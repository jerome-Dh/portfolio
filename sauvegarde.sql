# noinspection SqlNoDataSourceInspectionForFile

-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: id15236741_portfolio
-- ------------------------------------------------------
-- Server version	5.7.32-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `experience_technologie`
--

DROP TABLE IF EXISTS `experience_technologie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experience_technologie` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `experience_id` bigint(20) unsigned NOT NULL,
  `technologie_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `experience_technologie_experience_id_foreign` (`experience_id`),
  KEY `experience_technologie_technologie_id_foreign` (`technologie_id`),
  CONSTRAINT `experience_technologie_experience_id_foreign` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `experience_technologie_technologie_id_foreign` FOREIGN KEY (`technologie_id`) REFERENCES `technologies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experience_technologie`
--

LOCK TABLES `experience_technologie` WRITE;
/*!40000 ALTER TABLE `experience_technologie` DISABLE KEYS */;
INSERT INTO `experience_technologie` VALUES (1,7,1,'2020-10-30 22:39:07','2020-10-30 22:39:07'),(2,7,7,'2020-10-30 22:39:21','2020-10-30 22:39:21'),(3,7,8,'2020-10-30 22:39:33','2020-10-30 22:39:33'),(4,7,9,'2020-10-30 22:39:38','2020-10-30 22:39:38'),(5,7,10,'2020-10-30 22:39:51','2020-10-30 22:39:51'),(7,8,1,'2020-10-30 22:45:01','2020-10-30 22:45:01'),(8,8,2,'2020-10-30 22:45:09','2020-10-30 22:45:09'),(9,8,6,'2020-10-30 22:47:39','2020-10-30 22:47:39'),(10,8,3,'2020-10-30 22:47:49','2020-10-30 22:47:49'),(11,8,4,'2020-10-30 22:48:12','2020-10-30 22:48:12'),(12,8,5,'2020-10-30 22:48:19','2020-10-30 22:48:19'),(13,5,1,'2020-10-30 22:51:01','2020-10-30 22:51:01'),(14,5,14,'2020-10-30 22:51:09','2020-10-30 22:51:09'),(15,5,15,'2020-10-30 22:51:30','2020-10-30 22:51:30'),(16,5,16,'2020-10-30 22:51:35','2020-10-30 22:51:35'),(17,5,17,'2020-10-30 22:51:41','2020-10-30 22:51:41'),(18,6,1,'2020-10-30 22:52:32','2020-10-30 22:52:32'),(19,6,11,'2020-10-30 22:52:40','2020-10-30 22:52:40'),(20,6,5,'2020-10-30 22:52:55','2020-10-30 22:52:55'),(21,6,12,'2020-10-30 22:53:02','2020-10-30 22:53:02'),(22,6,13,'2020-10-30 22:53:10','2020-10-30 22:53:10'),(23,3,1,'2020-10-30 22:54:11','2020-10-30 22:54:11'),(24,3,19,'2020-10-30 22:54:25','2020-10-30 22:54:25'),(25,3,20,'2020-10-30 22:54:33','2020-10-30 22:54:33'),(26,3,21,'2020-10-30 22:54:45','2020-10-30 22:54:45'),(27,4,1,'2020-10-30 22:55:40','2020-10-30 22:55:40'),(28,4,7,'2020-10-30 22:55:45','2020-10-30 22:55:45'),(29,4,8,'2020-10-30 22:55:52','2020-10-30 22:55:52'),(30,4,9,'2020-10-30 22:56:04','2020-10-30 22:56:04'),(31,4,18,'2020-10-30 22:56:12','2020-10-30 22:56:12'),(32,2,1,'2020-10-30 22:56:55','2020-10-30 22:56:55'),(33,2,22,'2020-10-30 22:57:02','2020-10-30 22:57:02'),(34,2,15,'2020-10-30 22:57:10','2020-10-30 22:57:10'),(35,1,1,'2020-10-30 22:57:34','2020-10-30 22:57:34'),(36,1,23,'2020-10-30 22:57:42','2020-10-30 22:57:42'),(37,1,9,'2020-10-30 22:57:55','2020-10-30 22:57:55'),(38,1,21,'2020-10-30 22:58:01','2020-10-30 22:58:01'),(39,1,18,'2020-10-30 22:58:11','2020-10-30 22:58:11');
/*!40000 ALTER TABLE `experience_technologie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `experiences_name_en_unique` (`name_en`),
  UNIQUE KEY `experiences_name_fr_unique` (`name_fr`),
  KEY `experiences_author_id_foreign` (`author_id`),
  CONSTRAINT `experiences_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiences`
