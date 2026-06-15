# PKL Daily Report System

## Deskripsi Project

PKL Daily Report System adalah aplikasi web yang digunakan oleh siswa atau mahasiswa PKL untuk mencatat aktivitas harian selama masa praktik kerja lapangan.

Aplikasi ini membantu peserta PKL mendokumentasikan pekerjaan yang dilakukan setiap hari, mengunggah bukti pekerjaan, serta memudahkan mentor atau pembimbing untuk memantau perkembangan peserta.

Project ini berfokus pada pengelolaan laporan harian dan proses review sederhana oleh mentor.

---

# Tujuan Project

* Melatih pembuatan aplikasi backend menggunakan Laravel.
* Memahami autentikasi dan otorisasi user.
* Mengimplementasikan relasi database.
* Mengelola file upload.
* Menerapkan validasi data.
* Membuat sistem approval sederhana.
* Menghasilkan laporan dalam format PDF.

---

# Role User

## 1. Siswa PKL

Hak akses:

* Login
* Melihat profil
* Membuat laporan harian
* Mengedit laporan yang belum direview
* Menghapus laporan yang belum direview
* Upload screenshot atau dokumentasi
* Melihat status review

## 2. Mentor

Hak akses:

* Login
* Melihat seluruh laporan siswa
* Memberikan komentar
* Menyetujui laporan
* Menolak laporan

---

# Fitur Utama

## Authentication

* Login
* Logout
* Register (opsional)
* Reset password (opsional)

---

## Dashboard

Menampilkan:

* Total laporan
* Total laporan disetujui
* Total laporan ditolak
* Total laporan bulan ini

---

## Manajemen Laporan

### Tambah Laporan

Field:

* Tanggal
* Judul aktivitas
* Deskripsi aktivitas
* Kendala yang ditemukan
* Solusi yang dilakukan
* Screenshot dokumentasi

Contoh:

Tanggal:
2026-08-10

Judul:
Belajar Laravel Middleware

Deskripsi:
Mempelajari penggunaan middleware untuk membatasi akses halaman tertentu.

Kendala:
Masih bingung alur request lifecycle.

Solusi:
Membaca dokumentasi Laravel dan mencoba implementasi langsung.

---

### Edit Laporan

Hanya laporan yang belum direview dapat diedit.

---

### Hapus Laporan

Hanya laporan yang belum direview dapat dihapus.

---

## Review Mentor

Status:

* Pending
* Approved
* Rejected

Mentor dapat memberikan komentar.

Contoh:

Status:
Approved

Komentar:
Deskripsi sudah cukup jelas, lanjutkan eksplorasi middleware authentication.

---

## Upload Dokumentasi

Jenis file:

* JPG
* JPEG
* PNG

Maksimal ukuran:

* 2 MB

Lokasi penyimpanan:

storage/app/public/reports

---

## Export PDF

Fitur:

* Export laporan per bulan
* Export seluruh laporan
* Export laporan berdasarkan rentang tanggal

---

# Database Design

## users

| Field    | Type    |
| -------- | ------- |
| id       | bigint  |
| name     | varchar |
| email    | varchar |
| password | varchar |
| role     | enum    |

Role:

* student
* mentor

---

## reports

| Field         | Type      |
| ------------- | --------- |
| id            | bigint    |
| user_id       | bigint    |
| title         | varchar   |
| activity_date | date      |
| description   | text      |
| problem       | text      |
| solution      | text      |
| attachment    | varchar   |
| status        | enum      |
| created_at    | timestamp |
| updated_at    | timestamp |

Status:

* pending
* approved
* rejected

---

## report_reviews

| Field       | Type      |
| ----------- | --------- |
| id          | bigint    |
| report_id   | bigint    |
| mentor_id   | bigint    |
| comment     | text      |
| reviewed_at | timestamp |

---

# Relasi Database

User -> Reports

One To Many

1 User memiliki banyak Report.

---

Report -> Review

One To One

1 Report memiliki 1 hasil review.

---

Mentor -> Review

One To Many

1 Mentor dapat mereview banyak laporan.

---

# Struktur API (Opsional)

Authentication:

POST /login
POST /logout

Reports:

GET /reports
POST /reports
GET /reports/{id}
PUT /reports/{id}
DELETE /reports/{id}

Review:

POST /reports/{id}/approve
POST /reports/{id}/reject

PDF:

GET /reports/export/pdf

---

# Validasi

## Create Report

title

* required
* min:5
* max:255

description

* required
* min:20

activity_date

* required
* date

attachment

* image
* max:2048

---

# Tahapan Pengerjaan

## Phase 1

* Setup Laravel
* Authentication
* Database Migration

Target:
User dapat login.

---

## Phase 2

* CRUD Laporan

Target:
User dapat membuat laporan harian.

---

## Phase 3

* Upload Dokumentasi

Target:
User dapat mengunggah screenshot pekerjaan.

---

## Phase 4

* Review Mentor

Target:
Mentor dapat approve atau reject laporan.

---

## Phase 5

* Dashboard Statistik

Target:
Menampilkan ringkasan aktivitas.

---

## Phase 6

* Export PDF

Target:
Laporan dapat dicetak.

---

# Challenge Tambahan

Jika seluruh fitur utama selesai:

1. Notifikasi ketika laporan direview.
2. Sistem absensi PKL.
3. Progress mingguan.
4. Grafik aktivitas bulanan.
5. API untuk aplikasi mobile.
6. Export Excel.
7. Multi mentor.
8. Upload banyak lampiran.
9. Dark mode.
10. Riwayat revisi laporan.

---

# Target Pembelajaran Laravel

Setelah project selesai, diharapkan memahami:

* Migration
* Seeder
* Factory
* Authentication
* Middleware
* Authorization
* Validation
* File Upload
* Storage
* Eloquent Relationship
* Query Builder
* Pagination
* API Resource
* PDF Export
* Service Layer (opsional)
* Repository Pattern (opsional)
