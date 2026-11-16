SIAKAD - SISTEM INFORMASI AKADEMIK
Framework: CodeIgniter 4.7.6 | PHP 8.2+ | MySQL/MariaDB
============================================================

ISI PAKET
- Project CodeIgniter 4 lengkap, termasuk vendor dan source aplikasi.
- Fitur login dan tiga role: Admin, Dosen, Mahasiswa.
- Migration dan seeder data demo.
- Petunjuk instalasi, akun demo, dan skenario pengujian.

PENTING SEBELUM MENJALANKAN
1. Project menggunakan database bernama `siakad` yang sudah tersedia.
2. Jangan membuat database baru jika database `siakad` sudah ada.
3. Jangan menjalankan `php spark migrate:refresh`, `migrate:rollback`, atau perintah DROP TABLE.
4. Jika project lama sudah memiliki file `.env`, simpan file tersebut. Periksa konfigurasi koneksi database, jangan menimpanya secara sembarangan.

A. MENEMPATKAN PROJECT
1. Buat salinan/backup folder project lama terlebih dahulu.
2. Ekstrak folder `siakad` dari ZIP ke direktori kerja, misalnya `D:\DYAH\siakad`.
3. Pastikan folder `app`, `public`, `vendor`, file `spark`, dan `composer.json` berada di dalam folder project.
4. Jika folder project lama dipakai, gabungkan file aplikasi dari paket ini dan pertahankan `.env` lokal yang sudah benar.

B. KONFIGURASI DATABASE
Pastikan Apache dan MySQL berjalan dari XAMPP.
Buka file `.env` di root project. Jika belum ada, salin file `env` menjadi `.env`.
Pastikan konfigurasi berikut mengarah ke database yang sudah ada:

CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = siakad
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306

Jika MySQL menggunakan password, isi `database.default.password` sesuai konfigurasi lokal.
Pastikan ekstensi PHP `intl`, `mbstring`, dan `mysqli` aktif. Jika `intl` belum aktif pada XAMPP, buka `C:\xampp\php\php.ini`, cari `;extension=intl`, hapus tanda titik koma di depannya, simpan, lalu restart Apache dan buka ulang terminal. Periksa juga `php -m` untuk memastikan `intl`, `mbstring`, dan `mysqli` muncul.

C. MEMBUAT TABEL DAN DATA DEMO
Buka PowerShell pada direktori project:

cd D:\DYAH\siakad

Jalankan migration satu kali untuk membuat tabel aplikasi:

php spark migrate

Kemudian masukkan data demo:

php spark db:seed SiakadSeeder

Seeder otomatis dilewati jika tabel `users` sudah berisi data. Jika tabel aplikasi sudah ada dari instalasi sebelumnya, jangan memaksa migration atau menghapus tabel; periksa status dan struktur tabel terlebih dahulu.

D. MENJALANKAN APLIKASI
Dari direktori project jalankan:

php spark serve --port 8080

Buka browser:
http://localhost:8080

E. AKUN DEMO
Administrator
Username: admin
Password: admin123

Dosen
Username: 0011223301
Password: 0011223301

Mahasiswa
Username: 5025241186
Password: 5025241186

Password setiap akun dapat diganti melalui menu Ganti Password. Password disimpan menggunakan password_hash.

F. FITUR APLIKASI
ADMIN
- Dashboard ringkasan data.
- CRUD data mahasiswa, dosen, dan mata kuliah.
- Pencarian dan pagination sederhana.
- Pembuatan akun mahasiswa/dosen secara otomatis.
- Reset password akun ke NIM/NIDN.
- Upload, preview, penggantian, dan penghapusan foto mahasiswa.
- Validasi foto JPG, PNG, WEBP dengan ukuran maksimal 1 MB.

MAHASISWA
- Dashboard mahasiswa.
- Pengisian KRS semester 2026/2027 Ganjil.
- Batas maksimal 24 SKS dan pemeriksaan kuota kelas.
- Pencegahan pengambilan mata kuliah yang sama.
- Pembatalan KRS milik sendiri yang belum dinilai.
- KHS, IP per semester, IPK, dan transkrip.
- Cetak KRS dan transkrip.

DOSEN
- Dashboard dosen.
- Daftar mata kuliah yang diampu.
- Daftar mahasiswa perwalian.
- Input nilai hanya untuk peserta mata kuliah yang diampu.
- Validasi nilai A, AB, B, BC, C, D, dan E.

UMUM
- Login/logout dan session.
- Pembatasan akses berdasarkan role.
- CSRF protection pada request form.
- Penggantian password dengan verifikasi password lama.

G. ATURAN AKADEMIK
Semester aktif: 2026/2027 Ganjil.
Batas KRS: 24 SKS.
Bobot nilai: A=4, AB=3.5, B=3, BC=2.5, C=2, D=1, E=0.
IP dihitung dari mata kuliah yang telah dinilai pada semester terkait.
IPK dihitung dari seluruh mata kuliah yang telah dinilai.
Untuk mata kuliah yang diulang, transkrip menggunakan nilai terbaik.

H. CHECKLIST PENGUJIAN
1. Login admin dengan akun benar dan salah, lalu logout.
2. Akses halaman admin tanpa login dan menggunakan role selain admin.
3. Tambah, edit, cari, dan hapus data mahasiswa.
4. Uji upload foto valid, file non-gambar, dan foto lebih dari 1 MB.
5. Tambah, edit, hapus dosen, dan reset akun dosen.
6. Tambah, edit, hapus mata kuliah.
7. Pastikan mata kuliah yang sudah dipakai pada KRS tidak dapat dihapus.
8. Login mahasiswa dan lihat dashboard.
9. Ambil mata kuliah, uji duplikasi, kuota penuh, dan batas 24 SKS.
10. Batalkan KRS yang belum dinilai dan pastikan KRS yang sudah dinilai tidak dapat dibatalkan.
11. Periksa KHS, IP, IPK, dan transkrip.
12. Cetak KRS dan transkrip.
13. Login dosen dan periksa mata kuliah yang diampu serta mahasiswa perwalian.
14. Input nilai valid dan uji akses ke mata kuliah dosen lain.
15. Ganti password dengan password lama salah, konfirmasi tidak cocok, dan data valid.

CATATAN PENGUMPULAN
Akun dan data demo disediakan untuk mempermudah pengujian. Sesuaikan data contoh dengan kebutuhan demonstrasi. Lakukan pengujian di komputer lokal sebelum mengambil screenshot dan mengumpulkan project.
