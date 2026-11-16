<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Orders | DIET TOMORROW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { background:#fff9f6; color:#654638; font-family:'DM Sans',sans-serif; }
        h1 { font-family:'Playfair Display',serif; }
        .panel { background:white; border:1px solid #f0dfd6; border-radius:16px; padding:25px; }
        .btn-main { background:#b98270; color:white; border:0; border-radius:20px; padding:8px 15px; }
        .btn-main:hover { background:#986653; color:white; }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Order Management</h1>
            <p class="text-muted">Manage customer orders and their status.</p>
        </div>

        <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-outline-secondary">
            Back to Dashboard
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total</th>
                        <th>Current Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <strong>#<?= $order['id'] ?></strong>
                                <br>
                                <small class="text-muted"><?= esc($order['created_at'] ?? '') ?></small>
                            </td>

                            <td>
                                <?= esc($order['customer_name']) ?>
                                <br>
                                <small class="text-muted"><?= esc($order['address']) ?></small>
                            </td>

                            <td><?= esc($order['phone']) ?></td>

                            <td>
                                Rp<?= number_format($order['total_amount'], 0, ',', '.') ?>
                            </td>

                            <td><?= esc(ucfirst($order['status'])) ?></td>

                            <td>
                                <form action="<?= site_url('admin/orders/update/' . $order['id']) ?>" method="post" class="d-flex gap-2">
                                    <?= csrf_field() ?>

                                    <select name="status" class="form-select form-select-sm">
                                        <?php foreach (['pending', 'processing', 'completed', 'cancelled'] as $status): ?>
                                            <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>>
                                                <?= ucfirst($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button class="btn btn-main btn-sm">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($orders)): ?>
                        <tr><td colspan="6" class="text-center text-muted">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>