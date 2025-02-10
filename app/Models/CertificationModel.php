<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificationModel extends Model
{
    protected $table = 'certifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'pharmacy_id',
        'name',
        'issuing_authority',
        'certificate_number',
        'issue_date',
        'expiry_date',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get valid certifications for a pharmacy
    public function getValidCertifications($pharmacyId)
    {
        return $this->where([
            'pharmacy_id' => $pharmacyId,
            'status' => 'active'
        ])->where('expiry_date >', date('Y-m-d'))
        ->findAll();
    }

    // Check if certification is expired
    public function updateCertificationStatus()
    {
        $this->where('expiry_date <', date('Y-m-d'))
             ->set(['status' => 'expired'])
             ->update();
    }
}