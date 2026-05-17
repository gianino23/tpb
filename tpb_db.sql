-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2025 at 12:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_19_022631_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6DpKNyukOKXUIfyA0umkdRtkUuiHLMmzjZBPDA6W', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZWt1eXZpQWFWaVJCeDdKYmxBOXZVUm5Ca3I2SlgzdlJGSmZ6UFFyQiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2luZGlrYXRvciI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvaW5kaWthdG9yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1750384068),
('CAzWLhms6Bt2FnlOtBuG06xiyQneO7tEJAqPYAC2', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2QzVHFwQnpoNXNsTFpmbGxyNVNzQ3ZuU05aNzU4S1kxd3N2RHBvcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1750457488),
('csExwdObyPb6LDWC3sqIkttSjc25QNeFe6YoRJgq', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQUFPOFk1bUxvdm51eU1hU2Y0VUZKQkJhZ3cxWVN6b1NBZk1FcktMNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2luZGlrYXRvciI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvaW5kaWthdG9yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1750372062),
('dNIoZJnbj1S22n24M6wOyutPMdEjo5nh9wzbCf4S', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS1l2M1VSaE1vamRxVjRCbUhUeHVxazVpQlM2dndxV0pFOXdHT21LNyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2luZGlrYXRvciI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvcnBqbWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1750397604),
('KLeVDShxa639iF2QlYO7KoCygQl6XgHOXu2VO00z', 2, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOVNaZnRmb00wcnFyVUtCbllnMVZSRVdPR1VIaTFlQ0E1alNObUNCZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2NhcGFpYW4iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1750458757),
('YW4u0lnpI8jtjsCWjRQiLCMhHzDGp2uAu1RxHGVv', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibXFtV1RqUXlFVVZ5NGxHZUs5TVM5cGxubVppbG1QMVNTTkl0MHJuZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3RhcmdldCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvaW5kaWthdG9yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1750371682);

-- --------------------------------------------------------

--
-- Table structure for table `tb_capaian`
--

