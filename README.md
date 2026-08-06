<div align="center">
  <h1>Morfiqo - Full-Stack Smart Sizing E-Commerce</h1>
  <p>Platform E-Commerce Inovatif dengan Mesin Rekomendasi Ukuran Cerdas Berbasis Data (Data-Driven).</p>
</div>

## 📖 Tentang Proyek Ini

**Morfiqo** adalah platform *e-commerce full-stack* modern yang dibangun untuk memecahkan salah satu masalah terbesar dalam ritel *fashion online*: **tingkat pengembalian barang (retur) yang tinggi akibat ukuran pakaian yang tidak pas**. 

Daripada mengandalkan fitur coba virtual (*virtual try-on*) 3D yang mahal dan rumit untuk UMKM, Morfiqo menggunakan **Algoritma Smart Sizing**. Pelanggan dapat memasukkan dan memperbarui profil tubuh mereka (tinggi, berat, lingkar dada), sementara pemilik toko memasukkan *size chart* dalam sentimeter. Sistem kami kemudian akan menghitung kecocokan terbaik dan memberikan rekomendasi ukuran secara presisi.

### 🚀 Fitur Unggulan

*   **Smart Size AI Engine**: Sistem cerdas yang mengkalkulasi selisih dimensi pakaian dengan profil pelanggan untuk mencari kecocokan sempurna (Slim Fit, Regular, atau Oversize).
*   **Role-Based Access Control (RBAC)**: Tiga tingkat peran pengguna yang dikelola secara ketat:
    *   **Super Admin**: Memiliki *Dashboard* khusus untuk memantau metrik keseluruhan (pengguna, toko, dan pergerakan transaksi).
    *   **Pemilik Toko (Seller)**: Bisa mengelola etalase produk, mengunggah foto baju, menambah variasi ukuran, dan melacak pesanan masuk.
    *   **Pelanggan (Customer)**: Memiliki manajemen keranjang belanja, proses *checkout*, manajemen profil tubuh, dan riwayat pesanan.
*   **Manajemen Media**: Mendukung unggahan (*upload*) foto produk dengan tampilan antarmuka yang menarik.
*   **Sistem Ulasan (Reviews)**: Pelanggan dapat memberikan *rating* Bintang 1-5 setelah pesanan berstatus *Delivered* (Selesai).

### 🛠️ Teknologi yang Digunakan

*   **Framework**: Laravel 11 (PHP 8.2+) dengan antarmuka Blade
*   **Styling**: Tailwind CSS (melalui CDN) dan Alpine.js
*   **Database**: PostgreSQL
*   **Auth & Roles**: Laravel Breeze/Jetstream & Spatie Laravel-Permission

---

## 💻 Cara Menggunakan (Getting Started)

Ikuti petunjuk di bawah ini untuk menjalankan proyek secara lokal di komputer Anda.

### Prasyarat (Prerequisites)
*   PHP >= 8.2
*   Composer
*   PostgreSQL Server

### Instalasi

1.  **Clone repository ini**
    ```sh
    git clone https://github.com/username-anda/morfiqo.git
    cd morfiqo
    ```
2.  **Install dependensi PHP**
    ```sh
    composer install
    ```
3.  **Pengaturan Environment**
    Salin file `.env.example` menjadi `.env` dan konfigurasikan kredensial database PostgreSQL Anda.
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```
    *Pastikan Anda mengubah `DB_CONNECTION=pgsql` dan menyesuaikan nama databasenya.*
4.  **Konfigurasi Penyimpanan Media**
    Hubungkan folder *storage* agar foto produk dapat diakses secara publik:
    ```sh
    php artisan storage:link
    ```
5.  **Jalankan Migrations & Seeders**
    Langkah ini akan membuat tabel di database, mengatur struktur *Role*, dan memasukkan data dasar (akun admin).
    ```sh
    php artisan migrate:fresh --seed
    ```
6.  **Jalankan Server Aplikasi**
    ```sh
    php artisan serve
    ```
7.  **Akses Aplikasi**
    Buka `http://localhost:8000` di *browser* Anda.

---

## 🔍 Kredensial Akses Awal

Sistem ini memiliki *database seeder* (`AdminSeeder.php`) yang secara otomatis membuat satu akun **Super Admin** bawaan.

| Peran (Role) | Email | Password |
| :--- | :--- | :--- |
| **Super Admin** | `admin@morfiqo.com` | `password` |

- Untuk **Pemilik Toko** atau **Pembeli**, Anda dapat langsung mendaftar (*Register*) melalui halaman web. Anda akan otomatis diberikan *role* sesuai dengan jalur pendaftaran yang dipilih.
- Login menggunakan akun `admin@morfiqo.com` akan otomatis mengarahkan Anda ke Pusat Kendali (Admin Panel).

## 📌 Alur Kerja Utama (Workflow)

1. **Registrasi Penjual**: Buat akun sebagai penjual dan isi nama toko Anda. Anda akan langsung masuk ke *Seller Dashboard*.
2. **Manajemen Produk**: Tambahkan produk baru beserta foto baju dan deskripsinya.
3. **Manajemen Ukuran**: Pada halaman Edit Produk, masukkan *Size Chart* produk Anda.
4. **Registrasi Pembeli**: Buat akun pembeli dan lengkapi profil ukuran tubuh Anda (tinggi, berat, lingkar).
5. **Katalog & Smart Sizing**: Jelajahi beranda. Saat mengeklik suatu produk, gunakan fitur **Smart Sizing AI** untuk melihat rekomendasi ukuran baju yang pas untuk tubuh Anda.
6. **Checkout & Pesanan**: Tambahkan ke keranjang, dan lakukan simulasi pembayaran.
7. **Penyelesaian Transaksi & Ulasan**: Penjual mengubah status pesanan dari "Menunggu" menjadi "Dikirim" dan "Selesai" (Delivered). Pembeli kemudian dapat memberikan ulasan produk di menu Pesanan.
