CREATE DATABASE  IF NOT EXISTS `hotel` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `hotel`;
-- MySQL dump 10.13  Distrib 5.6.24, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: hotel
-- ------------------------------------------------------
-- Server version	5.6.24-0ubuntu2

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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity` tinyint(1) NOT NULL,
  `LOGS` text COLLATE utf8_unicode_ci NOT NULL,
  `actor` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `location` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (28,0,'Updated room information of room type: Single',15,'2015-02-02 23:44:51','2015-02-02 23:44:51',2),(29,0,'Updated booking ID of:91 by Jojsnadk kjklsdjfakjdl from cancelled to paid',15,'2015-02-03 22:14:50','2015-02-03 22:14:50',3),(30,0,'Updated booking ID of:103 by JAMES CARTER from paid to cancelled',15,'2015-02-03 22:17:57','2015-02-03 22:17:57',3),(31,0,'Updated booking ID of:3 by   from paid to cancelled',15,'2015-02-04 18:33:55','2015-02-04 18:33:55',3),(32,0,'Updated booking ID of:3 by   from cancelled to pending',15,'2015-02-04 18:34:10','2015-02-04 18:34:10',3),(33,0,'Updated room information of room type: Single',15,'2015-02-04 22:36:59','2015-02-04 22:36:59',2),(34,0,'Updated booking ID of:90 by WALK-IN WALK-IN from paid to pending',15,'2015-02-04 22:41:01','2015-02-04 22:41:01',3),(35,0,'Updated booking ID of:102 by Jonathan Espanol from paid to cancelled',15,'2015-02-04 22:41:05','2015-02-04 22:41:05',3),(36,0,'Updated booking ID of:104 by DFSADFA DFASDF from paid to cancelled',15,'2015-02-04 22:41:08','2015-02-04 22:41:08',3),(37,0,'Updated booking ID of:3 by   from pending to cancelled',15,'2015-02-04 22:41:24','2015-02-04 22:41:24',3),(38,0,'Added a room to: Single',15,'2015-02-04 22:41:55','2015-02-04 22:41:55',2),(39,0,'Updated Jonathan Espanol account information.',15,'2015-02-04 22:43:08','2015-02-04 22:43:08',1),(40,0,'Updated booking ID of:105 by WALK-IN WALK-IN from paid to cancelled',15,'2015-02-04 22:48:14','2015-02-04 22:48:14',3),(41,0,'Updated Jonathans Espanol account information.',15,'2015-02-04 22:48:33','2015-02-04 22:48:33',1),(42,0,'Updated Jonathans Espanol account information.',15,'2015-02-04 22:55:52','2015-02-04 22:55:52',1),(43,0,'Updated Kobe Bryant account information.',15,'2015-02-04 22:56:14','2015-02-04 22:56:14',1),(44,0,'Updated Kobe Bryant account information.',15,'2015-02-04 23:02:34','2015-02-04 23:02:34',1),(45,0,'Updated Kobe Bryant account information.',15,'2015-02-04 23:02:43','2015-02-04 23:02:43',1),(46,0,'Added a room to: Triple',15,'2015-02-04 23:11:54','2015-02-04 23:11:54',2),(47,0,'Updated room information of room type: Double',15,'2015-02-04 23:12:17','2015-02-04 23:12:17',2),(48,0,'Updated booking ID of:111 by Jonathan Espanol from pending to paid',15,'2015-02-06 00:55:25','2015-02-06 00:55:25',3),(49,0,'Updated booking ID of:117 by Jonathan Espanol from pending to paid',15,'2015-02-06 01:06:39','2015-02-06 01:06:39',3),(50,0,'Updated booking ID of:116 by Jonathan Espanol from pending to paid',15,'2015-02-06 01:06:42','2015-02-06 01:06:42',3),(51,0,'Updated booking ID of:115 by Jonathan Espanol from pending to paid',15,'2015-02-06 01:06:59','2015-02-06 01:06:59',3),(52,0,'Updated booking ID of:106 by James Carter from paid to paid',15,'2015-02-06 01:07:05','2015-02-06 01:07:05',3),(53,0,'Updated booking ID of:108 by Jonathan Espanol from pending to paid',15,'2015-02-06 01:07:08','2015-02-06 01:07:08',3),(54,0,'Updated booking ID of:105 by WALK-IN WALK-IN from cancelled to paid',15,'2015-02-06 01:07:25','2015-02-06 01:07:25',3),(55,0,'Updated booking ID of:104 by DFSADFA DFASDF from cancelled to paid',15,'2015-02-06 01:07:28','2015-02-06 01:07:28',3),(56,0,'Updated booking ID of:105 by WALK-IN WALK-IN from paid to cancelled',15,'2015-02-08 19:30:51','2015-02-08 19:30:51',3),(57,0,'Updated booking ID of:6 by Jonathan Espanol from cancelled to cancelled',15,'2015-02-09 19:21:43','2015-02-09 19:21:43',3),(58,0,'Updated booking ID of:7 by Jonathan Espanol from pending to cancelled',15,'2015-02-09 19:22:51','2015-02-09 19:22:51',3),(59,0,'Updated booking ID of:6 by Jonathan Espanol from cancelled to paid',15,'2015-02-09 19:54:40','2015-02-09 19:54:40',3),(60,0,'Updated booking ID of:7 by Jonathan Espanol from cancelled to paid',15,'2015-02-09 19:55:24','2015-02-09 19:55:24',3),(61,0,'Updated booking ID of:6 by Jonathan Espanol from paid to cancelled',15,'2015-02-09 20:39:05','2015-02-09 20:39:05',3),(62,0,'Updated booking ID of:7 by Jonathan Espanol from paid to cancelled',15,'2015-02-09 20:43:22','2015-02-09 20:43:22',3),(63,0,'Updated booking ID of:6 by Jonathan Espanol from cancelled to paid',15,'2015-02-09 20:43:43','2015-02-09 20:43:43',3),(64,0,'Updated booking ID of:13 by WALK-IN WALK-IN from pending to paid',15,'2015-02-10 00:55:52','2015-02-10 00:55:52',3),(65,0,'Updated booking ID of:14 by WALK-IN WALK-IN from pending to paid',15,'2015-02-10 00:57:56','2015-02-10 00:57:56',3),(66,0,'Updated booking ID of:15 by WALK-IN WALK-IN from pending to paid',15,'2015-02-10 01:00:38','2015-02-10 01:00:38',3),(67,0,'Updated booking ID of:16 by Jonathan Espanol from pending to cancelled',15,'2015-02-10 21:55:02','2015-02-10 21:55:02',3),(68,0,'Updated room information of room type: Double',15,'2015-02-16 23:09:53','2015-02-16 23:09:53',2),(69,0,'Updated room information of room type: Double',15,'2015-02-16 23:10:03','2015-02-16 23:10:03',2),(70,0,'Updated room information of room type: Double',15,'2015-02-16 23:11:21','2015-02-16 23:11:21',2),(71,0,'Updated room information of room type: Double',15,'2015-02-16 23:12:22','2015-02-16 23:12:22',2),(72,0,'Updated booking ID of:24 by WALK-IN WALK-IN from pending to paid',13,'2015-09-08 18:18:10','2015-09-08 18:18:10',3),(73,0,'Updated booking ID of:27 by WALK-IN WALK-IN from pending to paid',13,'2015-09-08 21:36:48','2015-09-08 21:36:48',3),(74,0,'Updated booking ID of:31 by WALK-IN WALK-IN from pending to paid',13,'2015-09-09 21:43:21','2015-09-09 21:43:21',3),(75,0,'Updated booking ID of:53 by Jonathan Espanol from paid to ',13,'2015-09-16 17:52:07','2015-09-16 17:52:07',3),(76,0,'Updated booking ID of:53 by Jonathan Espanol from  to ',13,'2015-09-16 17:59:37','2015-09-16 17:59:37',3),(77,0,'Updated booking ID of:53 by Jonathan Espanol from  to ',13,'2015-09-16 17:59:45','2015-09-16 17:59:45',3),(78,0,'Updated booking ID of:52 by WALK-IN WALK-IN from pending to paid',13,'2015-09-16 18:00:10','2015-09-16 18:00:10',3),(79,0,'Updated booking ID of:52 by WALK-IN WALK-IN from paid to ',13,'2015-09-16 18:00:18','2015-09-16 18:00:18',3),(80,0,'Updated booking ID of:54 by WALK-IN WALK-IN from pending to paid',13,'2015-09-16 18:41:05','2015-09-16 18:41:05',3),(81,0,'Updated booking ID of:54 by WALK-IN WALK-IN from paid to ',13,'2015-09-16 18:41:15','2015-09-16 18:41:15',3),(82,0,'Updated booking ID of:51 by WALK-IN WALK-IN from pending to paid',13,'2015-09-16 18:43:06','2015-09-16 18:43:06',3),(83,0,'Updated booking ID of:50 by WALK-IN WALK-IN from pending to paid',13,'2015-09-16 18:43:14','2015-09-16 18:43:14',3),(84,0,'Updated booking ID of:55 by WALK-IN WALK-IN from pending to cancelled',13,'2015-09-16 18:45:35','2015-09-16 18:45:35',3),(85,0,'Updated booking ID of:56 by WALK-IN WALK-IN from pending to paid',13,'2015-09-16 18:45:48','2015-09-16 18:45:48',3),(86,0,'Updated booking ID of:53 by Jonathan Espanol from  to ',13,'2015-09-16 22:26:15','2015-09-16 22:26:15',3),(87,0,'Updated booking ID of:152 by   from pending to cancelled',13,'2015-09-18 00:38:16','2015-09-18 00:38:16',3),(88,0,'Updated booking ID of:159 by WALK-IN WALK-IN from pending to paid',13,'2015-09-22 06:19:16','2015-09-22 06:19:16',3),(89,0,'Updated booking ID of:160 by WALK-IN WALK-IN from paid to paid',13,'2015-09-22 07:28:08','2015-09-22 07:28:08',3),(90,0,'Updated booking ID of:153 by Jonathan Espanol from pending to cancelled',13,'2015-09-22 08:27:22','2015-09-22 08:27:22',3),(91,0,'Updated booking ID of:158 by fdgfd fgsfg from paid to ',13,'2015-09-22 08:41:05','2015-09-22 08:41:05',3),(92,0,'Updated booking ID of:169 by WALK-IN WALK-IN from pending to cancelled',13,'2015-09-29 05:48:14','2015-09-29 05:48:14',3),(93,0,'Updated booking ID of:165 by WALK-IN WALK-IN from paid to ',13,'2015-09-29 07:49:27','2015-09-29 07:49:27',3),(94,0,'Updated booking ID of:151 by WALK-IN WALK-IN from paid to ',13,'2015-09-29 07:50:16','2015-09-29 07:50:16',3),(95,0,'Updated booking ID of:168 by WALK-IN WALK-IN from paid to ',13,'2015-09-29 08:52:01','2015-09-29 08:52:01',3),(96,0,'Updated booking ID of:176 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 01:47:12','2016-02-09 01:47:12',3),(97,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 01:48:57','2016-02-09 01:48:57',3),(98,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 01:52:14','2016-02-09 01:52:14',3),(99,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 01:52:33','2016-02-09 01:52:33',3),(100,0,'Updated booking ID of:176 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 01:52:45','2016-02-09 01:52:45',3),(101,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 01:53:29','2016-02-09 01:53:29',3),(102,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 02:11:38','2016-02-09 02:11:38',3),(103,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 02:46:22','2016-02-09 02:46:22',3),(104,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 02:58:22','2016-02-09 02:58:22',3),(105,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 03:03:19','2016-02-09 03:03:19',3),(106,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 03:05:59','2016-02-09 03:05:59',3),(107,0,'Updated booking ID of:173 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 03:06:37','2016-02-09 03:06:37',3),(108,0,'Updated booking ID of:175 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 03:07:14','2016-02-09 03:07:14',3),(109,0,'Updated booking ID of:175 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 03:29:41','2016-02-09 03:29:41',3),(110,0,'Updated booking ID of:175 by WALK-IN WALK-IN from pending to pending',13,'2016-02-09 05:55:46','2016-02-09 05:55:46',3),(111,0,'Updated booking ID of:175 by WALK-IN WALK-IN from pending to paid',13,'2016-02-09 06:28:15','2016-02-09 06:28:15',3),(112,0,'Updated booking ID of:181 by WALK-IN WALK-IN from paid to paid',13,'2016-02-16 02:28:58','2016-02-16 02:28:58',3),(113,0,'Updated booking ID of:181 by WALK-IN WALK-IN from paid to paid',13,'2016-02-16 02:35:23','2016-02-16 02:35:23',3),(114,0,'Updated booking ID of:175 by WALK-IN WALK-IN from  to ',13,'2016-02-19 06:22:25','2016-02-19 06:22:25',3),(115,0,'Updated booking ID of:151 by WALK-IN WALK-IN from  to pending',13,'2016-02-22 02:03:57','2016-02-22 02:03:57',3),(116,0,'Updated booking ID of:186 by Jonathan Espanol from paid to paid',13,'2016-02-22 05:42:52','2016-02-22 05:42:52',3),(117,0,'Updated booking ID of:186 by Jonathan Espanol from paid to paid',13,'2016-02-22 05:43:16','2016-02-22 05:43:16',3),(118,0,'Updated booking ID of:184 by Jonathan Espanol from paid to paid',13,'2016-02-22 05:44:55','2016-02-22 05:44:55',3),(119,0,'Updated booking ID of:184 by Jonathan Espanol from paid to paid',13,'2016-02-22 05:45:55','2016-02-22 05:45:55',3),(120,0,'Updated booking ID of:192 by Jonathan Espanol from paid to ',13,'2016-02-23 01:05:15','2016-02-23 01:05:15',3),(121,0,'Updated booking ID of:193 by WALK-IN WALK-IN from pending to cancelled',13,'2016-02-23 03:50:52','2016-02-23 03:50:52',3),(122,0,'Updated booking ID of:194 by WALK-IN WALK-IN from pending to cancelled',13,'2016-02-23 03:51:10','2016-02-23 03:51:10',3),(123,0,'Updated booking ID of:196 by WALK-IN WALK-IN from pending to cancelled',13,'2016-02-23 05:14:59','2016-02-23 05:14:59',3);
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_remarks_history`
--

