<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login SIAKAD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eaf0ff, #f8f5ff);
            display: grid;
            place-items: center;
        }

        .login {
            max-width: 430px;
            width: 100%;
            border: 0;
            border-radius: 20px;
            box-shadow: 0 20px 55px #26365d20;
        }

        .brand {
            color: #4056a1;
        }
    </style>
</head>

<body>
    <div class="card login p-4 p-md-5">

        <div class="text-center mb-4">
            <div class="fs-1">🎓</div>
            <h2 class="brand fw-bold">SIAKAD</h2>
            <p class="text-secondary">Sistem Informasi Akademik</p>
        </div>

        <?php if ($e = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc($e) ?>
            </div>
        <?php endif ?>

        <?php if ($s = session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc($s) ?>
            </div>
        <?php endif ?>

        <form method="post" action="<?= site_url('login') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input
                    class="form-control form-control-lg"
                    name="username"
                    value="<?= esc(old('username')) ?>"
                    required
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control form-control-lg"
                    name="password"
                    required
                >
            </div>

            <button class="btn btn-primary btn-lg w-100">
                Masuk
            </button>
        </form>

    </div>
</body>
</html>