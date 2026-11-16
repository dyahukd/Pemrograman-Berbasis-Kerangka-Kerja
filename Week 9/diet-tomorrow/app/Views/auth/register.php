<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | DIET TOMORROW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { background:#fff9f6; font-family:'DM Sans',sans-serif; color:#654638; }
        h1 { font-family:'Playfair Display',serif; }
        .auth-card { max-width:480px; margin:55px auto; padding:35px; background:white; border:1px solid #f0dfd6; border-radius:18px; }
        .form-control { padding:12px; border-radius:10px; border-color:#ead7cd; }
        .btn-main { background:#b98270; color:white; border:0; border-radius:25px; padding:12px; font-weight:700; }
        .btn-main:hover { background:#986653; color:white; }
    </style>
</head>
<body>
<div class="container">
    <div class="auth-card">
        <div class="text-center mb-4">
            <h1>Create Account ♡</h1>
            <p class="text-muted">Join the DIET TOMORROW family.</p>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('register') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input name="name" class="form-control" value="<?= esc(old('name') ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= esc(old('email') ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input name="phone" class="form-control" value="<?= esc(old('phone') ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" minlength="8" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirm" class="form-control" required>
            </div>

            <button class="btn btn-main w-100">Create Account ♡</button>
        </form>

        <p class="text-center mt-4 mb-0">
            Already have an account?
            <a href="<?= site_url('login') ?>">Login</a>
        </p>
        <p class="text-center mt-3">
            <a href="<?= site_url('/') ?>" class="text-muted">Back to Homepage</a>
        </p>
    </div>
</div>
</body>
</html>