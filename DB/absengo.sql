-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Jan 2026 pada 01.35
-- Versi server: 8.0.30
-- Versi PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absengo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `shift_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `terlambat_menit` int NOT NULL DEFAULT '0',
  `lembur_menit` int NOT NULL DEFAULT '0',
  `status` enum('Hadir','Terlambat','Lembur','Izin','Cuti') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensis`
--

INSERT INTO `absensis` (`id`, `user_id`, `shift_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `terlambat_menit`, `lembur_menit`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2026-01-19', '13:21:39', NULL, 442, 0, 'Terlambat', 'Terlambat 441.65443475 menit', '2026-01-19 06:21:39', '2026-01-19 06:21:39'),
(2, 4, NULL, '2026-01-18', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:27:00', '2026-01-19 06:27:00'),
(3, 4, NULL, '2026-01-19', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:27:00', '2026-01-19 06:27:00'),
(4, 4, NULL, '2026-01-20', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:27:00', '2026-01-19 06:27:00'),
(5, 4, NULL, '2026-01-21', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:27:00', '2026-01-19 06:27:00'),
(6, 4, NULL, '2026-01-22', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:27:00', '2026-01-19 06:27:00'),
(7, 4, NULL, '2026-01-23', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:27:00', '2026-01-19 06:27:00'),
(8, 3, NULL, '2026-01-20', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:28:16', '2026-01-19 07:54:25'),
(9, 3, NULL, '2026-01-21', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 06:28:16', '2026-01-19 07:54:25'),
(10, 3, NULL, '2026-01-22', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 07:54:25', '2026-01-19 07:54:25'),
(11, 3, NULL, '2026-01-23', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 07:54:25', '2026-01-19 07:54:25'),
(12, 3, NULL, '2026-01-24', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 07:54:25', '2026-01-19 07:54:25'),
(13, 3, NULL, '2026-01-25', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 07:54:25', '2026-01-19 07:54:25'),
(14, 3, NULL, '2026-01-26', NULL, NULL, 0, 0, 'Cuti', NULL, '2026-01-19 07:54:25', '2026-01-19 07:54:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_cuti`
--

CREATE TABLE `izin_cuti` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jenis` enum('izin','cuti') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `izin_cuti`
--

INSERT INTO `izin_cuti` (`id`, `user_id`, `jenis`, `alasan`, `tanggal_mulai`, `tanggal_selesai`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 4, 'cuti', 'cuti tahunan', '2026-01-18', '2026-01-23', 'disetujui', NULL, NULL, '2026-01-19 06:26:35', '2026-01-19 06:27:00'),
(2, 3, 'izin', 'sakit', '2026-01-20', '2026-01-21', 'disetujui', NULL, NULL, '2026-01-19 06:27:43', '2026-01-19 06:28:16'),
(3, 3, 'cuti', 'cuti tahunan', '2026-01-20', '2026-01-26', 'disetujui', NULL, NULL, '2026-01-19 07:54:02', '2026-01-19 07:54:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_01_01_000001_create_shifts_table', 1),
(4, '2024_01_01_000002_create_users_table', 1),
(5, '2025_12_11_004534_create_absensi_table', 1),
(6, '2025_12_11_004603_create_izin_cuti_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shifts`
--

INSERT INTO `shifts` (`id`, `nama_shift`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(1, 'Shift Pagi', '06:00:00', '02:00:00', '2026-01-19 06:19:53', '2026-01-19 06:19:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `shift_id` bigint UNSIGNED DEFAULT NULL,
  `sisa_cuti` int NOT NULL DEFAULT '12',
  `sisa_izin` int NOT NULL DEFAULT '5',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `status`, `shift_id`, `sisa_cuti`, `sisa_izin`, `remember_token`, `created_at`, `updated_at`, `department`) VALUES
(1, 'User Absengo', 'user@gmail.com', '$2y$12$Dpc/uM81O0RYT8Dvrya8iuhwnDc6EjBX.F0ahOcdSN/5Mi30OUOHe', 'user', 'Active', NULL, 12, 5, NULL, '2026-01-19 02:31:12', '2026-01-19 02:31:12', NULL),
(2, 'Admin Absengo', 'admin@gmail.com', '$2y$12$9KLbeAOYny5V/Brz/EIj/uVD/.egrJfkMt4SjO6j79o6E/ma410jG', 'admin', 'Active', NULL, 12, 5, NULL, '2026-01-19 02:31:12', '2026-01-19 02:31:12', NULL),
(3, 'fatdliana eka cahyani', 'eka@gmail.com', '$2y$12$C4QZ5MBUZoc/iQTUwMv3Se6Esy8Tn9N6uPaePjYPD1FTY63CFHbHG', 'user', 'Active', 1, 11, 4, NULL, '2026-01-19 06:20:39', '2026-01-19 07:54:25', 'marketing'),
(4, 'Bu Lilik', 'bulilik@gmail.com', '$2y$12$RSLnluhjFfpzQ2gbXOJm5.ZaBnvQIf86IzRJio4f8oGXSo2hi.ziK', 'user', 'Active', 1, 11, 5, NULL, '2026-01-19 06:21:17', '2026-01-19 06:27:00', 'kreator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensis_user_id_foreign` (`user_id`),
  ADD KEY `absensis_shift_id_foreign` (`shift_id`);

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
-- Indeks untuk tabel `izin_cuti`
--
ALTER TABLE `izin_cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `izin_cuti_approved_by_foreign` (`approved_by`),
  ADD KEY `izin_cuti_user_id_index` (`user_id`),
  ADD KEY `izin_cuti_status_index` (`status`);

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
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_shift_id_foreign` (`shift_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `izin_cuti`
--
ALTER TABLE `izin_cuti`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `absensis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin_cuti`
--
ALTER TABLE `izin_cuti`
  ADD CONSTRAINT `izin_cuti_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `izin_cuti_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
