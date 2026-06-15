# Authentication & Account Activation Architecture

## Overview

Dokumen ini menjelaskan arsitektur autentikasi dan aktivasi akun yang digunakan pada Sistem Informasi Sekolah berbasis Laravel dan MySQL.

Tujuan utama desain ini adalah:

* Mendukung banyak role (Admin, Guru, Siswa)
* Memisahkan data autentikasi dan data profil
* Mendukung proses aktivasi akun mandiri oleh siswa
* Memudahkan pengembangan fitur akademik di masa depan
* Menghindari duplikasi data dan perpindahan data antar tabel

---

# Architecture

## Authentication Layer

Seluruh autentikasi disimpan pada tabel `users`.

Tabel ini hanya bertanggung jawab terhadap:

* Login
* Password
* Role
* Status akun

Tabel ini tidak menyimpan data akademik maupun data kepegawaian.

---

## Profile Layer

Data spesifik setiap role dipisahkan ke tabel masing-masing.

### Student Profile

Menyimpan seluruh informasi siswa.

Contoh:

* NIS
* NISN
* Nama
* Tanggal Lahir
* Jenis Kelamin
* Kelas
* Alamat

### Teacher Profile

Menyimpan seluruh informasi guru.

Contoh:

* NIP
* Nama
* Tanggal Lahir
* Jabatan
* Status Kepegawaian

---

# Database Design

## users

Digunakan untuk autentikasi.

| Column            | Type               | Description             |
| ----------------- | ------------------ | ----------------------- |
| id                | bigint             | Primary Key             |
| email             | varchar            | Email Login             |
| password          | varchar            | Hashed Password         |
| role              | enum               | admin, teacher, student |
| is_active         | boolean            | Status akun             |
| email_verified_at | timestamp nullable | Verifikasi email        |
| created_at        | timestamp          | Created timestamp       |
| updated_at        | timestamp          | Updated timestamp       |

---

## students

Digunakan untuk menyimpan data siswa.

| Column     | Type            | Description                |
| ---------- | --------------- | -------------------------- |
| id         | bigint          | Primary Key                |
| user_id    | bigint nullable | FK ke users                |
| nis        | varchar unique  | Nomor Induk Siswa          |
| nisn       | varchar unique  | Nomor Induk Siswa Nasional |
| name       | varchar         | Nama lengkap               |
| birth_date | date            | Tanggal lahir              |
| gender     | enum            | L/P                        |
| address    | text            | Alamat                     |
| class_id   | bigint nullable | Relasi kelas               |
| created_at | timestamp       | Created timestamp          |
| updated_at | timestamp       | Updated timestamp          |

---

## teachers

Digunakan untuk menyimpan data guru.

| Column     | Type            | Description         |
| ---------- | --------------- | ------------------- |
| id         | bigint          | Primary Key         |
| user_id    | bigint nullable | FK ke users         |
| nip        | varchar unique  | Nomor Induk Pegawai |
| name       | varchar         | Nama lengkap        |
| birth_date | date            | Tanggal lahir       |
| position   | varchar         | Jabatan             |
| created_at | timestamp       | Created timestamp   |
| updated_at | timestamp       | Updated timestamp   |

---

# Relationship Diagram

users

1 ---- 1 students

users

1 ---- 1 teachers

Kondisi:

* Guru memiliki satu akun user
* Siswa memiliki satu akun user
* User hanya boleh terhubung ke satu profil

---

# Account Lifecycle

## Student Registration Flow

Akun siswa menggunakan sistem Pre-registration.

Admin membuat data siswa terlebih dahulu.

Contoh:

students

* nisn
* nis
* name
* birth_date

Namun:

user_id = NULL

Karena siswa belum melakukan aktivasi akun.

---

## Student Activation Flow

### Step 1 - Verification

Siswa membuka halaman aktivasi.

Input:

* NISN
* Tanggal Lahir

Backend melakukan validasi:

```sql
SELECT *
FROM students
WHERE nisn = ?
AND birth_date = ?;
```

---

### Step 2 - Activation Eligibility

Pastikan data ditemukan.

Pastikan akun belum aktif.

Kondisi:

```text
user_id IS NULL
```

Jika `user_id` sudah terisi:

```text
Akun telah diaktivasi sebelumnya.
```

---

### Step 3 - Identity Confirmation

Backend mengirimkan data dasar:

```json
{
    "name": "Nama Siswa"
}
```

Frontend meminta konfirmasi kepada siswa.

---

### Step 4 - Credential Creation

Siswa mengisi:

* Email
* Password
* Password Confirmation

Validasi:

* Email unique
* Password minimum sesuai kebijakan sistem

---

### Step 5 - Create User

Backend membuat akun baru pada tabel users.

Contoh:

```php
$user = User::create([
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'student',
    'is_active' => true
]);
```

---

### Step 6 - Link User

Hubungkan akun dengan profil siswa.

```php
$student->update([
    'user_id' => $user->id
]);
```

Hasil akhir:

```text
users
└── id = 10

students
└── user_id = 10
```

Aktivasi selesai.

---

# Authentication Flow

## Login

Semua role menggunakan endpoint login yang sama.

Input:

```json
{
    "email": "user@example.com",
    "password": "password"
}
```

Laravel melakukan autentikasi menggunakan tabel users.

---

## Authorization

Hak akses ditentukan menggunakan kolom role.

Contoh:

```text
admin
teacher
student
```

---

# Recommended Middleware

Contoh middleware:

```php
role:admin
role:teacher
role:student
```

Implementasi dapat menggunakan:

* Custom Middleware
* Laravel Gates
* Laravel Policies
* Spatie Laravel Permission

Untuk proyek jangka panjang, Spatie Permission direkomendasikan.

---

# Future Expansion

Struktur ini dirancang untuk mendukung fitur berikut tanpa perubahan besar:

## Academic

* Classes
* Subjects
* Schedules
* Attendance
* Grades
* Report Cards

## Administration

* Announcements
* Academic Calendar
* Permissions
* User Management

## Parent Portal

Dapat ditambahkan tabel:

```text
parents
```

yang nantinya dapat dihubungkan ke siswa.

---

# Best Practices

## Do

* Simpan password menggunakan Hash::make()
* Gunakan Foreign Key
* Gunakan Soft Delete bila diperlukan
* Pisahkan data autentikasi dan data profil
* Gunakan Form Request Validation
* Gunakan Service Layer untuk logic aktivasi

## Don't

* Jangan membuat tabel user_active dan user_inactive
* Jangan menyimpan password plaintext
* Jangan menyimpan data akademik di tabel users
* Jangan membuat Auth Guard berbeda jika tidak benar-benar diperlukan

---

# Conclusion

Arsitektur yang digunakan:

* Single Authentication Table (`users`)
* Separate Profile Tables (`students`, `teachers`)
* Pre-registration Account Activation
* Single Auth Guard
* Role-based Authorization

Pendekatan ini memberikan:

* Maintainability tinggi
* Struktur database ter-normalisasi
* Mudah dikembangkan
* Cocok untuk Laravel + MySQL
* Cocok untuk fitur akademik jangka panjang
