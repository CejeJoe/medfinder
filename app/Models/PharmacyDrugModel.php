<?php

namespace App\Models;

use CodeIgniter\Model;

class PharmacyDrugModel extends Model
{
    protected $table = 'pharmacy_drugs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'pharmacy_id', 'drug_id', 'price', 'stock', 'featured',
        'prescription_required', 'drug_name', 'category', 'image_url',
        'pharmacy_name', 'address', 'latitude', 'longitude',
        'delivery_available', 'rating','is_out_of_stock', 'low_stock_threshold'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'pharmacy_id' => 'required|integer',
        'drug_id' => 'required|integer',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'featured' => 'required|in_list[0,1]',
        'prescription_required' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'pharmacy_id' => [
            'required' => 'Pharmacy ID is required',
            'integer' => 'Pharmacy ID must be an integer'
        ],
        'drug_id' => [
            'required' => 'Drug ID is required',
            'integer' => 'Drug ID must be an integer'
        ],
        // Add more custom validation messages as needed
    ];

    protected $skipValidation = false;

    public function getPharmacyInventory($pharmacyId)
    {
        return $this->select('
            pharmacy_drugs.*,
            drugs.name,
            drugs.generic_name,
            drugs.category as drug_category,
            drugs.description,
            drugs.image_url as drug_image
        ')
        ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
        ->where('pharmacy_drugs.pharmacy_id', $pharmacyId)
        ->findAll();
    }

    public function addDrugToInventory($pharmacyId, $data)
    {
        $data['pharmacy_id'] = $pharmacyId;
        return $this->insert($data);
    }



    public function getInventoryItem($pharmacyId, $id)
    {
        return $this->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category, drugs.image_url')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->where('pharmacy_drugs.pharmacy_id', $pharmacyId)
                    ->where('pharmacy_drugs.id', $id)
                    ->first();
    }

    public function updateInventoryItem($id, $data)
    {
        return $this->update($id, $data);
    }
    public function batchUpdateInventory($pharmacyId, $updates)
    {
        foreach ($updates as $update) {
            $this->update($update['id'], [
                'quantity' => $update['quantity'],
                'price' => $update['price'],
                'low_stock_threshold' => $update['low_stock_threshold']
            ]);
        }
    }
    public function getPharmaciesWithDrug($drugId)
    {
        return $this->select('pharmacy_drugs.*, pharmacies.name as pharmacy_name, pharmacies.address, pharmacies.latitude, pharmacies.longitude, pharmacies.delivery_available, pharmacies.rating')
                    ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->where('pharmacy_drugs.drug_id', $drugId)
                    ->where('pharmacy_drugs.stock >', 0)
                    ->findAll();
    }

    public function getPharmacyDrugDetails($pharmacyDrugId)
    {
        return $this->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category, drugs.image_url, pharmacies.name as pharmacy_name, pharmacies.address, pharmacies.delivery_available')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id')
                    ->where('pharmacy_drugs.id', $pharmacyDrugId)
                    ->first();
    }

    public function getFeaturedDrugs($limit = 10)
    {
        return $this->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category, drugs.image_url, pharmacies.name as pharmacy_name')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id')
                    ->where('pharmacy_drugs.featured', 1)
                    ->where('pharmacy_drugs.stock >', 0)
                    ->orderBy('pharmacy_drugs.price', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }
    public function updateGeneralAvailability($pharmacyId, $drugId, $availability)
    {
        return $this->where('pharmacy_id', $pharmacyId)
                    ->where('drug_id', $drugId)
                    ->set(['general_availability' => $availability])
                    ->update();
    }
    public function searchDrugs($keyword, $category = null, $minPrice = null, $maxPrice = null)
    {
        $builder = $this->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category, drugs.image_url, pharmacies.name as pharmacy_name, pharmacies.address, pharmacies.latitude, pharmacies.longitude, pharmacies.delivery_available, pharmacies.rating')
                        ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                        ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id')
                        ->where('pharmacy_drugs.stock >', 0)
                        ->groupStart()
                            ->like('drugs.name', $keyword)
                            ->orLike('drugs.description', $keyword)
                            ->orLike('pharmacies.name', $keyword)
                        ->groupEnd();

        if ($category) {
            $builder->where('drugs.category', $category);
        }

        if ($minPrice !== null) {
            $builder->where('pharmacy_drugs.price >=', $minPrice);
        }

        if ($maxPrice !== null) {
            $builder->where('pharmacy_drugs.price <=', $maxPrice);
        }

        return $builder->findAll();
    }

    public function updateStock($id, $quantity, $operation = 'subtract')
    {
        $pharmacyDrug = $this->find($id);
        if (!$pharmacyDrug) {
            return false;
        }

        $newStock = $operation === 'add' ? $pharmacyDrug['stock'] + $quantity : $pharmacyDrug['stock'] - $quantity;
        $newStock = max(0, $newStock); // Ensure stock doesn't go below 0

        $data = [
            'stock' => $newStock,
            'is_out_of_stock' => ($newStock == 0)
        ];

        return $this->update($id, $data);
    }
    public function updateStockByDrugName($pharmacyId, $drugName, $newStock)
    {
        return $this->where('pharmacy_id', $pharmacyId)
                    ->where('drug_name', $drugName)
                    ->set(['stock' => $newStock])
                    ->update();
    }
    public function getLowStockItems()
    {
        return $this->select('pharmacy_drugs.*, drugs.name as drug_name, pharmacies.name as pharmacy_name')
                ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id')
                ->where('pharmacy_drugs.stock <= pharmacy_drugs.reorder_level')
                ->findAll();
    }


    //New search advanced 
    public function advancedSearch($query, $category, $minPrice, $maxPrice, $region, $rating, $availability, $sort)
    {
        $builder = $this->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category, pharmacies.name as pharmacy_name, pharmacies.rating')
                        ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                        ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id');

        if ($query) {
            $builder->groupStart()
                    ->like('drugs.name', $query)
                    ->orLike('pharmacies.name', $query)
                    ->groupEnd();
        }

        if ($category) {
            $builder->where('drugs.category', $category);
        }

        if ($minPrice) {
            $builder->where('pharmacy_drugs.price >=', $minPrice);
        }

        if ($maxPrice) {
            $builder->where('pharmacy_drugs.price <=', $maxPrice);
        }

        if ($region) {
            $builder->where('pharmacies.region', $region);
        }

        if ($rating) {
            $builder->where('pharmacies.rating >=', $rating);
        }

        if ($availability) {
            $builder->where('pharmacy_drugs.general_availability', $availability);
        }

        switch ($sort) {
            case 'price_low':
                $builder->orderBy('pharmacy_drugs.price', 'ASC');
                break;
            case 'price_high':
                $builder->orderBy('pharmacy_drugs.price', 'DESC');
                break;
            case 'rating':
                $builder->orderBy('pharmacies.rating', 'DESC');
                break;
            default:
                $builder->orderBy('pharmacies.rating', 'DESC');
                break;
        }

        return $builder->findAll();
    }
    public function getPharmacyDrugs($pharmacyId)
    {
        return $this->select('pharmacy_drugs.*, drugs.name, drugs.generic_name, drugs.category')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->where('pharmacy_id', $pharmacyId)
                    ->findAll();
    }

    public function getUpdatedStocks($pharmacyId, $lastEventId)
    {
        return $this->select('pharmacy_drugs.id, drugs.name, pharmacy_drugs.stock')
                ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                ->where('pharmacy_drugs.pharmacy_id', $pharmacyId)
                ->where('pharmacy_drugs.id >', $lastEventId)
                ->findAll();
    }

    public function getLowStockDrugs($pharmacyId, $threshold = 10)
    {
        return $this->select('pharmacy_drugs.*, drugs.name as drug_name')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->where('pharmacy_drugs.pharmacy_id', $pharmacyId)
                    ->where('pharmacy_drugs.stock <=', $threshold)
                    ->findAll();
    }
}

