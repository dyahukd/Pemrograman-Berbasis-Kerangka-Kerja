<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fff9f6;
            font-family: 'DM Sans', sans-serif;
            color: #654638;
        }

        h1, h2 {
            font-family: 'Playfair Display', serif;
        }

        .cart-container {
            max-width: 950px;
            margin: 60px auto;
        }

        .cart-item {
            background: white;
            border: 1px solid #f0dfd6;
            border-radius: 15px;
            padding: 22px;
            margin-bottom: 15px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quantity-control button {
            border: 1px solid #e8cfc2;
            background: #fff9f6;
            color: #654638;
            border-radius: 7px;
            width: 32px;
            height: 32px;
            font-weight: bold;
        }

        .quantity-control button:hover {
            background: #f3dfd5;
        }

        .remove-btn {
            border: none;
            background: none;
            color: #b36d6d;
            font-size: 13px;
            padding: 0;
        }

        .summary {
            background: white;
            border: 1px solid #f0dfd6;
            border-radius: 15px;
            padding: 25px;
        }

        .total {
            font-size: 21px;
            font-weight: 800;
        }

        .btn-shop {
            background: #b98270;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 11px 25px;
            text-decoration: none;
        }

        .btn-shop:hover {
            background: #986653;
            color: white;
        }
    </style>
</head>

<body>

<div class="container cart-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Your Shopping Cart ♡</h1>
            <p class="text-muted mb-0">A little sweetness is on its way.</p>
        </div>

        <a href="<?= site_url('/#shop') ?>" class="btn-shop">
            Continue Shopping
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

    <?php if (empty($cart)): ?>

        <div class="text-center bg-white rounded-4 p-5">
            <h2>Your cart is empty</h2>
            <p class="text-muted">Looks like you haven't added any treats yet.</p>

            <a href="<?= site_url('/#shop') ?>" class="btn-shop d-inline-block mt-3">
                Explore Our Treats
            </a>
        </div>

    <?php else: ?>

        <?php $grandTotal = 0; ?>

        <div class="row g-4">

            <div class="col-lg-8">

                <?php foreach ($cart as $id => $item): ?>

                    <?php
                        $subtotal = $item['price'] * $item['quantity'];
                        $grandTotal += $subtotal;
                    ?>

                    <div class="cart-item">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                            <div>
                                <h5 class="fw-bold mb-1">
                                    <?= esc($item['name']) ?>
                                </h5>

                                <p class="text-muted mb-2">
                                    Rp<?= number_format($item['price'], 0, ',', '.') ?>
                                </p>

                                <div class="quantity-control">

                                    <form action="<?= site_url('cart/update/' . $id) ?>" method="post">
                                        <?= csrf_field() ?>

                                        <input type="hidden" name="quantity"
                                            value="<?= $item['quantity'] - 1 ?>">

                                        <button type="submit">−</button>
                                    </form>

                                    <span class="fw-bold">
                                        <?= $item['quantity'] ?>
                                    </span>

                                    <form action="<?= site_url('cart/update/' . $id) ?>" method="post">
                                        <?= csrf_field() ?>

                                        <input type="hidden" name="quantity"
                                            value="<?= $item['quantity'] + 1 ?>">

                                        <button type="submit">+</button>
                                    </form>

                                </div>

                                <form action="<?= site_url('cart/remove/' . $id) ?>"
                                      method="post" class="mt-2">

                                    <?= csrf_field() ?>

                                    <button type="submit" class="remove-btn">
                                        Remove
                                    </button>
                                </form>
                            </div>

                            <div class="fw-bold">
                                Rp<?= number_format($subtotal, 0, ',', '.') ?>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

            <div class="col-lg-4">

                <div class="summary">

                    <h5 class="fw-bold mb-4">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>

                        <span>
                            Rp<?= number_format($grandTotal, 0, ',', '.') ?>
                        </span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between total">
                        <span>Total</span>

                        <span>
                            Rp<?= number_format($grandTotal, 0, ',', '.') ?>
                        </span>
                    </div>

                    <a href="<?= site_url('checkout') ?>"
                    class="btn-shop w-100 mt-4 d-block text-center">
                        Proceed to Checkout ♡
                    </a>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>

</body>
</html>