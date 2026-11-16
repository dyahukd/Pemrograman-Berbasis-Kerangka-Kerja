<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4 text-gray-800">Tambah Mahasiswa</h1>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/mahasiswa/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>NRP</label>
                <input type="text" name="nrp" class="form-control"
                       value="<?= esc(old('nrp') ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= esc(old('nama') ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc(old('email') ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" class="form-control"
                       value="<?= esc(old('jurusan') ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Angkatan</label>
                <input type="number" name="angkatan" class="form-control"
                       value="<?= esc(old('angkatan') ?? '') ?>"
                       min="1900" max="2100" required>
            </div>

            <div class="form-group">
                <label>Foto Mahasiswa</label>
                <input type="file" name="foto" class="form-control-file" accept="image/*">
                <small class="form-text text-muted">
                    Format: JPG, JPEG, PNG. Maksimal 2 MB.
                </small>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="<?= base_url('admin/mahasiswa') ?>"
               class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>