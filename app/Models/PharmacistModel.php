<?php

namespace App\Models;

use CodeIgniter\Model;

class PharmacistModel extends Model
{
    protected $table = 'pharmacists';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'pharmacy_id',
        'name',
        'license_number',
        'qualification',
        'specialization',
        'years_of_experience',
        'photo_url',
        'is_head_pharmacist',
        'working_hours',
        'contact_number',
        'email'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get all pharmacists for a pharmacy
    public function getPharmacyPharmacists($pharmacyId)
    {
        return $this->where('pharmacy_id', $pharmacyId)
                    ->orderBy('is_head_pharmacist', 'DESC')
                    ->orderBy('years_of_experience', 'DESC')
                    ->findAll();
    }

    // Get head pharmacist for a pharmacy
    public function getHeadPharmacist($pharmacyId)
    {
        return $this->where([
            'pharmacy_id' => $pharmacyId,
            'is_head_pharmacist' => 1
        ])->first();
    }

    // Check if license number exists
    public function isLicenseNumberUnique($licenseNumber, $excludeId = null)
    {
        $builder = $this->where('license_number', $licenseNumber);
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        return !$builder->countAllResults();
    }
}