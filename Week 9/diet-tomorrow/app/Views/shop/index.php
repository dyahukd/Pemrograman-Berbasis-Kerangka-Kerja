<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Treats — DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fffaf7;
            color: #493b3b;
            font-family: 'DM Sans', sans-serif;
        }

        .navbar {
            background: #fff;
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

        .hero {
            background: #f9e6e9;
            padding: 65px 20px;
            text-align: center;
        }

        .hero h1 {
            color: #a94f69;
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 6vw, 58px);
        }

        .hero p {
            color: #856a6a;
        }

        .product-card {
            background: white;
            border: 1px solid #f2e4e1;
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            transition: .25s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px #a76b7018;
        }

        .product-picture {
            height: 190px;
            background: #f9e6e9;
            overflow: hidden;
        }

        .product-picture img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            transition: .3s;
        }

        .product-picture:hover img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 20px;
        }

        .product-info h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .price {
            color: #c65b75;
            font-weight: 700;
        }

        .category {
            color: #a47777;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-pink {
            background: #c65b75;
            color: white;
            border-radius: 30px;
            padding: 9px 20px;
            font-weight: 600;
        }

        .btn-pink:hover {
            background: #a94f69;
            color: white;
        }

        .btn-pink:disabled {
            background: #c9a5ad;
            color: white;
        }

        footer {
            background: #f9e6e9;
            color: #856a6a;
            padding: 25px;
            text-align: center;
            margin-top: 70px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="brand" href="<?= site_url('/') ?>">DIET TOMORROW ♡</a>

        <div class="ms-auto d-flex gap-4">
            <a class="nav-link" href="<?= site_url('/') ?>">Home</a>
            <a class="nav-link" href="<?= site_url('shop') ?>">Shop</a>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <p>MADE WITH LOVE, BAKED WITH JOY ♡</p>
        <h1>Our Little Treats</h1>
        <p>Something sweet for every little moment.</p>
    </div>
</section>

<section class="container pt-5">
    <form action="<?= site_url('shop') ?>" method="get"
          class="row g-2 align-items-center">

        <div class="col-md-6">
            <input type="text"
                   name="q"
                   class="form-control rounded-pill"
                   placeholder="Search your favorite treats..."
                   value="<?= esc($keyword) ?>">
        </div>

        <div class="col-md-4">
            <select name="category"
                    class="form-select rounded-pill">

                <option value="">All Categories</option>

                <?php foreach ($categories as $item): ?>
                    <option value="<?= esc($item['category']) ?>"
                        <?= $selectedCategory === $item['category']
                            ? 'selected' : '' ?>>
                        <?= esc($item['category']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-pink w-100" type="submit">
                Search
            </button>
        </div>

    </form>
</section>

<section class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="category mb-1">THE GOOD STUFF</p>
            <h2 style="font-family: 'Playfair Display', serif;">
                Freshly Baked for You
            </h2>
        </div>

        <span class="text-secondary">
            <?= count($products) ?> products
        </span>
    </div>

    <div class="row g-4">

        <?php foreach ($products as $product): ?>

            <?php
                // Default product images
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

                // Use uploaded image if available
                // Otherwise use the default image based on product slug
                $image = !empty($product['image'])
                    ? base_url('uploads/products/' . $product['image'])
                    : ($productImages[$product['slug']]
                        ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=700');
            ?>

            <div class="col-12 col-sm-6 col-lg-3">

                <div class="product-card">

                    <div class="product-picture">
                        <a href="<?= site_url('product/' . $product['slug']) ?>">
                            <img
                                src="<?= esc($image) ?>"
                                alt="<?= esc($product['name']) ?>"
                                loading="lazy">
                        </a>
                    </div>

                    <div class="product-info">

                        <p class="category mb-2">
                            <?= esc($product['category']) ?>
                        </p>

                        <h5>
                            <a href="<?= site_url('product/' . $product['slug']) ?>"
                               class="text-decoration-none"
                               style="color: #493b3b;">
                                <?= esc($product['name']) ?>
                            </a>
                        </h5>

                        <p class="text-secondary small">
                            <?= esc($product['description']) ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="price">
                                Rp<?= number_format((float) $product['price'], 0, ',', '.') ?>
                            </span>

                            <form action="<?= site_url('cart/add/' . $product['id']) ?>"
                                  method="post">

                                <?= csrf_field() ?>

                                <button class="btn btn-pink btn-sm"
                                        type="submit"
                                        <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>

                                    <?= $product['stock'] > 0
                                        ? '+ Add'
                                        : 'Sold Out' ?>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

        <?php if (empty($products)): ?>
            <div class="col-12 text-center py-5">
                Belum ada produk tersedia ♡
            </div>
        <?php endif; ?>

    </div>
</section>

<footer>
    <strong>DIET TOMORROW ♡</strong>
    <p class="mb-0 mt-2">sweet treats, zero regrets ♡</p>
</footer>

</body>
</html>