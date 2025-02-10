<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class OrderManagement extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $filters = [
            'status' => $this->request->getGet('status'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date' => $this->request->getGet('end_date')
        ];
        $orders = $orderModel->filterOrders($filters);

        $data = [
            'title' => 'Order Management',
            'orders' => $orders
        ];

        return view('admin/orders/index', $data);
    }

    public function view($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderWithItems($id);

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        $data = [
            'title' => 'View Order',
            'order' => $order
        ];

        return view('admin/orders/view', $data);
    }
}

