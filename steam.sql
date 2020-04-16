-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2017 at 11:40 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `steam`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `intro` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `intro`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'cars', '0', 'cars', 'cars', '2017-09-20 06:31:34', '2017-09-20 06:31:34'),
(2, 'properties', '0', 'properties', 'properties', '2017-09-20 06:32:08', '2017-09-20 06:32:08'),
(3, 'repair', '1', 'repair', 'repair', '2017-09-20 06:32:33', '2017-09-20 06:32:33'),
(4, 'cooking', '1', 'hello intro', 'faawesome', '2017-09-23 09:55:56', '2017-09-23 09:55:56'),
(7, 'Developing apps', '2', 'this is intro of category', 'fontIcon', '2017-09-23 21:23:55', '2017-09-23 21:23:55'),
(8, 'web developer', '2', 'this is intro', 'iconfont', '2017-09-24 15:07:15', '2017-09-24 15:07:15'),
(9, 'Marketing', '2', 'tHIS IS iNTRO', 'IconFont', '2017-09-24 15:16:10', '2017-09-24 15:16:10'),
(11, 'mr code test category', '0', 'this intro', 'flag', '2017-09-24 20:59:54', '2017-09-28 19:09:26'),
(12, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:55', '2017-09-24 20:59:55'),
(13, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:55', '2017-09-24 20:59:55'),
(14, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:55', '2017-09-24 20:59:55'),
(15, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:56', '2017-09-24 20:59:56'),
(16, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:56', '2017-09-24 20:59:56'),
(17, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:56', '2017-09-24 20:59:56'),
(18, 'ss', '3', 'sss', 'ss', '2017-09-24 20:59:56', '2017-09-24 20:59:56'),
(19, 'sss', '3', 'sss', 'sss', '2017-09-24 21:00:45', '2017-09-24 21:00:45'),
(20, 'hello', '0', 'No', 'he', '2017-09-24 21:01:21', '2017-09-24 21:01:21'),
(21, 'Hello', '4', 'Noway', 'sjksk', '2017-09-24 21:06:21', '2017-09-24 21:06:21'),
(22, 'Web Design', '9', 'This is Intro', 'FontAwesome', '2017-09-24 21:07:58', '2017-09-24 21:07:58'),
(23, 'SEO', '3', 'This is intro', 'fontIcon', '2017-09-24 22:30:22', '2017-09-24 22:30:22'),
(24, 'Logo Design', '3', 'This is intro', 'linIcons', '2017-09-25 00:11:39', '2017-09-25 00:11:39'),
(25, 'Blogging', '2', 'this is new intro', 'fontAwesome', '2017-09-25 14:57:34', '2017-09-25 14:57:34'),
(26, 'mr code test category', '0', NULL, 'flag', '2017-09-25 19:03:49', '2017-09-25 19:03:49'),
(27, 'mr code test category', '0', NULL, 'flag', '2017-09-28 19:21:19', '2017-09-28 19:21:19'),
(28, 'mr code test category', '0', NULL, 'flag', '2017-09-28 20:55:48', '2017-09-28 20:55:48'),
(29, 'adasdasdasdasd12345', '0', NULL, NULL, '2017-10-01 16:50:00', '2017-10-01 16:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `favourits`
--

CREATE TABLE `favourits` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `service_id`, `city`, `area`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'cairo', '2017-09-20 06:32:51', '2017-09-20 06:32:51'),
(2, 1, NULL, 'alex', '2017-09-20 06:32:51', '2017-09-20 06:32:51'),
(7, 4, 'CAIROO', 'cairo', '2017-09-20 06:43:20', '2017-09-20 06:43:20'),
(8, 4, 'ALEEX', 'alex', '2017-09-20 06:43:20', '2017-09-20 06:43:20'),
(9, 5, 'CAIROO', 'cairo', '2017-09-20 06:50:17', '2017-09-20 06:50:17'),
(11, 5, 'none', 'none', '2017-09-20 06:50:17', '2017-09-20 06:50:17'),
(12, 6, 'maadi', 'cairo', '2017-09-20 06:53:44', '2017-09-20 06:53:44'),
(13, 6, 'manshia', 'alex', '2017-09-20 06:53:44', '2017-09-20 06:53:44'),
(14, 6, 'none', 'none', '2017-09-20 06:53:44', '2017-09-20 06:53:44'),
(15, 7, 'maadi', 'cairo', '2017-09-20 06:55:52', '2017-09-20 06:55:52'),
(16, 7, 'manshia', 'alex', '2017-09-20 06:55:52', '2017-09-20 06:55:52'),
(17, 8, 'maadi', 'cairo', '2017-09-20 08:11:35', '2017-09-20 08:11:35'),
(18, 8, 'manshia', 'alex', '2017-09-20 08:11:35', '2017-09-20 08:11:35'),
(19, 9, 'maadi', 'cairo', '2017-09-20 08:16:18', '2017-09-20 08:16:18'),
(20, 9, 'manshia', 'alex', '2017-09-20 08:16:18', '2017-09-20 08:16:18'),
(21, 10, 'Menofia', 'maisa', '2017-09-20 08:19:22', '2017-09-20 10:41:05'),
(22, 10, 'esmaillia', 'samia', '2017-09-20 08:19:22', '2017-09-20 10:41:05'),
(23, 12, 'asdasdsadds', 'asdasdsad', '2017-09-21 22:54:42', '2017-09-21 22:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2017_09_18_101959_create_requests_table', 1),
(9, '2017_09_18_102251_create_messages_table', 1),
(10, '2017_09_18_102550_create_favourits_table', 1),
(11, '2017_09_18_102658_create_reviews_table', 1),
(12, '2017_09_18_102750_create_categories_table', 1),
(13, '2017_09_18_101910_create_services_table', 2),
(14, '2017_09_18_102138_create_servicePics_table', 2),
(15, '2017_09_18_102337_create_locations_table', 2),
(16, '2017_09_18_102448_create_serviceLocs_table', 2),
(17, '2017_09_18_112454_create_serviceVeds_table', 2),
(18, '2017_10_08_084637_entrust_setup_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'roleController-getRoles', 'getRoles', NULL, '2017-10-08 13:44:59', '2017-10-08 13:44:59'),
(2, 'PermtionsController-allPermissions', 'allPermissions', NULL, '2017-10-08 13:45:03', '2017-10-08 13:45:03'),
(3, 'PermissionsController-allPermissions', 'allPermissions', NULL, '2017-10-08 13:51:19', '2017-10-08 13:51:19'),
(4, 'PermissionsController-addPermissionsRole', 'addPermissionsRole', NULL, '2017-10-08 14:11:22', '2017-10-08 14:11:22'),
(5, 'PermissionsController-getRolePermissions', 'getRolePermissions', NULL, '2017-10-08 14:15:51', '2017-10-08 14:15:51'),
(6, 'PermissionsController-allPermissionsFor', 'allPermissionsFor', NULL, '2017-10-09 09:14:42', '2017-10-09 09:14:42'),
(7, 'UsersController-registration', 'registration', NULL, '2017-10-09 10:28:40', '2017-10-09 10:28:40'),
(8, 'roleController-addRole', 'addRole', NULL, '2017-10-09 12:22:25', '2017-10-09 12:22:25'),
(9, 'HomeController-index', 'index', NULL, '2017-10-09 14:21:01', '2017-10-09 14:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`, `delete`) VALUES
(1, 'admin', 'Admin', 'admin role', '2017-10-08 08:15:43', '2017-10-08 08:15:43', 0),
(2, 'clubAdmin', 'Club Admin', 'Club Admin role', '2017-10-08 08:25:19', '2017-10-08 12:47:53', 0),
(3, 'clubMember', 'Club Member', 'Club Member role', '2017-10-08 08:25:19', '2017-10-08 12:47:53', 0),
(4, 'anyone', 'Anyone', 'anyone role', '2017-10-09 12:25:05', '2017-10-09 12:25:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 4),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 1),
(9, 3),
(10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `servicelocs`
--

CREATE TABLE `servicelocs` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicepics`
--

CREATE TABLE `servicepics` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servicepics`
--

INSERT INTO `servicepics` (`id`, `service_id`, `filename`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 46, 'serviceportofilo/Ez8a1bmKDq7GhLLk3KarYNxmkvU34tWi1gLluJpA.jpeg', NULL, '2017-09-24 22:36:36', '2017-09-24 22:36:36'),
(2, 46, 'serviceportofilo/OtEzAIbpnKTEvz0RuD1hfC27Wmn1sjuqhKOEjrM7.jpeg', NULL, '2017-09-24 22:36:36', '2017-09-24 22:36:36'),
(3, 52, 'serviceportofilo/5Mm1fiXVt8VS8rw7T6VKxcOqdn6KTBPwSsEqHsGj.jpeg', NULL, '2017-09-25 18:28:05', '2017-09-25 18:28:05'),
(5, 59, 'serviceportofilo/GcyxUyjiFsmiZQwJJwBRt2KIqMeLRWkgSTr9ZD6l.jpeg', NULL, '2017-09-28 20:48:56', '2017-09-28 20:48:56'),
(6, 59, 'serviceportofilo/7Pz53nkLVTy1HeoFt4kNxp7nfsnO7QOV5C9eJ8fm.jpeg', NULL, '2017-09-28 20:48:56', '2017-09-28 20:48:56'),
(7, 60, 'serviceportofilo/bVJlnCJDH6zZkh3l2sETMuGhpHmwbn4QIPqAZlti.jpeg', NULL, '2017-09-28 20:49:09', '2017-09-28 20:49:09'),
(8, 60, 'serviceportofilo/8ZlobSDJgnboniqtrc7IUOfUhqNpNZhTXW8mLk7t.jpeg', NULL, '2017-09-28 20:49:09', '2017-09-28 20:49:09'),
(9, 61, 'serviceportofilo/v4MK4yhBpY4Tfxg4iN98Bt0InngbAkx10Lzs5oMa.jpeg', NULL, '2017-09-28 20:53:33', '2017-09-28 20:53:33'),
(10, 65, 'serviceportofilo/Pd12qBX7YeVMD7TqbHTIDjBNBe3Aj66fLI1kvdoM.jpeg', NULL, '2017-09-28 21:01:09', '2017-09-28 21:01:09'),
(11, 83, NULL, NULL, '2017-10-03 09:29:59', '2017-10-03 09:29:59'),
(12, 84, NULL, NULL, '2017-10-03 09:32:28', '2017-10-03 09:32:28'),
(13, 85, NULL, NULL, '2017-10-03 09:32:34', '2017-10-03 09:32:34'),
(14, 86, 'serviceportofilo/user_1service_14.jpg', NULL, '2017-10-03 09:34:48', '2017-10-03 09:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `price_unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_per_unit` int(11) DEFAULT NULL,
  `days_to_deliver` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `terms` longtext COLLATE utf8mb4_unicode_ci,
  `question1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_lat_long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_lat_long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_lat_long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_input` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_input` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formatted_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `supplier_id`, `category_id`, `price_unit`, `price_per_unit`, `days_to_deliver`, `description`, `terms`, `question1`, `question2`, `question3`, `rating`, `created_at`, `updated_at`, `country_lat_long`, `city_lat_long`, `area_lat_long`, `lat_input`, `long_input`, `city_name`, `formatted_address`) VALUES
(1, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:32:51', '2017-09-20 06:32:51', '', '', '', '', '', '', ''),
(2, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:41:09', '2017-09-20 06:41:09', '', '', '', '', '', '', ''),
(3, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:42:29', '2017-09-20 06:42:29', '', '', '', '', '', '', ''),
(4, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:43:19', '2017-09-20 06:43:19', '', '', '', '', '', '', ''),
(5, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:50:17', '2017-09-20 06:50:17', '', '', '', '', '', '', ''),
(6, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:53:43', '2017-09-20 06:53:43', '', '', '', '', '', '', ''),
(7, 'writing an articledsad', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 06:55:52', '2017-09-20 06:55:52', '', '', '', '', '', '', ''),
(8, 'writing an articledsad dfdf', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 08:11:35', '2017-09-20 08:11:35', '', '', '', '', '', '', ''),
(9, 'writing an articledsad dfdf', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 08:16:17', '2017-09-20 08:16:17', '', '', '', '', '', '', ''),
(10, 'new test', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 08:19:22', '2017-09-20 10:41:05', '', '', '', '', '', '', ''),
(12, 'new test', 1, 3, '20', NULL, 4, 'sadsagasdsadsad', NULL, 'sadsadas', 'dsadsad', 'sadsadsad', NULL, '2017-09-21 22:54:42', '2017-09-21 22:54:42', '', '', '', '', '', '', ''),
(24, 'adasdasdasdasd12345', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-24 15:48:29', '2017-09-24 15:48:29', '', '', '', '', '', '', ''),
(25, '1', 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-24 17:12:27', '2017-09-24 17:12:27', '', '', '', '', '', '', ''),
(29, 'mr code test', 1, 3, 'data', 12, 4, 'asdasd', 'sad', 'sdads', NULL, NULL, NULL, '2017-09-24 17:15:11', '2017-09-25 19:38:04', '', '', '', '', '', '', ''),
(31, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 17:27:04', '2017-09-24 17:27:04', '', '', '', '', '', '', ''),
(34, 'adasdasdasdasd12345', 1, 3, 'data', 1234, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 19:39:52', '2017-09-24 19:39:52', '', '', '', '', '', '', ''),
(35, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 20:26:58', '2017-09-24 20:26:58', '', '', '', '', '', '', ''),
(36, 'adasdasdasdasd12345', 1, 3, 'hours', 12, 4, '2323', 'lakfmsdlkfmasdl;fksdmf;ladksfm;asdklfmad;kl', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 21:24:05', '2017-09-24 21:24:05', '', '', '', '', '', '', ''),
(37, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 21:59:37', '2017-09-24 21:59:37', '', '', '', '', '', '', ''),
(38, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:00:57', '2017-09-24 22:00:57', '', '', '', '', '', '', ''),
(39, 'adasdasdasdasd12345', 1, 3, 'data', 233, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:01:44', '2017-09-24 22:01:44', '', '', '', '', '', '', ''),
(40, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:02:13', '2017-09-24 22:02:13', '', '', '', '', '', '', ''),
(41, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:02:39', '2017-09-24 22:02:39', '', '', '', '', '', '', ''),
(42, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:20:15', '2017-09-24 22:20:15', '', '', '', '', '', '', ''),
(43, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:22:55', '2017-09-24 22:22:55', '', '', '', '', '', '', ''),
(44, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:27:14', '2017-09-24 22:27:14', '', '', '', '', '', '', ''),
(45, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:28:57', '2017-09-24 22:28:57', '', '', '', '', '', '', ''),
(46, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-24 22:36:36', '2017-09-24 22:36:36', '', '', '', '', '', '', ''),
(47, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 14:08:57', '2017-09-25 14:08:57', '', '', '', '', '', '', ''),
(48, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 14:48:09', '2017-09-25 14:48:09', '', '', '', '', '', '', ''),
(49, 'Seo services', 1, 3, '545', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 15:01:10', '2017-09-25 15:01:10', '', '', '', '', '', '', ''),
(50, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 18:27:10', '2017-09-25 18:27:10', '', '', '', '', '', '', ''),
(51, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 18:27:18', '2017-09-25 18:27:18', '', '', '', '', '', '', ''),
(52, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 18:28:05', '2017-09-25 18:28:05', '', '', '', '', '', '', ''),
(53, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 18:43:08', '2017-09-25 18:43:08', '', '', '', '', '', '', ''),
(54, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 18:44:03', '2017-09-25 18:44:03', '', '', '', '', '', '', ''),
(55, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-25 19:29:19', '2017-09-25 19:29:19', '', '', '', '', '', '', ''),
(56, 'test service gdeda', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 19:48:19', '2017-09-28 19:48:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'adasdasdasdasd12345', 1, 3, 'hours', 12, 4, '2323', 'lakfmsdlkfmasdl;fksdmf;ladksfm;asdklfmad;kl', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 20:05:10', '2017-09-28 20:05:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '1', 1, 3, '22', 233, 44, 'hello desc', 'hello terms', 'eueue', NULL, NULL, NULL, '2017-09-28 20:05:19', '2017-09-28 20:05:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'adasdasdasdasd12345', 1, 3, 'hours', 12, 4, '2323', 'lakfmsdlkfmasdl;fksdmf;ladksfm;asdklfmad;kl', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 20:48:56', '2017-09-28 20:48:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'adasdasdasdasd12345', 1, 3, 'hours', 12, 4, '2323', 'lakfmsdlkfmasdl;fksdmf;ladksfm;asdklfmad;kl', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 20:49:09', '2017-09-28 20:49:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 20:53:33', '2017-09-28 20:53:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, '1', 1, 3, '22', 233, 44, 'hello desc', 'hello terms', 'eueue', NULL, NULL, NULL, '2017-09-28 20:59:23', '2017-09-28 20:59:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '1', 1, 3, '22', 233, 44, 'hello desc', 'hello terms', 'eueue', NULL, NULL, NULL, '2017-09-28 20:59:58', '2017-09-28 20:59:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, '1', 1, 3, '22', 233, 44, 'hello desc', 'hello terms', 'eueue', NULL, NULL, NULL, '2017-09-28 21:00:13', '2017-09-28 21:00:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, '1', 1, 3, '22', 233, 44, 'hello desc', 'hello terms', 'eueue', NULL, NULL, NULL, '2017-09-28 21:01:09', '2017-09-28 21:01:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, '1', 1, 3, '22', 233, 44, 'hello desc', 'hello terms', 'eueue', NULL, NULL, NULL, '2017-09-28 21:10:38', '2017-09-28 21:10:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 22:37:18', '2017-09-28 22:37:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 22:41:52', '2017-09-28 22:41:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 22:43:04', '2017-09-28 22:43:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 22:59:18', '2017-09-28 22:59:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 22:59:44', '2017-09-28 22:59:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-09-28 22:59:51', '2017-09-28 22:59:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-01 16:46:37', '2017-10-01 16:46:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:04:10', '2017-10-03 09:04:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:04:38', '2017-10-03 09:04:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:04:41', '2017-10-03 09:04:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:06:16', '2017-10-03 09:06:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:06:17', '2017-10-03 09:06:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:08:26', '2017-10-03 09:08:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:15:16', '2017-10-03 09:15:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:15:38', '2017-10-03 09:15:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:16:45', '2017-10-03 09:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:29:58', '2017-10-03 09:29:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:32:28', '2017-10-03 09:32:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:32:34', '2017-10-03 09:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'adasdasdasdasd12345', 1, 3, 'data', 12, 4, '2323', 'test terms', 'test', 'asdasd', '23wdawds', NULL, '2017-10-03 09:34:48', '2017-10-03 09:34:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `serviceveds`
--

CREATE TABLE `serviceveds` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `serviceveds`
--

INSERT INTO `serviceveds` (`id`, `service_id`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, 'sdasda', '2017-09-20 06:32:51', '2017-09-25 18:46:11'),
(2, 1, 'new ved rtest', '2017-09-20 06:32:51', '2017-09-20 06:32:51'),
(3, 2, 'another ved test', '2017-09-20 06:41:09', '2017-09-20 06:41:09'),
(4, 2, 'new ved rtest', '2017-09-20 06:41:09', '2017-09-20 06:41:09'),
(5, 3, 'another ved test', '2017-09-20 06:42:29', '2017-09-20 06:42:29'),
(6, 3, 'new ved rtest', '2017-09-20 06:42:29', '2017-09-20 06:42:29'),
(7, 4, 'another ved test', '2017-09-20 06:43:20', '2017-09-20 06:43:20'),
(8, 4, 'new ved rtest', '2017-09-20 06:43:20', '2017-09-20 06:43:20'),
(9, 5, 'another ved test', '2017-09-20 06:50:17', '2017-09-20 06:50:17'),
(10, 5, 'new ved rtest', '2017-09-20 06:50:17', '2017-09-20 06:50:17'),
(11, 6, 'another ved test', '2017-09-20 06:53:44', '2017-09-20 06:53:44'),
(12, 6, 'new ved rtest', '2017-09-20 06:53:44', '2017-09-20 06:53:44'),
(13, 7, 'another ved test', '2017-09-20 06:55:52', '2017-09-20 06:55:52'),
(14, 7, 'new ved rtest', '2017-09-20 06:55:52', '2017-09-20 06:55:52'),
(15, 8, 'another ved test', '2017-09-20 08:11:35', '2017-09-20 08:11:35'),
(16, 8, 'new ved rtest', '2017-09-20 08:11:35', '2017-09-20 08:11:35'),
(17, 9, 'another ved test', '2017-09-20 08:16:17', '2017-09-20 08:16:17'),
(18, 9, 'new ved rtest', '2017-09-20 08:16:17', '2017-09-20 08:16:17'),
(19, 10, 'sara', '2017-09-20 08:19:22', '2017-09-20 10:41:05'),
(20, 10, 'frass', '2017-09-20 08:19:22', '2017-09-20 10:41:05'),
(21, 12, 'dsdsdsadsa', '2017-09-21 22:54:42', '2017-09-21 22:54:42'),
(22, 12, 'cxvcxvc', '2017-09-21 22:54:42', '2017-09-21 22:54:42'),
(23, 31, 'asasdda', '2017-09-24 17:27:04', '2017-09-24 17:27:04'),
(24, 31, 'sdasda', '2017-09-24 17:27:04', '2017-09-24 17:27:04'),
(31, 35, 'asasdda', '2017-09-24 20:26:58', '2017-09-24 20:26:58'),
(32, 35, 'sdasda', '2017-09-24 20:26:58', '2017-09-24 20:26:58'),
(33, 36, 'asasdda', '2017-09-24 21:24:05', '2017-09-24 21:24:05'),
(34, 36, 'sdasda', '2017-09-24 21:24:05', '2017-09-24 21:24:05'),
(35, 37, 'asasdda', '2017-09-24 21:59:37', '2017-09-24 21:59:37'),
(36, 37, 'sdasda', '2017-09-24 21:59:37', '2017-09-24 21:59:37'),
(37, 38, 'asasdda', '2017-09-24 22:00:57', '2017-09-24 22:00:57'),
(38, 38, 'sdasda', '2017-09-24 22:00:57', '2017-09-24 22:00:57'),
(39, 39, 'asasdda', '2017-09-24 22:01:44', '2017-09-24 22:01:44'),
(40, 39, 'sdasda', '2017-09-24 22:01:44', '2017-09-24 22:01:44'),
(41, 40, 'asasdda', '2017-09-24 22:02:13', '2017-09-24 22:02:13'),
(42, 40, 'sdasda', '2017-09-24 22:02:13', '2017-09-24 22:02:13'),
(43, 41, 'asasdda', '2017-09-24 22:02:39', '2017-09-24 22:02:39'),
(44, 41, 'sdasda', '2017-09-24 22:02:39', '2017-09-24 22:02:39'),
(45, 42, 'asasdda', '2017-09-24 22:20:15', '2017-09-24 22:20:15'),
(46, 42, 'sdasda', '2017-09-24 22:20:15', '2017-09-24 22:20:15'),
(47, 43, 'asasdda', '2017-09-24 22:22:55', '2017-09-24 22:22:55'),
(48, 43, 'sdasda', '2017-09-24 22:22:55', '2017-09-24 22:22:55'),
(49, 44, 'asasdda', '2017-09-24 22:27:14', '2017-09-24 22:27:14'),
(50, 44, 'sdasda', '2017-09-24 22:27:14', '2017-09-24 22:27:14'),
(51, 45, 'asasdda', '2017-09-24 22:28:57', '2017-09-24 22:28:57'),
(52, 45, 'sdasda', '2017-09-24 22:28:57', '2017-09-24 22:28:57'),
(53, 46, 'asasdda', '2017-09-24 22:36:36', '2017-09-24 22:36:36'),
(54, 46, 'sdasda', '2017-09-24 22:36:36', '2017-09-24 22:36:36'),
(55, 47, 'asasdda', '2017-09-25 14:08:57', '2017-09-25 14:08:57'),
(56, 47, 'sdasda', '2017-09-25 14:08:57', '2017-09-25 14:08:57'),
(57, 48, 'asasdda', '2017-09-25 14:48:09', '2017-09-25 14:48:09'),
(58, 48, 'sdasda', '2017-09-25 14:48:09', '2017-09-25 14:48:09'),
(59, 49, 'asasdda', '2017-09-25 15:01:10', '2017-09-25 15:01:10'),
(60, 49, 'sdasda', '2017-09-25 15:01:10', '2017-09-25 15:01:10'),
(61, 50, 'asasdda', '2017-09-25 18:27:10', '2017-09-25 18:27:10'),
(62, 50, 'sdasda', '2017-09-25 18:27:10', '2017-09-25 18:27:10'),
(63, 51, 'asasdda', '2017-09-25 18:27:18', '2017-09-25 18:27:18'),
(64, 51, 'sdasda', '2017-09-25 18:27:18', '2017-09-25 18:27:18'),
(65, 52, 'asasdda', '2017-09-25 18:28:05', '2017-09-25 18:28:05'),
(66, 52, 'sdasda', '2017-09-25 18:28:05', '2017-09-25 18:28:05'),
(67, 53, 'asasdda', '2017-09-25 18:43:08', '2017-09-25 18:43:08'),
(68, 53, 'sdasda', '2017-09-25 18:43:08', '2017-09-25 18:43:08'),
(69, 54, 'asasdda', '2017-09-25 18:44:03', '2017-09-25 18:44:03'),
(70, 54, 'sdasda', '2017-09-25 18:44:03', '2017-09-25 18:44:03'),
(71, 55, 'asasdda', '2017-09-25 19:29:19', '2017-09-25 19:29:19'),
(72, 55, 'sdasda', '2017-09-25 19:29:19', '2017-09-25 19:29:19'),
(73, 56, 'asasdda', '2017-09-28 19:48:19', '2017-09-28 19:48:19'),
(74, 56, 'sdasda', '2017-09-28 19:48:19', '2017-09-28 19:48:19'),
(75, 57, 'asasdda', '2017-09-28 20:05:10', '2017-09-28 20:05:10'),
(76, 57, 'sdasda', '2017-09-28 20:05:10', '2017-09-28 20:05:10'),
(77, 59, 'asasdda', '2017-09-28 20:48:56', '2017-09-28 20:48:56'),
(78, 59, 'sdasda', '2017-09-28 20:48:56', '2017-09-28 20:48:56'),
(79, 60, 'asasdda', '2017-09-28 20:49:09', '2017-09-28 20:49:09'),
(80, 60, 'sdasda', '2017-09-28 20:49:09', '2017-09-28 20:49:09'),
(81, 61, 'asasdda', '2017-09-28 20:53:33', '2017-09-28 20:53:33'),
(82, 61, 'sdasda', '2017-09-28 20:53:33', '2017-09-28 20:53:33'),
(83, 67, 'asasdda', '2017-09-28 22:37:18', '2017-09-28 22:37:18'),
(84, 67, 'sdasda', '2017-09-28 22:37:18', '2017-09-28 22:37:18'),
(85, 68, 'asasdda', '2017-09-28 22:41:52', '2017-09-28 22:41:52'),
(86, 68, 'sdasda', '2017-09-28 22:41:52', '2017-09-28 22:41:52'),
(87, 69, 'asasdda', '2017-09-28 22:43:04', '2017-09-28 22:43:04'),
(88, 69, 'sdasda', '2017-09-28 22:43:04', '2017-09-28 22:43:04'),
(89, 70, 'asasdda', '2017-09-28 22:59:18', '2017-09-28 22:59:18'),
(90, 70, 'sdasda', '2017-09-28 22:59:18', '2017-09-28 22:59:18'),
(91, 71, 'asasdda', '2017-09-28 22:59:44', '2017-09-28 22:59:44'),
(92, 71, 'sdasda', '2017-09-28 22:59:44', '2017-09-28 22:59:44'),
(93, 72, 'asasdda', '2017-09-28 22:59:51', '2017-09-28 22:59:51'),
(94, 72, 'sdasda', '2017-09-28 22:59:51', '2017-09-28 22:59:51'),
(95, 73, 'asasdda', '2017-10-01 16:46:37', '2017-10-01 16:46:37'),
(96, 73, 'sdasda', '2017-10-01 16:46:37', '2017-10-01 16:46:37'),
(97, 74, 'asasdda', '2017-10-03 09:04:10', '2017-10-03 09:04:10'),
(98, 74, 'sdasda', '2017-10-03 09:04:10', '2017-10-03 09:04:10'),
(99, 75, 'asasdda', '2017-10-03 09:04:39', '2017-10-03 09:04:39'),
(100, 75, 'sdasda', '2017-10-03 09:04:39', '2017-10-03 09:04:39'),
(101, 76, 'asasdda', '2017-10-03 09:04:41', '2017-10-03 09:04:41'),
(102, 76, 'sdasda', '2017-10-03 09:04:42', '2017-10-03 09:04:42'),
(103, 77, 'asasdda', '2017-10-03 09:06:16', '2017-10-03 09:06:16'),
(104, 77, 'sdasda', '2017-10-03 09:06:16', '2017-10-03 09:06:16'),
(105, 78, 'asasdda', '2017-10-03 09:06:17', '2017-10-03 09:06:17'),
(106, 78, 'sdasda', '2017-10-03 09:06:17', '2017-10-03 09:06:17'),
(107, 79, 'asasdda', '2017-10-03 09:08:26', '2017-10-03 09:08:26'),
(108, 79, 'sdasda', '2017-10-03 09:08:26', '2017-10-03 09:08:26'),
(109, 80, 'asasdda', '2017-10-03 09:15:16', '2017-10-03 09:15:16'),
(110, 80, 'sdasda', '2017-10-03 09:15:16', '2017-10-03 09:15:16'),
(111, 81, 'asasdda', '2017-10-03 09:15:39', '2017-10-03 09:15:39'),
(112, 81, 'sdasda', '2017-10-03 09:15:39', '2017-10-03 09:15:39'),
(113, 82, 'asasdda', '2017-10-03 09:16:45', '2017-10-03 09:16:45'),
(114, 82, 'sdasda', '2017-10-03 09:16:45', '2017-10-03 09:16:45'),
(115, 83, 'asasdda', '2017-10-03 09:29:59', '2017-10-03 09:29:59'),
(116, 83, 'sdasda', '2017-10-03 09:29:59', '2017-10-03 09:29:59'),
(117, 84, 'asasdda', '2017-10-03 09:32:28', '2017-10-03 09:32:28'),
(118, 84, 'sdasda', '2017-10-03 09:32:28', '2017-10-03 09:32:28'),
(119, 85, 'asasdda', '2017-10-03 09:32:34', '2017-10-03 09:32:34'),
(120, 85, 'sdasda', '2017-10-03 09:32:34', '2017-10-03 09:32:34'),
(121, 86, 'asasdda', '2017-10-03 09:34:48', '2017-10-03 09:34:48'),
(122, 86, 'sdasda', '2017-10-03 09:34:48', '2017-10-03 09:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2','') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0 = non verified 1 = verified 2 = pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `avatar`, `city`, `area`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'code', 'code.hifny@gmail.com', '0123234234343a', '$2y$10$QN.5bh0efxkP1LXpJ4/Bye/kJ7HgD3487oTFj1Y4WoSY9Zk6xKVi6', 'useravatar/user_1.jpg', 'cairo', 'maadi', NULL, '2017-10-09 11:57:18', '2017-10-09 11:57:18', '1'),
(2, 'public user', 'public_user', '010000000000', '$2y$10$QhttW6DqHphAuJKiXdgQzeXch3kYRzycrBZZuoL1nv9/ype6Mnw5.', NULL, 'cairo', 'maadi', NULL, '2017-10-09 12:51:23', '2017-10-09 12:51:23', '0'),
(3, 'sadasd', 'dsa@sasd.fgfd', '2313123123', '$2y$10$AlnLRwodj0REl/PygUSKBuDarGUxk7bih7yRkWSlml1yUiKm2jpk.', NULL, NULL, NULL, NULL, '2017-10-11 12:04:04', '2017-10-11 12:04:04', '0'),
(4, 'asdsd', 'sadasd@dsad.dadsa', 'sadasd', '$2y$10$o6i13KvqKQtr1dcPrYjw0.dg02Sen5fNThPVl3fzr2nja.G5GbMDq', NULL, NULL, NULL, NULL, '2017-10-12 11:01:09', '2017-10-12 11:01:09', '0'),
(5, 'caxsdasd', 'asdasd@dasda.caaca', 'asdasdasd', '$2y$10$91ezSZVK7Klu.ZzathMPVeP9yeY5ost/1fDVVaQEzdEnxURhzMuJa', NULL, NULL, NULL, NULL, '2017-10-12 11:04:15', '2017-10-12 11:04:15', '0'),
(6, 'caxsdasd', 'asdaasd@dasda.caaca', 'asdaasdasd', '$2y$10$VVYcNfaBLFXyIUAvlkJMl.tvndpQkqxccC1A5dP6I3sVFudEyNQ6W', NULL, NULL, NULL, NULL, '2017-10-12 11:30:44', '2017-10-12 11:30:44', '0'),
(7, 'sdasd', 'sadsad@sasd.dasd', 'asdas', '$2y$10$5ky6WqIqHBPqM8ZFNKOij.dUuh6N/BasakgzPFukaevn6HW5EGZuK', NULL, NULL, NULL, NULL, '2017-10-12 11:31:47', '2017-10-12 11:31:47', '0'),
(8, 'asdsad', 'asdasd@sdas.as', 'asdasd', '$2y$10$jbaaYPkD61rSDS01Zq11H.wQE68WqGP/cvz/9asoRzi46HoGfcAiO', NULL, NULL, NULL, NULL, '2017-10-12 11:33:12', '2017-10-12 11:33:12', '0'),
(9, 'sfhsfhs', 'rtwert@dasd.as', 'dfdsgg', '$2y$10$qhC47aE.BPWNUIusGSYlouh9b9Ch3AiX/XJ96TCVT.wzbdPPZYXdO', NULL, NULL, NULL, NULL, '2017-10-12 11:34:17', '2017-10-12 11:34:17', '0'),
(10, 'asdsadas', 'asdasd@sad.af', 'asdasdassdgyd', '$2y$10$Sh1jCfdGqZhaKdIHMOaS6.dUFVo4SV9.eeU4pkczivfk9kRKInkQC', NULL, NULL, NULL, NULL, '2017-10-12 11:35:17', '2017-10-12 11:35:17', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourits`
--
ALTER TABLE `favourits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_service_id_foreign` (`service_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

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
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `servicelocs`
--
ALTER TABLE `servicelocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicepics`
--
ALTER TABLE `servicepics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicepics_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_supplier_id_foreign` (`supplier_id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `serviceveds`
--
ALTER TABLE `serviceveds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serviceveds_service_id_foreign` (`service_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `favourits`
--
ALTER TABLE `favourits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `servicelocs`
--
ALTER TABLE `servicelocs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicepics`
--
ALTER TABLE `servicepics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `serviceveds`
--
ALTER TABLE `serviceveds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
