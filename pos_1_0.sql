-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 06:21 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_1_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cart_report_id` bigint(20) UNSIGNED NOT NULL,
  `tab_no` int(11) NOT NULL DEFAULT 0,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` decimal(11,1) NOT NULL DEFAULT 1.0,
  `price` decimal(11,1) NOT NULL DEFAULT 0.0,
  `sub_total` decimal(11,1) NOT NULL DEFAULT 0.0,
  `discount` decimal(11,1) NOT NULL DEFAULT 0.0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0: active, 1: saved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `cart_report_id`, `tab_no`, `product_id`, `qty`, `price`, `sub_total`, `discount`, `status`, `created_at`, `updated_at`) VALUES
(23, 1, 9, 0, 3, '1.0', '105000.0', '101850.0', '3.0', 0, '2024-01-26 13:33:59', '2024-01-26 13:34:08'),
(24, 1, 9, 0, 5, '1.0', '6000.0', '6000.0', '0.0', 0, '2024-01-26 13:34:12', '2024-01-26 13:34:12'),
(25, 1, 9, 0, 2, '1.0', '250000.0', '250000.0', '0.0', 0, '2024-01-26 17:12:03', '2024-01-26 17:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `cart_reports`
--

CREATE TABLE `cart_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `buyer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` int(11) NOT NULL DEFAULT 0 COMMENT '0:Cash, 1:Credit card, 2:Bank transfer',
  `grand_total` decimal(11,1) NOT NULL DEFAULT 0.0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_reports`
--

INSERT INTO `cart_reports` (`id`, `user_id`, `buyer`, `phone`, `address`, `payment_method`, `grand_total`, `created_at`, `updated_at`) VALUES
(9, 1, NULL, NULL, NULL, 0, '357850.0', '2024-01-26 13:33:59', '2024-01-26 17:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0:inactive, 1:active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Electronic appliances', 1, '2024-01-08 11:05:10', '2024-01-10 22:11:36'),
(3, 1, 'Mobile devices', 1, '2024-01-08 11:05:34', '2024-01-08 11:07:52'),
(4, 1, 'Machines', 1, '2024-01-08 11:05:53', '2024-01-08 11:05:53'),
(5, 1, 'Stationaries', 1, '2024-01-08 11:07:42', '2024-01-08 11:07:42'),
(6, 1, 'Fruits', 1, '2024-01-08 11:29:52', '2024-01-08 11:29:52'),
(7, 1, 'Frozen foods', 1, '2024-01-08 11:30:09', '2024-01-08 11:30:09'),
(8, 1, 'Cereals', 1, '2024-01-08 11:30:34', '2024-01-08 11:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `combined_orders`
--

CREATE TABLE `combined_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`buyer_details`)),
  `grand_total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0:pending, 1:completed, 2:refunded',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `combined_orders`
--

INSERT INTO `combined_orders` (`id`, `user_id`, `buyer_details`, `grand_total`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '{\"buyer\":null,\"phone\":null,\"address\":null,\"payment_method\":\"Credit card\"}', '68300.00', 1, '2024-01-08 11:42:45', '2024-01-08 11:42:45'),
(2, 1, '{\"buyer\":\"John smith\",\"phone\":\"07034876144\",\"address\":\"John mark str\",\"payment_method\":\"Credit card\"}', '505000.00', 1, '2024-01-08 11:43:54', '2024-01-08 11:43:54'),
(3, 1, '{\"buyer\":\"Adeosun Solomon\",\"phone\":\"07034876144\",\"address\":\"Igberen Ota, Ogun state\",\"payment_method\":\"Credit card\"}', '361500.00', 1, '2024-01-10 07:02:44', '2024-01-10 07:02:44'),
(4, 1, '{\"buyer\":\"Adewale Adebisi\",\"phone\":null,\"address\":null,\"payment_method\":\"Credit card\"}', '1200920.00', 1, '2024-01-10 08:24:09', '2024-01-10 08:24:09'),
(5, 1, '{\"buyer\":\"Miss Folakemi\",\"phone\":null,\"address\":null,\"payment_method\":\"Cash\"}', '940000.00', 1, '2024-01-10 08:52:37', '2024-01-10 08:52:37'),
(6, 1, '{\"buyer\":\"Olumide\",\"phone\":\"07069056472\",\"address\":\"Dalemo street\",\"payment_method\":\"Credit card\"}', '105500.00', 1, '2024-01-10 22:10:35', '2024-01-10 22:10:35'),
(7, 1, '{\"buyer\":\"Adewale Adebisi\",\"phone\":\"07034876144\",\"address\":\"Merryland Igberen Ota, Ogun state\",\"payment_method\":\"Bank transfer\"}', '107500.00', 1, '2024-01-17 21:07:48', '2024-01-17 21:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_21_163505_create_combined_orders_table', 1),
(6, '2023_12_22_223348_create_categories_table', 1),
(7, '2023_12_23_222616_create_products_table', 1),
(8, '2023_12_23_223702_create_orders_table', 1),
(9, '2023_12_23_224730_create_stocks_table', 1),
(10, '2023_12_26_070439_create_cart_reports_table', 1),
(11, '2023_12_27_195518_create_carts_table', 1),
(12, '2023_12_29_113154_create_permission_tables', 1),
(13, '2024_01_06_061411_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `combined_order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0:pending, 1:completed, 2:refunded',
  `qty` decimal(11,1) NOT NULL DEFAULT 0.0,
  `unit_price` decimal(11,1) NOT NULL DEFAULT 0.0,
  `sub_total` decimal(11,1) NOT NULL DEFAULT 0.0,
  `discount` decimal(11,1) NOT NULL DEFAULT 0.0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `combined_order_id`, `user_id`, `product_id`, `product`, `product_code`, `barcode`, `status`, `qty`, `unit_price`, `sub_total`, `discount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Chicken', NULL, NULL, 1, '10.8', '6000.0', '64800.0', '0.0', '2024-01-08 11:42:45', '2024-01-08 11:42:45'),
(2, 1, 1, 4, 'Water melon', '90935990434', NULL, 1, '7.0', '500.0', '3500.0', '0.0', '2024-01-08 11:42:45', '2024-01-08 11:42:45'),
(3, 2, 1, 1, 'Laptop', '89039949004', NULL, 1, '1.0', '150000.0', '150000.0', '0.0', '2024-01-08 11:43:54', '2024-01-08 11:43:54'),
(4, 2, 1, 2, 'Samsung S23', '89039949234', NULL, 1, '1.0', '250000.0', '250000.0', '0.0', '2024-01-08 11:43:55', '2024-01-08 11:43:55'),
(5, 2, 1, 3, 'LG Television', '898947437498', NULL, 1, '1.0', '105000.0', '105000.0', '0.0', '2024-01-08 11:43:55', '2024-01-08 11:43:55'),
(6, 3, 1, 4, 'Water melon', '90935990434', NULL, 1, '1.0', '500.0', '500.0', '0.0', '2024-01-10 07:02:44', '2024-01-10 07:02:44'),
(7, 3, 1, 3, 'LG Television', '8498573924', NULL, 1, '1.0', '105000.0', '105000.0', '0.0', '2024-01-10 07:02:44', '2024-01-10 07:02:44'),
(8, 3, 1, 2, 'Samsung S23', '89039949234', NULL, 1, '1.0', '250000.0', '250000.0', '0.0', '2024-01-10 07:02:44', '2024-01-10 07:02:44'),
(9, 3, 1, 5, 'Chicken', '98948478733', NULL, 1, '1.0', '6000.0', '6000.0', '0.0', '2024-01-10 07:02:44', '2024-01-10 07:02:44'),
(10, 4, 1, 1, 'Laptop', '89039949004', NULL, 1, '2.0', '150000.0', '270000.0', '10.0', '2024-01-10 08:24:09', '2024-01-10 08:24:09'),
(11, 4, 1, 2, 'Samsung S23', '89039949234', NULL, 1, '4.0', '250000.0', '920000.0', '8.0', '2024-01-10 08:24:09', '2024-01-10 08:24:09'),
(12, 4, 1, 5, 'Chicken', '98948478733', NULL, 1, '2.0', '6000.0', '10920.0', '9.0', '2024-01-10 08:24:09', '2024-01-10 08:24:09'),
(13, 5, 1, 2, 'Samsung S23', '89039949234', NULL, 1, '4.0', '250000.0', '940000.0', '6.0', '2024-01-10 08:52:37', '2024-01-10 08:52:37'),
(14, 6, 1, 4, 'Water melon', '90935990434', NULL, 1, '1.0', '500.0', '500.0', '0.0', '2024-01-10 22:10:35', '2024-01-10 22:10:35'),
(15, 6, 1, 3, 'LG Television', '8498573924', NULL, 1, '1.0', '105000.0', '105000.0', '0.0', '2024-01-10 22:10:36', '2024-01-10 22:10:36'),
(16, 7, 1, 3, 'LG Television', '8498573924', NULL, 1, '1.0', '105000.0', '105000.0', '0.0', '2024-01-17 21:07:48', '2024-01-17 21:07:48'),
(17, 7, 1, 1, 'Laptop', '89039949004', NULL, 2, '7.0', '150000.0', '945000.0', '10.0', '2024-01-17 21:07:48', '2024-01-17 21:09:33'),
(18, 7, 1, 4, 'Water melon', '90935990434', NULL, 1, '5.0', '500.0', '2500.0', '0.0', '2024-01-17 21:07:48', '2024-01-17 21:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'generate-order', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(2, 'generate-receipt', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(3, 'view-receipt', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(4, 'settings', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(5, 'create-product-category', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(6, 'edit-product-category', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(7, 'delete-product-category', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(8, 'create-product', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(9, 'edit-product', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(10, 'delete-product', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(11, 'create-stock', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(12, 'list-stock', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(13, 'request-stock', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(14, 'edit-stock', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(15, 'delete-stock', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(16, 'approve-stock', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(17, 'order-report', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(18, 'stock-report', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(19, 'general-report', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(20, 'edit-user', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(21, 'delete-user', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(22, 'create-role', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(23, 'edit-role', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(24, 'delete-role', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(25, 'shop', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT 0.00,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` decimal(11,2) NOT NULL DEFAULT 0.00,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0:Invisible, 1:Visible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `product_code`, `barcode`, `availability`, `img`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', 2, '150000.00', '89039949004', NULL, '2.00', '1704991223.png', 1, '2024-01-08 11:09:15', '2024-01-17 21:07:48'),
(2, 'Samsung S23', 2, '250000.00', '89039949234', NULL, '6.00', NULL, 1, '2024-01-08 11:14:33', '2024-01-10 08:52:38'),
(3, 'LG Television', 2, '105000.00', '8498573924', NULL, '1.00', NULL, 1, '2024-01-08 11:20:25', '2024-01-17 21:07:48'),
(4, 'Water melon', 2, '500.00', '90935990434', NULL, '6.00', '1704717343.png', 1, '2024-01-08 11:35:43', '2024-01-17 21:07:48'),
(5, 'Chicken', 2, '6000.00', '98948478733', NULL, '1.20', '1704717428.png', 1, '2024-01-08 11:37:08', '2024-01-10 08:24:09'),
(6, 'House', 2, '120000.00', '84777477264', NULL, '0.00', '1704785985.jpg', 1, '2024-01-09 06:39:46', '2024-01-10 06:46:07'),
(7, 'DVD player', 2, '5000.00', '63929846823', NULL, '0.00', '1704872794.png', 1, '2024-01-10 06:46:07', '2024-01-10 06:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(2, 'Cashier', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(3, 'Stock keeper', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06'),
(4, 'Sales person', 'web', '2024-01-08 10:04:06', '2024-01-08 10:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`company_phones`)),
  `company_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_status` int(11) NOT NULL DEFAULT 0,
  `signature_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_address`, `company_phones`, `company_email`, `company_logo`, `company_signature`, `logo_status`, `signature_status`, `created_at`, `updated_at`) VALUES
(1, 'POS Management System', 'Ota, Ogun State', '[\"07034876144\",\"07069056472\"]', 'jayjtech5@gmail.com', '1704921566.png', 'default_signature.png', 1, 1, '2024-01-08 10:04:06', '2024-01-10 21:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty_requested` decimal(11,1) NOT NULL DEFAULT 0.0,
  `qty_before_approval` decimal(8,2) NOT NULL DEFAULT 0.00,
  `qty_after_approval` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `user_id`, `product_id`, `product`, `product_code`, `barcode`, `qty_requested`, `qty_before_approval`, `qty_after_approval`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Water melon', '90935990434', NULL, '20.0', '0.00', '20.00', 1, '2024-01-08 11:39:22', '2024-01-08 11:40:04'),
(2, 1, 5, 'Chicken', NULL, NULL, '15.0', '0.00', '15.00', 1, '2024-01-08 11:39:22', '2024-01-08 11:40:04'),
(3, 1, 3, 'LG Television', '898947437498', NULL, '5.0', '0.00', '5.00', 1, '2024-01-08 11:39:22', '2024-01-08 11:40:04'),
(4, 1, 2, 'Samsung S23', '89039949234', NULL, '16.0', '0.00', '16.00', 1, '2024-01-08 11:39:22', '2024-01-08 11:40:04'),
(5, 1, 1, 'Laptop', '89039949004', NULL, '12.0', '0.00', '12.00', 1, '2024-01-08 11:39:22', '2024-01-08 11:40:04'),
(6, 1, 1, 'Laptop', '89039949004', NULL, '5.0', '0.00', '0.00', 1, '2024-01-09 04:15:03', '2024-01-10 22:55:38'),
(7, 1, 2, 'Samsung S23', '89039949234', NULL, '6.0', '0.00', '0.00', 1, '2024-01-09 04:15:03', '2024-01-10 22:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Main Admin', 'admin@pos.com', NULL, '$2y$10$ihBBpSkH2mE.CATD9YF7dO.ZBAm//EEak9eBQQESjLl34dgOxO0Qa', NULL, '2024-01-08 10:04:06', '2024-01-08 10:04:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_cart_report_id_foreign` (`cart_report_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `cart_reports`
--
ALTER TABLE `cart_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `combined_orders`
--
ALTER TABLE `combined_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `combined_orders_user_id_foreign` (`user_id`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_combined_order_id_foreign` (`combined_order_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_user_id_foreign` (`user_id`),
  ADD KEY `stocks_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart_reports`
--
ALTER TABLE `cart_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `combined_orders`
--
ALTER TABLE `combined_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_cart_report_id_foreign` FOREIGN KEY (`cart_report_id`) REFERENCES `cart_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart_reports`
--
ALTER TABLE `cart_reports`
  ADD CONSTRAINT `cart_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `combined_orders`
--
ALTER TABLE `combined_orders`
  ADD CONSTRAINT `combined_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_combined_order_id_foreign` FOREIGN KEY (`combined_order_id`) REFERENCES `combined_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
