<?php

namespace App\Controllers;

use App\Models\Product;

class Shop extends BaseController
{
    public function index(): string
    {
        $productModel = new Product();

        $keyword = trim($this->request->getGet('q') ?? '');
        $category = trim($this->request->getGet('category') ?? '');

        $builder = $productModel
            ->where('is_active', 1);

        if ($keyword !== '') {
            $builder->like('name', $keyword);
        }

        if ($category !== '') {
            $builder->where('category', $category);
        }

        $data['products'] = $builder->orderBy('id', 'DESC')->findAll();

        $data['keyword'] = $keyword;
        $data['selectedCategory'] = $category;

        $data['categories'] = (new Product())
            ->distinct()
            ->select('category')
            ->where('is_active', 1)
            ->orderBy('category', 'ASC')
            ->findAll();

        return view('shop/index', $data);
    }
}