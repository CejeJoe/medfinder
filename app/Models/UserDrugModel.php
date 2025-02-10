<?php

namespace App\Models;

use CodeIgniter\Model;

class UserDrugModel extends Model
{
    protected $table = 'user_drugs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'name', 'dosage', 'frequency', 'notes'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
        'user_id'   => 'required|numeric',
        'name'      => 'required|min_length[3]|max_length[100]',
        'dosage'    => 'required',
        'frequency' => 'required',
    ];

    protected $validationMessages = [
        'user_id'   => ['required' => 'User ID is required'],
        'name'      => [
            'required' => 'Drug name is required',
            'min_length' => 'Drug name must be at least 3 characters long',
            'max_length' => 'Drug name cannot exceed 100 characters'
        ],
        'dosage'    => ['required' => 'Dosage is required'],
        'frequency' => ['required' => 'Frequency is required'],
    ];

    protected $skipValidation = false;

    public function getUserDrugs($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}