DROP TABLE IF EXISTS `booking_remarks_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_remarks_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `deduction` double NOT NULL,
  `additional` double NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_remarks_history`
--

LOCK TABLES `booking_remarks_history` WRITE;
/*!40000 ALTER TABLE `booking_remarks_history` DISABLE KEYS */;
INSERT INTO `booking_remarks_history` VALUES (1,175,4,0,'','2016-02-09 03:29:41','2016-02-09 03:29:41'),(2,175,999,0,'Wrong','2016-02-09 05:55:45','2016-02-09 05:55:45'),(3,0,100,0,'Reduced 100 pesos','2016-02-16 02:35:23','2016-02-16 02:35:23'),(4,0,500,0,'This is to deduct 500','2016-02-19 06:22:25','2016-02-19 06:22:25'),(182,0,1,0,'Membership Discount','2016-02-21 17:43:21','2016-02-21 17:43:21'),(183,183,1,0,'Membership Discount','2016-02-21 17:46:22','2016-02-21 17:46:22'),(184,183,1,0,'Coupon Discount','2016-02-21 17:46:22','2016-02-21 17:46:22'),(185,184,200,0,'Membership Discount','2016-02-21 17:52:16','2016-02-21 17:52:16'),(186,184,500,0,'Coupon Discount','2016-02-21 17:52:16','2016-02-21 17:52:16'),(187,185,200,0,'Membership Discount','2016-02-21 17:53:54','2016-02-21 17:53:54'),(188,185,199.998,0,'Coupon Discount','2016-02-21 17:53:54','2016-02-21 17:53:54'),(189,186,200,0,'Membership Discount','2016-02-21 18:17:37','2016-02-21 18:17:37'),(190,186,199.998,0,'Coupon Discount','2016-02-21 18:17:37','2016-02-21 18:17:37'),(191,187,200,0,'Membership Discount','2016-02-21 18:33:39','2016-02-21 18:33:39'),(192,0,500,0,'This is just a test deductionsdf','2016-02-22 05:42:52','2016-02-22 05:42:52'),(193,0,500,0,'test deduction','2016-02-22 05:43:16','2016-02-22 05:43:16'),(194,184,500,0,'test','2016-02-22 05:45:55','2016-02-22 05:45:55'),(195,188,200,0,'Membership Discount','2016-02-21 22:08:38','2016-02-21 22:08:38'),(196,188,500,0,'Coupon Discount','2016-02-21 22:08:38','2016-02-21 22:08:38'),(197,190,200,0,'Membership Discount','2016-02-21 23:27:46','2016-02-21 23:27:46'),(198,192,200,0,'Membership Discount','2016-02-22 17:04:36','2016-02-22 17:04:36');
/*!40000 ALTER TABLE `booking_remarks_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `cancelled_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cancelled_remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `check_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `check_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `price` double DEFAULT NULL,
  `code` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `customer_paid` double DEFAULT NULL,
  `paid` double DEFAULT NULL,
  `invoice_no` int(10) unsigned NOT NULL,
  `payment_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'cash',
  `paypal_paymentId` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (190,3,'0000-00-00 00:00:00','','Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','jonathan.espanol@pythosinc.com','2016-02-21 23:27:46','2016-02-23 05:01:12','','2016-02-22 04:00:12','2016-02-23 03:59:11',1932.98,'zhkix20160222',NULL,1932.98,0,'paypal','QFVQ8EMP6T5SG'),(191,3,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-22 07:50:18','2016-02-23 05:01:12','','2016-02-22 04:00:00','2016-02-23 03:59:00',100,'N/A',NULL,100,0,'cash',NULL),(192,2,'0000-00-00 00:00:00','','Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','jonathan.espanol@pythosinc.com','2016-02-22 17:04:36','2016-02-23 01:05:15','','2016-02-23 04:00:12','2016-02-24 03:59:11',932.99,'mgcmt20160223',NULL,932.99,0,'paypal','QFVQ8EMP6T5SG'),(193,5,'2016-02-23 03:50:51','This is just a faulty booking','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 03:40:17','2016-02-23 03:50:51','','2016-02-23 04:00:00','2016-02-24 03:59:00',0,'N/A',NULL,0,0,'cash',NULL),(194,5,'2016-02-23 03:51:09','This is just a faulty booking','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 03:49:12','2016-02-23 03:51:09','','2016-02-23 04:00:00','2016-02-24 03:59:00',0,'N/A',NULL,0,0,'cash',NULL),(195,1,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:01:27','2016-02-23 05:02:27','','2016-02-23 04:00:00','2016-02-24 03:59:00',999.99,'N/A',NULL,1000,0,'cash',NULL),(196,5,'2016-02-23 05:14:59','This is just a faulty reservation','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:04:24','2016-02-23 05:14:59','','2016-02-23 04:00:00','2016-02-24 03:59:00',0,'N/A',NULL,0,0,'cash',NULL),(197,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:07:38','2016-02-23 05:07:38','','2016-02-23 04:00:00','2016-02-24 03:59:00',100,'N/A',NULL,NULL,0,'cash',NULL),(198,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:11:50','2016-02-23 05:11:51','','2016-02-23 04:00:00','2016-02-24 03:59:00',33,'N/A',NULL,NULL,0,'cash',NULL),(199,1,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:33:54','2016-02-23 05:34:13','','2016-02-23 04:00:00','2016-02-24 03:59:00',999.99,'N/A',NULL,1000,0,'cash',NULL),(200,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:40:41','2016-02-23 05:40:41','','2016-02-23 04:00:00','2016-02-24 03:59:00',999.99,'N/A',NULL,NULL,0,'cash',NULL),(201,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 05:44:10','2016-02-23 05:44:11','','2016-02-23 04:00:00','2016-02-24 03:59:00',33,'N/A',NULL,NULL,0,'cash',NULL),(202,1,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 06:00:01','2016-02-23 06:04:18','','2016-02-23 04:00:00','2016-02-24 03:59:00',33,'N/A',NULL,100,0,'cash',NULL),(203,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 06:38:30','2016-02-23 06:38:30','','2016-02-23 04:00:00','2016-02-24 03:59:00',999.99,'N/A',NULL,NULL,0,'cash',NULL),(204,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 06:53:14','2016-02-23 06:53:14','','2016-02-23 04:00:00','2016-02-24 03:59:00',100,'N/A',NULL,NULL,0,'cash',NULL),(205,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 06:56:01','2016-02-23 06:56:03','','2016-02-24 04:00:00','2016-02-25 03:59:00',100,'N/A',NULL,NULL,0,'cash',NULL),(206,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 06:58:10','2016-02-23 06:58:10','','2016-02-24 04:00:00','2016-02-25 03:59:00',33,'N/A',NULL,NULL,0,'cash',NULL),(207,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 07:01:22','2016-02-23 07:01:22','','2016-02-26 04:00:00','2016-02-27 03:59:00',999.99,'N/A',NULL,NULL,0,'cash',NULL),(208,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 07:02:29','2016-02-23 07:02:29','','2016-02-27 04:00:00','2016-02-28 03:59:00',999.99,'N/A',NULL,NULL,0,'cash',NULL),(209,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 07:06:33','2016-02-23 07:06:33','','2016-02-25 04:00:00','2016-02-26 03:59:00',999.99,'N/A',NULL,NULL,0,'cash',NULL),(210,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 07:07:56','2016-02-23 07:07:56','','2016-02-28 04:00:00','2016-02-29 03:59:00',100,'N/A',NULL,NULL,0,'cash',NULL),(211,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 07:09:32','2016-02-23 07:09:32','','2016-02-29 04:00:00','2016-03-01 03:59:00',100,'N/A',NULL,NULL,0,'cash',NULL),(212,0,'0000-00-00 00:00:00','','WALK-IN','WALK-IN','WALK-IN','000','WALK-IN','2016-02-23 07:16:11','2016-02-23 07:16:11','','2016-03-03 04:00:00','2016-03-04 03:59:00',33,'N/A',NULL,NULL,0,'cash',NULL);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_left` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_right` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `decimal_place` int(11) NOT NULL,
  `value` double(15,8) NOT NULL,
  `decimal_point` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `thousand_point` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'U.S. Dollar','$','','USD',2,1.00000000,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(2,'Euro','€','','EUR',2,0.74970001,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(3,'Pound Sterling','£','','GBP',2,0.62220001,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(4,'Australian Dollar','$','','AUD',2,0.94790000,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(5,'Canadian Dollar','$','','CAD',2,0.98500001,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(6,'Czech Koruna','','Kč','CZK',2,19.16900063,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(7,'Danish Krone','kr','','DKK',2,5.59420013,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(8,'Hong Kong Dollar','$','','HKD',2,7.75290012,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(9,'Hungarian Forint','Ft','','HUF',2,221.27000427,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(10,'Israeli New Sheqel','?','','ILS',2,3.73559999,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(11,'Japanese Yen','¥','','JPY',2,88.76499939,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(12,'Mexican Peso','$','','MXN',2,12.63899994,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(13,'Norwegian Krone','kr','','NOK',2,5.52229977,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(14,'New Zealand Dollar','$','','NZD',2,1.18970001,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(15,'Philippine Peso','Php','','PHP',2,40.58000183,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(16,'Polish Zloty','','zł','PLN',2,3.08590007,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(17,'Singapore Dollar','$','','SGD',2,1.22560000,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(18,'Swedish Krona','kr','','SEK',2,6.45870018,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(19,'Swiss Franc','CHF','','CHF',2,0.92259997,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(20,'Taiwan New Dollar','NT$','','TWD',2,28.95199966,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38'),(21,'Thai Baht','฿','','THB',2,30.09499931,'.',',',1,'2013-11-29 11:51:38','2013-11-29 11:51:38');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `membership_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_no` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pin` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`membership_id`),
  UNIQUE KEY `customers_email_address_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES ('1006196-2015','Test','Ulit','Hahah',123,'test@ulit.com','2015-09-30 06:41:10','2015-09-30 06:41:10','2015'),('1006953-2015','Jonathan','Espanol','Blk 7 lot 13, Maravilla',2432,'jonathan.espanol@pythosinc.com','2015-09-28 08:02:22','2015-09-28 08:02:22','2015'),('1085292-2015','Jonathan','Espanol','Cavite\r\nCavite',234,'tan0300@gmail.com','2015-09-28 06:26:47','2015-09-28 06:26:47','2015'),('1102847-2015','Testtt','Ulit','Hahah',123,'','2015-10-01 09:06:08','2015-10-01 09:06:08','2015'),('1102922-2015','Test ','testtest','Cavite\r\nCavite',2342,'etse@yah.com','2015-09-30 06:53:26','2015-09-30 06:53:26','2015');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounted_bookings`
--

DROP TABLE IF EXISTS `discounted_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounted_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `customer_discount_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounted_bookings`
--

LOCK TABLES `discounted_bookings` WRITE;
/*!40000 ALTER TABLE `discounted_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounted_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `used` datetime DEFAULT NULL,
  `effect` double DEFAULT NULL,
  `effect_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
INSERT INTO `discounts` VALUES (35,'This is a test',0,'50000000',NULL,'testlksdjflsafa','2015-10-01 08:38:25','2016-02-21 17:28:54','2016-02-22 01:28:54',100,0),(36,'500 Coupon ',0,'ASDFAJ500',NULL,'500 Pesos coupon discount','2015-10-01 08:52:03','2016-02-21 17:41:22','2016-02-22 01:41:22',500,0),(37,'500 Coupon ',0,'ASDFAJ5001',NULL,'500 Pesos coupon discount','2015-10-01 08:52:03','2016-02-21 22:07:50','2016-02-22 06:07:50',500,0),(38,'500 Coupon ',0,'503',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(39,'500 Coupon ',0,'504',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(40,'500 Coupon ',0,'505',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(41,'500 Coupon ',0,'506',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(42,'500 Coupon ',0,'507',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(43,'500 Coupon ',0,'508',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(44,'500 Coupon ',0,'509',NULL,'500 Pesos coupon discount','2015-10-01 08:52:04','2015-10-01 08:52:04',NULL,500,0),(45,'Membership',1,'',NULL,'20% Off','2015-10-02 01:07:23','2016-02-21 17:53:18','2016-02-22 01:53:18',20,1),(46,'This is a new ',0,'40000000000000',NULL,'dfafsffsdfsdf','2016-02-16 02:27:08','2016-02-16 02:27:08',NULL,5000,0),(47,'This is a new ',0,'50000000',NULL,'dfafsffsdfsdf','2016-02-16 02:27:08','2016-02-16 02:27:08',NULL,5000,0);
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts_customers`
--

DROP TABLE IF EXISTS `discounts_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discount_id` int(10) unsigned NOT NULL,
  `customer_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `expiration` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_discounts_customers_1_idx` (`discount_id`),
  KEY `fk_discounts_customers_2_idx` (`customer_id`),
  CONSTRAINT `fk_discounts_customers_1` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_discounts_customers_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`membership_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts_customers`
--

LOCK TABLES `discounts_customers` WRITE;
/*!40000 ALTER TABLE `discounts_customers` DISABLE KEYS */;
INSERT INTO `discounts_customers` VALUES (2,45,'1006953-2015','2016-03-02 15:21:04','2015-10-02 07:21:04','2015-10-02 07:21:04'),(3,45,'1085292-2015','2016-07-16 10:17:36','2016-02-16 02:17:36','2016-02-16 02:17:36');
/*!40000 ALTER TABLE `discounts_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (32,'9f079add26bb18d84a9d911059b88868.jpg','2014-12-28 22:54:53','2014-12-28 22:54:53'),(33,'3136645b26d832fdae8cee6ac8ffc456.jpg','2014-12-28 23:37:40','2014-12-28 23:37:40'),(34,'71a28b9e0c49c3a61c55b98ea8c9022b.jpg','2014-12-28 23:47:07','2014-12-28 23:47:07'),(35,'2af77c6a7f682f5304c2a9c7888763d7.jpg','2014-12-28 23:47:47','2014-12-28 23:47:47'),(51,'bacbaf4b4be7849b9d21bbec25f43560.jpg','2015-01-21 23:44:18','2015-01-21 23:44:18'),(52,'0e0c9778f607e6ec3e6d8f85c89ae8d5.jpg','2015-01-21 23:46:57','2015-01-21 23:46:57'),(53,'bcb6e80cafd400ada29cb4b40a5abd20.jpg','2015-01-21 23:47:45','2015-01-21 23:47:45'),(54,'9403876555fc33580319e185299811f6.jpg','2015-01-21 23:48:15','2015-01-21 23:48:15'),(55,'ec05ba2e8ebd0fef2b8a2f2e1a9e7538.jpg','2015-01-21 23:51:33','2015-01-21 23:51:33'),(56,'3f792d3d992883746f5430d9e5663bba.jpg','2015-01-21 23:52:05','2015-01-21 23:52:05'),(57,'e33107be9f9fd2e70e93c83687b7655c.jpg','2015-01-21 23:54:59','2015-01-21 23:54:59'),(58,'1301a4bbfa3c32af95ba77bf78effa7c.jpg','2015-01-21 23:56:05','2015-01-21 23:56:05'),(59,'5c15d16f68ffe2e94092f0738e67e631.jpg','2015-01-21 23:56:23','2015-01-21 23:56:23'),(60,'8e10782833e409b572d352aee13ac814.jpg','2015-01-21 23:56:55','2015-01-21 23:56:55'),(61,'7cad782b2d8d5ec8a6a9024c6d386d90.jpg','2015-01-21 23:57:26','2015-01-21 23:57:26'),(62,'3a3fe63070e73818170eb3a0e05a01ea.jpg','2015-01-21 23:57:46','2015-01-21 23:57:46'),(63,'0e9503ade81d69c6ecddba4d9ff720df.jpg','2015-01-21 23:57:51','2015-01-21 23:57:51'),(64,'4cb153503a90ab013d09f21fbad326a0.jpg','2015-01-22 00:00:44','2015-01-22 00:00:44'),(65,'b1e925d2977e607fef6b09b4b7001450.jpg','2015-01-22 00:01:41','2015-01-22 00:01:41'),(66,'5df685119a14b4bd1fbf4235743f160d.jpg','2015-01-22 00:01:48','2015-01-22 00:01:48'),(67,'24117d46081e9c511a713a39db993768.jpg','2015-01-22 00:01:54','2015-01-22 00:01:54'),(68,'13fdfdbcee318bed9c50bb256974d4bc.jpg','2015-01-22 00:02:05','2015-01-22 00:02:05'),(69,'77c7b6ba6c921635c769078b34078b2a.jpg','2015-01-22 00:02:31','2015-01-22 00:02:31'),(70,'bd1287f30e9697c376b408d083db71ca.jpg','2015-01-22 00:02:58','2015-01-22 00:02:58'),(71,'d9dd51f6fd5771cf3bf063764d08a534.jpg','2015-01-22 00:03:40','2015-01-22 00:03:40'),(72,'ee2dcb408927f9932b60da89c3db0ca6.jpg','2015-01-22 00:05:19','2015-01-22 00:05:19'),(73,'a562484a81e29cda85ca0979fc180410.jpg','2015-01-22 00:05:38','2015-01-22 00:05:38'),(74,'7dde0c2fb86be4eb184f9e2b86069c08.jpg','2015-01-22 00:06:05','2015-01-22 00:06:05'),(75,'d2d96911e741a4dd5dfff5ea408ede27.jpg','2015-01-22 00:06:50','2015-01-22 00:06:50'),(76,'1e73148e3690783f68a502f3bd0b2302.jpg','2015-01-22 00:07:10','2015-01-22 00:07:10'),(77,'cd468356c77653f0368be40ddd21a5d8.jpg','2015-01-22 00:07:56','2015-01-22 00:07:56'),(78,'2db764958b0a1570d3770294c75146a2.jpg','2015-01-22 00:08:34','2015-01-22 00:08:34'),(79,'b62020125fad11519b26d208a486d73b.jpg','2015-01-22 00:09:16','2015-01-22 00:09:16'),(80,'10d8f9f43213ae76d678e32248b544cc.jpg','2015-01-22 00:10:10','2015-01-22 00:10:10'),(81,'5df855519991102d305eb028dd72f77f.jpg','2015-01-22 00:11:02','2015-01-22 00:11:02'),(82,'401c4330fbb73a2017ad3194d170029c.jpg','2015-01-22 00:11:56','2015-01-22 00:11:56'),(83,'ebb56d7f1fc2504a777db69269bf4bb8.jpg','2015-01-22 00:19:56','2015-01-22 00:19:56'),(84,'a99622aad0627ce126db996764517dce.jpg','2015-01-22 00:21:22','2015-01-22 00:21:22'),(85,'2cdef8e17e67016ad7ff15ad2c0d2a42.jpg','2015-01-22 00:26:11','2015-01-22 00:26:11'),(86,'c586e3338bc5116543416cfba04b209a.jpg','2015-01-22 00:27:29','2015-01-22 00:27:29'),(87,'3f53c9d5c0318c60829483f2decf7bec.jpg','2015-01-22 00:28:02','2015-01-22 00:28:02'),(88,'29f28a808e800025d4de4c2b86a00850.jpg','2015-01-22 00:28:29','2015-01-22 00:28:29'),(89,'9c4fdbcb88ecade73b3b1125f9467a6b.jpg','2015-01-22 00:30:42','2015-01-22 00:30:42'),(90,'da9615f1212189771c657babe00913c2.jpg','2015-01-22 00:31:42','2015-01-22 00:31:42'),(91,'264a04bcce91e7444940765374e6a3e5.jpg','2015-01-22 00:32:47','2015-01-22 00:32:47'),(92,'60ddadbcaf4bb869b4e9ec22bce9d1af.jpg','2015-01-22 00:33:22','2015-01-22 00:33:22'),(93,'d073af2e7d52f8ca81c6cdfccbc57a78.jpg','2015-01-22 00:37:08','2015-01-22 00:37:08'),(94,'5907259d2458bd4458195af26dc867af.jpg','2015-01-22 00:37:45','2015-01-22 00:37:45'),(95,'f57dace54a34e3cfe1425f0a12900889.jpg','2015-01-22 00:38:06','2015-01-22 00:38:06'),(96,'a012465de108b123a472801db7519b49.jpg','2015-01-22 00:39:54','2015-01-22 00:39:54'),(97,'8e4eee2ca339dc1795961c3450666e45.jpg','2015-01-22 00:41:11','2015-01-22 00:41:11'),(98,'baa9b7a5fd3a5f928a6b01414419f88f.jpg','2015-01-22 00:41:58','2015-01-22 00:41:58'),(99,'0e4b61366b8a726d5325607545c13aab.jpg','2015-01-22 00:42:44','2015-01-22 00:42:44'),(100,'b4d54aea6b653492e3ebf9b0aec09512.jpg','2015-01-22 00:43:41','2015-01-22 00:43:41'),(101,'ef2f8f4a84bcdbcbc6538c907938415f.jpg','2015-01-22 00:43:41','2015-01-22 00:43:41'),(102,'ca0741d914e7841909daa5161f0923a0.jpg','2015-01-22 00:44:44','2015-01-22 00:44:44'),(103,'8df87d773c9b01f392b3b11adb89486d.jpg','2015-01-22 00:48:14','2015-01-22 00:48:14'),(104,'5eff8b3d98cccf12f55afe3cc1864c45.jpg','2015-01-22 00:48:29','2015-01-22 00:48:29'),(105,'b1355136c72ca6c76217774791cb2997.jpg','2015-01-22 00:48:45','2015-01-22 00:48:45'),(106,'5187ddc4c9392f2b8741030c1db87240.jpg','2015-01-22 17:34:51','2015-01-22 17:34:51'),(107,'76b3dba84f482ad7949d8fdc3e3172dc.jpg','2015-02-02 18:15:12','2015-02-02 18:15:12'),(108,'a5fbabaa87b6355e34776cd396932414.jpg','2015-02-02 18:15:12','2015-02-02 18:15:12'),(109,'c6de91e3e0d000920a366a9ef5196943.jpg','2015-02-02 18:37:06','2015-02-02 18:37:06'),(110,'190e3f66e5399fed677c18c349a49edf.jpg','2015-02-02 18:42:19','2015-02-02 18:42:19'),(111,'f988606ff46039b10d7fe1f99376a30f.jpg','2015-02-02 18:42:23','2015-02-02 18:42:23'),(112,'78451d627688cd0618228f063e5fe768.jpg','2015-02-02 18:44:05','2015-02-02 18:44:05'),(113,'e4f02a7ce931874b4752042814769379.jpg','2015-02-02 18:47:52','2015-02-02 18:47:52'),(114,'856543205eec7a4e36f6988c609b668c.jpg','2015-02-02 18:48:51','2015-02-02 18:48:51'),(115,'6f4a2d8fb9c7415f8b6c164e31bce4d5.jpg','2015-02-02 20:21:46','2015-02-02 20:21:46'),(116,'b8e48f0d812f44ed8893f4a76c9efffd.jpg','2015-02-16 23:12:21','2015-02-16 23:12:21');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_12_22_014604_create_reserved_rooms',1),('2014_12_23_035747_create_roomqty_table',2),('2014_12_29_022124_create_images_table',3),('2014_12_29_023300_create_rooms_table',4),('2014_12_29_025601_create_room_images_table',5),('2015_01_05_020922_create_users_table',6),('2015_01_30_053152_create_activities_table',7),('2013_11_26_161501_create_currency_table',8),('2015_02_10_022244_create_bookings_table',9),('2015_09_23_083228_create_discounts_table',10),('2015_09_23_083300_create_discount_customers_table',11),('2015_09_23_083818_create_customers_table',12),('2015_09_23_084634_create_discounted_bookings',12),('2015_09_23_083229_create_discounts_table',13),('2015_09_23_083828_create_customers_table',14),('2016_02_09_093332_create_booking_remarks_history',15);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserved_rooms`
--

DROP TABLE IF EXISTS `reserved_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserved_rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `check_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `check_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - pending\n1 - success\n5 - cancelled',
  `firstname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cancelled_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `price` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cancelled_remarks` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `booking_remarks` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `booking_id` int(10) unsigned NOT NULL,
  `code` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'online',
  `room_type` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reserved_rooms_1_idx` (`booking_id`),
  KEY `status_idx` (`status`),
  CONSTRAINT `fk_reserved_rooms_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=421 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserved_rooms`
--

LOCK TABLES `reserved_rooms` WRITE;
/*!40000 ALTER TABLE `reserved_rooms` DISABLE KEYS */;
INSERT INTO `reserved_rooms` VALUES (386,65,'2016-02-22 04:00:12','2016-02-23 03:59:11','2016-02-21 23:27:46','2016-02-23 05:01:19',3,'Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','jonathan.espanol@pythosinc.com','0000-00-00 00:00:00','999.99',NULL,NULL,190,'online',39),(387,115,'2016-02-22 04:00:12','2016-02-23 03:59:11','2016-02-21 23:27:46','2016-02-23 05:04:10',3,'Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','jonathan.espanol@pythosinc.com','0000-00-00 00:00:00','999.99',NULL,NULL,190,'online',39),(388,30,'2016-02-22 04:00:12','2016-02-23 03:59:11','2016-02-21 23:27:46','2016-02-23 05:01:19',3,'Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','jonathan.espanol@pythosinc.com','0000-00-00 00:00:00','100',NULL,NULL,190,'online',41),(389,92,'2016-02-22 04:00:12','2016-02-23 03:59:11','2016-02-21 23:27:47','2016-02-23 05:01:19',3,'Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','jonathan.espanol@pythosinc.com','0000-00-00 00:00:00','33',NULL,NULL,190,'online',50),(390,31,'2016-02-22 04:00:00','2016-02-23 03:59:00','2016-02-22 07:50:18','2016-02-23 05:01:19',3,'n/a','n/a','n/a','n/a','','0000-00-00 00:00:00','100',NULL,NULL,191,'N/A',41),(394,42,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 03:40:18','2016-02-23 03:50:51',5,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,193,'N/A',39),(395,43,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 03:40:23','2016-02-23 03:50:51',5,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,193,'N/A',39),(397,115,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 03:42:51','2016-02-23 03:50:52',5,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,193,'N/A',39),(398,119,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 03:42:51','2016-02-23 03:50:52',5,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,193,'N/A',39),(399,120,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 03:49:12','2016-02-23 03:51:09',5,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,194,'N/A',39),(400,44,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:01:27','2016-02-23 05:02:03',1,'n/a','n/a','n/a','n/a','','0000-00-00 00:00:00','999.99',NULL,NULL,195,'N/A',39),(401,30,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:01:31','2016-02-23 05:02:04',1,'n/a','n/a','n/a','n/a','','0000-00-00 00:00:00','100',NULL,NULL,195,'N/A',41),(402,65,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:04:24','2016-02-23 05:14:59',5,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,196,'N/A',39),(403,31,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:07:38','2016-02-23 05:07:38',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,197,'N/A',41),(404,92,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:11:50','2016-02-23 05:12:01',1,'Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','','0000-00-00 00:00:00','33',NULL,NULL,198,'N/A',50),(405,65,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:33:54','2016-02-23 05:33:59',1,'n/a','n/a','n/a','n/a','','0000-00-00 00:00:00','999.99',NULL,NULL,199,'N/A',39),(406,115,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:40:41','2016-02-23 05:41:08',1,'Jonathan','Espanol','Blk 7 lot 13, Maravilla','2432','','0000-00-00 00:00:00','999.99',NULL,NULL,200,'N/A',39),(407,93,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 05:44:11','2016-02-23 05:44:11',0,'','','','','','0000-00-00 00:00:00','33',NULL,NULL,201,'N/A',50),(408,94,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 06:00:01','2016-02-23 06:03:38',1,'n/a','n/a','n/a','n/a','','0000-00-00 00:00:00','33',NULL,NULL,202,'N/A',50),(409,120,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 06:38:30','2016-02-23 06:38:30',0,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,203,'N/A',39),(410,121,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 06:48:51','2016-02-23 06:48:51',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,203,'N/A',41),(411,122,'2016-02-23 04:00:00','2016-02-24 03:59:00','2016-02-23 06:53:14','2016-02-23 06:53:14',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,204,'N/A',41),(412,30,'2016-02-24 04:00:00','2016-02-25 03:59:00','2016-02-23 06:56:03','2016-02-23 06:56:03',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,205,'N/A',41),(413,30,'2016-02-25 04:00:00','2016-02-26 03:59:00','2016-02-23 06:57:04','2016-02-23 06:57:04',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,205,'N/A',41),(414,92,'2016-02-24 04:00:00','2016-02-25 03:59:00','2016-02-23 06:58:10','2016-02-23 06:58:10',0,'','','','','','0000-00-00 00:00:00','33',NULL,NULL,206,'N/A',50),(415,65,'2016-02-26 04:00:00','2016-02-27 03:59:00','2016-02-23 07:01:22','2016-02-23 07:01:22',0,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,207,'N/A',39),(416,65,'2016-02-27 04:00:00','2016-02-28 03:59:00','2016-02-23 07:02:29','2016-02-23 07:02:29',0,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,208,'N/A',39),(417,65,'2016-02-25 04:00:00','2016-02-26 03:59:00','2016-02-23 07:06:33','2016-02-23 07:06:33',0,'','','','','','0000-00-00 00:00:00','999.99',NULL,NULL,209,'N/A',39),(418,30,'2016-02-28 04:00:00','2016-02-29 03:59:00','2016-02-23 07:07:56','2016-02-23 07:07:56',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,210,'N/A',41),(419,30,'2016-02-29 04:00:00','2016-03-01 03:59:00','2016-02-23 07:09:32','2016-02-23 07:09:32',0,'','','','','','0000-00-00 00:00:00','100',NULL,NULL,211,'N/A',41),(420,92,'2016-03-03 04:00:00','2016-03-04 03:59:00','2016-02-23 07:16:11','2016-02-23 07:16:11',0,'','','','','','0000-00-00 00:00:00','33',NULL,NULL,212,'N/A',50);
/*!40000 ALTER TABLE `reserved_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_images`
--

DROP TABLE IF EXISTS `room_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_images`
--

LOCK TABLES `room_images` WRITE;
/*!40000 ALTER TABLE `room_images` DISABLE KEYS */;
INSERT INTO `room_images` VALUES (27,46,98,'2015-01-22 00:42:13','2015-01-22 00:42:13'),(34,43,102,'2015-01-22 00:44:45','2015-01-22 00:44:45'),(35,40,103,'2015-01-22 00:48:15','2015-01-22 00:48:15'),(36,41,104,'2015-01-22 00:48:31','2015-01-22 00:48:31'),(38,42,105,'2015-01-22 00:54:01','2015-01-22 00:54:01'),(58,51,112,'2015-02-02 18:44:15','2015-02-02 18:44:15'),(59,52,112,'2015-02-02 18:45:41','2015-02-02 18:45:41'),(60,53,112,'2015-02-02 18:46:29','2015-02-02 18:46:29'),(61,54,112,'2015-02-02 18:47:06','2015-02-02 18:47:06'),(62,55,112,'2015-02-02 18:47:10','2015-02-02 18:47:10'),(63,56,113,'2015-02-02 18:47:54','2015-02-02 18:47:54'),(64,57,113,'2015-02-02 18:47:59','2015-02-02 18:47:59'),(65,58,114,'2015-02-02 18:48:53','2015-02-02 18:48:53'),(68,59,115,'2015-02-02 20:21:48','2015-02-02 20:21:48'),(70,39,99,'2015-02-04 22:36:59','2015-02-04 22:36:59'),(73,50,116,'2015-02-16 23:12:22','2015-02-16 23:12:22');
/*!40000 ALTER TABLE `room_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_qty`
--

DROP TABLE IF EXISTS `room_qty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_qty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `room_no` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_qty`
--

LOCK TABLES `room_qty` WRITE;
/*!40000 ALTER TABLE `room_qty` DISABLE KEYS */;
INSERT INTO `room_qty` VALUES (28,40,5,'0000-00-00 00:00:00','2015-01-05 22:21:22',1),(29,40,103,'2014-12-28 23:37:41','2015-01-05 22:09:56',1),(30,41,404,'2014-12-28 23:47:08','2015-02-05 22:32:05',1),(31,41,444,'2014-12-28 23:47:09','2015-02-05 22:32:08',1),(32,42,0,'2014-12-28 23:47:53','2014-12-28 23:47:53',1),(33,42,0,'2014-12-28 23:47:53','2014-12-28 23:47:53',1),(34,42,0,'2014-12-28 23:47:53','2014-12-28 23:47:53',1),(35,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),(36,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),(42,39,2,'2015-01-05 19:19:17','2016-02-09 01:06:11',0),(43,39,2,'2015-01-05 19:19:18','2016-02-09 01:06:15',0),(44,39,3,'2015-01-05 19:19:18','2016-02-09 01:06:18',0),(55,40,333,'2015-01-05 21:51:06','2015-01-05 22:10:23',1),(56,40,NULL,'2015-01-05 21:51:06','2015-01-05 21:51:06',1),(57,40,NULL,'2015-01-05 22:05:52','2015-01-05 22:05:52',1),(58,40,NULL,'2015-01-05 22:05:52','2015-01-05 22:05:52',1),(59,40,NULL,'2015-01-05 22:05:52','2015-01-05 22:05:52',1),(60,40,NULL,'2015-01-05 22:06:01','2015-01-05 22:06:01',1),(61,40,NULL,'2015-01-05 22:06:01','2015-01-05 22:06:01',1),(62,40,NULL,'2015-01-05 22:06:01','2015-01-05 22:06:01',1),(65,39,11,'2015-01-06 17:16:19','2015-01-06 17:16:19',1),(66,46,NULL,'2015-01-22 00:31:43','2015-01-22 00:31:43',1),(67,46,NULL,'2015-01-22 00:31:43','2015-01-22 00:31:43',1),(86,48,NULL,'2015-02-02 18:23:07','2015-02-02 18:23:07',1),(87,48,NULL,'2015-02-02 18:23:07','2015-02-02 18:23:07',1),(88,48,NULL,'2015-02-02 18:23:08','2015-02-02 18:23:08',1),(89,49,NULL,'2015-02-02 18:24:57','2015-02-02 18:24:57',1),(90,49,NULL,'2015-02-02 18:24:58','2015-02-02 18:24:58',1),(91,49,NULL,'2015-02-02 18:24:58','2015-02-02 18:24:58',1),(92,50,100,'2015-02-02 18:42:29','2015-02-02 18:42:29',1),(93,50,NULL,'2015-02-02 18:42:29','2015-02-02 18:42:29',1),(94,50,NULL,'2015-02-02 18:42:29','2015-02-02 18:42:29',1),(95,51,NULL,'2015-02-02 18:44:15','2015-02-02 18:44:15',1),(96,51,NULL,'2015-02-02 18:44:15','2015-02-02 18:44:15',1),(97,51,NULL,'2015-02-02 18:44:15','2015-02-02 18:44:15',1),(98,52,NULL,'2015-02-02 18:45:41','2015-02-02 18:45:41',1),(99,52,NULL,'2015-02-02 18:45:41','2015-02-02 18:45:41',1),(100,52,NULL,'2015-02-02 18:45:41','2015-02-02 18:45:41',1),(101,53,NULL,'2015-02-02 18:46:29','2015-02-02 18:46:29',1),(102,53,NULL,'2015-02-02 18:46:29','2015-02-02 18:46:29',1),(103,53,NULL,'2015-02-02 18:46:29','2015-02-02 18:46:29',1),(104,54,NULL,'2015-02-02 18:47:05','2015-02-02 18:47:05',1),(105,54,NULL,'2015-02-02 18:47:05','2015-02-02 18:47:05',1),(106,54,NULL,'2015-02-02 18:47:06','2015-02-02 18:47:06',1),(107,55,NULL,'2015-02-02 18:47:10','2015-02-02 18:47:10',1),(108,55,NULL,'2015-02-02 18:47:10','2015-02-02 18:47:10',1),(109,55,NULL,'2015-02-02 18:47:10','2015-02-02 18:47:10',1),(110,56,NULL,'2015-02-02 18:47:54','2015-02-02 18:47:54',1),(111,57,NULL,'2015-02-02 18:47:59','2015-02-02 18:47:59',1),(112,58,NULL,'2015-02-02 18:48:52','2015-02-02 18:48:52',1),(113,58,NULL,'2015-02-02 18:48:52','2015-02-02 18:48:52',1),(114,58,NULL,'2015-02-02 18:48:53','2015-02-02 18:48:53',1),(115,39,22,'2015-02-02 20:16:00','2015-02-02 20:16:00',1),(116,59,NULL,'2015-02-02 20:21:48','2015-02-02 20:21:48',1),(117,59,NULL,'2015-02-02 20:21:48','2015-02-02 20:21:48',1),(118,59,NULL,'2015-02-02 20:21:48','2015-02-02 20:21:48',1),(119,39,33,'2015-02-04 22:41:55','2016-02-22 03:06:29',0),(120,39,44,'2015-02-04 22:41:55','2015-02-04 22:41:55',1),(121,41,414,'2015-02-04 23:11:53','2015-02-05 22:32:16',1),(122,41,414,'2015-02-04 23:11:53','2015-02-05 22:32:12',1),(123,41,141,'2015-02-04 23:11:53','2015-02-05 22:32:21',0),(124,41,420,'2015-02-04 23:11:54','2016-02-22 05:34:24',0),(125,41,490,'2015-02-04 23:11:54','2016-02-22 05:34:28',0);
/*!40000 ALTER TABLE `room_qty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `max_adults` int(11) NOT NULL DEFAULT '0',
  `max_children` int(11) NOT NULL DEFAULT '0',
  `beds` int(11) NOT NULL DEFAULT '0',
  `bathrooms` int(11) NOT NULL DEFAULT '0',
  `area` decimal(5,2) DEFAULT NULL,
  `price` decimal(5,2) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (39,'Single','Lorem i\"psum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut en\"im ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',2,2,2,2,222.00,999.99,'single','2014-12-28 22:54:54','2015-01-26 22:31:29'),(41,'Triple','Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute ','Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',2,2,2,2,100.00,100.00,'triple','2014-12-28 23:47:08','2014-12-28 23:47:08'),(50,'Double','sdfadfsdsdf','dfdsfasdfsdf',3,3,3,3,33.00,33.00,'double','2015-02-02 18:42:29','2015-02-04 23:12:17');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `checkout_time` time DEFAULT NULL,
  `checkin_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` tinyint(1) NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (13,'Jonathans','Espanol',1,'jonathan0301','$2y$10$W89dknzuNPLlVoCQK4wLU.jF.CQfeukO8xmjzn4I6ajA4CFyazkP2','2015-01-06 19:04:13','2015-09-09 17:03:25',NULL,NULL),(15,'Jonathans','Espanol',1,'jonathan0300','$2y$10$S1ojltVGQe3hLdYSNjVj0.fnjKrqJWYPDXgi2yk9GYYqnoygynCE2','2015-01-27 21:55:49','2015-02-04 22:48:33',NULL,NULL),(16,'Kobe','Bryant',2,'kobebryant','$2y$10$upy8oOHOEnV1grGq4E.7u.YuOMK20D.GFKk.osmpu4N.cjja9atVi','2015-02-01 23:24:39','2015-02-04 23:02:43',NULL,NULL);
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

-- Dump completed on 2016-02-23 16:50:04
