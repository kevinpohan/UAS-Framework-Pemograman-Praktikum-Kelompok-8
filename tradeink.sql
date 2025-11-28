-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2025 at 02:47 PM
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
('tradeink-cache-admin@tradeink.test|127.0.0.1', 'i:4;', 1762919531),
('tradeink-cache-admin@tradeink.test|127.0.0.1:timer', 'i:1762919531;', 1762919531),
('tradeink-cache-john@example.com|127.0.0.1', 'i:1;', 1762919580),
('tradeink-cache-john@example.com|127.0.0.1:timer', 'i:1762919580;', 1762919580);

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
(9, '2025_11_11_103802_create_price_caches_table', 2);

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
(1, 2, 5, '0.0013', '248.4000', '2025-11-11 04:12:43', '2025-11-11 04:12:43'),
(2, 4, 6, '6.0000', '192.7233', '2025-11-11 08:56:09', '2025-11-11 20:56:32'),
(3, 4, 4, '1.0000', '430.6000', '2025-11-13 04:29:12', '2025-11-13 04:29:12');

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
(2, 2, '511.1400', '2025-11-13 04:27:42', '{\"price\": \"511.14001\"}', '2025-11-11 04:11:54', '2025-11-13 04:27:42'),
(3, 3, '286.7100', '2025-11-13 04:27:42', '{\"price\": \"286.70999\"}', '2025-11-11 04:11:54', '2025-11-13 04:27:42'),
(4, 4, '430.6000', '2025-11-13 04:34:38', '{\"price\": \"430.60001\"}', '2025-11-11 04:11:55', '2025-11-13 04:34:38'),
(5, 5, '244.2000', '2025-11-13 04:27:43', '{\"price\": \"244.20000\"}', '2025-11-11 04:11:55', '2025-11-13 04:27:43'),
(6, 6, '193.8000', '2025-11-13 04:34:38', '{\"price\": \"193.80000\"}', '2025-11-11 04:11:56', '2025-11-13 04:34:38'),
(7, 7, '273.4700', '2025-11-13 04:27:44', '{\"price\": \"273.47000\"}', '2025-11-11 08:32:16', '2025-11-13 04:27:44'),
(8, 8, '44.9400', '2025-11-13 04:27:44', '{\"price\": \"44.94000\"}', '2025-11-11 09:07:49', '2025-11-13 04:27:44');

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
('1QXi9frStxfKWOGC1l1iq6p2JtTWzexVqwSC6Fpq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY1JhVTNBbTBja29qT1RnRlFkaU1heUQxU2t1Q1pLNkRMNjdLMFVXSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly90cmFkZWlua2FwcC50ZXN0OjgwODAvYWRtaW4vdG9wdXBzIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi50b3B1cHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1762919866),
('AoWcDJ4eQl7hlzxPN2ffF0eSv0UKdWRxgVOIaFCT', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY2UyR0J4cnBzVXNPZm9yZjhmNEZ6eGpqdjM3a1ZHb29rWnlOQmNQZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYXJrZXQvMiI7czo1OiJyb3V0ZSI7czoxMToibWFya2V0LnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1762870194),
('cAaWlofjw2eT2ZGBr23BDMJ8W8SAFNDAZ3ROl6T3', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGRzaTgxZVQzU3NCVzE4b0p4VDRjUm90S0VXVFoweEZIVFdPbWdjdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly90cmFkZWlua2FwcC50ZXN0OjgwODAvbWFya2V0IjtzOjU6InJvdXRlIjtzOjEyOiJtYXJrZXQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1762920408),
('e1jcBdaV17dk9aiiR6MLlpeVbChHjjNZNRChfKU2', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMUR0ZGhhZlVZcGpaOEFjMlNrb0pWbkJOc3o4VVVGbkxyTjA5TGxwNyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbWFya2V0IjtzOjU6InJvdXRlIjtzOjEyOiJtYXJrZXQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1762877269),
('iASZioDh0tJDjgbhAjzha6frcdyMgr1OmIFGBvpE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoid3E3ejlJeUpQNTFMVUVFMk9KYU9aMzF0Rkh2ZnloUzhHNDdxV1g2dyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdG9wdXBzIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi50b3B1cHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1762877256),
('mdAznOY1RDzDhhoSTbwsLrMjw44MZ2JFmh7hDiAc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiem82eE9JQ242TExwWmVBY2tyWm14NFdkTDQxOW91cG95cG5YVUdJdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90b3B1cHMiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnRvcHVwcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1763033832),
('v4bLuBrAmlwQFNXbkYprw5qDMsUcFSz5624bfQCj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjBDd2MyZVhUM0NRS3pGVDJHOEdFZkhWMUZhUGpaU3k4VmRPcmYxcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvc3RvY2svTVNGVC9jaGFydCI7czo1OiJyb3V0ZSI7czoxNToiYXBpLnN0b2NrLmNoYXJ0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762873533),
('xLG9dkWKA7UUtq9taEzzOtErnjHTGdEiC8ytnsJ7', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYVR3bUFRR25YWERKRXpFZnZ1TlFLRUhXSFpWV1poNmY5ZFpnYVUycCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdG9ja3Mvc2VhcmNoP3E9QUFQTCI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4uc3RvY2tzLnNob3ciO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1762869690),
('zlPrAKUYtvMumvYMJOk0HBQB65cQJ5lP2dN3VSmo', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN21CM0hiRlQ1ODJQNlg4UzlET1J1RjA1UGZZeXdhRGRmN2RwRGpTciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFuc2FjdGlvbnMiO3M6NToicm91dGUiO3M6MTg6InRyYW5zYWN0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1763033680);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `symbol`, `name`, `currency`, `extra_meta`, `created_at`, `updated_at`) VALUES
(2, 'MSFT', 'Microsoft Corporation', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53'),
(3, 'GOOGL', 'Alphabet Inc.', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53'),
(4, 'TSLA', 'Tesla Inc.', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53'),
(5, 'AMZN', 'Amazon.com Inc.', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53'),
(6, 'NVDA', 'NVIDIA Corporation', 'USD', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53'),
(7, 'AAPL', 'Apple Inc.', 'USD', NULL, '2025-11-11 08:32:04', '2025-11-11 08:32:04'),
(8, 'BTC', 'Grayscale Bitcoin Mini Trust ETF', 'USD', NULL, '2025-11-11 09:07:17', '2025-11-11 09:07:17');

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
(1, 2, 1, '10.00', NULL, 'rejected', NULL, '2025-11-11 04:13:38', '2025-11-11 05:27:18'),
(2, 4, 1, '1000.00', NULL, 'approved', NULL, '2025-11-11 05:08:42', '2025-11-11 05:27:13'),
(3, 4, 1, '10000.00', NULL, 'approved', NULL, '2025-11-11 09:06:13', '2025-11-11 09:06:41'),
(4, 4, 1, '200.00', NULL, 'approved', NULL, '2025-11-11 20:57:16', '2025-11-11 20:57:45');

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
(1, 2, 5, 'buy', '0.0013', '248.4000', '0.32', 'completed', NULL, '2025-11-11 04:12:43', '2025-11-11 04:12:43'),
(2, 4, NULL, 'topup', NULL, NULL, '1000.00', 'completed', '{\"topup_id\": 2}', '2025-11-11 05:27:13', '2025-11-11 05:27:13'),
(3, 4, 6, 'buy', '2.0000', '191.8500', '383.70', 'completed', NULL, '2025-11-11 08:56:09', '2025-11-11 08:56:09'),
(4, 4, NULL, 'topup', NULL, NULL, '10000.00', 'completed', '{\"topup_id\": 3}', '2025-11-11 09:06:41', '2025-11-11 09:06:41'),
(5, 4, 6, 'buy', '4.0000', '193.1600', '772.64', 'completed', NULL, '2025-11-11 20:56:32', '2025-11-11 20:56:32'),
(6, 4, NULL, 'topup', NULL, NULL, '200.00', 'completed', '{\"topup_id\": 4}', '2025-11-11 20:57:45', '2025-11-11 20:57:45'),
(7, 4, 4, 'buy', '1.0000', '430.6000', '430.60', 'completed', NULL, '2025-11-13 04:29:12', '2025-11-13 04:29:12');

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
(1, 'Admin User', 'admin@tradeink.com', NULL, '$2y$12$1EpZ9gXoU5OwB23F/50uhu8z.tayWWBhev0z9ImLnu.81a7HHyf3m', 'admin', '10000.00', NULL, '2025-11-11 04:10:52', '2025-11-11 04:10:52'),
(2, 'John Doe', 'john@example.com', NULL, '$2y$12$juI1pf9ueuWJxcAy/545vOK2V4hU1tJmwm4ONg2NVW/bRNvtIohJS', 'user', '4999.68', NULL, '2025-11-11 04:10:53', '2025-11-11 04:12:43'),
(3, 'Jane Smith', 'jane@example.com', NULL, '$2y$12$2E0BsoIf0no2gLsu3Yc.TeK0BjGadCibtBwtR79bU.RDzyw9vQtou', 'user', '7500.00', NULL, '2025-11-11 04:10:53', '2025-11-11 04:10:53'),
(4, 'Kevin', 'viensil@gmail.com', NULL, '$2y$12$tqQ9Zi/keWNVrqF6EWV3VuKlzef1uj5BOA3.pQaJeBQXQ6IcrEI66', 'user', '9613.06', NULL, '2025-11-11 05:07:19', '2025-11-13 04:29:12');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `price_caches`
--
ALTER TABLE `price_caches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `topups`
--
ALTER TABLE `topups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
