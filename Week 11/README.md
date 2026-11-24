# Week 11 - ShopEase

Week 11 merupakan pengembangan lanjutan dari aplikasi **ShopEase** berbasis **CodeIgniter 4**. Pada minggu ini, aplikasi dikembangkan dengan menambahkan sistem autentikasi dan pengelolaan akun untuk meningkatkan keamanan serta pengaturan hak akses pengguna.

Pengembangan ini mencakup tiga jenis pengguna, yaitu **Admin**, **Warehouse**, dan **Customer**, dengan hak akses yang disesuaikan untuk setiap peran.

## Fitur Utama

- **Customer:** Registrasi, login, fitur Remember Me, mengelola profil, mengganti password, melihat riwayat login, dan mengelola perangkat yang digunakan untuk login.
- **Admin:** Mengelola pengguna, mengubah role, membekukan atau mengaktifkan akun, mencabut sesi login pengguna, serta melihat log aktivitas login.
- **Warehouse:** Login dan mengakses fitur aplikasi sesuai dengan hak akses yang diberikan.

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

7. Isi database dengan data awal jika tersedia:

   ```bash
   php spark db:seed ShopEaseSeeder
   ```

8. Jalankan aplikasi:

   ```bash
   php spark serve
   ```

9. Buka aplikasi melalui browser:

   `http://localhost:8080`
