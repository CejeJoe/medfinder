<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'pharmacy_drug_id', 'quantity'];

    public function getUserCartItems($userId)
    {
        return $this->select('cart_items.*, pharmacy_drugs.price, drugs.name as drug_name')
                    ->join('pharmacy_drugs', 'pharmacy_drugs.id = cart_items.pharmacy_drug_id')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->where('cart_items.user_id', $userId)
                    ->findAll();
    }
}
