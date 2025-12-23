# README - Sistem Informasi Manajemen Ruangan Gedung FST

Aplikasi manajemen ruangan berbasis Laravel 12 untuk Gedung FST Universitas (Studi Kasus SIPBWL).

## 📋 Fitur Utama

### Admin
- **CRUD Hierarki**: Gedung → Lantai → Ruangan dengan auto-generate kode ruangan
- **Manajemen Fasilitas**: AC, proyektor, kursi, papan tulis, WiFi, arus listrik
- **Dashboard Statistik**: Grid visual dengan warna status (hijau=tersedia, kuning=terpakai, merah=tidak dapat dipakai)
- **Kelola Laporan/Pengaduan**: Review status laporan dari user, tambah catatan, export PDF

### User
- **Dashboard Interaktif**: Browse gedung → lantai → ruangan dengan detail fasilitas
- **Peminjaman Ruangan**: Booking dengan validasi overlap (room-level dan user-level)
- **Riwayat Peminjaman**: Lihat, batalkan dengan alasan
- **Laporan Ruangan**: Laporkan kerusakan/masalah dengan upload foto
- **Export Riwayat**: Lihat status peminjaman dan laporan

### System
- **Auto-Update Status**: Scheduler yang mengubah status peminjaman selesai dan ruangan kembali tersedia
- **Database-driven Sessions**: Session/queue/cache menggunakan database untuk konsistensi
- **Responsive UI**: Bootstrap 5 dengan custom CSS grid visual

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 5.7+ / MariaDB
- XAMPP (optional, recommended untuk local dev)

### Setup

1. **Clone & Install Dependencies**
   ```bash
   cd c:\xampp\htdocs\sipbwl
   composer install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update `.env`:
   ```
   DB_DATABASE=sipbwl
   DB_USERNAME=root
   DB_PASSWORD=
   QUEUE_CONNECTION=database
   SESSION_DRIVER=database
   CACHE_DRIVER=database
   ```

3. **Database Setup**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

4. **Run Development Server**
   ```bash
   php artisan serve
   ```
   Buka browser: `http://127.0.0.1:8000`

### Login Credentials

- **Admin**: `admin@uinsu.ac.id` / `Admin@123`
- **Demo User**: Buat via admin atau custom seeder

## 📊 Database Schema

| Table | Columns | Relations |
|---|---|---|
| `users` | id, name, email, password, role (enum: admin/user) | hasMany(peminjaman, laporan) |
| `gedung` | id, kode_gedung (unique), nama_gedung, lokasi | hasMany(lantai) |
| `lantai` | id, gedung_id, nomor_lantai, nama_lantai; unique(gedung_id, nomor_lantai) | belongsTo(gedung), hasMany(ruangan) |
| `ruangan` | id, lantai_id, kode_ruangan (unique), nama_ruangan, status (enum: tersedia/tidak_tersedia/tidak_dapat_dipakai), jam_masuk, jam_keluar, dosen_pengampu, alasan_tidak_dapat_dipakai | belongsTo(lantai), hasOne(fasilitas), hasMany(peminjaman, laporan) |
| `fasilitas` | id, ruangan_id, ac (bool), proyektor (bool), jumlah_kursi (int), papan_tulis (bool), wifi (enum: lancar/lemot/tidak_terjangkau), arus_listrik (enum: normal/terbatas) | belongsTo(ruangan) |
| `peminjaman` | id, user_id, ruangan_id, dosen_pengampu, jam_masuk (time), jam_keluar (time), status (enum: aktif/selesai/dibatalkan), alasan_pembatalan (text), timestamps | belongsTo(user, ruangan) |
| `laporan` | id, user_id, ruangan_id, deskripsi, foto_path, status (enum: baru/diproses/selesai), catatan_admin, timestamps | belongsTo(user, ruangan) |

## 🛣️ Key Routes

### Public
- `GET /` — Welcome page
- `GET /login`, `POST /login`, `POST /logout` — Authentication

### User (Protected by `auth` middleware)
- `GET /dashboard` — User dashboard dengan gedung list
- `GET /gedung/{id}` — Detail lantai & ruangan per gedung
- `GET /ruangan/{id}` — Detail ruangan & fasilitas
- `GET /booking/my-bookings` — Riwayat peminjaman
- `POST /booking/store/{ruangan_id}` — Create booking
- `POST /booking/{peminjaman_id}/cancel` — Show cancel form
- `PUT /booking/{peminjaman_id}/confirm-cancel` — Confirm cancellation
- `GET /laporan` — Riwayat laporan user
- `GET /laporan/create` — Form buat laporan
- `POST /laporan` — Submit laporan
- `GET /laporan/{id}` — Detail laporan
- `DELETE /laporan/{id}` — Hapus laporan (only status='baru')

### Admin (Protected by `auth` + `admin` middleware)
- `GET /admin/dashboard` — Admin dashboard with stats & grid visual
- `GET /gedung`, `POST /gedung`, etc. — CRUD Gedung (resource)
- `GET /gedung/{id}/lantai/*` — CRUD Lantai
- `GET /gedung/{id}/lantai/{id}/ruangan/*` — CRUD Ruangan
- `GET /gedung/{id}/lantai/{id}/ruangan/{id}/fasilitas/edit` — Edit Fasilitas
- `GET /admin/laporan` — Kelola semua laporan
- `GET /admin/laporan/export` — Export laporan PDF
- `GET /admin/laporan/{id}/edit` — Edit status & catatan laporan
- `PUT /admin/laporan/{id}` — Update laporan

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run Feature Tests Only
```bash
php artisan test --testsuite=Feature
```

### Run Specific Test
```bash
php artisan test --testsuite=Feature --filter BookingTest
```

**Test Coverage**: Auth, Booking (with overlap validation), Laporan (with file upload), Scheduler

## ⏰ Scheduler Setup

### Development (Manual Run)
```bash
php artisan schedule:run
```
Command: `app:auto-update-ruangan-status` — Update peminjaman selesai & ruangan status kembali tersedia

### Production (Cron Job)
Tambahkan ke crontab:
```bash
* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
```

Atau Windows Task Scheduler:
```
C:\xampp\php\php.exe C:\xampp\htdocs\sipbwl\artisan schedule:run
```
Jalankan setiap menit.

## 🔐 Security Notes

- ✅ Password hashing
- ✅ CSRF protection
- ✅ Session-based auth
- ✅ Role-based access control
- ✅ Authorization checks (user hanya bisa batalkan booking/laporan sendiri)
- ⚠️ Belum: HTTPS enforcement, rate limiting, 2FA (optional untuk future)

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
