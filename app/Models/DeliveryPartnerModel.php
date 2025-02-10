<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryPartnerModel extends Model
{
    protected $table = 'delivery_partners';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'name', 'email', 'vehicle_type', 'license_number', 'is_available'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPharmacyDeliveryPartners($pharmacyId)
    {
        return $this->where('pharmacy_id', $pharmacyId)->findAll();
    }

    public function getAvailableDeliveryPartners()
    {
        return $this->where('is_available', 1)
                    ->findAll();
    }

    public function getDriverByUserId($userId)
    {
        return $this->where('id', $userId)->first();
    }

    public function findByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}

