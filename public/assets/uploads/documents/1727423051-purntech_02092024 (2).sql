-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 10:31 AM
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
-- Database: `purntech_02092024`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adm_id` bigint(20) UNSIGNED NOT NULL,
  `adm_first_name` varchar(50) NOT NULL,
  `adm_last_name` varchar(50) NOT NULL,
  `adm_email` varchar(100) NOT NULL,
  `adm_mobile` varchar(15) NOT NULL,
  `adm_username` varchar(50) NOT NULL,
  `adm_password` longtext NOT NULL,
  `adm_visible_password` varchar(255) NOT NULL,
  `adm_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - Inactive, 1 - Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adm_id`, `adm_first_name`, `adm_last_name`, `adm_email`, `adm_mobile`, `adm_username`, `adm_password`, `adm_visible_password`, `adm_status`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', 'admin@gmail.com', '1234567890', 'SA16092024', '$2y$12$7IgTTT8pNEgSeda0KE6TQu6StEY9l5UbxlUc4cnVleerN1sdXb/nS', 'demo', 1, '2024-09-16 06:38:32', '2024-09-16 06:38:32');

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
-- Table structure for table `company_infos`
--

CREATE TABLE `company_infos` (
  `cmp_id` bigint(20) UNSIGNED NOT NULL,
  `cmp_name` varchar(255) NOT NULL,
  `cmp_short_name` varchar(255) NOT NULL,
  `cmp_logo` longtext DEFAULT NULL,
  `cmp_mobile1` varchar(15) NOT NULL,
  `cmp_mobile2` varchar(15) DEFAULT NULL,
  `cmp_mobile3` varchar(15) DEFAULT NULL,
  `cmp_primary_email` varchar(100) NOT NULL,
  `cmp_support_email` varchar(100) DEFAULT NULL,
  `cmp_contact_email` varchar(100) DEFAULT NULL,
  `cmp_website` varchar(100) DEFAULT NULL,
  `cmp_gst_no` varchar(50) DEFAULT NULL,
  `cmp_landmark` varchar(255) DEFAULT NULL,
  `cmp_city` varchar(50) DEFAULT NULL,
  `cmp_state` varchar(50) DEFAULT NULL,
  `cmp_country` varchar(50) DEFAULT NULL,
  `cmp_zip` int(11) DEFAULT NULL,
  `cmp_address1` varchar(255) DEFAULT NULL,
  `cmp_address2` varchar(255) DEFAULT NULL,
  `cmp_address3` varchar(255) DEFAULT NULL,
  `cmp_doc1` longtext DEFAULT NULL,
  `cmp_doc2` longtext DEFAULT NULL,
  `cmp_doc3` longtext DEFAULT NULL,
  `cmp_doc4` longtext DEFAULT NULL,
  `cmp_doc5` longtext DEFAULT NULL,
  `cmp_doc6` longtext DEFAULT NULL,
  `cmp_doc7` longtext DEFAULT NULL,
  `cmp_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `enq_id` bigint(20) UNSIGNED NOT NULL,
  `enq_user_first_name` varchar(50) NOT NULL,
  `enq_user_last_name` varchar(50) NOT NULL,
  `enq_user_email` varchar(100) NOT NULL,
  `enq_user_mobile` varchar(15) NOT NULL,
  `enq_user_service` varchar(255) NOT NULL,
  `enq_user_date` date NOT NULL,
  `enq_user_profile_photo` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`enq_id`, `enq_user_first_name`, `enq_user_last_name`, `enq_user_email`, `enq_user_mobile`, `enq_user_service`, `enq_user_date`, `enq_user_profile_photo`, `created_at`, `updated_at`) VALUES
