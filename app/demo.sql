-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: zaidesk_new_final_test
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.10.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `a_i_replays`
--

DROP TABLE IF EXISTS `a_i_replays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `a_i_replays` (
                               `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                               `ticket_id` int NOT NULL DEFAULT '0',
                               `ai_replay_text` longtext COLLATE utf8mb4_unicode_ci,
                               `created_at` timestamp NULL DEFAULT NULL,
                               `updated_at` timestamp NULL DEFAULT NULL,
                               `deleted_at` timestamp NULL DEFAULT NULL,
                               PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_i_replays`
--

/*!40000 ALTER TABLE `a_i_replays` DISABLE KEYS */;
/*!40000 ALTER TABLE `a_i_replays` ENABLE KEYS */;

--
-- Table structure for table `affiliation_histories`
--

DROP TABLE IF EXISTS `affiliation_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliation_histories` (
                                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                         `user_id` bigint unsigned NOT NULL,
                                         `child_id` bigint unsigned NOT NULL,
                                         `amount` decimal(19,8) NOT NULL DEFAULT '0.00000000',
                                         `system_fees` decimal(19,8) NOT NULL DEFAULT '0.00000000',
                                         `transaction_id` bigint unsigned NOT NULL,
                                         `order_type` int NOT NULL DEFAULT '1' COMMENT 'buy = 1, sell = 2',
                                         `level` int NOT NULL,
                                         `status` int NOT NULL DEFAULT '0' COMMENT 'unpaid = 0, paid = 1',
                                         `deleted_at` timestamp NULL DEFAULT NULL,
                                         `created_at` timestamp NULL DEFAULT NULL,
                                         `updated_at` timestamp NULL DEFAULT NULL,
                                         PRIMARY KEY (`id`),
                                         KEY `affiliation_histories_user_id_foreign` (`user_id`),
                                         KEY `affiliation_histories_child_id_foreign` (`child_id`),
                                         CONSTRAINT `affiliation_histories_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                                         CONSTRAINT `affiliation_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliation_histories`
--

/*!40000 ALTER TABLE `affiliation_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliation_histories` ENABLE KEYS */;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `customer_announcement` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `created_by` bigint unsigned NOT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banks` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `gateway_id` bigint unsigned NOT NULL,
                         `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
                         `status` tinyint NOT NULL DEFAULT '0',
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_categories` (
                                   `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `status` tinyint NOT NULL DEFAULT '0',
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   `updated_at` timestamp NULL DEFAULT NULL,
                                   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;

--
-- Table structure for table `blog_tag`
--

