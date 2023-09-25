-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2023 at 09:44 PM
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
-- Database: `web-n0s09`
--

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_invoice` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jasakirim_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rekening_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_invoice` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `konfirmasi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `kode_invoice`, `user_id`, `jasakirim_id`, `rekening_id`, `total_invoice`, `status`, `konfirmasi`, `created_at`, `updated_at`) VALUES
(4, 'INVPSBNS13092023KSAYC', 2, 3, 2, '1040000', 4, 1, '2023-09-12 22:34:23', '2023-09-13 13:46:56'),
(5, 'INVPSBNS13092023BGIHK', 2, 2, 2, '187000', 4, 1, '2023-09-13 12:08:21', '2023-09-13 13:47:42'),
(6, 'INVPSBNS13092023Y8IDX', 2, 3, 2, '615000', 4, 1, '2023-09-13 12:29:38', '2023-09-13 13:51:10'),
(7, 'INVPSBNS130920235BZ9U', 2, 3, 2, '515000', 5, 0, '2023-09-13 14:58:17', '2023-09-13 15:39:11'),
(8, 'INVPSBNS13092023IMMWH', 2, 3, 2, '190000', 1, 1, '2023-09-13 15:01:20', '2023-09-13 15:01:36'),
(9, 'INVPSBNS13092023PZLQD', 2, 2, 2, '132000', 2, 1, '2023-09-13 15:04:50', '2023-09-13 15:05:15'),
(10, 'INVPSBNS13092023LTOKT', 2, 2, 2, '537000', 4, 1, '2023-09-13 15:06:05', '2023-09-13 16:32:01'),
(11, 'INVPSBNS14092023A3QHS', NULL, NULL, NULL, '350000', 4, 1, '2023-09-13 17:37:55', '2023-09-13 17:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `jasa_kirims`
--

CREATE TABLE `jasa_kirims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `ongkir` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jasa_kirims`
--

INSERT INTO `jasa_kirims` (`id`, `nama`, `ongkir`, `created_at`, `updated_at`) VALUES
(2, 'JNE', '12000', '2023-09-12 01:08:56', '2023-09-12 23:06:01'),
(3, 'JNT', '15000', '2023-09-12 01:09:13', '2023-09-12 23:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produks`
--

CREATE TABLE `kategori_produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_produks`
--

INSERT INTO `kategori_produks` (`id`, `kategori`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'Baju', 'images/Kategori-Produk-Baju3RirI.jpg', '2023-09-11 19:11:57', '2023-09-11 19:11:57'),
(3, 'Sepatu', 'images/Kategori-Produk-Sepatu2pHwg.jpg', '2023-09-11 19:12:19', '2023-09-11 19:12:19'),
(4, 'Jam Tangan', 'images/Kategori-Produk-Jam-TanganZDykj.jpg', '2023-09-11 19:40:15', '2023-09-11 19:40:15');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_09_11_171133_create_settings_table', 1),
(6, '2023_09_11_171936_create_kategori_produks_table', 1),
(7, '2023_09_11_172109_create_produks_table', 1),
(8, '2023_09_11_173031_add_field_gambar_to_kategori_produks', 2),
(9, '2023_09_12_004635_create_profiles_table', 3),
(10, '2023_09_12_043045_add_field_slug_to_produks', 4),
(11, '2023_09_12_072129_create_rekenings_table', 5),
(12, '2023_09_12_072303_create_jasa_kirims_table', 5),
(13, '2023_09_12_072429_create_invoices_table', 6),
(14, '2023_09_12_072926_create_transaksis_table', 7),
(15, '2023_09_13_073523_create_pembayarans_table', 8),
(16, '2023_09_13_233616_create_pembelians_table', 9);

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
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `invoice_id`, `bukti`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'images/Bukti-Pembayaran-INVPSBNS13092023KSAYCM16gS.jpg', 0, '2023-09-13 00:44:41', '2023-09-13 00:44:41'),
(2, 5, 'images/Bukti-Pembayaran-INVPSBNS13092023BGIHKIweDo.jpg', 0, '2023-09-13 13:31:24', '2023-09-13 13:31:24'),
(3, 6, 'images/Bukti-Pembayaran-INVPSBNS13092023Y8IDXohKjF.jpg', 0, '2023-09-13 13:50:47', '2023-09-13 13:50:47'),
(4, 8, 'images/Bukti-Pembayaran-INVPSBNS13092023IMMWHE88CG.jpg', 0, '2023-09-13 15:01:36', '2023-09-13 15:01:36'),
(5, 9, 'images/Bukti-Pembayaran-INVPSBNS13092023PZLQDmSUeF.jpg', 0, '2023-09-13 15:05:07', '2023-09-13 15:05:07'),
(6, 10, 'images/Bukti-Pembayaran-INVPSBNS13092023LTOKTLC9uu.jpg', 0, '2023-09-13 15:06:23', '2023-09-13 15:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `pembelians`
--

CREATE TABLE `pembelians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelians`
--

INSERT INTO `pembelians` (`id`, `produk_id`, `nama_supplier`, `jumlah`, `total`, `created_at`, `updated_at`) VALUES
(3, 3, 'John', 5, '750000', '2023-09-13 17:09:26', '2023-09-13 17:09:26');

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
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategoriproduk_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `harga_modal` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `gambar_1` varchar(255) DEFAULT NULL,
  `gambar_2` varchar(255) DEFAULT NULL,
  `gambar_3` varchar(255) DEFAULT NULL,
  `gambar_4` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `kategoriproduk_id`, `nama`, `slug`, `harga_modal`, `harga_jual`, `stok`, `deskripsi`, `gambar`, `gambar_1`, `gambar_2`, `gambar_3`, `gambar_4`, `created_at`, `updated_at`) VALUES
