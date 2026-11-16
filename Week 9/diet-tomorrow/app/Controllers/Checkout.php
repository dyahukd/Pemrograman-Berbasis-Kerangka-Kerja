<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class Checkout extends BaseController
{
    public function index()
    {
        if (
            !session()->get('isLoggedIn') ||
            session()->get('user_role') !== 'customer'
        ) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Silakan login sebagai pelanggan terlebih dahulu.');
        }
        
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(site_url('cart'))
                ->with('error', 'Your cart is empty.');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout/index', [
            'cart'  => $cart,
            'total' => $total,
        ]);
    }

    public function placeOrder()
    {
        if (
            !session()->get('isLoggedIn') ||
            session()->get('user_role') !== 'customer'
        ) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Silakan login sebagai pelanggan terlebih dahulu.');
        }
    
        $rules = [
            'customer_name' => 'required|min_length[3]|max_length[100]',
            'phone'         => 'required|min_length[8]|max_length[20]',
            'address'       => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(site_url('cart'))
                ->with('error', 'Your cart is empty.');
        }

        $db = \Config\Database::connect();

        $productModel = new Product();
        $orderModel = new Order();
        $orderItemModel = new OrderItem();

        $db->transBegin();

        try {
            $orderItems = [];
            $total = 0;

            // Periksa ulang produk, harga, dan stok dari database.
            foreach ($cart as $id => $item) {
                $quantity = (int) $item['quantity'];
                $product = $productModel->find($id);

                if (
                    !$product ||
                    !$product['is_active'] ||
                    $quantity < 1 ||
                    $product['stock'] < $quantity
                ) {
                    throw new \RuntimeException(
                        'Stock for ' . $item['name'] . ' is no longer sufficient.'
                    );
                }

                $price = (float) $product['price'];
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $orderItems[] = [
                    'product_id'   => $product['id'],
                    'product_name' => $product['name'],
                    'price'        => $price,
                    'quantity'     => $quantity,
                    'subtotal'     => $subtotal,
                ];

                // Kurangi stok hanya jika stok masih mencukupi.
                $db->table('products')
                    ->set('stock', 'stock - ' . $quantity, false)
                    ->where('id', $id)
                    ->where('is_active', 1)
                    ->where('stock >=', $quantity)
                    ->update();

                if ($db->affectedRows() !== 1) {
                    throw new \RuntimeException(
                        'Stock for ' . $product['name'] . ' has changed. Please check your cart.'
                    );
                }
            }

            // Simpan data pesanan utama.
            $orderModel->insert([
                'user_id'       => session()->get('user_id'),
                'customer_name' => $this->request->getPost('customer_name'),
                'phone'         => $this->request->getPost('phone'),
                'address'       => $this->request->getPost('address'),
                'total_amount'  => $total,
                'status'        => 'pending',
            ]);

            $orderId = $orderModel->getInsertID();

            if (!$orderId) {
                throw new \RuntimeException('Failed to save order.');
            }

            // Simpan setiap produk ke detail pesanan.
            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $orderId;

                $orderItemModel->insert($orderItem);
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Failed to process your order.');
            }

            $db->transCommit();

            // Kosongkan keranjang setelah transaksi berhasil.
            session()->remove('cart');

            return redirect()->to(
                site_url('checkout/success/' . $orderId)
            );

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function success($id)
    {
        $orderModel = new Order();
        $orderItemModel = new OrderItem();

        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to(site_url('shop'));
        }

        $data['order'] = $order;
        $data['items'] = $orderItemModel
            ->where('order_id', $id)
            ->findAll();

        return view('checkout/success', $data);
    }
}