<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryJobModel extends Model
{
    protected $table = 'delivery_jobs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'user_id', 'status', 'estimated_delivery_time', 'latitude', 'longitude'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function assignDelivery($orderId, $userId, $estimatedDeliveryTime)
    {
        return $this->insert([
            'order_id' => $orderId,
            'user_id' => $userId,
            'status' => 'assigned',
            'estimated_delivery_time' => $estimatedDeliveryTime
        ]);
    }

    public function getAvailablePartners()
    {
        $db = \Config\Database::connect();
        return $db->table('delivery_partners')
                  ->where('is_available', true)
                  ->get()
                  ->getResultArray();
    }

    public function getAssignedOrders($userId)
    {
        return $this->select('delivery_jobs.*, orders.delivery_address, orders.total_amount, orders.delivery_latitude, orders.delivery_longitude')
                    ->join('orders', 'orders.id = delivery_jobs.order_id')
                    ->where('delivery_jobs.user_id', $userId)
                    ->where('delivery_jobs.status !=', 'delivered')
                    ->findAll();
    }

    public function updateStatus($jobId, $status)
    {
        return $this->update($jobId, ['status' => $status]);
    }

    public function updateDriverLocation($userId, $latitude, $longitude)
    {
        return $this->where('user_id', $userId)
                    ->set(['latitude' => $latitude, 'longitude' => $longitude])
                    ->update();
    }
}

