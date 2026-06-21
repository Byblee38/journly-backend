# Reports API Design (v1)

## General Notes

Authentication:

```http
Authorization: Bearer {token}
```

Date Format:

```text
YYYY-MM-DD
```

Example:

```text
2026-08-20
```

Business Rules:

* 1 student hanya boleh memiliki 1 report per hari.
* Student hanya dapat melihat report miliknya sendiri.
* Student hanya dapat mengubah report dengan status:

  * pending
  * rejected
* Report yang sudah approved tidak dapat diubah.
* Mentor hanya dapat melihat report siswa bimbingannya.
* Mentor hanya dapat approve atau reject report siswa bimbingannya.

---

# Student Endpoints

## Create Report

```http
POST /reports
```

Role:

* Student

Purpose:

* Membuat report baru.

Request:

```json
{
  "report_date": "2026-08-20"
}
```

Validation:

```text
required
date
unique(student_id, report_date)
```

---

## Get My Reports

```http
GET /reports
```

Role:

* Student

Purpose:

* Mengambil seluruh report milik student yang sedang login.

Optional Query:

```http
GET /reports?status=pending
GET /reports?status=approved
GET /reports?status=rejected
```

---

## Get Report Detail

```http
GET /reports/{report}
```

Role:

* Student

Purpose:

* Mengambil detail report.

Notes:

* Hanya dapat mengakses report miliknya sendiri.

---

## Update Report

```http
PUT /reports/{report}
```

Role:

* Student

Purpose:

* Mengubah data report.

Request:

```json
{
  "report_date": "2026-08-21"
}
```

Notes:

* Hanya boleh untuk report pending atau rejected.

---

# Report Activities

## Get Activities

```http
GET /reports/{report}/activities
```

Role:

* Student

Purpose:

* Mengambil seluruh activity dalam report.

---

## Create Activity

```http
POST /reports/{report}/activities
```

Role:

* Student

Purpose:

* Menambahkan activity ke dalam report.

Request:

```json
{
  "title": "Daily Meeting",
  "description": "Diskusi progress pekerjaan"
}
```

Notes:

* Report harus milik student yang login.
* Report tidak boleh berstatus approved.

---

## Update Activity

```http
PUT /activities/{activity}
```

Role:

* Student

Purpose:

* Mengubah activity.

Request:

```json
{
  "title": "Daily Meeting",
  "description": "Update deskripsi"
}
```

Notes:

* Parent report tidak boleh berstatus approved.

---

## Delete Activity

```http
DELETE /activities/{activity}
```

Role:

* Student

Purpose:

* Menghapus activity.

Notes:

* Parent report tidak boleh berstatus approved.

---

# Mentor Endpoints

## Get Student Reports

```http
GET /mentor/reports
```

Role:

* Mentor

Purpose:

* Mengambil daftar report seluruh siswa bimbingan.

Optional Query:

```http
GET /mentor/reports?status=pending
GET /mentor/reports?status=approved
GET /mentor/reports?status=rejected
```

---

## Get Report Detail

```http
GET /mentor/reports/{report}
```

Role:

* Mentor

Purpose:

* Melihat detail report siswa bimbingan.

---

## Approve Report

```http
POST /mentor/reports/{report}/approve
```

Role:

* Mentor

Purpose:

* Menyetujui report.

Request:

```json
{
  "note": "Laporan sudah sesuai"
}
```

Effect:

```text
status = approved
approved_at = current timestamp
mentor_note = note
```

Validation:

```text
Report harus memiliki minimal 1 activity.
```

---

## Reject Report

```http
POST /mentor/reports/{report}/reject
```

Role:

* Mentor

Purpose:

* Menolak report.

Request:

```json
{
  "note": "Mohon tambahkan detail pekerjaan"
}
```

Effect:

```text
status = rejected
mentor_note = note
```