DROP TABLE IF EXISTS `blog_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_tag` (
                            `blog_id` bigint unsigned NOT NULL,
                            `blog_tag_id` bigint unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tag`
--

/*!40000 ALTER TABLE `blog_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_tag` ENABLE KEYS */;

--
-- Table structure for table `blog_tags`
--

DROP TABLE IF EXISTS `blog_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_tags` (
                             `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tags`
--

/*!40000 ALTER TABLE `blog_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_tags` ENABLE KEYS */;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `user_id` bigint unsigned NOT NULL,
                         `blog_category_id` bigint unsigned NOT NULL,
                         `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                         `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `status` tinyint NOT NULL DEFAULT '0',
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;

--
-- Table structure for table `business_hours`
--

DROP TABLE IF EXISTS `business_hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_hours` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `user_id` int DEFAULT NULL,
                                  `days` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `start_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `end_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_hours`
--

/*!40000 ALTER TABLE `business_hours` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_hours` ENABLE KEYS */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
                              `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                              `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `status` tinyint NOT NULL DEFAULT '1',
                              `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
                              `deleted_at` timestamp NULL DEFAULT NULL,
                              `created_at` timestamp NULL DEFAULT NULL,
                              `updated_at` timestamp NULL DEFAULT NULL,
                              `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `is_ticket_prefix` tinyint(1) NOT NULL DEFAULT '0',
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

--
-- Table structure for table `category_user`
--

DROP TABLE IF EXISTS `category_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_user` (
                                 `category_id` bigint unsigned NOT NULL,
                                 `user_id` bigint unsigned NOT NULL,
                                 `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_user`
--

/*!40000 ALTER TABLE `category_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_user` ENABLE KEYS */;

--
-- Table structure for table `chat_configurations`
--

DROP TABLE IF EXISTS `chat_configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_configurations` (
                                       `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                       `chat_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `message_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `message_discription` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `status` int NOT NULL DEFAULT '0',
                                       `created_by` bigint DEFAULT NULL,
                                       `updated_by` bigint DEFAULT NULL,
                                       `created_at` timestamp NULL DEFAULT NULL,
                                       `updated_at` timestamp NULL DEFAULT NULL,
                                       PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_configurations`
--

/*!40000 ALTER TABLE `chat_configurations` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_configurations` ENABLE KEYS */;

--
-- Table structure for table `chat_sessions`
--

DROP TABLE IF EXISTS `chat_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_sessions` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `time` int DEFAULT NULL,
                                 `status` int NOT NULL DEFAULT '1',
                                 `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `created_by` int DEFAULT NULL,
                                 `deleted_at` timestamp NULL DEFAULT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_sessions`
--

/*!40000 ALTER TABLE `chat_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_sessions` ENABLE KEYS */;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chats` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `sender_id` int NOT NULL DEFAULT '0',
                         `receiver_id` int NOT NULL DEFAULT '0',
                         `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `message` longtext COLLATE utf8mb4_unicode_ci,
                         `is_seen` int NOT NULL DEFAULT '0',
                         `file` text COLLATE utf8mb4_unicode_ci,
                         `session_id` int NOT NULL DEFAULT '0',
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chats`
--

/*!40000 ALTER TABLE `chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `chats` ENABLE KEYS */;

--
-- Table structure for table `cms_settings`
--

DROP TABLE IF EXISTS `cms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_settings` (
                                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                `auth_page_title` longtext COLLATE utf8mb4_unicode_ci,
                                `auth_page_sub_title` longtext COLLATE utf8mb4_unicode_ci,
                                `app_footer_text` longtext COLLATE utf8mb4_unicode_ci,
                                `facebook_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `instagram_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `linkedin_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `twitter_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `skype_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `created_by` bigint unsigned DEFAULT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                `deleted_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_settings`
--

/*!40000 ALTER TABLE `cms_settings` DISABLE KEYS */;
INSERT INTO `cms_settings` VALUES (1,'','','','','','','','',NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL);
/*!40000 ALTER TABLE `cms_settings` ENABLE KEYS */;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
                                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                    `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    `updated_at` timestamp NULL DEFAULT NULL,
                                    `deleted_at` timestamp NULL DEFAULT NULL,
                                    `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `ticket_id` bigint unsigned NOT NULL,
                                 `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `file_id` text COLLATE utf8mb4_unicode_ci,
                                 `created_by` bigint unsigned NOT NULL,
                                 `status` int NOT NULL DEFAULT '0',
                                 `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `deleted_at` timestamp NULL DEFAULT NULL,
                                 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                 `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;

--
-- Table structure for table `counter_areas`
--

DROP TABLE IF EXISTS `counter_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `counter_areas` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counter_areas`
--

/*!40000 ALTER TABLE `counter_areas` DISABLE KEYS */;
INSERT INTO `counter_areas` VALUES (1,'+04','Years of experience','2024-03-11 09:00:26','2024-03-11 09:00:26'),(2,'+04k','Zaidesk active users','2024-03-11 09:00:26','2024-03-11 09:00:26'),(3,'+04','Employees so far','2024-03-11 09:00:26','2024-03-11 09:00:26'),(4,'+04','Zaidesk gateways','2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `counter_areas` ENABLE KEYS */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
                             `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                             `short_name` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `country_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `flag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `phonecode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `continent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `status` tinyint NOT NULL DEFAULT '1',
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'af','Afghanistan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(2,'al','Albania',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(3,'dz','Algeria',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(4,'ds','American Samoa',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(5,'ad','Andorra',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(6,'ao','Angola',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(7,'ai','Anguilla',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(8,'aq','Antarctica',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(9,'ag','Antigua and Barbuda',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(10,'ar','Argentina',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(11,'am','Armenia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(12,'aw','Aruba',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(13,'au','Australia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(14,'at','Austria',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(15,'az','Azerbaijan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(16,'bs','Bahamas',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(17,'bh','Bahrain',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(18,'bd','Bangladesh',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(19,'bb','Barbados',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(20,'by','Belarus',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(21,'be','Belgium',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(22,'bz','Belize',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(23,'bj','Benin',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(24,'bm','Bermuda',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(25,'bt','Bhutan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(26,'bo','Bolivia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(27,'ba','Bosnia and Herzegovina',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(28,'bw','Botswana',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(29,'br','Brazil',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(30,'io','British Indian Ocean Territory',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(31,'bn','Brunei',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(32,'bg','Bulgaria',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(33,'bf','Burkina ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(34,'bi','Burundi',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(35,'kh','Cambodia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(36,'cm','Cameroon',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(37,'ca','Canada',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(38,'cv','Cape Verde',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(39,'ky','Cayman Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(40,'cf','Central African Republic',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(41,'td','Chad',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(42,'cl','Chile',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(43,'cn','China',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(44,'cx','Christmas Island',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(45,'cc','Cocos Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(46,'co','Colombia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(47,'km','Comoros',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(48,'ck','Cook Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(49,'cr','Costa Rica',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(50,'hr','Croatia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(51,'cu','Cuba',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(52,'cy','Cyprus',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(53,'cz','Czech Republic',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(54,'cg','Congo',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(55,'dk','Denmark',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(56,'dj','Djibouti',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(57,'dm','Dominica',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(58,'tp','East Timor',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(59,'ec','Ecuador',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(60,'eg','Egypt',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(61,'sv','El Salvador',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(62,'gq','Equatorial Guinea',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(63,'er','Eritrea',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(64,'ee','Estonia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(65,'et','Ethiopia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(66,'fk','Falkland Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(67,'fo','Faroe ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(68,'fj','Fiji',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(69,'fi','Finland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(70,'fr','France',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(71,'pf','French Polynesia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(72,'ga','Gabon',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(73,'gm','Gambia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(74,'ge','Georgia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(75,'de','Germany',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(76,'gh','Ghana',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(77,'gi','Gibraltar',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(78,'gr','Greece',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(79,'gl','Greenland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(80,'gd','Grenada',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(81,'gu','Guam',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(82,'gt','Guatemala',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(83,'gk','Guernsey',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(84,'gn','Guinea',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(85,'gw','Guinea-',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(86,'gy','Guyana',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(87,'ht','Haiti',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(88,'hn','Honduras',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(89,'hk','Hong Kong',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(90,'hu','Hungary',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(91,'is','Iceland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(92,'in','India',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(93,'id','Indonesia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(94,'ir','Iran',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(95,'iq','Iraq',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(96,'ie','Ireland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(97,'im','Isle of ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(98,'il','Israel',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(99,'it','Italy',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(100,'ci','Ivory ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(101,'jm','Jamaica',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(102,'jp','Japan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(103,'je','Jersey',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(104,'jo','Jordan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(105,'kz','Kazakhstan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(106,'ke','Kenya',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(107,'ki','Kiribati',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(108,'kp','North Korea',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(109,'kr','South Korea',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(110,'xk','Kosovo',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(111,'kw','Kuwait',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(112,'kg','Kyrgyzstan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(113,'la','Laos',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(114,'lv','Latvia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(115,'lb','Lebanon',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(116,'ls','Lesotho',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(117,'lr','Liberia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(118,'ly','Libya',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(119,'li','Liechtenstein',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(120,'lt','Lithuania',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(121,'lu','Luxembourg',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(122,'mo','Macau',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(123,'mk','Macedonia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(124,'mg','Madagascar',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(125,'mw','Malawi',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(126,'my','Malaysia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(127,'mv','Maldives',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(128,'ml','Mali',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(129,'mt','Malta',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(130,'mh','Marshall Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(131,'mr','Mauritania',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(132,'mu','Mauritius',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(133,'ty','Mayotte',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(134,'mx','Mexico',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(135,'fm','Micronesia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(136,'md','Moldova, Republic of',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(137,'mc','Monaco',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(138,'mn','Mongolia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(139,'me','Montenegro',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(140,'ms','Montserrat',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(141,'ma','Morocco',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(142,'mz','Mozambique',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(143,'mm','Myanmar',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(144,'na','Namibia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(145,'nr','Nauru',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(146,'np','Nepal',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(147,'nl','Netherlands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(148,'an','Netherlands Antilles',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(149,'nc','New Caledonia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(150,'nz','New Zealand',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(151,'ni','Nicaragua',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(152,'ne','Niger',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(153,'ng','Nigeria',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(154,'nu','Niue',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(155,'mp','Northern Mariana Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(156,'no','Norway',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(157,'om','Oman',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(158,'pk','Pakistan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(159,'pw','Palau',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(160,'ps','Palestine',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(161,'pa','Panama',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(162,'pg','Papua New Guinea',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(163,'py','Paraguay',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(164,'pe','Peru',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(165,'ph','Philippines',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(166,'pn','Pitcairn',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(167,'pl','Poland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(168,'pt','Portugal',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(169,'qa','Qatar',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(170,'re','Reunion',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(171,'ro','Romania',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(172,'ru','Russian',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(173,'rw','Rwanda',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(174,'kn','Saint Kitts and Nevis',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(175,'lc','Saint Lucia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(176,'vc','Saint Vincent and the Grenadines',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(177,'ws','Samoa',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(178,'sm','San Marino',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(179,'st','Sao Tome and ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(180,'sa','Saudi Arabia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(181,'sn','Senegal',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(182,'rs','Serbia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(183,'sc','Seychelles',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(184,'sl','Sierra ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(185,'sg','Singapore',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(186,'sk','Slovakia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(187,'si','Slovenia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(188,'sb','Solomon Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(189,'so','Somalia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(190,'za','South Africa',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(191,'es','Spain',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(192,'lk','Sri Lanka',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(193,'sd','Sudan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(194,'sr','Suriname',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(195,'sj','Svalbard and Jan Mayen ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(196,'sz','Swaziland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(197,'se','Sweden',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(198,'ch','Switzerland',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(199,'sy','Syria',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(200,'tw','Taiwan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(201,'tj','Tajikistan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(202,'tz','Tanzania',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(203,'th','Thailand',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(204,'tg','Togo',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(205,'tk','Tokelau',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(206,'to','Tonga',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(207,'tt','Trinidad and Tobago',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(208,'tn','Tunisia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(209,'tr','Turkey',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(210,'tm','Turkmenistan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(211,'tc','Turks and Caicos Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(212,'tv','Tuvalu',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(213,'ug','Uganda',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(214,'ua','Ukraine',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(215,'ae','United Arab Emirates',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(216,'gb','United ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(217,'uy','Uruguay',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(218,'uz','Uzbekistan',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(219,'vu','Vanuatu',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(220,'va','Vatican City State',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(221,'ve','Venezuela',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(222,'vn','Vietnam',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(223,'vi','Virgin Islands (U.S.)',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(224,'wf','Wallis and Futuna Islands',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(225,'eh','Western ',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(226,'ye','Yemen',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(227,'zm','Zambia',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(228,'zw','Zimbabwe',NULL,NULL,NULL,NULL,1,'2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
                              `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                              `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `currency_placement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
                              `current_currency` tinyint NOT NULL DEFAULT '0',
                              `created_at` timestamp NULL DEFAULT NULL,
                              `updated_at` timestamp NULL DEFAULT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'USD','$','before',1,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(2,'BDT','৳','before',0,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(3,'INR','₹','before',0,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(4,'GBP','£','after',0,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(5,'MXN','$','before',0,'2024-03-11 09:00:25','2024-03-11 09:00:25'),(6,'SAR','SR','before',0,'2024-03-11 09:00:25','2024-03-11 09:00:25');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;

--
-- Table structure for table `custom_pages`
--

DROP TABLE IF EXISTS `custom_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_pages` (
                                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `desc` longtext COLLATE utf8mb4_unicode_ci,
                                `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `deleted_at` timestamp NULL DEFAULT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_pages`
--

/*!40000 ALTER TABLE `custom_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_pages` ENABLE KEYS */;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domains` (
                           `id` int unsigned NOT NULL AUTO_INCREMENT,
                           `domain` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                           `user_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           `custom_domain_status` tinyint DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `domains_domain_unique` (`domain`),
                           KEY `domains_tenant_id_foreign` (`tenant_id`),
                           CONSTRAINT `domains_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domains`
--

/*!40000 ALTER TABLE `domains` DISABLE KEYS */;
INSERT INTO `domains` VALUES (1,'localhost','localhost','zainiklab','2024-03-11 09:00:25','2024-03-11 09:00:25',NULL);
/*!40000 ALTER TABLE `domains` ENABLE KEYS */;

--
-- Table structure for table `dynamic_field_data`
--

DROP TABLE IF EXISTS `dynamic_field_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dynamic_field_data` (
                                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                      `ticket_id` bigint unsigned NOT NULL,
                                      `field_id` int NOT NULL DEFAULT '0',
                                      `field_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `created_by` bigint unsigned NOT NULL,
                                      `created_at` timestamp NULL DEFAULT NULL,
                                      `updated_at` timestamp NULL DEFAULT NULL,
                                      `deleted_at` timestamp NULL DEFAULT NULL,
                                      PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dynamic_field_data`
--

/*!40000 ALTER TABLE `dynamic_field_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `dynamic_field_data` ENABLE KEYS */;

--
-- Table structure for table `dynamic_fields`
--

DROP TABLE IF EXISTS `dynamic_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dynamic_fields` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `type` int NOT NULL DEFAULT '0',
                                  `level` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `required` tinyint NOT NULL DEFAULT '0',
                                  `order` int NOT NULL DEFAULT '0',
                                  `created_by` bigint unsigned NOT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `width` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dynamic_fields`
--

/*!40000 ALTER TABLE `dynamic_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `dynamic_fields` ENABLE KEYS */;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_templates` (
                                   `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                   `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `slug` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `body` longtext COLLATE utf8mb4_unicode_ci,
                                   `default` tinyint NOT NULL DEFAULT '0',
                                   `status` tinyint NOT NULL DEFAULT '0',
                                   `deleted_at` timestamp NULL DEFAULT NULL,
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   `updated_at` timestamp NULL DEFAULT NULL,
                                   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates`
--

/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` VALUES (1,'Email Verification','email-verification','Verify Your Account','<p>Hello, {{username}}\n            </p><p>            Thank you for creating an account with us. We\'re excited to have you as a part of our community!\n\n                Before you can start using your account, we need to verify your email address. Please click on the link below to complete the verification process:\n            </p><p>\n\n                Link: {{otp}}\n                        </p>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(2,'Password Reset','password-reset','Reset your password','<div><b>Hello</b> ,{{username}}</div><div><br></div><div>we\'re sending you this email because you requested a password reset. Click on this link to create a new password.</div><div><br></div><div>Set a new password . Here is a link -</div><div><br></div><div>Link :&nbsp;<span style=\"background-color: rgb(209, 231, 221); color: rgb(15, 81, 50); font-family: inter, sans-serif; text-align: var(--bs-body-text-align);\">{{<b>reset_password_url</b>}}</span></div><div><br></div><div>If you didn\'t request a password reset, you can ignore this email. Your password will not be a changed.</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(3,'Ticket Create Notify For Customer','ticket-create-notify-for-customer','New Ticket Created - {{tracking_no}}','<p><b>Dear</b> {{username}},\n            </p><p>\n                            We are happy to inform you that a new ticket has been successfully created in our system with the following details:\n            </p><p>\n                            Tracking No: <b>{{tracking_no}}\n            </b></p><p>                Category: {{ticket_category}}\n            </p><p>                Date Created: {{ticket_created_time}}\n            </p><p>                Title: {{ticket_title}}</p><p>\n                            You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal.\n\n                            If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}}  or {{contact_phone}}.\n\n                            Thank you for using our services!\n            </p><p><b>\n                Best regards</b>,\n                            {{app_name}}</p>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(4,'Email Ticket Create Notify For Customer','email-ticket-create-notify-for-customer','New Ticket Created - {{tracking_no}}','<div><font color=\"#0f5132\" face=\"inter, sans-serif\"><b>Dear</b> {{username}},</font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\"><br></font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\">We are happy to inform you that a new email ticket has been successfully created in our system with the following details:&nbsp;</font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\"><br></font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\">Tracking No: {{<b>tracking_no</b>}}</font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\"><br></font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\">Category: {{ticket_category}}&nbsp;</font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\"><br></font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\">Date Created: {{ticket_created_time}}&nbsp;</font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\"><br></font></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\">Title: {{ticket_title}}&nbsp;</font></div><div><br></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\">You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal. If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}} or {{contact_phone}}. Thank you for using our services!</font></div><div><br></div><div><font color=\"#0f5132\" face=\"inter, sans-serif\"><b>Best regards</b>, {{app_name}}</font></div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(5,'Ticket Create Notify For Admin','ticket-create-notify-for-admin','New Ticket Created - {{tracking_no}}','<div><b>Dear</b> {{username}},</div><div><br></div><div>A new ticket has been created in our system. Ticket Tracking No: {{<b>tracking_no</b>}} with the following details:</div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>Thank you for your attention.</div><div><b>Best regards</b>, {{app_name}}</div><div><br></div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(6,'Ticket Create Notify For Agent','ticket-create-notify-for-agent','New Ticket Created - {{tracking_no}}','<div><b>Dear</b> {{username}},</div><div><br></div><div>A new ticket has been created in our system. Ticket created by {{customer_name/agent_name}} with the following details:</div><div><br></div><div>Tracking No: {{tracking_no}}</div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>You can view and manage this ticket in the agent dashboard. As an agent, you have full access to ticket management, including assigning tickets to agents and resolving them.</div><div>If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team.</div><div><br></div><div>Thank you for your attention.</div><div><b>Best regards</b>, {{app_name}}</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(7,'Ticket Conversation For Admin','ticket-conversation-for-admin','New Reply For Your Ticket -{{tracking_no}}','<div><span style=\"font-weight: bolder;\">Dear</span>&nbsp;{{username}},</div><div><br></div><div>A new ticket has been created in our system. Ticket Tracking No: {{<span style=\"font-weight: bolder;\">tracking_no</span>}} with the following details:</div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>Thank you for your attention.</div><div><span style=\"font-weight: bolder;\">Best regards,</span>&nbsp;{{app_name}}</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(8,'Ticket Conversation For Agent','ticket-conversation-for-agent','New Reply For Your Ticket - {{tracking_no}}','<div><span style=\"font-weight: bolder;\">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{<span style=\"font-weight: bolder;\">tracking_no</span>}} has reply in our system with the following details:&nbsp;</div><div><br></div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>Thank you for your attention.</div><div><span style=\"font-weight: bolder;\">Best regards</span>, {{app_name}}</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(9,'Ticket Conversation For Customer','ticket-conversation-for-customer','New Reply For Your Ticket - {{tracking_no}}','<div><span style=\"font-weight: bolder;\">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{<span style=\"font-weight: bolder;\">tracking_no</span>}} has reply in our system with the following details:&nbsp;</div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal. If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}} or {{contact_phone}}. Thank you for using our services!</div><div><br></div><div><span style=\"font-weight: bolder;\">Best regards</span>, {{app_name}}</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(10,'Ticket Status Change For Customer','ticket-status-change-for-customer','Ticket Status Changed - {{tracking_no}}','<div><span style=\"font-weight: bolder;\">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{<span style=\"font-weight: bolder;\">tracking_no</span>}} has ticket status change in our system with the following details:&nbsp;</div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal. If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}} or {{contact_phone}}. Thank you for using our services!</div><div><br></div><div><span style=\"font-weight: bolder;\">Best regards</span>, {{app_name}}</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(11,'Ticket Review For Agent','ticket-review-for-agent','You got a review - {{tracking_no}}','<div><span style=\"font-weight: bolder;\">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{<span style=\"font-weight: bolder;\">tracking_no</span>}} has review in our system with the following details:&nbsp;</div><div><br></div><div>Category: {{ticket_category}}&nbsp;</div><div><br></div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;<span style=\"text-align: var(--bs-body-text-align);\">&nbsp;</span></div><div><br></div><div>Thank you for your attention.</div><div><span style=\"font-weight: bolder;\">Best regards</span>, {{app_name}}</div>',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(12,'Ticket assign For Agent And Admin','ticket-assign-for-agent-admin','ticket assign','ticket asaingn',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;

--
-- Table structure for table `envatos`
--

DROP TABLE IF EXISTS `envatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `envatos` (
                           `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `enable_purchase_code` tinyint NOT NULL DEFAULT '0',
                           `envato_expired_on` tinyint NOT NULL DEFAULT '0',
                           `support_policy_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `personal_api_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `envatos`
--

/*!40000 ALTER TABLE `envatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `envatos` ENABLE KEYS */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
                               `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                               `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
                               `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
                               `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                               `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                               `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               PRIMARY KEY (`id`),
                               UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

--
-- Table structure for table `faq_categories`
--

DROP TABLE IF EXISTS `faq_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_categories` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `status` tinyint NOT NULL DEFAULT '1',
                                  `created_by` int NOT NULL,
                                  `updated_by` int NOT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_categories`
--

/*!40000 ALTER TABLE `faq_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq_categories` ENABLE KEYS */;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `faq_category_id` bigint unsigned NOT NULL,
                        `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `answer` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
                        `status` tinyint NOT NULL DEFAULT '1',
                        `created_by` int NOT NULL,
                        `updated_by` int NOT NULL,
                        `created_at` timestamp NULL DEFAULT NULL,
                        `updated_at` timestamp NULL DEFAULT NULL,
                        `deleted_at` timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `features` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `description` text COLLATE utf8mb4_unicode_ci,
                            `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `status` tinyint NOT NULL DEFAULT '1',
                            `created_by` int DEFAULT NULL,
                            `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'Secure Payments','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo.','24',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(2,'24/7 Support','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo..','24',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(3,'Quality Templates','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo.','24',1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `features` ENABLE KEYS */;

--
-- Table structure for table `file_managers`
--

DROP TABLE IF EXISTS `file_managers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_managers` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `file_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `storage_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `original_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `user_id` bigint unsigned DEFAULT NULL,
                                 `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `extension` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `external_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `deleted_at` timestamp NULL DEFAULT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 UNIQUE KEY `file_managers_file_name_unique` (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_managers`
--

/*!40000 ALTER TABLE `file_managers` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_managers` ENABLE KEYS */;

--
-- Table structure for table `frontend_sections`
--

DROP TABLE IF EXISTS `frontend_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `frontend_sections` (
                                     `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                     `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                     `title` text COLLATE utf8mb4_unicode_ci,
                                     `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `has_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                     `description` longtext COLLATE utf8mb4_unicode_ci,
                                     `image` int DEFAULT NULL,
                                     `status` int NOT NULL DEFAULT '1',
                                     `created_by` int DEFAULT NULL,
                                     `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                     `created_at` timestamp NULL DEFAULT NULL,
                                     `updated_at` timestamp NULL DEFAULT NULL,
                                     `deleted_at` timestamp NULL DEFAULT NULL,
                                     PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frontend_sections`
--

/*!40000 ALTER TABLE `frontend_sections` DISABLE KEYS */;
INSERT INTO `frontend_sections` VALUES (1,'Hero Banner','Zaidesk Simple & Secure Way to Enter your Mining.','hero_banner','1','Zaidesk is a cryptocurrency mining application designed to be a highly secure platform design for future miners. Start mining and achieve the highest level of Hashrate.',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(2,'Features Area','All The logical_reason You Will Get','features_area','0','Nisl diam sodales lacus laoreet commodo congue. maece blandit montes lobort parturient..',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(3,'Price Area','Pricing that suits your needs','price_area','0','Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id maxime placeat facere possimus.',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(4,'Testimonial Area','Hear what our users have said about Zaidesk.','testimonial_area','0','Praesent consectetur iaculis et, malesuada facilisi. Suspendisse pretium quis pulvinar tempor commodo, eget tellus morbi. Morbi netus',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(5,'Faq Area','Frequently Asked Questions','faq_area','0','Praesent consectetur iacul vitae, malesua facilisi. Suspendisse pretium quis pulvinar tempor commodo, at eget tellus morbi.',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(6,'Faq Mood Area','Frequently asked questions','faq_mood_area','0','Get answers to commonly asked questions and find solutions to your queries in our comprehensive faq section',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(7,'knowledge Area','knowledge Area','knowledge_area','0','knowledge area Get answers to commonly asked questions and find solutions to your queries in our comprehensive faq section',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(8,'Need Support Area','Need Support & Response within 24 hours?','need_support_area','0','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam quae ab illo inventore.',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL),(9,'Looking Support Area','Looking For Support?','looking_support_area','0','Can\'t find the answer you\'re looking for? Don\'t worry we\'re here to solve your problem!',NULL,1,1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL);
/*!40000 ALTER TABLE `frontend_sections` ENABLE KEYS */;

--
-- Table structure for table `gateway_currencies`
--

DROP TABLE IF EXISTS `gateway_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gateway_currencies` (
                                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                      `gateway_id` bigint unsigned NOT NULL,
                                      `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
                                      `conversion_rate` decimal(8,2) NOT NULL DEFAULT '1.00',
                                      `created_at` timestamp NULL DEFAULT NULL,
                                      `updated_at` timestamp NULL DEFAULT NULL,
                                      `deleted_at` timestamp NULL DEFAULT NULL,
                                      PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateway_currencies`
--

/*!40000 ALTER TABLE `gateway_currencies` DISABLE KEYS */;
INSERT INTO `gateway_currencies` VALUES (1,1,'USD',1.00,NULL,NULL,NULL),(2,2,'USD',1.00,NULL,NULL,NULL),(3,3,'INR',80.00,NULL,NULL,NULL),(4,4,'INR',80.00,NULL,NULL,NULL),(5,5,'USD',1.00,NULL,NULL,NULL),(6,6,'NGN',464.00,NULL,NULL,NULL),(7,7,'BDT',100.00,NULL,NULL,NULL),(8,8,'NGN',464.00,NULL,NULL,NULL),(9,9,'BRL',5.00,NULL,NULL,NULL),(10,10,'USD',1.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `gateway_currencies` ENABLE KEYS */;

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gateways` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `status` tinyint NOT NULL DEFAULT '0' COMMENT '1=Active,0=Disable',
                            `mode` tinyint NOT NULL DEFAULT '2' COMMENT '1=live,2=sandbox',
                            `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client id, public key, key, store id, api key',
                            `secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client secret, secret, store password, auth token',
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            `deleted_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `gateways_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateways`
--

/*!40000 ALTER TABLE `gateways` DISABLE KEYS */;
INSERT INTO `gateways` VALUES (1,'Paypal','paypal','assets/images/gateway-icon/paypal.png',1,2,'','','',NULL,NULL,NULL),(2,'Stripe','stripe','assets/images/gateway-icon/stripe.png',1,2,'','','',NULL,NULL,NULL),(3,'Razorpay','razorpay','assets/images/gateway-icon/razorpay.png',1,2,'','','',NULL,NULL,NULL),(4,'Instamojo','instamojo','assets/images/gateway-icon/instamojo.png',1,2,'','','',NULL,NULL,NULL),(5,'Mollie','mollie','assets/images/gateway-icon/mollie.png',1,2,'','','',NULL,NULL,NULL),(6,'Paystack','paystack','assets/images/gateway-icon/paystack.png',1,2,'','','',NULL,NULL,NULL),(7,'Sslcommerz','sslcommerz','assets/images/gateway-icon/sslcommerz.png',1,2,'','','',NULL,NULL,NULL),(8,'Flutterwave','flutterwave','assets/images/gateway-icon/flutterwave.png',1,2,'','','',NULL,NULL,NULL),(9,'Mercadopago','mercadopago','assets/images/gateway-icon/mercadopago.png',1,2,'','','',NULL,NULL,NULL),(10,'Bank','bank','assets/images/gateway-icon/bank.png',1,2,'','','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `gateways` ENABLE KEYS */;

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `general_settings` (
                                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                    `app_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_contact_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_copyright` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_developed` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_debug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_date_format` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_time_format` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_preloader` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_fav_icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `app_footer_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `login_left_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `created_by` bigint unsigned DEFAULT NULL,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    `updated_at` timestamp NULL DEFAULT NULL,
                                    `deleted_at` timestamp NULL DEFAULT NULL,
                                    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_settings`
--

/*!40000 ALTER TABLE `general_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_settings` ENABLE KEYS */;

--
-- Table structure for table `hero_sections`
--

DROP TABLE IF EXISTS `hero_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_sections` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `section_id` int NOT NULL,
                                 `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `description` longtext COLLATE utf8mb4_unicode_ci,
                                 `status` int NOT NULL,
                                 `deleted_at` timestamp NULL DEFAULT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_sections`
--

/*!40000 ALTER TABLE `hero_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `hero_sections` ENABLE KEYS */;

--
-- Table structure for table `how_it_works`
--

DROP TABLE IF EXISTS `how_it_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `how_it_works` (
                                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `how_it_works`
--

/*!40000 ALTER TABLE `how_it_works` DISABLE KEYS */;
INSERT INTO `how_it_works` VALUES (1,'Create your account','A sodales ac tristique ut. Proin eget nibh scelerisque condimentum','2024-03-11 09:00:26','2024-03-11 09:00:26'),(2,'Choose Plans','Lorem ipsum dolor amet matter consectetur adipiscing mattis.','2024-03-11 09:00:26','2024-03-11 09:00:26'),(3,'Start Investing','A sodales ac tristique ut. Proin eget nibh scelerisque condimentum','2024-03-11 09:00:26','2024-03-11 09:00:26'),(4,'Get profits','Eum dicta pariatur laudantium modi corrupti voluptate.','2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `how_it_works` ENABLE KEYS */;

--
-- Table structure for table `instant_messages`
--

DROP TABLE IF EXISTS `instant_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instant_messages` (
                                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                    `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `status` int NOT NULL DEFAULT '0',
                                    `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `deleted_at` timestamp NULL DEFAULT NULL,
                                    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                                    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instant_messages`
--

/*!40000 ALTER TABLE `instant_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `instant_messages` ENABLE KEYS */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                        `attempts` tinyint unsigned NOT NULL,
                        `reserved_at` int unsigned DEFAULT NULL,
                        `available_at` int unsigned NOT NULL,
                        `created_at` int unsigned NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

--
-- Table structure for table `k_y_c_gateways`
--

DROP TABLE IF EXISTS `k_y_c_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `k_y_c_gateways` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `status` tinyint NOT NULL DEFAULT '0',
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `k_y_c_gateways`
--

/*!40000 ALTER TABLE `k_y_c_gateways` DISABLE KEYS */;
/*!40000 ALTER TABLE `k_y_c_gateways` ENABLE KEYS */;

--
-- Table structure for table `knowledge`
--

DROP TABLE IF EXISTS `knowledge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `knowledge` (
                             `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                             `knowledge_category_id` bigint unsigned NOT NULL,
                             `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                             `user_count` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
                             `status` tinyint NOT NULL DEFAULT '1',
                             `created_by` int NOT NULL,
                             `updated_by` int NOT NULL,
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             `deleted_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knowledge`
--

/*!40000 ALTER TABLE `knowledge` DISABLE KEYS */;
/*!40000 ALTER TABLE `knowledge` ENABLE KEYS */;

--
-- Table structure for table `knowledge_categories`
--

DROP TABLE IF EXISTS `knowledge_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `knowledge_categories` (
                                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                        `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                        `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                        `status` tinyint NOT NULL DEFAULT '1',
                                        `created_by` int NOT NULL,
                                        `updated_by` int NOT NULL,
                                        `created_at` timestamp NULL DEFAULT NULL,
                                        `updated_at` timestamp NULL DEFAULT NULL,
                                        `deleted_at` timestamp NULL DEFAULT NULL,
                                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knowledge_categories`
--

/*!40000 ALTER TABLE `knowledge_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `knowledge_categories` ENABLE KEYS */;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
                             `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                             `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `iso_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `flag_id` bigint unsigned DEFAULT NULL,
                             `font` bigint unsigned DEFAULT NULL,
                             `rtl` tinyint DEFAULT '3',
                             `status` tinyint NOT NULL DEFAULT '1',
                             `default` tinyint DEFAULT '0',
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             `deleted_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `languages_language_unique` (`language`),
                             UNIQUE KEY `languages_iso_code_unique` (`iso_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'','English','en',NULL,NULL,0,1,1,'2024-03-11 09:00:25','2024-03-11 09:00:25',NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;

--
-- Table structure for table `metas`
--

DROP TABLE IF EXISTS `metas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metas` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `page_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `meta_title` mediumtext COLLATE utf8mb4_unicode_ci,
                         `meta_description` mediumtext COLLATE utf8mb4_unicode_ci,
                         `meta_keyword` mediumtext COLLATE utf8mb4_unicode_ci,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metas`
--

/*!40000 ALTER TABLE `metas` DISABLE KEYS */;
INSERT INTO `metas` VALUES (1,NULL,'login','Log In','ZAIPROPARTY A property management system','zaiproperty, property, property management system, property management software',NULL,NULL,NULL);
/*!40000 ALTER TABLE `metas` ENABLE KEYS */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
                              `id` int unsigned NOT NULL AUTO_INCREMENT,
                              `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `batch` int NOT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_09_15_000010_create_tenants_table',1),(6,'2019_09_15_000020_create_domains_table',1),(7,'2019_12_14_000001_create_personal_access_tokens_table',1),(8,'2022_06_14_123059_create_metas_table',1),(9,'2022_06_23_121213_create_settings_table',1),(10,'2022_06_25_104329_create_countries_table',1),(11,'2022_06_25_110824_create_currencies_table',1),(12,'2022_06_25_111037_create_languages_table',1),(13,'2022_11_30_040739_create_gateways_table',1),(14,'2023_01_03_075827_create_gateway_currencies_table',1),(15,'2023_01_04_112243_create_permission_tables',1),(16,'2023_01_05_092212_create_file_managers_table',1),(17,'2023_01_07_120244_create_banks_table',1),(18,'2023_01_07_120245_create_pages_table',1),(19,'2023_01_30_071830_create_orders_table',1),(20,'2023_02_11_130034_create_packages_table',1),(21,'2023_02_12_123347_create_user_packages_table',1),(22,'2023_05_10_121127_create_k_y_c_gateways_table',1),(23,'2023_05_15_114835_create_user_documents_table',1),(24,'2023_05_23_050518_create_new_articles_table',1),(25,'2023_05_23_105029_create_referral_users_table',1),(26,'2023_05_25_070128_create_frontend_sections_table',1),(27,'2023_05_27_100921_create_hero_sections_table',1),(28,'2023_05_29_125747_create_contact_messages_table',1),(29,'2023_05_31_053037_create_news_table',1),(30,'2023_06_08_105522_create_features_table',1),(31,'2023_06_10_113910_create_services_table',1),(32,'2023_06_11_060437_create_faqs_table',1),(33,'2023_06_11_075340_create_table_plans',1),(34,'2023_06_11_112319_create_testimonials_table',1),(35,'2023_06_13_092019_create_teams_table',1),(36,'2023_06_13_123930_create_blog_tags_table',1),(37,'2023_06_13_124208_create_blog_categories_table',1),(38,'2023_06_13_124311_create_blogs_table',1),(39,'2023_06_13_124435_create_blog_tag',1),(40,'2023_06_14_133359_create_affiliation_histories_table',1),(41,'2023_06_15_134554_create_how_it_works_table',1),(42,'2023_06_17_140325_create_counter_areas_table',1),(43,'2023_06_18_110307_create_our_missions_table',1),(44,'2023_06_19_061340_create_user_activity_logs_table',1),(45,'2023_07_09_100721_create_notifications_table',1),(46,'2023_07_10_055110_add_column_in_users_table',1),(47,'2023_07_19_085919_create_business_hours_table',1),(48,'2023_07_19_131606_create_custom_pages_table',1),(49,'2023_07_20_052653_create_email_templates_table',1),(50,'2023_07_26_114704_create_categories_table',1),(51,'2023_07_26_131711_create_faq_categories_table',1),(52,'2023_07_27_065651_create_tickets_table',1),(53,'2023_07_30_115004_create_ticket_tag_table',1),(54,'2023_07_30_115952_create_tags_table',1),(55,'2023_07_30_120355_create_conversations_table',1),(56,'2023_07_30_141440_create_category_user_table',1),(57,'2023_07_30_154027_create_knowledge_categories_table',1),(58,'2023_07_30_162713_create_knowledge_table',1),(59,'2023_07_31_100806_create_tag_user_table',1),(60,'2023_07_31_115820_create_envatos_table',1),(61,'2023_08_01_111007_create_ticket_assignee_table',1),(62,'2023_08_02_105758_create_cms_settings_table',1),(63,'2023_08_02_114526_create_jobs_table',1),(64,'2023_08_08_130929_create_notification_seens_table',1),(65,'2023_08_09_063759_create_general_settings_table',1),(66,'2023_08_09_075609_create_varities_table',1),(67,'2023_08_09_084119_create_notes_table',1),(68,'2023_08_10_064946_create_instant_messages_table',1),(69,'2023_08_16_074843_create_chats_table',1),(70,'2023_08_17_093214_create_a_i_replays_table',1),(71,'2023_08_22_053154_create_chat_sessions_table',1),(72,'2023_08_22_084756_create_chat_configurations_table',1),(73,'2023_08_22_094452_create_ticket_ratings_table',1),(74,'2023_08_23_060128_create_rating_categories_table',1),(75,'2023_08_26_132245_create_ticket_seen_unseens_table',1),(76,'2023_09_05_095221_add_new_field_to_category_table',1),(77,'2023_09_05_095221_add_new_field_to_tickets_table',1),(78,'2023_09_19_090952_create_dynamic_fields_table',1),(79,'2023_09_19_104451_add_collision_detector_field_to_tickets_table',1),(80,'2023_09_19_121418_add_collision_maker_field_to_tickets_table',1),(81,'2023_09_20_102416_create_dynamic_field_data_table',1),(82,'2023_09_21_094606_add_new_field_to_dynamic_fields_table',1),(83,'2023_10_23_161530_create_announcements_table',1),(84,'2023_11_01_122203_add_new_field_to_domains_table',1),(85,'2023_11_01_190233_add_new_field_to_packages_table',1),(86,'2023_11_01_190255_add_new_field_to_user_packages_table',1),(87,'2023_11_02_190131_add_new_field_to_tickets_table',1),(88,'2023_11_09_110230_add_new_field_to_packages_table',1),(89,'2023_12_26_175609_create_ticket_license_verifies_table',1),(90,'2024_02_29_193156_add_new_field_to_ticket_license_verifies_table',1),(91,'2024_03_02_191326_add_new_field_to_users_table',1),(92,'2024_03_04_193034_add_new_field_to_ticket_ratings_table',1),(93,'2024_03_07_194403_add_new_field_to_contact_messages_table',1),(94,'2024_10_10_065853_add_field_verify_token_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `new_articles`
--

DROP TABLE IF EXISTS `new_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `new_articles` (
                                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                                `image` int NOT NULL,
                                `section_id` int NOT NULL,
                                `status` tinyint NOT NULL DEFAULT '0',
                                `deleted_at` timestamp NULL DEFAULT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                UNIQUE KEY `new_articles_title_unique` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_articles`
--

/*!40000 ALTER TABLE `new_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `new_articles` ENABLE KEYS */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
                        `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                        `image` int DEFAULT NULL,
                        `status` tinyint NOT NULL DEFAULT '0',
                        `created_at` timestamp NULL DEFAULT NULL,
                        `updated_at` timestamp NULL DEFAULT NULL,
                        `deleted_at` timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notes` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `ticket_id` bigint unsigned NOT NULL,
                         `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                         `file_id` bigint unsigned DEFAULT NULL,
                         `created_by` bigint unsigned NOT NULL,
                         `status` int NOT NULL DEFAULT '0',
                         `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;

--
-- Table structure for table `notification_seens`
--

DROP TABLE IF EXISTS `notification_seens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_seens` (
                                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                      `user_id` int DEFAULT NULL,
                                      `notification_id` int DEFAULT NULL,
                                      `created_at` timestamp NULL DEFAULT NULL,
                                      `updated_at` timestamp NULL DEFAULT NULL,
                                      PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_seens`
--

/*!40000 ALTER TABLE `notification_seens` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_seens` ENABLE KEYS */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `user_id` int DEFAULT NULL,
                                 `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `body` text COLLATE utf8mb4_unicode_ci,
                                 `link` text COLLATE utf8mb4_unicode_ci,
                                 `view_status` tinyint NOT NULL DEFAULT '0',
                                 `status` tinyint NOT NULL DEFAULT '1',
                                 `deleted_at` timestamp NULL DEFAULT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
                          `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                          `payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `user_id` bigint unsigned NOT NULL,
                          `package_id` bigint unsigned DEFAULT NULL,
                          `amount` double(8,2) DEFAULT '0.00',
                          `tax_amount` double(8,2) DEFAULT NULL,
                          `tax_percentage` double(8,2) DEFAULT NULL,
                          `system_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `gateway_id` bigint unsigned NOT NULL,
                          `gateway_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `conversion_rate` double(8,2) DEFAULT '1.00',
                          `duration_type` tinyint NOT NULL DEFAULT '1',
                          `subtotal` double(8,2) NOT NULL DEFAULT '0.00',
                          `total` double(8,2) DEFAULT '0.00',
                          `transaction_amount` double(8,2) DEFAULT '0.00',
                          `payment_status` tinyint DEFAULT '0' COMMENT '0=pending, 1=paid, 2=cancelled',
                          `bank_id` tinyint DEFAULT NULL,
                          `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `deposit_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `deposit_slip_id` bigint unsigned DEFAULT NULL,
                          `created_at` timestamp NULL DEFAULT NULL,
                          `updated_at` timestamp NULL DEFAULT NULL,
                          `deleted_at` timestamp NULL DEFAULT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `our_missions`
--

DROP TABLE IF EXISTS `our_missions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `our_missions` (
                                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `description_point` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `our_missions`
--

/*!40000 ALTER TABLE `our_missions` DISABLE KEYS */;
INSERT INTO `our_missions` VALUES (1,'The Zaidesk platform is the Most Probable solution.','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco ex ea commodo consequat. Duis aute irure dolor','[\"Diam dictumst faucibus dui aliquet aenean nascetur feugiat leo Etiam\",\"Blandit dignissim nulla varius tristique a sed integer ut tempor Diam dictumst\",\"Esd nam vulputate pellentesque quis. Varius a, nunc faucibus proin elementum\",\"Nteger interdum sodales scelerisque diam massa quam sit quis. Sed et du\"]','/frontend/assets/images/mission-image.jpg','2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `our_missions` ENABLE KEYS */;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `number_of_agent` int NOT NULL DEFAULT '0',
                            `access_community` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `dedicated_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `support` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `monthly_price` decimal(8,2) NOT NULL DEFAULT '0.00',
                            `yearly_price` decimal(8,2) NOT NULL DEFAULT '0.00',
                            `device_limit` int NOT NULL DEFAULT '1',
                            `status` tinyint NOT NULL DEFAULT '0' COMMENT 'active for 1 , deactivate for 0',
                            `is_default` tinyint NOT NULL DEFAULT '0' COMMENT 'default for 1 , not default for 0',
                            `is_trail` tinyint NOT NULL DEFAULT '0' COMMENT 'default for 1 , not default for 0',
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            `deleted_at` timestamp NULL DEFAULT NULL,
                            `custom_domain_setup` tinyint DEFAULT NULL,
                            `is_popular` tinyint NOT NULL DEFAULT '0',
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `packages_name_unique` (`name`),
                            UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (1,'Trail','Trail',0,'Trail Community',NULL,'Trail Support',0.00,0.00,1,1,0,1,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL,NULL,0),(2,'Basic','Basic',2,'Full Community',NULL,'Basic Support',10.00,120.00,1,1,0,0,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL,NULL,0),(3,'Standard','Standard',20,'Full Community',NULL,'Standard Support',50.00,600.00,1,1,0,0,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL,NULL,0),(4,'Premium','Premium',30,'Full Community',NULL,'Premium Support',100.00,1200.00,1,1,0,0,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL,NULL,0);
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `title` longtext COLLATE utf8mb4_unicode_ci,
                         `description` longtext COLLATE utf8mb4_unicode_ci,
                         `created_by` bigint unsigned DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'3','Terms Of Service','<div class=\"text-wraper\">\n        <h2>Changes to the Terms</h2>\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut\n            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\n            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in\n            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat\n            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n        <ul class=\"list-style-rounded\">\n            <li>Diam dictumst faucibus dui aliquet aenean nascetur feugiat leo Etiam dignissim orci\n                dignissim.</li>\n            <li>Blandit dignissim nulla varius tristique a sed integer ut tempor Diam dictumst faucibus.\n            </li>\n            <li>ed nam vulputate pellentesque quis. Varius a, nunc faucibus proin elementum id odio\n                auctor.</li>\n            <li>nteger interdum sodales scelerisque diam massa quam sit quis. Sed et dui a nam pulvinar.\n            </li>\n            <li>Pretium consectetur scelerisque blandit habitasse non ullamcorper enim.</li>\n        </ul>\n        <p>Eget purus aenean sit risus. Arcu, aliquam eget et viverra risus purus. Commodo fames\n            tristique dui pharetra elit aliquet morbi. Eget consectetur risus nunc lorem sit consequat\n            aliquet. Dolor velit consecte tur etiam scelerisque. Integer interdum sodales scelerisque\n            diam massa quam sit quis. Sed et dui a nam pulvinar. Tristique justo, donec lectus vitae,\n            cursus ligula ridiculus lacus, tincidunt. Diam dictumst faucib us dui aliquet aenean\n            nascetur feugiat leo. Etiam dignissim orci dignissim vitae.</p>\n        <p>aliquam eget et viverra risus purus. Commodo fames tristique dui pharetra elit aliquet morbi.\n            Eget consectetur risus nunc lorem sit consequat aliquet. Dolor velit consecte tur etiam\n            scelerisque. Integer interdum sodales scelerisque diam massa quam sit quis. Sed et dui a nam\n            pulvinar. Tristique justo, donec lectus vitae, cursus ligula ridiculus lacus, tincidunt.\n            Diam dictumst faucib us dui aliquet aenean nascetur feugiat leo. Etiam dignissim.</p>\n    </div>\n    <div class=\"text-wraper\">\n        <h2>Customer’s Obligations to End Users</h2>\n        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque\n            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi\n            architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit\n            aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione\n            voluptatem sequi nesciunt.</p>\n        <ul class=\"list-style-rounded\">\n            <li>Diam dictumst faucibus dui aliquet aenean nascetur feugiat leo Etiam dignissim orci\n                dignissim.</li>\n            <li>Blandit dignissim nulla varius tristique a sed integer ut tempor Diam dictumst faucibus.\n            </li>\n            <li>ed nam vulputate pellentesque quis. Varius a, nunc faucibus proin elementum id odio\n                auctor.</li>\n            <li>nteger interdum sodales scelerisque diam massa quam sit quis. Sed et dui a nam pulvinar.\n            </li>\n            <li>Pretium consectetur scelerisque blandit habitasse non ullamcorper enim.</li>\n        </ul>\n    </div>\n    <div class=\"text-wraper\">\n        <h2>License and Use Rights</h2>\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut\n            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\n            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in\n            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat\n            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque\n            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi\n            architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit\n            aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione\n            voluptatem sequi nesciunt.</p>\n    </div>\n    <div class=\"text-wraper\">\n        <h2>Warranties and Disclaimers</h2>\n        <p>Blandit dignissim nulla varius tristique a sed integer ut tempor. Augue interdum semper\n            bibendum amet sed. Dis in at ultricies tortor sit tellus. Habitant ornare aenean maecenas\n            pretium, dui ullamcorper quis. Egestas viverra et id aliquet faucibus rhoncus a.\n            Sollicitudin nisl nulla tempor pretium lorem at mauris faucibus pulvinar.</p>\n        <ol>\n            <li>Eget purus aenean sit risus. Arcu, aliquam eget et viverra risus purus. Commodo fames\n                tristique\n                dui pharetra elit aliquet morbi aliquam eget et viverra risus purus</li>\n            <li> Commodo fames tristique dui pharetra elit aliquet morbi. et consectetur risus nunc\n                lorem sit\n                consequat aliquet. Dolor velit consectetur etiam scelerisque. Integer interdum sodales\n                scelerisque diam\n                massa quam sit\n            </li>\n            <li>ristique justo, donec lectus vitae. cursus ligula ridiculus lacus, tincidunt. Diam\n                dictumst faucibus dui\n                aliquet aenean nascetur feugiat leo. Etiam dignissim orci dignissim vitae</li>\n            <li>Nullam morbi ornare tellus felis. Morbi senectus nibh amet a, pellentesque tincidunt. In\n                consectetur\n                elementum consectetur facilisis ut eu diam. Pellentesque quam fringilla in egestas id\n                consequat.</li>\n        </ol>\n        <p>Dignissim nulla varius tristique a sed integer ut tempor. Augue interdum semper bibendum amet amet sed. Dis in at ultricies tortor sit tellus. Habitant ornare aenean maecenas pretium, dui ullamcorper quis. Egestas viverra et id aliquet faucibus rhoncus a. Sollicitudin nisl nulla tempor pretium lorem at mauris faucibus pulvinar.Nunc, suspendisse consequat libero, pharetra tellus vulputate auctor venenatis tortor non rhoncus at duis. Pharetra ipsum mauris integer sit feugiat.Eget purus aenean sit risus. Arcu, aliquam eget et viverra risus purus. Commodo fames tristique dui pharetra elit aliquet morbi. Eget consectetu risus nunc lorem sit consequat aliquet.</p>\n        <ul>\n            <li>Blandit dignissim nulla varius tristique a sed integer ut tempor.</li>\n            <li>Id ipsum mi tempor eget. Pretium consectetur scelerisque blandit habitasse non ullamcorper enim</li>\n            <li>diam quam id et, tempus massa. Sed nam vulputate pellentesque quis. Varius a, nunc faucibus</li>\n        </ul>\n    </div>\n    <div class=\"text-wraper\">\n        <h2>Ownership Rights</h2>\n        <p>Malesuada tortor at mattis semper aenean. Tristique nisi pellentesque fringilla ipsum sed amet dui amet mattis. Eleifend orci sed pulvinar blandit aliquam nisl sed libero amet. Etiam lectus sed enim eu commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus. Sit lacus id pretium malesuada velit.</p>\n        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Eleifend orci sed pulvinar blandit aliquam nisl sed libero amet. Etiam lectus sed enim eu commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus.</p>\n    </div>\n    <div class=\"text-wraper\">\n        <h2>Limitations of Liability</h2>\n        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Eleifend orci sed pulvinar blandit aliquam nisl sed libero amet. Etiam lectus sed enim eu commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus.</p>\n        <ul>\n            <li>Blandit dignissim. nulla varius tristique a sed integer ut tempor.</li>\n            <li>Id ipsum mi tempor. eget Pretium consectetur scelerisque blandit habitasse non ullamcorper enim</li>\n            <li>diam quam id et, tempus massa. Sed nam vulputate pellentesque quis. Varius a, nunc faucibus</li>\n            <li>Neque rhoncus in amet ipsum. eget lacus odio. Viverra mus eu amet risus tempor pretium habitant et.</li>\n            <li>Etiam lectus sed enim eu. commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus.</li>\n        </ul>\n    </div>',1,'2024-03-11 09:00:26','2024-03-11 09:00:26',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
                                         `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                         `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                         `created_at` timestamp NULL DEFAULT NULL,
                                         PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
                                   `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
                                          `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                          `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `tokenable_id` bigint unsigned NOT NULL,
                                          `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `abilities` text COLLATE utf8mb4_unicode_ci,
                                          `last_used_at` timestamp NULL DEFAULT NULL,
                                          `expires_at` timestamp NULL DEFAULT NULL,
                                          `created_at` timestamp NULL DEFAULT NULL,
                                          `updated_at` timestamp NULL DEFAULT NULL,
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
                                          KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `coin_id` bigint unsigned NOT NULL,
                         `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `base_price` decimal(16,8) NOT NULL,
                         `current_price` decimal(16,8) NOT NULL,
                         `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `duration_type` tinyint NOT NULL DEFAULT '1',
                         `return_type` tinyint NOT NULL DEFAULT '2',
                         `return_amount_per_day` decimal(16,8) NOT NULL DEFAULT '0.00000000',
                         `min_return_amount_per_day` decimal(16,8) NOT NULL DEFAULT '0.00000000',
                         `max_return_amount_per_day` decimal(16,8) NOT NULL DEFAULT '0.00000000',
                         `duration` int NOT NULL,
                         `status` tinyint NOT NULL DEFAULT '1',
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;

--
-- Table structure for table `rating_categories`
--

DROP TABLE IF EXISTS `rating_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rating_categories` (
                                     `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                     `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `status` tinyint NOT NULL DEFAULT '1',
                                     `deleted_at` timestamp NULL DEFAULT NULL,
                                     `created_at` timestamp NULL DEFAULT NULL,
                                     `updated_at` timestamp NULL DEFAULT NULL,
                                     PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_categories`
--

/*!40000 ALTER TABLE `rating_categories` DISABLE KEYS */;
INSERT INTO `rating_categories` VALUES (1,'Extremely Good',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(2,'Extremely Poor',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(3,'Somewhat Good',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(4,'Somewhat Poor',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(5,'Slightly Good',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(6,'Slightly Poor',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(7,'Good',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(8,'Poor',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(9,'Neutral',1,NULL,'2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `rating_categories` ENABLE KEYS */;

--
-- Table structure for table `referral_users`
--

DROP TABLE IF EXISTS `referral_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referral_users` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `user_id` bigint unsigned NOT NULL,
                                  `parent_id` bigint unsigned NOT NULL,
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  UNIQUE KEY `referral_users_user_id_unique` (`user_id`),
                                  KEY `referral_users_parent_id_foreign` (`parent_id`),
                                  CONSTRAINT `referral_users_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                  CONSTRAINT `referral_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referral_users`
--

/*!40000 ALTER TABLE `referral_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `referral_users` ENABLE KEYS */;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                            `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `status` tinyint NOT NULL DEFAULT '1',
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'World Wide Service','Morbi eget varius risus, venenatis liberoPellentesque in porta dui.','',1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(2,'Unlimited Gateway','Morbi eget varius risus, venenatis liberoPellentesque in porta dui.','',1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(3,'Margin Trading','Morbi eget varius risus, venenatis liberoPellentesque in porta dui.','',1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(4,'Cloud Mining','Morbi eget varius risus, venenatis liberoPellentesque in porta dui.','',1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(5,'Payment Options','Morbi eget varius risus, venenatis liberoPellentesque in porta dui.','',1,'2024-03-11 09:00:26','2024-03-11 09:00:26'),(6,'News And Articles','Morbi eget varius risus, venenatis liberoPellentesque in porta dui.','',1,'2024-03-11 09:00:26','2024-03-11 09:00:26');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `option_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `option_value` text COLLATE utf8mb4_unicode_ci,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'build_version','9','2024-03-11 09:00:25','2024-03-11 09:00:25'),(2,'current_version','2.4','2024-03-11 09:00:25','2024-03-11 09:00:25'),(3,'MAIL_FROM_ADDRESS','0','2024-03-11 09:00:25','2024-03-11 09:00:25');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

--
-- Table structure for table `tag_user`
--

DROP TABLE IF EXISTS `tag_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_user` (
                            `tag_id` bigint unsigned NOT NULL,
                            `user_id` bigint unsigned NOT NULL,
                            `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_user`
--

/*!40000 ALTER TABLE `tag_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_user` ENABLE KEYS */;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `status` tinyint NOT NULL DEFAULT '1',
                        `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `deleted_at` timestamp NULL DEFAULT NULL,
                        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `facebook_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `instagram_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `twitter_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `status` tinyint NOT NULL DEFAULT '0',
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
                           `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           `data` json DEFAULT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES ('zainiklab','2024-03-11 09:00:25','2024-03-11 09:00:25','[]');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
                                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `comment` tinytext COLLATE utf8mb4_unicode_ci,
                                `star` tinyint NOT NULL DEFAULT '5',
                                `status` tinyint NOT NULL DEFAULT '0',
                                `created_by` int NOT NULL,
                                `updated_by` int NOT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                `deleted_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;

--
-- Table structure for table `ticket_assignee`
--

DROP TABLE IF EXISTS `ticket_assignee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_assignee` (
                                   `ticket_id` bigint unsigned NOT NULL,
                                   `assigned_to` bigint unsigned NOT NULL,
                                   `assigned_by` bigint unsigned NOT NULL,
                                   `is_active` tinyint(1) NOT NULL DEFAULT '1',
                                   `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_assignee`
--

/*!40000 ALTER TABLE `ticket_assignee` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_assignee` ENABLE KEYS */;

--
-- Table structure for table `ticket_license_verifies`
--

DROP TABLE IF EXISTS `ticket_license_verifies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_license_verifies` (
                                           `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                           `ticket_id` bigint unsigned NOT NULL,
                                           `response_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                                           `verified_at` datetime DEFAULT NULL,
                                           `created_at` timestamp NULL DEFAULT NULL,
                                           `updated_at` timestamp NULL DEFAULT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_license_verifies`
--

/*!40000 ALTER TABLE `ticket_license_verifies` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_license_verifies` ENABLE KEYS */;

--
-- Table structure for table `ticket_ratings`
--

DROP TABLE IF EXISTS `ticket_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_ratings` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `ticket_id` int unsigned NOT NULL,
                                  `rating` int NOT NULL DEFAULT '0',
                                  `comment` text COLLATE utf8mb4_unicode_ci,
                                  `customer_id` int unsigned NOT NULL,
                                  `category_id` int unsigned NOT NULL,
                                  `status` int NOT NULL DEFAULT '1' COMMENT 'Inactive = 0, Active = 1',
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  `agent_id` int unsigned NOT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_ratings`
--

/*!40000 ALTER TABLE `ticket_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_ratings` ENABLE KEYS */;

--
-- Table structure for table `ticket_seen_unseens`
--

DROP TABLE IF EXISTS `ticket_seen_unseens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_seen_unseens` (
                                       `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                       `ticket_id` int NOT NULL DEFAULT '0',
                                       `conversion_id` int NOT NULL DEFAULT '0',
                                       `is_seen` tinyint NOT NULL DEFAULT '1',
                                       `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `created_by` int NOT NULL DEFAULT '0',
                                       `created_at` timestamp NULL DEFAULT NULL,
                                       `updated_at` timestamp NULL DEFAULT NULL,
                                       PRIMARY KEY (`id`),
                                       UNIQUE KEY `ticket_seen_unseens_ticket_id_created_by_unique` (`ticket_id`,`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_seen_unseens`
--

/*!40000 ALTER TABLE `ticket_seen_unseens` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_seen_unseens` ENABLE KEYS */;

--
-- Table structure for table `ticket_tag`
--

DROP TABLE IF EXISTS `ticket_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_tag` (
                              `ticket_id` bigint unsigned NOT NULL,
                              `tag_id` bigint unsigned NOT NULL,
                              `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `created_at` timestamp NULL DEFAULT NULL,
                              `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_tag`
--

/*!40000 ALTER TABLE `ticket_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_tag` ENABLE KEYS */;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
                           `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `tracking_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `ticket_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `ticket_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                           `envato_licence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `ticket_type` int NOT NULL DEFAULT '1' COMMENT 'External = 1, Internal = 2',
                           `category_id` bigint unsigned NOT NULL,
                           `subcategory_id` bigint unsigned DEFAULT NULL,
                           `created_by` bigint unsigned NOT NULL,
                           `last_reply_id` bigint unsigned DEFAULT NULL,
                           `last_reply_by` bigint unsigned DEFAULT NULL,
                           `last_reply_time` timestamp NULL DEFAULT NULL,
                           `status` int NOT NULL DEFAULT '0' COMMENT 'Open = 0, In-Progress = 1,Canceled = 2,On-Hold = 3,Closed = 4,Resolved = 5,Re-Open = 6',
                           `priority` int NOT NULL DEFAULT '1' COMMENT 'Low = 1, Medium = 2,High = 3,Critical = 4',
                           `file_id` text COLLATE utf8mb4_unicode_ci,
                           `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `label` int NOT NULL DEFAULT '1',
                           `deleted_at` timestamp NULL DEFAULT NULL,
                           `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                           `domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `collision_detector` datetime DEFAULT NULL,
                           `collision_maker` bigint DEFAULT NULL,
                           `status_change_by` bigint unsigned DEFAULT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;

--
-- Table structure for table `user_activity_logs`
--

DROP TABLE IF EXISTS `user_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_activity_logs` (
                                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                      `user_id` bigint unsigned NOT NULL,
                                      `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `ticket_id` int DEFAULT NULL,
                                      `deleted_at` timestamp NULL DEFAULT NULL,
                                      `created_at` timestamp NULL DEFAULT NULL,
                                      `updated_at` timestamp NULL DEFAULT NULL,
                                      PRIMARY KEY (`id`),
                                      KEY `user_activity_logs_user_id_foreign` (`user_id`),
                                      CONSTRAINT `user_activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activity_logs`
--

/*!40000 ALTER TABLE `user_activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_activity_logs` ENABLE KEYS */;

--
-- Table structure for table `user_documents`
--

DROP TABLE IF EXISTS `user_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_documents` (
                                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `user_id` bigint NOT NULL,
                                  `passport_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `driver_front_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `driver_back_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `nid_front_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `nid_back_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `verification_rejected_reason` text COLLATE utf8mb4_unicode_ci,
                                  `status` tinyint NOT NULL DEFAULT '2' COMMENT '1-Approve,2-Pending,3-Reject,',
                                  `deleted_at` timestamp NULL DEFAULT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_documents`
--

/*!40000 ALTER TABLE `user_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_documents` ENABLE KEYS */;

--
-- Table structure for table `user_packages`
--

DROP TABLE IF EXISTS `user_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_packages` (
                                 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                 `user_id` bigint unsigned NOT NULL,
                                 `package_id` bigint unsigned NOT NULL,
                                 `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `number_of_agent` int NOT NULL DEFAULT '0',
                                 `access_community` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `support` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `monthly_price` decimal(8,2) NOT NULL DEFAULT '0.00',
                                 `yearly_price` decimal(8,2) NOT NULL DEFAULT '0.00',
                                 `device_limit` int NOT NULL DEFAULT '1',
                                 `start_date` datetime NOT NULL,
                                 `end_date` datetime NOT NULL,
                                 `order_id` bigint unsigned DEFAULT NULL,
                                 `status` tinyint NOT NULL DEFAULT '0',
                                 `is_trail` tinyint NOT NULL DEFAULT '0' COMMENT 'default for 1 , not default for 0',
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 `deleted_at` timestamp NULL DEFAULT NULL,
                                 `custom_domain_setup` tinyint DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_packages`
--

/*!40000 ALTER TABLE `user_packages` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_packages` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `email_verified_at` timestamp NULL DEFAULT NULL,
                         `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `dob` date DEFAULT NULL,
                         `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `image` bigint unsigned DEFAULT NULL,
                         `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `status` tinyint NOT NULL DEFAULT '1',
                         `created_by` bigint DEFAULT NULL,
                         `role` tinyint NOT NULL DEFAULT '2',
                         `email_verification_status` tinyint NOT NULL DEFAULT '0',
                         `phone_verification_status` tinyint NOT NULL DEFAULT '0',
                         `otp` int DEFAULT NULL,
                         `otp_expiry` datetime DEFAULT NULL,
                         `google_auth_status` tinyint NOT NULL DEFAULT '0',
                         `google2fa_secret` text COLLATE utf8mb4_unicode_ci,
                         `passport_verification_status` tinyint NOT NULL DEFAULT '0',
                         `driving_license_verification_status` tinyint NOT NULL DEFAULT '0',
                         `national_id_verification_status` tinyint NOT NULL DEFAULT '0',
                         `total_document_verification_count` tinyint NOT NULL DEFAULT '0',
                         `ref_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `ref_level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
                         `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `facebook_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `tenant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `app_timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `announcement_seen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
                         `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `verify_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         `is_popular` tinyint NOT NULL DEFAULT '0',
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `users_uuid_unique` (`uuid`),
                         UNIQUE KEY `users_email_unique` (`email`),
                         UNIQUE KEY `users_mobile_unique` (`mobile`),
                         UNIQUE KEY `users_ref_code_unique` (`ref_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'12345','Admin Doe','admin@gmail.com',NULL,NULL,'$2y$10$qB.he53.ha6gfAIxqsavbutuW4ATVJDHsjfl9IRe85f4HSJobhYTK',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,0,0,NULL,NULL,0,'',0,0,0,0,NULL,'1',NULL,NULL,'zainiklab',NULL,NULL,'0',NULL,NULL,NULL,NULL,'2024-03-11 09:00:25',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Table structure for table `varities`
--

DROP TABLE IF EXISTS `varities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `varities` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `schedule_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `schedule_desc` text COLLATE utf8mb4_unicode_ci,
                            `ticket_tracking_no_pre_fixed` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `agent_fake_name` tinyint(1) NOT NULL DEFAULT '0',
                            `created_by` int NOT NULL DEFAULT '1',
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `varities`
--

/*!40000 ALTER TABLE `varities` DISABLE KEYS */;
/*!40000 ALTER TABLE `varities` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-11 15:00:44
