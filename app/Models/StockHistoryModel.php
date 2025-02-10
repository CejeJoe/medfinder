<?php

namespace App\Models;

use CodeIgniter\Model;

class StockHistoryModel extends Model
{
    protected $table = 'stock_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pharmacy_drug_id', 'old_stock', 'new_stock', 'user_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function logStockChange($pharmacyDrugId, $oldStock, $newStock, $userId)
    {
        $this->insert([
            'pharmacy_drug_id' => $pharmacyDrugId,
            'old_stock' => $oldStock,
            'new_stock' => $newStock,
            'user_id' => $userId
        ]);
    }
}

