<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Mahasiswa</h1>
    <a href="<?= base_url('admin/mahasiswa/create') ?>"
       class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Mahasiswa
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Mahasiswa
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mahasiswa)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($mahasiswa as $mhs) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?php if (!empty($mhs['foto'])) : ?>
                                        <img src="<?= base_url('admin/mahasiswa/foto/' . rawurlencode($mhs['foto'])) ?>"
                                            alt="Foto Mahasiswa"
                                            width="60"
                                            height="60"
                                            style="object-fit: cover; border-radius: 50%;">
                                    <?php else : ?>
                                        <span class="text-muted">Belum ada foto</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($mhs['nrp']) ?></td>
                                <td><?= esc($mhs['nama']) ?></td>
                                <td><?= esc($mhs['email']) ?></td>
                                <td><?= esc($mhs['jurusan']) ?></td>
                                <td><?= esc($mhs['angkatan']) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/mahasiswa/edit/' . $mhs['id']) ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="<?= base_url('admin/mahasiswa/delete/' . $mhs['id']) ?>"
                                          method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada data mahasiswa.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>