<?php

namespace App\Models;

use CodeIgniter\Model;

class UserDrugRecommendationModel extends Model
{
    protected $table = 'user_drug_recommendations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'drug_id', 'recommendation_score'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    public function getRecommendedDrugs($userId, $limit = 4)
    {
        return $this->select('drugs.*, user_drug_recommendations.recommendation_score')
                    ->join('drugs', 'drugs.id = user_drug_recommendations.drug_id')
                    ->where('user_drug_recommendations.user_id', $userId)
                    ->orderBy('user_drug_recommendations.recommendation_score', 'DESC')
                    ->limit($limit)
                    ->find();
    }
}

