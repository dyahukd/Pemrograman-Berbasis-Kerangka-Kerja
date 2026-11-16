<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout | DIET TOMORROW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fff9f6;
            font-family: 'DM Sans', sans-serif;
            color: #654638;
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }

        .checkout-container {
            max-width: 1050px;
            margin: 55px auto;
        }

        .checkout-card {
            background: white;
            border: 1px solid #f0dfd6;
            border-radius: 18px;
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ead7cd;
            border-radius: 10px;
            padding: 12px 14px;
            color: #654638;
        }

        .form-control:focus {
            border-color: #c99480;
            box-shadow: 0 0 0 3px rgba(201, 148, 128, 0.15);
        }

        .summary-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1e6e0;
        }

        .total {
            font-size: 21px;
            font-weight: 800;
        }

        .btn-order {
            background: #b98270;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 13px 20px;
            font-weight: 700;
        }

        .btn-order:hover {
            background: #986653;
            color: white;
        }

        .back-link {
            color: #987363;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            color: #654638;
        }
    </style>
</head>

<body>

<div class="container checkout-container">

    <a href="<?= site_url('cart') ?>" class="back-link">
        ← Back to Cart
    </a>

    <div class="text-center my-4">
        <h1>Almost Yours ♡</h1>
        <p class="text-muted">
            Just a few more details before your sweet treats arrive.
        </p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('checkout/place-order') ?>" method="post">

        <?= csrf_field() ?>

        <div class="row g-4">

            <!-- Customer Information -->
            <div class="col-lg-7">

                <div class="checkout-card">

                    <h3 class="mb-4">Delivery Information</h3>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>

                        <input
                            type="text"
                            name="customer_name"
                            class="form-control"
                            placeholder="Enter your full name"
                            value="<?= esc(old('customer_name') ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>

                        <input
                            type="tel"
                            name="phone"
                            class="form-control"
                            placeholder="e.g. 081234567890"
                            value="<?= esc(old('phone') ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>

                        <textarea
                            name="address"
                            class="form-control"
                            rows="4"
                            placeholder="Enter your complete delivery address"
                            required
                        ><?= esc(old('address') ?? '') ?></textarea>
                    </div>

                </div>

            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">

                <div class="checkout-card">

                    <h3 class="mb-3">Your Order</h3>

                    <?php foreach ($cart as $item): ?>

                        <div class="summary-item">

                            <div class="d-flex justify-content-between gap-3">

                                <div>
                                    <div class="fw-bold">
                                        <?= esc($item['name']) ?>
                                    </div>

                                    <small class="text-muted">
                                        Qty: <?= $item['quantity'] ?>
                                    </small>
                                </div>

                                <div class="fw-semibold text-nowrap">
                                    Rp<?= number_format(
                                        $item['price'] * $item['quantity'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>
                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                    <div class="d-flex justify-content-between mt-4 mb-3">
                        <span class="text-muted">Subtotal</span>

                        <span>
                            Rp<?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between total">
                        <span>Total</span>

                        <span>
                            Rp<?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-order w-100 mt-4">
                        Place Order ♡
                    </button>

                    <p class="text-muted text-center small mt-3 mb-0">
                        Thank you for choosing DIET TOMORROW!
                    </p>

                </div>

            </div>

        </div>

    </form>

</div>

</body>
</html>