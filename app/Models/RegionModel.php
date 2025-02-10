<?php

namespace App\Models;

use CodeIgniter\Model;

class RegionModel extends Model
{
    protected $table = 'regions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'country'];

    public function getRegionsWithPharmacies()
    {
        return $this->select('regions.*, COUNT(pharmacies.id) as pharmacy_count')
                    ->join('pharmacies', 'pharmacies.region_id = regions.id', 'left')
                    ->groupBy('regions.id')
                    ->find();
    }
}

