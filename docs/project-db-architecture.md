# Database Architecture - Journly

## Overview

Journly merupakan aplikasi monitoring PKL yang memiliki tiga role utama:

* Admin
* Mentor
* Siswa

Alur utama sistem:

```text
Siswa membuat laporan
        ↓
Status = Pending
        ↓
Mentor melakukan review
        ↓
Approve / Reject
```

---

# Entity Relationship

```text
User
├── Teacher
│     └── Student
│             └── Report
│                     └── ReportActivity
```

---

# Tables

## users

Digunakan untuk autentikasi dan otorisasi pengguna.

| Column     | Type      | Description                 |
| ---------- | --------- | --------------------------- |
| id         | bigint    | Primary Key                 |
| email      | string    | Email pengguna              |
| password   | string    | Password yang telah di-hash |
| role       | enum      | admin, mentor, siswa        |
| created_at | timestamp | Timestamp Laravel           |
| updated_at | timestamp | Timestamp Laravel           |

### Relations

```php
User hasOne Student
User hasOne Teacher
```

---

## teachers

Menyimpan data profil guru, mentor, dan admin.

| Column     | Type            | Description          |
| ---------- | --------------- | -------------------- |
| id         | bigint          | Primary Key          |
| user_id    | bigint nullable | Relasi ke users      |
| nip        | string unique   | Nomor Induk Pegawai  |
| name       | string          | Nama guru            |
| gender     | enum            | Jenis kelamin        |
| is_active  | boolean         | Status aktivasi akun |
| created_at | timestamp       | Timestamp Laravel    |
| updated_at | timestamp       | Timestamp Laravel    |

### Relations

```php
Teacher belongsTo User
Teacher hasMany Student
```

---

## students

Menyimpan data profil siswa PKL.

| Column     | Type            | Description          |
| ---------- | --------------- | -------------------- |
| id         | bigint          | Primary Key          |
| user_id    | bigint nullable | Relasi ke users      |
| mentor_id  | bigint          | Relasi ke teachers   |
| nisn       | string unique   | Nomor Induk Siswa    |
| name       | string          | Nama siswa           |
| gender     | enum            | Jenis kelamin        |
| is_active  | boolean         | Status aktivasi akun |
| created_at | timestamp       | Timestamp Laravel    |
| updated_at | timestamp       | Timestamp Laravel    |

### Relations

```php
Student belongsTo User
Student belongsTo Teacher
Student hasMany Report
```

---

## reports

Menyimpan laporan harian siswa.

| Column      | Type               | Description                 |
| ----------- | ------------------ | --------------------------- |
| id          | bigint             | Primary Key                 |
| student_id  | bigint             | Relasi ke students          |
| report_date | date               | Tanggal laporan             |
| status      | enum               | pending, approved, rejected |
| mentor_note | text nullable      | Catatan mentor              |
| approved_at | timestamp nullable | Waktu approve               |
| created_at  | timestamp          | Timestamp Laravel           |
| updated_at  | timestamp          | Timestamp Laravel           |

### Relations

```php
Report belongsTo Student
Report hasMany ReportActivity
```

### Constraints

Setiap siswa hanya boleh memiliki satu laporan per hari.

```php
unique(student_id, report_date)
```

---

## report_activities

Menyimpan daftar aktivitas dalam satu laporan.

| Column      | Type      | Description       |
| ----------- | --------- | ----------------- |
| id          | bigint    | Primary Key       |
| report_id   | bigint    | Relasi ke reports |
| title       | string    | Nama aktivitas    |
| description | text      | Detail aktivitas  |
| created_at  | timestamp | Timestamp Laravel |
| updated_at  | timestamp | Timestamp Laravel |

### Relations

```php
ReportActivity belongsTo Report
```

---

# Report Flow

## Create Report

```text
Student
    ↓
Create Report
    ↓
Status = Pending
```

## Approve Report

```text
Mentor
    ↓
Review Report
    ↓
Approve
    ↓
Status = Approved
```

## Reject Report

```text
Mentor
    ↓
Review Report
    ↓
Reject
    ↓
Status = Rejected
    ↓
Mentor memberikan catatan
```

---

# Business Rules

### Student

* Hanya dapat melihat laporan miliknya.
* Hanya dapat membuat satu laporan per hari.
* Tidak dapat mengubah laporan yang sudah di-approve.
* Dapat mengubah laporan yang masih pending atau rejected.

### Mentor

* Hanya dapat melihat laporan siswa bimbingannya.
* Dapat melakukan approve atau reject laporan.
* Dapat memberikan catatan review.

### Admin

* Mengelola data siswa.
* Mengelola data mentor.
* Mengelola akun pengguna.
* Melakukan assignment mentor ke siswa.

```
```
