# Laravel Command Cheatsheet

## Setup Project

### Membuat Project Baru

```bash
composer create-project laravel/laravel nama-project
```

Contoh:

```bash
composer create-project laravel/laravel belajar-laravel
```

---

### Menjalankan Server Laravel

```bash
php artisan serve
```

Default:

```text
http://127.0.0.1:8000
```

---

### Generate APP_KEY

```bash
php artisan key:generate
```

Digunakan setelah membuat file `.env`.

---

### Install Frontend Dependency

```bash
npm install
```

---

### Menjalankan Vite

```bash
npm run dev
```

---

## Migration

### Menjalankan Semua Migration

```bash
php artisan migrate
```

---

### Membuat Migration Baru

```bash
php artisan make:migration create_posts_table
```

---

### Rollback Migration Terakhir

```bash
php artisan migrate:rollback
```

---

### Rollback Semua Migration

```bash
php artisan migrate:reset
```

---

### Hapus Semua Table dan Migrate Ulang

```bash
php artisan migrate:fresh
```

---

### Hapus Semua Table + Jalankan Seeder

```bash
php artisan migrate:fresh --seed
```

---

## Model

### Membuat Model

```bash
php artisan make:model Post
```

Hasil:

```text
app/Models/Post.php
```

---

### Membuat Model + Migration

```bash
php artisan make:model Post -m
```

---

### Membuat Model + Controller + Migration

```bash
php artisan make:model Post -mc
```

---

### Membuat Semua Sekaligus

```bash
php artisan make:model Post -mcrfs
```

Membuat:

* Model
* Migration
* Controller
* Resource Controller
* Factory
* Seeder

---

## Controller

### Membuat Controller Biasa

```bash
php artisan make:controller PostController
```

---

### Membuat Resource Controller

```bash
php artisan make:controller PostController --resource
```

Method yang dibuat:

```php
index()
create()
store()
show()
edit()
update()
destroy()
```

---

### Membuat API Controller

```bash
php artisan make:controller Api/PostController --api
```

Method:

```php
index()
store()
show()
update()
destroy()
```

Tidak ada:

```php
create()
edit()
```

karena API tidak membutuhkan halaman form.

---

## Seeder

### Membuat Seeder

```bash
php artisan make:seeder PostSeeder
```

---

### Menjalankan Seeder

```bash
php artisan db:seed
```

---

### Menjalankan Seeder Tertentu

```bash
php artisan db:seed --class=PostSeeder
```

---

## Factory

### Membuat Factory

```bash
php artisan make:factory PostFactory
```

Digunakan untuk membuat data dummy.

---

## Middleware

### Membuat Middleware

```bash
php artisan make:middleware CheckRole
```

Contoh penggunaan:

```php
->middleware('auth')
```

---

## Request Validation

### Membuat Form Request

```bash
php artisan make:request StorePostRequest
```

Digunakan untuk validasi input.

---

## API Resource

### Membuat Resource

```bash
php artisan make:resource PostResource
```

Digunakan untuk memformat response API.

---

## Event

### Membuat Event

```bash
php artisan make:event PostCreated
```

---

## Listener

### Membuat Listener

```bash
php artisan make:listener SendNotification
```

---

## Job

### Membuat Queue Job

```bash
php artisan make:job ProcessPost
```

---

## Policy

### Membuat Policy

```bash
php artisan make:policy PostPolicy
```

Digunakan untuk authorization.

---

## Command

### Membuat Artisan Command Sendiri

```bash
php artisan make:command SendEmailCommand
```

Jalankan:

```bash
php artisan send:email
```

---

## Route List

### Melihat Semua Route

```bash
php artisan route:list
```

Sangat sering digunakan saat debugging.

---

## Cache

### Membersihkan Cache

```bash
php artisan cache:clear
```

---

### Membersihkan Config Cache

```bash
php artisan config:clear
```

---

### Membersihkan Route Cache

```bash
php artisan route:clear
```

---

### Membersihkan Semua Cache

```bash
php artisan optimize:clear
```

Command favorit developer Laravel saat "kenapa kok masih error?" 😆

---

## Tinker

### Masuk ke Laravel REPL

```bash
php artisan tinker
```

Contoh:

```php
User::all();
Post::create([
    'title' => 'Belajar Laravel'
]);
```

---

# Command yang Paling Sering Dipakai Saat Belajar Laravel

```bash
php artisan serve

php artisan migrate

php artisan migrate:fresh --seed

php artisan make:model Post -m

php artisan make:model Post -mc

php artisan make:controller PostController

php artisan make:request StorePostRequest

php artisan make:seeder PostSeeder

php artisan route:list

php artisan tinker

php artisan optimize:clear
```
