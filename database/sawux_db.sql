-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2024 at 12:17 PM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jusoutbeauty_sawux_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_settings`
--

CREATE TABLE `api_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `system_api_url` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `api_refresh_time` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `system_status` tinyint(4) DEFAULT 0 COMMENT '0:OFF, 1:ON',
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_settings`
--

INSERT INTO `api_settings` (`id`, `api_url`, `system_api_url`, `api_key`, `api_refresh_time`, `image`, `system_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'https://cloud.sawux.net/external/api/get?token=', 'https://cloud.sawux.net/external/api/update?token=AkAaU4Dauwwa_-age9G9sUcORDnT0Az6&v18=', 'xa7Djv7lOCVHbqO-VMKzm4uUI27F8Ho', 80, 'uploads/1733036416.png', 1, 1, '2024-11-27 03:34:27', '2024-12-03 06:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_parameters`
--

CREATE TABLE `dynamic_parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `sub_type_id` int(11) DEFAULT NULL,
  `pre_title` varchar(255) DEFAULT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `parameter` varchar(255) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL,
  `on_off_flag` smallint(5) DEFAULT 0 COMMENT '0:OFF, 1:ON',
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dynamic_parameters`
--

INSERT INTO `dynamic_parameters` (`id`, `type_id`, `sub_type_id`, `pre_title`, `post_title`, `parameter`, `parameter_id`, `on_off_flag`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'AnO1', 'Vent-Ind', 'dataStreamId', 1, 0, 1, '2024-11-27 10:24:18', '2024-11-30 15:23:15'),
(2, 1, 1, 'AnO2', 'Vent-Ud', 'dataStreamId', 2, 0, 1, '2024-11-27 10:24:18', '2024-11-27 09:17:44'),
(3, 1, 1, 'AnO3', 'Rotor', 'dataStreamId', 3, 0, 1, '2024-11-27 10:24:18', '2024-11-28 00:15:13'),
(4, 1, 1, 'AnO4', 'Motor-verma', 'dataStreamId', 4, 0, 1, '2024-11-27 10:24:18', '2024-11-28 00:16:33'),
(5, 1, 1, 'AnO5', 'Motor-kole', 'dataStreamId', 5, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:40:19'),
(6, 1, 1, 'AnO6', 'Spjæld-ind', 'dataStreamId', 6, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:40:23'),
(7, 1, 1, 'AnO7', 'Spjæld-ud', 'dataStreamId', 7, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:40:33'),
(8, 1, 1, 'AnO8', 'Spjæld-recirk', 'dataStreamId', 8, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:40:39'),
(9, 1, 2, 'Anl1', 'Luft-ind', 'dataStreamId', 1, 0, 1, '2024-11-27 10:24:18', '2024-12-01 07:01:58'),
(10, 1, 2, 'Anl2', 'Luft-ud', 'dataStreamId', 2, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:40:51'),
(11, 1, 2, 'Anl3', 'Tryk-ind', 'dataStreamId', 3, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:40:59'),
(12, 1, 2, 'Anl4', 'Tryk-ud', 'dataStreamId', 4, 0, 1, '2024-11-27 10:24:18', '2024-11-28 02:41:04'),
(13, 1, 3, 'Dl1', 'Spjæld-ud', 'dataStreamId', 28, 0, 1, '2024-11-27 10:24:18', '2024-11-29 01:53:04'),
(14, 1, 3, 'Dl2', 'Spjæld-recirk', 'dataStreamId', 28, 0, 1, '2024-11-27 10:24:18', '2024-11-29 01:50:41'),
(15, 1, 3, 'DO1', 'Luft-ind', 'dataStreamId', 28, 0, 1, '2024-11-27 10:24:18', '2024-11-29 01:50:46'),
(16, 1, 3, 'DO2', 'Luft-ud', 'dataStreamId', 28, 0, 1, '2024-11-27 10:24:18', '2024-11-29 01:50:53'),
(17, 1, 3, 'DO3', 'Tryk-ind', 'dataStreamId', 28, 0, 1, '2024-11-27 10:24:18', '2024-11-29 01:50:59'),
(18, 1, 3, 'DO4', 'Tryk-ud', 'dataStreamId', 28, 0, 1, '2024-11-27 10:24:18', '2024-11-29 01:51:06'),
(19, 2, 4, 'T1', 'Indblæsning', 'dataStreamId', 1, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:23:42'),
(20, 2, 4, 'T2', 'Afkast', 'dataStreamId', 2, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:23:47'),
(21, 2, 4, 'T3', 'Efter rotorveksler', 'dataStreamId', 3, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:23:51'),
(22, 2, 4, 'T4', 'Varmeflade retur', 'dataStreamId', 4, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:23:58'),
(23, 2, 4, 'T5', 'Køleflade retur', 'dataStreamId', 5, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:24:03'),
(24, 2, 4, 'T6', 'Frisk luft', 'dataStreamId', 6, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:24:12'),
(25, 2, 4, 'T7', 'Udsugning', 'dataStreamId', 7, 0, 1, '2024-11-27 10:24:18', '2024-12-01 07:00:53'),
(26, 2, 4, 'T8', 'Efter recirk', 'dataStreamId', 8, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:24:28'),
(28, 3, 5, 'CO2', 'PPM', 'dataStreamId', 2, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:18:45'),
(29, 3, 5, 'Temp', '°C', 'dataStreamId', 3, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:18:50'),
(30, 3, 5, 'Fugt', '%RF', 'dataStreamId', 4, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:19:09'),
(31, 3, 5, 'TVOC', 'indeks', 'dataStreamId', 5, 0, 1, '2024-11-27 10:24:18', '2024-11-28 07:19:24');

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
(5, '2024_11_27_072037_create_api_settings_table', 2),
(6, '2024_11_27_101729_create_dynamic_parameters_table', 3),
(8, '2024_11_28_043732_create_sub_types_table', 5),
(9, '2024_11_28_043724_create_types_table', 6),
(13, '2024_11_30_063332_add_api_refresh_time_to_api_settings_table', 7),
(14, '2024_11_30_150831_add_system_api_url_to_api_settings_table', 8);

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
-- Table structure for table `sub_types`
--

CREATE TABLE `sub_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_types`
--

INSERT INTO `sub_types` (`id`, `type_id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Analog Output[0-10V]', 1, NULL, '2024-12-01 07:01:43'),
(2, 1, 'Analog Input[0-10V]', 1, NULL, '2024-11-30 09:35:18'),
(3, 1, 'Digital Input/Output[0-10V]', 1, NULL, NULL),
(4, 2, 'Digital Temperature Input[°C]', 1, NULL, NULL),
(5, 3, 'HVAC-AQS', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `device_key` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `title`, `device_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'HVAC-CTL', 'xa7Djv7lOCVHbqO-VMKzm4uUI27F8HoS', 1, '2024-11-28 02:42:07', '2024-12-03 06:32:23'),
(2, 'HVAC-ADD', 'xa7Djv7lOCVHbqO-VMKzm4uUI27F8HoS', 1, '2024-11-28 02:42:07', '2024-11-28 07:23:29'),
(3, 'HVAC-AQS', '3N-zxgP5Ujcmb5wVE1GDHMMZyuIS7poM', 1, '2024-11-28 02:42:07', '2024-11-28 07:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` smallint(5) DEFAULT NULL COMMENT '1:Admin, 2:User',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` smallint(5) DEFAULT 1 COMMENT '0:InActive, 1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'ADMIN', 'ADMIN', 1, NULL, '$2y$10$zzgv6h8k/aUnAF34odlYg.P5cCKhQtbJ8thalZ8ubdUMAtGGFZcnK', NULL, 1, '2024-11-28 07:16:14', '2024-11-29 02:02:11'),
(2, 'Hamza', 'USER', 'USER', 2, NULL, '$2y$10$uvn/3DWYFcQon2jx.BzI7uHT6TbLT/xC8PtPx8eaKd1znJngZHoZ.', NULL, 1, '2024-11-28 07:16:14', '2024-11-29 02:06:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_settings`
--
ALTER TABLE `api_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_parameters`
--
ALTER TABLE `dynamic_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `sub_types`
--
ALTER TABLE `sub_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
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
-- AUTO_INCREMENT for table `api_settings`
--
ALTER TABLE `api_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dynamic_parameters`
--
ALTER TABLE `dynamic_parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_types`
--
ALTER TABLE `sub_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
