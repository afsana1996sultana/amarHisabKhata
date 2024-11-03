-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 10:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `work_permit_bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `passport_number` varchar(255) NOT NULL,
  `country_origin` varchar(255) NOT NULL,
  `work_permit_number` varchar(255) NOT NULL,
  `permit_validity_period` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `organization_tax_code` varchar(255) NOT NULL,
  `work_region` varchar(255) NOT NULL,
  `issue_data_and_time` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `date_of_birth`, `passport_number`, `country_origin`, `work_permit_number`, `permit_validity_period`, `position`, `organization`, `organization_tax_code`, `work_region`, `issue_data_and_time`, `status`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Gillian', 'bywyk', '2013-07-22', 'tukose', 'ranyt', 'wadeqe', '1981-12-28', 'bepoga', 'nirar', 'zekaq', 'Enim voluptatem aut', '2010-01-06 00:00:00', 2, 'images/customer/1717997004.png', 'Tempore quis in con', '2024-06-09 23:23:24', '2024-06-09 23:23:24'),
(2, 'Alisa', 'kufihor', '2009-07-24', 'lawutudo', 'wybeg', 'jiqehyjafo', '1991-03-18', 'modag', 'jecojukyvu', 'wijiwa', 'Tempor rerum non dol', '2004-05-05 00:00:00', 1, 'images/customer/1717997017.jpg', 'Amet sit ex volupt', '2024-06-09 23:23:37', '2024-06-09 23:23:37'),
(3, 'Cara', 'kityv', '2003-12-30', 'winyfomymy', 'xigubisava', 'riwawacav', '2002-08-12', 'mejiq', 'vikuwaf', 'juqoqy', 'Quod ullam consectet', '1990-04-09 00:00:00', 1, 'images/customer/1717997028.jpg', 'Nobis consequatur M', '2024-06-09 23:23:48', '2024-06-09 23:23:48'),
(4, 'Duncan', 'jemyja', '1976-08-31', 'beqalyzez', 'qasube', 'xekova', '1982-02-20', 'gepibax', 'ryzix', 'cirecy', 'In aut anim voluptat', '2006-03-13 00:00:00', 2, 'images/customer/1717997040.jpeg', 'In esse non velit n', '2024-06-09 23:24:00', '2024-06-09 23:24:00'),
(5, 'Odessa', 'gagikojyhy', '1971-04-05', 'tonavusun', 'byvuhon', 'buwequbeda', '1995-09-04', 'terewulywu', 'rosogoba', 'ryparyj', 'Enim nostrud non ad', '1995-06-11 00:00:00', 1, 'images/customer/1718007088.jpeg', 'Eos reiciendis labor', '2024-06-10 02:11:28', '2024-06-10 02:11:28'),
(6, 'Preston', 'rupogariq', '2006-11-22', 'jalikiq', 'decuk', 'myhujufu', '1975-12-12', 'jibajubu', 'pofudegi', 'pawirosys', 'Esse et pariatur Do', '2023-07-23 00:00:00', 1, 'images/customer/1718007100.png', 'Omnis magnam qui et', '2024-06-10 02:11:40', '2024-06-10 02:11:40'),
(7, 'Daria', 'fazuvogy', '2018-08-08', 'kuhijenec', 'zokiqitel', 'giwici', '2005-11-20', 'nugeq', 'mopyladyr', 'zyvude', 'Pariatur Esse debit', '1983-11-03 00:00:00', 2, 'images/customer/1718007141.webp', 'In sed dolor ea dese', '2024-06-10 02:12:21', '2024-06-10 02:12:21'),
(8, 'Keane', 'pycajoson', '2014-09-14', 'fosibividy', 'jetyjit', 'mutiwyp', '1970-02-14', 'tiducyhura', 'kysamynu', 'tuduparov', 'Omnis recusandae De', '1977-05-15 00:00:00', 1, 'images/customer/1718007155.jpg', 'Explicabo Sint odi', '2024-06-10 02:12:35', '2024-06-10 02:12:35'),
(9, 'testr', 'asfdsafd', '2024-06-12', '3245324534', 'asdfasdf', '43534543', '2024-06-12', 'asdfsdf', 'asfasdfsa', 'asfasdf', 'asfdasdfasd', '2024-06-11 00:00:00', 1, 'images/customer/1718086761.jpg', 'asfdasdf', '2024-06-11 00:19:21', '2024-06-11 00:19:21'),
(10, 'Declan', 'mudumig', '2024-06-10', 'hysutot', 'kuzemodefo', 'buvyzeqy', '12-04-2024 12:00 PM - 23-05-2024 08:00 PM', 'memob', 'povuqybaxi', 'fotywy', 'Exercitation sunt ni', '2020-06-27 00:00:00', 2, 'images/customer/1718173977.jpg', 'Qui necessitatibus l', '2024-06-12 00:32:57', '2024-06-12 00:32:57'),
(11, 'Madison', 'bikef', '2000-04-10', 'rupegaruw', 'vyqaronijo', 'viqupuw', '22-06-2024 - 07-08-2024', 'bocopo', 'cefexeg', 'cabusyli', 'Autem et ab quidem t', '1981-10-07 00:00:00', 1, 'images/customer/1718174200.jpg', 'Veniam perferendis', '2024-06-12 00:36:40', '2024-06-12 00:41:58'),
(12, 'Neil', 'wymiwum', '1986-01-06', 'lecacu', 'picac', 'suwetafoj', '12-06-2024 - 30-06-2024', 'bapigit', 'pipygu', 'xuzekywe', 'Elit aliquip distin', '2007-04-25 00:00:00', 2, 'images/customer/1718174758.jpg', 'Cupiditate minus quo', '2024-06-12 00:45:58', '2024-06-12 00:45:58');

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
(5, '2024_06_08_042852_create_customers_table', 1),
(6, '2024_06_09_103612_create_settings_table', 2);

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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `header_logo` varchar(255) DEFAULT NULL,
  `footer_logo` varchar(255) DEFAULT NULL,
  `fav_icon` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_title`, `header_logo`, `footer_logo`, `fav_icon`, `contact_number`, `email`, `address`, `fax`, `created_at`, `updated_at`) VALUES
(1, 'Work Permit', 'Work Permit', 'images/setting/1717999228.png', 'images/setting/1717999255.png', 'images/setting/1717999255.png', '012412412', 'test@gmail.com', 'Dhaka Bangladesh', '1234514500', NULL, '2024-06-10 00:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `image`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '123456045', NULL, '$2y$12$esR03NfpGvVqOBpKuvFJ0.l7LmDO6q9KWnUWsn.jF/iqfE4XO8.62', 'images/admin/1717996671.png', 'Dhaka Bangaldeshs', NULL, '2024-06-09 04:12:21', '2024-06-10 03:14:30');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
