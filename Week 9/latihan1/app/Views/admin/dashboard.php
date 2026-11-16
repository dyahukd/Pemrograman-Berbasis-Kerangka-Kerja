<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<p class="mb-4">
    Selamat datang di Student Management System.
    Halaman ini merupakan dashboard administrator
    yang menggunakan template SB Admin 2.
</p>

<div class="row">

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Mahasiswa
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    120
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Mahasiswa Aktif
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    100
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Program Studi
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    5
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Informasi Aplikasi
        </h6>
    </div>
    <div class="card-body">
        <p class="mb-0">
            Aplikasi ini dikembangkan menggunakan CodeIgniter 4
            dengan template SB Admin 2 untuk tampilan dashboard.
        </p>
    </div>
</div>

<?= $this->endSection() ?>