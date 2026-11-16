<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $email = 'admin@diettommorrow.test';

        $exists = $this->db->table('users')
            ->where('email', $email)
            ->countAllResults();

        if ($exists > 0) {
            return;
        }

        $this->db->table('users')->insert([
            'name' => 'DIET TOMORROW Admin',
            'email' => $email,
            'phone' => '081234567890',
            'password_hash' => password_hash(
                'Admin123!',
                PASSWORD_DEFAULT
            ),
            'role' => 'admin',
        ]);
    }
}