QA Checklist — Sistem Manajemen Ruangan FST

Instruksi singkat:
- Jalankan aplikasi: `php artisan serve` (default http://127.0.0.1:8000)
- Pastikan `php artisan storage:link` sudah dijalankan (sudah dilakukan)

1) Verifikasi Otentikasi
- [ ] Buka `/login` dan login sebagai admin (admin@uinsu.ac.id / Admin@123)
- [ ] Login sebagai user biasa (buat user melalui registrasi admin atau seeder)
- [ ] Pastikan redirect role: admin -> `/admin/dashboard`, user -> `/dashboard`

2) CRUD Gedung/Lantai/Ruangan/Fasilitas (Admin)
- [ ] Tambah Gedung baru — cek validasi (kode_gedung unik)
- [ ] Tambah Lantai pada gedung — cek unique nomor lantai per gedung
- [ ] Tambah Ruangan pada lantai — cek auto-generate `kode_ruangan`
- [ ] Ubah status ruangan menjadi `tidak_dapat_dipakai` dengan alasan — tampil di UI
- [ ] Edit Fasilitas ruangan (AC, proyektor, jumlah kursi, wifi, listrik)
- [ ] Hapus entitas dan pastikan relasi cascade berjalan

3) Dashboard & Visual Grid
- [ ] Admin: buka `/admin/dashboard`, lihat statistik dan grid warna
- [ ] User: buka `/dashboard`, lihat daftar gedung -> detail lantai -> grid ruangan
- [ ] Klik ruangan -> detail fasilitas

4) Peminjaman (Booking)
- [ ] Dari halaman ruangan detail, klik `Buat Peminjaman` untuk ruangan tersedia
- [ ] Isi `dosen_pengampu`, `jam_masuk`, `jam_keluar` (format 24h)
- [ ] Validasi server-side: jam_keluar > jam_masuk
- [ ] Coba membuat peminjaman yang bertabrakan dengan peminjaman aktif -> harus ditolak
- [ ] Coba user membuat dua peminjaman pada waktu bersamaan -> harus ditolak
- [ ] Cek `Booking Saya` (riwayat) -> bisa batalkan jika status `aktif`
- [ ] Batalkan peminjaman -> isi alasan minimal 10 karakter -> status `dibatalkan`

5) Laporan / Pengaduan
- [ ] User buat laporan (opsional pilih ruangan) + upload foto (jpg/png <=2MB)
- [ ] Admin lihat daftar laporan (`/admin/laporan`) -> proses/edit -> ubah status
- [ ] Export PDF laporan dari admin -> file terdownload dan berisi daftar laporan

6) Scheduler
- [ ] Jalankan `php artisan schedule:run` manual untuk uji
- [ ] Buat peminjaman dengan jam_keluar di waktu lampau; jalankan scheduler -> status peminjaman berubah ke `selesai` dan ruangan kembali `tersedia` bila tidak ada peminjaman aktif lain

7) Cleanup & dokumentasi
- [ ] Catat hasil tiap langkah (pass/fail) di file ini atau lampirkan screenshot jika perlu
- [ ] Jika ada bug, catat langkah reproduksi, ekspektasi, dan output aktual

Perintah bantuan (PowerShell / terminal):

```powershell
php artisan serve
php artisan storage:link
php artisan migrate --seed
php artisan schedule:run
php artisan test
```

Selesai: catat status tiap item lalu beri tahu saya untuk saya bantu perbaiki bug atau menulis test otomatis.
