<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'pharmacy_id',
        'name',
        'description',
        'icon',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get active services for a pharmacy
    public function getPharmacyServices($pharmacyId)
    {
        return $this->where([
            'pharmacy_id' => $pharmacyId,
            'is_active' => 1
        ])->findAll();
    }
}