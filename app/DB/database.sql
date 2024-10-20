-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2024 at 11:37 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p_real_estate`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_users`
--

CREATE TABLE `access_users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Ajax', 'ajax', '1', 'Sujon Mia', 'Sujon Mia', '2024-10-16 22:32:05', '2024-10-18 23:18:24'),
(2, 'PHP', 'php', '1', 'Sujon Mia', NULL, '2024-10-17 00:45:04', '2024-10-17 00:45:04'),
(3, 'Laravel', 'laravel', '1', 'Sujon Mia', NULL, '2024-10-17 00:45:10', '2024-10-17 00:45:10'),
(4, 'Jquery', 'jquery', '1', 'Sujon Mia', NULL, '2024-10-18 23:18:31', '2024-10-18 23:18:31'),
(5, 'Javascript', 'javascript', '1', 'Sujon Mia', NULL, '2024-10-18 23:18:37', '2024-10-18 23:18:37'),
(6, 'React Js', 'react-js', '1', 'Sujon Mia', NULL, '2024-10-18 23:18:46', '2024-10-18 23:18:46'),
(7, 'Vue Js', 'vue-js', '1', 'Sujon Mia', NULL, '2024-10-18 23:18:54', '2024-10-18 23:18:54'),
(8, 'Java', 'java', '1', 'Sujon Mia', NULL, '2024-10-18 23:19:08', '2024-10-18 23:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `category_post`
--

CREATE TABLE `category_post` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_post`
--

INSERT INTO `category_post` (`id`, `post_id`, `category_id`) VALUES
(1, 1, 5),
(2, 1, 4),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `slug`, `status`, `meta_title`, `meta_description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Business', 'business', '1', 'Business Team For Myolbd', 'Business Team For Myolbd', 'Sujon Mia', NULL, '2024-10-18 23:34:26', '2024-10-18 23:34:26'),
(2, 'Marketing', 'marketing', '1', 'Marketing Team For Myolbd', 'Marketing Team For Myolbd', 'Sujon Mia', NULL, '2024-10-18 23:40:10', '2024-10-18 23:40:10');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `location`, `content`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Header', '1', '[{\"id\":\"1\"},{\"id\":\"2\",\"children\":{\"1\":{\"id\":\"8\"},\"2\":{\"id\":\"9\"},\"3\":{\"id\":\"12\"},\"4\":{\"id\":\"13\"}}},{\"id\":\"3\",\"children\":[{\"id\":\"11\"},{\"id\":\"10\"}]},{\"id\":\"4\"},{\"id\":\"5\"},{\"id\":\"16\",\"children\":[{\"id\":\"15\"},{\"id\":\"14\"}]},{\"id\":\"18\"},{\"id\":25},{\"id\":29}]', 'Sujon Mia', NULL, '2024-10-18 23:40:49', '2024-10-19 02:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classes` text COLLATE utf8mb4_unicode_ci,
  `target` enum('_self','_blank') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `name`, `slug`, `type`, `classes`, `target`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', NULL, 'http://127.0.0.1:8000/home', 'custom', 'new-class', '_blank', '2024-10-18 23:41:09', '2024-10-19 00:32:25'),
