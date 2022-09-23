-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2022 at 01:19 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cashbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobe1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobe2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobe3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `business_id`, `date`, `account`, `account_holder_id`, `account_holder_name`, `account_holder_phone`, `account_holder_bank`, `cheque_img`, `cheque_no`, `amount`, `tobe1`, `tobe2`, `tobe3`, `created_at`, `updated_at`) VALUES
(1, 2, '2022-09-16', '123', NULL, 'Test', '03025697856', 'test', '1663322479.png', '20', '5000', NULL, NULL, NULL, '2022-09-16 10:01:19', '2022-09-16 10:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `bill_books`
--

CREATE TABLE `bill_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `party` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_be2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_books`
--

INSERT INTO `bill_books` (`id`, `business_id`, `amount`, `detail`, `date`, `party`, `item`, `quantity`, `rate`, `method`, `to_be2`, `created_at`, `updated_at`) VALUES
(1, '2', '5000', 'Test Amount', '2022-09-06', NULL, NULL, NULL, NULL, 'cash', NULL, '2022-09-13 09:10:57', '2022-09-13 09:10:57'),
(6, '2', '5000', 'cash', '2022-09-22', NULL, 'test,Item', '10,10', '250,250', 'cash', NULL, '2022-09-22 09:52:37', '2022-09-22 09:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `user_id`, `business_name`, `created_at`, `updated_at`) VALUES
(2, 2, 'NSS', '2022-04-26 02:11:26', '2022-04-26 02:11:26'),
(4, 2, 'Test Business', '2022-09-09 07:04:27', '2022-09-09 07:04:27'),
(5, 2, 'Wholesale', '2022-09-09 07:19:07', '2022-09-09 07:19:07');

-- --------------------------------------------------------

--
-- Table structure for table `businesses_stocks`
--

CREATE TABLE `businesses_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_rate` decimal(8,2) DEFAULT NULL,
  `purchase_rate` decimal(8,2) DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in` decimal(8,2) DEFAULT NULL,
  `out` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `party` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bussinesses_customers`
--

CREATE TABLE `bussinesses_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_amount` float(8,2) DEFAULT 0.00,
  `got_amount` float(8,2) DEFAULT 0.00,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bussinesses_customers`
--

INSERT INTO `bussinesses_customers` (`id`, `date`, `customer_id`, `detail`, `given_amount`, `got_amount`, `bill`, `balance`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, NULL, 0.00, 20000.00, NULL, '20000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(2, NULL, 1, NULL, 0.00, 5000.00, NULL, '25000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(3, '2022-06-23', 2, 'cash', 0.00, 45000.00, NULL, '45000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(4, '2022-06-23', 2, NULL, 0.00, 4000.00, NULL, '49000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(5, '2022-06-23', 2, NULL, 0.00, 2000.00, NULL, '51000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(6, '2022-06-23', 2, NULL, 0.00, 0.00, NULL, '51000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(7, NULL, 3, NULL, 0.00, 5000.00, NULL, '5000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(8, NULL, 3, NULL, 0.00, 3000.00, NULL, '8000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(9, NULL, 3, NULL, 0.00, 50000.00, NULL, '58000.00', '2022-05-12 19:00:00', '2022-05-12 19:00:00'),
(10, '2022-06-23', 4, 'Test Amount', 2000.00, 0.00, 'no', '2000.00', NULL, NULL),
(11, '2022-06-16', 4, 'Test Amount', 0.00, 5000.00, 'no', '3000.00', NULL, NULL),
(12, NULL, 2, NULL, 60000.00, 0.00, NULL, '9000.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bussinesses_suppliers`
--

CREATE TABLE `bussinesses_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase` decimal(8,2) DEFAULT NULL,
  `payment` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bussinesses_suppliers`
--

INSERT INTO `bussinesses_suppliers` (`id`, `date`, `supplier_id`, `detail`, `purchase`, `payment`, `balance`, `bill`, `created_at`, `updated_at`) VALUES
(6, '2022-10-05', 2, 'cash', '855.00', NULL, '855.00', 'no', NULL, NULL),
(7, '2022-09-21', 1, 'cash', '52.00', NULL, '52.00', 'no', '2022-09-09 09:40:21', '2022-09-09 09:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `cashes`
--

CREATE TABLE `cashes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_books`
--

CREATE TABLE `cash_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_in` decimal(8,2) DEFAULT NULL,
  `cash_out` decimal(8,2) DEFAULT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_balance` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_books`
--

INSERT INTO `cash_books` (`id`, `business_id`, `date`, `amount`, `cash_in`, `cash_out`, `bill_no`, `party`, `detail`, `daily_balance`, `balance`, `created_at`, `updated_at`) VALUES
(1, '2', '2022-09-16', '5000', '5000.00', NULL, '41', 'Test Supplier', 'cash', NULL, NULL, '2022-09-16 11:24:39', '2022-09-16 11:24:39');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '123456789',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `business_id`, `name`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 2, 'Mehboob', '123456789', NULL, NULL),
(2, 2, 'Zahid', '123456789', NULL, NULL),
(3, 2, 'Ramaz', '123456789', NULL, NULL),
(4, 2, 'Test', '03008949530', '2022-06-22 23:51:58', '2022-06-22 23:51:58'),
(5, 5, 'Haider', '03004589631', '2022-09-09 07:20:07', '2022-09-09 07:20:07');

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
(5, '2022_04_21_072740_create_customers_table', 1),
(6, '2022_04_21_072757_create_suppliers_table', 1),
(7, '2022_04_23_094138_create_businesses_table', 1),
(8, '2022_04_24_064208_create_bussinesses_customers_table', 1),
(9, '2022_05_09_101933_create_bussinesses_suppliers_table', 2),
(10, '2022_05_10_050320_create_reports_table', 3),
(11, '2022_05_12_113903_create_temp_record_table', 4),
(70, '2022_06_24_075227_create_cashes_table', 5),
(73, '2022_06_28_042901_create_businesses_cashes_table', 5),
(85, '2022_06_24_075349_create_stocks_table', 6),
(86, '2022_06_27_051558_create_businesses_stocks_table', 6),
(87, '2022_07_01_060558_add_phone_to_users', 6),
(88, '2022_07_05_105042_create_cashes_table', 6),
(89, '2022_07_05_110501_add_business_id_to_stocks', 6),
(92, '2022_09_13_132931_create_bill_books_table', 7),
(100, '2022_09_15_100956_create_cash_books_table', 8),
(101, '2022_09_15_163726_create_stock_quantities_table', 8),
(107, '2022_09_16_111548_create_bank_accounts_table', 9);

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
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_amount` decimal(8,2) DEFAULT NULL,
  `got_amount` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_rate` decimal(8,2) DEFAULT NULL,
  `sale_rate` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `item_name`, `item_unit`, `purchase_rate`, `sale_rate`, `created_at`, `updated_at`, `business_id`) VALUES
(1, 'Rice', 'kg', '220.00', '240.00', '2022-09-22 11:04:14', '2022-09-22 11:04:14', 2);

-- --------------------------------------------------------

--
-- Table structure for table `stock_quantities`
--

CREATE TABLE `stock_quantities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sale_rate` decimal(8,2) DEFAULT NULL,
  `purchase_rate` decimal(8,2) DEFAULT NULL,
  `qty_in` decimal(8,2) DEFAULT NULL,
  `qty_out` decimal(8,2) DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `party` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_quantities`
--

INSERT INTO `stock_quantities` (`id`, `business_id`, `item_id`, `sale_rate`, `purchase_rate`, `qty_in`, `qty_out`, `detail`, `date`, `bill_no`, `amount`, `party`, `balance`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, '240.00', '25.00', NULL, 'Test', '2022-09-22', '35', '6000.00', 'Test Supplier 2', NULL, '2022-09-22 11:05:41', '2022-09-22 11:05:41'),
(2, 2, 1, '25.00', NULL, NULL, '10.00', 'Dolor qui cum quisqu', '1998-03-10', '31-Jul-2003', '840.00', 'Mehboob', NULL, '2022-09-22 11:09:04', '2022-09-22 11:09:04');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `business_id`, `name`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 2, 'Test Supplier', '03049758082', '2022-06-23 00:53:10', '2022-06-23 00:53:10'),
(2, 2, 'Test Supplier 2', '03008949530', '2022-06-23 00:55:34', '2022-06-23 00:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `temp_record`
--

CREATE TABLE `temp_record` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_amount` decimal(8,2) DEFAULT NULL,
  `got_amount` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unique_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-01 04:51:03', '2022-07-01 04:51:03', NULL),
(2, 'user', 'Test', 'testuser@mail.com', NULL, '$2y$10$9nmEt/RUqrRVxxKRLPKLY.2He7wfMvgaR0yVan37uawtFaaLphoqG', NULL, '2022-09-09 01:18:22', '2022-09-09 01:18:22', NULL),
(3, 'user', 'Test User', 'check@mail.com', NULL, '$2y$10$pxkWTSb.OzPi9Hnwpxm/RenDodxtMuzALvH7haiFmk4qWem/NgbL2', NULL, '2022-09-09 01:30:07', '2022-09-09 01:30:07', NULL),
(4, 'user', 'mehboob', 'mehboob@mail.com', NULL, '$2y$10$HwkTJR8ho9d3BM.kz10eqevCbw5GaL5z17j3iaTmxLceg.1ELU1cO', NULL, '2022-09-09 01:31:11', '2022-09-09 01:31:11', NULL),
(5, 'user', 'user', 'admin@mail.com', NULL, '$2y$10$YePdQVmLiWpsJddzFz5vMeoPnyOcYDpTPV3v.Q1xqcgk9ONi9GvrO', NULL, '2022-09-09 01:33:37', '2022-09-09 01:33:37', NULL),
(6, 'user', 'Kennedy May', 'gitica@mailinator.com', NULL, '$2y$10$kDWyfvfnVvv4alB.Siz1dOpcijVpEoWrNaPGhzUncEfQAqE7Eg1zO', NULL, '2022-09-09 01:35:14', '2022-09-09 01:35:14', NULL),
(7, 'user', 'Seth Hernandez', 'vido@mailinator.com', NULL, '$2y$10$r3FQGt5pPr2yo2GQbiX5yuJdX0vS7sjT6mL5H.YNPH/kli4Y9vKS2', NULL, '2022-09-09 01:36:12', '2022-09-09 01:36:12', NULL),
(8, 'user', 'Gail Phillips', 'poceqyk@mailinator.com', NULL, '$2y$10$c8xnxVoJoT2J/vaTM2oVH.vf1BYkfO.aRjAj08apQrvEV6D9u.PY6', NULL, '2022-09-09 06:40:00', '2022-09-09 06:40:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_books`
--
ALTER TABLE `bill_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `businesses_stocks`
--
ALTER TABLE `businesses_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bussinesses_customers`
--
ALTER TABLE `bussinesses_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bussinesses_suppliers`
--
ALTER TABLE `bussinesses_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_books`
--
ALTER TABLE `cash_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_business_id_foreign` (`business_id`);

--
-- Indexes for table `stock_quantities`
--
ALTER TABLE `stock_quantities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_record`
--
ALTER TABLE `temp_record`
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
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bill_books`
--
ALTER TABLE `bill_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `businesses_stocks`
--
ALTER TABLE `businesses_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bussinesses_customers`
--
ALTER TABLE `bussinesses_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bussinesses_suppliers`
--
ALTER TABLE `bussinesses_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_books`
--
ALTER TABLE `cash_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_quantities`
--
ALTER TABLE `stock_quantities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temp_record`
--
ALTER TABLE `temp_record`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
