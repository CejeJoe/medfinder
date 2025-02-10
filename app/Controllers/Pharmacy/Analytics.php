<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PharmacyDrugModel;

class Analytics extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $pharmacyDrugModel = new PharmacyDrugModel();
        $pharmacyId = session()->get('pharmacy_id');

        $data = [
            'title' => 'Pharmacy Analytics',
            'totalOrders' => $orderModel->where('pharmacy_id', $pharmacyId)->countAllResults(),
            'totalRevenue' => $orderModel->where('pharmacy_id', $pharmacyId)->selectSum('total_amount')->get()->getRow()->total_amount,
            'totalDrugs' => $pharmacyDrugModel->where('pharmacy_id', $pharmacyId)->countAllResults(),
            'recentOrders' => $orderModel->where('pharmacy_id', $pharmacyId)->orderBy('created_at', 'DESC')->limit(5)->find()
        ];

        return view('pharmacy_owner/analytics', $data);
    }
}

