<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'user_reviews';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'pharmacy_id', 'rating', 'comment'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
        'user_id'     => 'required|integer',
        'pharmacy_id' => 'required|integer',
        'rating'      => 'required|integer',
        'comment'     => 'required|min_length[10]|max_length[500]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be an integer'
        ],
        'pharmacy_id' => [
            'required' => 'Pharmacy ID is required',
            'integer' => 'Pharmacy ID must be an integer'
        ],
        'rating' => [
            'required' => 'Rating is required',
            'integer' => 'Rating must be an integer',
            'between' => 'Rating must be between 1 and 5'
        ],
        'comment' => [
            'required' => 'Comment is required',
            'min_length' => 'Comment must be at least 10 characters long',
            'max_length' => 'Comment cannot exceed 500 characters'
        ]
    ];

    protected $skipValidation = false;

    public function getPharmacyReviews($pharmacyId, $limit = 10, $offset = 0)
    {
        return $this->select('user_reviews.*, users.username')
                    ->join('users', 'users.id = user_reviews.user_id')
                    ->where('pharmacy_id', $pharmacyId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    public function getAverageRating($pharmacyId)
    {
        $result = $this->selectAvg('rating')
                       ->where('pharmacy_id', $pharmacyId)
                       ->first();
        return round($result['rating'] ?? 0, 1);
    }
}