(1, 4, 'Red digital smartwatch', 'red-digital-smartwatch', '90000', '120000', 95, '<p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p><p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\"><br></span><br></p>', 'images/Produk-Red-digital-smartwatchwitCZ.jpg', 'images/Produk-1-Red-digital-smartwatchWQq8z.jpg', 'images/Produk-2-Red-digital-smartwatchtdLQJ.jpg', NULL, NULL, '2023-09-11 19:48:40', '2023-09-13 13:51:10'),
(2, 3, 'Air Jordan Red', 'air-jordan-red', '340000', '500000', 99, '<p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p><p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>', 'images/Produk-Air-Jordan-RedO4wCi.jpg', NULL, NULL, NULL, NULL, '2023-09-11 20:59:59', '2023-09-13 17:07:07'),
(3, 2, 'Cyan cotton t-shirt', 'cyan-cotton-t-shirt', '150000', '175000', 99, '<p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p><p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\"><br></span></p>', 'images/Produk-Cyan-cotton-t-shirtx4jNu.jpg', NULL, NULL, NULL, NULL, '2023-09-11 21:29:19', '2023-09-13 17:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `jns_kelamin` enum('L','P') NOT NULL,
  `tmpt_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `no_telp`, `jns_kelamin`, `tmpt_lahir`, `tgl_lahir`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
(1, 2, '08982918213', 'L', 'Bogor', '2001-01-01', '<p>Kp. Baru</p>', 'images/Profile-Randy-SalimqIAHc.png', '2023-09-12 16:24:03', '2023-09-13 02:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `rekenings`
--

CREATE TABLE `rekenings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  `no_rekening` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekenings`
--

INSERT INTO `rekenings` (`id`, `nama_rekening`, `no_rekening`, `bank`, `created_at`, `updated_at`) VALUES
(2, 'Peseban Store', '8231831912', 'BCA', '2023-09-12 00:58:54', '2023-09-12 00:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_website` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `desk_singkat` text NOT NULL,
  `judul_header` varchar(255) NOT NULL,
  `gambar_header` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `bg_login` varchar(255) NOT NULL,
  `bg_register` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `nama_website`, `email`, `no_telp`, `alamat`, `desk_singkat`, `judul_header`, `gambar_header`, `logo`, `favicon`, `bg_login`, `bg_register`, `facebook`, `instagram`, `youtube`, `twitter`, `created_at`, `updated_at`) VALUES
