<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'pharmacy_id', 'total_amount', 'delivery_fee', 'payment_method', 'delivery_option', 'status', 'delivery_address', 'delivery_type', 'created_at', 'updated_at', 'estimated_delivery_time', 'delivery_latitude', 'delivery_longitude'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|numeric',
        'pharmacy_id' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'delivery_address' => 'required',
        'status' => 'required',
        'delivery_fee' => 'required|numeric',
        'payment_method' => 'required'
    ];

    public function getOrdersWithItems($userId)
    {
        return $this->select('orders.*, pharmacies.name as pharmacy_name')
                    ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
                    ->where('orders.user_id', $userId)
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll();
    }

    public function createOrder($orderData)
    {
        return $this->insert($orderData);
    }

    // Don't change
    public function getPharmacyOrders($pharmacyId)
    {
        return $this->where('pharmacy_id', $pharmacyId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function filterOrders($filters)
    {
        $builder = $this->builder();

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        if (!empty($filters['start_date'])) {
            $builder->where('created_at >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $builder->where('created_at <=', $filters['end_date']);
        }

        return $builder->get()->getResultArray();
    }

    public function getPharmacyOrder($pharmacyId, $orderId)
    {
        $order = $this->select('orders.*, pharmacies.name as pharmacy_name')
                      ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
                      ->where('orders.id', $orderId)
                      ->where('orders.pharmacy_id', $pharmacyId)
                      ->first();

        if ($order) {
            $orderItemModel = new OrderItemModel();
            $order['items'] = $orderItemModel->getOrderItems($orderId);
        }

        return $order;
    }

    public function updateOrderStatus($orderId, $status)
    {
        return $this->update($orderId, ['status' => $status]);
    }

    public function getSalesByPharmacy()
    {
        $result = $this->select('pharmacies.name AS pharmacy_name, SUM(orders.total_amount) AS total_sales, COUNT(orders.id) AS total_orders')
            ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
            ->groupBy('pharmacies.id')
            ->findAll();

        // Calculate average order value
        foreach ($result as &$row) {
            $row['average_order_value'] = $row['total_orders'] > 0 ? $row['total_sales'] / $row['total_orders'] : 0;
        }

        return $result;
    }

    public function getUserOrders($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getOrderWithItems($orderId, $userId = null)
    {
        $builder = $this->select('orders.*, users.username, pharmacies.name as pharmacy_name')
            ->join('users', 'users.id = orders.user_id')
            ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
            ->where('orders.id', $orderId);

        if ($userId !== null) {
            $builder->where('orders.user_id', $userId);
        }

        $order = $builder->first();

        if ($order) {
            $order['items'] = $this->db->table('order_items')
                ->select('order_items.*, drugs.name as drug_name')
                ->join('drugs', 'drugs.id = order_items.pharmacy_drug_id')
                ->where('order_id', $orderId)
                ->get()->getResultArray();
        }

        return $order;
    }

    public function getSalesByMonth()
    {
        try {
            return $this->select('MONTH(created_at) as month, COUNT(*) as order_count, SUM(total_amount) as total_sales')
                        ->where('status', 'delivered')
                        ->where('YEAR(created_at)', date('Y'))
                        ->groupBy('MONTH(created_at)')
                        ->orderBy('MONTH(created_at)', 'ASC')
                        ->get()
                        ->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error in OrderModel::getSalesByMonth: ' . $e->getMessage());
            return [];
        }
    }

    public function getTotalSales($pharmacyId = null)
    {
        $builder = $this->where('status', 'delivered')->selectSum('total_amount');
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        return $builder->get()->getRow()->total_amount ?? 0;
    }

    public function getMonthlySales($pharmacyId = null)
    {
        $builder = $this->select('MONTH(created_at) as month, SUM(total_amount) as total')
                        ->where('status', 'delivered')
                        ->where('YEAR(created_at)', date('Y'));
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        return $builder->groupBy('MONTH(created_at)')
                       ->orderBy('MONTH(created_at)', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    public function getTopSellingDrugs($pharmacyId = null, $limit = 5)
    {
        $builder = $this->db->table('order_items')
                            ->select('drugs.name, SUM(order_items.quantity) as total_sales')
                            ->join('drugs', 'drugs.id = order_items.pharmacy_drug_id')
                            ->join('orders', 'orders.id = order_items.order_id')
                            ->where('orders.status', 'delivered');
        if ($pharmacyId) {
            $builder->where('orders.pharmacy_id', $pharmacyId);
        }
        return $builder->groupBy('drugs.id')
                       ->orderBy('total_sales', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->getResultArray();
    }

    public function getRevenueByPharmacy()
    {
        return $this->select('pharmacies.name, SUM(orders.total_amount) as total_sales, COUNT(*) as total_orders')
                    ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
                    ->where('orders.status', 'delivered')
                    ->groupBy('pharmacies.id')
                    ->orderBy('total_sales', 'DESC')
                    ->get()
                    ->getResultArray();
    }

    public function getOrderCompletionRate($pharmacyId = null)
    {
        $builder = $this;
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        $totalOrders = $builder->countAllResults();
        $completedOrders = $builder->where('status', 'delivered')->countAllResults();
        return $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
    }

    public function getAverageOrderValue($pharmacyId = null)
    {
        $builder = $this->select('AVG(total_amount) as avg_order_value')
                        ->where('status', 'delivered');
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        $result = $builder->get()->getRow();
        return $result ? $result->avg_order_value : 0;
    }

    public function getReportData()
    {
        return $this->select('orders.id, orders.created_at, pharmacies.name as pharmacy, orders.total_amount, orders.status')
                    ->join('pharmacies', 'pharmacies.id = orders.pharmacy_id')
                    ->orderBy('orders.created_at', 'DESC')
                    ->get()
                    ->getResultArray();
    }

    public function getTotalOrders($pharmacyId = null)
    {
        $builder = $this;
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        return $builder->countAllResults();
    }

    public function getTotalCompletedOrders($pharmacyId = null)
    {
        $builder = $this->where('status', 'delivered');
        if ($pharmacyId) {
            $builder->where('pharmacy_id', $pharmacyId);
        }
        return $builder->countAllResults();
    }

    public function updateStatusByJobId($jobId, $status)
    {
        return $this->where('delivery_job_id', $jobId)
                    ->set(['status' => $status])
                    ->update();
    }

    public function getTracking($orderId)
    {
        return $this->db->table('delivery_jobs')
                        ->where('order_id', $orderId)
                        ->get()
                        ->getRowArray();
    }

    public function getOrderItems($orderId)
    {
        return $this->db->table('order_items')
                        ->where('order_id', $orderId)
                        ->get()
                        ->getResultArray();
    }
    
}