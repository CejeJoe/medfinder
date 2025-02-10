<?php

namespace App\Models;

use CodeIgniter\Model;

class PharmacyModel extends Model
{
    protected $table = 'pharmacies';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'name', 'address', 'contact_number', 'delivery_available',
        'delivery_terms', 'subscription_status', 'logo_url', 'subscription_plan',
        'subscription_expiry', 'premium_listing', 'premium_expiry', 'rating',
        'location', 'latitude', 'longitude', 'region_id', 'is_featured',
        'is_active', 'subscription_plan_id', 'operating_hours'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // New method to check if a pharmacy has an active premium listing
    public function hasPremiumListing($pharmacyId)
    {
        $pharmacy = $this->find($pharmacyId);
        return $pharmacy['premium_listing'] && strtotime($pharmacy['premium_expiry']) > time();
    }

    // New method to get the subscription details
    public function getSubscriptionDetails($pharmacyId)
    {
        $pharmacy = $this->find($pharmacyId);
        
        return [
            'status' => $pharmacy['subscription_status'],
            'plan' => $pharmacy['subscription_plan'],
            'expiry' => $pharmacy['subscription_expiry'],
        ];
    }

    public function getFeaturedPharmacies($limit = 4)
    {
        return $this->where('is_featured', true)
                    ->where('is_active', true)
                    ->orderBy('rating', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    public function getTopPharmacies($limit = 5)
    {
        return $this->where('rating >', 0)  // Only include pharmacies with at least one review
                    ->orderBy('rating', 'DESC') // Order by rating in descending order
                    ->limit($limit)  // Limit the number of results (default to 5)
                    ->find();
    }
    public function getPharmacyByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function updateProfile($pharmacyId, $data)
    {
        return $this->update($pharmacyId, $data);
    }

    public function upgradeSubscription($pharmacyId, $planId, $planName, $expiryDate)
    {
        return $this->update($pharmacyId, [
            'subscription_status' => 'active',
            'subscription_plan' => $planName,
            'subscription_expiry' => $expiryDate
        ]);
    }

    public function togglePremiumListing($pharmacyId)
    {
        $pharmacy = $this->find($pharmacyId);
        $newStatus = !$pharmacy['premium_listing'];
        $expiryDate = $newStatus ? date('Y-m-d H:i:s', strtotime('+30 days')) : null;

        return $this->update($pharmacyId, [
            'premium_listing' => $newStatus,
            'premium_expiry' => $expiryDate
        ]);
    }
    public function searchPharmacies($keyword, $region_id = null)
    {
        $builder = $this->like('name', $keyword)
                        ->orLike('address', $keyword)
                        ->where('is_active', true);

        if ($region_id) {
            $builder->where('region_id', $region_id);
        }

        return $builder->findAll();
    }
    public function getNearbyPharmacies($latitude, $longitude, $radius, $excludePharmacyId = null, $limit = 10)
    {
        $distance = "(6371 * acos(cos(radians(?)) 
                     * cos(radians(latitude)) 
                     * cos(radians(longitude) - radians(?)) 
                     + sin(radians(?)) 
                     * sin(radians(latitude))))";
    
        $sql = "SELECT *, $distance AS distance 
                FROM {$this->table} 
                WHERE is_active = 1 ";
        
        $params = [$latitude, $longitude, $latitude];
        
        if ($excludePharmacyId !== null) {
            $sql .= "AND id != ? ";
            $params[] = $excludePharmacyId;
        }
        
        $sql .= "HAVING distance <= ? 
                 ORDER BY distance 
                 LIMIT ?";
        
        $params[] = $radius;
        $params[] = $limit;
    
        return $this->query($sql, $params)->getResultArray();
    }
    // Subscription
    public function getCurrentSubscription($pharmacyId)
    {
        $pharmacy = $this->find($pharmacyId);
        if ($pharmacy && $pharmacy['subscription_plan_id']) {
            $subscriptionPlanModel = new SubscriptionPlanModel();
            $plan = $subscriptionPlanModel->find($pharmacy['subscription_plan_id']);
            return [
                'name' => $plan['name'],
                'expiry_date' => $pharmacy['subscription_expiry']
            ];
        }
        return null;
    }
    public function updateSubscription($pharmacyId, $planId, $planName, $expiryDate)
    {
        return $this->update($pharmacyId, [
            'subscription_plan_id' => $planId,
            'subscription_expiry' => $expiryDate
        ]);
    }

    public function cancelSubscription($pharmacyId)
    {
        return $this->update($pharmacyId, [
            'subscription_plan_id' => null,
            'subscription_expiry' => null
        ]);
    }
}

