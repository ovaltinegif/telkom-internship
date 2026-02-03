# Telkom Internship Management System

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

Sistem Manajemen Magang (Internship Management System) adalah aplikasi berbasis web yang dibangun menggunakan **Laravel 12** untuk mengelola kegiatan magang di Telkom Witel Semarang. Aplikasi ini memfasilitasi pencatatan logbook harian, absensi, hingga penilaian akhir mahasiswa oleh mentor.

## 🚀 Fitur Utama

Aplikasi ini menggunakan sistem *Role-Based Access Control* (RBAC) dengan tiga peran utama:

* **Mahasiswa (Student)**
    * Melakukan absensi masuk (*check-in*) dan pulang (*check-out*) harian.
    * Mengisi dan mengelola logbook aktivitas harian.
    * Melihat status magang dan dokumen pendukung lainnya.
* **Mentor**
    * Memantau daftar mahasiswa bimbingan secara *real-time*.
    * Melakukan verifikasi (Persetujuan/Penolakan) terhadap logbook harian mahasiswa.
    * Memberikan evaluasi dan penilaian performa mahasiswa magang.
* **Admin**
    * Manajemen data pengguna (*User Management*) dan divisi perusahaan.
    * Melakukan pengaturan (*Setup*) penempatan magang bagi mahasiswa baru.
    * Monitoring seluruh aktivitas magang di dalam sistem.

## 🛠️ Stack Teknologi

* **Framework:** Laravel 12.0
* **Bahasa Pemrograman:** PHP ^8.2
* **Authentication:** Laravel Breeze
* **Frontend:** Tailwind CSS & Alpine.js
* **Tooling:** Laravel Sail (Docker), Pint (Linting), dan Pail (Logging)

## 📋 Persyaratan Sistem

Pastikan perangkat kamu sudah terpasang:
* PHP >= 8.2
* Composer
* Node.js & NPM
* Database (MySQL atau SQLite)

## ⚙️ Instalasi Lokal

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/ovaltinegif/telkom-internship.git
    cd telkom-internship
    ```

2.  **Setup Cepat (Otomatis)**
    Gunakan script setup yang sudah dikonfigurasi di `composer.json` untuk menginstal dependensi dan menyiapkan database:
    ```bash
    composer run setup
    ```

3.  **Jalankan Aplikasi**
    Gunakan perintah berikut untuk menjalankan server development, queue, dan Vite secara bersamaan:
    ```bash
    composer run dev
    ```

## 🗄️ Struktur Database

Sistem ini memiliki beberapa tabel inti untuk mendukung operasionalnya:
* `users`: Data kredensial dan role pengguna.
* `internships`: Data utama hubungan mahasiswa, mentor, divisi, dan status magang.
* `daily_logbooks`: Catatan aktivitas harian mahasiswa yang diverifikasi mentor.
* `attendances`: Data kehadiran mahasiswa.
* `evaluations`: Data penilaian akhir mahasiswa.
* `divisions`: Daftar unit kerja/divisi di Telkom Witel Semarang.

---
*Proyek ini dikembangkan sebagai bagian dari program magang di Telkom Witel Semarang.*
