-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2025 at 01:37 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tradeink`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('tradeink-cache-admin@gmail.com|127.0.0.1', 'i:1;', 1764335110),
('tradeink-cache-admin@gmail.com|127.0.0.1:timer', 'i:1764335110;', 1764335110);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_11_103525_create_users_table', 2),
(5, '2025_11_11_103637_create_stocks_table', 2),
(6, '2025_11_11_103655_create_portfolios_table', 2),
(7, '2025_11_11_103718_create_transactions_table', 2),
(8, '2025_11_11_103740_create_topups_table', 2),
(9, '2025_11_11_103802_create_price_caches_table', 2),
(10, '2025_11_18_033539_add_is_vissible', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `stock_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `avg_price` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `user_id`, `stock_id`, `quantity`, `avg_price`, `created_at`, `updated_at`) VALUES
(2, 4, 6, '6.0000', '192.7233', '2025-11-11 08:56:09', '2025-11-11 20:56:32'),
(3, 4, 4, '0.6988', '430.6000', '2025-11-13 04:29:12', '2025-11-14 22:14:38'),
(5, 4, 3, '0.5000', '276.4100', '2025-11-15 07:09:40', '2025-11-15 07:13:09'),
(6, 4, 5, '5.0000', '234.6900', '2025-11-15 07:19:47', '2025-11-15 07:19:47'),
(7, 4, 13, '1.0000', '205.2500', '2025-11-15 09:26:25', '2025-11-15 09:26:25'),
(9, 6, 3, '5.0000', '285.0200', '2025-11-17 23:51:13', '2025-11-17 23:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `price_caches`
--

CREATE TABLE `price_caches` (
  `id` bigint UNSIGNED NOT NULL,
  `stock_id` bigint UNSIGNED NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `fetched_at` timestamp NOT NULL,
  `raw_response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_caches`
--

INSERT INTO `price_caches` (`id`, `stock_id`, `price`, `fetched_at`, `raw_response`, `created_at`, `updated_at`) VALUES
(3, 3, '319.9500', '2025-11-28 06:17:43', '{\"c\": 319.95, \"d\": -3.49, \"h\": 324.5, \"l\": 316.79, \"o\": 320.68, \"t\": 1764190800, \"dp\": -1.079, \"pc\": 323.44}', '2025-11-11 04:11:54', '2025-11-28 06:17:43'),
(4, 4, '426.5800', '2025-11-28 06:18:08', '{\"c\": 426.58, \"d\": 7.18, \"h\": 426.94, \"l\": 416.89, \"o\": 423.95, \"t\": 1764190800, \"dp\": 1.712, \"pc\": 419.4}', '2025-11-11 04:11:55', '2025-11-28 06:18:08'),
(5, 5, '229.1600', '2025-11-28 06:18:30', '{\"c\": 229.16, \"d\": -0.51, \"h\": 231.7474, \"l\": 228.77, \"o\": 230.74, \"t\": 1764190800, \"dp\": -0.2221, \"pc\": 229.67}', '2025-11-11 04:11:55', '2025-11-28 06:18:30'),
(6, 6, '180.2600', '2025-11-28 06:18:51', '{\"c\": 180.26, \"d\": 2.44, \"h\": 182.91, \"l\": 178.24, \"o\": 181.63, \"t\": 1764190800, \"dp\": 1.3722, \"pc\": 177.82}', '2025-11-11 04:11:56', '2025-11-28 06:18:51'),
(7, 7, '277.5500', '2025-11-28 06:19:13', '{\"c\": 277.55, \"d\": 0.58, \"h\": 279.53, \"l\": 276.63, \"o\": 276.96, \"t\": 1764190800, \"dp\": 0.2094, \"pc\": 276.97}', '2025-11-11 08:32:16', '2025-11-28 06:19:13'),
(9, 9, '303.2100', '2025-11-28 06:19:35', '{\"c\": 303.21, \"d\": -1.27, \"h\": 306.6, \"l\": 301.64, \"o\": 305.18, \"t\": 1764190800, \"dp\": -0.4171, \"pc\": 304.48}', '2025-11-14 23:30:27', '2025-11-28 06:19:35'),
(10, 10, '175.6400', '2025-11-28 06:19:57', '{\"c\": 175.64, \"d\": 3.45, \"h\": 180.63, \"l\": 169.7, \"o\": 173.69, \"t\": 1764190800, \"dp\": 2.0036, \"pc\": 172.19}', '2025-11-15 09:16:57', '2025-11-28 06:19:57'),
(11, 11, '133.2900', '2025-11-28 06:20:18', '{\"c\": 133.29, \"d\": 0.92, \"h\": 134.1, \"l\": 132.24, \"o\": 132.24, \"t\": 1764190800, \"dp\": 0.695, \"pc\": 132.37}', '2025-11-15 09:23:22', '2025-11-28 06:20:18'),
(12, 12, '17.0300', '2025-11-17 23:11:14', '{\"c\": 17.03, \"d\": -0.61, \"h\": 17.72, \"l\": 16.945, \"o\": 17.43, \"t\": 1763413200, \"dp\": -3.458, \"pc\": 17.64}', '2025-11-15 09:23:25', '2025-11-17 23:11:14'),
(13, 13, '185.3500', '2025-11-28 06:06:13', '{\"c\": 185.35, \"d\": -0.92, \"h\": 187.145, \"l\": 183.83, \"o\": 187.145, \"t\": 1764190800, \"dp\": -0.4939, \"pc\": 186.27}', '2025-11-15 09:23:28', '2025-11-28 06:06:13'),
(14, 14, '26.6200', '2025-11-17 20:42:58', '{\"c\": 26.62, \"d\": -0.68, \"h\": 27.44, \"l\": 26.41, \"o\": 27.19, \"t\": 1763413200, \"dp\": -2.4908, \"pc\": 27.3}', '2025-11-15 09:24:56', '2025-11-17 20:42:58'),
(15, 16, '40.6500', '2025-11-17 23:11:15', '{\"c\": 40.65, \"d\": -1.07, \"h\": 42.48, \"l\": 40.34, \"o\": 41.65, \"t\": 1763413200, \"dp\": -2.5647, \"pc\": 41.72}', '2025-11-17 20:38:34', '2025-11-17 23:11:15'),
(16, 17, '507.4900', '2025-11-17 23:11:15', '{\"c\": 507.49, \"d\": -2.69, \"h\": 512.12, \"l\": 504.91, \"o\": 508.45, \"t\": 1763413200, \"dp\": -0.5273, \"pc\": 510.18}', '2025-11-17 22:35:20', '2025-11-17 23:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9WMEAIiVTGAx3QTM5DqFaTHr6sNY7D3LwlpKxeO9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibVU3ZHB1Q1YzRHZUdTRsTUJOSlR1S1loaTlNOWFRczRIZVlNb1g1NiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BvcnRmb2xpbyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcG9ydGZvbGlvIjtzOjU6InJvdXRlIjtzOjE1OiJwb3J0Zm9saW8uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763469160),
('AJ3k1KApkm1Phs1ikZR0NT6ZTbwQc0ClPDmeEc1h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiazA2amYxM253ZGFIZU1kNUo0dUtEUEk4QXBoQXZlOHlJY1VzeGFuViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763469166),
('cXjwqrft0D0tcGOn9L4OdGrhBvEh0kCk5ffQ6ZUU', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNGZPeWpPczhpSmRMVkFrUmdpNUdEOU85VVQzYnl3bVZHWndDbExyciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFuc2FjdGlvbnMiO3M6NToicm91dGUiO3M6MTg6InRyYW5zYWN0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1764131499),
('eStbvhDEMsmTG0dQpRl9fCYvyrDLlPjRkqbhmeE5', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV2NMeGpmS3dhMkx0UWsxYWt1aloxdzNaV2VBN21FZUhpM0Z3cGE1MiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdG9ja3MiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnN0b2Nrcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764131498),
('JlANCXuDfdOeK2Y41d1SNhCvYZrPIQVR01lN9LHR', 6, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWW04TVZNR0lzVHZkMThCWng4cklIb1ozTHNVbVZIeGs0c01EYWhMbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvY2svR09PR0wvY2hhcnQ/cmVzb2x1dGlvbj0xbSI7czo1OiJyb3V0ZSI7czoxNToiYXBpLnN0b2NrLmNoYXJ0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1763455968),
('LD9CBOwKdWHLHSEOFuEEHWYZZ4mdXai0GiGLJode', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2JVeEI0YTl0Nm1MNUc5TFBrMDdxWE9sWk9HY2praHp5OE9CMWVINSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvY2svQU1aTi9jaGFydD9yZXNvbHV0aW9uPTFtIjtzOjU6InJvdXRlIjtzOjE1OiJhcGkuc3RvY2suY2hhcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1764046011),
('naKWa6Cse5kQ3TMRlCwTMqiUCncCpAcjyJYmT4Iw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmtBZ2REQ0xsSlp2U25ZRTNGa295Tzl4ZGVBVDR2dGxvb0h6Z1M3cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1764336073),
('wnpMzq95R2AjY4xxLjyVl6pFT2jCA0Ys4MPnHwak', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaGhvYTdkeUVZRnBGeWpVVzFLUDZXQWI0M000N29iaXdQUndLNDY0ciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90b3B1cHMiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnRvcHVwcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764335125),
('YxNkSmTlZVJnQmasfApaLBnr7XIGgCX8yJR1gTdG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQU5YdER5dUkyVHB2TFBiWWpCQ3ZsZ2xHdHlkS1liV3Q3M3dkUGI5ZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1763469573),
('ZOw2MnGiajSqtn8WQMFErq141Px2U6bcWoVsoYn4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNDFZNjY0dGhRNlFnbU03ZHQ1YnpJUWdBdVhsUWdtdlh4eXhjTEJkUiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZC9leHBvcnQvZXhjZWwiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764335558);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `extra_meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `symbol`, `name`, `currency`, `extra_meta`, `created_at`, `updated_at`, `is_visible`) VALUES
(3, 'GOOGL', 'Alphabet Inc.', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53', 1),
(4, 'TSLA', 'Tesla Inc.', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-17 20:45:19', 0),
(5, 'AMZN', 'Amazon.com Inc.', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53', 1),
(6, 'NVDA', 'NVIDIA Corporation', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-17 20:45:09', 0),
(7, 'AAPL', 'APPLE INC', 'USD', NULL, '2025-11-11 08:32:04', '2025-11-17 22:20:08', 1),
(9, 'IBM', 'INTL BUSINESS MACHINES CORP', 'USD', NULL, '2025-11-14 23:27:27', '2025-11-17 20:44:44', 0),
(10, 'MSTR', 'STRATEGY INC', 'USD', NULL, '2025-11-15 09:15:16', '2025-11-17 20:45:03', 0),
(11, 'EXR', 'Extra Space Storage Inc', 'USD', NULL, '2025-11-15 09:21:40', '2025-11-17 20:44:20', 0),
(12, 'EXTR', 'EXTREME NETWORKS INC', 'USD', NULL, '2025-11-15 09:22:22', '2025-11-17 20:44:26', 0),
(13, 'PANW', 'PALO ALTO NETWORKS INC', 'USD', NULL, '2025-11-15 09:22:58', '2025-11-17 20:45:14', 0),
(14, 'HAL', 'HALLIBURTON CO', 'USD', NULL, '2025-11-15 09:24:41', '2025-11-17 20:44:35', 0),
(16, 'BTC', 'GRAYSCALE BITCOIN MINI ETF', 'USD', NULL, '2025-11-17 20:38:25', '2025-11-17 20:44:15', 0),
(17, 'MSFT', 'MICROSOFT CORP', 'USD', NULL, '2025-11-17 22:35:06', '2025-11-17 22:56:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `topups`
--

CREATE TABLE `topups` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topups`
--

INSERT INTO `topups` (`id`, `user_id`, `admin_id`, `amount`, `proof`, `status`, `note`, `created_at`, `updated_at`) VALUES
(2, 4, 1, '1000.00', NULL, 'approved', NULL, '2025-11-11 05:08:42', '2025-11-11 05:27:13'),
(3, 4, 1, '10000.00', NULL, 'approved', NULL, '2025-11-11 09:06:13', '2025-11-11 09:06:41'),
(4, 4, 1, '200.00', NULL, 'approved', NULL, '2025-11-11 20:57:16', '2025-11-11 20:57:45'),
(5, 5, 1, '100000.00', NULL, 'approved', NULL, '2025-11-14 23:34:27', '2025-11-14 23:34:33'),
(6, 6, NULL, '10000.00', NULL, 'pending', NULL, '2025-11-14 23:44:57', '2025-11-14 23:44:57'),
(7, 6, 1, '2000.00', NULL, 'approved', NULL, '2025-11-14 23:45:04', '2025-11-17 23:46:55'),
(8, 5, NULL, '500.00', NULL, 'pending', NULL, '2025-11-14 23:45:15', '2025-11-14 23:45:15'),
(9, 4, NULL, '250.00', NULL, 'pending', NULL, '2025-11-14 23:46:02', '2025-11-14 23:46:02'),
(10, 6, NULL, '50.00', NULL, 'pending', NULL, '2025-11-14 23:46:18', '2025-11-14 23:46:18'),
(11, 4, 1, '10.00', NULL, 'rejected', NULL, '2025-11-14 23:46:43', '2025-11-17 22:11:02'),
(12, 4, 1, '500.00', NULL, 'approved', NULL, '2025-11-15 07:20:15', '2025-11-15 07:20:27'),
(13, 4, 1, '10.00', NULL, 'rejected', NULL, '2025-11-17 07:06:10', '2025-11-17 22:10:34'),
(14, 4, 1, '21.00', 'topup-proofs/J6aXHse1YJcebrLj16whnz66VDKnCBhZg4X0UklB.jpg', 'approved', NULL, '2025-11-17 07:20:19', '2025-11-17 07:35:57'),
(15, 5, 1, '10.00', NULL, 'approved', NULL, '2025-11-17 08:25:32', '2025-11-17 22:09:47'),
(16, 6, 1, '96000.00', NULL, 'approved', NULL, '2025-11-17 23:47:46', '2025-11-17 23:48:02');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `stock_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('buy','sell','topup','withdraw') COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` decimal(15,4) DEFAULT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `total` decimal(15,2) NOT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `stock_id`, `type`, `qty`, `price`, `total`, `status`, `meta`, `created_at`, `updated_at`) VALUES
(2, 4, NULL, 'topup', NULL, NULL, '1000.00', 'completed', '{\"topup_id\": 2}', '2025-11-11 05:27:13', '2025-11-11 05:27:13'),
(3, 4, 6, 'buy', '2.0000', '191.8500', '383.70', 'completed', NULL, '2025-11-11 08:56:09', '2025-11-11 08:56:09'),
(4, 4, NULL, 'topup', NULL, NULL, '10000.00', 'completed', '{\"topup_id\": 3}', '2025-11-11 09:06:41', '2025-11-11 09:06:41'),
(5, 4, 6, 'buy', '4.0000', '193.1600', '772.64', 'completed', NULL, '2025-11-11 20:56:32', '2025-11-11 20:56:32'),
(6, 4, NULL, 'topup', NULL, NULL, '200.00', 'completed', '{\"topup_id\": 4}', '2025-11-11 20:57:45', '2025-11-11 20:57:45'),
(7, 4, 4, 'buy', '1.0000', '430.6000', '430.60', 'completed', NULL, '2025-11-13 04:29:12', '2025-11-13 04:29:12'),
(8, 4, 4, 'sell', '0.0012', '404.3500', '0.49', 'completed', NULL, '2025-11-14 22:08:05', '2025-11-14 22:08:05'),
(9, 4, 4, 'sell', '0.3000', '404.3500', '121.31', 'completed', NULL, '2025-11-14 22:14:38', '2025-11-14 22:14:38'),
(10, 5, NULL, 'topup', NULL, NULL, '100000.00', 'completed', '{\"topup_id\": 5}', '2025-11-14 23:34:33', '2025-11-14 23:34:33'),
(11, 5, NULL, 'buy', '4.0000', '510.1800', '2040.72', 'completed', NULL, '2025-11-14 23:36:45', '2025-11-14 23:36:45'),
(12, 4, 3, 'buy', '1.0000', '276.4100', '276.41', 'completed', NULL, '2025-11-15 07:09:40', '2025-11-15 07:09:40'),
(13, 4, 3, 'sell', '0.5000', '276.4100', '138.21', 'completed', NULL, '2025-11-15 07:13:09', '2025-11-15 07:13:09'),
(14, 4, 5, 'buy', '5.0000', '234.6900', '1173.45', 'completed', NULL, '2025-11-15 07:19:47', '2025-11-15 07:19:47'),
(15, 4, NULL, 'topup', NULL, NULL, '500.00', 'completed', '{\"topup_id\": 12}', '2025-11-15 07:20:27', '2025-11-15 07:20:27'),
(16, 4, 13, 'buy', '1.0000', '205.2500', '205.25', 'completed', NULL, '2025-11-15 09:26:25', '2025-11-15 09:26:25'),
(17, 4, NULL, 'topup', NULL, NULL, '21.00', 'completed', '{\"topup_id\": 14}', '2025-11-17 07:35:57', '2025-11-17 07:35:57'),
(18, 5, NULL, 'sell', '0.0005', '509.5400', '0.25', 'completed', NULL, '2025-11-17 10:39:59', '2025-11-17 10:39:59'),
(19, 5, NULL, 'topup', NULL, NULL, '10.00', 'completed', '{\"topup_id\": 15}', '2025-11-17 22:09:47', '2025-11-17 22:09:47'),
(20, 6, NULL, 'topup', NULL, NULL, '2000.00', 'completed', '{\"topup_id\": 7}', '2025-11-17 23:46:55', '2025-11-17 23:46:55'),
(21, 6, NULL, 'topup', NULL, NULL, '96000.00', 'completed', '{\"topup_id\": 16}', '2025-11-17 23:48:02', '2025-11-17 23:48:02'),
(22, 6, 3, 'buy', '5.0000', '285.0200', '1425.10', 'completed', NULL, '2025-11-17 23:50:24', '2025-11-17 23:50:24'),
(23, 6, 3, 'sell', '5.0000', '285.0200', '1425.10', 'completed', NULL, '2025-11-17 23:50:36', '2025-11-17 23:50:36'),
(24, 6, 3, 'buy', '5.0000', '285.0200', '1425.10', 'completed', NULL, '2025-11-17 23:51:13', '2025-11-17 23:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `balance`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@tradeink.com', NULL, '$2y$12$1EpZ9gXoU5OwB23F/50uhu8z.tayWWBhev0z9ImLnu.81a7HHyf3m', 'admin', '0.00', NULL, '2025-11-11 04:10:52', '2025-11-11 04:10:52'),
(4, 'Kevin', 'viensil@gmail.com', NULL, '$2y$12$tqQ9Zi/keWNVrqF6EWV3VuKlzef1uj5BOA3.pQaJeBQXQ6IcrEI66', 'user', '8738.96', NULL, '2025-11-11 05:07:19', '2025-11-17 07:35:57'),
(5, 'Iman Nurwahyu', 'iman@gmail.com', NULL, '$2y$12$IT28RnCaEHsezVbb2fNMquSWxKF7O4FjKam31WWc0DrNaRbJ6T216', 'user', '97969.53', NULL, '2025-11-14 23:33:07', '2025-11-17 22:09:47'),
(6, 'Ayang Nova', 'nova@gmail.com', NULL, '$2y$12$DZAOYUKJXFm/vFOVXxVXqenqrH4mO8E9JoGtNEVTOW8aZWoLWEVla', 'user', '96574.90', NULL, '2025-11-14 23:44:43', '2025-11-17 23:51:13'),
(8, 'Admin 2', 'admin2@gmail.com', NULL, '$2y$12$nnMzKy7yZqHXQfURGYbxPuX8BRUP0ILl.60Z2g9IeDq6q2UPjzJX.', 'admin', '0.00', NULL, '2025-11-17 21:48:50', '2025-11-17 21:48:50');

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
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `portfolios_user_id_stock_id_unique` (`user_id`,`stock_id`),
  ADD KEY `portfolios_stock_id_foreign` (`stock_id`);

--
-- Indexes for table `price_caches`
--
ALTER TABLE `price_caches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `price_caches_stock_id_unique` (`stock_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stocks_symbol_unique` (`symbol`);

--
-- Indexes for table `topups`
--
ALTER TABLE `topups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topups_user_id_foreign` (`user_id`),
  ADD KEY `topups_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_stock_id_foreign` (`stock_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `price_caches`
--
ALTER TABLE `price_caches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `topups`
--
ALTER TABLE `topups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `portfolios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `price_caches`
--
ALTER TABLE `price_caches`
  ADD CONSTRAINT `price_caches_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topups`
--
ALTER TABLE `topups`
  ADD CONSTRAINT `topups_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `topups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
