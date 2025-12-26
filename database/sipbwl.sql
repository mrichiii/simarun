-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Des 2025 pada 16.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipbwl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ruangan_id` bigint(20) UNSIGNED NOT NULL,
  `ac` tinyint(1) NOT NULL DEFAULT 0,
  `proyektor` tinyint(1) NOT NULL DEFAULT 0,
  `jumlah_kursi` int(11) NOT NULL DEFAULT 0,
  `papan_tulis` tinyint(1) NOT NULL DEFAULT 0,
  `wifi` enum('lancar','lemot','tidak_terjangkau') NOT NULL DEFAULT 'tidak_terjangkau',
  `arus_listrik` enum('lancar','tidak') NOT NULL DEFAULT 'tidak',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gedung`
--

CREATE TABLE `gedung` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_gedung` varchar(255) NOT NULL,
  `nama_gedung` varchar(255) NOT NULL,
  `lokasi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gedung`
--

INSERT INTO `gedung` (`id`, `kode_gedung`, `nama_gedung`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, 'FST', 'Fakultas Sains dan Teknologi', NULL, '2025-12-23 03:11:46', '2025-12-23 03:14:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lantai`
--

CREATE TABLE `lantai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gedung_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_lantai` int(11) NOT NULL,
  `nama_lantai` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lantai`
--

INSERT INTO `lantai` (`id`, `gedung_id`, `nomor_lantai`, `nama_lantai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Lantar Dasar, Audotorium, Ruang Kelas, dan Kantin Fakultas', '2025-12-23 04:14:33', '2025-12-23 17:46:17'),
(2, 1, 2, 'Kantor Prodi, Perpustakaan Fakultas, dan Administrasi', '2025-12-23 04:15:21', '2025-12-23 04:15:21'),
(3, 1, 3, 'Lantai Teratas dan Ruangan Kelas', '2025-12-23 04:16:39', '2025-12-23 17:46:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ruangan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `foto_path` varchar(255) DEFAULT NULL,
  `status` enum('baru','diproses','selesai') NOT NULL DEFAULT 'baru',
  `catatan_admin` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_22_141523_add_role_to_users_table', 1),
(5, '2025_12_22_141618_create_gedung_table', 1),
(6, '2025_12_22_141619_create_lantai_table', 1),
(7, '2025_12_22_141619_create_ruangan_table', 1),
(8, '2025_12_22_141709_create_fasilitas_table', 1),
(9, '2025_12_22_144200_create_peminjaman_table', 1),
(10, '2025_12_22_144915_create_laporan_table', 1),
(11, '2025_12_23_012157_add_nim_to_users_table', 1),
(12, '2025_12_26_000001_upgrade_peminjaman_table_datetime', 2),
(13, '2025_12_26_000002_make_legacy_time_nullable', 3),
(14, '2025_12_26_000003_drop_legacy_time_columns', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ruangan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_jam_masuk` datetime DEFAULT NULL,
  `tanggal_jam_keluar` datetime DEFAULT NULL,
  `dosen_pengampu` varchar(255) NOT NULL,
  `status` enum('aktif','selesai','dibatalkan') NOT NULL DEFAULT 'aktif',
  `alasan_pembatalan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lantai_id` bigint(20) UNSIGNED NOT NULL,
  `kode_ruangan` varchar(255) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `status` enum('tersedia','tidak_tersedia','tidak_dapat_dipakai') NOT NULL DEFAULT 'tersedia',
  `alasan_tidak_dapat_dipakai` varchar(255) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `dosen_pengampu` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id`, `lantai_id`, `kode_ruangan`, `nama_ruangan`, `status`, `alasan_tidak_dapat_dipakai`, `jam_masuk`, `jam_keluar`, `dosen_pengampu`, `created_at`, `updated_at`) VALUES
(1, 1, 'FST-101', 'Ruang Kelas 101', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'FST-102', 'Ruang Kelas 102', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'FST-103', 'Ruang Kelas 103', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 'FST-104', 'Ruang Kelas 104', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 'FST-105', 'Ruang Kelas 105', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'FST-106', 'Ruang Kelas 106', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'FST-107', 'Ruang Kelas 107', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'FST-108', 'Ruang Kelas 108', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'FST-109', 'Ruang Kelas 109', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'FST-110', 'Ruang Kelas 110', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 3, 'FST-301', 'Ruang Kelas 301', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 3, 'FST-302', 'Ruang Kelas 302', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 3, 'FST-303', 'Ruang Kelas 303', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 3, 'FST-304', 'Ruang Kelas 304', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 3, 'FST-305', 'Ruang Kelas 305', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 3, 'FST-306', 'Ruang Kelas 306', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 3, 'FST-307', 'Ruang Kelas 307', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 3, 'FST-308', 'Ruang Kelas 308', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 3, 'FST-309', 'Ruang Kelas 309', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 3, 'FST-310', 'Ruang Kelas 310', 'tersedia', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JYOEBaLE2B7g1HsWc6BNjgtRhFaVdOAAmd6iI9eX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmNYaVFjcGxjRTRyRndIZFlFM1BXNXlnb2NTUmRIa0xMU1FhdDJHNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1766761348);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `nim` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nim`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@uinsu.ac.id', NULL, '$2y$12$yjJd32NFfm3xYDLb4RxgqeOcywQoe.7acSrpw4MtU9.nBq7A2ZMfa', 'admin', NULL, NULL, '2025-12-22 20:21:38', '2025-12-23 20:55:50'),
(2, 'Muhammad Richie Hadiansah', 'mahasiswa_0702231043@student.uinsu.ac.id', NULL, '$2y$12$CCB7jfCMJkFo2EyxlBDWlemJpXqeZJk0dyGZfDSKO5QP.FlfcVuDa', 'user', '0702231043', NULL, '2025-12-22 20:41:14', '2025-12-23 01:27:45'),
(4, 'Mutia Herman', 'mahasiswa_0702232120@student.uinsu.ac.id', NULL, '$2y$12$Bi6yyDWFFqQ0c83i.bOYF.UfkErYkvPj5.i1KspdNnRwnqsPg6WSO', 'user', '0702232120', NULL, '2025-12-22 20:50:53', '2025-12-22 20:50:53');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fasilitas_ruangan_id_foreign` (`ruangan_id`);

--
-- Indeks untuk tabel `gedung`
--
ALTER TABLE `gedung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gedung_kode_gedung_unique` (`kode_gedung`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lantai`
--
ALTER TABLE `lantai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lantai_gedung_id_nomor_lantai_unique` (`gedung_id`,`nomor_lantai`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_user_id_foreign` (`user_id`),
  ADD KEY `laporan_ruangan_id_foreign` (`ruangan_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_user_id_foreign` (`user_id`),
  ADD KEY `peminjaman_ruangan_id_foreign` (`ruangan_id`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruangan_kode_ruangan_unique` (`kode_ruangan`),
  ADD KEY `ruangan_lantai_id_foreign` (`lantai_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nim_unique` (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gedung`
--
ALTER TABLE `gedung`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lantai`
--
ALTER TABLE `lantai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD CONSTRAINT `fasilitas_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lantai`
--
ALTER TABLE `lantai`
  ADD CONSTRAINT `lantai_gedung_id_foreign` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `laporan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `ruangan_lantai_id_foreign` FOREIGN KEY (`lantai_id`) REFERENCES `lantai` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
