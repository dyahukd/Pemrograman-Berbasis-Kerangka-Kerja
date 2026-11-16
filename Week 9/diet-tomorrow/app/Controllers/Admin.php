<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderItem;

class Admin extends BaseController
{
    private function isAdmin()
    {
        return session()->get('isLoggedIn') &&
               session()->get('user_role') === 'admin';
    }

    public function dashboard()
    {
        if (!$this->isAdmin()) {
            return redirect()->to(site_url('admin/login'));
        }

        $db = \Config\Database::connect();

        $data['totalOrders'] = $db->table('orders')->countAllResults();
        $data['pendingOrders'] = $db->table('orders')
            ->where('status', 'pending')->countAllResults();
        $data['completedOrders'] = $db->table('orders')
            ->where('status', 'completed')->countAllResults();
        $data['totalRevenue'] = $db->table('orders')
            ->selectSum('total_amount')
            ->where('status !=', 'cancelled')
            ->get()->getRow()->total_amount ?? 0;

        $data['recentOrders'] = (new Order())
            ->orderBy('id', 'DESC')
            ->findAll(5);

        return view('admin/dashboard', $data);
    }

    public function orders()
    {
        if (!$this->isAdmin()) {
            return redirect()->to(site_url('admin/login'));
        }

        $data['orders'] = (new Order())
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/orders', $data);
    }

    public function updateStatus($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to(site_url('admin/login'));
        }

        $newStatus = $this->request->getPost('status');

        $allowed = ['pending', 'processing', 'completed', 'cancelled'];

        if (!in_array($newStatus, $allowed, true)) {
            return redirect()->back()->with('error', 'Invalid order status.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $order = (new Order())->find($id);

            if (!$order) {
                throw new \RuntimeException('Order not found.');
            }

            $oldStatus = $order['status'];
            $items = (new OrderItem())
                ->where('order_id', $id)
                ->findAll();

            // Restore stock when an order is cancelled.
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                foreach ($items as $item) {
                    $db->table('products')
                        ->set('stock', 'stock + ' . (int) $item['quantity'], false)
                        ->where('id', $item['product_id'])
                        ->update();
                }
            }

            // Deduct stock again if a cancelled order is reopened.
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($items as $item) {
                    $quantity = (int) $item['quantity'];

                    $db->table('products')
                        ->set('stock', 'stock - ' . $quantity, false)
                        ->where('id', $item['product_id'])
                        ->where('stock >=', $quantity)
                        ->update();

                    if ($db->affectedRows() !== 1) {
                        throw new \RuntimeException(
                            'Insufficient stock to reopen this order.'
                        );
                    }
                }
            }

            (new Order())->update($id, ['status' => $newStatus]);

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Failed to update order.');
            }

            $db->transCommit();

            return redirect()->to(site_url('admin/orders'))
                ->with('success', 'Order status updated successfully.');

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}