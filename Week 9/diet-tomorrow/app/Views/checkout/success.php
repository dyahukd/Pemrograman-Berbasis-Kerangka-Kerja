<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful | DIET TOMORROW</title>

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

        .success-card {
            max-width: 650px;
            margin: 70px auto;
            padding: 45px;
            background: white;
            border: 1px solid #f0dfd6;
            border-radius: 20px;
        }

        .success-icon {
            font-size: 55px;
            color: #b98270;
        }

        .order-item {
            border-bottom: 1px solid #f1e6e0;
            padding: 12px 0;
        }

        .btn-home {
            display: inline-block;
            background: #b98270;
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 700;
        }

        .btn-home:hover {
            background: #986653;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="success-card text-center">

        <div class="success-icon">♡</div>

        <h1 class="mt-3">Order Placed!</h1>

        <p class="text-muted">
            Thank you for choosing DIET TOMORROW.
            Your sweet treats are on their way!
        </p>

        <hr>

        <div class="text-start my-4">

            <p>
                <strong>Order ID:</strong>
                #<?= esc($order['id']) ?>
            </p>

            <p>
                <strong>Customer:</strong>
                <?= esc($order['customer_name']) ?>
            </p>

            <p>
                <strong>Phone:</strong>
                <?= esc($order['phone']) ?>
            </p>

            <p>
                <strong>Address:</strong>
                <?= esc($order['address']) ?>
            </p>

            <p>
                <strong>Status:</strong>
                <span class="badge bg-warning text-dark">
                    <?= esc(ucfirst($order['status'])) ?>
                </span>
            </p>

            <hr>

            <h5 class="mb-3">Order Summary</h5>

            <?php foreach ($items as $item): ?>
                <div class="order-item d-flex justify-content-between gap-3">
                    <span>
                        <?= esc($item['product_name']) ?>
                        × <?= esc($item['quantity']) ?>
                    </span>

                    <strong>
                        Rp<?= number_format($item['subtotal'], 0, ',', '.') ?>
                    </strong>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between mt-4 fs-5 fw-bold">
                <span>Total</span>

                <span>
                    Rp<?= number_format($order['total_amount'], 0, ',', '.') ?>
                </span>
            </div>

        </div>

        <a href="<?= site_url('/') ?>" class="btn-home mt-3">
            Back to Homepage ♡
        </a>

    </div>

</div>

</body>
</html>