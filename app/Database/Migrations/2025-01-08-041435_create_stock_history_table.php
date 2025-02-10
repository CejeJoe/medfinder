<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pharmacy_drug_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'old_stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'new_stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Add indexes for foreign keys
        $this->forge->addKey('pharmacy_drug_id');
        $this->forge->addKey('user_id');
        
        $this->forge->createTable('stock_history');
        
        // Add foreign keys after table creation
        $this->db->query('ALTER TABLE stock_history ADD CONSTRAINT fk_pharmacy_drug 
            FOREIGN KEY (pharmacy_drug_id) REFERENCES pharmacy_drugs(id) 
            ON DELETE CASCADE ON UPDATE CASCADE');
            
        $this->db->query('ALTER TABLE stock_history ADD CONSTRAINT fk_user 
            FOREIGN KEY (user_id) REFERENCES users(id) 
            ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop foreign keys first
        $this->db->query('ALTER TABLE stock_history DROP FOREIGN KEY fk_pharmacy_drug');
        $this->db->query('ALTER TABLE stock_history DROP FOREIGN KEY fk_user');
        
        $this->forge->dropTable('stock_history');
    }
} 