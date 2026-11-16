<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fff9f5;
            font-family: 'DM Sans', sans-serif;
            color: #59423d;
        }

        .navbar {
            background: white;
            padding: 18px 0;
            border-bottom: 1px solid #f3e5df;
        }

        .brand, .page-title {
            font-family: 'Playfair Display', serif;
            color: #bd7885;
            font-weight: 700;
        }

        .brand {
            font-size: 25px;
            text-decoration: none;
        }

        .detail-card {
            background: white;
            border: 1px solid #f1e2dc;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
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

        .table th {
            color: #8b6d66;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-back {
            color: #bd7885;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            color: #965c69;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container">
        <a href="<?= site_url('/') ?>" class="brand">DIET TOMORROW ♡</a>
    </div>
</nav>

<div class="container py-5">

    <a href="<?= site_url('my-orders') ?>" class="btn-back">
        ← Back to My Orders
    </a>

    <div class="mt-4 mb-4">
        <h1 class="page-title">Order Details ♡</h1>
        <p class="text-secondary">
            Here's everything about your order.
        </p>
    </div>

    <div class="detail-card">

        <div class="row gy-3">

            <div class="col-md-4">
                <small class="text-secondary">Order Number</small>
                <h5 class="fw-bold">#<?= esc($order['id']) ?></h5>
            </div>

            <div class="col-md-4">
                <small class="text-secondary">Order Date</small>
                <h6>
                    <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                </h6>
            </div>

            <div class="col-md-4">
                <small class="text-secondary">Status</small>
                <div>
                    <span class="status status-<?= esc($order['status']) ?>">
                        <?= esc($order['status']) ?>
                    </span>
                </div>
            </div>

        </div>

    </div>

    <div class="detail-card">
        <h5 class="page-title mb-4">Customer Information</h5>

        <p><strong>Name:</strong> <?= esc($order['customer_name']) ?></p>
        <p><strong>Phone:</strong> <?= esc($order['phone']) ?></p>
        <p class="mb-0">
            <strong>Address:</strong><br>
            <?= nl2br(esc($order['address'])) ?>
        </p>
    </div>

    <div class="detail-card">
        <h5 class="page-title mb-4">Ordered Items</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="fw-semibold">
                                <?= esc($item['product_name']) ?>
                            </td>

                            <td>
                                Rp<?= number_format($item['price'], 0, ',', '.') ?>
                            </td>

                            <td><?= esc($item['quantity']) ?></td>

                            <td class="text-end fw-semibold">
                                Rp<?= number_format($item['subtotal'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold">Total Payment</span>
            <h4 class="page-title mb-0">
                Rp<?= number_format($order['total_amount'], 0, ',', '.') ?>
            </h4>
        </div>
    </div>

</div>

</body>
</html>