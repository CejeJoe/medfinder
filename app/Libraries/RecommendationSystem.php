<?php

namespace App\Libraries;

use Phpml\Classification\KNearestNeighbors;
use Phpml\Math\Distance\Euclidean;

class RecommendationSystem
{
    private $classifier;
    private $drugModel;

    public function __construct()
    {
        $this->classifier = new KNearestNeighbors(3, new Euclidean());
        $this->drugModel = new \App\Models\DrugModel();
    }

    public function trainModel($userDrugHistory)
    {
        $samples = [];
        $labels = [];

        foreach ($userDrugHistory as $history) {
            $samples[] = [$history['user_age'], $history['user_gender'] === 'male' ? 1 : 0];
            $labels[] = $history['drug_id'];
        }

        $this->classifier->train($samples, $labels);
    }

    public function getRecommendations($userAge, $userGender)
    {
        $sample = [$userAge, $userGender === 'male' ? 1 : 0];
        $predictedDrugIds = $this->classifier->predict($sample);

        return $this->drugModel->find($predictedDrugIds);
    }
}

