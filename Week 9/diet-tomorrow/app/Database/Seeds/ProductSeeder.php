<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name'        => 'Monday Croissant',
                'slug'        => 'monday-croissant',
                'category'    => 'Pastries',
                'description' => 'Flaky, buttery croissant yang renyah di luar dan lembut di dalam.',
                'price'       => 22000,
                'image'       => null,
                'stock'       => 20,
                'is_active'   => 1,
            ],
            [
                'name'        => 'Midnight Brownies',
                'slug'        => 'midnight-brownies',
                'category'    => 'Brownies',
                'description' => 'Rich chocolate brownies dengan tekstur fudgy dan rasa cokelat yang intens.',
                'price'       => 28000,
                'image'       => null,
                'stock'       => 15,
                'is_active'   => 1,
            ],
            [
                'name'        => 'Strawberry Cloud',
                'slug'        => 'strawberry-cloud',
                'category'    => 'Cakes',
                'description' => 'Cake lembut dengan krim vanilla dan strawberry segar.',
                'price'       => 35000,
                'image'       => null,
                'stock'       => 12,
                'is_active'   => 1,
            ],
            [
                'name'        => 'Guilty Pleasure Cookies',
                'slug'        => 'guilty-pleasure-cookies',
                'category'    => 'Cookies',
                'description' => 'Cookies renyah dengan potongan cokelat yang melimpah.',
                'price'       => 18000,
                'image'       => null,
                'stock'       => 30,
                'is_active'   => 1,
            ],
        ];

        $this->db->table('products')->insertBatch($products);
    }
}