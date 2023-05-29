-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: workout_dev
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

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
-- Current Database: `workout_dev`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `workout_dev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `workout_dev`;

--
-- Table structure for table `exercise_types`
--

DROP TABLE IF EXISTS `exercise_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercise_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `default_sets` int unsigned DEFAULT '0',
  `default_reps` int unsigned DEFAULT '0',
  `wait_time` int unsigned DEFAULT '0',
  `category` enum('warm','pull','push','legs','core') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise_types`
--

LOCK TABLES `exercise_types` WRITE;
/*!40000 ALTER TABLE `exercise_types` DISABLE KEYS */;
INSERT INTO `exercise_types` VALUES (1,'Warm Up',1,1,0,'warm'),(2,'Pull Ups',3,5,60,'pull'),(3,'Dips',3,5,60,'push'),(4,'Push Ups',3,5,60,'push'),(5,'Leg Raises',3,5,60,'core'),(6,'Lunges',4,5,60,'legs'),(7,'Cobras',3,40,30,'core'),(8,'Planks',3,5,60,'core');
/*!40000 ALTER TABLE `exercise_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exercise_type_id` int unsigned NOT NULL,
  `workout_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `sets` int unsigned DEFAULT '0',
  `feedback` enum('up','down','none') DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises`
--

LOCK TABLES `exercises` WRITE;
/*!40000 ALTER TABLE `exercises` DISABLE KEYS */;
INSERT INTO `exercises` VALUES (1,1,1,1,1,'none'),(2,2,1,1,3,'none'),(3,4,1,1,3,'none'),(4,6,1,1,4,'none'),(5,8,1,1,3,'none'),(6,2,2,1,3,'none'),(7,4,2,1,3,'none'),(8,6,2,1,4,'none'),(9,8,2,1,3,'none'),(10,1,3,1,1,'none'),(11,2,3,1,3,'none'),(12,4,3,1,3,'none'),(13,6,3,1,4,'none'),(14,8,3,1,3,'none'),(15,1,4,1,1,'none'),(16,2,4,1,3,'none'),(17,4,4,1,3,'none'),(18,6,4,1,4,'none'),(19,7,4,1,3,'none'),(20,1,5,1,1,'none'),(21,2,5,1,3,'none'),(22,4,5,1,3,'none'),(23,6,5,1,4,'none'),(24,8,5,1,3,'none'),(25,1,6,1,1,'none'),(26,2,6,1,3,'none'),(27,4,6,1,3,'none'),(28,6,6,1,4,'none'),(29,8,6,1,3,'none'),(30,1,7,1,1,'none'),(31,2,7,1,3,'none'),(32,3,7,1,3,'none'),(33,6,7,1,4,'none'),(34,8,7,1,3,'none'),(35,1,8,1,1,'none'),(36,2,8,1,3,'none'),(37,3,8,1,3,'none'),(38,6,8,1,4,'none'),(39,7,8,1,3,'none'),(40,1,9,1,1,'none'),(41,2,9,1,3,'none'),(42,4,9,1,3,'none'),(43,6,9,1,4,'none'),(44,8,9,1,3,'none'),(45,1,10,1,1,'none'),(46,2,10,1,3,'none'),(47,4,10,1,3,'none'),(48,6,10,1,4,'none'),(49,7,10,1,3,'none'),(50,1,11,1,1,'none'),(51,2,11,1,3,'none'),(52,4,11,1,3,'none'),(53,6,11,1,4,'none'),(54,7,11,1,3,'none'),(55,1,12,1,1,'none'),(56,2,12,1,3,'none'),(57,4,12,1,3,'none'),(58,6,12,1,4,'none'),(59,7,12,1,3,'none'),(60,1,13,1,1,'none'),(61,2,13,1,3,'none'),(62,4,13,1,3,'none'),(63,6,13,1,4,'none'),(64,7,13,1,3,'none'),(65,1,14,1,1,'none'),(66,2,14,1,3,'none'),(67,4,14,1,3,'none'),(68,6,14,1,4,'none'),(69,8,14,1,3,'none'),(70,1,15,1,1,'none'),(71,2,15,1,3,'none'),(72,4,15,1,3,'none'),(73,6,15,1,4,'none'),(74,7,15,1,3,'none'),(75,1,16,1,1,'none'),(76,2,16,1,3,'none'),(77,4,16,1,3,'none'),(78,6,16,1,4,'none'),(79,8,16,1,3,'none');
/*!40000 ALTER TABLE `exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reps`
--

DROP TABLE IF EXISTS `reps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reps` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exercise_id` int unsigned NOT NULL,
  `amount` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reps`
--

LOCK TABLES `reps` WRITE;
/*!40000 ALTER TABLE `reps` DISABLE KEYS */;
INSERT INTO `reps` VALUES (1,1,'1'),(2,2,'7'),(3,2,'7'),(4,2,'9'),(5,3,'12'),(6,3,'12'),(7,3,'13'),(8,4,'12'),(9,4,'12'),(10,4,'12'),(11,4,'12'),(12,5,'40'),(13,5,'40'),(14,5,'40'),(15,6,'8'),(16,6,'8'),(17,6,'8'),(18,7,'12'),(19,7,'12'),(20,7,'12'),(21,8,'12'),(22,8,'12'),(23,8,'12'),(24,8,'12'),(25,9,'40'),(26,9,'40'),(27,9,'40'),(28,10,'1'),(29,11,'8'),(30,11,'8'),(31,11,'8'),(32,12,'12'),(33,12,'12'),(34,12,'13'),(35,13,'12'),(36,13,'12'),(37,13,'12'),(38,13,'12'),(39,14,'40'),(40,14,'40'),(41,14,'40'),(42,15,'1'),(43,16,'8'),(44,16,'8'),(45,16,'8'),(46,17,'12'),(47,17,'12'),(48,17,'12'),(49,18,'12'),(50,18,'12'),(51,18,'12'),(52,18,'12'),(53,19,'40'),(54,19,'40'),(55,19,'40'),(56,20,'1'),(57,21,'8'),(58,21,'8'),(59,21,'8'),(60,22,'12'),(61,22,'12'),(62,22,'12'),(63,23,'12'),(64,23,'12'),(65,23,'12'),(66,23,'12'),(67,24,'40'),(68,24,'40'),(69,24,'40'),(70,25,'1'),(71,26,'8'),(72,26,'8'),(73,26,'8'),(74,27,'12'),(75,27,'12'),(76,27,'12'),(77,28,'12'),(78,28,'12'),(79,28,'12'),(80,28,'12'),(81,29,'40'),(82,29,'40'),(83,29,'40'),(84,30,'1'),(85,31,'8'),(86,31,'8'),(87,31,'8'),(88,32,'12'),(89,32,'12'),(90,32,'12'),(91,33,'12'),(92,33,'12'),(93,33,'12'),(94,33,'12'),(95,34,'40'),(96,34,'40'),(97,34,'40'),(98,35,'1'),(99,36,'8'),(100,36,'9'),(101,36,'9'),(102,37,'12'),(103,37,'12'),(104,37,'14'),(105,38,'12'),(106,38,'14'),(107,38,'14'),(108,38,'12'),(109,39,'40'),(110,39,'40'),(111,39,'40'),(112,40,'1'),(113,41,'8'),(114,41,'8'),(115,41,'8'),(116,42,'12'),(117,42,'12'),(118,42,'12'),(119,43,'12'),(120,43,'12'),(121,43,'12'),(122,43,'12'),(123,44,'40'),(124,44,'40'),(125,44,'40'),(126,45,'1'),(127,46,'9'),(128,46,'9'),(129,46,'9'),(130,47,'13'),(131,47,'13'),(132,47,'13'),(133,48,'13'),(134,48,'13'),(135,48,'13'),(136,48,'13'),(137,49,'40'),(138,49,'40'),(139,49,'40'),(140,50,'1'),(141,51,'9'),(142,51,'9'),(143,51,'9'),(144,52,'13'),(145,52,'13'),(146,52,'13'),(147,53,'13'),(148,53,'13'),(149,53,'13'),(150,53,'13'),(151,54,'40'),(152,54,'40'),(153,54,'40'),(154,55,'1'),(155,56,'9'),(156,56,'9'),(157,56,'9'),(158,57,'13'),(159,57,'13'),(160,57,'13'),(161,58,'13'),(162,58,'13'),(163,58,'13'),(164,58,'13'),(165,59,'40'),(166,59,'40'),(167,59,'40'),(168,60,'1'),(169,61,'9'),(170,61,'9'),(171,61,'9'),(172,62,'13'),(173,62,'13'),(174,62,'13'),(175,63,'13'),(176,63,'13'),(177,63,'13'),(178,63,'13'),(179,64,'40'),(180,64,'40'),(181,64,'40'),(182,65,'1'),(183,66,'9'),(184,66,'9'),(185,66,'9'),(186,67,'13'),(187,67,'13'),(188,67,'14'),(189,68,'13'),(190,68,'13'),(191,68,'13'),(192,68,'13'),(193,69,'40'),(194,69,'40'),(195,69,'40'),(196,70,'1'),(197,71,'10'),(198,71,'10'),(199,71,'10'),(200,72,'14'),(201,72,'14'),(202,72,'14'),(203,73,'14'),(204,73,'14'),(205,73,'14'),(206,73,'14'),(207,74,'40'),(208,74,'40'),(209,74,'40'),(210,75,'1'),(211,76,'10'),(212,76,'10'),(213,76,'10'),(214,77,'14'),(215,77,'14'),(216,77,'14'),(217,78,'14'),(218,78,'14'),(219,78,'14'),(220,78,'14'),(221,79,'40'),(222,79,'40'),(223,79,'40');
/*!40000 ALTER TABLE `reps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (11,1,'eb5d0c99fd08301c00642f2fd2c7ecb78c6369569126edd2f9b6578d0f3706d75bf3f237a0a4146c2bed5a9839e0922a09cbf02affb0db2933212d1939f791b7d7df40e0ba18dbc97ad7ea9b3af76df137da7714d12f8d042070121c40af5fce90965c507b0cb41d1db63d43d4ea9536d28b9faee0b9ffd409f12312a745b857',null,null);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@localhost.com', md5('admin'), null, 'Eric');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workouts`
--

