<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($product['name']) ?> — DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fffaf7;
            color: #493b3b;
            font-family: 'DM Sans', sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #f4e5e5;
            padding: 18px 0;
        }

        .brand {
            color: #c65b75;
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 700;
            text-decoration: none;
        }

        .nav-link {
            color: #634e4e;
            font-weight: 600;
        }

        .product-image {
            background: #f9e6e9;
            border-radius: 22px;
            width: 100%;
            height: 450px;
            object-fit: cover;
            box-shadow: 0 10px 30px #a76b7015;
        }

        .category {
            color: #a47777;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: #a94f69;
            font-size: clamp(32px, 5vw, 45px);
        }

        .price {
            color: #c65b75;
            font-size: 25px;
            font-weight: 700;
        }

        .description {
            color: #856a6a;
            line-height: 1.8;
        }

        .stock-info {
            background: #f9e6e9;
            border-radius: 12px;
            padding: 14px 18px;
            display: inline-block;
            color: #856a6a;
        }

        .btn-pink {
            background: #c65b75;
            color: white;
            border-radius: 30px;
            padding: 11px 25px;
            font-weight: 600;
            border: none;
        }

        .btn-pink:hover {
            background: #a94f69;
            color: white;
        }

        .btn-pink:disabled {
            background: #c9a5ad;
            color: white;
        }

        .back-link {
            color: #c65b75;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            color: #a94f69;
        }

        footer {
            background: #f9e6e9;
            color: #856a6a;
            padding: 25px;
            text-align: center;
            margin-top: 80px;
        }

        @media (max-width: 767px) {
            .product-image {
                height: 320px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="brand" href="<?= site_url('/') ?>">
            DIET TOMORROW ♡
        </a>

        <div class="ms-auto d-flex gap-4">
            <a href="<?= site_url('/') ?>" class="nav-link">
                Home
            </a>

            <a href="<?= site_url('shop') ?>" class="nav-link">
                Shop
            </a>

            <a href="<?= site_url('cart') ?>" class="nav-link">
                Cart
            </a>
        </div>

    </div>
</nav>

<?php
    // Default images for each product
    $productImages = [
        'monday-croissant' =>
            'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=700',

        'midnight-brownies' =>
            'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=700',

        'strawberry-cloud' =>
            'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=700',

        'guilty-pleasure-cookies' =>
            'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=700',
    ];

    // Prefer uploaded image, otherwise use default product image
    $image = !empty($product['image'])
        ? base_url('uploads/products/' . $product['image'])
        : ($productImages[$product['slug']]
            ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=700');
?>

<section class="container py-5">

    <a href="<?= site_url('shop') ?>" class="back-link">
        ← Back to Shop
    </a>

    <div class="row g-5 align-items-center mt-3">

        <!-- Product Image -->
        <div class="col-md-6">

            <img
                src="<?= esc($image) ?>"
                alt="<?= esc($product['name']) ?>"
                class="product-image">

        </div>

        <!-- Product Information -->
        <div class="col-md-6">

            <p class="category mb-2">
                <?= esc($product['category']) ?>
            </p>

            <h1 class="mb-3">
                <?= esc($product['name']) ?>
            </h1>

            <p class="price mb-4">
                Rp<?= number_format((float) $product['price'], 0, ',', '.') ?>
            </p>

            <p class="description">
                <?= esc($product['description']) ?>
            </p>

            <div class="stock-info mt-3">
                <strong>Stock:</strong>
                <?= (int) $product['stock'] ?> available
            </div>

            <form action="<?= site_url('cart/add/' . $product['id']) ?>"
                  method="post">

                <?= csrf_field() ?>

                <button type="submit"
                        class="btn btn-pink mt-4"
                        <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>

                    <?= $product['stock'] > 0
                        ? 'Add to Cart ♡'
                        : 'Sold Out' ?>

                </button>

            </form>

            <p class="mt-4 small text-secondary">
                Sweet treats, zero regrets ♡
            </p>

        </div>

    </div>

</section>

<footer>
    <strong>DIET TOMORROW ♡</strong>
    <p class="mb-0 mt-2">sweet treats, zero regrets ♡</p>
</footer>

</body>
</html>