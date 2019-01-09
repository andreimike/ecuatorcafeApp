-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: ecuator_app
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `contractor_ean` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iln` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cui` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`contractor_ean`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES ('5940475172022','AUCHAN Romania SA TARGU MURES - 002','Mures, Targul Mures','5940477423917','Ro123781','2018-10-24 09:31:26','2018-10-24 09:31:26'),('5940475172053','AUCHAN Romania SA SUCEAVA - 009','Suceava, Romania','5940477423917','Ro123781','2018-10-24 09:31:26','2018-10-24 09:31:26'),('5940475172060','AUCHAN Romania SA MILITARI - 010','Bucuresti, Militari','5940477423917','Ro123781','2018-10-24 09:31:26','2018-10-24 09:31:26'),('5940475172091','AUCHAN Romania SA MILITARI - 010','Constanta, Romania','5940475172008','Ro123781','2018-10-24 09:31:26','2018-10-24 09:31:26'),('5940475172169','AUCHAN ROMANIA SA - BACAU - 034','Bacau, Romania','5940477423917','Ro123781','2018-10-24 09:31:26','2018-10-24 09:31:26');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_10_16_071459_create_upload_files_table',1),(4,'2018_10_17_071813_create_customers_table',1),(5,'2018_10_18_063726_create_products_table',2),(6,'2018_10_18_070159_create_orders_table',3),(7,'2018_10_18_125626_create_orders_table',4),(8,'2018_10_18_130137_change_product_length_to_orders',5),(9,'2018_10_18_132302_create_orders_table',6),(10,'2018_10_23_075332_create_options_table',7),(11,'2018_10_23_100601_create_options_table',8),(12,'2018_10_23_112118_create_options_table',9),(13,'2018_10_29_114447_add_serial_number_to_orders',10),(14,'2018_10_29_115515_create_options_table',11),(15,'2018_10_31_143129_add_pdf_local_path_to_orders',12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_number` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,80,NULL,NULL);
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` bigint(20) NOT NULL,
  `contractor_ean_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notice` tinyint(1) NOT NULL DEFAULT '0',
  `conformity_declaration` tinyint(1) NOT NULL DEFAULT '0',
  `dpd_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `smart_bill_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `serial_number` int(11) DEFAULT '0',
  `notice_pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_contractor_ean_id_foreign` (`contractor_ean_id`),
  CONSTRAINT `orders_contractor_ean_id_foreign` FOREIGN KEY (`contractor_ean_id`) REFERENCES `customers` (`contractor_ean`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,304390,'5940475172060','[{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":230,\"product_price\":15,\"frying_date\":\"2018-10-31\"},{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":20,\"product_price\":15,\"frying_date\":\"2018-10-28\"},{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":20,\"product_price\":15,\"frying_date\":\"2018-10-14\"}]',1,1,0,0,'2018-10-31 09:43:35','2018-11-01 09:31:20',1,'AvizNr-304390-2018-11-01.pdf'),(2,370197,'5940475172091','{\"3\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-31\"},\"4\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"},\"5\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-11-01 09:34:45',2,'AvizNr-370197-2018-11-01.pdf'),(3,588579,'5940475172169','{\"6\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":30,\"product_price\":15,\"frying_date\":\"2018-10-31\"},\"7\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"},\"8\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-10-31 13:52:58',3,NULL),(4,367635,'5940475172022','{\"9\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-31\"},\"10\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"},\"11\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-10-31 13:52:58',4,NULL),(5,234369,'5940475172053','{\"12\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-31\"},\"13\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"},\"14\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-10-31 13:52:58',5,NULL),(6,10234369,'5940475172053','{\"15\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-31\"},\"16\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"},\"17\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-10-31 13:52:58',6,NULL),(7,20234369,'5940475172053','{\"18\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-31\"},\"19\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"},\"20\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-10-31 13:52:58',7,NULL),(8,20234365,'5940475172053','{\"21\":{\"product_ean\":\"2000005405525\",\"product_name\":\"CAFEA COLUM BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-28\"},\"22\":{\"product_ean\":\"2000005405532\",\"product_name\":\"CAFEA ETHIOP BOABE200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-14\"},\"23\":{\"product_ean\":\"2000005405518\",\"product_name\":\"CAFEA BRAZ BOABE 200G ECUATOR\",\"product_qty\":10,\"product_price\":15,\"frying_date\":\"2018-10-31\"}}',1,1,0,0,'2018-10-31 09:43:35','2018-10-31 13:52:58',8,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `upload_files`
--

DROP TABLE IF EXISTS `upload_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upload_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cale_fisier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_files`
--

LOCK TABLES `upload_files` WRITE;
/*!40000 ALTER TABLE `upload_files` DISABLE KEYS */;
INSERT INTO `upload_files` VALUES (8,'files/import Clienti.xlsx-2018-10-18.xlsx',1,'2018-10-18 13:26:56','2018-10-18 13:26:56'),(9,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 13:27:36','2018-10-18 13:27:36'),(10,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 13:27:59','2018-10-18 13:27:59'),(11,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 13:28:43','2018-10-18 13:28:43'),(12,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 13:29:03','2018-10-18 13:29:03'),(13,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 13:29:43','2018-10-18 13:29:43'),(14,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 14:55:24','2018-10-18 14:55:24'),(15,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 14:57:00','2018-10-18 14:57:00'),(16,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 14:59:41','2018-10-18 14:59:41'),(17,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 16:13:23','2018-10-18 16:13:23'),(18,'orders/document.xls-2018-10-18.xls',1,'2018-10-18 16:14:11','2018-10-18 16:14:11'),(19,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 06:26:27','2018-10-19 06:26:27'),(20,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 06:26:51','2018-10-19 06:26:51'),(21,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 06:27:03','2018-10-19 06:27:03'),(22,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 06:27:52','2018-10-19 06:27:52'),(23,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 06:28:33','2018-10-19 06:28:33'),(24,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 06:39:53','2018-10-19 06:39:53'),(25,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 08:11:03','2018-10-19 08:11:03'),(26,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 08:11:47','2018-10-19 08:11:47'),(27,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 08:14:04','2018-10-19 08:14:04'),(28,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 08:15:24','2018-10-19 08:15:24'),(29,'orders/document.xls-2018-10-19.xls',1,'2018-10-19 08:20:19','2018-10-19 08:20:19'),(30,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 06:11:29','2018-10-22 06:11:29'),(31,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 06:11:46','2018-10-22 06:11:46'),(32,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 06:29:15','2018-10-22 06:29:15'),(33,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 06:30:35','2018-10-22 06:30:35'),(34,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:12:42','2018-10-22 11:12:42'),(35,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:15:09','2018-10-22 11:15:09'),(36,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:15:48','2018-10-22 11:15:48'),(37,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:16:12','2018-10-22 11:16:12'),(38,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:16:45','2018-10-22 11:16:45'),(39,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:19:55','2018-10-22 11:19:55'),(40,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:21:09','2018-10-22 11:21:09'),(41,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:21:36','2018-10-22 11:21:36'),(42,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:32:26','2018-10-22 11:32:26'),(43,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 11:32:39','2018-10-22 11:32:39'),(44,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:13:27','2018-10-22 16:13:27'),(45,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:14:54','2018-10-22 16:14:54'),(46,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:15:54','2018-10-22 16:15:54'),(47,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:17:49','2018-10-22 16:17:49'),(48,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:19:24','2018-10-22 16:19:24'),(49,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:23:51','2018-10-22 16:23:51'),(50,'orders/document.xls-2018-10-22.xls',1,'2018-10-22 16:25:33','2018-10-22 16:25:33'),(51,'orders/document.xls-2018-10-24.xls',1,'2018-10-24 09:13:04','2018-10-24 09:13:04'),(52,'orders/document.xls-2018-10-24.xls',1,'2018-10-24 09:13:44','2018-10-24 09:13:44'),(53,'files/import Clienti.xlsx-2018-10-24.xlsx',1,'2018-10-24 09:26:48','2018-10-24 09:26:48'),(54,'files/import Clienti.xlsx-2018-10-24.xlsx',1,'2018-10-24 09:31:26','2018-10-24 09:31:26'),(55,'orders/document.xls-2018-10-24.xls',1,'2018-10-24 09:39:50','2018-10-24 09:39:50'),(56,'orders/document.xls-2018-10-24.xls',1,'2018-10-24 11:45:40','2018-10-24 11:45:40'),(57,'orders/document.xls-2018-10-31.xls',1,'2018-10-31 09:43:34','2018-10-31 09:43:34'),(58,'files/import Clienti.xlsx-2018-11-01.xlsx',1,'2018-11-01 09:46:34','2018-11-01 09:46:34');
/*!40000 ALTER TABLE `upload_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `users` VALUES (1,'mike','mike@waveit.ro','$2y$10$jOb5ZrnjEX52UKMCTRBfZOhgi2UEcg3Cqm.eoiv1ylCYCu6c/kkji','fZFMernoTebcdPGD44cY7aDQnrmGVAhUHjN66wnaEPaMVxchBo2ZA7aMgNR6','2018-10-17 07:31:12','2018-10-17 07:31:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-01 13:06:17
