<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= $adminMode ? 'Admin Login' : 'Login' ?> | DIET TOMORROW
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fff9f6;
            font-family: 'DM Sans', sans-serif;
            color: #654638;
        }

        h1 {
            font-family: 'Playfair Display', serif;
        }

        .auth-card {
            max-width: 460px;
            margin: 85px auto;
            padding: 38px;
            background: white;
            border: 1px solid #f0dfd6;
            border-radius: 18px;
        }

        .form-control {
            padding: 12px;
            border-radius: 10px;
            border-color: #ead7cd;
        }

        .form-control:focus {
            border-color: #c99480;
            box-shadow: 0 0 0 3px rgba(201, 148, 128, 0.15);
        }

        .btn-main {
            background: #b98270;
            color: white;
            border: 0;
            border-radius: 25px;
            padding: 12px;
            font-weight: 700;
        }

        .btn-main:hover {
            background: #986653;
            color: white;
        }

        a {
            color: #a57564;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="auth-card">

        <div class="text-center mb-4">

            <h1>
                <?= $adminMode ? 'Admin Login' : 'Welcome Back ♡' ?>
            </h1>

            <p class="text-muted">
                <?= $adminMode
                    ? 'Access the store administration.'
                    : 'Login to your DIET TOMORROW account.' ?>
            </p>

        </div>

        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>

        <?php endif; ?>

        <!-- Login Form -->
        <form
            action="<?= site_url($adminMode ? 'admin/login' : 'login') ?>"
            method="post"
        >

            <?= csrf_field() ?>

            <div class="mb-3">

                <label class="form-label">Email Address</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email"
                    value="<?= esc(old('email') ?? '') ?>"
                    required
                >

            </div>

            <div class="mb-4">

                <label class="form-label">Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter your password"
                    required
                >

            </div>

            <button type="submit" class="btn btn-main w-100">

                <?= $adminMode
                    ? 'Login to Dashboard'
                    : 'Login ♡' ?>

            </button>

        </form>

        <!-- Register Link -->
        <?php if (!$adminMode): ?>

            <p class="text-center mt-4 mb-0">
                Don't have an account?
                <a href="<?= site_url('register') ?>">
                    Register
                </a>
            </p>

            <p class="text-center mt-3 mb-0">
                Are you an admin?
                <a href="<?= site_url('admin/login') ?>"
                style="color: #c77b8a; font-weight: 600; text-decoration: none;">
                    Admin Login
                </a>
            </p>

        <?php endif; ?>

        <p class="text-center mt-3 mb-0">

            <a href="<?= site_url('/') ?>" class="text-muted">
                Back to Homepage
            </a>

        </p>

    </div>

</div>

</body>
</html>