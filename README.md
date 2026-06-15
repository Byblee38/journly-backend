# Journly - PKL Daily Report System

Journly adalah sistem pelaporan harian Praktik Kerja Lapangan (PKL) yang dirancang untuk memudahkan siswa dalam mencatat aktivitas harian dan membantu mentor dalam memantau serta meninjau perkembangan siswa secara efisien.

---

## 🚀 Fitur Utama

### 1. Autentikasi & Multi-Role
- Login dan Logout yang aman.
- Mendukung peran **Siswa PKL** dan **Mentor**.
- Sistem aktivasi akun mandiri untuk siswa berdasarkan data pra-registrasi (NISN & Tanggal Lahir).

### 2. Manajemen Laporan (Siswa)
- Membuat, melihat, mengedit, dan menghapus laporan harian.
- Unggah bukti pekerjaan atau screenshot aktivitas (Maks. 2MB).
- Pemantauan status laporan (Pending, Approved, Rejected).

### 3. Peninjauan Laporan (Mentor)
- Dashboard pemantauan seluruh laporan siswa.
- Memberikan komentar, menyetujui, atau menolak laporan.

### 4. Dashboard & Statistik
- Ringkasan statistik aktivitas bulanan dan status laporan.

### 5. Ekspor Laporan
- Menghasilkan laporan dalam format PDF berdasarkan rentang tanggal atau per bulan.

---

## 🛠️ Tech Stack

- **Backend:** [Laravel 11](https://laravel.com)
- **Database:** MySQL
- **Frontend Tooling:** [Vite](https://vitejs.dev)
- **Authentication:** Laravel Sanctum (untuk API) / Session-based
- **PDF Generation:** DomPDF / Browsershot

---

## 🏗️ Arsitektur Database

Sistem ini menggunakan pemisahan antara data autentikasi dan data profil:
- **Tabel `users`:** Menyimpan informasi login, password, dan role.
- **Tabel `students`:** Profil detail siswa (NIS, NISN, Kelas, dll).
- **Tabel `teachers`:** Profil detail guru/mentor (NIP, Jabatan, dll).
- **Tabel `reports`:** Data aktivitas harian siswa.
- **Tabel `report_reviews`:** Catatan review dari mentor untuk laporan terkait.

---

## ⚙️ Instalasi & Penyiapan

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

### 1. Clone Repository
```bash
git clone <repository-url>
cd journly-backend
```

### 2. Instalasi Dependensi
```bash
composer install
npm install
```

### 3. Konfigurasi Lingkungan
Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Migrasi Database & Seeding
```bash
php artisan migrate --seed
```

### 5. Jalankan Server
```bash
php artisan serve
npm run dev
```

---

## 📖 Dokumentasi Proyek

Informasi lebih detail mengenai pengembangan proyek dapat ditemukan di folder `docs/`:
- [Project Context](./docs/project-context.md) - Detail fitur dan tujuan.
- [Database Architecture](./docs/project-db-architecture.md) - Skema dan relasi tabel.
- [Command Cheatsheet](./docs/project-command.md) - Perintah Artisan yang sering digunakan.

---

## 🤝 Kontribusi

Proyek ini dikembangkan sebagai bagian dari tugas praktikum/PKL untuk melatih pemahaman mengenai ekosistem Laravel dan pengembangan aplikasi web modern.