--

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (1,2014,'Zeiforme','Zeiforme','Social meetings, chat with a soul mate','Rencontres sociales, tchat avec l’âme sœur','rEa9cHYN3VuJyl65ecdJE0TLDXztovAvP0vcdyef.png',NULL,1,'2020-10-30 22:09:41','2020-10-30 23:28:08'),(2,2016,'Encryption','Encryption','Cryptography, homomorphic encryption with the Paillier cryptosystem','Cryptographie, chiffrement homomorphique avec le cryptosystème de Paillier','OQ83l2ZtPAa57YnepraNTofhdetWlGfJOa9qZ2Cd.png',NULL,1,'2020-10-30 22:13:46','2020-10-30 22:13:46'),(3,2018,'O\'Naturelle','O\'Naturelle','Inventory management and invoicing','Gestion des stocks et facturation','Mo1YtYT1msEPLt68boeQFGknBN7f8hnYGtugjiRI.png',NULL,1,'2020-10-30 22:15:01','2020-10-30 22:15:01'),(4,2018,'Glosus Sarl','Glosus ET\'S','Showcase, blog and presentation of the company\'s services','Vitrine, blog et presentation des services de l\'entreprise','Dr4wP4MsbLHdaAwGx6y6e4v9Bd8HyVK917ytDPDD.jpeg',NULL,1,'2020-10-30 22:17:15','2020-10-30 23:14:31'),(5,2019,'EpiSearch','EpiSearch','Semantic search engine on diseases and drugs using DBPedia as a source of data.','Moteur de recherche sémantique sur les maladies et médicaments en exploitant DBPedia comme source de données.','ompZ4UDHRdHot5rlfwg3GuEDCaLFrUlzjtZaQ0Fc.png','https://github.com/jerome-Dh/semantic-search',1,'2020-10-30 22:24:33','2020-10-30 22:24:33'),(6,2019,'Galapagos','Galapagos','Fast food, remote orders.','Restauration rapide, commandes a distance.','za3W14LzPMBD6RMH7GyTkWM2MDHLx9prUSZvMvIr.png','https://galapagosafrica.com/',1,'2020-10-30 22:26:03','2020-10-30 22:29:40'),(7,2020,'Muna Creativ','Muna Creativ','Showcase site, blog and presentation of services.','Site vitrine, blog et présentation des services.','Olxf2FBmubhYxUWVxsCPp2Ah1m8VveHiQdMHL55k.png','https://www.munacreativ.com/',1,'2020-10-30 22:27:20','2020-10-30 22:29:12'),(8,2020,'EGreen','EGreen','Staff management, organization of tasks, management of agricultural plantations.','Gestion du personnel, organisation des taches, gestion des plantations agricoles.','cx6Z30bn5ID6UPgAcTJZvtWwy0zUvwfnxzk1baR1.png','https://drive.google.com/file/d/1f255rQdkF0z3DXqQSQvLTP6ZKhZorOxV/view?usp=sharing',1,'2020-10-30 22:33:20','2020-10-30 22:37:10');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `illustrations`
--

DROP TABLE IF EXISTS `illustrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `illustrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_id` bigint(20) unsigned NOT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `illustrations_experience_id_foreign` (`experience_id`),
  KEY `illustrations_author_id_foreign` (`author_id`),
  CONSTRAINT `illustrations_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `illustrations_experience_id_foreign` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `illustrations`
--

