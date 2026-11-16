<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTables extends Migration
{
    public function up()
    {
        // Tabel orders
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'pending',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');

        // Tabel order_items
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'product_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'quantity' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('order_id');

        $this->forge->addForeignKey(
            'order_id',
            'orders',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items', true);
        $this->forge->dropTable('orders', true);
    }
}