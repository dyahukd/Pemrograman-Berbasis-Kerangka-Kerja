<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #fff9f5;
            color: #563c36;
            font-family: 'DM Sans', sans-serif;
        }

        .topbar {
            background: #fff;
            padding: 18px 5%;
            border-bottom: 1px solid #f1e5df;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            color: #a85d65;
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 700;
            text-decoration: none;
        }

        .page {
            max-width: 1150px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            color: #704b45;
        }

        .subtitle {
            color: #a58d85;
        }

        .btn-pink {
            background: #bd7780;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 11px 18px;
        }

        .btn-pink:hover {
            background: #a85d65;
            color: white;
        }

        .product-table {
            background: white;
            border-radius: 17px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(100, 65, 55, .06);
        }

        .table {
            margin: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f8eeea;
            color: #795b53;
            font-size: 13px;
            padding: 16px;
            border: none;
        }

        .table tbody td {
            padding: 15px 16px;
            border-color: #f5eeea;
        }

        .product-img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 10px;
        }

        .status {
            display: inline-block;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .active {
            background: #e8f4e9;
            color: #50845b;
        }

        .inactive {
            background: #f5e8e7;
            color: #a65c5c;
        }

        .btn-edit {
            color: #a85d65;
            background: #faeeee;
            border: none;
        }

        .btn-delete {
            color: #a65c5c;
            background: #f8e9e7;
            border: none;
        }

        .btn-edit, .btn-delete {
            border-radius: 8px;
            padding: 7px 10px;
        }

        .alert {
            border: none;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<header class="topbar">
    <a href="<?= site_url('admin/dashboard') ?>" class="brand">
        DIET TOMORROW
    </a>

    <a href="<?= site_url('admin/dashboard') ?>" class="text-decoration-none" style="color:#a85d65">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
</header>

<main class="page">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Manage Products</h1>
            <p class="subtitle mb-0">Manage your sweet treats here ♡</p>
        </div>

        <a href="<?= site_url('admin/products/new') ?>" class="btn btn-pink">
            <i class="bi bi-plus-lg"></i> Add New Product
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="product-table table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img
                                        src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                        class="product-img"
                                        alt="<?= esc($product['name']) ?>"
                                    >
                                <?php else: ?>
                                    <div class="product-img d-flex align-items-center justify-content-center" style="background:#f8eeea">
                                        <i class="bi bi-image fs-3" style="color:#bd9290"></i>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong><?= esc($product['name']) ?></strong>
                                <div class="small text-muted">
                                    <?= esc($product['slug']) ?>
                                </div>
                            </td>

                            <td><?= esc($product['category']) ?></td>

                            <td>
                                Rp<?= number_format($product['price'], 0, ',', '.') ?>
                            </td>

                            <td><?= esc($product['stock']) ?></td>

                            <td>
                                <?php if ($product['is_active']): ?>
                                    <span class="status active">Active</span>
                                <?php else: ?>
                                    <span class="status inactive">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a
                                        href="<?= site_url('admin/products/edit/' . $product['id']) ?>"
                                        class="btn-edit"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <?php if ($product['is_active']): ?>
                                        <form
                                            action="<?= site_url('admin/products/delete/' . $product['id']) ?>"
                                            method="post"
                                            onsubmit="return confirm('Nonaktifkan produk ini? Produk tidak akan tampil di toko.');"
                                        >
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn-delete" title="Deactivate">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            No products found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

</body>
</html>