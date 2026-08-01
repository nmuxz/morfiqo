<div align="center">
  <h1>Morfiqo - Smart Sizing E-Commerce API</h1>
  <p>Headless E-Commerce Backend dengan Mesin Rekomendasi Ukuran Berbasis Data (Data-Driven).</p>
</div>

## 📖 Tentang Proyek Ini

**Morfiqo** adalah sistem *backend* *e-commerce* modern yang dibangun sebagai proyek portofolio. Proyek ini memecahkan salah satu masalah utama dalam ritel *fashion online*: **tingkat pengembalian barang (retur) yang tinggi akibat ukuran yang tidak pas**. 

Daripada mengandalkan aset uji coba (*virtual try-on*) 3D yang mahal dan rumit—yang mana sebagian besar UMKM/toko menengah ke bawah tidak mampu membuatnya—Morfiqo menggunakan **Algoritma Smart Sizing**. Pelanggan cukup memasukkan ukuran tubuh mereka, toko memasukkan *size chart* standar mereka dalam sentimeter, dan sistem *backend* akan mengkalkulasi kecocokan terbaik secara otomatis.

### 🚀 Fitur Unggulan

*   **Smart Size Recommendation Engine**: Endpoint algoritmik yang mencocokkan profil tubuh pelanggan (tinggi, berat, lingkar dada) dengan dimensi produk secara akurat.
*   **Role-Based Access Control (RBAC)**: Otentikasi multi-peran yang aman (Super Admin, Pemilik Toko, Pelanggan) menggunakan modul Spatie.
*   **Headless API Architecture**: 100% JSON RESTful API, siap dikonsumsi oleh aplikasi Frontend apa pun (React, Vue, atau aplikasi Mobile).
*   **API Authentication**: Keamanan berbasis token menggunakan Laravel Sanctum.
*   **Auto-Generated API Docs**: Terintegrasi penuh dengan Dedoc Scramble untuk menghasilkan dokumentasi API otomatis (Swagger/OpenAPI).

### 🛠️ Teknologi yang Digunakan

*   **Framework**: Laravel 11 (PHP 8.2+)
*   **Database**: PostgreSQL
*   **Auth & Roles**: Laravel Sanctum & Spatie Laravel-Permission
*   **Dokumentasi API**: Dedoc Scramble

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
4.  **Jalankan Migrations & Seeders**
    Langkah ini akan membuat tabel di database, mengatur struktur *Role*, dan memasukkan data bohongan (katalog produk, *size charts*, dan *user* untuk pengujian).
    ```sh
    php artisan migrate:fresh --seed --seeder=MorfiqoTestSeeder
    ```
5.  **Jalankan Server Aplikasi**
    ```sh
    php artisan serve
    ```

---

## 🔍 Pengujian API (Melalui Postman)

Database *seeder* secara otomatis telah membuat *user* pengujian berikut. Semua *user* menggunakan `password` sebagai kata sandinya.

| Peran (Role) | Email |
| :--- | :--- |
| **Super Admin** | `admin@morfiqo.com` |
| **Pemilik Toko** | `owner@morfiqo.com` |
| **Pelanggan (Budi)**| `budi@example.com` |

### 1. Dapatkan Token Akses (Login)
Kirim *request* `POST` ke `/api/login` menggunakan kredensial pelanggan untuk mendapatkan `access_token`.
```json
// POST http://localhost:8000/api/login
{
    "email": "budi@example.com",
    "password": "password"
}
```

### 2. Tes Rekomendasi Ukuran (Smart Sizing)
Kirim *request* `GET` ke *endpoint* rekomendasi menggunakan token yang telah Anda dapatkan di langkah 1.
```http
GET /api/products/1/recommend-size?profile_id=1
Authorization: Bearer {token_akses_anda}
Accept: application/json
```

**Ekspektasi Respons (JSON):**
```json
{
    "recommended_size": "L",
    "confidence_score": "85%",
    "fit_details": {
        "chest": "Pas / Regular",
        "overall": "Cocok berdasarkan lingkar dada Anda."
    },
    "message": "Berdasarkan profil tubuh Anda, L adalah pilihan terbaik.",
    "product_id": 1
}

