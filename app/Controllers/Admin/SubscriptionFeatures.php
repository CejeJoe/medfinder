<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubscriptionPlanModel;
use App\Models\PharmacyModel;

class SubscriptionFeatureController extends BaseController
{
    protected $subscriptionPlanModel;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->subscriptionPlanModel = new SubscriptionPlanModel();
        $this->pharmacyModel = new PharmacyModel();
    }

    public function checkFeatureAccess($pharmacyId, $feature)
    {
        $pharmacy = $this->pharmacyModel->find($pharmacyId);
        if (!$pharmacy || !$pharmacy['subscription_plan_id']) {
            return false;
        }

        $plan = $this->subscriptionPlanModel->find($pharmacy['subscription_plan_id']);
        if (!$plan) {
            return false;
        }

        $features = json_decode($plan['features'], true);
        return in_array($feature, $features);
    }

    public function getInventoryLimit($pharmacyId)
    {
        $pharmacy = $this->pharmacyModel->find($pharmacyId);
        if (!$pharmacy || !$pharmacy['subscription_plan_id']) {
            return 50; // Basic plan limit
        }

        $plan = $this->subscriptionPlanModel->find($pharmacy['subscription_plan_id']);
        switch ($plan['name']) {
            case 'Premium':
                return PHP_INT_MAX; // Unlimited
            case 'Standard':
                return PHP_INT_MAX; // Unlimited
            default:
                return 50; // Basic plan limit
        }
    }

    public function setupDefaultPlans()
    {
        $plans = [
            [
                'name' => 'Basic',
                'description' => 'Perfect for small pharmacies starting out',
                'price' => 100000,
                'duration' => 30,
                'features' => json_encode([
                    'Basic profile visibility',
                    'Simple order tracking',
                    'Up to 50 inventory items',
                    'Basic SEO optimization'
                ]),
                'status' => 'active'
            ],
            [
                'name' => 'Standard',
                'description' => 'Great for growing pharmacies',
                'price' => 250000,
                'duration' => 30,
                'features' => json_encode([
                    'Unlimited inventory items',
                    'Delivery partner integration',
                    'Sales and order reports',
                    'Advanced SEO optimization',
                    'Category management'
                ]),
                'status' => 'active'
            ],
            [
                'name' => 'Premium',
                'description' => 'Full features for established pharmacies',
                'price' => 500000,
                'duration' => 30,
                'features' => json_encode([
                    'API integration',
                    'Automated stock management',
                    'Batch inventory updates',
                    'Advanced analytics',
                    'Featured pharmacy placement',
                    'Custom branding',
                    'Priority support'
                ]),
                'status' => 'active'
            ]
        ];

        foreach ($plans as $plan) {
            $this->subscriptionPlanModel->insert($plan);
        }
    }
}

