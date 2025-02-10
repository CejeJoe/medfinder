<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PharmacyModel;
use App\Models\DrugModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $pharmacyModel;
    protected $drugModel;
    protected $orderModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->session = session();
        $this->pharmacyModel = new PharmacyModel();
        $this->drugModel = new DrugModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }
    private function checkAuth()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'super_admin') {
            return redirect()->to('/login');
        }
    }
    public function index()
    {
        $this->checkAuth();
        $data = [
            'total_pharmacies' => $this->pharmacyModel->countAll(),
            'total_drugs' => $this->drugModel->countAll(),
            'total_users' => $this->userModel->countAll(),
            'total_orders' => $this->orderModel->countAll(),
            'recent_orders' => $this->orderModel->orderBy('created_at', 'DESC')->findAll(5),
            // 'pending_pharmacies' => $this->pharmacyModel->where('status', 'pending')->countAllResults(),
            'pending_drugs' => $this->drugModel->where('status', 'pending')->countAllResults(),
        ];

        $orderModel = new \App\Models\OrderModel();
        $pharmacyDrugModel = new \App\Models\PharmacyDrugModel();
        $activityModel = new \App\Models\ActivityModel();

        $data['order_status_data'] = [
            'delivered' => $orderModel->where('status', 'delivered')->countAllResults(),
            'pending' => $orderModel->where('status', 'pending')->countAllResults(),
            'processing' => $orderModel->where('status', 'processing')->countAllResults(),
            'cancelled' => $orderModel->where('status', 'cancelled')->countAllResults(),
        ];

        $data['low_stock_drugs'] = $this->drugModel->getLowStockDrugs(10, 5);

        $data['recent_activities'] = $activityModel->getRecentActivities(5);

        $data['monthly_sales'] = $orderModel->getMonthlySales();
        $data['top_selling_drugs'] = $orderModel->getTopSellingDrugs(5);

        return view('admin/dashboard', $data);
    }
}

