<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #fff9f6;
            color: #654638;
            font-family: 'DM Sans', sans-serif;
        }

        h1, h2 {
            font-family: 'Playfair Display', serif;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #f0dfd6;
            padding: 18px 0;
        }

        .stat-card, .panel {
            background: white;
            border: 1px solid #f0dfd6;
            border-radius: 16px;
            padding: 24px;
            height: 100%;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
        }

        .btn-main {
            background: #b98270;
            color: white;
            border: 0;
            border-radius: 25px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            transition: .2s;
        }

        .btn-main:hover {
            background: #986653;
            color: white;
        }

        .btn-products {
            background: #f5e5e2;
            color: #986653;
            border: 0;
            border-radius: 25px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            transition: .2s;
        }

        .btn-products:hover {
            background: #ead1cc;
            color: #795044;
        }

        .table thead th {
            color: #98796c;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <strong>DIET TOMORROW <span class="text-muted">| Admin</span></strong>

        <form action="<?= site_url('logout') ?>" method="post">
            <?= csrf_field() ?>
            <button class="btn btn-outline-secondary btn-sm">Logout</button>
        </form>
    </div>
</div>

<div class="container py-5">

    <h1>Dashboard Overview</h1>
    <p class="text-muted">Welcome, <?= esc(session()->get('user_name')) ?>!</p>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <div class="row g-3 my-4">

        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-muted mb-2">Total Orders</p>
                <div class="stat-number"><?= $totalOrders ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-muted mb-2">Pending Orders</p>
                <div class="stat-number"><?= $pendingOrders ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-muted mb-2">Completed Orders</p>
                <div class="stat-number"><?= $completedOrders ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-muted mb-2">Order Revenue</p>
                <div class="stat-number" style="font-size:22px">
                    Rp<?= number_format($totalRevenue, 0, ',', '.') ?>
                </div>
            </div>
        </div>

    </div>

    <div class="panel">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">

            <h4 class="mb-0">Recent Orders</h4>

            <div class="d-flex flex-wrap gap-2">

                <a href="<?= site_url('admin/products') ?>" class="btn-products">
                    <i class="bi bi-box-seam"></i> Manage Products
                </a>

                <a href="<?= site_url('admin/orders') ?>" class="btn-main">
                    <i class="bi bi-receipt"></i> Manage Orders
                </a>

            </div>

        </div>

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= esc($order['customer_name']) ?></td>
                            <td>
                                Rp<?= number_format($order['total_amount'], 0, ',', '.') ?>
                            </td>
                            <td><?= esc(ucfirst($order['status'])) ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($recentOrders)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No orders yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

</body>
</html>