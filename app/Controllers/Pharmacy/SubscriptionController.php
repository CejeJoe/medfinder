<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\SubscriptionPlanModel;
use App\Models\PharmacyModel;

class SubscriptionController extends BaseController
{
    protected $subscriptionPlanModel;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->subscriptionPlanModel = new SubscriptionPlanModel();
        $this->pharmacyModel = new PharmacyModel();
    }

    public function index()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $pharmacy = $this->pharmacyModel->find($pharmacyId);

        $data = [
            'currentPlan' => $this->pharmacyModel->getCurrentSubscription($pharmacyId),
            'availablePlans' => $this->subscriptionPlanModel->getActivePlans(),
            'pharmacy' => $pharmacy
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
            $this->pharmacyModel->updateSubscription($pharmacyId, $planId, $plan['name'], $expiryDate);

            return redirect()->to('/pharmacy/subscription')->with('success', 'Subscription upgraded successfully');
        }

        return redirect()->back()->with('error', 'Invalid plan selected');
    }

    public function cancel()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $this->pharmacyModel->cancelSubscription($pharmacyId);

        return redirect()->to('/pharmacy/subscription')->with('success', 'Subscription cancelled successfully');
    }
}

