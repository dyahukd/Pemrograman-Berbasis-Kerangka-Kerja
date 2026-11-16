<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToOrders extends Migration
{
    public function up()
    {
        $this->db->query(
            'ALTER TABLE orders
             ADD CONSTRAINT fk_orders_user
             FOREIGN KEY (user_id) REFERENCES users(id)
             ON DELETE SET NULL
             ON UPDATE CASCADE'
        );
    }

    public function down()
    {
        $this->db->query(
            'ALTER TABLE orders
             DROP FOREIGN KEY fk_orders_user'
        );
    }
}