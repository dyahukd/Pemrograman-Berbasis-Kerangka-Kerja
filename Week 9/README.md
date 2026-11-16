# Week 9 – Proyek CodeIgniter 4

Folder ini berisi tiga proyek aplikasi web yang dikembangkan menggunakan **CodeIgniter 4** sebagai bagian dari mata kuliah Pemrograman Berbasis Kerangka Kerja.

## Daftar Proyek

### 1. Latihan 1 – Pengelolaan Data Mahasiswa

Aplikasi pengelolaan data mahasiswa yang dikembangkan untuk menerapkan konsep dasar CodeIgniter 4, mulai dari konfigurasi framework, routing, controller, penggunaan template, hingga pengelolaan database dan autentikasi.

**Fitur Utama:**
- Halaman About dan Contact menggunakan Bootstrap
- Dashboard admin menggunakan template SB Admin 2
- Pengelolaan data mahasiswa (CRUD)
- Unggah dan pengelolaan foto mahasiswa
- Login dan logout administrator
- Pembatasan akses halaman admin menggunakan session dan authentication filter

### 2. DIET TOMORROW – Toko Roti Online

Aplikasi toko roti online yang memungkinkan pelanggan melihat katalog produk, mencari produk, menambahkan produk ke keranjang, dan melakukan pemesanan. Aplikasi ini juga menyediakan dashboard admin untuk mengelola produk dan pesanan pelanggan.

**Fitur Utama:**
- Registrasi dan login pelanggan
- Katalog produk, pencarian, dan filter kategori
- Keranjang belanja dan checkout
- Riwayat pesanan
- Dashboard admin dan pengelolaan produk
- Pengelolaan pesanan

### 3. SIAKAD – Sistem Informasi Akademik

Aplikasi sistem informasi akademik berbasis web yang dirancang untuk mengelola aktivitas dan informasi akademik dalam suatu institusi pendidikan.

**Fitur Utama:**
- Login berdasarkan peran Admin, Dosen, dan Mahasiswa
- Dashboard admin
- Pengelolaan data mahasiswa, dosen, dan mata kuliah
- Pengisian Kartu Rencana Studi (KRS)
- Halaman hasil studi (KHS) dan transkrip nilai

## Teknologi yang Digunakan

- PHP
- CodeIgniter 4
- MySQL
- HTML, CSS, dan JavaScript
- Bootstrap

## Cara Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan masing-masing proyek.

### 1. Persiapan

1. Clone atau unduh repository ini.
2. Buka folder proyek yang ingin dijalankan melalui terminal.
3. Instal dependensi menggunakan perintah:

   ```bash
   composer install
   ```

4. Salin file `env` menjadi `.env`, kemudian sesuaikan konfigurasi database.
5. Buat database MySQL sesuai dengan konfigurasi pada masing-masing proyek.

### 2. Menjalankan Latihan 1

Masuk ke folder `Week 9/latihan1`, kemudian jalankan:

```bash
php spark migrate
php spark db:seed UserSeeder
php spark serve --port 8000
```

Buka aplikasi melalui browser:

`http://localhost:8000`

### 3. Menjalankan DIET TOMORROW

Masuk ke folder `Week 9/diet-tomorrow`, kemudian jalankan migrasi dan seeder yang diperlukan:

```bash
php spark migrate
php spark db:seed AdminSeeder
php spark db:seed ProductSeeder
php spark serve
```

Buka aplikasi melalui browser:

`http://localhost:8080`

### 4. Menjalankan SIAKAD

Masuk ke folder `Week 9/siakad`, kemudian jalankan:

```bash
php spark migrate
php spark db:seed SiakadSeeder
php spark serve
```

Buka aplikasi melalui browser:

`http://localhost:8080`

**Catatan:** Pastikan PHP, Composer, dan MySQL sudah terpasang dan berjalan sebelum menjalankan aplikasi. Sesuaikan konfigurasi database pada file `.env` masing-masing proyek. Perintah seeder dan konfigurasi port dapat disesuaikan dengan implementasi setiap aplikasi.
