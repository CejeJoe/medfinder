<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionPlanModel extends Model
{
    protected $table = 'subscription_plans';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description', 'price', 'duration', 'features', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'price' => 'required|numeric',
        'duration' => 'required|integer',
        'status' => 'required|in_list[active,inactive]'
    ];

    public function getActivePlans()
    {
        return $this->where('status', 'active')->findAll();
    }

    public function setFeatures($features)
    {
        if (is_string($features)) {
            // Convert newline-separated string to array
            $features = array_filter(explode("\n", $features), 'trim');
        }
        
        return json_encode($features);
    }

    public function getFeatures($planId)
    {
        $plan = $this->find($planId);
        if ($plan) {
            $features = json_decode($plan['features'], true);
            return is_array($features) ? $features : [];
        }
        return [];
    }
}

