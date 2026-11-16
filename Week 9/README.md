# Week 9 – Proyek CodeIgniter 4

Folder ini berisi dua proyek aplikasi web yang dikembangkan menggunakan **CodeIgniter 4** sebagai bagian dari mata kuliah Pemrograman Berbasis Kerangka Kerja.

## Daftar Proyek

### 1. DIET TOMORROW – Toko Roti Online

Aplikasi toko roti online yang memungkinkan pelanggan melihat katalog produk, mencari produk, menambahkan produk ke keranjang, dan melakukan pemesanan. Aplikasi ini juga menyediakan dashboard admin untuk mengelola produk dan pesanan pelanggan.

**Fitur Utama:**
- Registrasi dan login pelanggan
- Katalog produk, pencarian, dan filter kategori
- Keranjang belanja dan checkout
- Riwayat pesanan
- Dashboard admin dan pengelolaan produk
- Pengelolaan pesanan

### 2. SIAKAD – Sistem Informasi Akademik

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

Ikuti langkah-langkah berikut untuk menjalankan masing-masing proyek:

1. Clone atau unduh repository ini.
2. Buka folder proyek yang ingin dijalankan (`diet-tomorrow` atau `siakad`) melalui terminal.
3. Instal dependensi dengan perintah:

   ```bash
   composer install
   ```

4. Salin file `env` menjadi `.env`, kemudian sesuaikan konfigurasi database.
5. Buat database MySQL sesuai dengan konfigurasi proyek.
6. Jalankan migrasi database dan seeder:

   ```bash
   php spark migrate
   php spark db:seed AdminSeeder
   ```

   Untuk SIAKAD, gunakan:

   ```bash
   php spark db:seed SiakadSeeder
   ```

   Untuk DIET TOMORROW, jalankan seeder produk jika diperlukan:

   ```bash
   php spark db:seed ProductSeeder
   ```

7. Jalankan server pengembangan:

   ```bash
   php spark serve
   ```

8. Buka aplikasi melalui browser:

   `http://localhost:8080`

**Catatan:** Pastikan PHP, Composer, dan MySQL sudah terpasang dan berjalan sebelum menjalankan aplikasi. Konfigurasi database dan seeder yang tersedia dapat berbeda pada setiap proyek.
