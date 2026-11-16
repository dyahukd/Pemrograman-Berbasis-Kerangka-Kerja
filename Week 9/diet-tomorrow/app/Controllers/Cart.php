<?php

namespace App\Controllers;

use App\Models\Product;

class Cart extends BaseController
{
    public function add($id)
    {
        $productModel = new Product();

        $product = $productModel
            ->where('is_active', 1)
            ->find($id);

        if (!$product) {
            return redirect()->to('/#shop')
                ->with('error', 'Product not found.');
        }

        $cart = session()->get('cart') ?? [];
        $currentQty = $cart[$id]['quantity'] ?? 0;

        if ($currentQty >= $product['stock']) {
            return redirect()->to('/#shop')
                ->with('error', 'Sorry, product stock is not sufficient.');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'image'    => $product['image'],
                'quantity' => 1,
            ];
        }

        session()->set('cart', $cart);

        return redirect()->to('/#shop')
            ->with('success', $product['name'] . ' added to cart!');
    }

    public function index()
    {
        $data['cart'] = session()->get('cart') ?? [];

        return view('cart/index', $data);
    }

    public function update($id)
    {
        $cart = session()->get('cart') ?? [];

        if (!isset($cart[$id])) {
            return redirect()->to(site_url('cart'));
        }

        $quantity = (int) $this->request->getPost('quantity');

        // Jika jumlah menjadi nol, hapus produk.
        if ($quantity <= 0) {
            unset($cart[$id]);
            session()->set('cart', $cart);

            return redirect()->to(site_url('cart'))
                ->with('success', 'Product removed from cart.');
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product || !$product['is_active']) {
            unset($cart[$id]);
            session()->set('cart', $cart);

            return redirect()->to(site_url('cart'))
                ->with('error', 'Product is no longer available.');
        }

        if ($quantity > $product['stock']) {
            return redirect()->to(site_url('cart'))
                ->with('error', 'Sorry, available stock is only ' . $product['stock'] . '.');
        }

        $cart[$id]['quantity'] = $quantity;
        session()->set('cart', $cart);

        return redirect()->to(site_url('cart'))
            ->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->set('cart', $cart);
        }

        return redirect()->to(site_url('cart'))
            ->with('success', 'Product removed from cart.');
    }
}