(1, 'Chandra', 'Kishor', 'ckg4155@gmail.com', '8678861104', '2', '2024-09-07', NULL, '2024-09-06 10:11:33', '2024-09-06 10:11:33'),
(2, 'Nikhil', 'Prem', 'nikhilroy855@gmail.com', '9508181434', '1', '2024-09-10', NULL, '2024-09-09 16:35:27', '2024-09-09 16:35:27'),
(3, 'Ketan', 'Gupta', 'ckg41555@gmail.com', '8709250721', '2', '2024-09-17', NULL, '2024-09-15 06:38:58', '2024-09-15 06:38:58');

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
  `inv_id` bigint(20) UNSIGNED NOT NULL,
  `inv_number` varchar(100) NOT NULL,
  `inv_party_id` bigint(20) NOT NULL COMMENT 'This column contains web users id',
  `inv_party_name` varchar(255) NOT NULL,
  `inv_party_address_1` varchar(255) NOT NULL,
  `inv_party_address_2` varchar(255) DEFAULT NULL,
  `inv_party_mobile1` varchar(15) NOT NULL,
  `inv_party_mobile2` varchar(15) DEFAULT NULL,
  `inv_message` longtext DEFAULT NULL,
  `inv_amount` int(11) NOT NULL,
  `inv_date` date NOT NULL,
  `inv_due_date` date NOT NULL,
  `inv_paid_amt` int(11) DEFAULT NULL,
  `inv_pay_mode` varchar(30) DEFAULT NULL,
  `inv_pay_date` date DEFAULT NULL,
  `inv_pay_ref` varchar(100) DEFAULT NULL,
  `inv_pay_screenshot` longtext DEFAULT NULL,
  `inv_status` tinyint(4) NOT NULL DEFAULT 1,
  `inv_created_by` tinyint(4) NOT NULL COMMENT 'This column contains admin id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`inv_id`, `inv_number`, `inv_party_id`, `inv_party_name`, `inv_party_address_1`, `inv_party_address_2`, `inv_party_mobile1`, `inv_party_mobile2`, `inv_message`, `inv_amount`, `inv_date`, `inv_due_date`, `inv_paid_amt`, `inv_pay_mode`, `inv_pay_date`, `inv_pay_ref`, `inv_pay_screenshot`, `inv_status`, `inv_created_by`, `created_at`, `updated_at`) VALUES
