# ShopEase

ShopEase merupakan aplikasi e-commerce berbasis web yang dikembangkan menggunakan **CodeIgniter 4**. Aplikasi ini menyediakan fitur belanja online, mulai dari melihat katalog produk, mengelola keranjang, melakukan checkout, hingga memantau pesanan.

Aplikasi ini memiliki tiga jenis pengguna, yaitu **Admin**, **Warehouse**, dan **Customer**, dengan fitur yang disesuaikan untuk setiap peran.

## Fitur Utama

- **Customer:** Registrasi, login, melihat produk, mengelola keranjang, checkout, pembayaran, dan melihat status pesanan.
- **Admin:** Mengelola produk dan kategori, memverifikasi pembayaran, serta melihat laporan penjualan.
- **Warehouse:** Mengelola proses pesanan dan pengiriman barang.

## Cara Menjalankan

1. Pastikan **XAMPP (Apache dan MySQL)** serta **Composer** sudah terpasang.
2. Jalankan Apache dan MySQL melalui XAMPP.
3. Buat database dengan nama `shopease` melalui phpMyAdmin.
4. Buka terminal pada folder project `shopease`, kemudian jalankan:

   ```bash
   composer install
   ```

5. Sesuaikan konfigurasi database pada `app/Config/Database.php` jika diperlukan.
6. Jalankan migrasi database:

   ```bash
   php spark migrate
   ```

7. Isi database dengan data awal:

   ```bash
   php spark db:seed ShopEaseSeeder
   ```

8. Jalankan aplikasi:

   ```bash
   php spark serve
   ```

9. Buka aplikasi melalui browser:

   `http://localhost:8080`

## Akun Pengujian

| Role | Email | Password |
|---|---|---|
| Admin | admin@shopease.test | admin123 |
| Warehouse | gudang@shopease.test | gudang123 |
| Customer | budi@mail.test | budi1234 |

**Catatan:** Migrasi dan seeder cukup dijalankan saat pertama kali menyiapkan database. Seeder akan memasukkan data awal untuk keperluan pengujian.
