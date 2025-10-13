-- Sports Club Database Schema
-- Complete database structure with sample data

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Table structure for site_settings
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for admins
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','super_admin') DEFAULT 'admin',
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for teams
DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `team_type` enum('A','B','U21','U19','U17','U15','U13','U11','U9') NOT NULL,
  `category` enum('men','women','youth') DEFAULT 'men',
  `league` varchar(100) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `season` varchar(20) DEFAULT '2024-25',
  `status` enum('active','inactive') DEFAULT 'active',
  `description` text,
  `founded_year` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for players
DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `jersey_number` int(11) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `team_type` enum('A','B','U21','U19','U17','U15','U13','U11','U9') DEFAULT 'A',
  `birth_date` date DEFAULT NULL,
  `nationality` varchar(50) DEFAULT 'Türkiye',
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text,
  `goals_scored` int(11) DEFAULT 0,
  `assists` int(11) DEFAULT 0,
  `yellow_cards` int(11) DEFAULT 0,
  `red_cards` int(11) DEFAULT 0,
  `matches_played` int(11) DEFAULT 0,
  `market_value` decimal(12,2) DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `status` enum('active','injured','suspended','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for technical_staff
DROP TABLE IF EXISTS `technical_staff`;
CREATE TABLE `technical_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text,
  `experience_years` int(11) DEFAULT 0,
  `license_type` varchar(100) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT 'Türkiye',
  `birth_date` date DEFAULT NULL,
  `joined_date` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `technical_staff_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for matches
DROP TABLE IF EXISTS `matches`;
CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) DEFAULT NULL,
  `home_team` varchar(100) NOT NULL,
  `away_team` varchar(100) NOT NULL,
  `match_date` datetime NOT NULL,
  `venue` varchar(100) DEFAULT NULL,
  `league` varchar(100) DEFAULT NULL,
  `season` varchar(20) DEFAULT '2024-25',
  `match_week` int(11) DEFAULT NULL,
  `home_score` int(11) DEFAULT NULL,
  `away_score` int(11) DEFAULT NULL,
  `status` enum('scheduled','live','finished','cancelled','postponed') DEFAULT 'scheduled',
  `referee` varchar(100) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  `weather_conditions` varchar(100) DEFAULT NULL,
  `match_report` text,
  `highlights_video` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  KEY `match_date` (`match_date`),
  KEY `status` (`status`),
  CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for news
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT 'genel',
  `tags` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('draft','published','archived') DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status` (`status`),
  KEY `published_at` (`published_at`),
  KEY `is_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `age_group` varchar(20) NOT NULL,
  `age_category` enum('minikler','küçükler','yıldızlar','gençler','yetişkinler') NOT NULL,
  `min_age` int(11) NOT NULL,
  `max_age` int(11) NOT NULL,
  `description` text,
  `training_days` varchar(100) DEFAULT NULL,
  `training_times` varchar(100) DEFAULT NULL,
  `monthly_fee` decimal(8,2) DEFAULT NULL,
  `max_capacity` int(11) DEFAULT 20,
  `current_members` int(11) DEFAULT 0,
  `status` enum('active','inactive','full') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for group_coaches
DROP TABLE IF EXISTS `group_coaches`;
CREATE TABLE `group_coaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `role` enum('head_coach','assistant_coach','goalkeeper_coach') DEFAULT 'head_coach',
  `assigned_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `coach_id` (`coach_id`),
  CONSTRAINT `group_coaches_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_coaches_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `technical_staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for training_schedules
DROP TABLE IF EXISTS `training_schedules`;
CREATE TABLE `training_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `training_type` varchar(50) DEFAULT 'normal',
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `training_schedules_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for sliders
DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Table structure for about_us
DROP TABLE IF EXISTS `about_us`;
CREATE TABLE `about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `section_name` (`section_name`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

SET FOREIGN_KEY_CHECKS = 1;