CREATE TABLE `tb_capaian` (
  `id` int(11) NOT NULL,
  `tpb_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `indikator_id` int(11) NOT NULL,
  `rpjmd_id` int(11) NOT NULL,
  `opd` text NOT NULL,
  `tahun_n4` text NOT NULL,
  `tahun_n3` text NOT NULL,
  `tahun_n2` text NOT NULL,
  `tahun_n1` text NOT NULL,
  `tahun_n` text NOT NULL,
  `gap` text NOT NULL,
  `kategori_capaian` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_capaian`
--

INSERT INTO `tb_capaian` (`id`, `tpb_id`, `target_id`, `indikator_id`, `rpjmd_id`, `opd`, `tahun_n4`, `tahun_n3`, `tahun_n2`, `tahun_n1`, `tahun_n`, `gap`, `kategori_capaian`) VALUES
(1, 17, 2, 4, 2, 'DLH', '100', '200', '300', '400', '500', '500', 'bagus');

-- --------------------------------------------------------

--
-- Table structure for table `tb_indikator`
--

CREATE TABLE `tb_indikator` (
  `id` int(11) NOT NULL,
  `no_indikator` varchar(50) NOT NULL,
  `nama_indikator_tpb` text NOT NULL,
  `indikator_rpjmd` text NOT NULL,
  `target_rpjmd` text NOT NULL,
  `dokumen_pendukung` text NOT NULL,
  `catatan` text NOT NULL,
  `target_perpres59` text NOT NULL,
  `ringkasan_target_perpres59` text NOT NULL,
  `kewenangan_kabupaten` varchar(50) NOT NULL,
  `kewenangan_kota` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_indikator`
--

INSERT INTO `tb_indikator` (`id`, `no_indikator`, `nama_indikator_tpb`, `indikator_rpjmd`, `target_rpjmd`, `dokumen_pendukung`, `catatan`, `target_perpres59`, `ringkasan_target_perpres59`, `kewenangan_kabupaten`, `kewenangan_kota`) VALUES
(4, '1.2.1*', 'Persentase penduduk yang hidup di bawah garis kemiskinan nasional, menurut jenis kelamin dan kelompok umur.', 'Persentase penduduk yang hidup di bawah garis kemiskinan nasional', 'Menentukan persentase penurunan tingkat kemiskinan di daerah sampai akhir periode RPJMD dengan mempertimbangkan target nasional', 'Target kemiskinan masing-masing daerah yang ditentukan secara nasional', 'Akan lebih lengkap jika daerah dapat mengkategorikan penduduk miskin berdasarkan jenis kelamin dan kelompok umur', 'Menurunnya tingkat kemiskinan pada tahun 2019 menjadi 7-8% (2015: 11,13%).', 'Menurun menjadi 7-8%', 'Kabupaten', 'Kota');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rpjmd`
--

CREATE TABLE `tb_rpjmd` (
  `id` int(11) NOT NULL,
  `no_indikator_rpjmd` varchar(50) NOT NULL,
  `indikator_kinerja` text NOT NULL,
  `spm` varchar(100) NOT NULL,
  `jenis_urusan` varchar(200) NOT NULL,
  `kategori_urusan` varchar(200) NOT NULL,
  `kekhususan_indikator` text NOT NULL,
  `referensi` text NOT NULL,
  `indikator_sama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_rpjmd`
--

INSERT INTO `tb_rpjmd` (`id`, `no_indikator_rpjmd`, `indikator_kinerja`, `spm`, `jenis_urusan`, `kategori_urusan`, `kekhususan_indikator`, `referensi`, `indikator_sama`) VALUES
(2, 'A.1.AKM.7', 'Persentase penduduk diatas garis kemiskinan', 'Cakupan jenis pelayanan dasar SPM Sosial', 'Sosial', 'Wajib Pelayanan Dasar', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tb_target`
--

CREATE TABLE `tb_target` (
  `id` int(11) NOT NULL,
  `no_target` varchar(50) NOT NULL,
  `nama_target` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_target`
--

INSERT INTO `tb_target` (`id`, `no_target`, `nama_target`) VALUES
(2, '1,2', 'Pada tahun 2030, mengurangii setidaknya setengah proporsi laki-laki, perempuan dan anak-anak dari semua usia, yang hidup dalam kemiskinan di semua dimensi, sesuai dengan definisi nasional');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tpb`
--

CREATE TABLE `tb_tpb` (
  `id` int(11) NOT NULL,
  `no_tpb` int(11) NOT NULL,
  `nama_tpb` text NOT NULL,
  `pilar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tpb`
--

INSERT INTO `tb_tpb` (`id`, `no_tpb`, `nama_tpb`, `pilar`) VALUES
(3, 1, 'Mengakhiri Kemiskinan dalam Segala Bentuk Dimanapun', 'SOSIAL'),
(4, 2, 'Menghilangkan Kelaparan, Mencapai Ketahanan Pangan dan Gizi yang Baik, serta Meningkatkan Pertanian Berkelanjutan', 'SOSIAL'),
(5, 3, 'Menjamin Kehidupan yang Sehat dan Meningkatkan Kesejahteraan Seluruh Penduduk Semua Usia', 'SOSIAL'),
(6, 4, 'Menjamin Kualitas Pendidikan yang Inklusif dan Merata serta Meningkatkan Kesempatan Belajar Sepanjang Hayat untuk Semua', 'SOSIAL'),
(7, 5, 'Mencapai Kesetaraan Gender dan Memberdayakan Kaum Perempuan', 'SOSIAL'),
(8, 6, 'Menjamin Ketersediaan serta Pengelolaan Air Bersih dan Sanitasi yang Berkelanjutan', 'LINGKUNGAN'),
(9, 7, 'Menjamin Akses Energi yang Terjangkau, Andal, Berkelanjutan dan Modern untuk Semua', 'EKONOMI'),
(10, 8, 'Meningkatkan Pertumbuhan Ekonomi yang Inklusif dan Berkelanjutan, Kesempatan Kerja yang Produktif dan Menyeluruh, serta Pekerjaan yang Layak untuk Semua', 'EKONOMI'),
(11, 9, 'Membangun Infrastruktur yang Tangguh, Meningkatkan Industri Inklusif dan Berkelanjutan, serta Mendorong Inovasi', 'EKONOMI'),
(12, 10, 'Mengurangi Kesenjangan Intra- dan Antarnegara', 'EKONOMI'),
(13, 11, 'Menjadikan Kota dan Permukiman Inklusif, Aman, Tangguh dan Berkelanjutan', 'LINGKUNGAN'),
(14, 12, 'Menjamin Pola Produksi dan Konsumsi yang Berkelanjutan', 'LINGKUNGAN'),
(15, 13, 'Mengambil Tindakan Cepat untuk Mengatasi Perubahan Iklim dan Dampaknya', 'LINGKUNGAN'),
(16, 14, 'Melestarikan dan Memanfaatkan secara Berkelanjutan Sumber Daya Kelautan dan Samudera untuk Pembangunan Berkelanjutan', 'LINGKUNGAN'),
(17, 15, 'Melindungi, Merestorasi dan Meningkatkan Pemanfaatan Berkelanjutan Ekosistem Daratan, Mengelola Hutan secara Lestari, Menghentikan Penggurunan, Memulihkan Degradasi Lahan, serta Menghentikan Kehilangan Keanekaragaman Hayati', 'LINGKUNGAN'),
(18, 16, 'Menguatkan Masyarakat yang Inklusif dan Damai untuk Pembangunan Berkelanjutan, Menyediaan Akses Keadilan untuk Semua, dan Membangun Kelembagaan yang Efektif, Akuntabel, dan Inklusif di Semua Tingkatan', 'HUKUM & TATA KELOLA'),
(19, 17, 'Menguatkan Sarana Pelaksanaan dan Merevitalisasi Kemitraan Global untuk Pembangunan Berkelanjutan', 'EKONOMI');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `foto` text NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `level`, `status`, `no_hp`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ryan', 'rian2g@gmail.com', NULL, '$2y$12$T/CshibpPgEba9bQ3WD7.e/pcLNsT/iYhS5dIV.1of7BbnntJRUQ6', 'Administrator', 1, '12345678', 'HuOvWe2q8XuqL6vXUNTGfTsUZwCKGKCGgUZzH1N4.png', NULL, NULL, '2025-06-18 18:37:14'),
(2, 'Ima DLH', 'ima@gmail.com', NULL, '$2y$12$.9n6Cgq/uWON677cb7jdx.rQPew8iHgz4W4hThroATWABSOAVj4RO', 'Petugas', 1, '1234512345', 'lHeWaqJKKyGL5VSsPVolwroxzKkpEAVyBs5hbVK0.png', NULL, '2025-06-18 18:44:13', '2025-06-18 18:44:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tb_capaian`
--
ALTER TABLE `tb_capaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_indikator`
--
ALTER TABLE `tb_indikator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_rpjmd`
--
ALTER TABLE `tb_rpjmd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_target`
--
ALTER TABLE `tb_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_tpb`
--
ALTER TABLE `tb_tpb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_capaian`
--
ALTER TABLE `tb_capaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_indikator`
--
ALTER TABLE `tb_indikator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_rpjmd`
--
ALTER TABLE `tb_rpjmd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_target`
--
ALTER TABLE `tb_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_tpb`
--
ALTER TABLE `tb_tpb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
