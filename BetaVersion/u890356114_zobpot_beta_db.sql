-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 18, 2026 at 10:03 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u890356114_zobpot_beta_db`
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
(125, '2014_10_12_000000_create_users_table', 1),
(126, '2014_10_12_100000_create_password_resets_table', 1),
(127, '2019_08_19_000000_create_failed_jobs_table', 1),
(128, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(129, '2025_07_09_161702_create_tbl_job_category_table', 1),
(130, '2025_07_09_161937_create_tbl_sub_category_table', 1),
(131, '2025_07_09_162045_create_tbl_employee_type_table', 1),
(132, '2025_07_09_162353_create_tbl_job_type_table', 1),
(133, '2025_07_09_162517_create_tbl_job_level_table', 1),
(134, '2025_07_09_162549_create_tbl_work_type_table', 1),
(135, '2025_07_09_162621_create_tbl_min_qualification_table', 1),
(136, '2025_07_09_162708_create_tbl_experience_req_table', 1),
(137, '2025_07_09_163052_create_tbl_skills_table', 1),
(138, '2025_07_09_163118_create_tbl_state_table', 1),
(139, '2025_07_09_163141_create_tbl_city_table', 1),
(140, '2025_07_09_163218_create_tbl_area_table', 1),
(141, '2025_07_09_163245_create_tbl_zipcode_table', 1),
(142, '2025_07_09_164645_add_role_to_users_table', 1),
(143, '2025_07_10_041501_create_test_demos_table', 1),
(144, '2025_07_10_094407_add_category_id_to_tbl_sub_category_table', 1),
(145, '2025_07_10_144638_add_country_id_to_tbl_state_table', 1),
(146, '2025_07_11_102124_create_permission_tables', 1),
(147, '2025_07_12_140117_add_otp_to_users_table', 1),
(148, '2025_07_13_043520_add_columns_to_users_table', 1),
(149, '2025_07_14_093235_create_company_branches_table', 2),
(151, '2025_07_14_000000_create_tbl_plan_pricing_table', 3),
(152, '2025_07_14_120000_create_tbl_plan_history_table', 4),
(153, '2025_07_14_120001_add_active_plan_id_to_users_table', 5),
(154, '2025_07_14_114036_add_area_id_to_users_table', 6),
(155, '2025_07_15_000000_add_designation_to_users_table', 7),
(157, '2025_07_15_045003_create_tbl_work_experience_table', 8),
(160, '2025_07_15_095434_create_tbl_education_table', 9),
(161, '2025_07_17_042418_add_resume_to_users_table', 10),
(162, '2025_07_17_100723_create_tbl_job_table', 11),
(163, '2025_07_18_091555_add_cover_img_to_users_table', 12),
(164, '2025_07_18_113420_add_image_to_tbl_job_category_table', 13),
(165, '2025_07_19_090423_create_tbl_job_save_table', 14),
(166, '2025_07_21_111845_create_tbl_blog_table', 15),
(167, '2025_07_21_114945_add_datetime_to_tbl_blog_table', 16),
(168, '2025_07_21_120759_create_tbl_achievement_table', 17),
(169, '2025_07_22_043008_add_status_and_apply_columns_to_tbl_job_table', 18),
(170, '2025_07_22_043351_create_tbl_job_apply_table', 19),
(171, '2025_07_22_043643_create_tbl_job_apply_history_table', 20),
(172, '2025_07_22_110407_create_tbl_ad_banner_table', 21),
(173, '2025_07_22_111613_add_status_to_tbl_ad_banner_table', 22),
(174, '2025_07_23_093056_create_tbl_testimonial_table', 23),
(175, '2025_07_24_042754_create_tbl_setting_table', 24),
(176, '2025_07_25_044833_create_tbl_job_round_table', 25),
(177, '2025_07_25_045006_create_tbl_round_complete_table', 26),
(178, '2025_07_30_050438_add_show_company_details_to_tbl_setting_table', 27),
(179, '2025_07_31_101050_add_salary_budget_to_tbl_job_table', 28),
(180, '2025_08_01_043647_create_tbl_resume_table', 29),
(181, '2025_08_01_043755_create_tbl_resume_builder_table', 30),
(182, '2025_08_02_043159_add_remarks_to_tbl_round_complete_table', 31),
(183, '2025_08_04_093920_add_profile_status_to_users_table', 32),
(184, '2025_08_05_053755_add_preference_type_to_tbl_job_category_table', 33),
(185, '2025_08_06_050439_create_tbl_staff_activity_table', 34),
(186, '2025_08_07_042918_add_experience_salary_languages_to_users_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'Dashboard-today_candidates_register_list', 'web', '2025-07-29 00:44:00', '2025-07-29 00:45:46'),
(5, 'Dashboard-today_company_register_list', 'web', '2025-07-29 00:44:17', '2025-07-29 00:45:37'),
(6, 'Dashboard-paid_company', 'web', '2025-07-29 00:44:37', '2025-07-29 00:45:30'),
(7, 'Dashboard-paid_candidates', 'web', '2025-07-29 00:44:50', '2025-07-29 00:45:25'),
(8, 'Dashboard-free_company_Candidates', 'web', '2025-07-29 00:45:16', '2025-07-29 00:45:16'),
(9, 'Dashboard-staff_activity_history', 'web', '2025-07-29 00:46:12', '2025-07-29 00:46:12'),
(10, 'Dashboard-expired_plan_month', 'web', '2025-07-29 00:46:31', '2025-07-29 00:46:31'),
(11, 'Category-Add', 'web', '2025-07-29 00:47:02', '2025-07-29 00:47:02'),
(12, 'Category-Edit', 'web', '2025-07-29 00:47:07', '2025-07-29 00:47:07'),
(13, 'Category-Delete', 'web', '2025-07-29 00:47:12', '2025-07-29 00:47:12'),
(14, 'SubCategory-Add', 'web', '2025-07-29 00:48:10', '2025-07-29 00:48:10'),
(15, 'SubCategory-Edit', 'web', '2025-07-29 00:48:15', '2025-07-29 00:48:15'),
(16, 'SubCategory-Delete', 'web', '2025-07-29 00:48:20', '2025-07-29 00:48:20'),
(17, 'JobType-Add', 'web', '2025-07-29 00:48:32', '2025-07-29 00:48:32'),
(18, 'JobType-Edit', 'web', '2025-07-29 00:48:36', '2025-07-29 00:48:36'),
(19, 'JobType-Delete', 'web', '2025-07-29 00:48:40', '2025-07-29 00:48:40'),
(20, 'JobLevel-Add', 'web', '2025-07-29 00:48:50', '2025-07-29 00:48:50'),
(21, 'JobLevel-Edit', 'web', '2025-07-29 00:48:55', '2025-07-29 00:48:55'),
(22, 'JobLevel-Delete', 'web', '2025-07-29 00:49:00', '2025-07-29 00:49:00'),
(23, 'WorkType-Add', 'web', '2025-07-29 00:49:11', '2025-07-29 00:49:11'),
(24, 'WorkType-Edit', 'web', '2025-07-29 00:49:15', '2025-07-29 00:49:15'),
(25, 'WorkType-Delete', 'web', '2025-07-29 00:49:21', '2025-07-29 00:49:21'),
(26, 'MinimumQualification-Add', 'web', '2025-07-29 00:49:58', '2025-07-29 00:49:58'),
(27, 'MinimumQualification-Edit', 'web', '2025-07-29 00:50:03', '2025-07-29 00:50:03'),
(28, 'MinimumQualification-Delete', 'web', '2025-07-29 00:50:07', '2025-07-29 00:50:07'),
(29, 'ExperienceRequired-Add', 'web', '2025-07-29 00:50:15', '2025-07-29 00:50:15'),
(30, 'ExperienceRequired-Edit', 'web', '2025-07-29 00:50:22', '2025-07-29 00:50:22'),
(31, 'ExperienceRequired-Delete', 'web', '2025-07-29 00:50:27', '2025-07-29 00:50:27'),
(32, 'Skills-Add', 'web', '2025-07-29 00:50:34', '2025-07-29 00:50:34'),
(33, 'Skills-Edit', 'web', '2025-07-29 00:50:39', '2025-07-29 00:50:39'),
(34, 'Skills-Delete', 'web', '2025-07-29 00:50:43', '2025-07-29 00:50:43'),
(35, 'Candidate-skill_register', 'web', '2025-07-29 00:54:19', '2025-07-29 01:08:16'),
(36, 'Candidate-non_skill_register', 'web', '2025-07-29 00:54:31', '2025-07-29 01:08:26'),
(37, 'Company-company_list', 'web', '2025-07-29 00:54:52', '2025-07-29 01:14:51'),
(38, 'Candidate-candidate_register_list', 'web', '2025-07-29 00:55:24', '2025-07-29 00:55:24'),
(39, 'Company-company_register_list', 'web', '2025-07-29 00:55:43', '2025-07-29 00:55:43'),
(40, 'Candidate-paid_candidate', 'web', '2025-07-29 00:56:03', '2025-07-29 00:56:03'),
(41, 'Company-paid_company', 'web', '2025-07-29 00:56:23', '2025-07-29 00:56:23'),
(42, 'Candidate-free_candidate', 'web', '2025-07-29 00:57:19', '2025-07-29 00:57:19'),
(43, 'Company-free_company', 'web', '2025-07-29 00:57:29', '2025-07-29 00:57:29'),
(44, 'Candidate-candidate_expire_plan', 'web', '2025-07-29 00:57:45', '2025-07-29 00:58:09'),
(45, 'Company-company_expire_plan', 'web', '2025-07-29 00:57:59', '2025-07-29 00:57:59'),
(46, 'About-Update', 'web', '2025-07-29 00:58:22', '2025-07-29 00:58:22'),
(47, 'Blog-Add', 'web', '2025-07-29 00:58:28', '2025-07-29 00:58:28'),
(48, 'Blog-Edit', 'web', '2025-07-29 00:58:33', '2025-07-29 00:58:33'),
(49, 'Blog-Delete', 'web', '2025-07-29 00:58:38', '2025-07-29 00:58:38'),
(50, 'Testimonial-Add', 'web', '2025-07-29 00:58:49', '2025-07-29 00:58:49'),
(51, 'Testimonial-Edit', 'web', '2025-07-29 00:58:53', '2025-07-29 00:58:53'),
(52, 'Testimonial-Delete', 'web', '2025-07-29 00:58:57', '2025-07-29 00:58:57'),
(53, 'AdBanner-Add', 'web', '2025-07-29 00:59:10', '2025-07-29 00:59:10'),
(54, 'AdBanner-Edit', 'web', '2025-07-29 00:59:15', '2025-07-29 00:59:15'),
(55, 'AdBanner-Delete', 'web', '2025-07-29 00:59:19', '2025-07-29 00:59:19'),
(56, 'PlanPricing-Add', 'web', '2025-07-29 00:59:32', '2025-07-29 00:59:32'),
(57, 'PlanPricing-Edit', 'web', '2025-07-29 00:59:37', '2025-07-29 00:59:37'),
(58, 'PlanPricing-Delete', 'web', '2025-07-29 00:59:43', '2025-07-29 00:59:43'),
(59, 'Achievement-Update', 'web', '2025-07-29 00:59:59', '2025-07-29 00:59:59'),
(60, 'Setting-Update', 'web', '2025-07-29 01:00:06', '2025-07-29 01:00:06'),
(61, 'State-Add', 'web', '2025-07-29 01:08:45', '2025-07-29 01:08:45'),
(62, 'State-Edit', 'web', '2025-07-29 01:08:49', '2025-07-29 01:08:49'),
(63, 'State-Delete', 'web', '2025-07-29 01:08:54', '2025-07-29 01:08:54'),
(64, 'City-Add', 'web', '2025-07-29 01:08:59', '2025-07-29 01:08:59'),
(65, 'City-Edit', 'web', '2025-07-29 01:09:05', '2025-07-29 01:09:05'),
(66, 'City-Delete', 'web', '2025-07-29 01:09:09', '2025-07-29 01:09:09'),
(67, 'Area-Add', 'web', '2025-07-29 01:09:15', '2025-07-29 01:09:15'),
(68, 'Area-Edit', 'web', '2025-07-29 01:09:21', '2025-07-29 01:09:21'),
(69, 'Area-Delete', 'web', '2025-07-29 01:09:26', '2025-07-29 01:09:26'),
(70, 'Zipcode-Add', 'web', '2025-07-29 01:09:32', '2025-07-29 01:09:32'),
(71, 'Zipcode-Edit', 'web', '2025-07-29 01:09:37', '2025-07-29 01:09:37'),
(72, 'Zipcode-Delete', 'web', '2025-07-29 01:09:43', '2025-07-29 01:09:43');

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'super-admin', 'web', '2025-08-21 06:27:12', '2025-08-21 06:27:12');

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
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(25, 5),
(26, 5),
(27, 5),
(28, 5),
(29, 5),
(30, 5),
(31, 5),
(32, 5),
(33, 5),
(34, 5),
(35, 5),
(36, 5),
(37, 5),
(38, 5),
(39, 5),
(40, 5),
(41, 5),
(42, 5),
(43, 5),
(44, 5),
(45, 5),
(46, 5),
(47, 5),
(48, 5),
(49, 5),
(50, 5),
(51, 5),
(52, 5),
(53, 5),
(54, 5),
(55, 5),
(56, 5),
(57, 5),
(58, 5),
(59, 5),
(60, 5),
(61, 5),
(62, 5),
(63, 5),
(64, 5),
(65, 5),
(66, 5),
(67, 5),
(68, 5),
(69, 5),
(70, 5),
(71, 5),
(72, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_achievement`
--

CREATE TABLE `tbl_achievement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_achievement`
--

