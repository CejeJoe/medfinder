<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'pharmacy_drug_id', 'quantity'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserCartItems($userId)
    {
        return $this->select('cart_items.*, pharmacy_drugs.price, drugs.name as drug_name, drugs.image_url, pharmacy_drugs.pharmacy_id, pharmacy_drugs.drug_id')
                    ->join('pharmacy_drugs', 'pharmacy_drugs.id = cart_items.pharmacy_drug_id')
                    ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
                    ->where('cart_items.user_id', $userId)
                    ->findAll();
    }

    public function addToCart($userId, $pharmacyDrugId, $quantity, $price)
    {
        try {
            $existingItem = $this->where('user_id', $userId)
                                ->where('pharmacy_drug_id', $pharmacyDrugId)
                                ->first();

            if ($existingItem) {
                $updated = $this->update($existingItem['id'], [
                    'quantity' => $existingItem['quantity'] + $quantity,
                ]);
                
                if (!$updated) {
                    log_message('error', 'Failed to update cart item: ' . json_encode($this->errors()));
                    return false;
                }
            } else {
                $inserted = $this->insert([
                    'user_id' => $userId,
                    'pharmacy_drug_id' => $pharmacyDrugId,
                    'quantity' => $quantity,
                ]);
                
                if (!$inserted) {
                    log_message('error', 'Failed to insert cart item: ' . json_encode($this->errors()));
                    return false;
                }
            }
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Cart operation failed: ' . $e->getMessage());
            return false;
        }
    }

    public function removeFromCart($userId, $pharmacyDrugId)
    {
        return $this->where('user_id', $userId)
                    ->where('pharmacy_drug_id', $pharmacyDrugId)
                    ->delete();
    }

    public function updateQuantity($userId, $pharmacyDrugId, $quantity)
    {
        return $this->where('user_id', $userId)
                    ->where('pharmacy_drug_id', $pharmacyDrugId)
                    ->set(['quantity' => $quantity])
                    ->update();
    }

    public function clearCart($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}

