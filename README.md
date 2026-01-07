# RWH - Sistem Manajemen Travel Umrah

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## 📋 Tentang Proyek

**RWH (Sistem Manajemen Travel Umrah)** adalah aplikasi berbasis web komprehensif yang dirancang untuk merampingkan operasional agen perjalanan Umrah. Sistem ini menyediakan platform yang tangguh untuk mengelola Jemaah, jadwal keberangkatan, paket perjalanan, pembayaran, dan validasi dokumen.

Sistem ini dilengkapi dengan dashboard admin modern yang menawarkan wawasan real-time mengenai metrik kinerja utama seperti total jemaah, ringkasan keuangan, dan jadwal keberangkatan mendatang.

### 🌟 Fitur Utama

-   **📈 Dashboard Interaktif**: Analitik visual menggunakan ApexCharts untuk melacak statistik jemaah, pendapatan, dan efektivitas jadwal.
-   **🕋 Manajemen Paket & Jenis Paket**: Pengelolaan fleksibel untuk berbagai jenis paket Umrah (Reguler, Plus, dll).
-   **🗓️ Manajemen Keberangkatan**: Pemantauan kuota, tanggal keberangkatan, dan status pendaftaran secara real-time.
-   **👥 Manajemen Jemaah & Dokumen**:
    -   Profil lengkap jemaah dan manajemen grup/keluarga.
    -   Pelacakan dokumen (Paspor, Visa, Kuning, dll) dengan indikator kelengkapan.
    -   Preview dokumen langsung dari sistem.
-   **💰 Manajemen Keuangan & Cicilan**:
    -   Pencatatan pembayaran transparan dengan fungsionalitas cicilan.
    -   Pembuatan kwitansi dan laporan pendapatan otomatis.
-   **🔔 Notifikasi Sistem**: Notifikasi otomatis untuk pendaftaran baru, pembayaran, dan aktivitas penting lainnya.
-   **⚙️ Pengaturan Aplikasi**: Konfigurasi mandiri untuk identitas perusahaan (Logo, Nama, Alamat, dll).
-   **🛡️ Keamanan & Log**:
    -   Kontrol akses berbasis peran (Admin & Staf).
    -   Autentikasi Dua Faktor (2FA) via Laravel Jetstream.
    -   Log aktivitas lengkap untuk audit sistem.
-   **📂 Backup Data**: Fitur pencadangan database langsung dari dashboard.

---

## 🛠️ Teknologi yang Digunakan

-   **Backend**: [Laravel 10](https://laravel.com/)
-   **Frontend**: Blade Templates, [Bootstrap 4](https://getbootstrap.com/), [Alpine.js](https://alpinejs.dev/)
-   **Autentikasi**: [Laravel Jetstream](https://jetstream.laravel.com/) (Livewire stack)
-   **Database**: MySQL
-   **Template Admin**: Otika Premium Bootstrap Admin Template
-   **Library Kunci**:
    -   `spatie/laravel-activitylog`: Untuk pelacakan jejak audit.
    -   `barryvdh/laravel-dompdf`: Untuk pembuatan laporan PDF.
    -   `phpoffice/phpspreadsheet`: Untuk integrasi laporan Excel.
    -   `livewire/livewire`: Untuk komponen UI reaktif.

---

## 🚀 Memulai (Instalasi Lokal)

### Prasyarat

-   PHP >= 8.1
-   Composer
-   MySQL / MariaDB
-   Node.js & NPM

### Langkah Instalasi

1.  **Clone repositori**

    ```bash
    git clone https://github.com/usernameanda/project-rwh.git
    cd project-rwh
    ```

2.  **Instal Dependensi PHP**

    ```bash
    composer install
    ```

3.  **Instal Dependensi Frontend**

    ```bash
    npm install && npm run build
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:

    ```env
    DB_DATABASE=rwh_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Persiapan Database**

    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```

6.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Buka `http://localhost:8000` di browser Anda.

---

## 📂 Struktur Proyek Utama

-   `app/Http/Controllers`: Logika bisnis (Dashboard, Jemaah, Keuangan, dll).
-   `resources/views`: Antarmuka pengguna (Blade templates).
-   `routes/web.php`: Definisi alur navigasi dan API internal.
-   `public/admin/assets`: Aset UI (CSS kustom, JS, dan Gambar).

## 🛡️ Lisensi

Sistem ini adalah perangkat lunak berpemilik (Proprietary). Penggunaan, modifikasi, atau distribusi tanpa izin tertulis dari pengembang dilarang keras.

---

_Dikembangkan dengan dedikasi untuk efisiensi operasional Travel Umrah._
