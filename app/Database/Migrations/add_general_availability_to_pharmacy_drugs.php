<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGeneralAvailabilityToPharmacyDrugs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pharmacy_drugs', [
            'general_availability' => [
                'type' => 'ENUM',
                'constraint' => ['in_stock', 'low_stock', 'out_of_stock'],
                'default' => 'in_stock',
                'after' => 'stock'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pharmacy_drugs', 'general_availability');
    }
}

