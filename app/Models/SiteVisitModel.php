<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteVisitModel extends Model
{
    protected $table = 'site_visits';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'visit_date', 
        'visits', 
        'user_location', 
        'latitude', 
        'longitude', 
        'device_type', 
        'referral_source', 
        'time_spent', 
        'created_at', 
        'updated_at'
    ];
}
