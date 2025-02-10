<?php

namespace App\Controllers;

use App\Models\DrugModel;
use App\Models\PharmacyModel;
use App\Models\TestimonialModel;
use App\Models\BlogPostModel;
use App\Models\RegionModel;
use App\Models\UserDrugRecommendationModel;

class Home extends BaseController
{
    public function index()
    {
        $drugModel = new DrugModel();
        $pharmacyModel = new PharmacyModel();
        $testimonialModel = new TestimonialModel();
        $blogPostModel = new BlogPostModel();
        $regionModel = new RegionModel();
        $userDrugRecommendationModel = new UserDrugRecommendationModel();

        $data['featuredDrugs'] = $drugModel->where('is_featured', true)->findAll(4);
        $data['featuredPharmacies'] = $pharmacyModel->where('is_featured', true)->findAll(4);
        $data['testimonials'] = $testimonialModel->getTestimonialsWithUserInfo(6); // Fetch 6 testimonials for 2 carousel slides
        $data['blogPosts'] = $blogPostModel->findAll(3);
        $data['regions'] = $regionModel->findAll();

        // Fetch personalized recommendations if user is logged in
        if (session()->get('logged_in')) {
            $userId = session()->get('user_id');
            $data['recommendedDrugs'] = $userDrugRecommendationModel->getRecommendedDrugs($userId, 4);
        }

        return view('home', $data);
    }
}

