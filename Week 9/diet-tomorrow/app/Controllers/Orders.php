<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderItem;

class Orders extends BaseController
{
    public function index()
    {
        if (
            !session()->get('isLoggedIn') ||
            session()->get('user_role') !== 'customer'
        ) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $orderModel = new Order();

        $data['orders'] = $orderModel
            ->where('user_id', session()->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('orders/index', $data);
    }

    public function show($id)
    {
        if (
            !session()->get('isLoggedIn') ||
            session()->get('user_role') !== 'customer'
        ) {
            return redirect()->to(site_url('login'));
        }

        $orderModel = new Order();
        $orderItemModel = new OrderItem();

        $order = $orderModel
            ->where('id', $id)
            ->where('user_id', session()->get('user_id'))
            ->first();

        if (!$order) {
            return redirect()->to(site_url('my-orders'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $data['order'] = $order;
        $data['items'] = $orderItemModel
            ->where('order_id', $id)
            ->findAll();

        return view('orders/show', $data);
    }
}