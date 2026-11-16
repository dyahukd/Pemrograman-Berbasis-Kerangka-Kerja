<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIET TOMORROW — Bakery & Sweet Treats</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --pink: #ed9db5;
            --pink-dark: #d86e91;
            --pink-light: #fff0f4;
            --cream: #fffaf5;
            --brown: #49332f;
            --muted: #927d77;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--brown);
            font-family: 'DM Sans', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .announcement {
            background: var(--pink-dark);
            color: white;
            text-align: center;
            padding: 9px 12px;
            font-size: 12px;
            letter-spacing: 1.2px;
        }

        .navbar {
            background: rgba(255, 250, 245, .96);
            border-bottom: 1px solid #f4e6e3;
            padding: 17px 0;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 800;
            color: var(--pink-dark);
            letter-spacing: -1px;
        }

        .nav-link {
            color: var(--brown);
            font-size: 13px;
            font-weight: 600;
            margin: 0 9px;
        }

        .nav-link:hover {
            color: var(--pink-dark);
        }

        .nav-icon {
            color: #654638;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-icon .bi-person {
            font-size: 23px;
        }

        .nav-icon .bi-bag {
            font-size: 19px;
        }

        /* Account yang sedang login */
        .nav-user {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #654638;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .nav-user:hover {
            color: var(--pink-dark);
        }

        /* Tombol logout */
        .nav-logout {
            background: none;
            border: none;
            color: #927d77;
            font-size: 13px;
            cursor: pointer;
            padding: 5px;
        }

        .nav-logout:hover {
            color: var(--pink-dark);
        }

        .hero {
            padding: 65px 0;
            background: var(--pink-light);
            overflow: hidden;
        }

        .hero-label {
            display: inline-block;
            background: white;
            color: var(--pink-dark);
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(43px, 6vw, 70px);
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: var(--pink-dark);
            font-style: italic;
        }

        .hero p {
            color: var(--muted);
            line-height: 1.9;
            max-width: 450px;
            font-size: 15px;
        }

        .btn-pink {
            background: var(--pink-dark);
            color: white;
            border: 1px solid var(--pink-dark);
            border-radius: 30px;
            padding: 13px 27px;
            font-weight: 700;
            font-size: 13px;
            transition: .2s;
        }

        .btn-pink:hover {
            background: var(--brown);
            border-color: var(--brown);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-pink {
            border: 1px solid var(--pink-dark);
            color: var(--pink-dark);
            border-radius: 30px;
            padding: 13px 25px;
            font-weight: 700;
            font-size: 13px;
        }

        .btn-outline-pink:hover {
            background: var(--pink-dark);
            color: white;
        }

        .hero-image {
            width: 100%;
            height: 440px;
            object-fit: cover;
            border-radius: 48% 48% 25px 25px;
            box-shadow: 15px 15px 0 #f3c6d2;
        }

        .section {
            padding: 75px 0;
        }

        .eyebrow {
            color: var(--pink-dark);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 4vw, 42px);
            font-weight: 800;
            margin: 10px 0;
        }

        .section-subtitle {
            color: var(--muted);
            font-size: 14px;
        }

        .category-card {
            display: block;
            text-align: center;
            color: var(--brown);
            padding: 20px 10px;
            border-radius: 18px;
            background: white;
            transition: .2s;
            border: 1px solid #f3e8e4;
        }

        .category-card:hover {
            transform: translateY(-5px);
            border-color: var(--pink);
            color: var(--pink-dark);
        }

        .category-icon {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: var(--pink-light);
            font-size: 34px;
            margin: 0 auto 12px;
        }

        .category-card h6 {
            font-weight: 800;
            font-size: 13px;
            margin: 0;
        }

        .product-card {
            border: 1px solid #f1e6e1;
            border-radius: 18px;
            overflow: hidden;
            background: white;
            height: 100%;
            transition: .25s;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(90, 50, 50, .08);
        }

        .product-image-wrap {
            position: relative;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 225px;
            object-fit: cover;
            transition: .3s;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-tag {
            position: absolute;
            top: 13px;
            left: 13px;
            background: white;
            color: var(--pink-dark);
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
        }

        .product-info {
            padding: 18px;
        }

        .product-info h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 19px;
        }

        .product-info p {
            color: var(--muted);
            font-size: 12px;
            min-height: 36px;
        }

        .product-price {
            color: var(--pink-dark);
            font-weight: 800;
            font-size: 15px;
        }

        .add-cart {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: var(--pink-light);
            color: var(--pink-dark);
            font-size: 21px;
            font-weight: 700;
        }

        .add-cart:hover {
            background: var(--pink-dark);
            color: white;
        }

        /* Homepage Search and Category Filter */
        .home-search {
            background: white;
            border: 1px solid #f1e6e1;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 35px;
        }

        .home-search .form-control,
        .home-search .form-select {
            border: 1px solid #f0dedf;
            border-radius: 30px;
            padding: 12px 18px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--brown);
        }

        .home-search .form-control:focus,
        .home-search .form-select:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(237, 157, 181, .15);
        }

        .home-search .btn-pink {
            width: 100%;
            height: 100%;
            min-height: 45px;
        }

        .story {
            background: #fbe4e9;
            border-radius: 25px;
            padding: 45px;
        }

        .story h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 36px;
        }

        .story p {
            color: #806d68;
            line-height: 1.9;
            font-size: 14px;
        }

        .story-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 20px;
        }

        footer {
            background: #49332f;
            color: #fff4ee;
            padding: 45px 0 25px;
        }

        footer .brand {
            color: #f3a9bf;
        }

        footer p,
        footer a {
            color: #d9c6bf;
            font-size: 13px;
        }

        footer a:hover {
            color: white;
        }

        @media (max-width: 767px) {
            .hero {
                padding: 45px 0;
            }

            .hero-image {
                height: 310px;
                margin-top: 35px;
            }

            .section {
                padding: 55px 0;
            }

            .story {
                padding: 25px;
            }

            .story-image {
                margin-top: 25px;
            }
        }
    </style>
