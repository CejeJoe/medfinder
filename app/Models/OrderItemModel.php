<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['order_id', 'pharmacy_drug_id', 'quantity', 'price'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'order_id' => 'required|numeric',
        'drug_id' => 'required|numeric',
        'quantity' => 'required|numeric',
        'price' => 'required|numeric'
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'Order ID is required',
            'numeric' => 'Order ID must be a number'
        ],
        // Add more custom validation messages as needed
    ];

    protected $skipValidation = false;

    public function getOrderItems($orderId)
    {
        return $this->db->table('order_items')
                        ->select('order_items.*, drugs.name as drug_name')
                        ->join('drugs', 'drugs.id = order_items.pharmacy_drug_id')
                        ->where('order_id', $orderId)
                        ->get()
                        ->getResultArray();
    }
}

