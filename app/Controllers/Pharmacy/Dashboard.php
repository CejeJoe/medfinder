<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\PharmacyModel;
use App\Models\DrugModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    protected $pharmacyModel;
    protected $drugModel;
    protected $orderModel;

    public function __construct()
    {
        $this->pharmacyModel = new PharmacyModel();
        $this->drugModel = new DrugModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $low_stock_drugs = $this->drugModel->getLowStockDrugs($pharmacyId);
        
        $data = [
            'total_drugs' => $this->drugModel->countPharmacyDrugs($pharmacyId),
            'total_orders' => $this->orderModel->where('pharmacy_id', $pharmacyId)->countAllResults(),
            'total_sales' => $this->orderModel->where('pharmacy_id', $pharmacyId)
                                            ->selectSum('total_amount')
                                            ->get()
                                            ->getRow()
                                            ->total_amount ?? 0,
            'recent_orders' => $this->orderModel->where('pharmacy_id', $pharmacyId)
                                              ->orderBy('created_at', 'DESC')
                                              ->limit(5)
                                              ->find(),
            'low_stock_drugs' => $low_stock_drugs,
            'low_stock_count' => count($low_stock_drugs),
            'top_selling_drugs' => $this->drugModel->getTopSellingDrugs($pharmacyId, 5),
        ];

        return view('pharmacy_owner/dashboard', $data);
    }
}

