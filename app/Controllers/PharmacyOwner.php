<?php

namespace App\Controllers;

use App\Models\PharmacyModel;
use App\Models\PharmacyDrugModel;
use App\Models\DrugModel;
use App\Models\SubscriptionPlanModel;

class PharmacyOwner extends BaseController
{
    protected $session;
    protected $pharmacyModel;
    protected $pharmacyDrugModel;
    protected $drugModel;
    protected $subscriptionPlanModel;

    public function __construct()
    {
        $this->session = session();
        $this->pharmacyModel = new PharmacyModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->drugModel = new DrugModel();
        $this->subscriptionPlanModel = new SubscriptionPlanModel();
    }

    private function checkAuth()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'pharmacy_admin') {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        // Fetch low stock drugs for the specific pharmacy
        $lowStockDrugs = $this->pharmacyDrugModel
            ->select('pharmacy_drugs.*, drugs.name as name')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->where('pharmacy_drugs.pharmacy_id', $pharmacy['id'])
            ->where('pharmacy_drugs.stock <', 10)
            ->findAll();

        if (empty($lowStockDrugs)) {    
            // Handle the case where there are no low stock drugs
            // Example: Show a message to the user
            $data['lowStockCount'] = 0;
            $data['lowStockDrugs'] = [];
        } else {
            $data['lowStockCount'] = count($lowStockDrugs);
            $data['lowStockDrugs'] = $lowStockDrugs;
        }

        $data = [
            'pharmacy' => $pharmacy,
            'totalDrugs' => $this->pharmacyDrugModel->where('pharmacy_id', $pharmacy['id'])->countAllResults(),
            'lowStockCount' => count($lowStockDrugs),
            'lowStockDrugs' => $lowStockDrugs,
            'recentOrders' => [] // You'll need to implement this based on your order model
        ];

        return view('pharmacy_owner/dashboard', $data);
    }

    public function profile()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        if ($this->request->getMethod() === 'post') {
            $this->pharmacyModel->update($pharmacy['id'], [
                'name' => $this->request->getPost('name'),
                'address' => $this->request->getPost('address'),
                'contact_number' => $this->request->getPost('contact_number'),
                'delivery_available' => $this->request->getPost('delivery_available') ? 1 : 0,
                'delivery_terms' => $this->request->getPost('delivery_terms'),
            ]);
            return redirect()->to('/pharmacy_owner/profile')->with('success', 'Profile updated successfully');
        }

        return view('pharmacy_owner/profile', ['pharmacy' => $pharmacy]);
    }

    public function inventory()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        $inventory = $this->pharmacyDrugModel
            ->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->where('pharmacy_drugs.pharmacy_id', $pharmacy['id'])
            ->findAll();

        return view('pharmacy_owner/inventory', ['inventory' => $inventory]);
    }

    public function updateInventory($id)
    {
        $this->checkAuth();
        
        if ($this->request->getMethod() === 'post') {
            $this->pharmacyDrugModel->update($id, [
                'price' => $this->request->getPost('price'),
                'stock' => $this->request->getPost('stock'),
                'featured' => $this->request->getPost('featured') ? 1 : 0,
            ]);
            return redirect()->to('/pharmacy/inventory')->with('success', 'Inventory updated successfully');
        }

        $inventoryItem = $this->pharmacyDrugModel
            ->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->find($id);

        return view('pharmacy_owner/update_inventory', ['item' => $inventoryItem]);
    }

    public function subscription()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        $data = [
            'pharmacy' => $pharmacy,
            'subscription' => $this->pharmacyModel->getSubscriptionDetails($pharmacy['id']),
            'plans' => $this->subscriptionPlanModel->getActivePlans()
        ];

        return view('pharmacy_owner/subscription', $data);
    }

    public function upgradePlan()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        $planId = $this->request->getPost('plan_id');
        $plan = $this->subscriptionPlanModel->find($planId);

        if ($plan) {
            // Here you would typically integrate with a payment gateway
            // For demonstration, we'll just update the subscription
            $expiryDate = date('Y-m-d H:i:s', strtotime('+' . $plan['duration'] . ' days'));
            $this->pharmacyModel->update($pharmacy['id'], [
                'subscription_status' => 'active',
                'subscription_plan' => $plan['name'],
                'subscription_expiry' => $expiryDate
            ]);

            return redirect()->to('/pharmacy_owner/subscription')->with('success', 'Subscription upgraded successfully');
        }

        return redirect()->back()->with('error', 'Invalid plan selected');
    }

    public function togglePremiumListing()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        $currentPremium = $this->pharmacyModel->hasPremiumListing($pharmacy['id']);
        $newPremiumStatus = !$currentPremium;

        $this->pharmacyModel->update($pharmacy['id'], [
            'premium_listing' => $newPremiumStatus,
            'premium_expiry' => $newPremiumStatus ? date('Y-m-d H:i:s', strtotime('+30 days')) : null
        ]);

        return redirect()->back()->with('success', 'Premium listing status updated');
    }
}

