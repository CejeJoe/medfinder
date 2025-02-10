<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLowStockThresholdToPharmacyDrugs extends Migration
{
    public function up()
    {
        // Adding 'low_stock_threshold' column to the 'pharmacy_drugs' table
        $this->forge->addColumn('pharmacy_drugs', [
            'low_stock_threshold' => [
                'type' => 'INT',
                'constraint' => 11, // Limits the size of the integer
                'unsigned' => true,  // Prevents negative numbers, ensuring it only holds positive values
                'null' => false,     // Makes this column mandatory (not nullable)
                'default' => 10,     // Sets a default value (can be changed if required)
            ],
        ]);
    }

    public function down()
    {
        // Dropping the 'low_stock_threshold' column in case of rollback
        $this->forge->dropColumn('pharmacy_drugs', 'low_stock_threshold');
    }
}
