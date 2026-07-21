/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `grade_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grade_criteria` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grade_criteria_section_id_foreign` (`section_id`),
  KEY `grade_criteria_grade_id_section_id_index` (`grade_id`,`section_id`),
  CONSTRAINT `grade_criteria_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grade_criteria_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `grade_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `grade_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grade_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grade_sections_grade_id_index` (`grade_id`),
  CONSTRAINT `grade_sections_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `college_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `total_marks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_college_id_index` (`college_id`),
  KEY `grades_course_id_index` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `internship_marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `internship_marks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `internship_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `criteria_id` bigint(20) unsigned NOT NULL,
  `criteria_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_marks` int(11) NOT NULL DEFAULT 0,
  `marks` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=draft, 1=submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `intern_student_criteria_unique` (`internship_id`,`student_id`,`criteria_id`),
  KEY `internship_marks_student_id_foreign` (`student_id`),
  KEY `internship_marks_criteria_id_foreign` (`criteria_id`),
  KEY `internship_marks_internship_id_student_id_index` (`internship_id`,`student_id`),
  KEY `internship_marks_status_index` (`status`),
  CONSTRAINT `internship_marks_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `grade_criteria` (`id`) ON DELETE CASCADE,
  CONSTRAINT `internship_marks_internship_id_foreign` FOREIGN KEY (`internship_id`) REFERENCES `tbl_internship` (`id`) ON DELETE CASCADE,
  CONSTRAINT `internship_marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `college_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  KEY `roles_college_id_foreign` (`college_id`),
  CONSTRAINT `roles_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `tbl_college` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_achievement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_ad_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_ad_banner` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ad_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_nm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_area` (
  `area_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) unsigned NOT NULL,
  `city_id` bigint(20) unsigned NOT NULL,
  `area_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_blog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `datetime` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_city` (
  `city_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) unsigned NOT NULL,
  `city_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_college`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_college` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `college_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `college_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `university_id` bigint(20) unsigned NOT NULL,
  `degree_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`degree_ids`)),
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, approved, rejected',
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Role or type for college',
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_college_university_id_foreign` (`university_id`),
  CONSTRAINT `tbl_college_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `tbl_university` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_college_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_college_staff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `college_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_college_staff_email_unique` (`email`),
  KEY `tbl_college_staff_college_id_foreign` (`college_id`),
  KEY `tbl_college_staff_role_id_foreign` (`role_id`),
  CONSTRAINT `tbl_college_staff_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `tbl_college` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_college_staff_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_company_branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_company_branches` (
  `branch_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `company_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_company_kyc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_company_kyc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_degree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_degree` (
  `degree_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `degree_level_id` bigint(20) unsigned NOT NULL,
  `degree_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:pending,1:approved,2:rejected',
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`degree_id`),
  KEY `tbl_degree_degree_level_id_foreign` (`degree_level_id`),
  CONSTRAINT `tbl_degree_degree_level_id_foreign` FOREIGN KEY (`degree_level_id`) REFERENCES `tbl_degree_level` (`degree_level_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_degree_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_degree_level` (
  `degree_level_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `degree_level_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:pending,1:approved,2:rejected',
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`degree_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_education` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_of_study` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` int(4) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_employee_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_employee_type` (
  `emp_type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`emp_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_experience_req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_experience_req` (
  `experience_req_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`experience_req_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `internship_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Default, 1 = With College, 2 = With Industry',
  `internship_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `company_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stipend` decimal(10,2) DEFAULT NULL,
  `openings` int(11) DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_weeks` int(11) DEFAULT NULL,
  `total_hours` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `batch_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Store data in format: [["monday":{"09:00","10:00"}],[]]' CHECK (json_valid(`batch_days`)),
  `skills` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eligibility_criteria` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internship_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_brief_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internship_objective` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internship_outcome` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_instructions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`perks`)),
  `registration_fees` decimal(10,2) DEFAULT NULL,
  `gst_percentage` decimal(5,2) DEFAULT NULL,
  `gst_amount` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `manage_task_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Enable task management for this internship',
  `complete_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Incomplete, 1 = Complete',
  `college_complete_sts` tinyint(4) NOT NULL DEFAULT 0,
  `college_pending_flag` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = admin marked as pending for college marks entry',
  `company_complete_sts` tinyint(4) NOT NULL DEFAULT 0,
  `approve_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Reject',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_internship_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship_application` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `internship_id` bigint(20) unsigned DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `complete_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: pending, 1: completed',
  `applied_on` timestamp NULL DEFAULT NULL,
  `company_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `college_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_staff_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_internship_application_assigned_staff_id_foreign` (`assigned_staff_id`),
  CONSTRAINT `tbl_internship_application_assigned_staff_id_foreign` FOREIGN KEY (`assigned_staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship_college_submits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship_college_submits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `internship_id` bigint(20) unsigned NOT NULL,
  `college_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_internship_college_course` (`internship_id`,`college_id`,`course_id`),
  CONSTRAINT `tbl_internship_college_submits_internship_id_foreign` FOREIGN KEY (`internship_id`) REFERENCES `tbl_internship` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship_payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `internship_id` bigint(20) unsigned DEFAULT NULL,
  `gst_percentage` decimal(5,2) DEFAULT NULL,
  `gst_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `payment_mode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'e.g., Razorpay, Stripe, Paytm, local',
  `transaction_id` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Gateway transaction id or local generated payment id',
  `payment_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Application status Pending:0, Success:1, Failed:2, Refunded:3',
  `paid_on` timestamp NULL DEFAULT NULL,
  `payment_response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Raw gateway response JSON' CHECK (json_valid(`payment_response_data`)),
  `payment_transaction_id` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Local payment transaction id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship_review` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `internship_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `star` tinyint(3) unsigned NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT 1,
  `write_on` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_internship_review_internship_id_index` (`internship_id`),
  KEY `tbl_internship_review_student_id_index` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship_tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `internship_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `student_id` bigint(20) unsigned DEFAULT NULL,
  `date_time` datetime DEFAULT NULL COMMENT 'Date & Time for the task',
  `day` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Day of the week (e.g., Monday)',
  `module_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Module/Task Title',
  `module_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Module and Task Description',
  `upload_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Uploaded file path',
  `last_submission_date` date DEFAULT NULL COMMENT 'Last date for submission',
  `online_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Online link for task',
  `is_final_assignment` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Final Assignment/Report, 0 = Regular Task',
  `student_submit_file` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_submit_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_submit_project_link` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submit_on` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `task_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_internship_tasks_internship_id_foreign` (`internship_id`),
  CONSTRAINT `tbl_internship_tasks_internship_id_foreign` FOREIGN KEY (`internship_id`) REFERENCES `tbl_internship` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_internship_wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_internship_wishlist` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `internship_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_internship_wishlist_user_id_internship_id_unique` (`user_id`,`internship_id`),
  KEY `tbl_internship_wishlist_internship_id_foreign` (`internship_id`),
  CONSTRAINT `tbl_internship_wishlist_internship_id_foreign` FOREIGN KEY (`internship_id`) REFERENCES `tbl_internship` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_internship_wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job` (
  `job_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `preference_type` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `sub_category_id` bigint(20) unsigned DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification_id` bigint(20) unsigned DEFAULT NULL,
  `job_level_id` bigint(20) unsigned DEFAULT NULL,
  `job_type_id` bigint(20) unsigned DEFAULT NULL,
  `work_type_id` bigint(20) unsigned DEFAULT NULL,
  `number_of_openings` int(11) NOT NULL DEFAULT 1,
  `salary_budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interviewer_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_req_id` bigint(20) unsigned DEFAULT NULL,
  `job_timing` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) unsigned DEFAULT NULL,
  `city_id` bigint(20) unsigned DEFAULT NULL,
  `area_id` bigint(20) unsigned DEFAULT NULL,
  `zipcode_id` bigint(20) unsigned DEFAULT NULL,
  `hr_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_contact_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Active, 0-Draft, 2-Close',
  `total_apply` int(11) DEFAULT NULL,
  `remain_opening` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_apply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_apply` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `markAsRead` int(11) DEFAULT NULL COMMENT '1: means read for show selected dialog',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_nm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Uploaded file: image/pdf/doc/docx',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Accepted, 2 = Rejected 3: Shortlisted 4 = Schedule Interview',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Job_id_ref` (`job_id`),
  CONSTRAINT `Job_id_ref` FOREIGN KEY (`job_id`) REFERENCES `tbl_job` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_apply_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_apply_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `job_id` bigint(20) unsigned NOT NULL,
  `job_apply_id` bigint(20) unsigned NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Job_id_ref_job_history` (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_category` (
  `category_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `preference_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1: Skill 2: Non-Skill',
  `category_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_level` (
  `job_level_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`job_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_round`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_round` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` bigint(20) unsigned NOT NULL,
  `round_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `round_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Job_id_ref_job_round` (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_save`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_save` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `job_id` bigint(20) unsigned NOT NULL,
  `saved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `save_job_id` (`job_id`),
  KEY `save_job_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_title` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_job_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_job_type` (
  `job_type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`job_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_major`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_major` (
  `major_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `degree_id` bigint(20) unsigned NOT NULL,
  `major_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:pending,1:approved,2:rejected',
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`major_id`),
  KEY `tbl_major_degree_id_foreign` (`degree_id`),
  CONSTRAINT `tbl_major_degree_id_foreign` FOREIGN KEY (`degree_id`) REFERENCES `tbl_degree` (`degree_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_min_qualification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_min_qualification` (
  `qualification_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`qualification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_plan_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_plan_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `purchase_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_plan_history_plan_id_foreign` (`plan_id`),
  KEY `tbl_plan_history_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_plan_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_plan_pricing` (
  `plan_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plan_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_price` decimal(10,2) NOT NULL,
  `plan_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `benefits` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '1=Hackathon, 2=Internship',
  `internship_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `university` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `college` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '1=Male, 2=Female, 3=Other',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Complete, 2=Cancel',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_resume` (
  `resume_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `file_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume_type` tinyint(4) NOT NULL COMMENT '1: Uploaded Resume, 2: Resume Builder',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`resume_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_resume_builder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_resume_builder` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `resume_id` bigint(20) unsigned NOT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_known` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_round_complete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_round_complete` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `round_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `job_id` bigint(20) unsigned NOT NULL,
  `hr_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interview_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `complete_datetime` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_setting` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ShowCompanyDetails` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Active 2: Deactive',
  `web_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_meta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_us` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corporate_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `play_store_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_store_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `sub_category_id` bigint(20) unsigned NOT NULL,
  `skill_nm` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_staff_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_staff_activity` (
  `activity_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_state` (
  `state_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_sub_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_sub_category` (
  `sub_category_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `sub_category_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sub_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_testimonial` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_university`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_university` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `university_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, approved, rejected',
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_work_experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_work_experience` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_type_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_status` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_type_id` bigint(20) unsigned NOT NULL,
  `role_responsibility` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_work_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_work_type` (
  `work_type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`work_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tbl_zipcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_zipcode` (
  `zipcode_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) unsigned NOT NULL,
  `city_id` bigint(20) unsigned NOT NULL,
  `area_id` bigint(20) unsigned NOT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`zipcode_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `test_demos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_demos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `active_plan_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint(20) unsigned DEFAULT NULL,
  `state_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languages` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `sub_category_id` bigint(20) unsigned DEFAULT NULL,
  `skills_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `university_id` int(10) unsigned DEFAULT NULL,
  `college_id` int(10) unsigned DEFAULT NULL,
  `degree_level_id` int(10) unsigned DEFAULT NULL,
  `degree_id` int(10) unsigned DEFAULT NULL,
  `major_id` int(10) unsigned DEFAULT NULL,
  `semester` int(10) unsigned DEFAULT NULL,
  `preference_type` bigint(20) unsigned DEFAULT NULL COMMENT '1: Skill 2: Non-Skill',
  `verify_status` tinyint(4) NOT NULL DEFAULT 0,
  `profile_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume_nm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `personal_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_nm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `average_salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_since` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL COMMENT '1=Male, 2=Female, 3=Other',
  `profile_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Rejected',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (125,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (126,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (127,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (128,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES (129,'2025_07_09_161702_create_tbl_job_category_table',1);
INSERT INTO `migrations` VALUES (130,'2025_07_09_161937_create_tbl_sub_category_table',1);
INSERT INTO `migrations` VALUES (131,'2025_07_09_162045_create_tbl_employee_type_table',1);
INSERT INTO `migrations` VALUES (132,'2025_07_09_162353_create_tbl_job_type_table',1);
INSERT INTO `migrations` VALUES (133,'2025_07_09_162517_create_tbl_job_level_table',1);
INSERT INTO `migrations` VALUES (134,'2025_07_09_162549_create_tbl_work_type_table',1);
INSERT INTO `migrations` VALUES (135,'2025_07_09_162621_create_tbl_min_qualification_table',1);
INSERT INTO `migrations` VALUES (136,'2025_07_09_162708_create_tbl_experience_req_table',1);
INSERT INTO `migrations` VALUES (137,'2025_07_09_163052_create_tbl_skills_table',1);
INSERT INTO `migrations` VALUES (138,'2025_07_09_163118_create_tbl_state_table',1);
INSERT INTO `migrations` VALUES (139,'2025_07_09_163141_create_tbl_city_table',1);
INSERT INTO `migrations` VALUES (140,'2025_07_09_163218_create_tbl_area_table',1);
INSERT INTO `migrations` VALUES (141,'2025_07_09_163245_create_tbl_zipcode_table',1);
INSERT INTO `migrations` VALUES (142,'2025_07_09_164645_add_role_to_users_table',1);
INSERT INTO `migrations` VALUES (143,'2025_07_10_041501_create_test_demos_table',1);
INSERT INTO `migrations` VALUES (144,'2025_07_10_094407_add_category_id_to_tbl_sub_category_table',1);
INSERT INTO `migrations` VALUES (145,'2025_07_10_144638_add_country_id_to_tbl_state_table',1);
INSERT INTO `migrations` VALUES (146,'2025_07_11_102124_create_permission_tables',1);
INSERT INTO `migrations` VALUES (147,'2025_07_12_140117_add_otp_to_users_table',1);
INSERT INTO `migrations` VALUES (148,'2025_07_13_043520_add_columns_to_users_table',1);
INSERT INTO `migrations` VALUES (149,'2025_07_14_093235_create_company_branches_table',2);
INSERT INTO `migrations` VALUES (151,'2025_07_14_000000_create_tbl_plan_pricing_table',3);
INSERT INTO `migrations` VALUES (152,'2025_07_14_120000_create_tbl_plan_history_table',4);
INSERT INTO `migrations` VALUES (153,'2025_07_14_120001_add_active_plan_id_to_users_table',5);
INSERT INTO `migrations` VALUES (154,'2025_07_14_114036_add_area_id_to_users_table',6);
INSERT INTO `migrations` VALUES (155,'2025_07_15_000000_add_designation_to_users_table',7);
INSERT INTO `migrations` VALUES (157,'2025_07_15_045003_create_tbl_work_experience_table',8);
INSERT INTO `migrations` VALUES (160,'2025_07_15_095434_create_tbl_education_table',9);
INSERT INTO `migrations` VALUES (161,'2025_07_17_042418_add_resume_to_users_table',10);
INSERT INTO `migrations` VALUES (162,'2025_07_17_100723_create_tbl_job_table',11);
INSERT INTO `migrations` VALUES (163,'2025_07_18_091555_add_cover_img_to_users_table',12);
INSERT INTO `migrations` VALUES (164,'2025_07_18_113420_add_image_to_tbl_job_category_table',13);
INSERT INTO `migrations` VALUES (165,'2025_07_19_090423_create_tbl_job_save_table',14);
INSERT INTO `migrations` VALUES (166,'2025_07_21_111845_create_tbl_blog_table',15);
INSERT INTO `migrations` VALUES (167,'2025_07_21_114945_add_datetime_to_tbl_blog_table',16);
INSERT INTO `migrations` VALUES (168,'2025_07_21_120759_create_tbl_achievement_table',17);
INSERT INTO `migrations` VALUES (169,'2025_07_22_043008_add_status_and_apply_columns_to_tbl_job_table',18);
INSERT INTO `migrations` VALUES (170,'2025_07_22_043351_create_tbl_job_apply_table',19);
INSERT INTO `migrations` VALUES (171,'2025_07_22_043643_create_tbl_job_apply_history_table',20);
INSERT INTO `migrations` VALUES (172,'2025_07_22_110407_create_tbl_ad_banner_table',21);
INSERT INTO `migrations` VALUES (173,'2025_07_22_111613_add_status_to_tbl_ad_banner_table',22);
INSERT INTO `migrations` VALUES (174,'2025_07_23_093056_create_tbl_testimonial_table',23);
INSERT INTO `migrations` VALUES (175,'2025_07_24_042754_create_tbl_setting_table',24);
INSERT INTO `migrations` VALUES (176,'2025_07_25_044833_create_tbl_job_round_table',25);
INSERT INTO `migrations` VALUES (177,'2025_07_25_045006_create_tbl_round_complete_table',26);
INSERT INTO `migrations` VALUES (178,'2025_07_30_050438_add_show_company_details_to_tbl_setting_table',27);
INSERT INTO `migrations` VALUES (179,'2025_07_31_101050_add_salary_budget_to_tbl_job_table',28);
INSERT INTO `migrations` VALUES (180,'2025_08_01_043647_create_tbl_resume_table',29);
INSERT INTO `migrations` VALUES (181,'2025_08_01_043755_create_tbl_resume_builder_table',30);
INSERT INTO `migrations` VALUES (182,'2025_08_02_043159_add_remarks_to_tbl_round_complete_table',31);
INSERT INTO `migrations` VALUES (183,'2025_08_04_093920_add_profile_status_to_users_table',32);
INSERT INTO `migrations` VALUES (184,'2025_08_05_053755_add_preference_type_to_tbl_job_category_table',33);
INSERT INTO `migrations` VALUES (185,'2025_08_06_050439_create_tbl_staff_activity_table',34);
INSERT INTO `migrations` VALUES (186,'2025_08_07_042918_add_experience_salary_languages_to_users_table',35);
INSERT INTO `migrations` VALUES (187,'2025_09_15_090014_add_collumn_into_table_tbl_plan_history',36);
INSERT INTO `migrations` VALUES (188,'2026_02_10_000000_create_tbl_internship_table',37);
INSERT INTO `migrations` VALUES (189,'2026_02_25_042845_add_rejection_reason_to_tbl_internship_table',38);
INSERT INTO `migrations` VALUES (190,'2026_02_25_053424_add_internship_type_to_tbl_internship_table',39);
INSERT INTO `migrations` VALUES (191,'2026_02_25_055512_add_general_instructions_to_tbl_internship_table',40);
INSERT INTO `migrations` VALUES (192,'2026_02_25_103057_create_tbl_internship_tasks_table',41);
INSERT INTO `migrations` VALUES (193,'2026_02_26_085658_add_slug_to_tbl_internship_table',42);
INSERT INTO `migrations` VALUES (194,'2026_02_26_092009_create_tbl_internship_wishlist_table',43);
INSERT INTO `migrations` VALUES (195,'2026_02_26_092642_add_perks_to_tbl_internship_table',44);
INSERT INTO `migrations` VALUES (196,'2026_03_07_000001_create_tbl_degree_level_table',45);
INSERT INTO `migrations` VALUES (197,'2026_03_07_000002_create_tbl_degree_table',46);
INSERT INTO `migrations` VALUES (198,'2026_03_07_000003_create_tbl_major_table',47);
INSERT INTO `migrations` VALUES (199,'2026_03_06_000001_create_tbl_university_table',48);
INSERT INTO `migrations` VALUES (200,'2026_03_06_000002_create_tbl_college_table',48);
INSERT INTO `migrations` VALUES (201,'2026_03_06_061522_add_reject_reason_to_tbl_university_table',49);
INSERT INTO `migrations` VALUES (202,'2026_03_06_062720_add_columns_to_tbl_college_table',50);
INSERT INTO `migrations` VALUES (203,'2026_03_07_120000_add_institution_fields_to_users_table',51);
INSERT INTO `migrations` VALUES (204,'2026_03_07_130000_create_tbl_internship_payment_table',52);
INSERT INTO `migrations` VALUES (205,'2026_03_07_140000_create_tbl_internship_application_table',53);
INSERT INTO `migrations` VALUES (206,'2026_03_07_120000_add_approve_status_and_reject_reason_to_tbl_degree_level',54);
INSERT INTO `migrations` VALUES (207,'2026_03_07_120100_add_approve_status_and_reject_reason_to_tbl_major',55);
INSERT INTO `migrations` VALUES (208,'2026_03_07_120200_add_approve_status_and_reject_reason_to_tbl_degree',56);
INSERT INTO `migrations` VALUES (209,'2026_03_09_000000_add_parent_and_student_to_tbl_internship_tasks',57);
INSERT INTO `migrations` VALUES (210,'2026_03_09_020000_add_student_submission_columns_to_tbl_internship_tasks',58);
INSERT INTO `migrations` VALUES (211,'2026_03_09_120000_create_tbl_internship_review_table',59);
INSERT INTO `migrations` VALUES (212,'2026_03_09_103717_add_task_feedback_to_tbl_internship_tasks',60);
INSERT INTO `migrations` VALUES (213,'2026_03_10_000001_create_grades_table',61);
INSERT INTO `migrations` VALUES (214,'2026_03_10_000002_create_grade_sections_table',62);
INSERT INTO `migrations` VALUES (215,'2026_03_10_000003_create_grade_criteria_table',63);
INSERT INTO `migrations` VALUES (216,'2026_03_11_120000_add_role_to_tbl_college',64);
INSERT INTO `migrations` VALUES (217,'2026_03_11_120000_add_manage_task_status_to_tbl_internship_table',65);
INSERT INTO `migrations` VALUES (218,'2026_02_27_000000_add_internship_id_to_tbl_registrations_table',66);
INSERT INTO `migrations` VALUES (219,'2026_03_11_150000_add_password_to_tbl_college',67);
INSERT INTO `migrations` VALUES (220,'2026_03_12_044455_add_assigned_staff_id_to_internship_application',68);
INSERT INTO `migrations` VALUES (221,'2026_03_12_053213_create_tbl_college_staff_table',69);
INSERT INTO `migrations` VALUES (222,'2026_03_12_053253_add_college_id_to_roles_table',69);
INSERT INTO `migrations` VALUES (223,'2026_03_12_061705_add_college_permissions_to_permissions_table',70);
INSERT INTO `migrations` VALUES (224,'2026_04_08_000001_create_internship_marks_table',71);
INSERT INTO `migrations` VALUES (225,'2026_04_08_100001_update_internship_marks_add_snapshot_remove_feedback',72);
INSERT INTO `migrations` VALUES (226,'2026_04_08_200001_add_college_company_complete_sts_to_tbl_internship',73);
INSERT INTO `migrations` VALUES (227,'2026_04_08_300000_add_college_pending_flag_to_tbl_internship',74);
INSERT INTO `migrations` VALUES (228,'2026_04_10_000001_add_degree_ids_to_tbl_college',75);
INSERT INTO `migrations` VALUES (229,'2026_04_10_000002_create_tbl_internship_college_submits',76);