(2, 1, 'Frontend', NULL, '#', 'custom', NULL, '_self', '2024-10-18 23:41:25', '2024-10-19 00:33:53'),
(3, 1, 'Backend', NULL, '#', 'custom', NULL, '_self', '2024-10-18 23:41:33', NULL),
(4, 1, 'Portfolio', NULL, 'http://127.0.0.1:8000/portfolio', 'custom', NULL, '_self', '2024-10-18 23:41:58', NULL),
(5, 1, 'Contacts', NULL, 'http://127.0.0.1:8000/contacts', 'custom', NULL, '_self', '2024-10-18 23:42:10', NULL),
(8, 1, 'Javascript', NULL, 'javascript', 'category', NULL, '_self', '2024-10-18 23:42:29', NULL),
(9, 1, 'Jquery', NULL, 'jquery', 'category', NULL, '_self', '2024-10-18 23:42:29', NULL),
(10, 1, 'Laravel', NULL, 'laravel', 'category', NULL, '_self', '2024-10-18 23:42:29', NULL),
(11, 1, 'PHP', NULL, 'php', 'category', NULL, '_self', '2024-10-18 23:42:29', NULL),
(12, 1, 'React Js', NULL, 'react-js', 'category', NULL, '_self', '2024-10-18 23:42:29', NULL),
(13, 1, 'Vue Js', NULL, 'vue-js', 'category', NULL, '_self', '2024-10-18 23:42:29', NULL),
(14, 1, 'Business', NULL, 'business', 'department', NULL, '_self', '2024-10-18 23:42:41', NULL),
(15, 1, 'Marketing', NULL, 'marketing', 'department', NULL, '_self', '2024-10-18 23:42:41', NULL),
(16, 1, 'Departments', NULL, '#', 'custom', NULL, '_self', '2024-10-18 23:42:49', NULL),
(18, 1, 'Custom', NULL, '#', 'custom', NULL, '_self', '2024-10-19 01:33:06', NULL),
(25, 1, 'Test', NULL, '#', 'custom', NULL, '_self', '2024-10-19 02:01:17', '2024-10-19 02:01:17'),
(29, 1, 'jQuery কিভাবে কাজ করে?', NULL, 'jquery', 'post', NULL, '_self', '2024-10-19 02:11:01', '2024-10-19 02:11:01');

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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_01_063919_create_users_table', 1),
(6, '2024_06_01_063920_create_modules_table', 1),
(7, '2024_06_01_063931_create_permissions_table', 1),
(8, '2024_06_01_064511_create_permission_user_table', 1),
(10, '2024_06_08_091857_create_categories_table', 1),
(11, '2024_06_08_091858_create_category_post_table', 1),
(12, '2024_09_10_165139_create_our_banks_table', 1),
(13, '2024_09_10_182926_create_faqs_table', 1),
(14, '2024_09_11_162921_create_achievements_table', 1),
(15, '2024_09_11_170240_create_our_partners_table', 1),
(16, '2024_09_11_172128_create_team_languages_table', 1),
(17, '2024_09_11_173218_create_team_specializeds_table', 1),
(19, '2024_09_17_121806_create_access_users_table', 1),
(22, '2024_09_28_105832_create_testimonials_table', 1),
(23, '2024_09_11_172127_create_departments_table', 2),
(24, '2024_09_25_091551_create_menus_table', 2),
(25, '2024_09_25_091615_create_menu_items_table', 2),
(26, '2024_09_30_170457_create_our_team_team_language_table', 2),
(27, '2024_06_08_091856_create_posts_table', 3),
(28, '2024_09_11_174201_create_our_teams_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `ordering`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard Permission', 1, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(2, 'User Permission', 2, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(3, 'Blog Permission', 10, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(4, 'Our Bank Permission', 3, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(5, 'FAQ Permission', 4, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(6, 'Achievement Permission', 5, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(7, 'Our Partner Permission', 6, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(8, 'Department', 7, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(9, 'Team Language Permission', 7, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(10, 'Team Specialized Permission', 8, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(11, 'Our Team Permission', 9, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(12, 'Testimonial Permission', 9, '2024-10-18 23:28:47', '2024-10-18 23:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `our_banks`
--

CREATE TABLE `our_banks` (
  `id` bigint UNSIGNED NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `our_partners`
--

CREATE TABLE `our_partners` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `our_teams`
--

CREATE TABLE `our_teams` (
  `id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `specialized_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languages` json NOT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `meta_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordering` int NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `our_team_team_language`
--

CREATE TABLE `our_team_team_language` (
  `id` bigint UNSIGNED NOT NULL,
  `our_team_id` bigint UNSIGNED NOT NULL,
  `team_language_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `module_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module_id`, `name`, `slug`) VALUES
(1, 1, 'Access', 'dashboard-access'),
(2, 2, 'Access', 'user-access'),
(3, 2, 'Create', 'user-create'),
(4, 2, 'Edit/Update', 'user-edit'),
(5, 2, 'Status', 'user-status'),
(6, 2, 'Delete', 'user-delete'),
(7, 2, 'Bulk Delete', 'user-bulk-delete'),
(8, 2, 'View', 'user-view'),
(9, 3, 'Access', 'blog-access'),
(10, 3, 'Create', 'blog-create'),
(11, 3, 'Edit/Update', 'blog-edit'),
(12, 3, 'Status', 'blog-status'),
(13, 3, 'Delete', 'blog-delete'),
(14, 3, 'Bulk Delete', 'blog-bulk-delete'),
(15, 3, 'View', 'blog-view'),
(16, 4, 'Access', 'our-bank-access'),
(17, 4, 'Create', 'our-bank-create'),
(18, 4, 'Edit/Update', 'our-bank-edit'),
(19, 4, 'Status', 'our-bank-status'),
(20, 4, 'Delete', 'our-bank-delete'),
(21, 4, 'Bulk Delete', 'our-bank-bulk-delete'),
(22, 5, 'Access', 'faq-access'),
(23, 5, 'Create', 'faq-create'),
(24, 5, 'Edit/Update', 'faq-edit'),
(25, 5, 'Status', 'faq-status'),
(26, 5, 'Delete', 'faq-delete'),
(27, 5, 'Bulk Delete', 'faq-bulk-delete'),
(28, 6, 'Access', 'achievement-access'),
(29, 6, 'Create', 'achievement-create'),
(30, 6, 'Edit/Update', 'achievement-edit'),
(31, 6, 'Status', 'achievement-status'),
(32, 6, 'Delete', 'achievement-delete'),
(33, 6, 'Bulk Delete', 'achievement-bulk-delete'),
(34, 7, 'Access', 'our-partner-access'),
(35, 7, 'Create', 'our-partner-create'),
(36, 7, 'Edit/Update', 'our-partner-edit'),
(37, 7, 'Status', 'our-partner-status'),
(38, 7, 'Delete', 'our-partner-delete'),
(39, 7, 'Bulk Delete', 'our-partner-bulk-delete'),
(40, 8, 'Access', 'department-access'),
(41, 8, 'Create', 'department-create'),
(42, 8, 'Edit/Update', 'department-edit'),
(43, 8, 'Status', 'department-status'),
(44, 8, 'Delete', 'department-delete'),
(45, 8, 'Bulk Delete', 'department-bulk-delete'),
(46, 9, 'Access', 'team-language-access'),
(47, 9, 'Create', 'team-language-create'),
(48, 9, 'Edit/Update', 'team-language-edit'),
(49, 9, 'Status', 'team-language-status'),
(50, 9, 'Delete', 'team-language-delete'),
(51, 9, 'Bulk Delete', 'team-language-bulk-delete'),
(52, 10, 'Access', 'team-specialized-access'),
(53, 10, 'Create', 'team-specialized-create'),
(54, 10, 'Edit/Update', 'team-specialized-edit'),
(55, 10, 'Status', 'team-specialized-status'),
(56, 10, 'Delete', 'team-specialized-delete'),
(57, 10, 'Bulk Delete', 'team-specialized-bulk-delete'),
(58, 11, 'Access', 'our-team-access'),
(59, 11, 'Create', 'our-team-create'),
(60, 11, 'Edit/Update', 'our-team-edit'),
(61, 11, 'Status', 'our-team-status'),
(62, 11, 'Delete', 'our-team-delete'),
(63, 11, 'Bulk Delete', 'our-team-bulk-delete'),
(64, 11, 'View', 'our-team-view'),
(65, 12, 'Access', 'testimonial-access'),
(66, 12, 'Create', 'testimonial-create'),
(67, 12, 'Edit/Update', 'testimonial-edit'),
(68, 12, 'Status', 'testimonial-status'),
(69, 12, 'Delete', 'testimonial-delete'),
(70, 12, 'Bulk Delete', 'testimonial-bulk-delete');

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_user`
--

INSERT INTO `permission_user` (`id`, `user_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 1, 34),
(35, 1, 35),
(36, 1, 36),
(37, 1, 37),
(38, 1, 38),
(39, 1, 39),
(40, 1, 40),
(41, 1, 41),
(42, 1, 42),
(43, 1, 43),
(44, 1, 44),
(45, 1, 45),
(46, 1, 46),
(47, 1, 47),
(48, 1, 48),
(49, 1, 49),
(50, 1, 50),
(51, 1, 51),
(52, 1, 52),
(53, 1, 53),
(54, 1, 54),
(55, 1, 55),
(56, 1, 56),
(57, 1, 57),
(58, 1, 58),
(59, 1, 59),
(60, 1, 60),
(61, 1, 61),
(62, 1, 62),
(63, 1, 63),
(64, 1, 64),
(65, 1, 65),
(66, 1, 66),
(67, 1, 67),
(68, 1, 68),
(69, 1, 69),
(70, 1, 70),
(71, 2, 1),
(72, 2, 2),
(73, 2, 3),
(74, 2, 4),
(75, 2, 5),
(76, 2, 6),
(77, 2, 7),
(78, 2, 8),
(79, 2, 9),
(80, 2, 10),
(81, 2, 11),
(82, 2, 12),
(83, 2, 13),
(84, 2, 14),
(85, 2, 15),
(86, 2, 16),
(87, 2, 17),
(88, 2, 18),
(89, 2, 19),
(90, 2, 20),
(91, 2, 21),
(92, 2, 22),
(93, 2, 23),
(94, 2, 24),
(95, 2, 25),
(96, 2, 26),
(97, 2, 27),
(98, 2, 28),
(99, 2, 29),
(100, 2, 30),
(101, 2, 31),
(102, 2, 32),
(103, 2, 33),
(104, 2, 34),
(105, 2, 35),
(106, 2, 36),
(107, 2, 37),
(108, 2, 38),
(109, 2, 39),
(110, 2, 40),
(111, 2, 41),
(112, 2, 42),
(113, 2, 43),
(114, 2, 44),
(115, 2, 45),
(116, 2, 46),
(117, 2, 47),
(118, 2, 48),
(119, 2, 49),
(120, 2, 50),
(121, 2, 51),
(122, 2, 52),
(123, 2, 53),
(124, 2, 54),
(125, 2, 55),
(126, 2, 56),
(127, 2, 57),
(128, 2, 58),
(129, 2, 59),
(130, 2, 60),
(131, 2, 61),
(132, 2, 62),
(133, 2, 63),
(134, 2, 64),
(135, 2, 65),
(136, 2, 66),
(137, 2, 67),
(138, 2, 68),
(139, 2, 69),
(140, 2, 70);

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

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Published, 2 = Draft, 3 = Pending',
  `visibility` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Public, 2 = Private',
  `published_date` date NOT NULL,
  `meta_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `slug`, `short_description`, `description`, `feature_image`, `alt_text`, `status`, `visibility`, `published_date`, `meta_title`, `meta_description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ajax কিভাবে কাজ করে?', 'ajax', 'Ajax কোন একটি server এর সাথে XMLHttpRequest নামে একটি object এর মাধ্যমে যোগাযোগ করে থাকে। তাহলে চলুন একটি চিত্রের মাধ্যমে আমরা দেখে আসি যে, যখন আমরা কোন একটি Ajax request পাঠাই তখন Ajax request টি কিভাবে কাজ করে', '১। প্রথমেই Web Browser দিয়ে একটি request পাঠানো হয় তারপর XMLHttpRequest নামক একটি object তৈরী হয় javascript call এর মাধ্যমে।\r\n২। তারপর XMLHttpRequest object এর মাধ্যমে server এর কাছে HTTP Request পাঠানো হয়।\r\n৩। এরপর server আপনার database এর সাথে যোগাযোগ করে যে কি Data সে নিয়ে আসবে। এই যোগাযোগটি মূলত JSP, PHP, Servlet, ASP.net ইত্যাদি Programing Lanuage এর মাধ্যমে করা হয়ে থাকে।\r\n৪। এরপর সেই Data গুলো গ্রহণ করা হয়।\r\n৫। এরপর Server এই Data গুলোকে XML অথবা JSON Data আকরে XMLHttpRequest এর callback function মধ্যে পাঠায়।\r\n৬। সবশেষ আপনার Web Browser ঐ Data গুলো প্রদর্শিত হয়।\r\n\r\nকোথায় Ajax ব্যবহার করব?\r\nAjax আপনি বিভিন্ন জায়গায় আপনার প্রয়োজন মত ব্যবহার করতে পারেন তবে সাধারনত কোথায় কোথায় ব্যবহার করা হয় চলুন তা দেখে আসি। তবে মানে রাখবেন নিম্নোক্ত সব ব্যবহার গুলোই সম্পূর্ণ Web Page টি লোড ছাড়াই সম্পন্ন হয়-\r\n১। কোন একটি HTML FORM Validation এর জন্য আপনি Ajax ব্যবহার করতে পারেন।\r\n২। আপনি চাচ্ছেন যে FORM এর মধ্যে username নামে যে Input Field টি রয়েছে তার Value টি Database এ Record গুলোর সাথে Check করবেন যে এই Value টি Unique কি না?\r\n৩। কোন একটি FORM এর Content আপনার Database এ Insert বা নিয়ে আসার জন্য ব্যবহার করতে পারেন।\r\n৪। কোন একটি Button এ Click করে আপনি চাচ্ছেন যে Database থেকে সব Data নিয়ে আসবেন। Ajax এর মাধ্যমে আপনি সহজেই তা করতে পারবেন।\r\n৫। বর্তমানে আমরা যে Gmail ব্যবহার করি তা কিন্তু Ajax এর মাধ্যমেই Data গুলোকে আদান প্রদান করা হয়েছে।\r\n৬। আমরা যে Google Map দেখে থাকি তাও এই Ajax এর মাধ্যমে দেখানো হয়।\r\n৭। এছাড়া আরো অনেক কিছু… আশা করি মোটামুটি একটি ধারনা হয়েছে যে Ajax দিয়ে কি করা যায়, তাই না? 🙂\r\n\r\nAjax কি দিয়ে তৈরী করা হয়েছে?\r\nআমরা জানি যে Ajax কিন্তু একটি Programing Language না বরং কতগুলো technology এর দ্বারা Ajax তৈরী করা হয়েছে বা কাজ করে। যেমন- HTML/XHTML and CSS, DOM, XML অথবা JSON, XMLHttpRequest এবং JavaScript। চলুন এই প্রত্যেকটি technology সম্পর্কে কিছু ধারনা নিয়ে আসি –\r\n১। HTML/XHTML and CSS\r\nHTML/XHTML এর কাজ হলো কোন একটি Website এর Layout কে বানানো এবং CSS এর কাজ হলো সেই Layout কে নিজের মত করে বিভিন্ন Design করা। মূলত Website এর presentation এর জন্য এই HTML/XHTML এবং CSS ব্যবহার করা হয়।\r\n২। DOM\r\nDynamically কোন data দেখানো বা data এর সাথে যোগাযোগ করার জন্য এই DOM ব্যবহার করা হয়। DOM এর অর্থ হলো – Document Object Model.\r\n৩। XML or JSON\r\nXML মূলত data কে server এর সাথে আদান প্রদানের জন্য ব্যবহার করা হয়। JSON অর্থ হলো Javascript Object Notation এবং এটি XML এরই মত কিন্তু XML এর চেয়ে অনেক দ্রুত কাজ করে।\r\n৪। XMLHttpRequest\r\nXMLHttpRequest হলো JavaScript এর একটি object যা client এবং server এর সাথে asynchronous ভাবে যোাগাযোগ করার জন্য ব্যবহার করা হয়।\r\n৫। JavaScript\r\nClient-side সম্পর্কিত কাজ করার জন্য এই Language ব্যবহার করা হয়।\r\n\r\n\r\nXMLHttpRequest সম্পর্কে ধারণা\r\nXMLHttpRequest হলো JavaScript এর একটি Object যা client এবং server এর সাথে asynchronous ভাবে যোগাযোগ করার জন্য ব্যবহার করা হয়।\r\nমুলত ৩ টি কাজ করে থাকে এই Object টি আর তা হলো –\r\n১। Browser বা Client থেকে data পাঠায়।\r\n২। Server থেকে data গ্রহণ করে।\r\n৩। কোন প্রকার Website রিলোড ছাড়াই webpage এর content update করে।\r\nপ্রত্যেকটি Object এর মতো XMLHttpRequest Object এর কিছু Properties এবং methods রয়েছে।\r\n\r\nচলুন XMLHttpRequest Object এর কিছু গুরুত্বপূর্ণ Properties দেখে আসি-\r\n১। onReadyStateChange\r\n২। readyState\r\n৩। reponseText\r\n৪। responseXML\r\n১। onReadyStateChange\r\nreadystate নামে যে attribute রয়েছে তা যখন পরিবর্তন হয় তখন এই onReadyStateChange Proerpty টিকে call করা হয়।\r\n২। readyState\r\nযে request টি পাঠানো হয়েছে তার বর্তমান কি অবস্থা তা এই readyState Proerpty মাধ্যমে জানা যায়। এই Proerpty এর return value সাধারনত 0(Zero) থেকে 4(Four) এই ৫ ধরনরে হয়ে থাকে। যেমন-\r\n0 মানে হলো request টি এখনো শুরু হয়নি।\r\n1 মানে হলো request টি পাঠানোর জন্য এখন সম্পূর্ণ প্রস্তুত।\r\n2 মানে হলো request টি পাঠানো সম্পন্ন হয়েছে।\r\n3 মানে হলো request টি এখানো প্রক্রিয়াধীন রয়েছে।\r\n4 মানে হলো request টি সম্পন্ন হয়েছে।\r\n৩। reponseText\r\nRequest সম্পন্ন হওয়ার পর Result টি Text আকারে আসবে।\r\n৪। responseXML\r\nRequest সম্পন্ন হওয়ার পর Result টি XML আকারে আসবে।\r\n\r\nএবার চলুন XMLHttpRequest Object এর কিছু গুরুত্বপূর্ণ Methods দেখে আসি-\r\n১। open(method, URL, async, username, password)\r\n২। send()\r\n৩। send(string)\r\n৪। setRequestHeader(header,value)\r\n১। open()\r\nএই open() method এর মাধ্যমে Web Server এর সাথে connection করা হয়। এই method কে আপনি ৩ ভাবে call করতে পারেন –\r\n    ১) open(method, URL)\r\n    ২) open(method, URL, async)\r\n    ৩) open(method, URL, async, username, password)\r\nউপরের open() method এ আপনি চাইলে ২টি বা ৩টি আবার ৫ টি parameters সহ ব্যবহার করতে পারেন। তবে সর্বনিম্ন আপনাকে ২টি parameters অব্যশই ব্যবহার করতে হবে। চলুন এই ৫ টি parameters সম্পর্কে একটু জেনে আসি-\r\nmethod = কোন method এ আপনি Data পাঠাবেন মানে POST নাকি GET method এ।\r\nURL = কোন URL এ request টি পাঠাবেন।\r\nasync =  যদি true দিয়ে আসেন তাহলে Asynchronous ভাবে data transfer হবে এবং যদি false দিয়ে আসেন তাহলে Synchronous ভাবে data transfer হবে।\r\nusername = authentication এর জন্য আপনি চাইলে username ব্যবহার করতে পারেন।\r\npassword = authentication এর জন্য আপনি চাইলে password ব্যবহার করতে পারেন।\r\n২। send()\r\nএই send Method এর মাধ্যমে server এর Request পাঠানো হয়। এখন আপনি যদি Request টি GET Method এর মাধ্যমে পাঠাতে চান তাহলে এই Method টি ব্যবহার পারেন। তবে এ ক্ষেত্রে কোন parameter লাগবে না।\r\n৩। send(string)\r\nআপনি যদি Request টি POST Method এর মাধ্যমে পাঠাতে চান তাহলে তাহলে এই Method টি ব্যবহার পারেন। এ ক্ষেত্রে parameter দিয়ে আসতে হবে।\r\n৪। setRequestHeader(header,value)\r\nHTTP request header এর জন্য যদি কোন value ঠিক করতে চান তাহলে এই Method টি ব্যবহার করতে হবে। তবে মনে রাখবেন এই Method টি অবশ্যই open() Method কল করার পর এবং send() Method কল করার আগে ব্যবহার করতে হবে।', 'WhatsApp-Image-2024-08-17-at-09.27.43_1bc2f864-941030.jpg', 'Ajax কিভাবে কাজ করে?', '1', '1', '2024-10-19', 'Ajax কিভাবে কাজ করে?', 'Ajax কিভাবে কাজ করে?', 'Sujon Mia', NULL, '2024-10-18 23:23:14', '2024-10-18 23:23:14'),
(2, 1, 'jQuery কিভাবে কাজ করে?', 'jquery', 'Ajax কোন একটি server এর সাথে XMLHttpRequest নামে একটি object এর মাধ্যমে যোগাযোগ করে থাকে। তাহলে চলুন একটি চিত্রের মাধ্যমে আমরা দেখে আসি যে, যখন আমরা কোন একটি Ajax request পাঠাই তখন Ajax request টি কিভাবে কাজ করে', '১। প্রথমেই Web Browser দিয়ে একটি request পাঠানো হয় তারপর XMLHttpRequest নামক একটি object তৈরী হয় javascript call এর মাধ্যমে।\r\n২। তারপর XMLHttpRequest object এর মাধ্যমে server এর কাছে HTTP Request পাঠানো হয়।\r\n৩। এরপর server আপনার database এর সাথে যোগাযোগ করে যে কি Data সে নিয়ে আসবে। এই যোগাযোগটি মূলত JSP, PHP, Servlet, ASP.net ইত্যাদি Programing Lanuage এর মাধ্যমে করা হয়ে থাকে।\r\n৪। এরপর সেই Data গুলো গ্রহণ করা হয়।\r\n৫। এরপর Server এই Data গুলোকে XML অথবা JSON Data আকরে XMLHttpRequest এর callback function মধ্যে পাঠায়।\r\n৬। সবশেষ আপনার Web Browser ঐ Data গুলো প্রদর্শিত হয়।\r\n\r\nকোথায় Ajax ব্যবহার করব?\r\nAjax আপনি বিভিন্ন জায়গায় আপনার প্রয়োজন মত ব্যবহার করতে পারেন তবে সাধারনত কোথায় কোথায় ব্যবহার করা হয় চলুন তা দেখে আসি। তবে মানে রাখবেন নিম্নোক্ত সব ব্যবহার গুলোই সম্পূর্ণ Web Page টি লোড ছাড়াই সম্পন্ন হয়-\r\n১। কোন একটি HTML FORM Validation এর জন্য আপনি Ajax ব্যবহার করতে পারেন।\r\n২। আপনি চাচ্ছেন যে FORM এর মধ্যে username নামে যে Input Field টি রয়েছে তার Value টি Database এ Record গুলোর সাথে Check করবেন যে এই Value টি Unique কি না?\r\n৩। কোন একটি FORM এর Content আপনার Database এ Insert বা নিয়ে আসার জন্য ব্যবহার করতে পারেন।\r\n৪। কোন একটি Button এ Click করে আপনি চাচ্ছেন যে Database থেকে সব Data নিয়ে আসবেন। Ajax এর মাধ্যমে আপনি সহজেই তা করতে পারবেন।\r\n৫। বর্তমানে আমরা যে Gmail ব্যবহার করি তা কিন্তু Ajax এর মাধ্যমেই Data গুলোকে আদান প্রদান করা হয়েছে।\r\n৬। আমরা যে Google Map দেখে থাকি তাও এই Ajax এর মাধ্যমে দেখানো হয়।\r\n৭। এছাড়া আরো অনেক কিছু… আশা করি মোটামুটি একটি ধারনা হয়েছে যে Ajax দিয়ে কি করা যায়, তাই না? 🙂\r\n\r\nAjax কি দিয়ে তৈরী করা হয়েছে?\r\nআমরা জানি যে Ajax কিন্তু একটি Programing Language না বরং কতগুলো technology এর দ্বারা Ajax তৈরী করা হয়েছে বা কাজ করে। যেমন- HTML/XHTML and CSS, DOM, XML অথবা JSON, XMLHttpRequest এবং JavaScript। চলুন এই প্রত্যেকটি technology সম্পর্কে কিছু ধারনা নিয়ে আসি –\r\n১। HTML/XHTML and CSS\r\nHTML/XHTML এর কাজ হলো কোন একটি Website এর Layout কে বানানো এবং CSS এর কাজ হলো সেই Layout কে নিজের মত করে বিভিন্ন Design করা। মূলত Website এর presentation এর জন্য এই HTML/XHTML এবং CSS ব্যবহার করা হয়।\r\n২। DOM\r\nDynamically কোন data দেখানো বা data এর সাথে যোগাযোগ করার জন্য এই DOM ব্যবহার করা হয়। DOM এর অর্থ হলো – Document Object Model.\r\n৩। XML or JSON\r\nXML মূলত data কে server এর সাথে আদান প্রদানের জন্য ব্যবহার করা হয়। JSON অর্থ হলো Javascript Object Notation এবং এটি XML এরই মত কিন্তু XML এর চেয়ে অনেক দ্রুত কাজ করে।\r\n৪। XMLHttpRequest\r\nXMLHttpRequest হলো JavaScript এর একটি object যা client এবং server এর সাথে asynchronous ভাবে যোাগাযোগ করার জন্য ব্যবহার করা হয়।\r\n৫। JavaScript\r\nClient-side সম্পর্কিত কাজ করার জন্য এই Language ব্যবহার করা হয়।\r\n\r\n\r\nXMLHttpRequest সম্পর্কে ধারণা\r\nXMLHttpRequest হলো JavaScript এর একটি Object যা client এবং server এর সাথে asynchronous ভাবে যোগাযোগ করার জন্য ব্যবহার করা হয়।\r\nমুলত ৩ টি কাজ করে থাকে এই Object টি আর তা হলো –\r\n১। Browser বা Client থেকে data পাঠায়।\r\n২। Server থেকে data গ্রহণ করে।\r\n৩। কোন প্রকার Website রিলোড ছাড়াই webpage এর content update করে।\r\nপ্রত্যেকটি Object এর মতো XMLHttpRequest Object এর কিছু Properties এবং methods রয়েছে।\r\n\r\nচলুন XMLHttpRequest Object এর কিছু গুরুত্বপূর্ণ Properties দেখে আসি-\r\n১। onReadyStateChange\r\n২। readyState\r\n৩। reponseText\r\n৪। responseXML\r\n১। onReadyStateChange\r\nreadystate নামে যে attribute রয়েছে তা যখন পরিবর্তন হয় তখন এই onReadyStateChange Proerpty টিকে call করা হয়।\r\n২। readyState\r\nযে request টি পাঠানো হয়েছে তার বর্তমান কি অবস্থা তা এই readyState Proerpty মাধ্যমে জানা যায়। এই Proerpty এর return value সাধারনত 0(Zero) থেকে 4(Four) এই ৫ ধরনরে হয়ে থাকে। যেমন-\r\n0 মানে হলো request টি এখনো শুরু হয়নি।\r\n1 মানে হলো request টি পাঠানোর জন্য এখন সম্পূর্ণ প্রস্তুত।\r\n2 মানে হলো request টি পাঠানো সম্পন্ন হয়েছে।\r\n3 মানে হলো request টি এখানো প্রক্রিয়াধীন রয়েছে।\r\n4 মানে হলো request টি সম্পন্ন হয়েছে।\r\n৩। reponseText\r\nRequest সম্পন্ন হওয়ার পর Result টি Text আকারে আসবে।\r\n৪। responseXML\r\nRequest সম্পন্ন হওয়ার পর Result টি XML আকারে আসবে।\r\n\r\nএবার চলুন XMLHttpRequest Object এর কিছু গুরুত্বপূর্ণ Methods দেখে আসি-\r\n১। open(method, URL, async, username, password)\r\n২। send()\r\n৩। send(string)\r\n৪। setRequestHeader(header,value)\r\n১। open()\r\nএই open() method এর মাধ্যমে Web Server এর সাথে connection করা হয়। এই method কে আপনি ৩ ভাবে call করতে পারেন –\r\n    ১) open(method, URL)\r\n    ২) open(method, URL, async)\r\n    ৩) open(method, URL, async, username, password)\r\nউপরের open() method এ আপনি চাইলে ২টি বা ৩টি আবার ৫ টি parameters সহ ব্যবহার করতে পারেন। তবে সর্বনিম্ন আপনাকে ২টি parameters অব্যশই ব্যবহার করতে হবে। চলুন এই ৫ টি parameters সম্পর্কে একটু জেনে আসি-\r\nmethod = কোন method এ আপনি Data পাঠাবেন মানে POST নাকি GET method এ।\r\nURL = কোন URL এ request টি পাঠাবেন।\r\nasync =  যদি true দিয়ে আসেন তাহলে Asynchronous ভাবে data transfer হবে এবং যদি false দিয়ে আসেন তাহলে Synchronous ভাবে data transfer হবে।\r\nusername = authentication এর জন্য আপনি চাইলে username ব্যবহার করতে পারেন।\r\npassword = authentication এর জন্য আপনি চাইলে password ব্যবহার করতে পারেন।\r\n২। send()\r\nএই send Method এর মাধ্যমে server এর Request পাঠানো হয়। এখন আপনি যদি Request টি GET Method এর মাধ্যমে পাঠাতে চান তাহলে এই Method টি ব্যবহার পারেন। তবে এ ক্ষেত্রে কোন parameter লাগবে না।\r\n৩। send(string)\r\nআপনি যদি Request টি POST Method এর মাধ্যমে পাঠাতে চান তাহলে তাহলে এই Method টি ব্যবহার পারেন। এ ক্ষেত্রে parameter দিয়ে আসতে হবে।\r\n৪। setRequestHeader(header,value)\r\nHTTP request header এর জন্য যদি কোন value ঠিক করতে চান তাহলে এই Method টি ব্যবহার করতে হবে। তবে মনে রাখবেন এই Method টি অবশ্যই open() Method কল করার পর এবং send() Method কল করার আগে ব্যবহার করতে হবে।', 'WhatsApp-Image-2024-08-17-at-09.27.43_1bc2f864-941030.jpg', 'Ajax কিভাবে কাজ করে?', '1', '1', '2024-10-19', 'Ajax কিভাবে কাজ করে?', 'Ajax কিভাবে কাজ করে?', 'Sujon Mia', NULL, '2024-10-18 23:23:14', '2024-10-18 23:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `team_languages`
--

CREATE TABLE `team_languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_specializeds`
--

CREATE TABLE `team_specializeds` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 = Gender, 2 = Male',
  `is_active` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 = Active, 2 = Disabled',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `mobile_no`, `gender`, `is_active`, `created_by`, `updated_by`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sujon Mia', 'super@gmail.com', NULL, '$2y$12$EmuYuUbOotC/aQJoagnY7eTlduL1B/37qcxjRDF2kA3bheqOGy3ne', NULL, '01743776488', '1', '1', 'Sujon Mia', NULL, NULL, NULL, '2024-10-18 23:28:47', '2024-10-18 23:28:47'),
(2, 'Admin', 'admin@gmail.com', NULL, '$2y$12$kSUbBB2MBfD0651cOfqXY.IL4AF9FUj3sd2wktXHkzfSFnQ8GQ.lm', NULL, '01602603147', '1', '1', 'Sujon Mia', NULL, NULL, NULL, '2024-10-18 23:28:48', '2024-10-18 23:28:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_users`
--
ALTER TABLE `access_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_users_email_unique` (`email`);

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `category_post`
--
ALTER TABLE `category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_post_post_id_foreign` (`post_id`),
  ADD KEY `category_post_category_id_foreign` (`category_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_name_unique` (`name`);

--
-- Indexes for table `our_banks`
--
ALTER TABLE `our_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_partners`
--
ALTER TABLE `our_partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_teams`
--
ALTER TABLE `our_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `our_teams_department_id_foreign` (`department_id`),
  ADD KEY `our_teams_specialized_id_foreign` (`specialized_id`);

--
-- Indexes for table `our_team_team_language`
--
ALTER TABLE `our_team_team_language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `our_team_team_language_our_team_id_foreign` (`our_team_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_user_id_foreign` (`user_id`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `team_languages`
--
ALTER TABLE `team_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_specializeds`
--
ALTER TABLE `team_specializeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
-- AUTO_INCREMENT for table `access_users`
--
ALTER TABLE `access_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category_post`
--
ALTER TABLE `category_post`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `our_banks`
--
ALTER TABLE `our_banks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_partners`
--
ALTER TABLE `our_partners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_teams`
--
ALTER TABLE `our_teams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_team_team_language`
--
ALTER TABLE `our_team_team_language`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `permission_user`
--
ALTER TABLE `permission_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team_languages`
--
ALTER TABLE `team_languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_specializeds`
--
ALTER TABLE `team_specializeds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_post`
--
ALTER TABLE `category_post`
  ADD CONSTRAINT `category_post_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `our_teams`
--
ALTER TABLE `our_teams`
  ADD CONSTRAINT `our_teams_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `our_teams_specialized_id_foreign` FOREIGN KEY (`specialized_id`) REFERENCES `team_specializeds` (`id`);

--
-- Constraints for table `our_team_team_language`
--
ALTER TABLE `our_team_team_language`
  ADD CONSTRAINT `our_team_team_language_our_team_id_foreign` FOREIGN KEY (`our_team_id`) REFERENCES `our_teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
