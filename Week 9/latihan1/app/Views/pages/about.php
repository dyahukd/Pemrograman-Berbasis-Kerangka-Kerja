<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold">About Us</h1>
        <p class="col-md-8 fs-5">
            Selamat datang di aplikasi Latihan 1.
            Aplikasi ini dikembangkan menggunakan
            framework CodeIgniter 4 dan Bootstrap 5.
        </p>
        <a href="/contact" class="btn btn-primary btn-lg">
            Contact Us
        </a>
    </div>
</div>

<?= $this->endSection() ?>