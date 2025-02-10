<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel; // Import the OrderItemModel
use App\Models\DeliveryJobModel;
use App\Models\UserModel; // Import the UserModel
use App\Models\DeliveryPartnerModel; // Import the DeliveryPartnerModel

class Orders extends BaseController
{
    protected $orderModel;
    protected $orderItemModel; // Declare OrderItemModel
    protected $deliveryJobModel;
    protected $userModel; // Declare UserModel
    protected $deliveryPartnerModel; // Declare DeliveryPartnerModel

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel(); // Initialize OrderItemModel
        $this->deliveryJobModel = new DeliveryJobModel();
        $this->userModel = new UserModel(); // Initialize UserModel
        $this->deliveryPartnerModel = new DeliveryPartnerModel(); // Initialize DeliveryPartnerModel
    }

    public function index()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $data['orders'] = $this->orderModel->getPharmacyOrders($pharmacyId);
        return view('pharmacy_owner/orders/index', $data);
    }

    public function view($id)
    {
        $pharmacyId = session()->get('pharmacy_id');
        
        // Fetch order details
        $data['order'] = $this->orderModel->getPharmacyOrder($pharmacyId, $id);
        
        // Fetch order items based on the order's ID
        $data['order_items'] = $this->orderItemModel->where('order_id', $id)->findAll();
        
        // Fetch user details based on the user_id in the order
        $data['user'] = $this->userModel->find($data['order']['user_id']);
        
        // Pass data to the view
        return view('pharmacy_owner/orders/view', $data);
    }

    public function updateStatus($id)
    {
        $pharmacyId = session()->get('pharmacy_id');
        $this->orderModel->updateOrderStatus($pharmacyId, $id, $this->request->getPost('status'));

        // Check if the order status is 'delivered'
        if ($this->request->getPost('status') == 'delivered') {
            // Fetch the delivery job associated with this order
            $deliveryJob = $this->deliveryJobModel->where('order_id', $id)->first();
            if ($deliveryJob) {
                // Update the delivery partner's availability
                $this->deliveryPartnerModel->update($deliveryJob['delivery_partner_id'], ['is_available' => 1]);
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function assignDelivery($orderId)
    {
        $deliveryPartnerModel = new \App\Models\DeliveryPartnerModel();
        
        if ($this->request->getMethod() === 'POST') {
            $deliveryPartnerId = $this->request->getPost('delivery_partner_id');
            $estimatedDeliveryTime = $this->request->getPost('estimated_delivery_time');

            // Fetch the order to get the user_id
            $order = $this->orderModel->find($orderId);
            $userId = $order['user_id'];

            // Create delivery job
            $deliveryJobData = [
                'order_id' => $orderId,
                'user_id' => $userId,
                'delivery_partner_id' => $deliveryPartnerId,
                'estimated_delivery_time' => $estimatedDeliveryTime,
                'status' => 'pending'
            ];

            if ($this->deliveryJobModel->insert($deliveryJobData)) {
                // Update order status to 'out_for_delivery'
                $this->orderModel->updateOrderStatus($orderId, 'dispatched');
                
                // Update delivery partner availability
                $deliveryPartnerModel->update($deliveryPartnerId, ['is_available' => 0]);

                return redirect()->to('/pharmacy/orders')->with('success', 'Delivery partner assigned successfully');
            }

            return redirect()->back()->with('error', 'Failed to assign delivery partner');
        }

        $data = [
            'order_id' => $orderId,
            'delivery_partners' => $deliveryPartnerModel->getAvailableDeliveryPartners()
        ];

        return view('pharmacy_owner/orders/assign_delivery', $data);
    }
}
