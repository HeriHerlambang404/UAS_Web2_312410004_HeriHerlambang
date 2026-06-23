# UAS_Web2_312410004_HeriHerlambang

- Design relation database
  <img width="1231" height="832" alt="Cuplikan layar 2026-06-21 134556" src="https://github.com/user-attachments/assets/420f1190-c9fe-4fec-85a2-20164ab0ae88" />
- Uji coba tembak api Barang-keluar jika token tidak valid
  <img width="1590" height="996" alt="image" src="https://github.com/user-attachments/assets/deb0f84d-107e-48b3-bec9-102bbd82f8da" />
- Uji coba tembak api Barang-keluar jika token valid
  <img width="1592" height="991" alt="image" src="https://github.com/user-attachments/assets/a7778a89-0f14-4887-9991-9b18bc456a6f" />
- UI Landing Page
  <img width="1918" height="1077" alt="image" src="https://github.com/user-attachments/assets/412b28f9-fe3d-4795-86d2-913cdf9a04d8" />
- UI Login Page
  <img width="1918" height="1077" alt="image" src="https://github.com/user-attachments/assets/c1449a6e-1b3a-4bf6-be59-3740dd11259d" />
- UI Dashboard
  <img width="1918" height="1078" alt="image" src="https://github.com/user-attachments/assets/5aef6942-7662-4111-a97d-7928061b5bd2" />
- UI Tabel Kategori
  <img width="1918" height="1078" alt="image" src="https://github.com/user-attachments/assets/9aaa36d8-a5ad-480a-a122-44d014710731" />
- UI Tabel Supplier
  <img width="1918" height="1078" alt="image" src="https://github.com/user-attachments/assets/fa76b371-4acd-4a60-a8b6-daced7ceea9c" />
- UI Data Barang
  <img width="1918" height="1078" alt="image" src="https://github.com/user-attachments/assets/d0328f14-aebb-4b0a-ba58-bc960f055a75" />
- UI Barang Masuk
  <img width="1918" height="1078" alt="image" src="https://github.com/user-attachments/assets/995d936c-d91f-4910-8b43-ec055efc0dff" />
- UI Barang Keluar
  <img width="1918" height="1078" alt="image" src="https://github.com/user-attachments/assets/d607aed6-af54-4b1c-abf6-373b14e747bb" />

- Cara Instalasi dan menjalankan proyek backend
  1. Instalasi Database
      Buka XAMPP Control Panel dan aktifkan Apache serta MySQL.
      Buka phpMyAdmin di browser (http://localhost/phpmyadmin).
      Dan Buat database baru dengan nama db_inventaris
  2. Menjalankan Backend (CodeIgniter 4)
      Buka Terminal dalam folder Backend (Inventaris-Api)
      Lalu Jalankan perintah berikut untuk memulai server API: php spark serve

  Dokumentasi Praktikum Pemrograman Web (Pertemuan 1 - 14)
Repositori ini berisi kumpulan tugas dan implementasi dari Praktikum Pemrograman Web (Pertemuan 1 hingga 14). Proyek ini dibangun menggunakan framework CodeIgniter 4 (CI4) untuk sisi backend (termasuk RESTful API) dan Vue.js (secara standalone) untuk integrasi frontend.

🚀 Teknologi yang Digunakan
Backend: PHP, CodeIgniter 4
Frontend: HTML, CSS, JavaScript, Vue.js
Database: MySQL
Tools: Composer, Spark (CI4 CLI)
📚 Ringkasan Progres Praktikum
Berikut adalah penjelasan tahapan pengembangan sistem dari awal hingga akhir praktikum:

1. Praktikum 1 - 3: Setup & Instalasi Dasar
Pengenalan dan instalasi framework CodeIgniter 4 menggunakan Composer.
Pemahaman struktur direktori CI4 (seperti app/, public/, writable/).
Konfigurasi awal sistem pada file .env dan app/Config/Paths.php untuk environment development.
Menjalankan local development server menggunakan perintah php spark serve.
2. Praktikum 4 - 5: Konsep MVC (Model-View-Controller) Dasar
Pengenalan konsep Routing (app/Config/Routes.php) untuk memetakan URL ke fungsi tertentu.
Pembuatan Controller dasar (Home.php, Artikel.php) untuk mengatur alur logika aplikasi.
Pembuatan Views (welcome_message.php, layout dasar) untuk menampilkan antarmuka web kepada pengguna.
3. Praktikum 6 - 7: Database, Migrations, dan Models
Konfigurasi koneksi database MySQL di file .env.
Penggunaan CI4 Migrations untuk version control database.
Membuat tabel user (2026-06-22-000003_CreateUserTable.php).
Membuat tabel kategori (2026-06-22-000001_CreateKategoriTable.php).
Memperbarui struktur tabel artikel (2026-06-22-000002_UpdateArtikelForKategoriAndUpload.php).
Penggunaan Seeders (PraktikumSeeder.php) untuk mengisi data awal (dummy data) ke dalam database.
Pembuatan Models (ArtikelModel.php, UserModel.php, KategoriModel.php) untuk berinteraksi dengan tabel-tabel di database.
4. Praktikum 8 - 9: Operasi CRUD (Create, Read, Update, Delete)
Implementasi antarmuka halaman admin untuk mengelola artikel.
Pembuatan form tambah artikel (form_add.php) dan edit artikel (form_edit.php).
Validasi input pengguna dan penanganan proses upload file/gambar untuk artikel.
Menampilkan data secara dinamis dari database ke halaman detail artikel (detail.php) dan halaman index (admin_index.php).
5. Praktikum 10 - 11: Sistem Autentikasi (Login)
Pembuatan sistem autentikasi sederhana menggunakan sistem Session bawaan CodeIgniter.
Pembuatan halaman login (login.php) dan controller User.php.
Membatasi akses halaman admin agar hanya bisa diakses oleh user yang sudah berhasil login (Proteksi Route).
6. Praktikum 12: Implementasi AJAX Request
Pengenalan konsep Asynchronous JavaScript and XML (AJAX).
Pembuatan controller khusus AjaxController.php untuk merespons request AJAX.
Membangun view (ajax/index.php) yang dapat memuat data secara dinamis tanpa melakukan reload halaman utuh.
7. Praktikum 13: Pembuatan RESTful API & Token Auth
Mengekspos data artikel agar bisa dikonsumsi oleh aplikasi eksternal (Frontend/Mobile).
Pembuatan API endpoint pada Api/Auth.php.
Implementasi keamanan API berbasis Token/JWT menggunakan Filter ApiAuthFilter.php untuk memastikan hanya permintaan terautentikasi yang diizinkan mengambil atau mengubah data.
8. Praktikum 14: Integrasi Frontend dengan Vue.js
Memisahkan frontend dari backend (konsep Headless / API-driven).
Pembuatan antarmuka pengguna interaktif menggunakan Vue.js (berada di folder lab8_vuejs/).
Membangun Single Page Application (SPA) dengan komponen fungsional seperti:
Home.js: Halaman utama.
Artikel.js: Komponen untuk fetch dan menampilkan data artikel dari API CI4.
Login.js: Komponen antarmuka login yang terhubung ke sistem token CI4.
About.js: Halaman profil/informasi.


