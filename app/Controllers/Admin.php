<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('logged_in')|| session()->get('role') !== 'admin') {
            return redirect()->to('/login');  // Redirect to login if not logged in
        }
    }

    public function index()
    {
        $this->checkAuth();

        $userModel = new \App\Models\UserModel();
        $pharmacyModel = new \App\Models\PharmacyModel();
        $orderModel = new \App\Models\OrderModel();

        $data = [
            'totalUsers' => $userModel->countAll(),
            'totalPharmacies' => $pharmacyModel->countAll(),
            'totalOrders' => $orderModel->countAll(),
            'recentOrders' => $orderModel->orderBy('created_at', 'DESC')->findAll(10)
        ];

        return view('admin/dashboard', $data);
    }

    public function manageUsers()
    {
        $this->checkAuth();

        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->findAll();

        return view('admin/manage_users', $data);
    }

    public function manageDrugs()
    {
        $this->checkAuth();

        $drugModel = new \App\Models\DrugModel();
        $data['drugs'] = $drugModel->findAll();

        return view('admin/manage_drugs', $data);
    }

    public function analytics()
    {
        $this->checkAuth();

        // Implement analytics logic here
        return view('admin/analytics');
    }
    public function settings()
    {
        $this->checkAuth();

        $db = \Config\Database::connect();

        return view('admin/settings', ['db' => $db]);
    }
    public function lowStock()
    {
        $pharmacyDrugModel = new \App\Models\PharmacyDrugModel();
        $data['low_stock_items'] = $pharmacyDrugModel->getLowStockItems();
        return view('admin/inventory/low_stock', $data);
    }

    public function recentActivities()
    {
        $activityModel = new \App\Models\ActivityModel();
        $data['activities'] = $activityModel->getRecentActivities(20); // Get 20 most recent activities
        return view('admin/activities', $data);
    }
}