(1, 'BIWTS/26/09/2024/24CK1104', 1, 'Chandra Kishor', 'Mahadev Asthan, Brahmpur Bazar', 'Phulwari Sharif, Patna - 801505', '8678861104', '8709250721', 'JIO welcomes you. We are pleased to inform you that your application for the installation of a JIO tower has been accepted. The address mentioned by you has been secretly verified by the company team. Below are the details as captured in JIO\'s records. Please review carefully and inform us immediately of any discrepancies.', 27260, '2024-09-01', '2024-09-10', NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-09-26 06:47:30', '2024-09-26 06:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_description_amounts`
--

CREATE TABLE `invoice_description_amounts` (
  `ida_id` bigint(20) UNSIGNED NOT NULL,
  `ida_inv_id` varchar(255) NOT NULL,
  `ida_inv_no` varchar(255) NOT NULL,
  `ida_description` varchar(255) NOT NULL,
  `ida_amount` varchar(255) NOT NULL,
  `ida_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_description_amounts`
--

INSERT INTO `invoice_description_amounts` (`ida_id`, `ida_inv_id`, `ida_inv_no`, `ida_description`, `ida_amount`, `ida_status`, `created_at`, `updated_at`) VALUES
(1, '1', 'BIWTS/26/09/2024/24CK1104', 'Loan Amount', '25000', 1, '2024-09-26 06:47:30', '2024-09-26 06:47:30'),
(2, '1', 'BIWTS/26/09/2024/24CK1104', 'Processing Charge', '260', 1, '2024-09-26 06:47:30', '2024-09-26 06:47:30'),
(3, '1', 'BIWTS/26/09/2024/24CK1104', 'Other Charges', '2000', 1, '2024-09-26 06:47:30', '2024-09-26 06:47:30');

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
(4, '2024_09_03_090519_create_enquiries_table', 2),
(5, '2024_09_03_090542_create_web_users_table', 2),
(6, '2024_09_03_090554_create_admins_table', 2),
(7, '2024_09_03_094206_create_otp_records_table', 2),
(8, '2024_09_05_144046_create_user_documents_table', 3),
(9, '2024_09_12_131802_create_user_bank_details_table', 4),
(10, '2024_09_14_152556_create_invoices_table', 5),
(11, '2024_09_14_153643_create_company_infos_table', 6),
(12, '2024_09_25_121313_create_invoice_description_amounts_table', 7),
(13, '2024_09_25_130844_create_invoice_logos_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `otp_records`
--

CREATE TABLE `otp_records` (
  `otp_id` bigint(20) UNSIGNED NOT NULL,
  `otp_code` int(11) NOT NULL,
  `otp_initiated_by` bigint(20) NOT NULL,
  `otp_initiated_for` varchar(255) NOT NULL,
  `otp_user_type` varchar(10) NOT NULL,
  `otp_sent_to` varchar(15) NOT NULL,
  `otp_message` varchar(255) NOT NULL,
  `otp_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 - Unused/active, 1 - Used/Expired',
  `otp_expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_records`
--

INSERT INTO `otp_records` (`otp_id`, `otp_code`, `otp_initiated_by`, `otp_initiated_for`, `otp_user_type`, `otp_sent_to`, `otp_message`, `otp_status`, `otp_expires_at`, `created_at`, `updated_at`) VALUES
(1, 320172, 1, 'Login', 'User', '8678861104', '320172 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-06 16:23:28', '2024-09-06 10:45:28', '2024-09-06 10:48:37'),
(2, 470883, 1, 'Login', 'User', '8678861104', '470883 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-06 16:30:50', '2024-09-06 10:52:50', '2024-09-10 07:00:16'),
(3, 792266, 1, 'Login', 'User', '8678861104', '792266 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-06 16:31:24', '2024-09-06 10:53:24', '2024-09-06 10:53:44'),
(4, 347310, 1, 'Login', 'User', '8678861104', '347310 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-07 11:58:27', '2024-09-07 06:20:27', '2024-09-07 06:20:46'),
(5, 202933, 1, 'Login', 'User', '8678861104', '202933 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-08 12:19:22', '2024-09-08 06:41:22', '2024-09-08 06:41:41'),
(6, 965090, 1, 'Login', 'User', '8678861104', '965090 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-08 13:39:58', '2024-09-08 08:01:58', '2024-09-08 08:02:17'),
(7, 712701, 1, 'Login', 'User', '8678861104', '712701 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-09 17:22:08', '2024-09-09 11:44:08', '2024-09-09 11:44:45'),
(8, 512061, 2, 'Login', 'User', '9508181434', '512061 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-09 22:13:44', '2024-09-09 16:35:44', '2024-09-09 16:36:06'),
(9, 640964, 1, 'Login', 'User', '8678861104', '640964 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-10 12:37:49', '2024-09-10 06:59:49', '2024-09-10 07:00:55'),
(10, 626605, 1, 'Login', 'User', '8678861104', '626605 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-11 17:05:37', '2024-09-11 11:27:37', '2024-09-11 11:27:58'),
(11, 538110, 1, 'Login', 'User', '8678861104', '538110 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-11 20:33:42', '2024-09-11 14:55:42', '2024-09-11 14:56:00'),
(12, 940541, 1, 'Login', 'User', '8678861104', '940541 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-12 12:45:36', '2024-09-12 07:07:36', '2024-09-12 07:07:49'),
(13, 690392, 1, 'Login', 'User', '8678861104', '690392 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-13 23:05:49', '2024-09-13 17:27:49', '2024-09-13 17:28:01'),
(14, 442980, 1, 'Login', 'User', '8678861104', '442980 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-14 15:01:30', '2024-09-14 09:23:30', '2024-09-14 09:23:58'),
(15, 464543, 1, 'Login', 'User', '8678861104', '464543 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-14 17:39:23', '2024-09-14 12:01:23', '2024-09-14 12:01:53'),
(16, 611017, 1, 'Login', 'User', '8678861104', '611017 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-15 18:41:08', '2024-09-15 13:03:08', '2024-09-15 13:03:28'),
(17, 600793, 1, 'Login', 'User', '8678861104', '600793 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-16 12:03:16', '2024-09-16 06:25:16', '2024-09-16 06:25:39'),
(18, 240422, 1, 'Login', 'User', '8678861104', '240422 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-16 14:12:04', '2024-09-16 08:34:04', '2024-09-16 08:34:21'),
(19, 653815, 1, 'Login', 'User', '8678861104', '653815 is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT', 1, '2024-09-18 15:56:38', '2024-09-18 10:18:38', '2024-09-18 10:18:52');

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
('bXcqnmxF3HAaXwRhNWHyjtQuvNbjwkVBXs8cMMcm', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiMDZKMWpia2ZjbVU4ZGZjMVNJM256QmJScVp6eVAyeFNzeGJQT2lMTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sb2NhbGhvc3QvcHVybnRlY2gtcHJvai0xL2FkbWluL3VzZXItaW52b2ljZXMtcGFnZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6ODoibG9nZ2VkaW4iO3M6NToiYWRtaW4iO3M6MzoidWlkIjtpOjE7czo5OiJmdXNlcm5hbWUiO3M6NToiU3VwZXIiO3M6OToibHVzZXJuYW1lIjtzOjU6IkFkbWluIjt9', 1727333733);

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `ubd_id` bigint(20) UNSIGNED NOT NULL,
  `ubd_usr_id` bigint(20) NOT NULL,
  `ubd_user_name` varchar(100) NOT NULL,
  `ubd_user_pan` varchar(10) NOT NULL,
  `ubd_user_name_in_bank` varchar(100) NOT NULL,
  `ubd_user_bank_name` varchar(100) DEFAULT NULL,
  `ubd_user_bank_name_other` varchar(100) DEFAULT NULL,
  `ubd_user_bank_acc` varchar(20) NOT NULL,
  `ubd_user_ifsc` varchar(11) NOT NULL,
  `ubd_user_bank_proof` longtext NOT NULL,
  `ubd_user_kyc_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 - Pending, 2 - Verified, 3 - Rejected, 0 - Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_bank_details`
--

INSERT INTO `user_bank_details` (`ubd_id`, `ubd_usr_id`, `ubd_user_name`, `ubd_user_pan`, `ubd_user_name_in_bank`, `ubd_user_bank_name`, `ubd_user_bank_name_other`, `ubd_user_bank_acc`, `ubd_user_ifsc`, `ubd_user_bank_proof`, `ubd_user_kyc_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Chandra Kishor', 'ckzpg6171p', 'Chandra Kishor Gupta', 'Other', 'Kotak 811', '123456789', 'kkbk0002544', '1726315685-Approval Letter.pdf', 1, '2024-09-14 12:08:05', '2024-09-26 06:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `udc_id` bigint(20) UNSIGNED NOT NULL,
  `udc_name` varchar(255) NOT NULL COMMENT 'Physical file name',
  `udc_user_id` bigint(20) NOT NULL COMMENT 'Foregin Key',
  `udc_source` varchar(255) DEFAULT NULL COMMENT 'To locate where it comes from',
  `udc_doc_type` int(11) DEFAULT NULL,
  `udc_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - Deleted, 1 - Not Deleted/Not Verified, 2 - Verified, 3 - Rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`udc_id`, `udc_name`, `udc_user_id`, `udc_source`, `udc_doc_type`, `udc_status`, `created_at`, `updated_at`) VALUES
(1, '1725617493-bg_compose_background.png', 1, 'Enquiry Form', 1, 3, '2024-09-06 10:11:33', '2024-09-25 11:01:00'),
(2, '1725617493-bg_compose_background.png', 1, 'Enquiry Form', 2, 2, '2024-09-06 10:11:33', '2024-09-18 10:25:40'),
(3, '1725617493-bg_compose_background.png', 1, 'Enquiry Form', 3, 2, '2024-09-06 10:11:33', '2024-09-18 07:35:25'),
(4, '1725958414-androidparty.png', 1, 'User Document Page', 4, 2, '2024-09-10 08:53:34', '2024-09-10 08:53:34'),
(5, '1725958498-certificate.png', 1, 'User Document Page', 5, 2, '2024-09-10 08:54:58', '2024-09-10 08:54:58'),
(6, '1725958511-How to make excel entry form.txt', 1, 'User Document Page', 6, 2, '2024-09-10 08:55:11', '2024-09-10 08:55:11'),
(7, '1725958606-Application Form Corrected.pdf', 1, 'User Document Page', 7, 2, '2024-09-10 08:56:46', '2024-09-10 08:56:46'),
(8, '1725962071-Chandra_Kishor_Exp[1].pdf', 1, 'User Document Page', 1, 2, '2024-09-10 09:54:31', '2024-09-22 14:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `web_users`
--

CREATE TABLE `web_users` (
  `usr_id` bigint(20) UNSIGNED NOT NULL,
  `usr_first_name` varchar(50) NOT NULL,
  `usr_last_name` varchar(50) NOT NULL,
  `usr_email` varchar(100) NOT NULL,
  `usr_mobile` varchar(15) NOT NULL,
  `usr_alt_mobile` varchar(15) DEFAULT NULL,
  `usr_gender` varchar(30) DEFAULT NULL,
  `usr_dob` date DEFAULT NULL,
  `usr_father` varchar(100) DEFAULT NULL,
  `usr_mother` varchar(100) DEFAULT NULL,
  `usr_full_address` varchar(256) DEFAULT NULL,
  `usr_landmark` varchar(256) DEFAULT NULL,
  `usr_service` varchar(255) NOT NULL,
  `usr_date` date NOT NULL,
  `usr_profile_photo` longtext DEFAULT NULL,
  `usr_username` varchar(50) NOT NULL,
  `usr_password` longtext DEFAULT NULL,
  `usr_visible_password` varchar(255) DEFAULT NULL,
  `usr_profile_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - Deleted, 1 - Unblocked/Unrestricted, 2 - Blocked/Restricted',
  `usr_verification_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 - Not Verified, 1 - Verified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_users`
--

INSERT INTO `web_users` (`usr_id`, `usr_first_name`, `usr_last_name`, `usr_email`, `usr_mobile`, `usr_alt_mobile`, `usr_gender`, `usr_dob`, `usr_father`, `usr_mother`, `usr_full_address`, `usr_landmark`, `usr_service`, `usr_date`, `usr_profile_photo`, `usr_username`, `usr_password`, `usr_visible_password`, `usr_profile_status`, `usr_verification_status`, `created_at`, `updated_at`) VALUES
(1, 'Chandra', 'Kishor', 'ckg4155@gmail.com', '8678861104', '8709250721', 'Male', '1999-07-01', 'Test', 'Demo', 'Phulwari Sharif, Patna - 801505', 'Mahadev Asthan, Brahmpur Bazar', '2', '2024-09-07', '1725708350-988439-naruto-shippuden-hinata-hyuga-new-hd-ultra-hd-desktop-background-wallpaper-for-4k-uhd-tv-widescreen-ultrawide-desktop-laptop-tablet.jpg', 'CHA43023', NULL, NULL, 1, 0, '2024-09-06 10:11:33', '2024-09-17 07:29:50'),
(2, 'Nikhil', 'Prem', 'nikhilroy855@gmail.com', '9508181434', NULL, 'Male', '1999-07-27', 'Test', 'Pinki Kumari', NULL, NULL, '1', '2024-09-10', '1725899987-ic_task_completed.png', 'NIK68711', NULL, NULL, 1, 0, '2024-09-09 16:35:27', '2024-09-17 07:30:30'),
(3, 'Ketan', 'Gupta', 'ckg41555@gmail.com', '8709250721', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '2024-09-17', NULL, 'KET85909', NULL, NULL, 1, 0, '2024-09-15 06:38:58', '2024-09-22 15:24:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adm_id`),
  ADD UNIQUE KEY `admins_adm_email_unique` (`adm_email`),
  ADD UNIQUE KEY `admins_adm_mobile_unique` (`adm_mobile`),
  ADD UNIQUE KEY `admins_adm_username_unique` (`adm_username`);

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
-- Indexes for table `company_infos`
--
ALTER TABLE `company_infos`
  ADD PRIMARY KEY (`cmp_id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`enq_id`);

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
  ADD PRIMARY KEY (`inv_id`),
  ADD UNIQUE KEY `invoices_inv_number_unique` (`inv_number`);

--
-- Indexes for table `invoice_description_amounts`
--
ALTER TABLE `invoice_description_amounts`
  ADD PRIMARY KEY (`ida_id`);

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
-- Indexes for table `otp_records`
--
ALTER TABLE `otp_records`
  ADD PRIMARY KEY (`otp_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`ubd_id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`udc_id`);

--
-- Indexes for table `web_users`
--
ALTER TABLE `web_users`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `web_users_usr_email_unique` (`usr_email`),
  ADD UNIQUE KEY `web_users_usr_mobile_unique` (`usr_mobile`),
  ADD UNIQUE KEY `web_users_usr_username_unique` (`usr_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adm_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_infos`
--
ALTER TABLE `company_infos`
  MODIFY `cmp_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `enq_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `inv_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_description_amounts`
--
ALTER TABLE `invoice_description_amounts`
  MODIFY `ida_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `otp_records`
--
ALTER TABLE `otp_records`
  MODIFY `otp_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `ubd_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `udc_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `web_users`
--
ALTER TABLE `web_users`
  MODIFY `usr_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
