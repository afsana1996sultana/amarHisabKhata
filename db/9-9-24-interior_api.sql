-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2024 at 08:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interior_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `expense_heads`
--

CREATE TABLE `expense_heads` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_heads`
--

INSERT INTO `expense_heads` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Office Expense', 'office-expense', 1, '2024-08-27 08:12:57', '2024-08-27 08:12:57'),
(2, 'Material Buy', 'material-buy', 1, '2024-08-27 08:16:59', '2024-08-27 08:16:59'),
(3, 'Labour Cost', 'labour-cost', 1, '2024-08-27 08:17:08', '2024-08-27 08:17:08'),
(4, 'Staff Salary', 'staff-salary', 1, '2024-08-27 08:17:21', '2024-08-27 08:17:21');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_08_042852_create_customers_table', 1),
(6, '2024_06_09_103612_create_settings_table', 1),
(7, '2024_07_03_064958_create_payments_table', 1),
(8, '2024_07_08_043232_create_payment_methods_table', 2),
(9, '2024_08_26_121835_create_projects_table', 3),
(10, '2024_08_27_130932_create_expense_heads_table', 4),
(12, '2024_08_28_150537_create_roles_table', 5),
(13, '2024_08_28_182316_create_staff_table', 6);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `project_id` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_value` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid` int DEFAULT NULL,
  `due` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `next_due` int DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `project_id`, `customer_name`, `customer_phone`, `project_name`, `project_value`, `paid`, `due`, `amount`, `next_due`, `payment_type`, `date`, `note`, `status`, `created_at`, `updated_at`) VALUES
(7, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 10000, 90000, 5000, 85000, 'Bank', '2024-08-29', 'test purpose', 0, '2024-08-29 12:44:05', '2024-08-29 12:44:05'),
(8, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 15000, 85000, 45000, 40000, 'Bkash', '2024-08-29', 'segdhn', 0, '2024-08-29 12:44:38', '2024-08-29 12:44:38'),
(14, '33', 'Afsana Sultana', '01753142981', 'Test Project', '250000', 50000, 200000, 1000, 199000, 'Bank', '2024-08-31', 'Bank Payment', 0, '2024-08-31 08:46:05', '2024-08-31 08:46:05'),
(15, '33', 'Afsana Sultana', '01753142981', 'Test Project', '250000', 51000, 199000, 199000, 0, 'Bank', '2024-08-30', 'Bank Payment', 0, '2024-08-31 08:47:43', '2024-08-31 08:47:43'),
(16, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 60000, 40000, 10000, 30000, 'Bkash', '2024-08-31', 'Bkash Payment', 0, '2024-08-31 09:03:00', '2024-08-31 09:03:00'),
(17, '25', 'Namjul Hasan', '01753142981', 'Classic IT', '72000', 2000, 70000, 70000, 0, 'Bank', '2024-08-31', 'Bank Payment', 0, '2024-08-31 09:04:06', '2024-08-31 09:04:06'),
(18, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 70000, 30000, 10000, 20000, 'Bkash', '2024-08-31', 'Bkash payment', 0, '2024-08-31 10:30:19', '2024-08-31 10:30:19'),
(19, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 80000, 20000, 1000, 19000, 'Bkash', '2024-08-31', 'Payment from Bkash', 0, '2024-08-31 11:17:54', '2024-08-31 11:17:54'),
(20, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 81000, 19000, 1000, 18000, 'Cash', '2024-08-31', 'Cash Payment', 0, '2024-08-31 12:09:33', '2024-08-31 12:09:33'),
(21, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 82000, 18000, 1000, 17000, 'Bank', '2024-08-31', NULL, 0, '2024-08-31 12:31:14', '2024-08-31 12:31:14'),
(23, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 83000, 17000, 1000, 16000, 'Bkash', '2024-09-01', NULL, 0, '2024-09-01 09:46:50', '2024-09-01 09:46:50'),
(33, '26', 'Skyler Mcfadden', '01753142981', 'Kimberley Robbins', '50000', 4000, 46000, 10000, 36000, NULL, NULL, NULL, 0, '2024-09-02 04:25:20', '2024-09-02 04:25:20'),
(53, '30', 'Safat', '01906897865', 'Interior Part two', '100000', 84000, 16000, NULL, 16000, NULL, NULL, NULL, 0, '2024-09-08 07:59:12', '2024-09-08 07:59:12'),
(54, '37', 'Nafi', '01906897805', 'Interior Part two', '100000', 10000, 90000, 90000, 0, 'Bkash', '2024-09-13', 'fdfdf', 0, '2024-09-08 11:35:38', '2024-09-08 11:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'myApp', 'd339609ba151d01f2e5bc9fdb14f8e74d92e869ce8e9cad79ecee9684fe70470', '[\"*\"]', NULL, NULL, '2024-08-25 08:33:36', '2024-08-25 08:33:36'),
(2, 'App\\Models\\User', 1, 'myApp', '00aeed410db8da4a969f2c9af71aae0609c3506ea54bcd7164141b87124a24bc', '[\"*\"]', NULL, NULL, '2024-08-25 08:34:48', '2024-08-25 08:34:48'),
(3, 'App\\Models\\User', 1, 'myApp', 'c13ce9918d28bf80372750c2d11a41c38536017715e9bacba206a8bc96c3fc59', '[\"*\"]', NULL, NULL, '2024-08-25 08:36:27', '2024-08-25 08:36:27'),
(4, 'App\\Models\\User', 1, 'myApp', '6e6678d38f316a993518774599f4d4159782a312e58937b43349ebb5acf61e79', '[\"*\"]', NULL, NULL, '2024-08-25 08:39:11', '2024-08-25 08:39:11'),
(5, 'App\\Models\\User', 1, 'myApp', 'aea31a991c407f7978af0082e5533babae24c857663bb84af10753b2968307e3', '[\"*\"]', NULL, NULL, '2024-08-25 08:43:57', '2024-08-25 08:43:57'),
(6, 'App\\Models\\User', 1, 'myApp', '54e1e2abd345aa5265f9136aeeb2e8b8289949a0c6cc0f7ad6265da5a3f717b3', '[\"*\"]', NULL, NULL, '2024-08-25 08:45:37', '2024-08-25 08:45:37'),
(7, 'App\\Models\\User', 5, 'myApp', '01b93987d5d900292784275aac16f71ce3cc5c53def472e1b0b85764e3dcecfd', '[\"*\"]', NULL, NULL, '2024-08-25 08:48:26', '2024-08-25 08:48:26'),
(8, 'App\\Models\\User', 1, 'myApp', '539e8ea31e1394e6ef563b316e459466bf49af6137120621d5751f0e500bac8c', '[\"*\"]', NULL, NULL, '2024-08-25 08:48:41', '2024-08-25 08:48:41'),
(9, 'App\\Models\\User', 1, 'myApp', 'd777af55aea65989ed0b52611d5ea4547d8e4a32487fb26f04fec3aea009ecf4', '[\"*\"]', '2024-08-25 10:56:15', NULL, '2024-08-25 09:41:21', '2024-08-25 10:56:15'),
(10, 'App\\Models\\User', 5, 'myApp', '40da7ff87cf6c511874e2ccd2520cf534989e2bde5467397b3fb34ad68462d22', '[\"*\"]', '2024-08-25 10:59:35', NULL, '2024-08-25 10:56:08', '2024-08-25 10:59:35'),
(11, 'App\\Models\\User', 5, 'myApp', '5d7f6c585b6028cf3226341de70832b0d74c1b92909ea03c139326a429ca7b3b', '[\"*\"]', '2024-08-25 11:06:18', NULL, '2024-08-25 10:59:45', '2024-08-25 11:06:18'),
(12, 'App\\Models\\User', 1, 'myApp', '91cc05a4ad41fd3df40f4e249f4c254f1e415badbbb91969ba817ade45be41ad', '[\"*\"]', '2024-08-25 11:06:51', NULL, '2024-08-25 11:05:59', '2024-08-25 11:06:51'),
(13, 'App\\Models\\User', 5, 'myApp', 'd92aea2287f18844a985cdb7f44b73715c307c6878bc859862ca5b807ad710b8', '[\"*\"]', '2024-08-25 11:07:43', NULL, '2024-08-25 11:07:03', '2024-08-25 11:07:43'),
(14, 'App\\Models\\User', 5, 'myApp', '3cc715638f7d090c053b59c2bdf409c2881c0c61e180c18d2da3827f7a30372d', '[\"*\"]', '2024-08-25 11:12:02', NULL, '2024-08-25 11:08:25', '2024-08-25 11:12:02'),
(15, 'App\\Models\\User', 1, 'myApp', 'b27b72ef4a9949b62a874599043dfb58e3a12a78cdeb9e87b60cc7bcf34f76d7', '[\"*\"]', '2024-08-25 11:13:34', NULL, '2024-08-25 11:11:40', '2024-08-25 11:13:34'),
(16, 'App\\Models\\User', 5, 'myApp', 'fa83fecae605c84e445aefd148545c67d90cb834d2dc82f7131c1d46d49aaffd', '[\"*\"]', '2024-08-26 04:26:29', NULL, '2024-08-25 11:24:05', '2024-08-26 04:26:29'),
(17, 'App\\Models\\User', 5, 'myApp', '6f3f7b781f575770ee0e9b48137c181da64d047376d9db0e16b35f942c76ff4d', '[\"*\"]', NULL, NULL, '2024-08-25 12:39:52', '2024-08-25 12:39:52'),
(18, 'App\\Models\\User', 1, 'myApp', '6a2ba4f0d94bc693b3a4fa5bdd0e6270daadbfd2dbb2c9bd4caf1d95db4bd4fc', '[\"*\"]', '2024-08-26 10:20:05', NULL, '2024-08-26 04:26:17', '2024-08-26 10:20:05'),
(19, 'App\\Models\\User', 5, 'myApp', 'b9ac92f7378c40bacd09d1b1bb31104a1ea6902f1d9d96faf763615b97fd9f05', '[\"*\"]', '2024-08-26 10:20:48', NULL, '2024-08-26 10:19:53', '2024-08-26 10:20:48'),
(20, 'App\\Models\\User', 1, 'myApp', '7fceb60b0ec3785944c684cf9987134dc87d1161a1c1204564413cea85d70f5b', '[\"*\"]', '2024-09-02 04:54:34', NULL, '2024-08-26 10:21:02', '2024-09-02 04:54:34'),
(21, 'App\\Models\\User', 1, 'myApp', '577c9d8391ef17bd2adbf04c2de8fc21af425455b16fc842c71392249b37896f', '[\"*\"]', NULL, NULL, '2024-08-28 05:03:49', '2024-08-28 05:03:49'),
(22, 'App\\Models\\User', 1, 'myApp', '5f917e6b08cbfe370720d472db1662b74a52027d8bca963ce5014d90cbcc32e6', '[\"*\"]', '2024-09-08 07:59:12', NULL, '2024-09-08 04:45:16', '2024-09-08 07:59:12'),
(23, 'App\\Models\\User', 1, 'myApp', '62bb179c277eb6197eb77a7279abaf9632c4ac5402cc9e30ccb3b52ca1752a5b', '[\"*\"]', '2024-09-08 10:08:17', NULL, '2024-09-08 09:28:45', '2024-09-08 10:08:17'),
(24, 'App\\Models\\User', 1, 'myApp', 'aca992da679bfbf655a9656506ee10d62f2b7ae4a97bef0c4c990ed1b8720397', '[\"*\"]', '2024-09-08 10:17:35', NULL, '2024-09-08 10:17:12', '2024-09-08 10:17:35'),
(25, 'App\\Models\\User', 1, 'myApp', '6007202e69d9359851286ff8e37ba0b0acd8914a67280f9ca32b31edf46ee2f1', '[\"*\"]', '2024-09-08 10:36:49', NULL, '2024-09-08 10:25:33', '2024-09-08 10:36:49'),
(26, 'App\\Models\\User', 1, 'myApp', '3d33c034b604ef5c0b6a20ad545349b0bf1f738ca55b56789be227d78c206d88', '[\"*\"]', NULL, NULL, '2024-09-08 10:59:25', '2024-09-08 10:59:25'),
(27, 'App\\Models\\User', 1, 'myApp', 'd7e5988f05dbe9f6d9367851e037d23894707da97fa2b315f73e363bb3195f05', '[\"*\"]', NULL, NULL, '2024-09-09 04:38:12', '2024-09-09 04:38:12'),
(28, 'App\\Models\\User', 1, 'myApp', '86ab3084d64f59ecb3296ae30c6d320fc37b5a547197fb1c0b9a210f4a8c9db0', '[\"*\"]', '2024-09-09 04:47:28', NULL, '2024-09-09 04:39:33', '2024-09-09 04:47:28'),
(29, 'App\\Models\\User', 1, 'myApp', 'b7107d99c0c5f65d81cfe2c8d7b3741a9cc13e7795831b0fe81979a86ddf0cdb', '[\"*\"]', '2024-09-09 04:49:51', NULL, '2024-09-09 04:49:17', '2024-09-09 04:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_value` int NOT NULL,
  `advance` int DEFAULT NULL,
  `project_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Started, 1=>Completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `customer_name`, `customer_phone`, `customer_email`, `address`, `project_name`, `project_value`, `advance`, `project_duration`, `date`, `status`, `created_at`, `updated_at`) VALUES
(25, 'Namjul Hasan', '01753142981', 'najmul@gmail.com', 'Uttara', 'Classic IT', 72000, 2000, '3 month', '2024-08-26', 1, '2024-08-26 12:21:29', '2024-09-01 12:46:13'),
(26, 'Skyler Mcfadden', '01753142981', 'vinexe@mailinator.com', 'Pariatur Quam dolor', 'Kimberley Robbins', 50000, 4000, 'Recusandae Odit nem', '1982-10-14', 1, '2024-08-26 12:22:56', '2024-09-08 12:10:31'),
(30, 'Safat', '01906897865', 'safat@gmail.com', 'Dhaka', 'Interior Part two', 100000, 10000, '50Days', '2024-09-26', 0, '2024-08-26 12:29:19', '2024-09-09 04:46:41'),
(31, 'Raymond Vance', '01753142981', 'gigopijo@mailinator.com', 'Earum voluptate natu', 'Neve Evans', 40000, 9000, 'Dolorem alias lorem', '2024-07-05', 0, '2024-08-26 12:39:16', '2024-08-26 12:39:16'),
(37, 'Nafi', '01906897805', 'nafi@gmail.com', 'Dhaka', 'Interior Part twoInterior Part twoInterior Part twoInterior Part twoInterior Part two', 100000, 10000, '60Days', '2024-09-26', 1, '2024-09-08 07:55:18', '2024-09-08 12:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Manager', 'null', '2024-08-28 10:51:58', '2024-08-28 10:51:58'),
(2, 'Sales Man', '[\"2\",\"3\"]', '2024-08-28 10:53:14', '2024-08-28 10:53:14'),
(3, 'Head of Sales', '[\"1\"]', '2024-08-28 11:20:30', '2024-09-01 10:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fav_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_title`, `prefix`, `header_logo`, `footer_logo`, `fav_icon`, `contact_number`, `email`, `address`, `fax`, `created_at`, `updated_at`) VALUES
(1, 'Test Name', 'Test Title', 'najmulhasan', 'images/setting/1725797150.webp', 'images/setting/1725797150.webp', 'images/setting/1725797150.webp', '012000000001', 'info@gmail.com', 'Dhaka Bangladesh', '01210111101', '2024-07-06 05:00:54', '2024-09-09 04:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `roles_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `roles_id`, `created_at`, `updated_at`) VALUES
(2, 29, 2, '2024-08-29 03:43:45', '2024-09-08 07:41:54'),
(3, 30, 3, '2024-08-29 03:44:35', '2024-08-29 03:44:35'),
(11, 38, 2, '2024-09-08 07:58:23', '2024-09-08 07:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Roles: 1=admin, 2=staff',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plain_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_role`, `email`, `phone`, `email_verified_at`, `password`, `plain_password`, `image`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1', 'admin@gmail.com', '01845900360', NULL, '$2y$12$cplz4/lZec6DV139SOL7TuwGb9XQMAzDxSSTFajNTnoOrMwdKK6mi', NULL, 'backend/assets/images/profile/elm9CuNir7.png', 'Gulshan', NULL, '2024-07-06 05:00:54', '2024-09-08 11:24:52'),
(29, 'Nafid', '2', 'dd@gmail.com', '01563255877', NULL, '$2y$12$HqAi3Wjhp8WN4s/kSE8nhunAOo3O7Un33eB7zmgTtkwMlvolNrDQG', NULL, 'backend/assets/images/staff/i7s7vhhFRW.png', 'Gulshan', NULL, '2024-08-29 03:43:45', '2024-09-08 11:27:01'),
(30, 'Soudia Mannan', '2', 'soudia@gmail.com', '01753698547', NULL, '$2y$12$1sknvus98Pv575T9oK.Wce6iyxdIN0UyCQOKPcZXhMb7AqOZWXZpi', NULL, 'backend/assets/images/staff/EXw4AXiOqq.png', 'Uttara', NULL, '2024-08-29 03:44:35', '2024-09-01 04:59:06'),
(38, 'Tasfi', '2', 'taseew1@gmail.com', '01563450800', NULL, '$2y$12$ZMES/Ru89CkoElMjyCDKP.3Qm0y15JyfM9SFN0tZnBg7DGDRAl.4.', NULL, NULL, 'Dhaka', NULL, '2024-09-08 07:58:23', '2024-09-08 07:58:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expense_heads`
--
ALTER TABLE `expense_heads`
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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_user_id_foreign` (`user_id`),
  ADD KEY `staff_roles_id_foreign` (`roles_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expense_heads`
--
ALTER TABLE `expense_heads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