INSERT INTO `tbl_achievement` (`id`, `count`, `title`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 100, 'Completed Cases', 'We always provide people a complete solution upon focused of any business', NULL, NULL, '2025-08-18 11:02:13'),
(2, 149, 'Our Office', 'We always provide people a complete solution upon focused of any business', NULL, NULL, '2025-08-18 11:02:13'),
(3, 900, 'Skilled People', 'We always provide people a complete solution upon focused of any business', NULL, NULL, '2025-08-18 11:02:13'),
(4, 30, 'Happy Clients', 'We always provide people a complete solution upon focused of any business', NULL, NULL, '2025-08-18 11:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ad_banner`
--

CREATE TABLE `tbl_ad_banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_nm` varchar(255) NOT NULL,
  `ad_link` varchar(255) DEFAULT NULL,
  `img_nm` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_ad_banner`
--

INSERT INTO `tbl_ad_banner` (`id`, `page_nm`, `ad_link`, `img_nm`, `start_date`, `end_date`, `status`, `datetime`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '3', NULL, '1753182865_687f729197c68.png', NULL, NULL, 1, '2025-07-22 11:14:26', '2025-07-22 06:10:11', '2025-07-22 05:44:26', '2025-07-22 06:10:11'),
(2, '1', 'https://projectiv.in/zobpot/public/', '1753692508_6887395ced3e6.png', '2025-07-01', '2025-07-31', 1, '2025-07-22 11:18:49', NULL, '2025-07-22 05:48:49', '2025-07-28 03:18:29'),
(3, '2', 'https://projectiv.in/gotilo/', '1753256343_6880919721e04.png', '2025-07-22', '2025-07-31', 1, '2025-07-23 07:38:14', NULL, '2025-07-23 02:08:14', '2025-07-28 22:49:32'),
(4, '4', 'https://projectiv.in/gotilo/', '1753338182_6881d1460c794.png', '2025-07-22', '2025-07-30', 1, '2025-07-23 07:41:15', NULL, '2025-07-23 02:11:15', '2025-07-24 00:53:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_area`
--

CREATE TABLE `tbl_area` (
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `area_nm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_area`
--

INSERT INTO `tbl_area` (`area_id`, `state_id`, `city_id`, `area_nm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Vastrapur', '2025-07-31 00:11:23', '2025-08-18 09:40:07', '2025-08-18 09:40:07'),
(2, 2, 2, 'Malad', '2025-07-31 01:12:27', '2025-08-18 09:40:09', '2025-08-18 09:40:09'),
(3, 3, 3, 'Palace Road', '2025-08-01 06:21:05', '2025-08-18 09:40:32', '2025-08-18 09:40:32'),
(4, 2, 2, 'East Mumbai', '2025-08-05 01:10:46', '2025-08-18 09:40:12', '2025-08-18 09:40:12'),
(5, 2, 2, 'East Mumbai', '2025-08-05 01:13:44', '2025-08-18 09:40:14', '2025-08-18 09:40:14'),
(6, 2, 2, 'East Mumbai', '2025-08-05 01:14:35', '2025-08-18 09:40:16', '2025-08-18 09:40:16'),
(7, 2, 2, 'East Mumbai', '2025-08-05 01:15:11', '2025-08-18 09:40:18', '2025-08-18 09:40:18'),
(8, 2, 2, 'East Mumbai', '2025-08-05 01:16:34', '2025-08-18 09:40:21', '2025-08-18 09:40:21'),
(9, 2, 2, 'West Mumbai', '2025-08-05 01:21:27', '2025-08-18 09:40:23', '2025-08-18 09:40:23'),
(10, 2, 2, 'Andheri', '2025-08-05 01:38:05', '2025-08-18 09:40:24', '2025-08-18 09:40:24'),
(11, 2, 2, 'Marein Drive', '2025-08-05 01:53:41', '2025-08-18 09:40:04', '2025-08-18 09:40:04'),
(13, 2, 2, 'Vest Hom', '2025-08-05 01:58:07', '2025-08-18 09:40:26', '2025-08-18 09:40:26'),
(15, 2, 2, 'Demosss', '2025-08-05 02:00:45', '2025-08-18 09:40:28', '2025-08-18 09:40:28'),
(16, 2, 2, 'Mirsh', '2025-08-05 02:02:55', '2025-08-18 09:40:30', '2025-08-18 09:40:30'),
(17, 1, 4, 'Palanpur', '2025-08-15 09:02:34', '2025-08-18 09:40:34', '2025-08-18 09:40:34'),
(18, 4, 5, 'Radhanpur road', '2025-08-15 09:10:42', '2025-08-18 09:40:36', '2025-08-18 09:40:36'),
(19, 5, 6, 'Place Road', '2025-08-18 09:49:51', '2025-08-18 09:49:51', NULL),
(20, 5, 6, 'Mahal Road', '2025-08-18 09:51:46', '2025-08-18 09:51:46', NULL),
(21, 6, 7, 'radhanpur road', '2025-08-19 05:11:19', '2025-08-19 05:11:19', NULL),
(22, 6, 8, 'Radhanpur road', '2025-08-19 05:51:21', '2025-08-19 05:51:21', NULL),
(23, 6, 9, 'sidhpur chokdi', '2025-08-19 06:17:16', '2025-08-19 06:17:16', NULL),
(24, 6, 8, 'VISNAGAR', '2025-08-19 07:08:56', '2025-08-19 07:08:56', NULL),
(25, 7, 10, 'Sidhpur Chokdi', '2025-08-19 08:39:16', '2025-08-19 08:39:16', NULL),
(26, 8, 11, 'VIJAPUR', '2025-08-19 08:53:05', '2025-08-19 08:53:05', NULL),
(27, 6, 12, 'KADI HIGHWAY', '2025-08-19 09:05:28', '2025-08-19 09:05:28', NULL),
(28, 6, 7, 'modhera road', '2025-08-19 09:28:50', '2025-08-19 09:28:50', NULL),
(29, 10, 14, 'PATAN', '2025-08-21 07:01:41', '2025-08-21 07:01:41', NULL),
(30, 11, 15, 'MANIYARI PARA', '2025-08-21 09:33:52', '2025-08-21 09:33:52', NULL),
(31, 6, 7, 'modhera road', '2025-08-25 04:37:55', '2025-08-25 04:37:55', NULL),
(32, 12, 16, 'Radhanpur road', '2025-08-25 06:45:59', '2025-08-25 06:45:59', NULL),
(33, 13, 17, 'motamadha', '2025-08-26 05:11:41', '2025-08-26 05:11:41', NULL),
(34, 7, 18, 'radhanpur', '2025-08-26 06:40:05', '2025-08-26 06:40:05', NULL),
(35, 6, 7, 'punashan', '2025-08-26 09:13:24', '2025-08-26 09:13:24', NULL),
(36, 7, 19, 'visnagar  chokadi hudako', '2025-08-26 10:00:44', '2025-08-26 10:00:44', NULL),
(37, 7, 20, 'unava', '2025-08-26 10:30:01', '2025-08-26 10:30:01', NULL),
(38, 6, 7, 'N.G International school', '2025-08-26 11:41:02', '2025-08-26 11:41:02', NULL),
(39, 14, 21, 'Kalol', '2025-09-01 07:00:50', '2025-09-01 07:00:50', NULL),
(40, 6, 22, 'Palvada Village', '2025-09-01 10:03:38', '2025-09-01 10:03:38', NULL),
(41, 6, 7, 'chamunda chokadi', '2025-09-05 05:47:57', '2025-09-05 05:47:57', NULL),
(42, 7, 10, 'patan', '2025-09-05 05:52:02', '2025-09-05 05:52:02', NULL),
(43, 15, 23, 'DHANOT', '2025-09-05 06:01:40', '2025-09-05 06:01:40', NULL),
(44, 6, 24, 'LANGHNJ', '2025-09-05 06:26:02', '2025-09-05 06:26:02', NULL),
(45, 7, 25, 'LANGHNAJ', '2025-09-05 06:36:34', '2025-09-05 06:36:34', NULL),
(46, 7, 26, 'rabarivas', '2025-09-05 06:51:54', '2025-09-05 06:51:54', NULL),
(47, 6, 7, 'kherva', '2025-09-05 06:56:28', '2025-09-05 06:56:28', NULL),
(48, 7, 27, '10, sanidhya recidency', '2025-09-05 07:24:21', '2025-09-05 07:24:21', NULL),
(49, 7, 28, 'azad chok', '2025-09-05 09:23:18', '2025-09-05 09:23:18', NULL),
(50, 7, 25, 'kherva', '2025-09-05 10:22:02', '2025-09-05 10:22:02', NULL),
(51, 7, 30, 'norta', '2025-09-05 11:15:47', '2025-09-05 11:15:47', NULL),
(52, 7, 32, 'taluka vav', '2025-09-05 11:29:16', '2025-09-05 11:29:16', NULL),
(53, 7, 10, 'PATAN', '2025-09-05 11:56:33', '2025-09-05 11:56:33', NULL),
(54, 7, 33, 'vankar vas', '2025-09-06 09:19:41', '2025-09-06 09:19:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `datetime` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`id`, `title`, `desc`, `image`, `status`, `datetime`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'First Blog', '<p>First Blog</p>', '1755514744_68a307787b0ae.png', 1, '2025-08-18 10:59:04', '2025-09-29 10:03:32', '2025-08-18 10:59:04', '2025-09-29 10:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `city_nm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`city_id`, `state_id`, `city_nm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Ahmedabad', '2025-07-31 00:11:23', '2025-08-18 09:39:29', '2025-08-18 09:39:29'),
(2, 2, 'Mumbai', '2025-07-31 01:12:27', '2025-08-18 09:39:33', '2025-08-18 09:39:33'),
(3, 3, 'Sirohi', '2025-08-01 06:21:05', '2025-08-18 09:39:38', '2025-08-18 09:39:38'),
(4, 1, 'Palanpur', '2025-08-15 09:02:34', '2025-08-18 09:39:40', '2025-08-18 09:39:40'),
(5, 4, 'mehsana', '2025-08-15 09:10:42', '2025-08-18 09:39:35', '2025-08-18 09:39:35'),
(6, 5, 'Sirohi', '2025-08-18 09:49:38', '2025-08-18 09:49:38', NULL),
(7, 6, 'mehsana', '2025-08-19 05:11:19', '2025-08-19 05:11:19', NULL),
(8, 6, 'Mahesana', '2025-08-19 05:51:21', '2025-08-19 05:51:21', NULL),
(9, 6, 'Patan', '2025-08-19 06:17:16', '2025-08-19 06:17:16', NULL),
(10, 7, 'Patan', '2025-08-19 08:39:16', '2025-08-19 08:39:16', NULL),
(11, 8, 'MAHESANA', '2025-08-19 08:53:05', '2025-08-19 08:53:05', NULL),
(12, 6, 'kadi', '2025-08-19 09:05:28', '2025-08-19 09:05:28', NULL),
(13, 9, 'MEHSANA', '2025-08-21 06:51:31', '2025-08-21 06:51:31', NULL),
(14, 10, 'PATAN', '2025-08-21 07:01:41', '2025-08-21 07:01:41', NULL),
(15, 11, 'PATAN', '2025-08-21 09:33:52', '2025-08-21 09:33:52', NULL),
(16, 12, 'Mehsana', '2025-08-25 06:45:59', '2025-08-25 06:45:59', NULL),
(17, 13, 'mehsana', '2025-08-26 05:11:41', '2025-08-26 05:11:41', NULL),
(18, 7, 'radhanpur', '2025-08-26 06:40:05', '2025-08-26 06:40:05', NULL),
(19, 7, 'unjha', '2025-08-26 10:00:44', '2025-08-26 10:00:44', NULL),
(20, 7, 'unava', '2025-08-26 10:30:01', '2025-08-26 10:30:01', NULL),
(21, 14, 'Gandhinagar', '2025-09-01 07:00:50', '2025-09-01 07:00:50', NULL),
(22, 6, 'Palvada Village', '2025-09-01 10:03:38', '2025-09-01 10:03:38', NULL),
(23, 15, 'AHMEDABAD', '2025-09-05 06:01:40', '2025-09-05 06:01:40', NULL),
(24, 6, 'LANGHNAJ', '2025-09-05 06:26:02', '2025-09-05 06:26:02', NULL),
(25, 7, 'MEHSANA', '2025-09-05 06:36:34', '2025-09-05 06:36:34', NULL),
(26, 7, 'Motidau', '2025-09-05 06:51:54', '2025-09-05 06:51:54', NULL),
(27, 7, 'sidhpur', '2025-09-05 07:24:21', '2025-09-05 07:24:21', NULL),
(28, 7, 'kolvada', '2025-09-05 09:23:18', '2025-09-05 09:23:18', NULL),
(29, 9, 'Visnagar', '2025-09-05 10:42:55', '2025-09-05 10:42:55', NULL),
(30, 7, 'Norta Talpad', '2025-09-05 11:15:47', '2025-09-05 11:15:47', NULL),
(31, 6, 'visnagar', '2025-09-05 11:22:11', '2025-09-05 11:22:11', NULL),
(32, 7, 'Banaskantha', '2025-09-05 11:29:16', '2025-09-05 11:29:16', NULL),
(33, 7, 'panchot', '2025-09-06 09:19:41', '2025-09-06 09:19:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_branches`
--

CREATE TABLE `tbl_company_branches` (
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_nm` varchar(255) NOT NULL,
  `company_address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_company_branches`
--

INSERT INTO `tbl_company_branches` (`branch_id`, `user_id`, `company_nm`, `company_address`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(7, 46, 'Zobpot 1', 'Lorem Ipsum is simply dummy text of the', 1, NULL, '2025-08-18 10:15:17', '2025-08-18 10:15:17'),
(8, 46, 'Zobpot 2', 'Lorem Ipsum is simply dummy text of the  dummy text of the', 1, NULL, '2025-08-18 10:15:17', '2025-08-18 10:15:17'),
(9, 66, 'consta cool pvt.ltd.', 'matoda,ahmedabad', 1, NULL, '2025-08-19 09:05:28', '2025-08-19 09:05:28'),
(10, 73, 'ayushi pharma', 'chhatral', 1, NULL, '2025-08-21 06:44:39', '2025-08-21 06:44:39'),
(11, 75, 'Amol Menachem', 'kadi', 1, NULL, '2025-08-21 06:54:20', '2025-08-21 06:54:20'),
(12, 77, 'anmol', 'Mehsana', 1, NULL, '2025-08-21 07:02:45', '2025-08-21 07:02:45'),
(13, 78, 'Consta Cool Pvt. Ltd.', 'Chhatral', 1, NULL, '2025-08-21 07:11:30', '2025-08-21 07:11:30'),
(14, 94, 'RAJPUR', 'PLOT SY. NO. 1143 P 2 @ 3 NR. GHUMASAN BUS STOP, OPP. CHOKADI TUBES, N.H. NO.8, AT. KADI, DIST. MEHSANA.', 1, NULL, '2025-09-05 06:01:40', '2025-09-05 06:01:40'),
(15, 97, 'AARAV TENDER CONSULTANT PVT.LTD.', '2ND FLOOR, JAGDISH CHAMBER NR. ANAD NIKETAN SCHOOL, MALGODOWN ROAD, OPP. RAJKAMAL PETROL PUMP, MEHSANA HIGHWAY, MEHSANA - 384002', 1, NULL, '2025-09-05 06:51:24', '2025-09-05 06:51:24'),
(16, 109, 'AMOL MINECHEM LTD.', 'MEHSANA AHMEDABAD HIGHWAY', 1, NULL, '2025-09-06 07:20:47', '2025-09-06 07:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_education`
--

CREATE TABLE `tbl_education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `degree` varchar(255) NOT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_education`
--

INSERT INTO `tbl_education` (`id`, `school_name`, `user_id`, `degree`, `field_of_study`, `grade`, `start_date`, `end_date`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ssc', 41, 'Diploma Mechanical', 'Mechanical', 'A', '2025-08-01', '2025-08-10', 'Fan Project', '2025-08-15 09:31:37', '2025-08-15 09:31:37', NULL),
(2, 'Ahmedabad Univercuty', 45, 'BCA', 'Computer', 'A', '2025-08-01', '2025-08-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2025-08-18 10:06:06', '2025-08-18 10:06:06', NULL),
(3, '12 PASS', 48, 'BA', 'COMPUTER', 'A', '2025-08-11', '2025-09-15', 'COMPUTER', '2025-08-19 05:26:38', '2025-08-19 05:26:38', NULL),
(4, '12PASS', 49, 'BCA', 'Computer Science', 'A', '2025-08-06', '2025-09-14', 'Project description?', '2025-08-19 06:10:18', '2025-08-19 06:10:18', NULL),
(5, '12PASS', 52, 'B.COM', 'COMPUTER  SCIENCE', 'A', '2025-08-08', '2025-09-21', 'A summary of a topic or concept', '2025-08-19 06:29:04', '2025-08-19 06:29:04', NULL),
(6, '12PASS', 53, 'B.COM', 'COMPUTER  SCIENCE', 'A', '2025-08-08', '2025-09-18', 'A product description?', '2025-08-19 06:43:13', '2025-08-19 06:43:13', NULL),
(7, '12PASS', 56, 'BSC', 'Computer Science', 'A', '2025-08-11', '2025-09-18', 'Maintain comprehensive project documentation.', '2025-08-19 06:53:27', '2025-08-19 06:53:27', NULL),
(8, 'B.K Amin High School', 51, 'B.A.', 'Agriculture', 'A', '2006-12-06', '2024-10-03', 'B.A complete', '2025-08-19 06:57:25', '2025-08-19 06:57:25', NULL),
(9, 'j m sarvjanik vidhyalay  mehsana', 55, 'b. com', 'COMPUTER', 'A', '2025-08-02', '2025-08-29', 'Handle end-to-end recruitment process.', '2025-08-19 06:58:10', '2025-08-19 06:58:10', NULL),
(10, '12PASS', 57, 'MSW', 'Computer Science', 'A', '2025-08-06', '2025-09-30', 'Develop and implement HR policies in line with company goals and legal requirements.', '2025-08-19 07:03:46', '2025-08-19 07:03:46', NULL),
(11, '12PASS', 58, 'B.E', 'Science & Technology', 'A', '2025-08-01', '2025-09-13', 'The Marketing Executive is responsible for developing and executing marketing strategies to promote a company\'s products or services. This includes market research, campaign planning, content creation, and analyzing the effectiveness of marketing initiatives.', '2025-08-19 07:15:37', '2025-08-19 07:15:37', NULL),
(12, '12PASS', 59, 'M.COM', 'Science & Technology', 'A', '2025-08-07', '2025-09-28', 'Ensure data accuracy and integrity.', '2025-08-19 07:27:02', '2025-08-19 07:27:02', NULL),
(13, 'B.K Amin High School', 60, 'B.A.', 'Agriculture', 'A', '2005-10-06', '2024-10-01', 'Study Complete', '2025-08-19 07:30:19', '2025-08-19 07:30:19', NULL),
(14, '12PASS', 63, 'BSC', 'Science & Technology', 'A', '2025-08-06', '2025-09-13', 'Responsibilities are the tasks and obligations that come with that role — what the person is expected to do to fulfill their job effectively.', '2025-08-19 08:58:24', '2025-08-19 08:58:24', NULL),
(15, '12PASS', 64, 'MSC', 'Science & Technology', 'A', '2025-08-10', '2025-09-29', 'Avoid overlap and confusion,', '2025-08-19 09:08:46', '2025-08-19 09:08:46', NULL),
(16, '10PASS', 70, 'DIPLOMA IT', 'Computer Science', 'A', '2025-08-08', '2025-09-27', 'As a Software Engineer, I design, develop, and maintain scalable web applications using modern frameworks. I collaborate with cross-functional teams to deliver robust, user-centric solutions while following agile methodologies.', '2025-08-20 04:36:20', '2025-08-20 04:36:20', NULL),
(17, '12PASS', 71, 'CIVIL ENGINEERING', 'COMPUTER SCIENCE', 'A', '2025-08-05', '2025-09-23', 'MS WORD\r\nGOOD COMMUNICATION', '2025-08-20 04:54:26', '2025-08-20 04:54:26', NULL),
(18, 'SAVRAJANIK VIDHYALAY MEHSANA', 72, 'B.COM', 'ACCOUNT', 'A+', '2025-08-21', '2025-09-28', '“Enthusiastic MBA graduate with specialization in Marketing. Skilled in market research, digital campaigns, and client communication. Looking for an opportunity to apply creativity and strategic thinking in a dynamic organization.”', '2025-08-21 06:34:24', '2025-08-21 06:34:24', NULL),
(19, 'J.M. CHAUDHARY SCHOOL AND COLLAGE MEHSANA', 74, 'IT', 'COMPUTER', 'A', '2025-06-28', '2025-09-05', '“A Web Developer is responsible for designing, coding, and maintaining websites and web applications. The role involves developing responsive and visually appealing layouts, integrating back-end systems, ensuring cross-browser compatibility, and optimizing performance', '2025-08-21 06:57:25', '2025-08-21 06:57:25', NULL),
(20, 'SAVRAJANIK VIDHYALAY MEHSANA', 76, 'B.COM', 'ACCOUNT', 'A', '2025-06-02', '2025-11-23', 'Seeking an entry-level role in finance or accounts to apply academic knowledge and build practical experience.”', '2025-08-21 07:09:52', '2025-08-21 07:09:52', NULL),
(21, 'SAVRAJANIK VIDHYALAY MEHSANA', 80, 'M.B.A', 'MARKETING', 'A', '2025-08-04', '2025-10-07', 'Enthusiastic MBA graduate with specialization in Marketing. Skilled in market research, digital campaigns, and client communication. Looking for an opportunity to apply creativity and strategic thinking in a dynamic organization.”', '2025-08-21 10:19:31', '2025-08-21 10:19:31', NULL),
(22, 'HNGU Patan', 81, 'M.A', 'Agriculture', 'A', '2022-06-25', '2025-03-14', 'hard working', '2025-08-25 05:24:52', '2025-08-25 05:24:52', NULL),
(23, 'HNGU Patan', 83, 'B.ed', 'theching', 'A', '2021-07-20', '2024-05-07', 'I hereby declare that the above mentioned', '2025-08-26 05:58:06', '2025-08-26 05:58:06', NULL),
(24, 'HNGU Patan', 84, 'B.Com', 'tally', 'A', '2025-02-20', '2025-05-24', 'I hereby affirm that the information in this document is accurate and true to the the best of my  knowledge.', '2025-08-26 06:56:25', '2025-08-26 06:56:25', NULL),
(25, 'SMT  .K.K. PATEL MBA/MCA COLLEGE, PALASAR', 85, 'M.B.A', 'H.R', 'B', '2020-06-01', '2025-01-29', 'Do hereby declare that the particulars of information and facts stated herein above are true correct  and complete to the  best of my knowledge and belief.', '2025-08-26 09:44:58', '2025-08-26 09:44:58', NULL),
(26, 'Smt. S. R  Patel Engineering College ,Dabhi', 87, 'B.E', 'tally', 'B', '2021-06-14', '2024-05-13', 'I  hereby declare that the information provided  above  in this reference bio-data by   me is correct to the  best  of  my knowledge', '2025-08-26 11:01:20', '2025-08-26 11:01:20', NULL),
(27, 'G.T.U', 88, 'M.E', 'computer  engineering', 'A', '2022-04-06', '2025-05-11', 'Seeking the posting of assistant teacher in a renowed organization .', '2025-08-26 11:52:51', '2025-08-26 11:52:51', NULL),
(28, 'SHREE N.H. SARVJANIK VIDHYA MANDIR DHINOJ', 89, 'BA', 'ACCOUNT', 'A', '2024-11-30', '2025-08-10', 'Strong problem-solving ability, teamwork, and communication skills.', '2025-08-29 12:06:17', '2025-08-29 12:06:17', NULL),
(29, '12PASS', 90, 'B.COM', 'Computer Science', 'A', '1981-04-01', '2008-03-31', 'Srong foundation in accounting, taxation, and business management.', '2025-09-01 09:33:19', '2025-09-01 09:33:19', NULL),
(30, 'M.J. Vaghela Highschool', 91, 'B.COM', 'COMPUTER SCIENCE', 'A', '2006-06-15', '2021-05-31', 'Graduate With knowledge in Accounting, Finance, and Taxation.', '2025-09-01 10:26:21', '2025-09-01 10:26:21', NULL),
(31, 'PATEL GROUP  OF INSTITUTIONS', 92, 'MCA', 'WEB PROGRAMMING', 'A', '2023-05-05', '2024-04-05', 'ABOUT THE LATEST TECHNOLOGIES AND FINDING OUT HOW TO IMPROVE MY CRAFT. I AM DETAIL ORIENTED  AND FOCUSED', '2025-09-05 06:07:09', '2025-09-05 06:07:09', NULL),
(32, 'THE UNION HIGH SCHOOL', 95, 'B.Com', 'tally', 'B', '2024-12-05', '2025-05-05', 'CULTURE OF INNOVATION , CONTINUOUS IEARNING AND PERSONALGROWTH.', '2025-09-05 06:48:38', '2025-09-05 06:48:38', NULL),
(33, 'K.D  POLYTECHNIC', 99, 'B.E', 'computer  engineering', 'B', '2022-07-05', '2025-05-05', 'STUDENTS MANAGEMAENT  SYSTEM  PROJECT', '2025-09-05 07:13:17', '2025-09-05 07:13:17', NULL),
(34, 'Tribhuvan vidhyalay', 98, 'B.sc', 'B.sc', 'A', '2021-06-10', '2025-06-10', 'B.sc complete', '2025-09-05 08:56:02', '2025-09-05 08:56:02', NULL),
(35, 'Tribhuvan vidhyalay', 100, 'B.com', 'B.com', 'A', '2015-06-10', '2021-03-10', 'b.com complete', '2025-09-05 09:18:54', '2025-09-05 09:18:54', NULL),
(36, 'Aadarsh high School', 93, 'B.com', 'B.com', 'A', '2008-06-06', '2020-01-06', 'B.com complete', '2025-09-05 10:19:15', '2025-09-05 10:19:15', NULL),
(37, 'Expremental school', 104, 'B.sc', 'B.sc', 'A', '2010-06-10', '2021-03-20', 'MIC Course Completed', '2025-09-05 10:50:54', '2025-09-05 10:50:54', NULL),
(38, 'HNGU Patan', 102, 'M.COM', 'tally', 'A', '2024-08-05', '2025-03-05', 'INFORMATION MANTINED ABOVE IS TRUE TO THE BEST OF MY KNOWLEDGE', '2025-09-05 10:51:49', '2025-09-05 10:51:49', NULL),
(39, 'Tribhuvan vidhyalay', 107, 'BA', 'BUSINESS', 'A', '2010-09-06', '2020-09-06', 'TO SECURE THE POSITION WITH A STABLE AND PROFITABLE ORGANIZATION .', '2025-09-05 11:53:08', '2025-09-05 11:53:08', NULL),
(40, 'S K BUSINESS AND MANAGEMENT COLLEGE', 108, 'B.Com', 'tally', 'B', '2019-07-05', '2021-05-05', 'I  HAVE A SKILLS  IN MANAGEMENT DECISION MAKING AND ALSO, IHAD AGOOD COMMMUNICATION SKILL.', '2025-09-05 12:08:03', '2025-09-05 12:08:03', NULL),
(41, 'GUJARAT TECHNOLOGICAL UNIVERSITY', 110, 'B.E', 'computer  engineering', 'B', '2018-07-06', '2021-05-06', 'SEEKING  TO   LEVERAGE  TECHNICAL EXPERTISE  AND PRATICAL  EXPERINCE TO CONTRIBUTE EFF ECTIVEIY  IN ADYNAMIC  ENGINEERING ROLE', '2025-09-06 09:05:59', '2025-09-06 09:05:59', NULL),
(42, 'N.C.V.E.T', 111, 'I.T.I', 'computer  engineering', 'B', '2021-02-23', '2024-11-14', 'TO BE  AN INTEGRAL PART OF AN ORGANIZATION WHERE I CAN UTILIZE MY KNOWLEDGE SKILL AND ABILITY IN GROWTH OF THE ORGANIZATION', '2025-09-06 09:34:48', '2025-09-06 09:34:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_type`
--

CREATE TABLE `tbl_employee_type` (
  `emp_type_id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_experience_req`
--

CREATE TABLE `tbl_experience_req` (
  `experience_req_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_experience_req`
--

INSERT INTO `tbl_experience_req` (`experience_req_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fresher', '2025-07-30 23:56:08', '2025-07-30 23:56:08', NULL),
(2, 'Beginner', '2025-07-30 23:56:15', '2025-07-30 23:56:15', NULL),
(3, 'internship', '2025-07-30 23:56:21', '2025-07-30 23:56:21', NULL),
(4, 'Junior level', '2025-07-30 23:56:31', '2025-07-30 23:56:31', NULL),
(5, 'Entry-level', '2025-07-30 23:56:37', '2025-07-30 23:56:37', NULL),
(6, 'Intermediate', '2025-07-30 23:56:42', '2025-07-30 23:56:42', NULL),
(7, 'mid-level', '2025-07-30 23:56:48', '2025-07-30 23:56:48', NULL),
(8, 'Senior', '2025-07-30 23:56:53', '2025-07-30 23:56:53', NULL),
(9, 'Executive level', '2025-07-30 23:57:05', '2025-07-30 23:57:05', NULL),
(10, 'Senior leadership', '2025-07-30 23:57:10', '2025-07-30 23:57:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job`
--

CREATE TABLE `tbl_job` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `preference_type` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_title` varchar(255) NOT NULL,
  `qualification_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `work_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_of_openings` int(11) NOT NULL DEFAULT 1,
  `salary_budget` varchar(255) DEFAULT NULL,
  `job_description` text DEFAULT NULL,
  `interviewer_address` text DEFAULT NULL,
  `experience_req_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zipcode_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hr_email` varchar(255) DEFAULT NULL,
  `hr_contact_no` varchar(20) DEFAULT NULL,
  `skill_id` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Active, 0-Draft, 2-Close',
  `total_apply` int(11) DEFAULT NULL,
  `remain_opening` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job`
--

INSERT INTO `tbl_job` (`job_id`, `user_id`, `preference_type`, `category_id`, `sub_category_id`, `job_title`, `qualification_id`, `job_level_id`, `job_type_id`, `work_type_id`, `number_of_openings`, `salary_budget`, `job_description`, `interviewer_address`, `experience_req_id`, `contact_no`, `company_website`, `company_address`, `state_id`, `city_id`, `area_id`, `zipcode_id`, `hr_email`, `hr_contact_no`, `skill_id`, `datetime`, `status`, `total_apply`, `remain_opening`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 44, 2, 1, 1, 'Website Developer', 1, 1, 1, 1, 5, '100K-200K', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', 1, '7867564534', 'www.ivisioninfotech.in', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Ahmedabad, Gujarat', 2, 2, 9, 3, 'mahesh@gmail.com', '7867564534', '[\"HTML5\",\"CSS3\",\"JavaScript\"]', '2025-08-18 06:54:09', 1, 1, NULL, '2025-08-18 06:54:09', '2025-08-18 07:03:51', NULL),
(21, 46, 2, 13, 13, 'Urgent Driver Need', 7, 1, 1, 1, 5, '12000', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '409-B, Himalaya Arcade, Opp Vastrapur Lake, Vastrapur, Ahmedabad - Gujarat 380015', 2, '7867564534', NULL, 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Ahmedabad, Gujarat', 5, 6, 20, 1, 'mahesh@gmail.com', '7867564534', '[\"Transport Management\",\"Responsiblity\",\"Night Driver\"]', '2025-08-18 10:21:24', 1, 1, NULL, '2025-08-18 10:21:24', '2025-08-18 10:35:51', NULL),
(22, 54, 2, 1, 1, 'production', 2, 6, 1, 1, 2, '20000', 'Enter Here...Hi! Your Vi bill of Rs.1653.18 is due on 2-Jul-25. Please pay by the due date to avoid late payment charges. Never miss a due date. Make payment through Vi App and set UPI autopay with a single click', 'Ahmedabad', 3, '6357024800', NULL, 'bavla Ahmedabad', 6, 7, 21, 4, 'zobpot.2@gmail.com', '9016303444', '[\"Bootstrap\",\"JavaScript\"]', '2025-08-19 06:56:29', 1, 1, NULL, '2025-08-19 06:56:29', '2025-08-20 11:31:33', '2025-08-20 11:31:33'),
(23, 66, 2, 3, 9, 'marketing', 1, 1, 1, 4, 5, '25000', 'sales marketing', 'kadi,ahmedabad highway', 4, '6357024600', NULL, 'kadi,ahmedabad highway', 6, 12, 27, 11, 'zobpot.2@gmail.com', NULL, '[\"\"]', '2025-08-19 09:29:37', 1, NULL, NULL, '2025-08-19 09:29:37', '2025-08-19 09:29:37', NULL),
(24, 73, 2, 2, 6, 'Accountant', 3, 4, 1, 1, 2, '20000', 'Enter Here...', 'Ahmedabad', 8, '6357024800', NULL, 'Chhatral', 6, 7, 21, 4, 'zobpot.2@gmail.com', '9016303444', '[\"\"]', '2025-08-21 06:47:24', 1, 3, NULL, '2025-08-21 06:47:24', '2025-08-29 12:12:41', NULL),
(25, 75, 2, 3, 9, 'door to door sales marketing', 1, 6, 1, 4, 2, '20000', 'Enter Here...', 'kadi', 1, '6357024800', NULL, 'kadi', 6, 7, 21, 4, 'amol@gmail.com', NULL, '[\"\"]', '2025-08-21 06:56:51', 1, NULL, NULL, '2025-08-21 06:56:51', '2025-08-21 06:56:51', NULL),
(26, 77, 2, 13, 13, 'Driver', 7, 1, 6, 4, 1, '10000', 'Enter Here...', 'Mehsana', 1, '6357024800', NULL, 'Mehsana', 6, 7, 21, 3, 'amol.1@gmail.com', NULL, '[\"Driver\"]', '2025-08-21 07:05:39', 1, NULL, NULL, '2025-08-21 07:05:39', '2025-08-21 07:05:39', NULL),
(27, 78, 2, 1, 1, 'Web developer', 5, 4, 1, 1, 1, '20000', 'web Developer', 'Chhatral', 8, '6357024800', NULL, 'Chhatral', 5, 6, 19, 1, 'consta@gmail.com', NULL, '[\"\"]', '2025-08-21 07:14:58', 1, 1, NULL, '2025-08-21 07:14:58', '2025-08-21 08:34:21', NULL),
(28, 54, 2, 1, 1, 'Web developer', 3, 4, 1, 1, 1, '10000', 'Enter Here...', 'Ahmedabad', 8, '6357024800', NULL, 'bavla Ahmedabad', 6, 7, 21, 4, 'zobpot.2@gmail.com', '9016303444', '[\"\"]', '2025-08-22 06:47:07', 1, NULL, NULL, '2025-08-22 06:47:07', '2025-08-22 06:47:07', NULL),
(29, 94, 2, 1, 1, 'marketing', 1, 1, 1, 4, 5, '25000', 'MARKETING', 'S N 69 & 71 PAIKIL, B/H RAVI ESTATE, NR. GAYTRI DAIRY, AT DHANOT, TAL. KALOL, DIST. GANDHINAGAR, GUJARAT, INDIA.', 1, '6357024600', 'www.deedygroup.com', 'B-801, SHAPATH-IV, OPP. KAMAVATI CLUB,S.G. ROAD, AHMEDABAD - 3840015', 15, 23, 43, 27, 'hrd@deedygroup.com', NULL, '[\"\"]', '2025-09-05 06:27:45', 1, 4, NULL, '2025-09-05 06:27:45', '2025-09-05 12:04:46', NULL),
(30, 97, 2, 3, 12, 'SALES MARKETING', 5, 3, 1, 4, 5, '30000', 'Conduct market research to understand customer needs and trends.\r\n\r\nDevelop and implement marketing strategies and campaigns.\r\n\r\nManage digital marketing (social media, SEO, email, ads).', '2ND FLOOR, JAGDISH CHAMBER NR. ANAD NIKETAN SCHOOL, MALGODAWON ROAD, OPP. RAJKAMAL PETROL PUMP, MEHSANA HIGHWAY, MEHSANA-384002', 3, '6358934530', NULL, '2ND FLOOR, JAGDISH CHAMBER NR. ANAD NIKETAN SCHOOL, MALGODAWON ROAD, OPP. RAJKAMAL PETROL PUMP, MEHSANA HIGHWAY, MEHSANA-384002', 6, 7, 28, 4, 'aaravtender@gmail.com', NULL, '[\"\"]', '2025-09-05 07:29:44', 1, 3, NULL, '2025-09-05 07:29:44', '2025-09-05 11:58:00', NULL),
(31, 97, 2, 1, 1, 'SALES MARKETING', 2, 4, 1, 4, 5, '30000', 'Conduct market research to understand customer needs and trends.\r\n\r\nDevelop and implement marketing strategies and campaigns.\r\n\r\nManage digital marketing (social media, SEO, email, ads).', 'Silicon sponta, radhanpur road,opp. shubha residence, mehsana-384002 gujarat, india', 4, '6357024600', NULL, '2nd floor,jagdish chamber nr. anad niketan school, malgodown road, opp. rajkamal petrol pump, mehsana highway, mehsana-384002', 6, 7, 28, 4, 'aaravtender@gmail.com', '6357024600', '[\"\"]', '2025-09-05 09:24:20', 1, 4, NULL, '2025-09-05 09:24:20', '2025-09-05 12:15:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_apply`
--

CREATE TABLE `tbl_job_apply` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `file_nm` varchar(255) DEFAULT NULL COMMENT 'Uploaded file: image/pdf/doc/docx',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Accepted, 2 = Rejected 3: Shortlisted 4 = Schedule Interview',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_apply`
--

INSERT INTO `tbl_job_apply` (`id`, `job_id`, `user_id`, `description`, `file_nm`, `status`, `datetime`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 20, 43, NULL, 'resumes/mukesh-suthar_68a2cf8de85af_resume.pdf', 2, '2025-08-18 07:03:51', '2025-08-18 07:03:51', '2025-08-18 08:12:53', NULL),
(2, 21, 45, NULL, 'resumes/ganesh-shah_68a30194a0a35_resume.pdf', 1, '2025-08-18 10:35:51', '2025-08-18 10:35:51', '2025-08-18 10:42:51', NULL),
(3, 22, 69, NULL, 'resumes/pravin-raval_68a46962ba8a4_resume.pdf', 0, '2025-08-19 12:17:33', '2025-08-19 12:17:33', '2025-08-19 12:17:33', NULL),
(4, 27, 79, NULL, 'resumes/kajal-patel_68a6ca28d53ed_resume.pdf', 4, '2025-08-21 08:34:21', '2025-08-21 08:34:21', '2025-08-21 08:38:34', NULL),
(5, 24, 79, NULL, 'resumes/kajal-patel_68a6ca28d53ed_resume.pdf', 1, '2025-08-21 11:20:07', '2025-08-21 11:20:07', '2025-08-21 12:16:17', NULL),
(6, 24, 76, NULL, 'resumes/priyanka-suthar_68a70f5a10e45_resume.pdf', 2, '2025-08-21 12:23:16', '2025-08-21 12:21:46', '2025-08-21 12:23:16', NULL),
(7, 24, 89, NULL, 'resumes/vejal-surati_68b1956742c14_resume.pdf', 4, '2025-08-29 12:12:41', '2025-08-29 12:12:41', '2025-08-29 12:29:20', NULL),
(8, 30, 98, NULL, 'resumes/kajal-desai_68ba8c8e70a3b_resume.pdf', 2, '2025-09-05 09:15:24', '2025-09-05 08:46:12', '2025-09-05 09:15:24', NULL),
(9, 29, 92, NULL, 'resumes/jinal-ravat_68ba7c0431902_resume.pdf', 4, '2025-09-05 09:05:25', '2025-09-05 09:05:25', '2025-09-05 09:11:40', NULL),
(10, 29, 100, NULL, 'resumes/sangita-yadav_68baaba4da4f1_resume.pdf', 4, '2025-09-05 09:21:40', '2025-09-05 09:21:40', '2025-09-05 12:08:09', NULL),
(11, 31, 100, NULL, 'resumes/sangita-yadav_68baacbb5cc3b_resume.pdf', 1, '2025-09-05 09:26:19', '2025-09-05 09:26:19', '2025-09-05 09:49:14', NULL),
(12, 31, 95, NULL, 'resumes/piyush-dave_68ba84f2ca512_resume.pdf', 1, '2025-09-05 09:27:40', '2025-09-05 09:27:40', '2025-09-05 09:46:33', NULL),
(13, 31, 93, NULL, 'resumes/chauhan-archana_68babbd68e9ea_resume.pdf', 1, '2025-09-05 10:30:46', '2025-09-05 10:30:46', '2025-09-05 11:17:16', NULL),
(14, 30, 102, NULL, 'resumes/patel-fulketa-pravinbhai_68babb285a68c_resume.pdf', 1, '2025-09-05 10:54:24', '2025-09-05 10:54:24', '2025-09-05 11:15:31', NULL),
(15, 29, 104, NULL, 'resumes/avni-bhavsar_68bac3daa9f95_resume.pdf', 4, '2025-09-05 11:04:58', '2025-09-05 11:04:58', '2025-09-05 12:07:28', NULL),
(16, 30, 107, NULL, 'resumes/priya-barot_68bad0482f607_resume.pdf', 0, '2025-09-05 11:58:00', '2025-09-05 11:58:00', '2025-09-05 11:58:00', NULL),
(17, 29, 56, NULL, 'resumes/reshma-senma_68a41e5742a88_resume.pdf', 4, '2025-09-05 12:04:46', '2025-09-05 12:04:46', '2025-09-05 12:12:09', NULL),
(18, 31, 108, NULL, 'resumes/vaishali-rajnikant-joshi_68bad1018d25d_resume.pdf', 3, '2025-09-05 12:15:47', '2025-09-05 12:15:47', '2025-09-05 12:18:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_apply_history`
--

CREATE TABLE `tbl_job_apply_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `job_apply_id` bigint(20) UNSIGNED NOT NULL,
  `msg` text DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_apply_history`
--

INSERT INTO `tbl_job_apply_history` (`id`, `user_id`, `job_id`, `job_apply_id`, `msg`, `datetime`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 43, 20, 1, 'rejected', '2025-08-18 07:03:51', '2025-08-18 07:03:51', '2025-08-18 08:12:53', NULL),
(2, 45, 21, 2, 'Selected for this job', '2025-08-18 10:35:51', '2025-08-18 10:35:51', '2025-08-18 10:42:51', NULL),
(3, 69, 22, 3, '', '2025-08-19 12:17:33', '2025-08-19 12:17:33', '2025-08-19 12:17:33', NULL),
(4, 79, 27, 4, '', '2025-08-21 08:34:21', '2025-08-21 08:34:21', '2025-08-21 08:34:21', NULL),
(5, 79, 24, 5, 'Selected', '2025-08-21 11:20:07', '2025-08-21 11:20:07', '2025-08-21 12:16:17', NULL),
(6, 76, 24, 6, '', '2025-08-21 12:21:46', '2025-08-21 12:21:46', '2025-08-21 12:21:46', NULL),
(7, 73, 24, 6, 'Do not match Profile', '2025-08-21 12:23:16', '2025-08-21 12:23:16', '2025-08-21 12:23:16', NULL),
(8, 89, 24, 7, '', '2025-08-29 12:12:41', '2025-08-29 12:12:41', '2025-08-29 12:12:41', NULL),
(9, 98, 30, 8, '', '2025-09-05 08:46:12', '2025-09-05 08:46:12', '2025-09-05 08:46:12', NULL),
(10, 92, 29, 9, 'good', '2025-09-05 09:05:25', '2025-09-05 09:05:25', '2025-09-05 11:42:20', NULL),
(11, 97, 30, 8, 'Not mach a profile', '2025-09-05 09:15:24', '2025-09-05 09:15:24', '2025-09-05 09:15:24', NULL),
(12, 100, 29, 10, '', '2025-09-05 09:21:40', '2025-09-05 09:21:40', '2025-09-05 09:21:40', NULL),
(13, 100, 31, 11, 'GOOD', '2025-09-05 09:26:19', '2025-09-05 09:26:19', '2025-09-05 09:49:14', NULL),
(14, 95, 31, 12, 'GOOD PROFILE', '2025-09-05 09:27:40', '2025-09-05 09:27:40', '2025-09-05 09:44:46', NULL),
(15, 93, 31, 13, 'GOOD PROFILE', '2025-09-05 10:30:46', '2025-09-05 10:30:46', '2025-09-05 11:17:16', NULL),
(16, 102, 30, 14, 'GOOD', '2025-09-05 10:54:24', '2025-09-05 10:54:24', '2025-09-05 11:15:31', NULL),
(17, 104, 29, 15, '', '2025-09-05 11:04:58', '2025-09-05 11:04:58', '2025-09-05 11:04:58', NULL),
(18, 107, 30, 16, '', '2025-09-05 11:58:00', '2025-09-05 11:58:00', '2025-09-05 11:58:00', NULL),
(19, 56, 29, 17, '', '2025-09-05 12:04:46', '2025-09-05 12:04:46', '2025-09-05 12:04:46', NULL),
(20, 108, 31, 18, '', '2025-09-05 12:15:47', '2025-09-05 12:15:47', '2025-09-05 12:15:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_category`
--

CREATE TABLE `tbl_job_category` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `preference_type` varchar(255) DEFAULT NULL COMMENT '1: Skill 2: Non-Skill',
  `category_nm` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_category`
--

INSERT INTO `tbl_job_category` (`category_id`, `preference_type`, `category_nm`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2', 'IT Company', '1752841272_687a3c38c72b1.png', '2025-09-30 05:27:31', '2025-07-13 03:16:49', '2025-09-30 05:27:31'),
(2, '1', 'Accounnting', '1752841342_687a3c7e9ea88.png', '2025-09-30 05:27:33', '2025-07-17 02:16:22', '2025-09-30 05:27:33'),
(3, '2', 'Marketing Sale', '1752922606_687b79eed2af6.png', '2025-09-30 05:27:37', '2025-07-18 23:56:46', '2025-09-30 05:27:37'),
(4, '1', 'Customer Help', '1752922618_687b79faeaca6.png', '2025-09-30 05:27:49', '2025-07-18 23:56:59', '2025-09-30 05:27:49'),
(5, '1', 'Finance', '1752922629_687b7a05e51b7.png', '2025-09-30 05:27:53', '2025-07-18 23:57:09', '2025-09-30 05:27:53'),
(6, '1', 'Software', '1752922641_687b7a11ce24e.png', '2025-09-30 05:29:01', '2025-07-18 23:57:21', '2025-09-30 05:29:01'),
(7, '1', 'Human Resource', '1752922654_687b7a1e7fa75.png', '2025-09-30 05:29:04', '2025-07-18 23:57:34', '2025-09-30 05:29:04'),
(8, '1', 'Management', '1752922670_687b7a2ecefba.png', '2025-09-30 05:29:08', '2025-07-18 23:57:50', '2025-09-30 05:29:08'),
(9, '1', 'Retail Products', '1752922685_687b7a3ddac3e.png', '2025-09-30 05:29:10', '2025-07-18 23:58:05', '2025-09-30 05:29:10'),
(10, '1', 'Security Analyst', '1752922694_687b7a46b5ea1.png', '2025-09-30 05:27:46', '2025-07-18 23:58:14', '2025-09-30 05:27:46'),
(11, '1', 'Content Writer', '1752922702_687b7a4e6edd9.png', '2025-09-30 05:29:15', '2025-07-18 23:58:22', '2025-09-30 05:29:15'),
(12, '1', 'Market Research', '1752922712_687b7a58a2fcb.png', '2025-09-30 05:29:21', '2025-07-18 23:58:32', '2025-09-30 05:29:21'),
(13, '2', 'Driver', '1755509590_68a2f3567d42c.png', '2025-09-30 05:27:43', '2025-08-18 09:33:10', '2025-09-30 05:27:43'),
(14, '1', 'IT & Software', '1759212711_68db74a72ee2f.jpg', '2025-10-01 08:38:58', '2025-09-30 06:11:51', '2025-10-01 08:38:58'),
(15, '1', 'ENGINEERING', '1759212866_68db754224285.jpg', '2025-10-01 08:39:02', '2025-09-30 06:14:26', '2025-10-01 08:39:02'),
(16, '2', 'HEALTHCARE / MEDICAL', '1759212940_68db758c3b569.jpg', '2025-09-30 06:15:53', '2025-09-30 06:15:40', '2025-09-30 06:15:53'),
(17, '1', 'HEALTHCARE / MEDICAL', '1759212964_68db75a4cf628.jpg', '2025-10-01 08:39:04', '2025-09-30 06:16:04', '2025-10-01 08:39:04'),
(18, '1', 'Finance & Accounts', '1759216995_68db85637e53a.webp', '2025-10-01 08:39:07', '2025-09-30 07:23:15', '2025-10-01 08:39:07'),
(19, '1', 'Sales & Marketing', '1759217131_68db85eb2a4f9.png', '2025-10-01 08:39:09', '2025-09-30 07:25:31', '2025-10-01 08:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_level`
--

CREATE TABLE `tbl_job_level` (
  `job_level_id` bigint(20) UNSIGNED NOT NULL,
  `type_nm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_level`
--

INSERT INTO `tbl_job_level` (`job_level_id`, `type_nm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Entry Level', '2025-07-30 23:52:53', '2025-07-30 23:52:53', NULL),
(2, 'Mid Level', '2025-07-30 23:52:57', '2025-07-30 23:52:57', NULL),
(3, 'Senior Level', '2025-07-30 23:53:02', '2025-07-30 23:53:02', NULL),
(4, 'Manager', '2025-07-30 23:53:07', '2025-07-30 23:53:07', NULL),
(5, 'Director', '2025-07-30 23:53:11', '2025-07-30 23:53:11', NULL),
(6, 'Executive', '2025-07-30 23:53:16', '2025-07-30 23:53:16', NULL),
(7, 'Team Lead', '2025-07-30 23:53:21', '2025-07-30 23:53:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_round`
--

CREATE TABLE `tbl_job_round` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `round_name` varchar(255) NOT NULL,
  `round_desc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_round`
--

INSERT INTO `tbl_job_round` (`id`, `job_id`, `round_name`, `round_desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 20, 'HR Round', 'A hands-on coding test to evaluate your HTML, CSS, JavaScript, and basic backend skills. This round focuses on real-world problem-solving and clean code practices.', '2025-08-18 06:54:09', '2025-08-18 06:54:09', NULL),
(2, 20, 'Technical Assessment', 'A hands-on coding test to evaluate your HTML, CSS, JavaScript, and basic backend skills. This round focuses on real-world problem-solving and clean code practices.', '2025-08-18 06:54:09', '2025-08-18 06:54:09', NULL),
(3, 21, 'Meeting Round', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s', '2025-08-18 10:21:24', '2025-08-18 10:21:24', NULL),
(4, 21, 'Salary Discuss', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s', '2025-08-18 10:21:24', '2025-08-18 10:21:24', NULL),
(5, 22, 'jit sir', 'first round', '2025-08-19 06:56:29', '2025-08-20 11:31:33', '2025-08-20 11:31:33'),
(6, 23, '1', 'face interview', '2025-08-19 09:29:37', '2025-08-19 09:29:37', NULL),
(7, 24, 'gopal sir', 'first round', '2025-08-21 06:47:24', '2025-08-21 06:47:24', NULL),
(8, 25, 'harshit sir', 'first round', '2025-08-21 06:56:51', '2025-08-21 06:56:51', NULL),
(9, 26, 'Rajan patel', '2 round', '2025-08-21 07:05:39', '2025-08-21 07:05:39', NULL),
(10, 27, 'Ankit soni', '1 round', '2025-08-21 07:14:58', '2025-08-21 07:14:58', NULL),
(11, 28, 'jit sir', '1 round', '2025-08-22 06:47:07', '2025-08-22 06:47:07', NULL),
(12, 29, '1', 'ONLINE INTERVIEW', '2025-09-05 06:27:45', '2025-09-05 06:27:45', NULL),
(13, 30, '1', 'FACE INTERVIEW', '2025-09-05 07:29:44', '2025-09-05 07:29:44', NULL),
(14, 31, '1', 'face interview', '2025-09-05 09:24:20', '2025-09-05 09:24:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_save`
--

CREATE TABLE `tbl_job_save` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `saved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_save`
--

INSERT INTO `tbl_job_save` (`id`, `user_id`, `job_id`, `saved_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 45, 21, '2025-08-18 10:26:12', '2025-08-18 10:26:12', '2025-08-18 10:26:12', NULL),
(2, 69, 22, '2025-08-19 12:19:03', '2025-08-19 12:19:03', '2025-08-19 12:19:03', NULL),
(3, 79, 27, '2025-08-21 08:35:04', '2025-08-21 08:35:04', '2025-08-21 08:35:04', NULL),
(4, 79, 24, '2025-08-21 11:20:17', '2025-08-21 11:20:17', '2025-08-21 11:20:17', NULL),
(5, 76, 24, '2025-08-21 12:20:52', '2025-08-21 12:20:52', '2025-08-21 12:20:52', NULL),
(6, 89, 24, '2025-08-29 12:12:26', '2025-08-29 12:12:26', '2025-08-29 12:12:26', NULL),
(7, 98, 30, '2025-09-05 08:44:40', '2025-09-05 08:44:40', '2025-09-05 08:44:40', NULL),
(8, 92, 24, '2025-09-05 09:00:50', '2025-09-05 09:00:50', '2025-09-05 09:00:50', NULL),
(9, 92, 29, '2025-09-05 09:05:07', '2025-09-05 09:05:07', '2025-09-05 09:05:07', NULL),
(10, 100, 29, '2025-09-05 09:16:50', '2025-09-05 09:16:50', '2025-09-05 09:16:50', NULL),
(11, 100, 31, '2025-09-05 09:25:54', '2025-09-05 09:25:54', '2025-09-05 09:25:54', NULL),
(12, 95, 31, '2025-09-05 09:27:28', '2025-09-05 09:27:28', '2025-09-05 09:27:28', NULL),
(13, 93, 31, '2025-09-05 10:22:09', '2025-09-05 10:22:09', '2025-09-05 10:22:09', NULL),
(14, 102, 30, '2025-09-05 10:54:16', '2025-09-05 10:54:16', '2025-09-05 10:54:16', NULL),
(15, 104, 29, '2025-09-05 11:03:31', '2025-09-05 11:03:31', '2025-09-05 11:03:31', NULL),
(16, 107, 30, '2025-09-05 11:57:00', '2025-09-05 11:57:00', '2025-09-05 11:57:00', NULL),
(17, 56, 29, '2025-09-05 12:04:34', '2025-09-05 12:04:34', '2025-09-05 12:04:34', NULL),
(18, 108, 31, '2025-09-05 12:15:41', '2025-09-05 12:15:41', '2025-09-05 12:15:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_type`
--

CREATE TABLE `tbl_job_type` (
  `job_type_id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_job_type`
--

INSERT INTO `tbl_job_type` (`job_type_id`, `type_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Full-Time', '2025-07-30 23:52:20', '2025-07-30 23:52:20', NULL),
(2, 'Part-Time', '2025-07-30 23:52:24', '2025-07-30 23:52:24', NULL),
(3, 'Internship', '2025-07-30 23:52:30', '2025-07-30 23:52:30', NULL),
(4, 'Freelance', '2025-07-30 23:52:33', '2025-07-30 23:52:33', NULL),
(5, 'Contract', '2025-07-30 23:52:38', '2025-07-30 23:52:38', NULL),
(6, 'Temporary', '2025-07-30 23:52:41', '2025-07-30 23:52:41', NULL),
(7, 'Remote', '2025-07-30 23:52:46', '2025-07-30 23:52:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_min_qualification`
--

CREATE TABLE `tbl_min_qualification` (
  `qualification_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_min_qualification`
--

INSERT INTO `tbl_min_qualification` (`qualification_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'High School Diploma', '2025-07-30 23:54:15', '2025-07-30 23:54:15', NULL),
(2, 'Bachelor\'s Degree', '2025-07-30 23:54:21', '2025-07-30 23:54:21', NULL),
(3, 'Master’s Degree', '2025-07-30 23:54:26', '2025-07-30 23:54:26', NULL),
(4, 'PhD', '2025-07-30 23:54:30', '2025-07-30 23:54:30', NULL),
(5, 'Diploma or Certification', '2025-07-30 23:54:35', '2025-07-30 23:54:35', NULL),
(6, 'Associate Degree', '2025-07-30 23:54:42', '2025-07-30 23:54:42', NULL),
(7, 'No Formal Education Required', '2025-07-30 23:54:47', '2025-07-30 23:54:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plan_history`
--

CREATE TABLE `tbl_plan_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `duration` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_plan_history`
--

INSERT INTO `tbl_plan_history` (`id`, `plan_id`, `user_id`, `purchase_date`, `expire_date`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 40, '2025-08-15', '2026-08-15', '1Y', 1, '2025-08-15 09:07:02', '2025-08-15 09:07:02'),
(2, 8, 41, '2025-08-15', '2026-08-15', '1Y', 1, '2025-08-15 09:11:04', '2025-08-15 09:11:04'),
(3, 8, 42, '2025-08-15', '2026-08-15', '1Y', 1, '2025-08-15 10:57:42', '2025-08-15 10:57:42'),
(4, 8, 43, '2025-08-18', '2026-08-18', '1Y', 1, '2025-08-18 06:48:38', '2025-08-18 06:48:38'),
(5, 7, 44, '2025-08-18', '2025-09-18', '1M', 1, '2025-08-18 06:50:33', '2025-08-18 06:50:33'),
(6, 10, 45, '2025-07-18', '2025-08-17', '1M', 1, '2025-08-18 09:54:15', '2025-08-18 09:54:15'),
(7, 5, 46, '2025-07-16', '2025-08-17', '1M', 1, '2025-08-18 10:15:32', '2025-08-18 10:15:32'),
(8, 8, 48, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 05:12:23', '2025-08-19 05:12:23'),
(9, 8, 49, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 05:48:21', '2025-08-19 05:48:21'),
(10, 8, 50, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 05:52:06', '2025-08-19 05:52:06'),
(11, 8, 51, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 06:17:38', '2025-08-19 06:17:38'),
(12, 8, 52, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 06:19:29', '2025-08-19 06:19:29'),
(13, 8, 53, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 06:37:26', '2025-08-19 06:37:26'),
(14, 9, 55, '2025-08-19', '2025-09-19', '1M', 1, '2025-08-19 06:47:47', '2025-08-19 06:47:47'),
(15, 8, 56, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 06:48:17', '2025-08-19 06:48:17'),
(16, 5, 54, '2025-08-19', '2025-09-19', '1M', 1, '2025-08-19 06:51:36', '2025-08-19 06:51:36'),
(17, 8, 57, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 06:58:41', '2025-08-19 06:58:41'),
(18, 8, 58, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 07:09:13', '2025-08-19 07:09:13'),
(19, 8, 59, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 07:21:29', '2025-08-19 07:21:29'),
(20, 8, 60, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 07:21:37', '2025-08-19 07:21:37'),
(21, 5, 61, '2025-08-19', '2025-09-19', '1M', 1, '2025-08-19 07:32:46', '2025-08-19 07:32:46'),
(22, 8, 62, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 08:39:33', '2025-08-19 08:39:33'),
(23, 8, 63, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 08:53:22', '2025-08-19 08:53:22'),
(24, 8, 64, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 09:03:08', '2025-08-19 09:03:08'),
(25, 8, 65, '2025-08-19', '2026-08-19', '1Y', 1, '2025-08-19 09:04:03', '2025-08-19 09:04:03'),
(26, 7, 66, '2025-08-19', '2025-09-19', '1M', 1, '2025-08-19 09:07:18', '2025-08-19 09:07:18'),
(27, 5, 67, '2025-08-19', '2025-09-19', '1M', 1, '2025-08-19 09:29:14', '2025-08-19 09:29:14'),
(28, 9, 69, '2025-08-19', '2025-09-19', '1M', 1, '2025-08-19 11:27:35', '2025-08-19 11:27:35'),
(29, 8, 70, '2025-08-20', '2026-08-20', '1Y', 1, '2025-08-20 04:30:10', '2025-08-20 04:30:10'),
(30, 8, 71, '2025-08-20', '2026-08-20', '1Y', 1, '2025-08-20 04:43:31', '2025-08-20 04:43:31'),
(31, 8, 72, '2025-08-21', '2026-08-21', '1Y', 1, '2025-08-21 05:40:43', '2025-08-21 05:40:43'),
(32, 7, 73, '2025-08-21', '2025-09-21', '1M', 1, '2025-08-21 06:45:09', '2025-08-21 06:45:09'),
(33, 8, 74, '2025-08-21', '2026-08-21', '1Y', 1, '2025-08-21 06:51:46', '2025-08-21 06:51:46'),
(34, 5, 75, '2025-08-21', '2025-09-21', '1M', 1, '2025-08-21 06:54:35', '2025-08-21 06:54:35'),
(35, 9, 76, '2025-08-21', '2025-09-21', '1M', 1, '2025-08-21 07:02:14', '2025-08-21 07:02:14'),
(36, 5, 77, '2025-08-21', '2025-09-21', '1M', 1, '2025-08-21 07:02:58', '2025-08-21 07:02:58'),
(37, 6, 78, '2025-08-21', '2025-09-21', '1M', 1, '2025-08-21 07:11:47', '2025-08-21 07:11:47'),
(38, 8, 79, '2025-08-21', '2026-08-21', '1Y', 1, '2025-08-21 07:19:44', '2025-08-21 07:19:44'),
(39, 10, 80, '2025-08-21', '2025-09-21', '1M', 1, '2025-08-21 09:35:00', '2025-08-21 09:35:00'),
(40, 8, 81, '2025-08-25', '2026-08-25', '1Y', 1, '2025-08-25 04:38:50', '2025-08-25 04:38:50'),
(41, 8, 82, '2025-08-25', '2026-08-25', '1Y', 1, '2025-08-25 06:46:15', '2025-08-25 06:46:15'),
(42, 8, 83, '2025-08-26', '2026-08-26', '1Y', 1, '2025-08-26 05:12:16', '2025-08-26 05:12:16'),
(43, 8, 84, '2025-08-26', '2026-08-26', '1Y', 1, '2025-08-26 06:40:27', '2025-08-26 06:40:27'),
(44, 8, 85, '2025-08-26', '2026-08-26', '1Y', 1, '2025-08-26 09:13:49', '2025-08-26 09:13:49'),
(45, 8, 86, '2025-08-26', '2026-08-26', '1Y', 1, '2025-08-26 10:01:07', '2025-08-26 10:01:07'),
(46, 8, 87, '2025-08-26', '2026-08-26', '1Y', 1, '2025-08-26 10:48:15', '2025-08-26 10:48:15'),
(47, 8, 88, '2025-08-26', '2026-08-26', '1Y', 1, '2025-08-26 11:41:23', '2025-08-26 11:41:23'),
(48, 8, 89, '2025-08-29', '2026-08-29', '1Y', 1, '2025-08-29 07:16:55', '2025-08-29 07:16:55'),
(49, 9, 90, '2025-09-01', '2025-10-01', '1M', 1, '2025-09-01 07:02:24', '2025-09-01 07:02:24'),
(50, 9, 91, '2025-09-01', '2025-10-01', '1M', 1, '2025-09-01 10:04:09', '2025-09-01 10:04:09'),
(51, 9, 92, '2025-09-05', '2025-10-05', '1M', 1, '2025-09-05 05:48:20', '2025-09-05 05:48:20'),
(52, 8, 93, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 05:52:36', '2025-09-05 05:52:36'),
(53, 5, 94, '2025-09-05', '2025-10-05', '1M', 1, '2025-09-05 06:11:22', '2025-09-05 06:11:22'),
(54, 8, 95, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 06:26:15', '2025-09-05 06:26:15'),
(55, 8, 96, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 06:42:16', '2025-09-05 06:42:16'),
(56, 6, 97, '2025-09-05', '2025-10-05', '1M', 1, '2025-09-05 06:51:39', '2025-09-05 06:51:39'),
(57, 8, 98, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 06:52:14', '2025-09-05 06:52:14'),
(58, 8, 98, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 06:53:42', '2025-09-05 06:53:42'),
(59, 8, 99, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 06:56:51', '2025-09-05 06:56:51'),
(60, 8, 100, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 07:24:37', '2025-09-05 07:24:37'),
(61, 8, 101, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 09:23:35', '2025-09-05 09:23:35'),
(62, 8, 102, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 10:22:22', '2025-09-05 10:22:22'),
(63, 10, 103, '2025-09-05', '2025-10-05', '1M', 1, '2025-09-05 10:27:33', '2025-09-05 10:27:33'),
(64, 8, 104, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 10:43:18', '2025-09-05 10:43:18'),
(65, 8, 106, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 11:22:33', '2025-09-05 11:22:33'),
(66, 8, 107, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 11:29:33', '2025-09-05 11:29:33'),
(67, 8, 108, '2025-09-05', '2026-09-05', '1Y', 1, '2025-09-05 11:56:54', '2025-09-05 11:56:54'),
(68, 7, 109, '2025-09-06', '2025-10-06', '1M', 1, '2025-09-06 08:07:29', '2025-09-06 08:07:29'),
(69, 8, 110, '2025-09-06', '2026-09-06', '1Y', 1, '2025-09-06 08:44:01', '2025-09-06 08:44:01'),
(70, 9, 111, '2025-09-06', '2025-10-06', '1M', 1, '2025-09-06 09:20:13', '2025-09-06 09:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plan_pricing`
--

CREATE TABLE `tbl_plan_pricing` (
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `plan_price` decimal(10,2) NOT NULL,
  `plan_description` text DEFAULT NULL,
  `plan_for` varchar(255) NOT NULL,
  `benefits` text DEFAULT NULL,
  `plan_duration` varchar(255) NOT NULL,
  `plan_time` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_plan_pricing`
--

INSERT INTO `tbl_plan_pricing` (`plan_id`, `plan_name`, `plan_price`, `plan_description`, `plan_for`, `benefits`, `plan_duration`, `plan_time`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Basic Plan', 499.00, 'Demo eeee', 'Company', '121212,Demo 12,Demo 123', 'Y', '3', 1, '2025-07-14 04:54:47', '2025-07-14 05:16:43', '2025-07-14 05:16:43'),
(2, 'Basic Plan', 1999.00, 'ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centu', 'Employee', 'Unlimited updates,Custom designs & features,Custom permissions,Custom instructors,Free support ticket', 'M', '1', 1, '2025-07-14 05:18:32', '2025-07-31 00:01:08', '2025-07-31 00:01:08'),
(3, 'Gold Plan', 2999.00, 'Lorem Ipsum is simply dummy text of the printing', 'Employee', 'Lorem Ipsum is simply dummy text,a long established fact that a reader,a long established fact that a reader,a long established fact that a reader', 'M', '1', 1, '2025-07-17 08:07:49', '2025-07-31 00:01:10', '2025-07-31 00:01:10'),
(4, 'Golden', 1999.00, 'Demo', 'Company', 'Demo,Demo 1,Demo 2,Demo 3', 'M', '1', 1, '2025-07-24 00:37:52', '2025-07-31 00:01:12', '2025-07-31 00:01:12'),
(5, 'Starter Plan', 499.00, 'Best for startups or companies hiring occasionally.', 'Company', 'Post up to 5 job listings,Job visibility for 15 days,Basic applicant filtering,Limited resume access,Email alerts for applications', 'M', '1', 1, '2025-07-31 00:03:30', '2025-07-31 00:03:30', NULL),
(6, 'Growth Plan', 1499.00, 'Suitable for growing companies with regular hiring needs.', 'Company', 'Post up to 25 job listings,Job visibility for 30 days,Resume database access,Featured job highlight,Employer dashboard with analytics', 'M', '1', 1, '2025-07-31 00:04:10', '2025-07-31 00:04:10', NULL),
(7, 'Enterprise Plan', 2999.00, 'Designed for large-scale recruitment and branding.', 'Company', 'Unlimited job postings,60-day visibility per job,Priority listing and promotions,Access to all candidate resumes,Dedicated account manager', 'M', '1', 1, '2025-07-31 00:04:54', '2025-07-31 00:04:54', NULL),
(8, 'Free Plan', 0.00, 'Get started with basic job search tools.', 'Employee', 'Apply to 10 jobs/month,Basic profile visibility,Email job alerts,Resume builder access,View saved jobs', 'Y', '1', 1, '2025-07-31 00:05:35', '2025-07-31 00:05:35', NULL),
(9, 'Pro Plan', 299.00, 'Upgrade your visibility and boost applications.', 'Employee', 'Unlimited job applications,Highlighted profile,Access to premium jobs,Advanced resume analytics,Direct recruiter messaging', 'M', '1', 1, '2025-07-31 00:06:13', '2025-07-31 00:06:13', NULL),
(10, 'Elite Plan', 999.00, 'Full career support for serious job seekers.', 'Employee', ',Resume review by experts,Priority placement in search,Interview preparation kit,1-on-1 career coaching (email support),Premium badge on profile', 'M', '1', 1, '2025-07-31 00:06:52', '2025-08-18 09:53:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resume`
--

CREATE TABLE `tbl_resume` (
  `resume_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `file_nm` varchar(255) NOT NULL,
  `resume_type` tinyint(4) NOT NULL COMMENT '1: Uploaded Resume, 2: Resume Builder',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_resume`
--

INSERT INTO `tbl_resume` (`resume_id`, `user_id`, `file_nm`, `resume_type`, `created_at`, `updated_at`) VALUES
(1, 42, 'resumes/khushi-patel_689f132606ee0_resume.pdf', 2, '2025-08-15 10:59:50', '2025-08-15 10:59:50'),
(2, 43, 'resumes/mukesh-suthar_68a2cf707df1d_resume.pdf', 1, '2025-08-18 06:59:43', '2025-08-18 07:00:00'),
(3, 43, 'resumes/mukesh-suthar_68a2cf8de85af_resume.pdf', 2, '2025-08-18 07:00:30', '2025-08-18 07:00:30'),
(4, 45, 'resumes/ganesh-shah_68a30026435fa_resume.pdf', 1, '2025-08-18 10:27:50', '2025-08-18 10:27:50'),
(5, 45, 'resumes/ganesh-shah_68a30194a0a35_resume.pdf', 2, '2025-08-18 10:33:56', '2025-08-18 10:33:56'),
(6, 48, 'resumes/khushbu-patel_68a408bf624f2_resume.pdf', 2, '2025-08-19 05:16:47', '2025-08-19 05:16:47'),
(7, 49, 'resumes/khushbu-patel_68a4121ad68de_resume.pdf', 1, '2025-08-19 05:56:42', '2025-08-19 05:56:42'),
(8, 52, 'resumes/vidhi-patel_68a41833bda96_resume.pdf', 1, '2025-08-19 06:22:43', '2025-08-19 06:22:43'),
(9, 53, 'resumes/priyanka-mangalani_68a41bca8c958_resume.pdf', 1, '2025-08-19 06:38:02', '2025-08-19 06:38:02'),
(10, 56, 'resumes/reshma-senma_68a41e5742a88_resume.pdf', 1, '2025-08-19 06:48:55', '2025-08-19 06:48:55'),
(11, 57, 'resumes/dhara-solanki_68a420b95b744_resume.pdf', 1, '2025-08-19 06:59:05', '2025-08-19 06:59:05'),
(12, 51, 'resumes/mittal-raval_68a4221525bc0_resume.pdf', 2, '2025-08-19 07:04:53', '2025-08-19 07:04:53'),
(13, 58, 'resumes/hiral-parmar_68a4235a3d2a9_resume.pdf', 1, '2025-08-19 07:10:18', '2025-08-19 07:10:18'),
(14, 59, 'resumes/juhi-verjani_68a4262a47953_resume.pdf', 1, '2025-08-19 07:22:18', '2025-08-19 07:22:18'),
(15, 63, 'resumes/prakash-patel_68a43b9d2a51d_resume.pdf', 1, '2025-08-19 08:53:49', '2025-08-19 08:53:49'),
(16, 64, 'resumes/sneha-patel_68a43debceec9_resume.pdf', 1, '2025-08-19 09:03:39', '2025-08-19 09:03:39'),
(17, 69, 'resumes/pravin-raval_68a46962ba8a4_resume.pdf', 1, '2025-08-19 12:09:06', '2025-08-19 12:09:06'),
(18, 70, 'resumes/vikash-prajapati_68a54f6e9336f_resume.pdf', 1, '2025-08-20 04:30:38', '2025-08-20 04:30:38'),
(19, 71, 'resumes/diya-patel_68a5528e729fe_resume.pdf', 1, '2025-08-20 04:43:58', '2025-08-20 04:43:58'),
(20, 72, 'resumes/nikita-prajapati_68a6b8aca4120_resume.pdf', 2, '2025-08-21 06:11:57', '2025-08-21 06:11:57'),
(21, 79, 'resumes/kajal-patel_68a6ca28d53ed_resume.pdf', 1, '2025-08-21 07:26:32', '2025-08-21 07:26:32'),
(22, 81, 'resumes/kumbhar-aradhana_68abf1c97d63d_resume.pdf', 1, '2025-08-25 05:13:15', '2025-08-25 05:16:57'),
(23, 83, 'resumes/mausami-s-patal_68ad47f64a59f_resume.pdf', 1, '2025-08-26 05:32:13', '2025-08-26 05:36:54'),
(24, 84, 'resumes/patel-vidhi-dineshbhai_68ad58bdcb62f_resume.pdf', 1, '2025-08-26 06:46:52', '2025-08-26 06:48:29'),
(25, 85, 'resumes/prajapati-mihigna-arvinbhai_68ad7e6bd8a41_resume.pdf', 1, '2025-08-26 09:29:15', '2025-08-26 09:29:15'),
(26, 89, 'resumes/vejal-surati_68b1956742c14_resume.pdf', 1, '2025-08-29 11:55:17', '2025-08-29 11:56:23'),
(27, 90, 'resumes/chiragkumar-c-bhatt_68b54d8829136_resume.pdf', 2, '2025-09-01 07:38:48', '2025-09-01 07:38:48'),
(28, 92, 'resumes/jinal-ravat_68ba7c0431902_resume.pdf', 1, '2025-09-05 05:58:28', '2025-09-05 05:58:28'),
(29, 95, 'resumes/piyush-dave_68ba84f2ca512_resume.pdf', 1, '2025-09-05 06:36:34', '2025-09-05 06:36:34'),
(30, 99, 'resumes/sathvara-vidhi-shaileshbhai_68ba8b827e5c4_resume.pdf', 1, '2025-09-05 07:04:34', '2025-09-05 07:04:34'),
(31, 98, 'resumes/kajal-desai_68ba8c8e70a3b_resume.pdf', 1, '2025-09-05 07:09:02', '2025-09-05 07:09:02'),
(32, 102, 'resumes/patel-fulketa-pravinbhai_68babb285a68c_resume.pdf', 1, '2025-09-05 10:27:52', '2025-09-05 10:27:52'),
(33, 103, 'resumes/manish-patel_68bac10d5b7ba_resume.pdf', 1, '2025-09-05 10:50:28', '2025-09-05 10:53:01'),
(34, 106, 'resumes/mayank-kiranbhai-modi_68baca1c0552f_resume.pdf', 1, '2025-09-05 11:31:40', '2025-09-05 11:31:40'),
(35, 108, 'resumes/vaishali-rajnikant-joshi_68bad1018d25d_resume.pdf', 1, '2025-09-05 12:01:05', '2025-09-05 12:01:05'),
(36, 110, 'resumes/jaysinh-zala_68bbf6c31d898_resume.pdf', 1, '2025-09-06 08:54:27', '2025-09-06 08:54:27'),
(37, 111, 'resumes/jagdish-pravinbhai-makwana_68bbfe5562329_resume.pdf', 1, '2025-09-06 09:26:45', '2025-09-06 09:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resume_builder`
--

CREATE TABLE `tbl_resume_builder` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `resume_id` bigint(20) UNSIGNED NOT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `skills` text DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_resume_builder`
--

INSERT INTO `tbl_resume_builder` (`id`, `user_id`, `resume_id`, `profile_img`, `full_name`, `email`, `phone`, `skills`, `designation`, `summary`, `experience`, `education`, `created_at`, `updated_at`) VALUES
(1, 42, 1, NULL, 'Khushi Patel', 'zobpot.1@gmail.com', '6357024500', 'HR', 'Expiriance', NULL, '3 Year Experience', 'B.com', '2025-08-15 10:59:50', '2025-08-15 10:59:50'),
(2, 43, 2, NULL, 'Mukesh Suthar', 'mukeshsthr690@gmail.com', '7296930519', 'html,css,bootstarp', 'Software Developer', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-08-18 06:59:43', '2025-08-18 06:59:43'),
(4, 45, 5, NULL, 'Mukesh Suthar', 'mukeshahmd@gmail.com', '7296930519', 'Driver,road,full time', 'Software Developer', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s \r\n\r\nstandard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap \r\n\r\ninto electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-08-18 10:33:56', '2025-08-18 10:33:56'),
(5, 48, 6, NULL, 'KHUSHBU PATEL', 'ap4065981@gmail.com', '6353973478', 'EXCLE,MS OFFICE,WORD,POWER POINT,', 'Fresher', 'GOOD COMPUTER SKILL', NULL, '12 PASS', '2025-08-19 05:16:47', '2025-08-19 05:16:47'),
(6, 51, 12, NULL, 'Raval Mittal', 'Zobpot.5@gmail.com', '6357024900', 'good communication , Ability to team Work', 'Marketing Representive', NULL, '6 month', 'B.A complete', '2025-08-19 07:04:53', '2025-08-19 07:04:53'),
(7, 72, 20, NULL, 'NIKITA PRAJAPATI', 'nikitaprajapati1412@gmail.com', '63519 73697', 'GOOD COMPUTER SKILL', 'Fresher', 'Sales Executive with 3+ years of experience in B2B sales, proven record of achieving targets, and strong client relationship skills.”', NULL, 'b.com', '2025-08-21 06:11:57', '2025-08-21 06:11:57'),
(8, 81, 22, NULL, 'Kumbhar Aradhana', 'aradhanap209@gmail.com', '7698650209', 'good communication , Ability to team Work', 'Exprience', 'Having special  skills like:\r\nAbility to communicate effective with the team members and client.\r\ncapacity to work in team or individually and take up resposibility .', 'I have 3 years experience as a computer operator  at  nayan jyot press, mehesana.', '1. SSC - GSEB Gandhinagar \r\n2. HSC - GSEB Gandhinagar \r\n3.B.A  - HNGU, Patan \r\n4. M.A - HNGU ,Patan', '2025-08-25 05:13:15', '2025-08-25 05:13:15'),
(9, 83, 23, NULL, 'Mausami S.Patel', 'patelmausami268@gmail.com', '9737179237', 'Domestic data entry operter', 'Exprience', 'To start career with an organization that provides  immediate  challenge  and excellent training and which enables me to apply.', 'School name :Dhuliben Ramabhai Higher  Secondary Vidhalay , Raiya\r\nFROM :june-2018 To :May 2019\r\nSubject :physics', '1. SSC -G.S.E.B\r\n2. HSC -G.H.S.E.B\r\n3. BSC - HNGU\r\n4. MSC - HNGU\r\n5.B.ed- HNGU', '2025-08-26 05:32:13', '2025-08-26 05:32:13'),
(10, 84, 24, NULL, 'Patel Vidhi Dineshbhai', 'vidhip408@gmail.com', '9327008143', 'good communication , Ability to team Work', 'Accounter', 'To work in an organization where i am able to contribute in the organization growth.', 'Fresher', 'SSC -GSEB\r\nHSC- GSHEB\r\nB.COM- HNGU', '2025-08-26 06:46:52', '2025-08-26 06:46:52'),
(11, 89, 26, NULL, 'vejal surti', 'vejaisurati@gmail.com', '73596 90763', 'communication,management,problem solving,collaboration,leadership', 'Fresher', 'Highly-motivated employee with desire to take on new challenges. Adaptabilty, and exceptional interpersonal skill. Adept at working and quickly mastering new skill.', NULL, 'Master of Arts (English)', '2025-08-29 11:55:17', '2025-08-29 11:55:17'),
(12, 90, 27, NULL, 'CHIRAGKUMAR C. BHATT', 'chiragbhatt1525@gmail.com', '8200218054', NULL, NULL, 'To seek a channeling position in a challenging and stimulating environment personal growth and career development associating with an organization provides an ambiance for lerning and professional growth.', 'Organization Name:Prachem Laboratories Pvt. Ltd., Chhatral\r\n       Duration                             :18.10.2024 to till date \r\n       Duties                                   :\r\n   -> Manage the recrutiment and selection process\r\n   ->issues and negotiation.', 'B.Com(Eng)', '2025-09-01 07:38:48', '2025-09-01 07:38:48'),
(13, 103, 33, NULL, 'manisha patel', 'manishapatel@gmail.com', '83413 00244', 'good computer skill, good marketing', 'Fresher', 'Commerce Graduate with solid knowledge in accounts and finance. Skilled in MS Excel, tally, and data analysis with a focus on accuracy and efficiency.”', NULL, 'b.com/m.com', '2025-09-05 10:50:28', '2025-09-05 10:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_round_complete`
--

CREATE TABLE `tbl_round_complete` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `round_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `hr_name` varchar(255) DEFAULT NULL,
  `hr_contact_no` varchar(255) DEFAULT NULL,
  `hr_email` varchar(255) DEFAULT NULL,
  `interview_address` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `complete_datetime` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_round_complete`
--

INSERT INTO `tbl_round_complete` (`id`, `round_id`, `user_id`, `job_id`, `hr_name`, `hr_contact_no`, `hr_email`, `interview_address`, `datetime`, `complete_datetime`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 43, 20, NULL, '7867564534', 'mahesh@gmail.com', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', '2025-08-18 12:32:00', '2025-08-18 08:12:53', 1, 'rejected', '2025-08-18 07:03:51', '2025-08-18 08:12:53'),
(2, 2, 43, 20, NULL, '7867564534', 'mahesh@gmail.com', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', '2025-08-18 12:36:00', '2025-08-18 08:12:53', 1, 'rejected', '2025-08-18 07:03:51', '2025-08-18 08:12:53'),
(3, 3, 45, 21, NULL, '7867564534', 'mahesh@gmail.com', '409-B, Himalaya Arcade, Opp Vastrapur Lake, Vastrapur, Ahmedabad - Gujarat 380015', '2025-08-18 16:04:00', '2025-08-18 10:42:51', 1, 'Selected for this job', '2025-08-18 10:35:51', '2025-08-18 10:42:51'),
(4, 4, 45, 21, NULL, '7867564534', 'mahesh@gmail.com', '409-B, Himalaya Arcade, Opp Vastrapur Lake, Vastrapur, Ahmedabad - Gujarat 380015', '2025-08-18 16:07:00', '2025-08-18 10:42:51', 1, 'Selected for this job', '2025-08-18 10:35:51', '2025-08-18 10:42:51'),
(5, 5, 69, 22, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-08-19 12:17:33', '2025-08-19 12:17:33'),
(6, 10, 79, 27, NULL, '9016303444', 'consta@gmail.com', 'Chhatral', '2025-08-31 14:08:00', NULL, 0, NULL, '2025-08-21 08:34:21', '2025-08-23 08:37:41'),
(7, 7, 79, 24, NULL, '9016303444', 'zobpot.2@gmail.com', 'Ahmedabad', '2025-09-05 17:44:00', '2025-08-21 12:16:17', 1, 'Selected', '2025-08-21 11:20:07', '2025-08-21 12:16:17'),
(8, 7, 76, 24, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-08-21 12:21:46', '2025-08-21 12:21:46'),
(9, 7, 89, 24, NULL, '9016303444', 'zobpot.2@gmail.com', 'Ahmedabad', '2025-08-30 11:00:00', NULL, 0, NULL, '2025-08-29 12:12:41', '2025-08-29 12:29:20'),
(10, 13, 98, 30, NULL, '9016303444', 'aaravtender@gmail.com', '2ND FLOOR, JAGDISH CHAMBER NR. ANAD NIKETAN SCHOOL, MALGODAWON ROAD, OPP. RAJKAMAL PETROL PUMP, MEHSANA HIGHWAY, MEHSANA-384002', '2025-09-06 11:00:00', NULL, 0, NULL, '2025-09-05 08:46:12', '2025-09-05 08:53:39'),
(11, 12, 92, 29, NULL, '9016303444', 'hrd@deedygroup.com', 'S N 69 & 71 PAIKIL, B/H RAVI ESTATE, NR. GAYTRI DAIRY, AT DHANOT, TAL. KALOL, DIST. GANDHINAGAR, GUJARAT, INDIA.', '2025-09-06 11:00:00', '2025-09-05 11:42:20', 1, 'good', '2025-09-05 09:05:25', '2025-09-05 11:42:20'),
(12, 12, 100, 29, NULL, '9016303444', 'hrd@deedygroup.com', 'S N 69 & 71 PAIKIL, B/H RAVI ESTATE, NR. GAYTRI DAIRY, AT DHANOT, TAL. KALOL, DIST. GANDHINAGAR, GUJARAT, INDIA.', '2025-09-21 10:40:00', NULL, 0, NULL, '2025-09-05 09:21:40', '2025-09-05 12:08:09'),
(13, 14, 100, 31, NULL, '6357024600', 'aaravtender@gmail.com', 'Silicon sponta, radhanpur road,opp. shubha residence, mehsana-384002 gujarat, india', '2025-09-09 11:00:00', '2025-09-05 09:49:14', 1, 'GOOD', '2025-09-05 09:26:19', '2025-09-05 09:49:14'),
(14, 14, 95, 31, NULL, '6357024600', 'aaravtender@gmail.com', 'Silicon sponta, radhanpur road,opp. shubha residence, mehsana-384002 gujarat, india', '2025-09-09 23:59:00', '2025-09-05 09:46:33', 1, 'GOOD PROFILE', '2025-09-05 09:27:40', '2025-09-05 09:46:33'),
(15, 14, 93, 31, NULL, '6357024600', 'aaravtender@gmail.com', 'Silicon sponta, radhanpur road,opp. shubha residence, mehsana-384002 gujarat, india', '2025-09-14 11:30:00', '2025-09-05 11:17:16', 1, 'GOOD PROFILE', '2025-09-05 10:30:46', '2025-09-05 11:17:16'),
(16, 13, 102, 30, NULL, '9016303444', 'aaravtender@gmail.com', '2ND FLOOR, JAGDISH CHAMBER NR. ANAD NIKETAN SCHOOL, MALGODAWON ROAD, OPP. RAJKAMAL PETROL PUMP, MEHSANA HIGHWAY, MEHSANA-384002', '2025-09-21 10:00:00', '2025-09-05 11:15:31', 1, 'GOOD', '2025-09-05 10:54:24', '2025-09-05 11:15:31'),
(17, 12, 104, 29, NULL, '6357024600', 'hrd@deedygroup.com', 'S N 69 & 71 PAIKIL, B/H RAVI ESTATE, NR. GAYTRI DAIRY, AT DHANOT, TAL. KALOL, DIST. GANDHINAGAR, GUJARAT, INDIA.', '2025-09-14 10:40:00', NULL, 0, NULL, '2025-09-05 11:04:58', '2025-09-05 12:09:40'),
(18, 13, 107, 30, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-09-05 11:58:00', '2025-09-05 11:58:00'),
(19, 12, 56, 29, NULL, '9016303444', 'hrd@deedygroup.com', 'S N 69 & 71 PAIKIL, B/H RAVI ESTATE, NR. GAYTRI DAIRY, AT DHANOT, TAL. KALOL, DIST. GANDHINAGAR, GUJARAT, INDIA.', '2025-09-20 22:10:00', NULL, 0, NULL, '2025-09-05 12:04:46', '2025-09-06 05:03:13'),
(20, 14, 108, 31, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-09-05 12:15:47', '2025-09-05 12:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ShowCompanyDetails` tinyint(1) NOT NULL DEFAULT 1,
  `web_title` varchar(255) NOT NULL,
  `web_meta` varchar(255) DEFAULT NULL,
  `web_keyword` varchar(255) DEFAULT NULL,
  `web_description` text DEFAULT NULL,
  `about_us` text DEFAULT NULL,
  `header_logo` varchar(255) DEFAULT NULL,
  `footer_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `contact_1` varchar(255) DEFAULT NULL,
  `contact_2` varchar(255) DEFAULT NULL,
  `email_1` varchar(255) DEFAULT NULL,
  `email_2` varchar(255) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `play_store_link` varchar(255) DEFAULT NULL,
  `app_store_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `ShowCompanyDetails`, `web_title`, `web_meta`, `web_keyword`, `web_description`, `about_us`, `header_logo`, `footer_logo`, `favicon`, `contact_1`, `contact_2`, `email_1`, `email_2`, `Address`, `play_store_link`, `app_store_link`, `created_at`, `updated_at`) VALUES
(1, 0, 'demo', 'demo', 'demo', 'demo', '<p>Aenean sollicituin, lorem quis bibendum auctor nisi elit consequat ipsum sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet maurisorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctora ornare odio.</p><p>Aenean sollicituin, lorem quis bibendum auctor nisi elit consequat ipsum sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet maurisorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctora ornare odio.</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos.</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos.</p><p>&nbsp;</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos.</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos.</p>', '1755601908_68a45bf4c5fcc.jpeg', '1755601887_68a45bdfd7091.jpeg', '1753334004_6881c0f416e03.png', '+91 7296930519', NULL, 'info@zobpot.com', NULL, 'S/F 207, SILICON SPONTA, OPP : SHUBH RESIDENCY, RADHANPUR ROAD MEHSANA - 38002 (GUJARAT) INDIA', 'demo', 'demo', NULL, '2025-08-19 11:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_skills`
--

CREATE TABLE `tbl_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `skill_nm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_skills`
--

INSERT INTO `tbl_skills` (`id`, `category_id`, `sub_category_id`, `skill_nm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'HTML5,CSS3,JavaScript,React,jQuery,Bootstrap,PHP,Laravel,Node.js,MySQL,RESTful APIs,GitHub,Docker', '2025-07-30 23:59:04', '2025-07-30 23:59:04', NULL),
(2, 1, 2, 'Routing & Switching,VPN configuration,Windows Server,Linux,macOS', '2025-07-30 23:59:44', '2025-07-30 23:59:44', NULL),
(3, 2, 5, 'Tally ERP,Tally Prime,QuickBooks,MS Excel,Tax Filing Portals,Accounting Software', '2025-07-31 00:00:23', '2025-07-31 00:00:23', NULL),
(4, 2, 7, 'Payroll Processing & Management,Salary Calculations,Employee Benefits & Deductions,Leave & Attendance Management,Payroll Audits & Reconciliations', '2025-07-31 00:00:59', '2025-07-31 00:00:59', NULL),
(5, 3, 11, 'Demo', '2025-08-06 00:43:49', '2025-08-06 00:43:49', NULL),
(6, 13, 13, 'Transport Management,Responsiblity', '2025-08-18 09:38:22', '2025-08-18 09:38:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_activity`
--

CREATE TABLE `tbl_staff_activity` (
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `msg` text NOT NULL,
  `current_path` varchar(255) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_staff_activity`
--

INSERT INTO `tbl_staff_activity` (`activity_id`, `user_id`, `msg`, `current_path`, `datetime`) VALUES
(1, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-14 10:15:32'),
(2, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-15 08:56:12'),
(3, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-17 09:31:03'),
(4, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 03:54:38'),
(5, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 03:56:07'),
(6, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 03:56:28'),
(7, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 03:58:28'),
(8, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 04:55:07'),
(9, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 06:04:16'),
(10, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 06:35:26'),
(11, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 06:55:48'),
(12, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 06:56:19'),
(13, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 07:12:29'),
(14, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 08:15:58'),
(15, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 09:21:00'),
(16, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-18 09:25:22'),
(17, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-08-18 09:33:10'),
(18, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-08-18 09:34:47'),
(19, 1, 'Skills Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/skills', '2025-08-18 09:38:22'),
(20, 1, 'State Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/state/1', '2025-08-18 09:39:07'),
(21, 1, 'State Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/state/2', '2025-08-18 09:39:10'),
(22, 1, 'State Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/state/3', '2025-08-18 09:39:12'),
(23, 1, 'State Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/state/4', '2025-08-18 09:39:15'),
(24, 1, 'City Delete successfully.', 'https://zobpot.com/BetaVersion/public/admin/city/1', '2025-08-18 09:39:29'),
(25, 1, 'City Delete successfully.', 'https://zobpot.com/BetaVersion/public/admin/city/2', '2025-08-18 09:39:33'),
(26, 1, 'City Delete successfully.', 'https://zobpot.com/BetaVersion/public/admin/city/5', '2025-08-18 09:39:35'),
(27, 1, 'City Delete successfully.', 'https://zobpot.com/BetaVersion/public/admin/city/3', '2025-08-18 09:39:38'),
(28, 1, 'City Delete successfully.', 'https://zobpot.com/BetaVersion/public/admin/city/4', '2025-08-18 09:39:40'),
(29, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/11', '2025-08-18 09:40:04'),
(30, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/1', '2025-08-18 09:40:07'),
(31, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/2', '2025-08-18 09:40:09'),
(32, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/4', '2025-08-18 09:40:12'),
(33, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/5', '2025-08-18 09:40:14'),
(34, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/6', '2025-08-18 09:40:16'),
(35, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/7', '2025-08-18 09:40:18'),
(36, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/8', '2025-08-18 09:40:21'),
(37, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/9', '2025-08-18 09:40:23'),
(38, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/10', '2025-08-18 09:40:24'),
(39, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/13', '2025-08-18 09:40:26'),
(40, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/15', '2025-08-18 09:40:28'),
(41, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/16', '2025-08-18 09:40:30'),
(42, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/3', '2025-08-18 09:40:32'),
(43, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/17', '2025-08-18 09:40:34'),
(44, 1, 'Area Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area/18', '2025-08-18 09:40:36'),
(45, 1, 'Pincode Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/pincode/1', '2025-08-18 09:41:22'),
(46, 1, 'Pincode Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/pincode/3', '2025-08-18 09:41:37'),
(47, 1, 'State Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/state', '2025-08-18 09:49:28'),
(48, 1, 'City Added successfully.', 'https://zobpot.com/BetaVersion/public/admin/city', '2025-08-18 09:49:38'),
(49, 1, 'Area Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/area', '2025-08-18 09:49:51'),
(50, 1, 'Pincode Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/pincode', '2025-08-18 09:50:06'),
(51, 1, 'Plan Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/pricing/10', '2025-08-18 09:53:51'),
(52, 1, 'Candidate Profile update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/candidate-profile-update', '2025-08-18 09:56:44'),
(53, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 10:22:53'),
(54, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 10:23:11'),
(55, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 10:23:39'),
(56, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 10:23:57'),
(57, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 10:24:11'),
(58, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-18 10:24:31'),
(59, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 10:44:05'),
(60, 1, 'Staff Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/staff', '2025-08-18 10:47:57'),
(61, 47, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 10:48:28'),
(62, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 10:48:47'),
(63, 47, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-18 10:49:17'),
(64, 47, 'Job Category Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/1', '2025-08-18 10:49:39'),
(65, 1, 'Blog Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/blog', '2025-08-18 10:59:04'),
(66, 1, 'Testimonial Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/testimonial', '2025-08-18 11:00:19'),
(67, 1, 'Testimonial Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/testimonial/1', '2025-08-18 11:01:16'),
(68, 1, 'Website Achievements updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/update-achievements', '2025-08-18 11:02:13'),
(69, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 11:19:28'),
(70, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 11:35:40'),
(71, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 11:41:57'),
(72, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-18 12:21:31'),
(73, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 04:42:08'),
(74, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 04:52:03'),
(75, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 05:09:59'),
(76, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 05:17:40'),
(77, 1, 'Pincode Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/pincode', '2025-08-19 05:22:46'),
(78, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 05:33:02'),
(79, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 05:56:49'),
(80, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 06:19:18'),
(81, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 06:20:19'),
(82, 1, 'Candidate Profile update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/candidate-profile-update', '2025-08-19 06:21:16'),
(83, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 06:30:27'),
(84, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 06:41:28'),
(85, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 06:42:26'),
(86, 1, 'Candidate Profile about and skills updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/candidate-profile-about-skill-update', '2025-08-19 06:49:59'),
(87, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 07:00:45'),
(88, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 07:01:00'),
(89, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 07:35:04'),
(90, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 08:35:34'),
(91, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 08:42:45'),
(92, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:19'),
(93, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:25'),
(94, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:34'),
(95, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:41'),
(96, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:49'),
(97, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:52'),
(98, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:43:57'),
(99, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:44:01'),
(100, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:44:06'),
(101, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 08:44:08'),
(102, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:44:10'),
(103, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:44:14'),
(104, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 08:44:19'),
(105, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 08:46:42'),
(106, 54, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 09:06:00'),
(107, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 09:22:50'),
(108, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 09:25:27'),
(109, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 09:30:28'),
(110, 67, 'Candidate Profile update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/candidate-profile-update', '2025-08-19 09:36:33'),
(111, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 09:45:57'),
(112, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 09:58:44'),
(113, 1, 'Staff Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/staff', '2025-08-19 10:32:23'),
(114, 1, 'Staff Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/staff/68', '2025-08-19 10:45:41'),
(115, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-19 11:00:29'),
(116, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 11:01:26'),
(117, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-19 11:02:04'),
(118, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-19 11:02:27'),
(119, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-19 11:11:27'),
(120, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-19 11:11:36'),
(121, 1, 'Settings Update Successfully.', 'https://zobpot.com/BetaVersion/public/admin/setting/1', '2025-08-19 11:11:48'),
(122, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-19 12:05:16'),
(123, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 12:07:46'),
(124, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 12:08:25'),
(125, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-19 12:08:29'),
(126, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-20 11:29:19'),
(127, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-20 11:29:37'),
(128, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-20 11:29:41'),
(129, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-20 11:35:49'),
(130, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 05:27:52'),
(131, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 05:29:12'),
(132, 1, 'Staff Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/staff/47', '2025-08-21 05:32:32'),
(133, 1, 'Staff Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/staff/68', '2025-08-21 05:32:36'),
(134, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:32:50'),
(135, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:32:55'),
(136, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:32:59'),
(137, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:03'),
(138, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:07'),
(139, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:10'),
(140, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:15'),
(141, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:19'),
(142, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:23'),
(143, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:26'),
(144, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:32'),
(145, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:36'),
(146, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:39'),
(147, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:44'),
(148, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:49'),
(149, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:54'),
(150, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:33:57'),
(151, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:34:01'),
(152, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 05:34:11'),
(153, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 05:34:16'),
(154, 1, 'Role Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/roles/3', '2025-08-21 05:34:31'),
(155, 1, 'Role Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/roles/4', '2025-08-21 05:34:34'),
(156, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 05:36:26'),
(157, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:05:19'),
(158, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:19:23'),
(159, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:24:48'),
(160, 1, 'Role Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/roles', '2025-08-21 06:27:12'),
(161, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:27:25'),
(162, 1, 'Role Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/roles', '2025-08-21 06:32:54'),
(163, 1, 'Role Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/roles/6', '2025-08-21 06:32:58'),
(164, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 06:36:00'),
(165, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:41:57'),
(166, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:49:12'),
(167, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 06:57:43'),
(168, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 07:07:20'),
(169, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 07:10:13'),
(170, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 07:14:18'),
(171, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 07:18:37'),
(172, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 07:19:14'),
(173, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 07:19:19'),
(174, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 07:19:24'),
(175, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 07:19:28'),
(176, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 09:05:32'),
(177, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-21 09:10:33'),
(178, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 09:11:32'),
(179, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 09:16:36'),
(180, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 09:17:10'),
(181, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-08-21 09:17:40'),
(182, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-22 06:49:51'),
(183, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-22 06:51:04'),
(184, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-23 08:36:15'),
(185, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-25 06:47:52'),
(186, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-08-29 06:21:13'),
(187, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-09-04 05:10:58'),
(188, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-09-05 09:26:13'),
(189, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-09-05 10:12:46'),
(190, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-05 10:13:57'),
(191, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-09-05 10:16:54'),
(192, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-05 10:17:27'),
(193, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-05 10:18:12'),
(194, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-05 10:19:02'),
(195, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-05 10:19:48'),
(196, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-09-29 09:56:37'),
(197, 1, 'Blog Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/blog/1', '2025-09-29 10:03:32'),
(198, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 10:53:56'),
(199, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 10:54:00'),
(200, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 10:54:09'),
(201, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 10:54:16'),
(202, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 11:41:49'),
(203, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 11:41:54'),
(204, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 11:42:41'),
(205, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 11:42:46'),
(206, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 11:42:55'),
(207, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-29 11:43:04'),
(208, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-09-30 05:25:51'),
(209, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/1', '2025-09-30 05:27:31'),
(210, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/2', '2025-09-30 05:27:33'),
(211, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/3', '2025-09-30 05:27:37'),
(212, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/13', '2025-09-30 05:27:43'),
(213, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/10', '2025-09-30 05:27:46'),
(214, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/4', '2025-09-30 05:27:49'),
(215, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/5', '2025-09-30 05:27:53'),
(216, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/6', '2025-09-30 05:29:01'),
(217, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/7', '2025-09-30 05:29:04'),
(218, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/8', '2025-09-30 05:29:08'),
(219, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/9', '2025-09-30 05:29:10'),
(220, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/11', '2025-09-30 05:29:15'),
(221, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/12', '2025-09-30 05:29:21'),
(222, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/1', '2025-09-30 05:30:38'),
(223, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/2', '2025-09-30 05:30:41'),
(224, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/3', '2025-09-30 05:30:43'),
(225, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/4', '2025-09-30 05:30:46'),
(226, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/5', '2025-09-30 05:30:49'),
(227, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/6', '2025-09-30 05:30:54'),
(228, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/7', '2025-09-30 05:30:57'),
(229, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/8', '2025-09-30 05:31:39'),
(230, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/9', '2025-09-30 05:31:41'),
(231, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/11', '2025-09-30 05:31:45'),
(232, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/12', '2025-09-30 05:31:50'),
(233, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/13', '2025-09-30 05:31:52'),
(234, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-09-30 06:11:51'),
(235, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-09-30 06:14:26'),
(236, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-09-30 06:15:40'),
(237, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/16', '2025-09-30 06:15:53'),
(238, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-09-30 06:16:04'),
(239, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-09-30 07:04:04'),
(240, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-09-30 07:04:18'),
(241, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-09-30 07:04:33'),
(242, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-09-30 07:04:49'),
(243, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-09-30 07:05:02'),
(244, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-09-30 07:05:14'),
(245, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-09-30 07:23:15'),
(246, 1, 'Job Category Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category', '2025-09-30 07:25:31'),
(247, 1, 'User profile status updated successfully.', 'https://zobpot.com/BetaVersion/public/admin/approve-disapprove-profile-active', '2025-09-30 07:29:13'),
(248, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-10-01 05:22:54'),
(249, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:39:54'),
(250, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:40:08'),
(251, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:40:23'),
(252, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:40:41'),
(253, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:51:59'),
(254, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:52:23'),
(255, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:52:40'),
(256, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:53:00'),
(257, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:53:16'),
(258, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:54:16'),
(259, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:54:32'),
(260, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:54:47'),
(261, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:55:04'),
(262, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:55:27'),
(263, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:55:41'),
(264, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:56:00'),
(265, 1, 'Job Subcategory Added Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category', '2025-10-01 05:56:36'),
(266, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-10-01 08:38:50'),
(267, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/14', '2025-10-01 08:38:58'),
(268, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/15', '2025-10-01 08:39:02'),
(269, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/17', '2025-10-01 08:39:04'),
(270, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/18', '2025-10-01 08:39:07'),
(271, 1, 'Job Category Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-category/19', '2025-10-01 08:39:09'),
(272, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/14', '2025-10-01 08:39:15'),
(273, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/15', '2025-10-01 08:39:18'),
(274, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/17', '2025-10-01 08:39:21'),
(275, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/16', '2025-10-01 08:39:32'),
(276, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/18', '2025-10-01 08:39:35'),
(277, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/19', '2025-10-01 08:39:37'),
(278, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/20', '2025-10-01 08:39:40'),
(279, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/21', '2025-10-01 08:39:42'),
(280, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/22', '2025-10-01 08:39:45'),
(281, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/24', '2025-10-01 08:39:47'),
(282, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/23', '2025-10-01 08:39:50'),
(283, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/25', '2025-10-01 08:39:53'),
(284, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/26', '2025-10-01 08:39:55'),
(285, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/27', '2025-10-01 08:39:57'),
(286, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/28', '2025-10-01 08:40:00'),
(287, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/29', '2025-10-01 08:40:02'),
(288, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/30', '2025-10-01 08:40:04'),
(289, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/31', '2025-10-01 08:40:07'),
(290, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/32', '2025-10-01 08:40:09'),
(291, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/33', '2025-10-01 08:40:12'),
(292, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/34', '2025-10-01 08:40:14'),
(293, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/35', '2025-10-01 08:40:16'),
(294, 1, 'Job Subcategory Delete Successfully.', 'https://zobpot.com/BetaVersion/public/admin/job-sub-category/36', '2025-10-01 08:40:19'),
(295, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-10-30 04:28:43'),
(296, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-11-10 08:39:19'),
(297, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2025-11-11 04:08:12'),
(298, 1, 'Login Successfully', 'https://zobpot.com/BetaVersion/public/post-login', '2026-01-16 06:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`state_id`, `state_name`, `country_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gujrat', 1, '2025-07-31 00:11:23', '2025-08-18 09:39:07', '2025-08-18 09:39:07'),
(2, 'Maharastha', 1, '2025-07-31 01:12:27', '2025-08-18 09:39:10', '2025-08-18 09:39:10'),
(3, 'Rajasthan', 1, '2025-08-01 06:21:05', '2025-08-18 09:39:12', '2025-08-18 09:39:12'),
(4, 'Gujarat', 1, '2025-08-15 09:10:42', '2025-08-18 09:39:15', '2025-08-18 09:39:15'),
(5, 'Rajasthan', 1, '2025-08-18 09:49:28', '2025-08-18 09:49:28', NULL),
(6, 'gujarat', 1, '2025-08-19 05:11:19', '2025-08-19 05:11:19', NULL),
(7, 'Gujarat', 1, '2025-08-19 08:39:16', '2025-08-19 08:39:16', NULL),
(8, 'gujarat', 1, '2025-08-19 08:53:05', '2025-08-19 08:53:05', NULL),
(9, 'GUJARAT', 1, '2025-08-21 06:51:31', '2025-08-21 06:51:31', NULL),
(10, 'GUJARAT', 1, '2025-08-21 07:01:41', '2025-08-21 07:01:41', NULL),
(11, 'GUJARAT', 1, '2025-08-21 09:33:52', '2025-08-21 09:33:52', NULL),
(12, 'Gujarat', 1, '2025-08-25 06:45:59', '2025-08-25 06:45:59', NULL),
(13, 'gujarat', 1, '2025-08-26 05:11:41', '2025-08-26 05:11:41', NULL),
(14, 'Gandhinagar', 1, '2025-09-01 07:00:50', '2025-09-01 07:00:50', NULL),
(15, 'GUJARAT', 1, '2025-09-05 06:01:40', '2025-09-05 06:01:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_nm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sub_category`
--

INSERT INTO `tbl_sub_category` (`sub_category_id`, `category_id`, `sub_category_nm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Web Developer', '2025-07-30 23:50:05', '2025-09-30 05:30:38', '2025-09-30 05:30:38'),
(2, 1, 'System Administrator', '2025-07-30 23:50:12', '2025-09-30 05:30:41', '2025-09-30 05:30:41'),
(3, 1, 'Network Engineer', '2025-07-30 23:50:17', '2025-09-30 05:30:43', '2025-09-30 05:30:43'),
(4, 1, 'IT Support Specialist', '2025-07-30 23:50:24', '2025-09-30 05:30:46', '2025-09-30 05:30:46'),
(5, 2, 'Tax Accountant', '2025-07-30 23:50:31', '2025-09-30 05:30:49', '2025-09-30 05:30:49'),
(6, 2, 'Financial Auditor', '2025-07-30 23:50:37', '2025-09-30 05:30:54', '2025-09-30 05:30:54'),
(7, 2, 'Payroll Specialist', '2025-07-30 23:50:43', '2025-09-30 05:30:57', '2025-09-30 05:30:57'),
(8, 2, 'Accounts Payable/Receivable Clerk', '2025-07-30 23:50:49', '2025-09-30 05:31:39', '2025-09-30 05:31:39'),
(9, 3, 'Digital Marketing Executive', '2025-07-30 23:50:55', '2025-09-30 05:31:41', '2025-09-30 05:31:41'),
(10, 3, 'SEO Specialist', '2025-07-30 23:51:02', '2025-08-06 00:43:32', '2025-08-06 00:43:32'),
(11, 3, 'Sales Representative', '2025-07-30 23:51:09', '2025-09-30 05:31:45', '2025-09-30 05:31:45'),
(12, 3, 'Brand Manager', '2025-07-30 23:51:15', '2025-09-30 05:31:50', '2025-09-30 05:31:50'),
(13, 13, 'Truck Driver', '2025-08-18 09:34:47', '2025-09-30 05:31:52', '2025-09-30 05:31:52'),
(14, 14, 'Web Developer', '2025-09-30 07:04:04', '2025-10-01 08:39:15', '2025-10-01 08:39:15'),
(15, 14, 'Software Engineer', '2025-09-30 07:04:18', '2025-10-01 08:39:18', '2025-10-01 08:39:18'),
(16, 14, 'Mobile App Developer', '2025-09-30 07:04:33', '2025-10-01 08:39:32', '2025-10-01 08:39:32'),
(17, 14, 'Data Analyst', '2025-09-30 07:04:49', '2025-10-01 08:39:21', '2025-10-01 08:39:21'),
(18, 14, 'UI/UX Designer', '2025-09-30 07:05:02', '2025-10-01 08:39:35', '2025-10-01 08:39:35'),
(19, 14, 'Cyber Security', '2025-09-30 07:05:14', '2025-10-01 08:39:37', '2025-10-01 08:39:37'),
(20, 15, 'Civil Engineer', '2025-10-01 05:39:54', '2025-10-01 08:39:40', '2025-10-01 08:39:40'),
(21, 15, 'Electrical Engineer', '2025-10-01 05:40:08', '2025-10-01 08:39:42', '2025-10-01 08:39:42'),
(22, 15, 'Production Engineer', '2025-10-01 05:40:23', '2025-10-01 08:39:45', '2025-10-01 08:39:45'),
(23, 15, 'Quality Engineer', '2025-10-01 05:40:41', '2025-10-01 08:39:50', '2025-10-01 08:39:50'),
(24, 17, 'Doctor', '2025-10-01 05:51:59', '2025-10-01 08:39:47', '2025-10-01 08:39:47'),
(25, 17, 'Nurse', '2025-10-01 05:52:23', '2025-10-01 08:39:53', '2025-10-01 08:39:53'),
(26, 17, 'Pharmacist', '2025-10-01 05:52:40', '2025-10-01 08:39:55', '2025-10-01 08:39:55'),
(27, 17, 'Lab Technician', '2025-10-01 05:53:00', '2025-10-01 08:39:57', '2025-10-01 08:39:57'),
(28, 17, 'Medical Representative', '2025-10-01 05:53:16', '2025-10-01 08:40:00', '2025-10-01 08:40:00'),
(29, 18, 'Accountant', '2025-10-01 05:54:16', '2025-10-01 08:40:02', '2025-10-01 08:40:02'),
(30, 18, 'Chartered Accountant (CA)', '2025-10-01 05:54:32', '2025-10-01 08:40:04', '2025-10-01 08:40:04'),
(31, 18, 'Finance Executive', '2025-10-01 05:54:47', '2025-10-01 08:40:07', '2025-10-01 08:40:07'),
(32, 18, 'Audit Assistant', '2025-10-01 05:55:04', '2025-10-01 08:40:09', '2025-10-01 08:40:09'),
(33, 19, 'Business Development Executive', '2025-10-01 05:55:27', '2025-10-01 08:40:12', '2025-10-01 08:40:12'),
(34, 19, 'Digital Marketing Specialist', '2025-10-01 05:55:41', '2025-10-01 08:40:14', '2025-10-01 08:40:14'),
(35, 19, 'Sales Manager', '2025-10-01 05:56:00', '2025-10-01 08:40:16', '2025-10-01 08:40:16'),
(36, 19, 'Tele caller (with experience)', '2025-10-01 05:56:36', '2025-10-01 08:40:19', '2025-10-01 08:40:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonial`
--

CREATE TABLE `tbl_testimonial` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_testimonial`
--

INSERT INTO `tbl_testimonial` (`id`, `username`, `designation`, `description`, `profile_img`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Software Developer', 'ived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\r\nIt was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently\r\nwith desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nExperience', '1755514819_68a307c398f49.png', 1, '2025-08-18 11:00:19', '2025-08-18 11:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_experience`
--

CREATE TABLE `tbl_work_experience` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `work_type_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) NOT NULL,
  `working_status` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `job_type_id` bigint(20) UNSIGNED NOT NULL,
  `role_responsibility` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_work_experience`
--

INSERT INTO `tbl_work_experience` (`id`, `title`, `work_type_id`, `user_id`, `company`, `working_status`, `start_date`, `end_date`, `location`, `job_type_id`, `role_responsibility`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Account superviesor', 7, 41, 'navkar Pvt.ltd.', 0, '2025-08-01', '2025-08-10', 'Ahmedabad', 1, 'Shift vise Supervisor , Electrician ,', '2025-08-15 09:29:02', '2025-08-15 09:41:35', '2025-08-15 09:41:35'),
(2, 'Computer Operator', 1, 41, 'john pvt.ltd.', 0, '2025-07-01', '2025-07-30', 'Ahmedabad', 1, 'Computer Work', '2025-08-15 09:33:50', '2025-08-15 09:33:50', NULL),
(3, 'operator', 1, 41, 'john pvt.ltd.', 1, '2025-08-14', NULL, 'mehsana', 1, 'Stor incharge', '2025-08-15 09:47:05', '2025-08-15 09:47:05', NULL),
(4, 'sdffd', 1, 43, 'I Vision Infotech', 0, '2025-08-18', '2025-08-27', 'Ahmedabad', 2, 'dsfdsdfsd', '2025-08-18 08:53:39', '2025-08-18 08:53:39', NULL),
(5, 'Full Time Driver', 1, 45, 'I Vision Infotech', 1, '2025-08-01', NULL, 'Ahmedabad', 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2025-08-18 10:04:25', '2025-08-18 10:05:08', NULL),
(6, 'COMPUTER OPERTORE', 3, 48, 'PRAMUKH', 1, '2025-08-04', NULL, 'MEHSANA', 1, 'MENEGMENT', '2025-08-19 05:24:30', '2025-08-19 05:24:30', NULL),
(7, 'COMPUTER OPRETER', 3, 49, 'PRAMUKH', 0, '2025-08-05', '2025-09-14', 'MAHESANA', 1, 'A specific job title (e.g., Project Manager, Data Analyst)?', '2025-08-19 06:07:53', '2025-08-19 06:07:53', NULL),
(8, 'COMPUTER OPRETER', 3, 52, 'PRAMUKH', 0, '2025-08-02', '2025-09-10', 'MAHESANA', 1, 'Develop and maintain web-based applications using modern programming languages.\r\n\r\nCollaborate with cross-functional teams to define software requirements.', '2025-08-19 06:26:39', '2025-08-19 06:26:39', NULL),
(9, 'COMPUTER OPRETER', 3, 53, 'PRAMUKH', 0, '2025-08-04', '2025-09-17', 'MAHESANA', 1, 'Your own role and responsibilities in a team or company?', '2025-08-19 06:41:46', '2025-08-19 06:41:46', NULL),
(10, 'computer work', 6, 51, 'Agro', 0, '2025-10-06', '2025-10-12', 'Mahesana', 1, 'manage work', '2025-08-19 06:51:42', '2025-08-19 06:51:42', NULL),
(11, 'COMPUTER OPRETER', 3, 56, 'PRAMUKH', 0, '2025-08-12', '2025-09-29', 'MAHESANA', 1, '[Responsibility 1: Describe a major duty or task]', '2025-08-19 06:51:46', '2025-08-19 06:51:46', NULL),
(12, 'back office', 4, 55, 'gujrat multy pvt.ltd.', 1, '2025-07-18', NULL, 'MEHSANA', 1, 'corproation managment', '2025-08-19 06:52:05', '2025-08-19 06:52:05', NULL),
(13, 'COMPUTER OPRETER', 3, 57, 'PRAMUKH', 0, '2025-08-05', '2025-09-25', 'MAHESANA', 1, 'Design, develop, and maintain efficient, reusable, and reliable code.', '2025-08-19 07:02:07', '2025-08-19 07:02:07', NULL),
(14, 'COMPUTER OPRETER', 3, 58, 'PRAMUKH', 0, '2025-08-11', '2025-09-26', 'MAHESANA', 1, 'Handle customer inquiries via phone, email, or chat.', '2025-08-19 07:12:57', '2025-08-19 07:12:57', NULL),
(15, 'COMPUTER OPRETER', 1, 59, 'PRAMUKH', 0, '2025-08-02', '2025-09-11', 'MAHESANA', 2, 'Write clean, efficient, and well-documented code.', '2025-08-19 07:25:31', '2025-08-19 07:25:31', NULL),
(16, 'Marketing Reprentive', 7, 60, 'online Jwellers', 0, '2024-10-02', '2025-10-04', 'Mahesana', 1, 'Manage time ,work', '2025-08-19 07:28:06', '2025-08-19 07:28:06', NULL),
(17, 'COMPUTER OPRETER', 2, 63, 'PRAMUKH', 0, '2025-08-16', '2025-09-29', 'MAHESANA', 6, 'A definition of \"roles and responsibilities\" in general?', '2025-08-19 08:56:37', '2025-08-19 08:56:37', NULL),
(18, 'COMPUTER OPRETER', 3, 64, 'PRAMUKH', 0, '2025-08-05', '2025-09-13', 'MAHESANA', 1, 'KEEPING ACCURATE RECORDSON MEDICAL TESTS', '2025-08-19 09:07:31', '2025-08-19 09:07:31', NULL),
(19, 'COMPUTER OPRETER', 5, 70, 'PRAMUKH', 0, '2025-08-02', '2025-09-19', 'MAHESANA', 1, 'Analyzed market trends to optimize campaign performance and ROI.', '2025-08-20 04:34:44', '2025-08-20 04:34:44', NULL),
(20, 'COMPUTER OPRETER', 4, 71, 'PRAMUKH', 0, '2025-08-04', '2025-09-20', 'MAHESANA', 3, 'Lead project planning, scheduling, and resource allocation to ensure timely delivery.', '2025-08-20 04:50:07', '2025-08-20 04:50:07', NULL),
(21, 'FERSHER', 6, 72, 'PRAMUKH MANAGEMENT PVT.LTD.', 0, '2025-08-21', '2025-09-13', 'MEHSANA', 3, 'Maintain daily bookkeeping & ledger entries', '2025-08-21 06:41:32', '2025-08-21 06:41:32', NULL),
(22, 'WED DEVLOPER', 4, 74, 'PRAMUKH MANAGEMENT PVT.LTD.', 1, '2025-07-18', NULL, 'MEHSANA', 5, 'Develop responsive and user-friendly websites\r\n\r\nMaintain, update, and optimize existing websites', '2025-08-21 06:55:02', '2025-08-21 06:55:02', NULL),
(23, 'ACCOUNTING', 7, 76, 'PRAMUKH MANAGEMENT PVT.LTD.', 0, '2025-05-23', '2025-12-27', 'MEHSANA', 5, 'DATA OPERATOR', '2025-08-21 07:13:39', '2025-08-21 07:13:39', NULL),
(24, 'QC', 3, 80, 'PRAMUKH MANAGEMENT PVT.LTD.', 0, '2025-08-11', '2025-09-09', 'MEHSANA', 1, 'MANAGEMENT', '2025-08-21 10:15:59', '2025-08-21 10:15:59', NULL),
(25, 'Accounnte', 4, 81, 'COPA', 0, '2025-08-25', '2025-11-25', 'Mahesana', 1, 'account', '2025-08-25 05:21:13', '2025-08-25 05:21:13', NULL),
(26, 'Experience', 7, 83, 'krishna library', 0, '2021-06-15', '2022-04-30', 'Mahesana', 1, 'dat entry operator', '2025-08-26 05:53:23', '2025-08-26 05:53:23', NULL),
(27, 'fresher', 4, 84, 'krishna library', 0, '2025-05-26', '2025-08-26', 'mehsana', 1, 'acctouter', '2025-08-26 06:52:46', '2025-08-26 06:52:46', NULL),
(28, 'hr officer', 4, 85, 'Real cade life sclence private ltd.', 0, '2024-06-12', '2025-06-08', 'kadi', 1, 'HR officer', '2025-08-26 09:39:42', '2025-08-26 09:39:42', NULL),
(29, 'lecturer', 4, 88, 'G.V Acharya college of polytechnic,shelu.', 0, '2025-08-26', '2025-11-08', 'shelu', 1, 'teacher and  lecturer', '2025-08-26 11:49:14', '2025-08-26 11:49:14', NULL),
(30, 'Job experience', 4, 90, 'BVM,Kalol', 0, '2012-10-11', '2017-02-07', 'Kalol', 1, 'Network Design & Implementation', '2025-09-01 09:21:58', '2025-09-01 09:21:58', NULL),
(31, 'FRESHER', 4, 92, 'NO WORKING', 0, '2025-09-05', '2025-09-05', 'MEHSANA', 1, 'ONLINE HOME SERVICE BOOKING', '2025-09-05 06:02:09', '2025-09-05 06:02:09', NULL),
(32, 'B.COM', 4, 95, 'SHAH AND  PATEL ASSOCIATES', 0, '2023-07-05', '2025-03-05', 'MEHSANA', 1, 'GST CONSULTANT', '2025-09-05 06:45:35', '2025-09-05 06:45:35', NULL),
(33, 'DATE ENTRY', 4, 99, 'K.D POLYTECHINC  PATAN', 0, '2024-07-05', '2025-08-05', 'AHEMDABAD', 3, 'DATE ENTRY operator', '2025-09-05 07:10:37', '2025-09-05 07:10:37', NULL),
(34, 'Accounant', 4, 100, 'Laxmi Engineering Pvt. Ltd.', 0, '2020-09-10', '2021-03-06', 'Ahmedabad', 1, 'Accountant', '2025-09-05 09:40:04', '2025-09-05 09:40:04', NULL),
(35, 'FRESHER', 4, 102, 'COPA', 0, '2025-01-05', '2025-09-05', 'AHEMDABAD', 3, 'ACCOUNNTER', '2025-09-05 10:49:42', '2025-09-05 10:49:42', NULL),
(36, 'SELES', 4, 106, 'SHREE HARSIDDHI ENGINEERING', 0, '2012-05-05', '2025-01-05', 'MEHSANA', 1, 'SELES MEN', '2025-09-05 11:43:20', '2025-09-05 11:43:20', NULL),
(37, 'REQUERMENT AND SELECTION PROCESS FOR HONDA ACTIVA', 7, 107, 'HONDA', 0, '2021-01-02', '2022-01-02', 'BANSKANTHA', 1, 'PROJECTER', '2025-09-05 11:56:36', '2025-09-05 11:56:36', NULL),
(38, 'BECOMING SALES OFFICER', 4, 108, 'G.V Acharya college of polytechnic', 0, '2024-08-05', '2025-05-05', 'MEHSANA', 3, 'BECOMING SALES', '2025-09-05 12:04:50', '2025-09-05 12:04:50', NULL),
(39, 'MECHANICAL  ENGINEER', 4, 110, 'JTEKT  ENGINEER', 0, '2020-02-06', '2022-03-06', 'AHEMDABAD', 1, 'PRODUCTION ENGINEER', '2025-09-06 09:00:28', '2025-09-06 09:00:28', NULL),
(40, 'FRESHER', 4, 111, 'online Jwellers', 0, '2025-08-06', '2025-09-06', 'MEHSANA', 2, 'SALES MEN', '2025-09-06 09:29:55', '2025-09-06 09:29:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_type`
--

CREATE TABLE `tbl_work_type` (
  `work_type_id` bigint(20) UNSIGNED NOT NULL,
  `type_nm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_work_type`
--

INSERT INTO `tbl_work_type` (`work_type_id`, `type_nm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'On-site', '2025-07-30 23:53:27', '2025-07-30 23:53:27', NULL),
(2, 'Hybrid', '2025-07-30 23:53:33', '2025-07-30 23:53:33', NULL),
(3, 'Remote', '2025-07-30 23:53:38', '2025-07-30 23:53:38', NULL),
(4, 'Field Work', '2025-07-30 23:53:44', '2025-07-30 23:53:44', NULL),
(5, 'Shift-Based', '2025-07-30 23:53:49', '2025-07-30 23:53:49', NULL),
(6, 'Work From Home', '2025-07-30 23:53:53', '2025-07-30 23:53:53', NULL),
(7, 'Flexible Hours', '2025-07-30 23:54:00', '2025-07-30 23:54:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zipcode`
--

CREATE TABLE `tbl_zipcode` (
  `zipcode_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_zipcode`
--

INSERT INTO `tbl_zipcode` (`zipcode_id`, `state_id`, `city_id`, `area_id`, `zipcode`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 6, 19, '307001', '2025-08-18 09:50:06', '2025-08-18 09:50:06', NULL),
(2, 5, 6, 20, '307001', '2025-08-18 09:51:46', '2025-08-18 09:51:46', NULL),
(3, 6, 7, 21, '384001', '2025-08-19 05:11:19', '2025-08-19 05:11:19', NULL),
(4, 6, 7, 21, '384002', '2025-08-19 05:22:46', '2025-08-19 05:22:46', NULL),
(5, 6, 8, 22, '38400', '2025-08-19 05:51:21', '2025-08-19 05:51:21', NULL),
(6, 6, 9, 23, '384260', '2025-08-19 06:17:16', '2025-08-19 06:17:16', NULL),
(7, 6, 8, 22, '384001', '2025-08-19 06:21:16', '2025-08-19 06:21:16', NULL),
(8, 6, 8, 24, '384315', '2025-08-19 07:08:56', '2025-08-19 07:08:56', NULL),
(9, 7, 10, 25, '384265', '2025-08-19 08:39:16', '2025-08-19 08:39:16', NULL),
(10, 8, 11, 26, '283870', '2025-08-19 08:53:05', '2025-08-19 08:53:05', NULL),
(11, 6, 12, 27, '384440', '2025-08-19 09:05:28', '2025-08-19 09:05:28', NULL),
(12, 6, 7, 28, '384002', '2025-08-19 09:28:50', '2025-08-19 09:28:50', NULL),
(13, 10, 14, 29, '384225', '2025-08-21 07:01:41', '2025-08-21 07:01:41', NULL),
(14, 11, 15, 30, '384220', '2025-08-21 09:33:52', '2025-08-21 09:33:52', NULL),
(15, 6, 7, 31, '384001', '2025-08-25 04:37:55', '2025-08-25 04:37:55', NULL),
(16, 12, 16, 32, '384001', '2025-08-25 06:45:59', '2025-08-25 06:45:59', NULL),
(17, 13, 17, 33, '384212', '2025-08-26 05:11:41', '2025-08-26 05:11:41', NULL),
(18, 7, 18, 34, '385340', '2025-08-26 06:40:05', '2025-08-26 06:40:05', NULL),
(19, 6, 7, 35, '384002', '2025-08-26 09:13:24', '2025-08-26 09:13:24', NULL),
(20, 7, 19, 36, '384170', '2025-08-26 10:00:44', '2025-08-26 10:00:44', NULL),
(21, 7, 20, 37, '384160', '2025-08-26 10:30:01', '2025-08-26 10:30:01', NULL),
(22, 6, 7, 38, '384002', '2025-08-26 11:41:02', '2025-08-26 11:41:02', NULL),
(23, 14, 21, 39, '382721', '2025-09-01 07:00:50', '2025-09-01 07:00:50', NULL),
(24, 6, 22, 40, '382220', '2025-09-01 10:03:38', '2025-09-01 10:03:38', NULL),
(25, 6, 7, 41, '384002', '2025-09-05 05:47:57', '2025-09-05 05:47:57', NULL),
(26, 7, 10, 42, '384265', '2025-09-05 05:52:02', '2025-09-05 05:52:02', NULL),
(27, 15, 23, 43, '380015', '2025-09-05 06:01:40', '2025-09-05 06:01:40', NULL),
(28, 7, 25, 45, '382730', '2025-09-05 06:36:34', '2025-09-05 06:36:34', NULL),
(29, 7, 26, 46, '384120', '2025-09-05 06:51:54', '2025-09-05 06:51:54', NULL),
(30, 6, 7, 47, '384001', '2025-09-05 06:56:28', '2025-09-05 06:56:28', NULL),
(31, 7, 27, 48, '384151', '2025-09-05 07:24:21', '2025-09-05 07:24:21', NULL),
(32, 7, 28, 49, '382820', '2025-09-05 09:23:18', '2025-09-05 09:23:18', NULL),
(33, 7, 25, 50, '382711', '2025-09-05 10:22:02', '2025-09-05 10:22:02', NULL),
(34, 7, 30, 51, '384275', '2025-09-05 11:15:47', '2025-09-05 11:15:47', NULL),
(35, 7, 32, 52, '385575', '2025-09-05 11:29:16', '2025-09-05 11:29:16', NULL),
(36, 7, 10, 53, '384265', '2025-09-05 11:56:33', '2025-09-05 11:56:33', NULL),
(37, 7, 33, 54, '384005', '2025-09-06 09:19:41', '2025-09-06 09:19:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_demos`
--

CREATE TABLE `test_demos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `active_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `city_id` varchar(255) DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` varchar(255) DEFAULT NULL,
  `zipcode_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'User',
  `experience` varchar(255) DEFAULT NULL,
  `expected_salary` varchar(255) DEFAULT NULL,
  `languages` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `skills_id` text DEFAULT NULL,
  `company_desc` text DEFAULT NULL,
  `about` text DEFAULT NULL,
  `preference_type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '1: Skill 2: Non-Skill',
  `verify_status` tinyint(4) NOT NULL DEFAULT 0,
  `profile_type` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `resume_nm` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `personal_name` varchar(255) DEFAULT NULL,
  `contact_person_nm` varchar(255) DEFAULT NULL,
  `contact_person_phone_no` varchar(255) DEFAULT NULL,
  `average_salary` varchar(255) DEFAULT NULL,
  `company_size` varchar(255) DEFAULT NULL,
  `company_since` varchar(255) DEFAULT NULL,
  `personal_website` varchar(255) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `cover_img` varchar(255) DEFAULT NULL,
  `profile_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `active_plan_id`, `name`, `email`, `contact_no`, `city_id`, `area_id`, `state_id`, `zipcode_id`, `password`, `otp`, `address`, `role`, `experience`, `expected_salary`, `languages`, `category_id`, `sub_category_id`, `skills_id`, `company_desc`, `about`, `preference_type`, `verify_status`, `profile_type`, `designation`, `active_status`, `remember_token`, `resume_nm`, `created_at`, `updated_at`, `deleted_at`, `personal_name`, `contact_person_nm`, `contact_person_phone_no`, `average_salary`, `company_size`, `company_since`, `personal_website`, `profile_img`, `cover_img`, `profile_status`) VALUES
(1, 0, 'iv', 'superadmin@gmail.com', '7296930519', '1', NULL, '1', '1', '$2y$10$1d4gD1FxGijNe/sUygGw9.9VsHDOp4NsTYup5E0PfLwSwOe0xpkp2', '716804', 'thakurji gali', 'Admin', NULL, NULL, NULL, 1, 1, '[\"\"]', 'demodemodemodemodemodemodemodemodemodemodemodemodemodemodemo', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, '2025-07-14 03:58:21', '2025-08-02 00:16:04', NULL, 'Pinal Patel', 'Ronak Patel', '8978675645', '2K-3K', '12', '2012', NULL, NULL, NULL, 0),
(40, 8, 'jigar', 'jigar@gmail.com', '9988776655', '4', 17, '1', '0', '$2y$10$9E9XA5odwhQY5NHwE/rYa.ERzn2a5RaC6ZC4GYqzN2oR7zJbAxxA.', '786894', 'Akeshan fatak', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 2, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-15 09:02:34', '2025-09-29 10:54:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(41, 8, 'Vipul patel', 'vipul@gmail.com', '9988776646', '5', 18, '4', '0', '$2y$10$f2qdlFaAvar9vgQZEmFdOuhXzAeBL2m.3KVr8pPGTSoa4HXLgFqjO', '332546', 'pramukh management', 'User', '1 Year', '20000', '[\"\"]', 2, 5, '[\"Tally ERP\",\"Tally Prime\"]', NULL, 'Write Here..', 2, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-15 09:10:42', '2025-09-29 10:54:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(42, 8, 'Khushi Patel', 'zobpot.1@gmail.com', '6357024500', '5', 18, '4', '0', '$2y$10$Tvx0grOcEbGFnZEwn87qsecsWwxR9XjMe8/OqDBjMsorqfY3X42NC', '788333', 'Mehsana', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 2, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-15 10:57:17', '2025-09-29 11:41:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(43, 8, 'Mukesh Suthar', 'mukeshsthr690@gmail.com', '7296930530', '2', 9, '2', '3', '$2y$10$doVccfRfFCOxX3SnSqQvZ.Gy15YRBP/P8fVaShfYGOMqmnmHnxFCW', '967202', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', 'User', '12', '12', '[\"English\",\"Hindi\"]', 1, 1, '[\"HTML5\",\"CSS3\"]', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-18 06:44:42', '2025-08-18 09:25:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(44, 7, 'Global Tech', 'globaltech@gmail.com', '8978675645', '2', 9, '2', '3', '$2y$10$G6YlPcZGcOjr.M/qgu.JVuv1rkeJF4g.I.9ZSAd4NPmKsLHxilOgG', '502231', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', 'User', NULL, NULL, NULL, 1, 1, '[\"\"]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', NULL, NULL, 1, 'Company', 'IT Company', 1, NULL, NULL, '2025-08-18 06:50:22', '2025-08-21 06:36:00', NULL, 'Rakesh Sharma', 'Dhawal Thakor', '7867564534', '100K-150K', '15', '2012', NULL, '1755499951_68a2cdafabafe.jpg', '1755499884_68a2cd6c8c1e1.jpg', 1),
(45, 0, 'Ganesh Shah', 'ganesh@gmail.com', '7867564567', '6', 20, '5', '1', '$2y$10$UFX4j.LO0bMCjqj8j4FivuRFtIo0QoTEnUePzcB4L3pXhWO.wG3s6', '682483', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', 'User', NULL, NULL, '[\"English\",\"Hindi\"]', 13, 13, '[\"Responsiblity\",\"Transport Management\"]', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 2, 1, 'Employee', 'Truck Driver', 1, NULL, NULL, '2025-08-18 09:51:46', '2025-09-29 11:41:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1755511771_68a2fbdbdf305.jpg', '1755511772_68a2fbdc941cb.jpg', 1),
(46, 5, 'Zobpot', 'zobpot@gmail.com', '7867561234', '6', 20, '5', '1', '$2y$10$N640Q87esaC.zC/dnjATIubU20xOOApU38Iu0cpbHjaIYJx4jTscm', '271424', 'S Cube, T-332, Radhanpur Rd, opp. Bansari Township, Kunal, Mehsana, Gujarat 384002', 'User', NULL, NULL, NULL, 13, 13, '[\"\"]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, 1, 'Company', NULL, 1, NULL, NULL, '2025-08-18 10:15:17', '2025-09-29 11:42:46', NULL, 'Rakesh Sharma', 'Dhawal Thakor', '7867564534', NULL, '10', '2012', NULL, 'profile.png', NULL, 1),
(48, 8, 'KHUSHBU PATEL', 'ap4065981@gmail.com', '6353973478', '7', 21, '6', '3', '$2y$10$LfgDSUro3s3FZI7bgRHsz.CYc2m75NCjGURTA32ziMs/1lbiMAnzq', '840026', 'ORADAVAS,VIRTA,VIRTA,MEHSANA ,GUJARAT 384001', 'User', '1 YEAR', '15000', '[\"\"]', 2, 5, '[\"Tally ERP\"]', NULL, 'I AM HARDWORKING AND CREATIVE INDIVIDUAL WITH', 2, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-19 05:11:19', '2025-08-21 05:33:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(49, 8, 'KHUSHBU PATEL', 'zobpot.3@gmail.com', '6357024700', '7', 21, '6', '4', '$2y$10$dFFcnPaeOd7pWCwZSRbzuOIvUAk5UAvhRxTzAdyW8fpN4A8qM.0um', '892702', 'ORDAVAS,VIRTA,GUJRAT 384002', 'User', '1YEAR', '12000', '[\"\"]', 2, 5, '[\"Accounting Software\"]', NULL, 'GOOD COMMUNICATION SKILL   \r\nHARD WORKING', 2, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-19 05:47:21', '2025-08-21 05:33:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(50, 8, 'Mittal raval', 'Zobpot.4@gmail.com', '6357024800', '8', 22, '6', '7', '$2y$10$/5fMbUCbow8YiVTaRjlsyOxOtjXJW.TWk/74BDJYDWXvHeeaeDzHq', '384655', 'Mahesana , Radhnpur road', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 2, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-19 05:51:21', '2025-08-21 05:33:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(51, 8, 'Mittal Raval', 'Zobpot.5@gmail.com', '6357024900', '9', 23, '6', '6', '$2y$10$PCGFVWM//bLjgZjKpnY1quBkUnd4flyrq/qmB.6wAbhXUpvyDnOh2', '614006', 'sidhpur chokdi , patan', 'User', '6 month', '10000', '[\"\"]', 3, 11, '[\"Demo\"]', NULL, 'Hard work , team work , good communication.', 2, 1, 'Employee', 'Sales Reprentive', 1, NULL, NULL, '2025-08-19 06:17:16', '2025-08-19 08:43:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(52, 8, 'VIDHI PATEL', 'vidhipatel771@gmail.com', '9104416606', '7', 21, '6', '4', '$2y$10$h7TlYaANcwtoluXUSv6ciOjxrUHSnm1jO4RfO22HrOmKBZlKQUJa6', '767371', '10,SATYAM BUNGLOWS, B/H. OLDDHARAM CINEMA, MEHSANA 384002, GUJARAT', 'User', '2YEARS', '20000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'COMPLETE KNOWLEDGE OF ACCOUNTING\r\nTEAM WORK', 2, 1, 'Employee', 'Something related to military, government, or legal contexts?', 1, NULL, NULL, '2025-08-19 06:19:09', '2025-08-21 05:33:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(53, 8, 'PRIYANKA MANGALANI', 'priyankamangalani@gmail.com', '9974532702', '7', 21, '6', '3', '$2y$10$Ltc0Igf.2m.ytVr3jn/2luQrl2R9TKK5CB6NmhQR6famvLHzUFI4q', '585462', '11, LAKHVADIBHAGOL, POLICELINE, BHOYRAVAS, MEHSANA DIST.,MEHSANA-384001, GUJARAT-INDIA.', 'User', '1YEAR', '15000', '[\"\"]', 2, 5, '[\"Tax Filing Portals\"]', NULL, 'bout a person, place, or thing?', 2, 1, 'Employee', 'Something related to military, government, or legal contexts?', 1, NULL, NULL, '2025-08-19 06:37:03', '2025-08-21 05:33:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(54, 5, 'NAVKAR TRANSCORE PVTLTD', 'zobpot.2@gmail.com', '9737405510', '7', 21, '6', '4', '$2y$10$W6yCyKBaN2xKid8g8YfHHuZCWPV1K23jA4Uy.uokI6iVdK7pexsS6', '912102', 'Mehsana', 'User', NULL, NULL, NULL, 1, 1, '[\"GitHub\"]', 'This Sawn Soma, empower your business growth with expert guidance from ZOBPOT, your trusted consultant. 🛍️', 'Hi! Your Vi bill of Rs.1653.18 is due on 2-Jul-25. Please pay by the due date to avoid late payment charges. Never miss a due date. Make payment through Vi App and set UPI autopay with a single click', NULL, 1, 'Company', 'web developer', 1, NULL, NULL, '2025-08-19 06:40:14', '2025-08-22 06:47:18', NULL, 'Krishna Patel', 'vipul patel', '9016303444', '20000', '10', '20', NULL, 'profile.png', NULL, 1),
(55, 9, 'Kuntal parmar', 'parmarkuntal11@gmail.com', '9601912313', '7', 21, '6', '3', '$2y$10$EgbmXIQbejBGAGOnmPz2UOUm7MY003ahIS78h4c30XDTXQG5NkXvG', '263608', '1 gajanand society, somnath road opp. sidharth vidhyalaya school mehsana-384001 gujarat', 'User', '1 YEAR', '15000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'good computer skill', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-19 06:47:17', '2025-08-19 08:43:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(56, 8, 'RESHMA SENMA', 'reshmasenma1810@gmail.com', '9638484658', '7', 21, '6', '3', '$2y$10$iS/mwaYY1tl9uqU.8b7YuuiAkpvBzbUD0IZZ6H9OIEXwC6y37gTy.', '833520', 'DIPARA DARWAJA NEAR WATER TANK', 'User', '3YEARS', '25000', '[\"\"]', 2, 5, '[\"Accounting Software\"]', NULL, 'GOOD COMMUNICATION\r\nMS OFFICE', 2, 1, 'Employee', 'Something related to military, government, or legal contexts?', 1, 'HD69PJ7vK0KGRBCXzgXjxJckqvEqEAvAbs7PRk6fH1fv5Hm6wlhVM3ESlPPa', NULL, '2025-08-19 06:47:58', '2025-09-05 12:03:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(57, 8, 'DHARA SOLANKI', 'dharapsolanki5@gmail.com', '9974775574', '7', 21, '6', '3', '$2y$10$vaBRnqQi731YDWqHNu8JNuKVPX7t4cSKqmE4N6Px7fTG/h4Y8wsvS', '188544', '5, AMRAPALI SOCIETY, VISHNAGAR LINK ROAD, MEHSANA, GUJRAT.', 'User', '1YEAR', '17000', '[\"\"]', 2, 5, '[\"Tax Filing Portals\"]', NULL, 'GOOD COMMUNICATION\r\nMS WORD', 2, 1, 'Employee', 'Something related to military, government, or legal contexts?', 1, NULL, NULL, '2025-08-19 06:58:20', '2025-08-19 08:44:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(58, 8, 'HIRAL PARMAR', 'parmarhiral08@gmail.com', '9106680057', '8', 24, '6', '8', '$2y$10$3JzE03uVHEVvqhmzAy3Wnuwu8jGANky/kqkYlhV52LPa2ax7sR8hW', '146591', '12/BALAJINAGAR SOCIETY OPP GURUKUL SCHOOL KANSA N.A. AREA VISNAGAR TA-VISNAGAR DI-MEHSANA PIN-384315', 'User', '2YEARS', '20000', '[\"\"]', 2, 5, '[\"Tally ERP\"]', NULL, 'GOOD COMMUNICATION\r\nMS WORD', 1, 1, 'Employee', 'Project Manager', 1, NULL, NULL, '2025-08-19 07:08:57', '2025-09-30 07:29:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 2),
(59, 8, 'JUHI VERJANI', 'juhiverjani89@gmail.com', '9024533507', '7', 21, '6', '3', '$2y$10$5z9xq1UgvuryXEqJqNuZVux7Bgcct9jIqai8xQ60RIy91bjV.Nxpu', '418313', '22, KARUNA BUNGLOWS, BEHIND JANPATH HOTEL, NEAR ONGC CIRCLE, MEHSANA-384003 GUJARAT', 'User', '1YEAR', '12000', '[\"\"]', 2, 5, '[\"Tax Filing Portals\"]', NULL, 'MS WORD \r\nPOWER POINT', 2, 1, 'Employee', 'Project Manager', 1, NULL, NULL, '2025-08-19 07:21:11', '2025-08-19 08:44:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(60, 8, 'Krisha Prajapati', 'krishu1022@gmail.com', '9426782867', '9', 23, '6', '6', '$2y$10$J8I/nhHmwC0IAzVmPesT5u3DUrtFAHbyoYu1PmbGauKT4S1ni5OF2', '999781', 'sidhpur chokdi , patan', 'User', '1 year', '15000', '[\"\"]', 3, 11, '[\"Demo\"]', NULL, 'online ordering system', 1, 1, 'Employee', 'Marketing Representive', 1, NULL, NULL, '2025-08-19 07:21:18', '2025-08-19 08:44:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(61, 5, 'ORIENS IMMIGRATION', 'hrm.pramukhmanagement@gmail.com', '6357024600', '7', 21, '6', '4', '$2y$10$MJUB5QUj.lHeGFqeuxY5WORjl7g1ONaQeqkDYUhElHbNIui6dYaou', '770794', 'MEHSANA', 'User', NULL, NULL, NULL, 1, 1, '[\"\"]', 'SOFTWER ENGINEERING', NULL, NULL, 1, 'Company', 'Fresher', 1, NULL, NULL, '2025-08-19 07:32:27', '2025-08-19 08:43:19', NULL, 'VIPUL PATEL', 'HAPPY PATEL', '9327643612', '20000', '10', '5', NULL, 'profile.png', NULL, 1),
(62, 8, 'Rinkal Patel', 'rinkal7001@gmail.com', '7203813637', '10', 25, '7', '9', '$2y$10$agqX6utRXbhtAP12nVEOKu4ZsOES9xIqj1aD99iow0qW4ryYAG0vi', '246712', 'Padamnath chokdi', 'User', NULL, NULL, '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'Accounting Work', 1, 1, 'Employee', 'Accounter', 1, NULL, NULL, '2025-08-19 08:39:16', '2025-08-19 08:43:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(63, 8, 'PRAKASH PATEL', 'patelpk144@gmail.com', '7698400558', '11', 26, '8', '10', '$2y$10$tEJxKnieHdURM1LZaqkOc.jfJpcFDxiLYcPkugHbnRgVUiHfjkdj.', '873718', 'AT-HASANPUR, TA-VIJAPUR, DI-MEHSANA, PIN-283870', 'User', '2YEARS', '21000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'GOOD COMMUNICATION\r\nMA WORD', 2, 1, 'Employee', 'Project Manager', 1, NULL, NULL, '2025-08-19 08:53:05', '2025-08-19 09:06:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(64, 8, 'SNEHA PATEL', 'patelsneha375@gmail.com', '7202920730', '7', 21, '6', '4', '$2y$10$j3Dpoyc6d5hEkaL5jrldd.uMnBqiCDKEsWlQMg1cIvcE86fFydOBS', '833178', '2, SATYAM BUNGLOWS, OPP-MAAN PHARMA, MODHERA ROAD, MEHSANA', 'User', '1YEAR', '14000', '[\"\"]', 2, 5, '[\"Accounting Software\"]', NULL, 'POWER POINT\r\nMS WORD', 1, 1, 'Employee', 'Something related to military, government, or legal contexts?', 1, NULL, NULL, '2025-08-19 09:02:25', '2025-08-19 12:07:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(65, 8, 'Sakshi patel', 'zobpot.6@gmail.com', '9909787444', '7', 21, '6', '4', '$2y$10$sP8JH.60aKVGKNky/FtP8uCWYj68egZDhnqTjCJchtpVHHSxzDvN6', '270621', 'Mehsana', 'User', NULL, NULL, NULL, 2, 5, '[\"Tally ERP\",\"Tally Prime\",\"QuickBooks\",\"MS Excel\",\"Accounting Software\"]', NULL, 'Account', 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-19 09:03:38', '2025-09-29 10:53:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(66, 7, 'CONSTA COOL PVT LTD', 'constacool@gmail.com', '8511102229', '12', 27, '6', '11', '$2y$10$C57gWdi8PrTZah699HsGguSdPh1K2GXLz/LtsXlvWWSkztz7UlUMy', '844175', 'mehsana ,ahmedabad highway', 'User', NULL, NULL, NULL, 3, 9, '[\"\"]', 'marketing executive, sales marketing', NULL, NULL, 1, 'Company', 'sales marketing', 1, NULL, NULL, '2025-08-19 09:05:28', '2025-08-19 12:08:25', NULL, 'mohit varma', 'ankit soni', '8511102229', '25000', '15', '5', NULL, 'profile.png', NULL, 1),
(67, 5, 'pratham tradelink', 'savanp951@gmail.com', '9106993518', '7', 28, '6', '4', '$2y$10$yQJoPxGrytGd35f4kMJzaOahCD/BFj7Ft6kd5P1ICdGeEDSaCfF1S', '576526', 'mehsana', 'User', NULL, NULL, NULL, 3, 12, '[\"\"]', NULL, NULL, NULL, 1, 'Company', NULL, 1, NULL, NULL, '2025-08-19 09:28:50', '2025-08-19 12:08:29', NULL, 'savan patel', 'savan patel', '9106993518', '15000/-', '10', '2020', NULL, 'profile.png', NULL, 1),
(69, 9, 'PRAVIN RAVAL', 'pravinraval1980@gmail.com', '9624968950', '7', 21, '6', '3', '$2y$10$pXERl0c30pVoVjtUWbD2le5RAv37RaAZkYoc6PgXDNfrGHdlyJup6', '198960', 'TALETI,MEHSANA 384001', 'User', NULL, NULL, NULL, 3, 11, '[\"Demo\"]', NULL, 'INDUSTRY MEETUPS, MANAGING YOUR EMOTION IN SOCIAL OR PROFESSIONAL SITUATION', 1, 1, 'Employee', 'sales marketing', 1, NULL, NULL, '2025-08-19 11:27:15', '2025-09-29 10:54:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(70, 8, 'VIKASH PRAJAPATI', 'vikashprajapati272@gmail.com', '7624004686', '7', 21, '7', '4', '$2y$10$VL1RUo/AJJi6VO5.OC2BQOPuqcLjJ4uniGblEeuVQ/Rvvb/pJQBW6', '257720', 'NAGRAJ SOCIETY, NR. KKALAPI NAGAR, RADHANPUR ROAD, MEHSANA (GUJRAT)', 'User', '1YEAR', '12000', '[\"\"]', 2, 5, '[\"Tax Filing Portals\"]', NULL, '\"About\" section for a resume – Want help writing a summary or professional bio?', 2, 1, 'Employee', 'Project Manager', 1, NULL, NULL, '2025-08-20 04:29:42', '2025-08-20 11:29:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(71, 8, 'DIYA PATEL', 'diyapatel812@gmail.com', '9714882354', '7', 21, '6', '3', '$2y$10$XKlPDtiyY96CwigV04eEU.wvDnqj5BC0/aPluGDMWupbZSjZy5966', '336397', 'ORDAVAS, VIRTA DI-MAHESANA, GUJRAT', 'User', '2YEARS', '20000', '[\"\"]', 2, 5, '[\"Tally Prime\",\"Tax Filing Portals\"]', NULL, 'MS WORD\r\nPOWER POINT', 1, 1, 'Employee', 'Project Manager', 1, NULL, NULL, '2025-08-20 04:43:16', '2025-08-20 11:29:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(72, 8, 'NIKITA PRAJAPATI', 'nikitaprajapati1412@gmail.com', '6351973697', '7', 21, '6', '4', '$2y$10$u7ETDkF4JKXXyj8rWOJSNuqr2ja8QhDpNpRwGKlIOvABBFBWMS4/W', '207893', 'MEHSANA, GUJARAT', 'User', 'FRESHER', '15000', '[\"\"]', 2, 7, '[\"GOOG COMPUTER SKILL\"]', NULL, 'GOOD  COMUNICATION SKILL,GOOD COMPUTER SKILL', 2, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-21 05:40:12', '2025-08-21 09:11:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(73, 7, 'AYUSHI PHARMA', 'ayushi@gmail.com', '9624402348', '7', 21, '6', '4', '$2y$10$YUltSmKrN0mTrH/pgRrciu1HUOKhVAFEmiPTZ.VYA/hlLIVWKokcS', '360463', 'Chhatral', 'User', NULL, NULL, NULL, 2, 5, '[\"\"]', 'Accountant tally ERP sap', NULL, NULL, 1, 'Company', 'Expiriance', 1, NULL, NULL, '2025-08-21 06:44:39', '2025-08-21 07:19:14', NULL, 'gopal bhai', 'rakesh sir', '9624402348', '20000', '10', '2004', NULL, 'profile.png', NULL, 1),
(74, 8, 'JAIMINI SENMA', 'jaiminiraval@gmail.com', '9624402850', '13', 22, '9', '3', '$2y$10$6eZDCtA33CH4Vzo9u27HCeKHdI1v5XT6T89b9tDBUu8eO0DhJ1TEe', '772554', 'LAKHVADIBHAGOL,POLICELINE,BHOYRAVAS,MEHSANA DIST: MEHSANA-384001 GUJARAT INDIA', 'User', '1 YEAR', '250000', '[\"\"]', 1, 1, '[\"Bootstrap\"]', NULL, 'DATA ANALYTICS', 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-21 06:51:31', '2025-08-21 09:16:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(75, 5, 'Amol Menachem', 'amol@gmail.com', '8141439898', '7', 21, '6', '4', '$2y$10$RK80G3GCPDDoIINcw3rPQ.8J8eINWEM65A/MBULmPirMWNJo6I4c2', '654113', 'kadi', 'User', NULL, NULL, NULL, 3, 9, '[\"\"]', 'marketing sales executive', NULL, NULL, 1, 'Company', 'marketing', 1, NULL, NULL, '2025-08-21 06:54:20', '2025-08-21 07:19:19', NULL, 'harshit sir', 'harshit sir', '8141439898', '20000', '10', '2004', NULL, 'profile.png', NULL, 1),
(76, 9, 'PRIYANKA SUTHAR', 'pancholipriyanka778@gmail.com', '8780497681', '14', 29, '10', '13', '$2y$10$.m3.X2Jn0ViSMTvk.b.UdO.EAhSvaLrwGw6wiyvPgrKV7F3.qYwc6', '634883', 'D/O: VASDEV,DHINOJ,DHINOJ,PATEN,GUJARAT,384225', 'User', '1 years', '25000', '[\"\"]', 2, 6, '[\"accounting\"]', NULL, 'I Have been 1 years in laxmi stock advisor as tally coller and computer opretore', 2, 1, 'Employee', 'TALLT COLLER', 1, NULL, 'resumes/priyanka-suthar_68a70f5a10e45_resume.pdf', '2025-08-21 07:01:41', '2025-08-21 12:21:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(77, 5, 'anmol aggrotech industries', 'amol.1@gmail.com', '9099963456', '7', 21, '6', '3', '$2y$10$5XY5QLUVvdmZAirolsoO8uFBx8wSKG98uZvDSijIk85QwSRax0OwG', '811741', 'Mehsana', 'User', NULL, NULL, NULL, 1, 3, '[\"\"]', 'Driver', NULL, NULL, 1, 'Company', 'Driver', 1, NULL, NULL, '2025-08-21 07:02:45', '2025-08-21 07:19:24', NULL, 'rajan patel', 'rajan patel', '9099963456', '20000', '10', '2004', NULL, 'profile.png', NULL, 1),
(78, 6, 'Consta Cool pvtltd', 'consta@gmail.com', '8511110222', '6', 19, '5', '1', '$2y$10$G5NYBNFIY52uBy1Lmc3E2.pIMi66Hkyvih7POSSgY5mm/Yfuodyba', '585273', 'Chhatral', 'User', NULL, NULL, NULL, 3, 12, '[\"\"]', 'Sales Marketing', NULL, NULL, 1, 'Company', 'web developer', 1, NULL, NULL, '2025-08-21 07:11:30', '2025-08-21 07:19:28', NULL, 'Ankit soni', 'Ankit soni', '8511102229', '20000', '10', '2004', NULL, 'profile.png', NULL, 1),
(79, 8, 'KAJAL PATEL', 'kp9924210736@gmail.com', '8155862008', '7', 21, '6', '3', '$2y$10$OTDw.wWr.P6.g6Q3TUo3v.gcCi0Qcf0YwU9bRbLnHNF/PJVSJGUoO', '835328', 'mehsana gurat', 'User', '2 YEARS', '25000', '[\"\"]', 2, 7, '[\"Salary Calculations\"]', NULL, 'Manage GST, TDS & tax filings', 1, 1, 'Employee', 'salary calculations', 1, NULL, NULL, '2025-08-21 07:19:27', '2025-08-21 09:17:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(80, 10, 'JIMMI PATEL', 'jimmipatel@gmail.com', '7284926109', '15', 30, '11', '14', '$2y$10$fa9BifHYZqnLbEGpQZll7OONnZWz1BPDuaHF9ni2WtttOr4rs1kNa', '505624', 'MANIYARI PARA, PATAN GUJARAT,384220', 'User', 'FRESHER', '15000', '[\"\"]', 1, 3, '[\"NETWORK SKILL\"]', NULL, 'DIPATMENT MANAGEMENT', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-21 09:33:53', '2025-08-21 10:17:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(81, 8, 'Kumbhar Aradhana', 'aradhanap209@gmail.com', '7698650209', '7', 31, '6', '3', '$2y$10$yUn/4RqDNcAhDP6k6P5u6eP5h84mcJuivI0PUb56/PUggCh8zSKUK', '260319', '7/b Narayan nagar socitey ,near tahuko  party polt, modhera ,mehasana', 'User', '3 years', '10000', '[\"\"]', 1, 1, '[\"marking\"]', NULL, 'Accounnting', 1, 1, 'Employee', 'Accounter', 1, NULL, NULL, '2025-08-25 04:37:55', '2025-08-25 04:58:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(82, 8, 'Anjali Panchal', 'rajpalanjali92@gmail.com', '8511081936', '16', 32, '12', '3', '$2y$10$oNft1jQeZo0VKhXnrAu3le8zgik2/u2q.0F8ipDeIch5VCW2aFoza', '997710', 'C-44,Balaji Residency Visnagar Link road', 'User', NULL, NULL, NULL, 3, 11, '[\"Demo\"]', NULL, 'I Am working from sales marketing', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-25 06:45:59', '2025-08-25 06:46:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(83, 8, 'Mausami s patal', 'patalmausami268@gmail.com', '9737179237', '17', 33, '13', '17', '$2y$10$Irhy.jMrY5xcdSEC8Z/dMejCNM8.hYrCA9DsaI1M2jwQd7GNcqllC', '429809', 'Motamadha  At-motap, Ta-Bechraji, Dist-Mehsana', 'User', NULL, NULL, NULL, 3, 9, '[\"\"]', NULL, 'I hereby declare that the above mentioned information  is true to the best of my knowledge .', 1, 1, 'Employee', 'Exprience', 1, NULL, NULL, '2025-08-26 05:11:41', '2025-08-26 05:58:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(84, 8, 'patel vidhi dineshbhai', 'vidhip408@gmail.com', '9327008143', '18', 34, '7', '18', '$2y$10$NKSaCLesqmLOq/zgQax0KeHqibTyWfFDZlJAe1tz1ZMGtv3/KdDRK', '761570', 'Sainath Residency Radhanpur', 'User', 'fresher', '8000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'I am a committed and hardworking person .I am a self motivated parson and I learn from My experiences.', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-26 06:40:05', '2025-08-26 06:56:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(85, 8, 'prajapati mihigna arvinbhai', 'mihignaoza@gmail.com', '7984156458', '7', 35, '6', '4', '$2y$10$1EEWgZrrGuGURpN.2IUOLOr8tcyIiDxq9U0OekK/99Y.Pde7R9sGy', '250882', 'Post- punashan, Dist - Mehsana  near primary school', 'User', '1 year', '15000', '[\"\"]', 5, 1, '[\"JavaScript\"]', NULL, 'Do hereby declare that the particulars of information and facts stated herein above are true correct  and complete to the  best of my knowledge and belief.', 2, 1, 'Employee', 'HR OFFICER', 1, NULL, NULL, '2025-08-26 09:13:24', '2025-08-26 09:45:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(86, 8, 'pushpa k makwana', 'pushapamakwana97955@gmail.com', '8780260999', '19', 36, '7', '20', '$2y$10$RXCGqY/UZ2RIyLHFe9Kj6.ZlTFVSggvNnSrQXGs0QpD7VE/cWO7CK', '691602', 'lal bahar shastri nagar  visnagar chokadi  hudako', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 2, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-26 10:00:45', '2025-08-26 10:02:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(87, 8, 'Aneri Arvindbhai Patel', 'aneripatel190997@gmail.com', '9664765182', '20', 37, '7', '21', '$2y$10$gc.Cn58ikEx7a2x6jcupDuqozg7CL3nVom/TwPsyWd2Fi/jVXjDDa', '687795', 'Bhadrakali  mta pase,b.k paru, unavaq', 'User', 'fresher', '9000', '[\"\"]', 1, 1, '[\"CSS3\"]', NULL, 'I  hereby declare that the information provided  above  in this reference bio-data by   me is correct to the  best  of  my knowledge.', 2, 1, 'Employee', NULL, 1, NULL, NULL, '2025-08-26 10:30:01', '2025-08-26 11:02:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(88, 8, 'Rupali  prashant patli', 'patilrupali90@gmail.com', '9833305789', '7', 38, '6', '4', '$2y$10$xTim0iirX8KtWqUJq38o7O3oLDmSD8xOQ5wlgjNAi4KOr0gBVgX1O', '664530', 'A-207 kunal  hope town, near n.g. internation  school', 'User', '1 year', '16000', '[\"\"]', 7, 1, '[\"CSS3\",\"HTML5\"]', NULL, 'Seeking the posting of assistant teacher in a renowed organization .', 1, 1, 'Employee', 'tyeaching', 1, NULL, NULL, '2025-08-26 11:41:02', '2025-08-26 11:53:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(89, 8, 'VEJAL SURATI', 'vejaisurati@gmail.com', '7359690763', '7', 21, '6', '3', '$2y$10$BtZ6eZfNteR8UAtiwHdSkOYvw5XWULmbI1R5xjmUCQ7MAGxpKam9q', '323429', 'gorad bahuchar mata temple,gorad mehsana - 384001', 'User', 'FRESHER', NULL, '[\"\"]', 2, 5, '[\"Tally ERP\",\"Tax Filing Portals\"]', NULL, 'Skilled in communication, problem-solving and eager to build a career in finance sector.”', 2, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-08-29 07:16:38', '2025-08-29 12:03:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(90, 9, 'CHIRAGKUMAR C  BHATT', 'chiragbhatt1525@gmail.com', '8200218054', '21', 39, '14', '23', '$2y$10$lqq2g6G9365lj2Xvxjf6Ee8gz6KCNxPL8pV/ejAoopugmZTVb7BqW', '382309', 'A-22,Gate no.3, Gardencity Tenaments Panchwati Area,Kalol', 'User', '2YEARS', '40000', '[\"English\",\"Hindi\",\"Gujarati\"]', 1, 3, '[\"Networking concepts\"]', NULL, 'To seek a channeling in a challenging and stimulating environment personal growth and career development associating with an organization provides an ambiance for learning and professionl growth.', 2, 1, 'Employee', NULL, 1, NULL, NULL, '2025-09-01 07:00:50', '2025-09-01 09:40:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(91, 9, 'CHAUHAN VIRPALSINH J', 'virpalsinh4841 @gmail.com', '8160095633', '22', 40, '6', '24', '$2y$10$m2SRD/H.PQsubjyarFqlrutsWpxI9CipARTNm21KjxZmoVu0dFb5G', '938526', 'Palvada Village', 'User', NULL, '20000', '[\"\"]', 2, 5, '[\"MS Excel\"]', NULL, 'B.Com graduate with skills in Accounting,Tally & Excel.', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-09-01 10:03:38', '2025-09-01 10:14:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(92, 9, 'JINAL RAVAT', 'ravatjinal8@gmail.com', '9512865056', '7', 41, '6', '4', '$2y$10$ZfIaQkXjgj1rgQnrfclB8ukAnwpOVwdG/R4eY3Jp1MMhbLe5NxEBi', '791601', 'A-14  SHIV KUTIR SOCIETY, CHAMUNDA CHOKDI,  MEHSANA', 'User', 'fresher', '10000', '[\"\"]', 1, 1, '[\"HTML5\"]', NULL, 'I BELIEVE THE QUALITY OF HUMAN LIFE CAN BE IMPROVED WITH TECHNOLOGY.', 1, 1, 'Employee', 'Fresher', 1, '9nMlLbAuwkTaHEvWO49nbh26nsciB23oKgJkeFPQVWc69x7KTngtT9ie6jqR', NULL, '2025-09-05 05:47:57', '2025-09-05 10:13:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(93, 8, 'Chauhan Archana', 'chauhanarchana6382@gmail.com', '6356976712', '10', 42, '7', '9', '$2y$10$CxGLnbolVPUg0vgks7f/.ufKLeRdEgQn4Vd2gjRm.RVta68P5xFiq', '103965', 'chauhanvas', 'User', 'fresher', '10000', '[\"\"]', 3, 11, '[\"Tally Prime\"]', NULL, 'Team managment', 1, 1, 'Employee', 'Fresher', 1, NULL, 'resumes/chauhan-archana_68babbd68e9ea_resume.pdf', '2025-09-05 05:52:02', '2025-09-05 10:30:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(94, 5, 'DEEDY CHEMICALS PVTLTD', 'hrd@deedygroup.com', '40323652', '23', 43, '15', '27', '$2y$10$RG3dnV0iHs2HSLJxfLGvw.eEtvOaTQyDXM9SLYkkc6aS0Y38LEeqO', '229147', 'S N 69 & 71 PAIKI, B/H RAVI ESTATE, NR. GAYATRI DAIRY, AT. DHANOT, TAL. KALOL, DIST. GANDHINAGAR, GUJARAT, INDIA', 'User', NULL, NULL, NULL, 1, 1, '[\"\"]', 'chemical company', NULL, NULL, 1, 'Company', 'chemical company', 1, NULL, NULL, '2025-09-05 06:01:40', '2025-09-29 11:42:41', NULL, 'HARDIK GANATRA', 'HARDIK GANATRA', '9924078784', '50000', '25', '2000', NULL, 'profile.png', NULL, 1),
(95, 8, 'PIYUSH DAVE', 'davepiyush278@gmail.com', '9714946752', '25', 45, '7', '28', '$2y$10$LVCVZ0KNtcloYTn7rDhBZeFVC7TmTS5iXmNgcnqikr0qWEGEhiApa', '944099', 'LANGHNAJ', 'User', '2 year', '20000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'LOOKING FOR EXCTING AND DYNAMIC JOB.', 2, 1, 'Employee', 'Accounter', 1, NULL, NULL, '2025-09-05 06:26:02', '2025-09-05 10:17:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(96, 8, 'Kinnari Maulik kumar Patel', 'Kinnari.angle@gmail.com', '8140018217', '7', 22, '6', '3', '$2y$10$UOIeC9EQzYEnRVFnS9bRnue09CTS9usqYO1ebNpktkvm2dCe/FPDG', '754492', 'subh recidency , radhanpur road', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-09-05 06:41:04', '2025-09-05 06:42:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(97, 6, 'AARAV TENDER CONSULTANT PVTLTD', 'aaravtender@gmail.com', '6358934530', '7', 28, '6', '4', '$2y$10$yg9QcpHN6ezHI7hENLLZpeXv3DvOWdgxLoUEkF8F7tRBO9rSP.R.G', '522209', '2nd floor, jagdish chambernr. anad niketan school, malgodoen road, opp. rajkamal petrol pump, mehsana highway, mehsana- 384002', 'User', NULL, NULL, NULL, 3, 12, '[\"\"]', 'A Tender Executive is responsible for managing the entire tendering process for the company, including identifying tender opportunities, preparing tender documents, submitting bids, and ensuring compliance with all requirements. The role involves coordination with internal departments, clients, and vendors to secure contracts and support business growth.', NULL, NULL, 1, 'Company', NULL, 1, NULL, NULL, '2025-09-05 06:51:24', '2025-09-29 11:42:55', NULL, 'mohit patel', 'bhavik mahavar', '6358934530', '45000', '50', '2005', NULL, 'profile.png', NULL, 1),
(98, 8, 'Kajal Desai', 'kavyadesai650@gmail.com', '6356106968', '26', 46, '7', '29', '$2y$10$PAZ3IKyiZ369G9ci9AqH3.PQTnVIWX1jPAflKvCeoVp8QY3O8shDi', '495774', 'rabari vas , motidau', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-09-05 06:51:54', '2025-09-05 10:18:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(99, 8, 'SATHVARA VIDHI SHAILESHBHAI', 'vidhisathvara@gmail.com', '7046621050', '7', 47, '6', '3', '$2y$10$hYZV63UFqq7hXyFMDNN3JuZW1M95R6HUCnA3yMk8U2JQY7NohZggm', '547024', 'MAHADEV  VAS KHERVA', 'User', 'fresher', '10000', '[\"\"]', 1, 1, '[\"HTML5\"]', NULL, 'DATA ENTRY OPRTER', 2, 1, 'Employee', 'Exprience', 1, NULL, NULL, '2025-09-05 06:56:28', '2025-09-05 07:13:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(100, 8, 'Sangita Yadav', 'sangitayadav0697@gmail.com', '9580919139', '27', 48, '7', '31', '$2y$10$0.KDS967VTzjy01T6e0BuOv8KmG3X.RfkakbJusSHwRRWMOs2U.nS', '965421', '10, sanidhya recidency , ganeshpura road, Sidhhpur', 'User', 'experience of 6 month of in documentation', '15000', '[\"\"]', 2, 5, '[\"Tally Prime\",\"Tally ERP\"]', NULL, 'i hereby declare that all the statemet  made here in are true to best of my knowledge and belief', 1, 1, 'Employee', NULL, 1, NULL, 'resumes/sangita-yadav_68baaba4da4f1_resume.pdf', '2025-09-05 07:24:21', '2025-09-05 10:19:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(101, 8, 'RAKSHA B VIHOL', 'viholjayshri278@gmail.com', '6352703666', '28', 49, '7', '32', '$2y$10$DzlG208wW4VwRE49meFMb.aMBmf/2pPDu5EbhfiixY66edQBlxkra', '669268', 'jain derasar nipachal,Azad chok , Kolvada', 'User', NULL, NULL, NULL, 3, 9, '[\"\"]', NULL, 'marketing work good', 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-09-05 09:23:18', '2025-09-05 10:19:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 1),
(102, 8, 'PATEL FULKETA  PRAVINBHAI', 'fulketapatel1587@gmail.com', '8980299171', '25', 50, '7', '33', '$2y$10$gOvcY0heDbSb7PE1pL9ye.OnN2fyoaRy8T1Vl3rxLvtlonA.Tlovy', '588561', 'GANGA MAIYA SOCIETY, KHERVA ,MEHSANA', 'User', 'fresher', '10000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'COMPUTER  KNOWLEDGE', 1, 1, 'Employee', 'Accounter', 1, NULL, NULL, '2025-09-05 10:22:02', '2025-09-05 10:53:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(103, 10, 'manish patel', 'manishpatel@gmail.com', '8341300244', '7', 21, '6', '3', '$2y$10$wS0QOmBRb3i/9MY3RNAlQOwKHubXNNPiWu7X8zrtmpQhcz7thVxwq', '435643', 'laxmiparu gorad,ta & dist :- mehsana , mehsana - 384001, gujarat, india.', 'User', 'FRESHER', NULL, '[\"\"]', 2, 6, '[\"Accounting Software\"]', NULL, 'B.Com graduate with strong knowledge of accounting principles and MS Excel. Eager to start a career in finance and contribute to organizational growth.', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-09-05 10:27:22', '2025-09-05 10:57:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(104, 8, 'Avni Bhavsar', 'avnibhavsar1512001@gmail.com', '9408884671', '29', 24, '9', '8', '$2y$10$IR8j.DFM4pAF2xnXwGsSSeUYoDNfyvaqu7MccwlVtQxFACsBUOMbG', '162290', 'avnibhavsar1512001@gmail.com', 'User', 'fresher', '10000', '[\"\"]', 2, 5, '[\"MS Excel\"]', NULL, 'MIC Cource complete', 1, 1, 'Employee', 'Fresher', 1, 'v9gT0qcPvuabbmvzlTrjEXg8YSVU4Fq9YdMYB2kmzj0yzAR3fuKPolppKZcf', 'resumes/avni-bhavsar_68bac3daa9f95_resume.pdf', '2025-09-05 10:42:56', '2025-09-05 11:04:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(105, NULL, 'Patel Roshan kumar Bharatbhai', 'roshanpatel168@gmail.com', '9586475409', '30', 51, '7', '34', '$2y$10$Jut8yBhjmcllkRHLYj6FsuS54JKEa3uENEMb0JTReWBNiiXkH1516', '742861', 'NORTA , PATEL VAS', 'User', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, 1, 1, 'Employee', NULL, 1, NULL, NULL, '2025-09-05 11:15:47', '2025-09-05 11:15:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(106, 8, 'MAYANK KIRANBHAI MODI', 'mayankmodi71088@gmail.com', '9870047108', '31', 24, '6', '8', '$2y$10$b1wkD0iev3Na6No8f0RoQO7jSh7xA5kbWynRLOQpMMW.6XoJ0.wbW', '977646', 'suryoday society kansa na vistar visnagar', 'User', '13 YEARS', '37000', '[\"\"]', 1, 1, '[\"HTML5\"]', NULL, 'I HEREBY DECLARE THAT ALL THE INFORMATION MENTIONED ABOVE IS TRUE TO THE BEST OF MY KNOWLEDGE.', 1, 1, 'Employee', 'Exprience', 1, NULL, NULL, '2025-09-05 11:22:11', '2025-09-05 11:47:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(107, 8, 'priya barot', 'barotpriya885@gmail.com', '7046232278', '32', 52, '7', '35', '$2y$10$W614Ba7lQsutglUpW0O6j.sRhZqqGICVUBXXXVRJ4sUth/INgGMpK', '830883', 'taluka vav , Banaskantha', 'User', '2 YEAR EXPERENCE', '20000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'IMPACT REWARD AND RECOGNITION    EMPLOYE', 2, 1, 'Employee', 'BA', 1, NULL, 'resumes/priya-barot_68bad0482f607_resume.pdf', '2025-09-05 11:29:16', '2025-09-05 11:58:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(108, 8, 'VAISHALI RAJNIKANT JOSHI', 'VAISHALI123@GMAIL.COM', '9773152198', '10', 53, '7', '9', '$2y$10$DQH6tu35JgrpOsURsenPHOmAzRBslqarOK5GC8Eb46dr8JRG2KzJ6', '710811', 'SUBH-LAXMI SOCIETY, PATAN', 'User', 'fresher', '10000', '[\"\"]', 2, 5, '[\"Tally Prime\"]', NULL, 'I AM PURSUING BACHLER OPF BUSINESS ADMINISTEATOE.', 2, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-09-05 11:56:33', '2025-09-05 12:08:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(109, 7, 'AMOL MINECHEM LTD', 'hr@amolminechem.com', '9173788142', '7', 21, '6', '4', '$2y$10$uPsG8ucHqTcCIU31bzRnQOfkIniC5JFTSGTgZAma2jQV4KPh.hmTu', '382704', 'MEHSANA AHMEDABAD HIGHWAY', 'User', NULL, NULL, NULL, 1, 1, '[\"\"]', 'The core objective of a spare parts company is to meet customer demands with durable, cost-effective, and timely solutions. Many companies also focus on both genuine OEM parts and aftermarket parts, catering to a wide range of client needs.', NULL, NULL, 1, 'Company', NULL, 1, NULL, NULL, '2025-09-06 07:20:47', '2025-09-29 11:43:04', NULL, 'savan patel', 'savan patel', '9173788142', '25000', '25', '2008', NULL, 'profile.png', NULL, 1),
(110, 8, 'JAYSINH ZALA', 'zalajaysinh8@gmail.com', '9173605084', '7', 21, '6', '3', '$2y$10$NNY/WfqtVdecBZvL3a3wle8L3dCSv4HNLx6sFY42bwkU9P6ep1i02', '330814', 'MEHSANA, RADHANPUR ROAD', 'User', '3 years', '30000', '[\"\"]', 1, 1, '[\"Routing & Switching\"]', NULL, 'GOOD COMMUNICEN SKILLS', 1, 1, 'Employee', 'MECHNICAL ENGINEER', 1, NULL, NULL, '2025-09-06 08:43:46', '2025-09-06 09:06:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0),
(111, 9, 'JAGDISH PRAVINBHAI MAKWANA', 'makwanajagdish512@gmail.com', '9099152521', '33', 54, '7', '37', '$2y$10$jSs9ir6jrAw6baDdj9UZnegAWsHTTI.Ki0qCfqpE5gCx1NIfAqGMS', '968105', 'vankar vas, panchot', 'User', 'fresher', '10000', '[\"\"]', 1, 1, '[\"JavaScript\",\"HTML5\"]', NULL, 'I wil lbe working and in achieving  quality goals with continual improvement to attain new  height  in my field  of work.', 1, 1, 'Employee', 'Fresher', 1, NULL, NULL, '2025-09-06 09:19:41', '2025-09-06 09:35:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'profile.png', NULL, 0);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

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
-- Indexes for table `tbl_achievement`
--
ALTER TABLE `tbl_achievement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ad_banner`
--
ALTER TABLE `tbl_ad_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_area`
--
ALTER TABLE `tbl_area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `tbl_company_branches`
--
ALTER TABLE `tbl_company_branches`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `tbl_company_branches_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_education`
--
ALTER TABLE `tbl_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee_type`
--
ALTER TABLE `tbl_employee_type`
  ADD PRIMARY KEY (`emp_type_id`);

--
-- Indexes for table `tbl_experience_req`
--
ALTER TABLE `tbl_experience_req`
  ADD PRIMARY KEY (`experience_req_id`);

--
-- Indexes for table `tbl_job`
--
ALTER TABLE `tbl_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `tbl_job_apply`
--
ALTER TABLE `tbl_job_apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_job_apply_history`
--
ALTER TABLE `tbl_job_apply_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_job_category`
--
ALTER TABLE `tbl_job_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_job_level`
--
ALTER TABLE `tbl_job_level`
  ADD PRIMARY KEY (`job_level_id`);

--
-- Indexes for table `tbl_job_round`
--
ALTER TABLE `tbl_job_round`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_job_save`
--
ALTER TABLE `tbl_job_save`
  ADD PRIMARY KEY (`id`),
  ADD KEY `save_job_id` (`job_id`),
  ADD KEY `save_job_user_id` (`user_id`);

--
-- Indexes for table `tbl_job_type`
--
ALTER TABLE `tbl_job_type`
  ADD PRIMARY KEY (`job_type_id`);

--
-- Indexes for table `tbl_min_qualification`
--
ALTER TABLE `tbl_min_qualification`
  ADD PRIMARY KEY (`qualification_id`);

--
-- Indexes for table `tbl_plan_history`
--
ALTER TABLE `tbl_plan_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_plan_history_plan_id_foreign` (`plan_id`),
  ADD KEY `tbl_plan_history_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_plan_pricing`
--
ALTER TABLE `tbl_plan_pricing`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `tbl_resume`
--
ALTER TABLE `tbl_resume`
  ADD PRIMARY KEY (`resume_id`);

--
-- Indexes for table `tbl_resume_builder`
--
ALTER TABLE `tbl_resume_builder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_round_complete`
--
ALTER TABLE `tbl_round_complete`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_staff_activity`
--
ALTER TABLE `tbl_staff_activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  ADD PRIMARY KEY (`sub_category_id`);

--
-- Indexes for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_work_experience`
--
ALTER TABLE `tbl_work_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_work_type`
--
ALTER TABLE `tbl_work_type`
  ADD PRIMARY KEY (`work_type_id`);

--
-- Indexes for table `tbl_zipcode`
--
ALTER TABLE `tbl_zipcode`
  ADD PRIMARY KEY (`zipcode_id`);

--
-- Indexes for table `test_demos`
--
ALTER TABLE `test_demos`
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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_achievement`
--
ALTER TABLE `tbl_achievement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_ad_banner`
--
ALTER TABLE `tbl_ad_banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_area`
--
ALTER TABLE `tbl_area`
  MODIFY `area_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `city_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_company_branches`
--
ALTER TABLE `tbl_company_branches`
  MODIFY `branch_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_education`
--
ALTER TABLE `tbl_education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_employee_type`
--
ALTER TABLE `tbl_employee_type`
  MODIFY `emp_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_experience_req`
--
ALTER TABLE `tbl_experience_req`
  MODIFY `experience_req_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_job`
--
ALTER TABLE `tbl_job`
  MODIFY `job_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_job_apply`
--
ALTER TABLE `tbl_job_apply`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_job_apply_history`
--
ALTER TABLE `tbl_job_apply_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_job_category`
--
ALTER TABLE `tbl_job_category`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_job_level`
--
ALTER TABLE `tbl_job_level`
  MODIFY `job_level_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_job_round`
--
ALTER TABLE `tbl_job_round`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_job_save`
--
ALTER TABLE `tbl_job_save`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_job_type`
--
ALTER TABLE `tbl_job_type`
  MODIFY `job_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_min_qualification`
--
ALTER TABLE `tbl_min_qualification`
  MODIFY `qualification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_plan_history`
--
ALTER TABLE `tbl_plan_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_plan_pricing`
--
ALTER TABLE `tbl_plan_pricing`
  MODIFY `plan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_resume`
--
ALTER TABLE `tbl_resume`
  MODIFY `resume_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_resume_builder`
--
ALTER TABLE `tbl_resume_builder`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_round_complete`
--
ALTER TABLE `tbl_round_complete`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_staff_activity`
--
ALTER TABLE `tbl_staff_activity`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `state_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `sub_category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_work_experience`
--
ALTER TABLE `tbl_work_experience`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_work_type`
--
ALTER TABLE `tbl_work_type`
  MODIFY `work_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_zipcode`
--
ALTER TABLE `tbl_zipcode`
  MODIFY `zipcode_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `test_demos`
--
ALTER TABLE `test_demos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_company_branches`
--
ALTER TABLE `tbl_company_branches`
  ADD CONSTRAINT `tbl_company_branches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_job_save`
--
ALTER TABLE `tbl_job_save`
  ADD CONSTRAINT `save_job_id` FOREIGN KEY (`job_id`) REFERENCES `tbl_job` (`job_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `save_job_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_plan_history`
--
ALTER TABLE `tbl_plan_history`
  ADD CONSTRAINT `tbl_plan_history_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `tbl_plan_pricing` (`plan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_plan_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
