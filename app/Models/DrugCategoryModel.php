<?php

namespace App\Models;

use CodeIgniter\Model;

class DrugCategoryModel extends Model
{
    protected $table = 'drug_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllCategories()
    {
        return $this->findAll();
    }

    public function addCategory($name, $description)
    {
        return $this->insert([
            'name' => $name,
            'description' => $description
        ]);
    }
}

