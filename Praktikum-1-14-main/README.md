# Dokumentasi Praktikum Pemrograman Web (Pertemuan 1 - 14)

Repositori ini berisi kumpulan tugas dan implementasi dari Praktikum Pemrograman Web (Pertemuan 1 hingga 14). Proyek ini dibangun menggunakan framework **CodeIgniter 4 (CI4)** untuk sisi *backend* (termasuk RESTful API) dan **Vue.js** (secara *standalone*) untuk integrasi *frontend*.

##  Teknologi yang Digunakan
* **Backend:** PHP, CodeIgniter 4
* **Frontend:** HTML, CSS, JavaScript, Vue.js
* **Database:** MySQL
* **Tools:** Composer, Spark (CI4 CLI)

---

##  Ringkasan Progres Praktikum

Berikut adalah penjelasan tahapan pengembangan sistem dari awal hingga akhir praktikum:

### Praktikum 1 - 3: Setup & Instalasi Dasar
* Pengenalan dan instalasi framework **CodeIgniter 4** menggunakan Composer.
* Pemahaman struktur direktori CI4 (seperti `app/`, `public/`, `writable/`).
* Konfigurasi awal sistem pada file `.env` dan `app/Config/Paths.php` untuk environment *development*.
* Menjalankan local development server menggunakan perintah `php spark serve`.

### Praktikum 4 - 5: Konsep MVC (Model-View-Controller) Dasar
* Pengenalan konsep *Routing* (`app/Config/Routes.php`) untuk memetakan URL ke fungsi tertentu.
* Pembuatan **Controller** dasar (`Home.php`, `Artikel.php`) untuk mengatur alur logika aplikasi.
* Pembuatan **Views** (`welcome_message.php`, layout dasar) untuk menampilkan antarmuka web kepada pengguna.

### Praktikum 6 - 7: Database, Migrations, dan Models
* Konfigurasi koneksi database MySQL di file `.env`.
* Penggunaan CI4 **Migrations** untuk *version control* database.
    * Membuat tabel `user` (`2026-06-22-000003_CreateUserTable.php`).
    * Membuat tabel `kategori` (`2026-06-22-000001_CreateKategoriTable.php`).
    * Memperbarui struktur tabel `artikel` (`2026-06-22-000002_UpdateArtikelForKategoriAndUpload.php`).
* Penggunaan **Seeders** (`PraktikumSeeder.php`) untuk mengisi data awal (dummy data) ke dalam database.
* Pembuatan **Models** (`ArtikelModel.php`, `UserModel.php`, `KategoriModel.php`) untuk berinteraksi dengan tabel-tabel di database.

### Praktikum 8 - 9: Operasi CRUD (Create, Read, Update, Delete)
* Implementasi antarmuka halaman admin untuk mengelola artikel.
* Pembuatan *form* tambah artikel (`form_add.php`) dan edit artikel (`form_edit.php`).
* Validasi input pengguna dan penanganan proses *upload* file/gambar untuk artikel.
* Menampilkan data secara dinamis dari database ke halaman detail artikel (`detail.php`) dan halaman index (`admin_index.php`).

### Praktikum 10 - 11: Sistem Autentikasi (Login)
* Pembuatan sistem autentikasi sederhana menggunakan sistem *Session* bawaan CodeIgniter.
* Pembuatan halaman login (`login.php`) dan controller `User.php`.
* Membatasi akses halaman admin agar hanya bisa diakses oleh *user* yang sudah berhasil *login* (Proteksi *Route*).

### Praktikum 12: Implementasi AJAX Request
* Pengenalan konsep *Asynchronous JavaScript and XML* (AJAX).
* Pembuatan controller khusus `AjaxController.php` untuk merespons *request* AJAX.
* Membangun view (`ajax/index.php`) yang dapat memuat data secara dinamis tanpa melakukan *reload* halaman utuh.

### Praktikum 13: Pembuatan RESTful API & Token Auth
* Mengekspos data artikel agar bisa dikonsumsi oleh aplikasi eksternal (Frontend/Mobile).
* Pembuatan API endpoint pada `Api/Auth.php`.
* Implementasi keamanan API berbasis Token/JWT menggunakan Filter `ApiAuthFilter.php` untuk memastikan hanya permintaan terautentikasi yang diizinkan mengambil atau mengubah data.

### Praktikum 14: Integrasi Frontend dengan Vue.js
* Memisahkan *frontend* dari *backend* (konsep *Headless* / API-driven).
* Pembuatan antarmuka pengguna interaktif menggunakan **Vue.js** (berada di folder `lab8_vuejs/`).
* Membangun *Single Page Application* (SPA) dengan komponen fungsional seperti:
    * `Home.js`: Halaman utama.
    * `Artikel.js`: Komponen untuk *fetch* dan menampilkan data artikel dari API CI4.
    * `Login.js`: Komponen antarmuka login yang terhubung ke sistem token CI4.
    * `About.js`: Halaman profil/informasi.

---

## 🛠️ Cara Menjalankan Proyek

### 1. Persiapan Backend (CodeIgniter 4)
1. Buka terminal di direktori root aplikasi.
2. Jalankan `composer install` untuk mengunduh *dependencies*.
3. Salin file `env` menjadi `.env` dan konfigurasikan bagian database:
   ```env
   database.default.hostname = localhost
   database.default.database = nama_database_kamu
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi


### Jalankan migrasi database dan seeding data awal:

    php spark migrate
    php spark db:seed PraktikumSeeder

### Jalankan server lokal CI4:

    php spark serve

```
Aplikasi backend akan berjalan di http://localhost:8080
```

### 2. Persiapan Frontend (Vue.js)

1.  Buka folder lab8_vuejs.

2.  Buka file index.html menggunakan browser atau ekstensi seperti Live Server di VS Code / Editor.

3.  Pastikan konfigurasi URL endpoint API pada assets/js/app.js sudah mengarah dengan benar ke server CI4 lokal kamu  (biasanya http://localhost:8080).
