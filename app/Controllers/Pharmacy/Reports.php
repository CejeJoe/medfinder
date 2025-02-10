<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\PharmacyDrugModel;
use App\Models\OrderModel;
use App\Models\PharmacyViewModel;
use App\Models\PharmacyModel;

class Reports extends BaseController
{
    protected $pharmacyDrugModel;
    protected $orderModel;
    protected $pharmacyViewModel;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->orderModel = new OrderModel();
        $this->pharmacyViewModel = new PharmacyViewModel();
        $this->pharmacyModel = new PharmacyModel();
    }

    public function index()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $pharmacy = $this->pharmacyModel->find($pharmacyId);

        $totalSales = $this->orderModel->getTotalSales($pharmacyId);
        $totalOrders = $this->orderModel->getTotalOrders($pharmacyId);
        $totalCompletedOrders = $this->orderModel->getTotalCompletedOrders($pharmacyId);
        $orderCompletionRate = ($totalOrders > 0) ? ($totalCompletedOrders / $totalOrders) * 100 : 0;
        $averageOrderValue = ($totalOrders > 0) ? $totalSales / $totalOrders : 0;

        $data = [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'orderCompletionRate' => $orderCompletionRate,
            'averageOrderValue' => $averageOrderValue,
            'topSellingDrugs' => $this->orderModel->getTopSellingDrugs($pharmacyId, 5),
            'lowStockDrugs' => $this->pharmacyDrugModel->getLowStockDrugs($pharmacyId),
            'monthlySales' => $this->orderModel->getMonthlySales($pharmacyId),
            'revenueByPharmacy' => $this->orderModel->getRevenueByPharmacy(),
            'premium_listing' => $pharmacy['premium_listing'],
            'dailyViews' => $this->pharmacyViewModel->getDailyViews($pharmacyId, date('Y-m-d')),
            'totalViews' => $this->pharmacyViewModel->getTotalViews($pharmacyId),
        ];

        return view('pharmacy_owner/reports/index', $data);
    }
}