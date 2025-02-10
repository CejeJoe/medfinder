<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\PharmacyModel;
use App\Models\SubscriptionPlanModel;

class Subscription extends BaseController
{
    protected $pharmacyModel;
    protected $subscriptionPlanModel;

    public function __construct()
    {
        $this->pharmacyModel = new PharmacyModel();
        $this->subscriptionPlanModel = new SubscriptionPlanModel();
    }

    public function index()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $pharmacy = $this->pharmacyModel->find($pharmacyId);

        $data = [
            'current_subscription' => $this->pharmacyModel->getSubscriptionDetails($pharmacyId),
            'available_plans' => $this->subscriptionPlanModel->getActivePlans(),
            'premium_listing' => [
                'status' => $pharmacy['premium_listing'],
                'expiry_date' => $pharmacy['premium_expiry']
            ]
        ];

        return view('pharmacy_owner/subscription/index', $data);
    }

    public function upgrade()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $planId = $this->request->getPost('plan_id');

        $plan = $this->subscriptionPlanModel->find($planId);

        if ($plan) {
            $expiryDate = date('Y-m-d H:i:s', strtotime('+' . $plan['duration'] . ' days'));
            $this->pharmacyModel->upgradeSubscription($pharmacyId, $planId, $plan['name'], $expiryDate);

            return $this->response->setJSON(['success' => true, 'message' => 'Subscription upgraded successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid plan selected']);
    }

    public function togglePremium()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $result = $this->pharmacyModel->togglePremiumListing($pharmacyId);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Premium listing status updated']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Error updating premium listing status']);
    }
}