DROP TABLE IF EXISTS `workouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workouts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `notes` varchar(1024) DEFAULT NULL,
  `feel` enum('weak','average','strong') DEFAULT 'average',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workouts`
--

LOCK TABLES `workouts` WRITE;
/*!40000 ALTER TABLE `workouts` DISABLE KEYS */;
INSERT INTO `workouts` VALUES (1,1,'2022-05-17 01:17:44','2022-05-17 01:45:16','distracted\n\nspotify liked to motogp France FP4 22','strong'),(2,1,'2022-05-19 01:33:46','2022-05-19 02:00:22','FrenchGP Race 22','strong'),(3,1,'2022-05-21 00:55:57','2022-05-21 01:21:41','Random access memories','strong'),(4,1,'2022-05-24 00:58:02','2022-05-24 01:25:52','spotify meandering','average'),(5,1,'2022-06-02 01:01:09','2022-06-02 01:27:58','- MotoGP ItalianGP 2022\n- keep knee brace on for planks','average'),(6,1,'2022-06-04 00:05:57','2022-06-04 00:33:33','- MotoGP CatalanGP FP1\n- medium to weak workout','average'),(7,1,'2022-06-09 02:10:41','2022-06-09 02:35:16','- motogp catalan FP3\n- lunges - one foot, on ball of foot\n- warm','average'),(8,1,'2022-06-14 02:20:08','2022-06-14 02:49:20','- poor sad portfolio\n- shoulder muscle pain but okay\n','average'),(9,1,'2022-06-17 01:14:14','2022-06-17 01:39:01','- weak feel but medium workout\n- off the bike\n- spotify danny brown mix','average'),(10,1,'2022-06-21 00:58:05','2022-06-21 01:26:55','- germanGP 2022\n- strong\n- can up cobraz','strong'),(11,1,'2022-06-23 01:07:55','2022-06-23 01:36:20','- Rage Against the Machine - Renegades','strong'),(12,1,'2022-06-30 01:36:06','2022-06-30 02:06:14','- MotoGP Assen 2022 Q1','average'),(13,1,'2022-07-07 01:05:40','2022-07-07 01:33:42','- difficult after 1 week of no workouts\n- Rage - Battle of Los Angeles','average'),(14,1,'2022-07-09 00:24:39','2022-07-09 00:49:59','- MF DOOM - Madvillian','average'),(15,1,'2022-07-12 01:12:22','2022-07-12 01:39:46','- tired but strong, inc reps from 13 to 14','strong'),(16,1,'2022-07-15 01:26:26','2022-07-15 01:52:40','- Cate Le Bon- Crab Day\n- planks hard on shoulders','strong');
/*!40000 ALTER TABLE `workouts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-15  2:20:34
