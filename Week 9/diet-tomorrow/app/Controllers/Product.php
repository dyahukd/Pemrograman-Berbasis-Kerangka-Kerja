<?php

namespace App\Controllers;

use App\Models\Product as ProductModel;

class Product extends BaseController
{
    public function detail($slug)
    {
        $product = (new ProductModel())
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Product not found.'
            );
        }

        return view('product/detail', [
            'product' => $product
        ]);
    }
}