LOCK TABLES `illustrations` WRITE;
/*!40000 ALTER TABLE `illustrations` DISABLE KEYS */;
INSERT INTO `illustrations` VALUES (1,'yQTg2cjIBFciuT20b75rA0g6DgM3ljpAQxqYhtHa.jpeg',7,1,'2020-10-30 23:01:49','2020-10-30 23:01:49'),(2,'IHVo6wOy7YvT5yrGIf0brzRyVy4FKmzFByVpv1FT.jpeg',7,1,'2020-10-30 23:02:20','2020-10-30 23:02:20'),(3,'IYT3I4Sh9oUs3AjigsKZ60hH1UwRdptD55JJF08s.jpeg',7,1,'2020-10-30 23:02:56','2020-10-30 23:02:56'),(4,'Vzy7oXpG5rQ2h5sZ3V2vras0LWkJGhqfM28saSNz.png',8,1,'2020-10-30 23:04:34','2020-10-30 23:04:34'),(5,'uxLK8coElN3ijYG2PEkZJ1YgpssOFkKuBh8scy4l.png',8,1,'2020-10-30 23:04:53','2020-10-30 23:04:53'),(6,'17ZjtDss3QQM1dDkRJwaqBjX22zCburuJKb82lOs.png',5,1,'2020-10-30 23:07:08','2020-10-30 23:07:08'),(7,'c2XTPJslAXyhjVFkZ5lf3D5HWiL3PwnPyVoO7y3q.png',5,1,'2020-10-30 23:07:16','2020-10-30 23:07:16'),(8,'5HcuF95uwqHVAp5wcN5AQKEH5CbhrIko6VKTt5hq.png',5,1,'2020-10-30 23:07:27','2020-10-30 23:07:27'),(9,'CTkQN2Am74OezibVxDsflRYJ65sHNCs9rhbXXU74.jpeg',6,1,'2020-10-30 23:08:41','2020-10-30 23:08:41'),(10,'w9wKVtAARnEIwphR7wDrEzcUxacSN9D3JYQW9Zea.png',6,1,'2020-10-30 23:09:02','2020-10-30 23:09:02'),(11,'VeQbv8MAnd2CMYwntN22ryR5SuGvUedbtjInvDCs.png',3,1,'2020-10-30 23:09:48','2020-10-30 23:09:48'),(12,'auabSJ7YJuO32JfKLN9IpjMaPHT0MI7adr3UJg1c.png',3,1,'2020-10-30 23:10:01','2020-10-30 23:10:01'),(13,'VGNpba3RZijS5dikXC78pq5o7gGrvb5mkcbtblHY.png',3,1,'2020-10-30 23:10:22','2020-10-30 23:10:22'),(14,'HT2LqbZMXjBhkjQO4dRaioqgDzXDVzjT0P6dQwwT.jpeg',4,1,'2020-10-30 23:11:25','2020-10-30 23:11:25'),(15,'RJlFpsVcp3abQebo0c5NaKMoKXYzH9XXynzgx6gf.png',4,1,'2020-10-30 23:11:54','2020-10-30 23:11:54'),(16,'1plvx4p0MRuyn60BzyUdLmYVBCdQUHCLpqyYobZn.png',4,1,'2020-10-30 23:14:07','2020-10-30 23:14:07'),(18,'WWRWzjLZa4o4RnDPsU0GDUQbnNt6V3b6qEsOsNJq.png',2,1,'2020-10-30 23:17:21','2020-10-30 23:17:21'),(19,'6SDLd7g3trim0rRs1SOffD1rZgrCY820PgOxB2kI.png',2,1,'2020-10-30 23:17:33','2020-10-30 23:17:33'),(20,'GAcwmjGZmwEwZpoYsUtRvms8if69WBHmegDbhi8Y.png',2,1,'2020-10-30 23:18:08','2020-10-30 23:18:08'),(21,'NDNpWxuq2cRfUiBxnOtwucz24ZUsLgKnkR052i5J.png',1,1,'2020-10-30 23:23:36','2020-10-30 23:23:36'),(22,'D2ndHHPFuOtcyjftP49ZCnpO7zG7P0DSCyUncOWF.png',1,1,'2020-10-30 23:23:49','2020-10-30 23:23:49'),(23,'NQiEfS7bWF0gYqKDDVx8ptPKkA6gU7aPCx4w6bpW.png',1,1,'2020-10-30 23:24:23','2020-10-30 23:24:23');
/*!40000 ALTER TABLE `illustrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_10_03_210342_create_experiences_table',1),(5,'2020_10_03_214931_create_technologies_table',1),(6,'2020_10_03_215518_create_experience_technologie_table',1),(7,'2020_10_03_231904_create_skills_table',1),(8,'2020_10_03_232459_create_modules_table',1),(9,'2020_10_03_233057_create_module_skill_table',1),(10,'2020_10_03_233340_create_works_table',1),(11,'2020_10_04_231033_create_illustrations_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_skill`
--

DROP TABLE IF EXISTS `module_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_skill` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) unsigned NOT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_skill_module_id_foreign` (`module_id`),
  KEY `module_skill_skill_id_foreign` (`skill_id`),
  CONSTRAINT `module_skill_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `module_skill_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_skill`
--

LOCK TABLES `module_skill` WRITE;
/*!40000 ALTER TABLE `module_skill` DISABLE KEYS */;
INSERT INTO `module_skill` VALUES (1,1,1,'2020-10-31 23:07:46','2020-10-31 23:07:46'),(2,5,1,'2020-10-31 23:07:53','2020-10-31 23:07:53'),(3,3,1,'2020-10-31 23:08:00','2020-10-31 23:08:00'),(4,4,1,'2020-10-31 23:08:11','2020-10-31 23:08:11'),(5,7,1,'2020-10-31 23:08:19','2020-10-31 23:08:19'),(6,2,1,'2020-10-31 23:08:26','2020-10-31 23:08:26'),(7,6,1,'2020-10-31 23:08:31','2020-10-31 23:08:31'),(8,8,1,'2020-10-31 23:09:09','2020-10-31 23:09:09'),(9,1,2,'2020-10-31 23:20:29','2020-10-31 23:20:29'),(10,9,2,'2020-10-31 23:20:39','2020-10-31 23:20:39'),(11,10,2,'2020-10-31 23:21:02','2020-10-31 23:21:02'),(12,4,2,'2020-10-31 23:21:11','2020-10-31 23:21:11'),(13,11,2,'2020-10-31 23:21:19','2020-10-31 23:21:19'),(14,12,2,'2020-10-31 23:21:28','2020-10-31 23:21:28'),(15,8,2,'2020-10-31 23:21:34','2020-10-31 23:21:34'),(16,13,2,'2020-10-31 23:21:41','2020-10-31 23:21:41'),(17,1,3,'2020-10-31 23:27:39','2020-10-31 23:27:39'),(18,14,3,'2020-10-31 23:27:48','2020-10-31 23:27:48'),(19,15,3,'2020-10-31 23:27:55','2020-10-31 23:27:55'),(20,16,3,'2020-10-31 23:28:06','2020-10-31 23:28:06'),(21,17,3,'2020-10-31 23:28:11','2020-10-31 23:28:11'),(22,18,3,'2020-10-31 23:28:20','2020-10-31 23:28:20'),(23,19,3,'2020-10-31 23:28:25','2020-10-31 23:28:25'),(24,20,3,'2020-10-31 23:28:30','2020-10-31 23:28:30'),(25,21,4,'2020-10-31 23:35:43','2020-10-31 23:35:43'),(26,22,4,'2020-10-31 23:35:49','2020-10-31 23:35:49'),(28,24,4,'2020-10-31 23:39:41','2020-10-31 23:39:41'),(29,25,4,'2020-10-31 23:39:49','2020-10-31 23:39:49'),(30,26,4,'2020-10-31 23:56:12','2020-10-31 23:56:12'),(31,27,4,'2020-10-31 23:59:43','2020-10-31 23:59:43');
/*!40000 ALTER TABLE `module_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leved` tinyint(4) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modules_name_en_unique` (`name_en`),
  UNIQUE KEY `modules_name_fr_unique` (`name_fr`),
  KEY `modules_author_id_foreign` (`author_id`),
  CONSTRAINT `modules_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'POO','POO',5,'6b0OB33K5i20JN0VVnhHT3NCpfesTyKNztEvyupT.png',1,'2020-10-31 23:03:26','2020-10-31 23:50:58'),(2,'CURL','CURL',4,NULL,1,'2020-10-31 23:03:45','2020-10-31 23:03:45'),(3,'API','API',4,NULL,1,'2020-10-31 23:04:12','2020-10-31 23:04:12'),(4,'ORM','ORM',5,NULL,1,'2020-10-31 23:04:27','2020-10-31 23:04:27'),(5,'Laravel','Laravel',4,'5k4UM2hr5Ma24R26nTawZgnLFK51FBVdvscu6Rlj.png',1,'2020-10-31 23:05:01','2020-10-31 23:05:01'),(6,'CLI','CLI',4,NULL,1,'2020-10-31 23:05:25','2020-10-31 23:05:25'),(7,'WordPress','WordPress',4,'T6JPSBuIk5UAb2saOcMGHXGvRiJOcZzSGE4hSqAU.png',1,'2020-10-31 23:06:01','2020-10-31 23:14:46'),(8,'HTTP','HTTP',5,'lG1qxDlzC0WG0I22TkpDMoT0PLHiaNngORNNLMzA.png',1,'2020-10-31 23:06:17','2020-11-01 00:02:30'),(9,'I/O','I/O',4,NULL,1,'2020-10-31 23:17:53','2020-10-31 23:17:53'),(10,'Socket','Socket',3,NULL,1,'2020-10-31 23:18:38','2020-10-31 23:18:38'),(11,'JavaFX','JavaFX',3,'zgRl8imD5bLwfde4Svk7TfTGx2g2UBC3jb9tENjc.png',1,'2020-10-31 23:19:21','2020-10-31 23:19:21'),(12,'Tomcat','Tomcat',2,NULL,1,'2020-10-31 23:19:39','2020-10-31 23:19:39'),(13,'Android','Android',4,'EESSRf5d4rqyPypUphBvPWWl0FiuQ5nxeRtqTRcR.png',1,'2020-10-31 23:20:13','2020-10-31 23:51:38'),(14,'RestFul','RestFul',4,NULL,1,'2020-10-31 23:24:42','2020-10-31 23:24:42'),(15,'Ajax','Ajax',5,NULL,1,'2020-10-31 23:24:55','2020-10-31 23:24:55'),(16,'ECMAScript','ECMAScript',2,'F0jRa2Iuqo0KDpD3QzlnoSKzghGyfMSouHfsKZYU.png',1,'2020-10-31 23:25:27','2020-10-31 23:48:57'),(17,'React\'Nat','React\'Nat',3,'mWEPIw4NYmtWUtpmRPN5EVM99WClPbGZowaBm1Dt.png',1,'2020-10-31 23:25:56','2020-10-31 23:32:04'),(18,'Canvas','Canvas',4,NULL,1,'2020-10-31 23:26:17','2020-10-31 23:26:17'),(19,'JQuery','JQuery',4,'xUXn46MZb24JbwvzMQoU9kCbqQqayaoJKqS8TACr.png',1,'2020-10-31 23:26:58','2020-10-31 23:30:13'),(20,'Local Storage','Local Storage',4,NULL,1,'2020-10-31 23:27:28','2020-10-31 23:27:28'),(21,'HTML5','HTML5',4,'W2yUgaG2wsobYxes2My5t8OP49h5qPQzt8bxHORU.png',1,'2020-10-31 23:33:13','2020-10-31 23:33:13'),(22,'CSS3','CSS3',4,'XceYhNThPqyDwEdVvEC4whYGAANmQPjBOcrqUvBR.png',1,'2020-10-31 23:34:45','2020-10-31 23:34:45'),(23,'Web Payment','Paiement Web',3,'EyFP87WZzaz2WGIqmhSG3rXZtghOJivcnXi5trfR.jpeg',1,'2020-10-31 23:35:30','2020-10-31 23:35:30'),(24,'Visa API','API VISA',3,'2z1e7k5syV0BrYdGzngSSzSHwRebudZOC2rMhInm.jpeg',1,'2020-10-31 23:39:05','2020-10-31 23:39:05'),(25,'MasterCard','MasterCard',3,'Tp956P29rsdDVXcQHrJ39ziufEfRgoOsb3guIcbm.jpeg',1,'2020-10-31 23:39:30','2020-10-31 23:39:30'),(26,'Shell','Shell',3,'emadPBXqDKUitdcqtAouTLvbv7oDCjQT7lZ5IAJ3.jpeg',1,'2020-10-31 23:56:01','2020-10-31 23:56:01'),(27,'SQL','SQL',4,'5asSYy6FuBTzqjSggQkqtf8SrIVA3I6lyqUk1HNB.png',1,'2020-10-31 23:59:30','2020-10-31 23:59:30');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subname_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subname_fr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `skills_name_en_unique` (`name_en`),
  UNIQUE KEY `skills_name_fr_unique` (`name_fr`),
  KEY `skills_author_id_foreign` (`author_id`),
  CONSTRAINT `skills_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'PHP','PHP','PHP 7.4','PHP 7.4',1,'2020-10-31 23:01:01','2020-10-31 23:01:01'),(2,'Java','Java','JDK 12','JDK 12',1,'2020-10-31 23:01:34','2020-10-31 23:01:34'),(3,'JavaScript','JavaScript','JS V8','JS V8',1,'2020-10-31 23:02:00','2020-10-31 23:02:00'),(4,'Others','Autres',NULL,NULL,1,'2020-10-31 23:32:29','2020-10-31 23:32:29');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `technologies`
--

DROP TABLE IF EXISTS `technologies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `technologies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `technologies_name_en_unique` (`name_en`),
  UNIQUE KEY `technologies_name_fr_unique` (`name_fr`),
  KEY `technologies_author_id_foreign` (`author_id`),
  CONSTRAINT `technologies_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `technologies`
--

LOCK TABLES `technologies` WRITE;
/*!40000 ALTER TABLE `technologies` DISABLE KEYS */;
INSERT INTO `technologies` VALUES (1,'Run on Desktop','S’exécute sur Ordinateur de bureau','1ANL2nOiWBoCXfFe7AtkEgI6l1PLvFeYkXN7FQ30.png',1,'2020-10-30 21:55:17','2020-10-30 21:55:17'),(2,'Run on mobile and smartphone','S’exécute sur mobile et smartphone','x8Fjn6SNIoXqZOvhyDEzZ9rXQQkfaIN3Jt26FaiI.png',1,'2020-10-30 21:55:55','2020-10-30 22:08:53'),(3,'Statistics','Statistiques','UBBFhj8s4tzH6GPnW2HCX0rek2RobUQ8FinduUse.png',1,'2020-10-30 21:56:13','2020-10-30 21:56:13'),(4,'React Native','React Native','Ivr6pRkm8aSh3Clo7AnacRtlnKjbYvzyTp4oR8hh.png',1,'2020-10-30 22:00:04','2020-10-30 22:00:04'),(5,'Laravel','Laravel','WpA5oPjNM1kfhgOzlZZdsIid7fdK7iPMpF8YyHSs.png',1,'2020-10-30 22:00:31','2020-10-30 22:00:31'),(6,'Users profiles','Profiles utilisateurs','3ImdKgiw7ADwZanSAPVVvCMeIXuTpdmrjKWOvAND.png',1,'2020-10-30 22:00:54','2020-10-30 22:00:54'),(7,'Feed','Flux','q29GefPGv2hVP2JryUrUT3YFSrgJdwZUpqsJduhb.png',1,'2020-10-30 22:01:13','2020-10-30 22:01:13'),(8,'News','Diffusion des informations','QSDnrAyxihCguNAXuJ57wtF0UGAlohbOI3zO8yEM.png',1,'2020-10-30 22:01:33','2020-10-30 22:01:33'),(9,'PHP','PHP','l9uJblym7O4njKuNdNsrNBjuFNljLpodbfC1BdJd.jpeg',1,'2020-10-30 22:01:55','2020-10-30 22:03:07'),(10,'Blog','Blog','6xW8ugMBMgnyDdlcq3ZXo29R5JVoIcEPly9yoWLW.png',1,'2020-10-30 22:02:12','2020-10-30 22:02:12'),(11,'Shopping cart','Panier d\'achat','OzLPvBzhpiRrurszfAMhsuMQnNlKQjH9D9u0EYBi.png',1,'2020-10-30 22:03:31','2020-10-30 22:03:31'),(12,'JavaScript','JavaScript','qqIBNqrT914GxH4G4E2LBPGP0kNGTf8MjivktHSC.png',1,'2020-10-30 22:03:50','2020-10-30 22:03:50'),(13,'Uikit','Uikit','f9MmY6pcnTo3w0nnoXAxgbtpxka5Inv1YRs0ydEW.jpeg',1,'2020-10-30 22:04:06','2020-10-30 22:04:06'),(14,'Semantic search','Recherche sémantique','POGkoBncgSYBjFfsHchFpEroMZ7DTT2g4P9ZVZtw.png',1,'2020-10-30 22:04:30','2020-10-30 22:04:30'),(15,'Java','Java','i40TZhA5KkAU3S8n7GzO7vYh49xWTBrexB5fbGid.png',1,'2020-10-30 22:04:49','2020-10-30 22:04:49'),(16,'JQuery','JQuery','uaYU1QChnmS96UFqXHkDvLEj376xs2xJGk5YZZqJ.png',1,'2020-10-30 22:05:13','2020-10-30 22:05:13'),(17,'PostgreSQL','PostgreSQL','6vNGaukr7Ps8VqKvUOpOzgrLbXbj5UTVjE5lN5fe.png',1,'2020-10-30 22:05:38','2020-10-30 22:05:38'),(18,'Bootstrap','Bootstrap','jbYAFBiVFyWWSlFaBan5l7XaqnbDPZJpoTmSNvrV.jpeg',1,'2020-10-30 22:05:56','2020-10-30 22:05:56'),(19,'Pie chart','Statistiques graphiques','gov6gcmwIZ6176FA4jlTf2DjYFag3QAyo4iBzPRM.png',1,'2020-10-30 22:06:16','2020-10-30 22:06:16'),(20,'JavaFX','JavaFX','AdnoZEhRFbu2JFwhtv4GgsdjO7DTxyQJCT00Zq1p.png',1,'2020-10-30 22:06:41','2020-10-30 22:06:41'),(21,'MySQL','MySQL','qZbLfKjPc4rBKnCzdTVaEthq7p6eFNB5rPptZvlM.png',1,'2020-10-30 22:07:02','2020-10-30 22:07:02'),(22,'Encryption','Chiffrement','9ddyAgEqi0Fz17W9K7OQD0NjDhm1xRlJsDC35GJk.png',1,'2020-10-30 22:07:16','2020-10-30 22:07:16'),(23,'Chat','Tchat','ImOdyUqV9iUgfnrYFtRFOwp9uyFh8ktUQKHErcdm.png',1,'2020-10-30 22:07:30','2020-10-30 22:07:30');
/*!40000 ALTER TABLE `technologies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jerome Dh','jdieuhou@gmail.com',NULL,'$2y$10$xcsCY15Gz63N6yAf6xhSEudTv1U099C.wx8mKXogrwHRrBL.cRN3.',2,NULL,'2020-10-30 20:56:17','2020-10-30 20:56:17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_fr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `works_name_en_unique` (`name_en`),
  UNIQUE KEY `works_name_fr_unique` (`name_fr`),
  KEY `works_author_id_foreign` (`author_id`),
  CONSTRAINT `works_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES (1,'Etoile Bleue Server','Etoile Bleue Server','Setting up a web server','Mise en place d\'un serveur Web','Etoile Bleue is a lightweight web server that implements the HTTP/2 protocol. It was designed to perform hybrid parallel execution to reduce query latency and then deliver high performance. This project was formalized in university research.','Etoile Bleue est un serveur Web léger qui implémente le protocole HTTP/2. Il a été conçu pour une exécution parallèle hybride afin de réduire la latence des requêtes et offrir des performances élevées. Ce projet est issu de la recherche universitaire.','XJBOXhGPgZLte03xZdv7lWZadp5jluE7H39TK9me.png','https://github.com/jerome-Dh/etoile-bleue-server',1,'2020-10-30 23:36:01','2020-10-30 23:40:30'),(2,'First Bicycle Runner','First Bicycle Runner','HTML5 game: The bike racer','Jeu HTML5: Le coureur à vélo','First Bicycle Runner is a bicycle racing game made with HTML5 and JavaScript. It can be running on browser.','First Bicycle Runner est un jeu de course de vélo réalisé avec HTML5 et JavaScript. Il peut être exécuté sur un navigateur.','H7REI3E4jo7BJ4YnB1eNbqXCBJYXnDLJ26PfY3jY.png','https://github.com/jerome-Dh/first-bicycle-runner',1,'2020-10-30 23:48:12','2020-10-30 23:48:12'),(3,'Dyno MVC','Dyno MVC','Framework PHP: Dyno MVC','Bibliothèque PHP: Dyno MVC','Dhyno is a framework for the development of web applications in PHP following an MVC architecture (Model–view–controller). It very simple and have some basic functionalities such as query management, response handler, sessions, etc.','Dhyno est un framework pour le développement d\'applications web en PHP suivant une architecture MVC (Model-Vue-Controleur). Il est très simple et possède quelques fonctionnalités de base telles que la gestion des requêtes, les réponses, etc.','NZTO1uw9kYpieuQQBX4enDq09tBexybCiNe5sQs6.png','https://github.com/jerome-Dh/dhyno',1,'2020-10-31 00:03:46','2020-10-31 00:05:06');
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-01  2:05:42