</head>

<body>

    <?php
    $successMessage = session()->getFlashdata('success');
    $errorMessage = session()->getFlashdata('error');
    ?>

    <?php if ($successMessage): ?>
        <div class="alert alert-success text-center m-3">
            <?= esc($successMessage) ?>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger text-center m-3">
            <?= esc($errorMessage) ?>
        </div>
    <?php endif; ?>

    <div class="announcement">
        ♡ FRESHLY BAKED WITH LOVE — A LITTLE TREAT GOES A LONG WAY ♡
    </div>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">

            <a class="navbar-brand brand" href="/">
                DIET TOMORROW<span>♡</span>
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#categories">CATEGORIES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#shop">OUR TREATS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">OUR STORY</a>
                    </li>
                </ul>

                <!-- Account dan Shopping Cart -->
                <div class="d-flex align-items-center gap-3">

                    <?php if (session()->get('isLoggedIn')): ?>

                        <a
                            href="<?= session()->get('user_role') === 'admin'
                                ? site_url('admin/dashboard')
                                : site_url('/') ?>"
                            class="nav-user"
                            aria-label="My Account"
                        >
                            <i class="bi bi-person-circle"
                                style="font-size: 21px;"></i>

                            <span>
                                <?= esc(session()->get('user_name')) ?>
                            </span>
                        </a>

                        <?php if (
                            session()->get('isLoggedIn') &&
                            session()->get('user_role') === 'customer'
                        ): ?>
                            <a href="<?= site_url('my-orders') ?>" class="nav-link">
                                My Orders
                            </a>
                        <?php endif; ?>

                        <form action="<?= site_url('logout') ?>"
                            method="post" class="m-0">

                            <?= csrf_field() ?>

                            <button type="submit"
                                class="nav-logout"
                                aria-label="Logout">

                                <i class="bi bi-box-arrow-right"
                                    style="font-size: 19px;"></i>

                            </button>
                        </form>

                    <?php else: ?>

                        <a href="<?= site_url('login') ?>"
                            class="nav-icon"
                            aria-label="Login">

                            <i class="bi bi-person"></i>

                        </a>

                    <?php endif; ?>

                    <a href="<?= site_url('cart') ?>"
                        class="nav-icon"
                        aria-label="Shopping cart">

                        <i class="bi bi-bag"></i>

                    </a>

                </div>

            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="home">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <span class="hero-label">
                        YOUR DAILY DOSE OF HAPPINESS
                    </span>

                    <h1>
                        Life is short.<br>
                        Eat the <span>dessert.</span>
                    </h1>

                    <p>
                        Freshly baked happiness, sweet little indulgences,
                        and treats that make every day a little more special.
                        Your diet can always start tomorrow!
                    </p>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="#shop" class="btn btn-pink">
                            SHOP OUR TREATS ♡
                        </a>

                        <a href="#about" class="btn btn-outline-pink">
                            OUR STORY
                        </a>
                    </div>

                    <div class="mt-4 small" style="color:#aa8b89;">
                        ✿ Made fresh daily &nbsp; ✿ Baked with love
                    </div>

                </div>

                <div class="col-lg-6">

                    <img
                        class="hero-image"
                        src="https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=1000"
                        alt="Beautiful cupcakes and sweet bakery treats"
                    >

                </div>

            </div>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="section" id="categories">
        <div class="container">

            <div class="text-center mb-5">
                <div class="eyebrow">
                    A LITTLE SOMETHING FOR EVERYONE
                </div>

                <h2 class="section-title">
                    What are you craving?
                </h2>

                <p class="section-subtitle">
                    Pick your favorite kind of happiness.
                </p>
            </div>

            <div class="row g-3 justify-content-center">

                <div class="col-6 col-md-3">
                    <a href="<?= site_url('shop') ?>?category=Pastries"
                        class="category-card">
                        <div class="category-icon">🥐</div>
                        <h6>Breads & Pastries</h6>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="<?= site_url('shop') ?>?category=Cakes"
                        class="category-card">
                        <div class="category-icon">🍰</div>
                        <h6>Cakes & Desserts</h6>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="<?= site_url('shop') ?>?category=Cookies"
                        class="category-card">
                        <div class="category-icon">🍪</div>
                        <h6>Cookies</h6>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="<?= site_url('shop') ?>?category=Brownies"
                        class="category-card">
                        <div class="category-icon">🍫</div>
                        <h6>Brownies</h6>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- OUR TREATS -->
    <section class="section pt-0" id="shop">
        <div class="container">

            <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">

                <div>
                    <div class="eyebrow">BAKED WITH LOVE</div>

                    <h2 class="section-title">
                        Our little favorites.
                    </h2>

                    <p class="section-subtitle mb-0">
                        Good things are meant to be enjoyed.
                    </p>
                </div>

                <a href="<?= site_url('shop') ?>" class="btn btn-outline-pink mt-3">
                    VIEW ALL TREATS →
                </a>

            </div>

            <!-- SEARCH AND CATEGORY FILTER -->
            <div class="home-search">

                <form action="<?= site_url('shop') ?>" method="get">

                    <div class="row g-3 align-items-center">

                        <div class="col-lg-6">

                            <input
                                type="text"
                                name="q"
                                class="form-control"
                                placeholder="Search your favorite treats..."
                            >

                        </div>

                        <div class="col-lg-4">

                            <select name="category" class="form-select">

                                <option value="">All Categories</option>

                                <?php
                                $homeCategories = array_unique(
                                    array_column($products ?? [], 'category')
                                );
                                sort($homeCategories);
                                ?>

                                <?php foreach ($homeCategories as $category): ?>

                                    <option value="<?= esc($category) ?>">
                                        <?= esc($category) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-lg-2">

                            <button type="submit" class="btn btn-pink">
                                <i class="bi bi-search"></i>
                                SEARCH TREATS
                            </button>

                        </div>

                    </div>

                </form>

            </div>

            <?php
            // Foto dan badge khusus untuk empat produk awal.
            // Produk baru dapat menggunakan foto dari kolom image.

            $productImages = [
                'monday-croissant' => [
                    'url' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=700',
                    'alt' => 'Fresh croissant',
                    'tag' => 'BEST SELLER',
                ],

                'midnight-brownies' => [
                    'url' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=700',
                    'alt' => 'Chocolate cake',
                    'tag' => 'FAN FAVORITE',
                ],

                'strawberry-cloud' => [
                    'url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=700',
                    'alt' => 'Strawberry dessert',
                    'tag' => 'NEW!',
                ],

                'guilty-pleasure-cookies' => [
                    'url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=700',
                    'alt' => 'Chocolate cookies',
                    'tag' => 'MUST TRY',
                ],
            ];
            ?>

            <div class="row g-4">

                <?php if (!empty($products)): ?>

                    <?php foreach ($products as $product): ?>

                        <?php
                        $slug = $product['slug'];

                        $imageInfo = $productImages[$slug] ?? [
                            'url' => 'https://placehold.co/700x500/f9e6e9/c65b75?text=DIET+TOMORROW',
                            'alt' => $product['name'],
                            'tag' => 'FRESHLY BAKED',
                        ];

                        // Gunakan gambar upload admin jika tersedia.
                        if (!empty($product['image'])) {
                            $imageUrl = base_url('uploads/products/' . $product['image']);
                        } else {
                            $imageUrl = $imageInfo['url'];
                        }
                        ?>

                        <div class="col-6 col-lg-3">

                            <div class="product-card">

                                <div class="product-image-wrap">

                                    <img
                                        class="product-image"
                                        src="<?= esc($imageUrl) ?>"
                                        alt="<?= esc($imageInfo['alt']) ?>"
                                    >

                                    <span class="product-tag">
                                        <?= esc($imageInfo['tag']) ?>
                                    </span>

                                </div>

                                <div class="product-info">

                                    <h5>
                                        <?= esc($product['name']) ?>
                                    </h5>

                                    <p>
                                        <?= esc($product['description']) ?>
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <span class="product-price">
                                            Rp <?= number_format((float) $product['price'], 0, ',', '.') ?>
                                        </span>

                                        <form
                                            action="<?= site_url('cart/add/' . $product['id']) ?>"
                                            method="post"
                                        >

                                            <?= csrf_field() ?>

                                            <button
                                                class="add-cart"
                                                type="submit"
                                                aria-label="Add <?= esc($product['name']) ?>"
                                                <?= (int) $product['stock'] <= 0 ? 'disabled' : '' ?>
                                            >+</button>

                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="col-12 text-center py-5">
                        <p class="section-subtitle">
                            No sweet treats available just yet. ♡
                        </p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- OUR STORY -->
    <section class="section pt-0" id="about">
        <div class="container">

            <div class="story">

                <div class="row align-items-center g-4">

                    <div class="col-lg-6">

                        <div class="eyebrow">
                            A LITTLE STORY ABOUT US
                        </div>

                        <h2>
                            Tomorrow can wait.<br>
                            Happiness can't. ♡
                        </h2>

                        <p>
                            At DIET TOMORROW, we believe that life's little
                            moments deserve something sweet. Every treat is
                            made with love, care, and a little sprinkle of joy.
                            Because sometimes, the best plan is simply enjoying
                            your favorite dessert.
                        </p>

                        <a href="#shop" class="btn btn-pink mt-2">
                            FIND YOUR HAPPY TREAT
                        </a>

                    </div>

                    <div class="col-lg-6">

                        <img
                            class="story-image"
                            src="https://images.unsplash.com/photo-1551024506-0bccd828d307?w=1000"
                            alt="Delicious bakery desserts"
                        >

                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">

            <div class="row g-4">

                <div class="col-md-5">

                    <div class="brand">
                        DIET TOMORROW ♡
                    </div>

                    <p class="mt-3">
                        Sweet treats, zero regrets.<br>
                        Made with love, baked for happiness.
                    </p>

                </div>

                <div class="col-md-3">

                    <h6>EXPLORE</h6>

                    <p><a href="#home">Home</a></p>
                    <p><a href="#categories">Categories</a></p>
                    <p><a href="#shop">Our Treats</a></p>

                </div>

                <div class="col-md-4">

                    <h6>STAY SWEET</h6>

                    <p>
                        Follow us for more little moments of happiness.
                    </p>

                    <p>
                        Instagram: @diettommorrow
                    </p>

                </div>

            </div>

            <hr style="border-color:#735c55;">

            <p class="text-center mb-0">
                © 2026 DIET TOMORROW. Baked with love ♡
            </p>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>