<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'content', 'rating'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    public function getTestimonialsWithUserInfo($limit = 3)
    {
        return $this->select('testimonials.*, testimonials.rating, users.username as user_name, users.profile_image as user_image')
                    ->join('users', 'users.id = testimonials.user_id')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }
}

