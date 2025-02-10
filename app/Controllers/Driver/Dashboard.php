<?php

namespace App\Controllers\Driver;

use App\Controllers\BaseController;
use App\Models\DeliveryJobModel;
use App\Models\UserModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    protected $deliveryJobModel;
    protected $userModel;
    protected $orderModel;

    public function __construct()
    {
        $this->deliveryJobModel = new DeliveryJobModel();
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $driver = $this->userModel->find($userId);

        if (!$driver) {
            return redirect()->to('/login')->with('error', 'Driver not found');
        }

        $assignedOrders = $this->deliveryJobModel->getAssignedOrders($userId);
        $today = date('Y-m-d');

        $todayDeliveries = $this->deliveryJobModel
            ->select('delivery_jobs.*, orders.delivery_address, users.username as customer_name')
            ->join('orders', 'orders.id = delivery_jobs.order_id')
            ->join('users', 'users.id = orders.user_id')
            ->where('delivery_jobs.user_id', $userId)
            ->where('DATE(delivery_jobs.estimated_delivery_time)', $today)
            ->findAll();

        // Fetch customer names
        foreach ($todayDeliveries as &$delivery) {
            $user = $this->userModel->find($delivery['user_id']);
            $delivery['customer_name'] = $user['username'];
        }

        // Calculate earnings and completed orders
        $earnings = $this->deliveryJobModel
            ->selectSum('orders.total_amount')
            ->join('orders', 'orders.id = delivery_jobs.order_id')
            ->where('delivery_jobs.user_id', $userId)
            ->where('delivery_jobs.status', 'delivered')
            ->first()['total_amount'];

        $completedOrders = $this->deliveryJobModel
            ->where('user_id', $userId)
            ->where('status', 'delivered')
            ->countAllResults();

        $data = [
            'title' => 'Driver Dashboard',
            'driver' => $driver,
            'assignedOrders' => $assignedOrders,
            'todayDeliveries' => $todayDeliveries,
            'earnings' => $earnings,
            'completedOrders' => $completedOrders
        ];

        return view('driver/dashboard', $data);
    }

    public function updateDeliveryStatus()
    {
        if ($this->request->isAJAX()) {
            $jobId = $this->request->getPost('job_id');
            $orderId = $this->request->getPost('order_id');
            $status = $this->request->getPost('status');

            $success = $this->deliveryJobModel->updateStatus($jobId, $status);

            if ($success) {
                $this->orderModel->update($orderId, ['status' => $status]);
                return $this->response->setJSON(['success' => true, 'message' => 'Delivery status updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update delivery status']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    public function updateLocation()
    {
        if ($this->request->isAJAX()) {
            $userId = session()->get('user_id');
            $latitude = $this->request->getPost('latitude');
            $longitude = $this->request->getPost('longitude');

            $success = $this->deliveryJobModel->updateDriverLocation($userId, $latitude, $longitude);

            if ($success) {
                return $this->response->setJSON(['success' => true, 'message' => 'Location updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update location']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    public function trackDelivery($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->to('/driver/dashboard')->with('error', 'Order not found');
        }

        $customer = $this->userModel->find($order['user_id']);

        $data = [
            'title' => 'Track Delivery',
            'order' => $order,
            'customer' => $customer
        ];

        return view('driver/track_delivery', $data);
    }
}

