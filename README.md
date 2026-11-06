# 🚀 POS Digital & Analytics Dashboard

![Laravel](https://img.shields.io/badge/Laravel-13.40-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-blue?style=flat-square&logo=php)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green.svg)

**POS Digital & Analytics Dashboard** adalah aplikasi Point of Sale (Kasir) *full-stack* berbasis web yang dilengkapi dengan *Executive Analytics Dashboard*. Proyek ini dibangun menggunakan **Laravel 13**, **Tailwind CSS**, dan **Chart.js** dengan menerapkan arsitektur *API-first*, penanganan transaksi stok yang aman (*atomic transaction*), serta visualisasi pendapatan secara *real-time*.

---

## ✨ Fitur Utama & Keunggulan Arsitektur

* **🔒 Atomic Transactions & Anti-Race Condition**: Memanfaatkan transaksi database Laravel dengan mekanisme `lockForUpdate()` untuk menjamin integritas stok barang saat checkout berlangsung secara bersamaan.
* **📊 Executive Analytics Dashboard**: Ringkasan metrik eksekutif dan visualisasi grafik tren pendapatan bulanan yang dinamis menggunakan **Chart.js** dan agregasi kueri Eloquent.
* **🔌 Arsitektur API-First**: Dilengkapi *endpoint* RESTful API yang disiapkan untuk integrasi perangkat kasir *mobile* atau tablet (diamankan dengan **Laravel Sanctum**).
* **⚙️ Kalkulasi Bisnis Dinamis**: Perhitungan otomatis subtotal, fleksibilitas diskon transaksi, dan pajak (PPN 11%).
* **💻 Antarmuka Modern & Responsif**: Tampilan UI/UX yang bersih dan interaktif menggunakan **Tailwind CSS** dan **Alpine.js**.

---

## 🛠️ Stack Teknologi

* **Backend**: PHP 8.4, Laravel 13, Eloquent ORM
* **Database**: MySQL / MariaDB
* **Frontend**: Blade Templates, Tailwind CSS (CDN), Alpine.js, Chart.js
* **Keamanan & Arsitektur**: Service-Layer Pattern, Database Transactions (`lockForUpdate`), Laravel Sanctum

---

## 📁 Struktur Proyek & Pola Arsitektur

Proyek ini menerapkan **Service-Layer Pattern** untuk menjaga *controller* tetap bersih (*lean controller*) dan memisahkan logika bisnis agar lebih aman serta mudah dipelihara:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── OrderController.php  # Menangani endpoint checkout RESTful API
│   │   └── DashboardController.php   # Menangani metrik & analitik dashboard
├── Models/
│   ├── Order.php                     # Model Eloquent pesanan & relasi
│   ├── OrderItem.php                 # Relasi detail barang pesanan
│   └── Product.php                   # Model produk & manajemen stok
└── Services/
    └── OrderService.php              # Logika bisnis inti & transaksi atomik stok