(1, 'Peseban Store', 'pesebanstore@example.com', '081293182838', '<p>Kp. Baru RT 01/02<br>Kec. Lama - Jawa Barat<br></p>', '<p><span style=\"color: rgb(108, 117, 125); font-family: &quot;Libre Franklin&quot;, sans-serif; font-size: 13.6px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span><br></p>', 'New Season', 'images/Header-Peseban-StoreBAxu7.jpg', 'images/Logo-Peseban-Storelh1xk.png', 'images/Favicon-Peseban-StoreKcxAs.png', 'images/BG-Login-Peseban-Storeg9oFg.webp', 'images/BG-Register-Peseban-StoredKlPN.webp', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://www.youtube.com/', 'https://www.twitter.com/', NULL, '2023-09-11 18:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `invoice_id`, `produk_id`, `jumlah`, `total`, `created_at`, `updated_at`) VALUES
(6, 4, 3, 3, '525000', '2023-09-12 22:34:23', '2023-09-12 22:38:10'),
(7, 4, 2, 1, '500000', '2023-09-12 22:39:15', '2023-09-12 22:39:15'),
(8, 5, 3, 1, '175000', '2023-09-13 12:08:22', '2023-09-13 12:08:22'),
(9, 6, 1, 5, '600000', '2023-09-13 12:29:38', '2023-09-13 13:50:26'),
(10, 7, 2, 1, '500000', '2023-09-13 14:58:17', '2023-09-13 14:58:17'),
(11, 8, 3, 1, '175000', '2023-09-13 15:01:20', '2023-09-13 15:01:20'),
(12, 9, 1, 1, '120000', '2023-09-13 15:04:50', '2023-09-13 15:04:50'),
(13, 10, 3, 3, '525000', '2023-09-13 15:06:05', '2023-09-13 15:06:11'),
(14, 11, 3, 2, '350000', '2023-09-13 17:37:55', '2023-09-13 17:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Admin','Pegawai','Pelanggan') NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@example.com', 'Admin', NULL, '$2y$10$T97jzUHV999Hc1lmiJHEaO58ifZpz7OIgO3rOY1jW.Ty3Gd1IJdYm', NULL, '2023-09-11 17:45:52', '2023-09-13 18:22:33'),
(2, 'Randy Salim', 'randysalim', 'randy@example.com', 'Pelanggan', NULL, '$2y$10$FOYX.xIN/5Gkq7YOQmUDPO5pLM7lL6ANRUa5YRED7dfB4il3XZ5Di', NULL, '2023-09-12 16:24:03', '2023-09-12 16:24:03'),
(5, 'Pegawai 1', 'pegawai1', 'pegawai1@gmail.com', 'Pegawai', NULL, '$2y$10$1Fl2A/qyo4pVlmWeeb8ac.rUwc7yN0SKYHMxcX3Zg92w3qYuCFhlS', NULL, '2023-09-13 18:23:55', '2023-09-13 18:24:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_kode_invoice_unique` (`kode_invoice`),
  ADD KEY `invoices_user_id_foreign` (`user_id`),
  ADD KEY `invoices_jasakirim_id_foreign` (`jasakirim_id`),
  ADD KEY `invoices_rekening_id_foreign` (`rekening_id`);

--
-- Indexes for table `jasa_kirims`
--
ALTER TABLE `jasa_kirims`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_produks`
--
ALTER TABLE `kategori_produks`
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
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelians_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_kategoriproduk_id_foreign` (`kategoriproduk_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profiles_no_telp_unique` (`no_telp`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `rekenings`
--
ALTER TABLE `rekenings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_invoice_id_foreign` (`invoice_id`),
  ADD KEY `transaksis_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
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
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jasa_kirims`
--
ALTER TABLE `jasa_kirims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_produks`
--
ALTER TABLE `kategori_produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembelians`
--
ALTER TABLE `pembelians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rekenings`
--
ALTER TABLE `rekenings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_jasakirim_id_foreign` FOREIGN KEY (`jasakirim_id`) REFERENCES `jasa_kirims` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_rekening_id_foreign` FOREIGN KEY (`rekening_id`) REFERENCES `rekenings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD CONSTRAINT `pembelians_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_kategoriproduk_id_foreign` FOREIGN KEY (`kategoriproduk_id`) REFERENCES `kategori_produks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
