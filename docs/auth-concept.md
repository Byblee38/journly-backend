# Konsep Autentikasi dan Akun (Auth) - Project Journly

Dokumentasi ini menjelaskan arsitektur dan alur kerja sistem autentikasi pada project Journly. Sistem ini menggunakan Laravel Sanctum untuk manajemen token API dan memiliki struktur data yang memisahkan data identitas (Siswa/Guru) dengan data akun (User).

## 1. Model Data dan Relasi

Sistem Auth di Journly melibatkan tiga entitas utama yang saling berhubungan:

### a. Model `User`
- Merupakan entitas utama untuk autentikasi (Laravel Authenticatable).
- Menyimpan kredensial dasar: `email`, `password`, dan `role`.
- Menggunakan Laravel Sanctum untuk token-based authentication.
- **Relasi:**
    - `hasOne(Student::class)`: Relasi ke data detail siswa.
    - `hasOne(Teacher::class)`: Relasi ke data detail guru/mentor/admin.

### b. Model `Student` (Siswa)
- Menyimpan data profil khusus siswa.
- Identitas unik menggunakan `nisn`.
- Memiliki kolom `is_active` untuk menandai apakah siswa tersebut sudah melakukan aktivasi akun.
- **Relasi:** `belongsTo(User::class)` melalui `user_id`.

### c. Model `Teacher` (Guru/Mentor/Admin)
- Menyimpan data profil khusus guru, mentor, atau admin.
- Identitas unik menggunakan `nip`.
- Memiliki kolom `is_active` untuk menandai apakah akun sudah aktif.
- **Relasi:** `belongsTo(User::class)` melalui `user_id`.

---

## 2. Peran Pengguna (User Roles)

Terdapat tiga role utama yang didefinisikan dalam `UserRole` enum:
1. **`siswa`**: Pengguna dengan data yang merujuk ke tabel `students`.
2. **`mentor`**: Pengguna dengan data yang merujuk ke tabel `teachers`.
3. **`admin`**: Pengguna dengan hak akses administratif, juga merujuk ke tabel `teachers`.

---

## 3. Alur Autentikasi (Auth Flow)

Sistem ini memiliki alur aktivasi akun yang unik:

### Tahap 1: Registrasi Data (Pre-Activation)
Data siswa atau guru dimasukkan ke sistem oleh admin melalui endpoint `createUser`. Pada tahap ini, record di tabel `students` atau `teachers` dibuat, tetapi record di tabel `users` **belum ada**, dan `is_active` bernilai `false`.

### Tahap 2: Pengecekan User (`userCheck`)
Sebelum aktivasi, user (siswa/guru) dapat mengecek apakah data mereka sudah terdaftar di sistem menggunakan NISN/NIP. Jika ditemukan, sistem akan mengembalikan status `is_active`.

### Tahap 3: Aktivasi Akun (`activateUser`)
Jika data sudah ada tetapi belum aktif, user melakukan aktivasi dengan:
1. Menyediakan NISN/NIP.
2. Memberikan email dan password baru.
3. Sistem akan membuat record baru di tabel `users`.
4. Sistem menghubungkan `user_id` ke record `students` atau `teachers` yang bersangkutan.
5. Mengubah status `is_active` menjadi `true`.

### Tahap 4: Login
- Menggunakan `email` dan `password`.
- Validasi menggunakan `Hash::check`.
- Jika berhasil, sistem men-generate token menggunakan `createToken('access-token')->plainTextToken` (Sanctum).
- Response menyertakan profil lengkap (gabungan data `users` dan detail dari `students`/`teachers`).

### Tahap 5: Logout
- Menghapus current access token yang sedang digunakan.

---

## 4. Struktur API (AuthController)

Endpoint dasar: `/api/v1`

| Method | Endpoint | Deskripsi | Middleware |
| --- | --- | --- | --- |
| `POST` | `/auth/login` | Autentikasi user dan pemberian token Sanctum. | - |
| `GET` | `/user-check` | Mengecek keberadaan data profil (NISN/NIP). | - |
| `POST` | `/users/activate` | Aktivasi akun (membuat record `users`). | - |
| `POST` | `/auth/logout` | Mencabut token akses yang aktif. | `auth:sanctum` |
| `POST` | `/users` | Menambahkan data dasar siswa/guru (profil). | `auth:sanctum` |

---

## 5. Validasi dan Keamanan
- Menggunakan Laravel `Validator` untuk semua input.
- Password disimpan menggunakan hashing (Bcrypt via `Hash::make`).
- Validasi unik pada `nisn`, `nip`, dan `email`.
- Penggunaan Enum (`UserGender`, `UserRole`) untuk memastikan konsistensi data.
