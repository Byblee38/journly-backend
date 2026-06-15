# HTTP Status Code Response JSON

Dokumentasi singkat HTTP Status Code yang umum digunakan pada REST API.

---

## 200 OK

Request berhasil diproses.

### Response

```json
{
  "success": true,
  "message": "Data berhasil diambil",
  "data": {
    "id": 1,
    "name": "Bayu"
  }
}
```

### Kapan digunakan?

- GET data berhasil
- UPDATE data berhasil
- Operasi lain berhasil tanpa error

---

## 201 Created

Resource baru berhasil dibuat.

### Response

```json
{
  "success": true,
  "message": "User berhasil dibuat",
  "data": {
    "id": 10,
    "name": "Bayu"
  }
}
```

### Kapan digunakan?

- Register user
- Menambah data baru
- Create resource

---

## 204 No Content

Request berhasil tetapi tidak mengembalikan data.

### Response

Tidak ada body response.

### Kapan digunakan?

- Delete data berhasil
- Update yang tidak perlu mengirim data kembali

---

## 400 Bad Request

Request tidak valid.

### Response

```json
{
  "success": false,
  "message": "Format request tidak valid"
}
```

### Kapan digunakan?

- Body JSON rusak
- Parameter tidak sesuai format

---

## 401 Unauthorized

User belum login atau token tidak valid.

### Response

```json
{
  "success": false,
  "message": "Unauthorized"
}
```

### Kapan digunakan?

- JWT tidak dikirim
- JWT expired
- JWT invalid

---

## 403 Forbidden

User login tetapi tidak memiliki akses.

### Response

```json
{
  "success": false,
  "message": "Akses ditolak"
}
```

### Kapan digunakan?

- User biasa mengakses halaman admin
- Permission tidak mencukupi

---

## 404 Not Found

Resource tidak ditemukan.

### Response

```json
{
  "success": false,
  "message": "User tidak ditemukan"
}
```

### Kapan digunakan?

- ID tidak ada di database
- Endpoint tidak ditemukan

---

## 409 Conflict

Terjadi konflik data.

### Response

```json
{
  "success": false,
  "message": "Email sudah digunakan"
}
```

### Kapan digunakan?

- Duplicate email
- Duplicate username
- Data unik sudah ada

---

## 422 Unprocessable Entity

Data valid secara format tetapi gagal validasi bisnis.

### Response

```json
{
  "success": false,
  "message": "Validation Error",
  "errors": {
    "email": [
      "Email wajib diisi"
    ],
    "password": [
      "Password minimal 8 karakter"
    ]
  }
}
```

### Kapan digunakan?

- Validasi form gagal
- Data tidak memenuhi aturan bisnis

Contoh:

- Email kosong
- Password terlalu pendek
- Nomor telepon tidak valid

---

## 429 Too Many Requests

Terlalu banyak request dalam waktu singkat.

### Response

```json
{
  "success": false,
  "message": "Terlalu banyak request, coba lagi nanti"
}
```

### Kapan digunakan?

- Rate limiting
- Anti spam
- Anti brute force login

---

## 500 Internal Server Error

Terjadi error di server.

### Response

```json
{
  "success": false,
  "message": "Internal Server Error"
}
```

### Kapan digunakan?

- Query database gagal
- Error pada kode backend
- Error yang tidak terduga

---

## 503 Service Unavailable

Server sedang tidak tersedia.

### Response

```json
{
  "success": false,
  "message": "Service sedang maintenance"
}
```

### Kapan digunakan?

- Maintenance
- Database down
- Server overload

---

# Template Response Sukses

```json
{
  "success": true,
  "message": "Berhasil",
  "data": {}
}
```

---

# Template Response Error

```json
{
  "success": false,
  "message": "Terjadi kesalahan"
}
```

---

# Template Validation Error

```json
{
  "success": false,
  "message": "Validation Error",
  "errors": {
    "field_name": [
      "Pesan error"
    ]
  }
}
```

---

# Ringkasan

| Code | Arti |
|--------|--------|
| 200 | OK |
| 201 | Created |
| 204 | No Content |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 409 | Conflict |
| 422 | Validation Error |
| 429 | Too Many Requests |
| 500 | Internal Server Error |
| 503 | Service Unavailable |
