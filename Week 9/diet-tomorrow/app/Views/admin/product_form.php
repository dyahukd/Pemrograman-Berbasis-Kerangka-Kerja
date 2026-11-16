<?php
$isEdit = !empty($product);
$action = $isEdit
    ? site_url('admin/products/update/' . $product['id'])
    : site_url('admin/products/store');

$errors = session()->getFlashdata('errors') ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?> - DIET TOMORROW</title>

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
            background: white;
            padding: 18px 5%;
            border-bottom: 1px solid #f1e5df;
        }

        .brand {
            color: #a85d65;
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 700;
            text-decoration: none;
        }

        .form-container {
            max-width: 800px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 5px 25px rgba(100, 65, 55, .06);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: #704b45;
        }

        .form-label {
            font-weight: 600;
            color: #795b53;
        }

        .form-control, .form-select {
            border: 1px solid #eadbd5;
            border-radius: 10px;
            padding: 11px 13px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #bd7780;
            box-shadow: 0 0 0 .2rem rgba(189,119,128,.12);
        }

        .btn-pink {
            background: #bd7780;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 11px 20px;
        }

        .btn-pink:hover {
            background: #a85d65;
            color: white;
        }

        .current-image {
            width: 150px;
            height: 130px;
            object-fit: cover;
            border-radius: 12px;
        }

        .error-list {
            background: #fff0ee;
            color: #a64f4f;
            border-radius: 10px;
            padding: 14px 20px;
        }
    </style>
</head>

<body>

<header class="topbar">
    <a href="<?= site_url('admin/dashboard') ?>" class="brand">
        DIET TOMORROW
    </a>
</header>

<main class="form-container">

    <a href="<?= site_url('admin/products') ?>" class="text-decoration-none" style="color:#a85d65">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>

    <div class="mt-4 mb-4">
        <h1><?= esc($pageTitle) ?></h1>
        <p class="text-muted">Give your sweet treats the details they deserve ♡</p>
    </div>

    <div class="form-card">

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-list mb-4">
                <strong>Please check the following:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="<?= esc(old('name', $product['name'] ?? '')) ?>"
                    placeholder="e.g. Strawberry Cloud"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input
                    type="text"
                    name="category"
                    class="form-control"
                    value="<?= esc(old('category', $product['category'] ?? '')) ?>"
                    placeholder="e.g. Cakes, Pastries, Cookies"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                    placeholder="Describe your delicious product..."
                    required
                ><?= esc(old('description', $product['description'] ?? '')) ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (Rupiah)</label>
                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="<?= esc(old('price', $product['price'] ?? '')) ?>"
                        placeholder="22000"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock</label>
                    <input
                        type="number"
                        name="stock"
                        class="form-control"
                        min="0"
                        value="<?= esc(old('stock', $product['stock'] ?? '0')) ?>"
                        placeholder="20"
                        required
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>

                <?php if ($isEdit && !empty($product['image'])): ?>
                    <div class="mb-3">
                        <img
                            src="<?= base_url('uploads/products/' . $product['image']) ?>"
                            class="current-image"
                            alt="Current product image"
                        >
                        <p class="small text-muted mt-2 mb-0">Current image</p>
                    </div>
                <?php endif; ?>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept="image/png,image/jpeg,image/webp"
                    <?= $isEdit ? '' : 'required' ?>
                >

                <small class="text-muted">
                    <?= $isEdit ? 'Leave empty to keep the current image.' : 'Upload a product image.' ?>
                    Maximum file size: 2 MB. JPG, PNG, or WEBP.
                </small>
            </div>

            <div class="mb-4">
                <label class="form-label">Product Status</label>
                <?php $activeValue = old('is_active', $product['is_active'] ?? 1); ?>

                <select name="is_active" class="form-select">
                    <option value="1" <?= (string) $activeValue === '1' ? 'selected' : '' ?>>
                        Active - Show in Shop
                    </option>
                    <option value="0" <?= (string) $activeValue === '0' ? 'selected' : '' ?>>
                        Inactive - Hide from Shop
                    </option>
                </select>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-pink">
                    <i class="bi bi-check-lg"></i>
                    <?= $isEdit ? 'Save Changes' : 'Add Product' ?>
                </button>

                <a href="<?= site_url('admin/products') ?>" class="btn btn-light rounded-3 px-4">
                    Cancel
                </a>
            </div>
        </form>

    </div>

</main>

</body>
</html>