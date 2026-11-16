<?php

namespace App\Controllers;

use App\Models\Product;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel = new Product();

        $data['products'] = $productModel
            ->where('is_active', 1)
            ->findAll();

        return view('home', $data);
    }
}