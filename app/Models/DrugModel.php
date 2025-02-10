<?php

namespace App\Models;

use CodeIgniter\Model;

class DrugModel extends Model
{
    protected $table = 'drugs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'category', 'description', 'price', 'thumbnail_url', 'image_url', 'status',
        'is_featured', 'expiry_date', 'is_approved', 'dosage', 'form',
        'side_effects', 'contraindications', 'generic_name', 'prescription_required',
        'manufacturer', 'deleted_at', 'manufacturer_country', 'manufacturer_name', 'indications', 
        'pharmacology', 'dosage_administration', 'storage_conditions', 'shelf_life'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'category' => 'required|max_length[100]',
        'description' => 'required',
        'price' => 'required|numeric',
        'image_url' => 'required',
        'status' => 'required|in_list[active,inactive]',
        'is_featured' => 'required|in_list[0,1]',
        'is_approved' => 'required|in_list[0,1]',
        'prescription_required' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Drug name is required',
            'min_length' => 'Drug name must be at least 3 characters long',
            'max_length' => 'Drug name cannot exceed 255 characters'
        ],
        // Add more custom validation messages as needed
    ];
    protected $skipValidation = false;
    // You can add custom methods here as needed
    public function getFeaturedDrugs($limit = 4)
    {
        return $this->where('is_featured', true)
                    ->where('status', 'active')
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }
    public function getTopDrugs($limit = 5)
{
    return $this->where('is_featured', true)  // Only include featured drugs
                ->orderBy('created_at', 'DESC')  // Order by the most recent (or change to 'ASC' for oldest)
                ->limit($limit)
                ->find();
}

    // Count the total drugs available in a pharmacy
    public function countPharmacyDrugs($pharmacyId)
    {
        return $this->join('pharmacy_drugs', 'pharmacy_drugs.drug_id = drugs.id')
                    ->where('pharmacy_drugs.pharmacy_id', $pharmacyId)
                    ->countAllResults();
    }

    public function getLowStockDrugs($pharmacyId, $threshold = 10)
    {
        $lowStockDrugs = $this->select('drugs.*, pharmacy_drugs.stock, pharmacies.user_id')
                    ->join('pharmacy_drugs', 'pharmacy_drugs.drug_id = drugs.id', 'inner')
                    ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id', 'inner')
                    ->where([
                        'pharmacy_drugs.pharmacy_id' => $pharmacyId,
                        'drugs.status' => 'active'
                    ])
                    ->where('pharmacy_drugs.stock <', $threshold)
                    ->findAll();

        $notificationModel = new \App\Models\NotificationModel();

        // Get all drugs that are NOT in low stock to remove their notifications if they exist
        $normalStockDrugs = $this->select('drugs.*, pharmacy_drugs.stock, pharmacies.user_id')
                    ->join('pharmacy_drugs', 'pharmacy_drugs.drug_id = drugs.id', 'inner')
                    ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id', 'inner')
                    ->where([
                        'pharmacy_drugs.pharmacy_id' => $pharmacyId,
                        'drugs.status' => 'active'
                    ])
                    ->where('pharmacy_drugs.stock >=', $threshold)
                    ->findAll();

        // Remove notifications for drugs that are no longer low in stock
        foreach ($normalStockDrugs as $drug) {
            $notificationModel->where('user_id', $drug['user_id'])
                             ->where('type', 'inventory')
                             ->like('message', "Low stock alert: {$drug['name']}")
                             ->delete();
        }

        // Create notifications for current low stock items
        if (!empty($lowStockDrugs)) {
            foreach ($lowStockDrugs as $drug) {
                // Check if a similar notification already exists within the last 24 hours
                $existingNotification = $notificationModel->where([
                    'user_id' => $drug['user_id'],
                    'type' => 'inventory',
                    'message' => "Low stock alert: {$drug['name']} has only {$drug['stock']} units remaining"
                ])
                ->where('created_at >', date('Y-m-d H:i:s', strtotime('-24 hours')))
                ->first();

                // Only create notification if one doesn't exist
                if (!$existingNotification) {
                    $notificationModel->createNotification(
                        $drug['user_id'],
                        "Low stock alert: {$drug['name']} has only {$drug['stock']} units remaining",
                        'inventory'
                    );
                }
            }
        }

        return $lowStockDrugs;
    }

    public function getTopSellingDrugs($pharmacyId, $limit = 5)
    {
        return $this->db->table('orders')
                        ->select('orders.*, pharmacies.name as pharmacy_name, orders.total_amount')
                        ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
                        ->where('orders.pharmacy_id', $pharmacyId)
                        ->orderBy('orders.total_amount', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResult();
    }
    
    public function searchDrugs($keyword, $category = null)
    {
        $builder = $this->like('name', $keyword)
                        ->orLike('description', $keyword)
                        ->where('status', 'active')
                        ->where('is_approved', true);

        if ($category) {
            $builder->where('category', $category);
        }

        return $builder->findAll();
    }
    public function archiveDrug($id)
    {
        return $this->delete($id); // This will perform a soft delete
    }

    public function getArchivedDrugs()
    {
        return $this->onlyDeleted()->findAll();
    }
    public function saveImages($drugId, $imagePaths)
    {
        return $this->update($drugId, [
            'thumbnail_url' => $imagePaths['thumbnail'],
            'image_url' => $imagePaths['full_size']
        ]);
    }


    public function searchWithSuggestions($query)
    {
        // Exact matches
        $exactMatches = $this->like('name', $query)->orLike('generic_name', $query)->findAll();

        // Fuzzy matches (using soundex for phonetic similarity)
        $soundexQuery = soundex($query);
        $fuzzyMatches = $this->select('drugs.*, SOUNDEX(name) as soundex_name')
            ->where('SOUNDEX(name)', $soundexQuery)
            ->orWhere('SOUNDEX(generic_name)', $soundexQuery)
            ->findAll();

        // Remove exact matches from fuzzy matches to avoid duplicates
        $fuzzyMatches = array_filter($fuzzyMatches, function ($fuzzyMatch) use ($exactMatches) {
            return !in_array($fuzzyMatch, $exactMatches);
        });

        return [
            'exact_matches' => $exactMatches,
            'suggestions' => $fuzzyMatches
        ];
    }
    public function search($query)
    {
        return $this->like('name', $query)
                    ->orLike('generic_name', $query)
                    ->findAll(10);  // Limit to 10 results for autocomplete
    }

    public function getCategories()
    {
        return $this->distinct()->select('category')->findAll();
    }
    public function insertBatch(?array $set = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false): int
    {
        return $this->builder()->insertBatch($set, $escape, $batchSize);
    }

    public function updateDrug($drugData)
    {
        $existingDrug = $this->where('name', $drugData['name'])->first();

        if ($existingDrug) {
            if ($this->update($existingDrug['id'], $drugData)) {
                return true;
            } else {
                log_message('error', 'Failed to update drug: ' . json_encode($this->errors()));
                return false;
            }
        } else {
            log_message('error', 'Drug not found: ' . $drugData['name']);
            return false;
        }
    }

    public function insertDrug($drugData)
    {
        return $this->insert($drugData);
    }
}

