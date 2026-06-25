# Laravel Naming Conventions & Best Practices Guide

Dokumen ini berisi panduan lengkap standar penamaan (*naming conventions*) yang disarankan dalam ekosistem Laravel. Mengikuti standar ini sangat penting untuk memastikan kode tetap bersih, konsisten, mudah dipelihara (*maintainable*), serta memaksimalkan fitur otomatisasi bawaan Laravel (seperti konvensi Eloquent).

---

## 1. Database Architecture (Tabel & Kolom)

Laravel menggunakan library `Doctrine Inflector` untuk mengubah kata tunggal (*singular*) menjadi jamak (*plural*) secara otomatis. Mengikuti standar database akan meminimalkan konfigurasi manual pada Eloquent Model.

| Komponen | Pola Penamaan | Standar / Format | Contoh |
| :--- | :--- | :--- | :--- |
| **Nama Tabel** | `snake_case` | Jamak (*Plural*) | `users`, `posts`, `identity_cards`, `flight_bookings` |
| **Pivot Table** (Many-to-Many) | `snake_case` | Tunggal (*Singular*), urut abjad model | `role_user`, `article_tag` (bukan `user_roles` atau `tags_articles`) |
| **Primary Key** | `id` | Huruf kecil semua | `id` |
| **Foreign Key** | `singular_model_id` | Nama model (tunggal) + `_id` | `user_id`, `post_id`, `identity_card_id` |
| **Nama Kolom** | `snake_case` | Huruf kecil, pemisah *underscore* | `first_name`, `is_active`, `published_at`, `remember_token` |

---

## 2. Eloquent Models

Model merupakan representasi objek tunggal dari tabel database Anda.

* **Nama Model Class:** Menggunakan **`PascalCase`** (atau `StudlyCase`) dan berbentuk **tunggal (*singular*)**.
  * *Contoh:* `User`, `Post`, `IdentityCard`, `FlightBooking`.
* **Attributes / Properties:** Menggunakan **`snake_case`**, disesuaikan langsung dengan nama kolom pada database.
  * *Contoh:* `$user->first_name`, `$post->is_active`.
* **Relationship Methods:** Menggunakan **`camelCase`**.
  * **One-to-One / Belongs-To** (Mengembalikan 1 objek): Menggunakan bentuk **tunggal**.
    ```php
    public function phone() { return $this->hasOne(Phone::class); }
    public function user() { return $this->belongsTo(User::class); }
    ```
  * **One-to-Many / Many-to-Many** (Mengembalikan kumpulan/koleksi data): Menggunakan bentuk **jamak**.
    ```php
    public function posts() { return $this->hasMany(Post::class); }
    public function roles() { return $this->belongsToMany(Role::class); }
    ```

---

## 3. Controllers & Routing

Controller berfungsi sebagai jembatan penanganan logika HTTP request sebelum dikembalikan ke user.

### A. Controllers
* **Nama Class:** Menggunakan **`PascalCase`** + akhiran kata **`Controller`** (berbentuk tunggal).
  * *Contoh:* `UserController`, `PostController`, `AuthController`, `PaymentGatewayController`.
* **Resource Controller Methods:** Sangat disarankan mengikuti standar metode CRUD bawaan Laravel:
  * `index` — Menampilkan daftar semua data.
  * `create` — Menampilkan halaman/form untuk tambah data.
  * `store` — Memproses penyimpanan data baru ke DB.
  * `show` — Menampilkan detail dari satu data spesifik.
  * `edit` — Menampilkan halaman/form untuk mengubah data.
  * `update` — Memproses pembaruan data di DB.
  * `destroy` — Memproses penghapusan data dari DB.
* **Single Action Controller:** Jika controller hanya memiliki satu tugas spesifik (misal: proses pembayaran atau *invitation approval*), gunakan method **`__invoke()`**.
  * *Contoh Class:* `PurchaseCourseController`.

### B. Routing & URL
* **URL / URI Path:** Menggunakan **`kebab-case`** (huruf kecil semua, dipisah tanda hubung) dan berbentuk **jamak** untuk resource umum.
  * *Contoh:* `/users`, `/user-profiles`, `/blog-posts`.
* **Route Name:** Menggunakan **`camelCase`** atau lebih direkomendasikan menggunakan **`dot.notation`** (notasi titik) yang mencerminkan struktur resource dan aksinya.
  * *Contoh:* `users.index`, `users.store`, `payment.checkout`.

---

## 4. Frontend Layer (Views & Assets)

* **Nama File View (Blade):** Menggunakan **`kebab-case`**, huruf kecil semua, dan diakhiri `.blade.php`.
  * *Contoh:* `index.blade.php`, `show.blade.php`, `user-profile.blade.php`.
* **Struktur Folder View:** Disimpan di dalam `resources/views/` dengan mengelompokkannya ke dalam nama folder resource (bisa tunggal/jamak, pastikan konsisten).
  * *Contoh:* `resources/views/posts/index.blade.php`, `resources/views/auth/login.blade.php`.

