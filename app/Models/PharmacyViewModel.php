<?php

namespace App\Models;

use CodeIgniter\Model;

class PharmacyViewModel extends Model
{
    protected $table = 'pharmacy_views';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pharmacy_id', 'pharmacy_name', 'created_at', 'updated_at', 'user_agent', 'ip_address', 'view_date'];

    public function getDailyViews($pharmacyId = null)
    {
        $builder = $this->where('view_date', date('Y-m-d'));
        
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        
        $result = $builder->countAllResults();
        return $result;
    }

    public function getTotalViews($pharmacyId = null)
    {
        $builder = $this;
        
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        
        $result = $builder->countAllResults();
        return $result;
    }
}
