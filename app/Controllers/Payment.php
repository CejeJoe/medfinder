<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Payment extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function process($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        // In a real-world scenario, you'd integrate with a payment gateway here
        // For this example, we'll simulate a successful payment

        $paymentMethod = $this->request->getPost('payment_method');
        $paymentDetails = $this->request->getPost('payment_details');

        // Simulate payment processing
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            $this->orderModel->update($orderId, ['status' => 'paid']);
            return redirect()->to('order/confirmation/' . $orderId)->with('success', 'Payment successful');
        } else {
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }
}