---

## 5. Semua Kelas Tambahan (Classes, Services, Security, dll.)

Untuk kelas-kelas pendukung arsitektur Laravel lainnya, seluruh nama class wajib menggunakan **`PascalCase`**. Berikut adalah aturan penamaan lengkap beserta contohnya:

### A. Arsitektur Inti Laravel
* **Migrations:** Menggunakan pola `tahun_bulan_hari_timestamp_aksi_nama_tabel` (Dibuat otomatis oleh Artisan).
  * *Contoh:* `2026_06_24_000000_create_posts_table.php`, `2026_06_24_000001_add_role_id_to_users_table.php`.
* **Seeders:** Menggunakan akhiran **`Seeder`**.
  * *Contoh:* `UserSeeder`, `RoleSeeder`, `DatabaseSeeder`.
* **Factories:** Menggunakan akhiran **`Factory`** (biasanya berpasangan langsung dengan nama Model).
  * *Contoh:* `UserFactory`, `PostFactory`.
* **Middlewares:** Menggunakan nama deskriptif berbentuk kondisi atau aksi tanpa akhiran khusus.
  * *Contoh:* `Authenticate`, `CheckIsAdmin`, `EnsureEmailIsVerified`, `SetLocalization`.

### B. Request Handling & Data Transformation
* **Form Requests (Validation):** Menggunakan awalan aksi (`Store` / `Update`) + Nama Model + akhiran **`Request`**.
  * *Contoh:* `StorePostRequest`, `UpdateUserRequest`, `LoginRequest`.
* **API Resources:** Menggunakan akhiran **`Resource`** (untuk data tunggal) atau **`Collection`** (untuk kumpulan data).
  * *Contoh:* `UserResource`, `UserCollection`, `PostResource`.

### C. Business Logic & Advanced Architecture
* **Services (Service Pattern):** Jika Anda memisahkan logika bisnis dari Controller, gunakan kelas Service dengan akhiran **`Service`**.
  * *Contoh:* `PaymentService`, `OrderProcessingService`, `GitHubAuthService`.
* **Repositories (Repository Pattern):** Digunakan jika Anda melakukan abstraksi data layer. Gunakan akhiran **`Repository`**.
  * *Contoh:* `UserRepository`, `PostRepositoryInterface`.
* **Traits:** Kelas pembantu untuk kode yang bisa digunakan kembali (*reusable code*). Menggunakan akhiran **`Trait`** atau kata sifat deskriptif.
  * *Contoh:* `HasUuid`, `UploadImageTrait`, `Sluggable`.

### D. Event-Driven & Background Jobs
* **Jobs (Asynchronous/Queue):** Menggunakan kata kerja deskriptif atau aksi yang mencerminkan tugas kelas tersebut.
  * *Contoh:* `ProcessVideoUpload`, `SendMarketingEmail`, `ExportTransactionsJob`.
* **Events:** Menggunakan kata benda atau kalimat pasif (menandakan sesuatu telah terjadi).
  * *Contoh:* `OrderPlaced`, `UserRegistered`, `PaymentFailed`.
* **Listeners:** Menggunakan frasa aksi responsif untuk merespons Event terkait, sering kali diawali dengan fungsi tugasnya.
  * *Contoh:* `SendOrderConfirmationNotification`, `UpdateInventoryStock`, `LogUserActivity`.

### E. Security & Automation
* **Policies (Authorization):** Digunakan untuk mengatur hak akses (*gate*). Menggunakan nama Model + akhiran **`Policy`**.
  * *Contoh:* `PostPolicy`, `UserPolicy`.
* **Console Commands (Artisan CLI):** Nama kelas menggunakan **`PascalCase`** dengan kata benda/kerja deskriptif. Properti `$signature` di dalamnya menggunakan `kebab-case` dipisah titik dua (`:`).
  * *Contoh Class:* `ClearExpiredTokensCommand`.
  * *Contoh Command CLI:* `php artisan tokens:clear`.

---

## Ringkasan Cepat (*Cheat Sheet*)

| Komponen | Pola Kasus (*Casing*) | Contoh |
| :--- | :--- | :--- |
| **Database Table** | `snake_case` (Jamak) | `blog_posts` |
| **Model** | `PascalCase` (Tunggal) | `BlogPost` |
| **Controller** | `PascalCase` + `Controller` | `BlogPostController` |
| **Service Class** | `PascalCase` + `Service` | `PostPublishService` |
| **Request Class** | `PascalCase` + `Request` | `StorePostRequest` |
| **Blade View** | `kebab-case` | `create-post.blade.php` |
| **Route Name** | `dot.notation` | `posts.create` |

---
*Catatan: Konsistensi adalah kunci utama. Dengan mengikuti konvensi ini, developer lain yang membaca project Laravel Anda akan langsung mengenali struktur dan alur kode dengan mudah.*
