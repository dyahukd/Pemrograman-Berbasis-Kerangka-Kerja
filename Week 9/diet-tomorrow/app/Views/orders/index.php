<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fff9f5;
            font-family: 'DM Sans', sans-serif;
            color: #59423d;
        }

        .navbar {
            background: #fff;
            padding: 18px 0;
            border-bottom: 1px solid #f3e5df;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            color: #bd7885;
            font-size: 25px;
            font-weight: 700;
            text-decoration: none;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            color: #704b48;
        }

        .order-card {
            background: white;
            border: 1px solid #f1e2dc;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 18px;
        }

        .status {
            display: inline-block;
            padding: 6px 13px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-pending {
            background: #fff1cf;
            color: #946b17;
        }

        .status-processing {
            background: #e4efff;
            color: #3766a0;
        }

        .status-completed {
            background: #e1f5e7;
            color: #34764a;
        }

        .status-cancelled {
            background: #fbe2e2;
            color: #a94444;
        }

        .btn-detail {
            background: #c77f8c;
            color: white;
            border-radius: 25px;
            padding: 9px 20px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-detail:hover {
            background: #ad6674;
            color: white;
        }

        .empty-box {
            background: white;
            border: 1px solid #f1e2dc;
            border-radius: 18px;
            padding: 55px 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="<?= site_url('/') ?>" class="brand">DIET TOMORROW ♡</a>

        <div class="d-flex gap-3 align-items-center">
            <a href="<?= site_url('/') ?>" class="text-decoration-none text-secondary">Home</a>
            <a href="<?= site_url('shop') ?>" class="text-decoration-none text-secondary">Shop</a>
            <a href="<?= site_url('cart') ?>" class="text-decoration-none text-secondary">Cart</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <div class="mb-4">
        <h1 class="page-title">My Orders ♡</h1>
        <p class="text-secondary">Keep track of your sweet little purchases.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>

        <div class="empty-box">
            <div style="font-size: 50px;">🧁</div>
            <h4 class="page-title mt-3">No orders yet!</h4>
            <p class="text-secondary">
                Looks like you haven't ordered any treats.
            </p>
            <a href="<?= site_url('/#shop') ?>" class="btn-detail d-inline-block mt-2">
                Start Shopping
            </a>
        </div>

    <?php else: ?>

        <?php foreach ($orders as $order): ?>

            <div class="order-card">
                <div class="row align-items-center gy-3">

                    <div class="col-md-3">
                        <small class="text-secondary">Order Number</small>
                        <h6 class="fw-bold mb-0">
                            #<?= esc($order['id']) ?>
                        </h6>
                    </div>

                    <div class="col-md-3">
                        <small class="text-secondary">Order Date</small>
                        <div class="fw-semibold">
                            <?= date('d M Y', strtotime($order['created_at'])) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-secondary">Total</small>
                        <div class="fw-bold">
                            Rp<?= number_format($order['total_amount'], 0, ',', '.') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-secondary">Status</small>
                        <div>
                            <span class="status status-<?= esc($order['status']) ?>">
                                <?= esc($order['status']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="col-12 text-md-end">
                        <a href="<?= site_url('my-orders/' . $order['id']) ?>"
                           class="btn-detail">
                            View Details →
                        </a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

</body>
</html>