-- MariaDB dump 10.19  Distrib 10.5.19-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: workout
-- ------------------------------------------------------
-- Server version	10.5.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `email` varchar(128) NOT NULL,
    `password` varchar(128) NOT NULL,
    `created_date` datetime DEFAULT current_timestamp(),
    `first_name` varchar(128) NOT NULL,
    `last_name` varchar(128) DEFAULT NULL,
    `active` boolean DEFAULT 1,
    PRIMARY KEY (`id`),
    INDEX (`email`),
    CONSTRAINT `uq_users_email` UNIQUE(`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
    (1,'system@localhost.com','21232f297a57a5a743894a0e4a801fc3',now(),'System','User',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `exercise_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exercise_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `title` varchar(128) DEFAULT NULL,
    `default_sets` int(1) unsigned DEFAULT 0,
    `default_reps` int(1) unsigned DEFAULT 0,
    `wait_time` int(2) unsigned DEFAULT 0,
    `active` boolean not null default 1,
    PRIMARY KEY (`id`),
    INDEX (`user_id`),
    CONSTRAINT `fk_exercise_types_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `exercise_types` WRITE;
/*!40000 ALTER TABLE `exercise_types` DISABLE KEYS */;
INSERT INTO `exercise_types`
(`id`, `user_id`, `title`, `default_sets`, `default_reps`, `wait_time`)
VALUES
    (1, 1, 'Warm Up',     1,  1,  0),
    (2, 1, 'Pull Ups',    3,  5,  60),
    (3, 1, 'Dips',        3,  5,  60),
    (4, 1, 'Push Ups',    3,  5,  60),
    (5, 1, 'Leg Raises',  3,  5,  60),
    (6, 1, 'Lunges',      4,  5,  60),
    (7, 1, 'Cobras',      3,  40, 30),
    (8, 1, 'Planks',      3,  5,  60),
    (9, 1, 'Run',         3,  10, 60);
/*!40000 ALTER TABLE `exercise_types` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exercises` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `exercise_type_id` int(10) unsigned NOT NULL,
    `workout_id` int(10) unsigned NOT NULL,
    `user_id` int(10) unsigned NOT NULL,
    `sets` int(1) unsigned DEFAULT 0,
    `feedback` enum('up','down','none') DEFAULT 'none',
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_exercises_exercise_type_id` FOREIGN KEY (`exercise_type_id`) REFERENCES exercise_types(`id`),
    CONSTRAINT `fk_exercises_workout_id` FOREIGN KEY (`workout_id`) REFERENCES workouts(`id`),
    CONSTRAINT `fk_exercises_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    INDEX (`exercise_type_id`),
    INDEX (`workout_id`),
    INDEX (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `reps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reps` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `exercise_id` int(10) unsigned NOT NULL,
    `amount` varchar(8) DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_reps_exercise_id` FOREIGN KEY (`exercise_id`) REFERENCES exercises(`id`),
    INDEX (`exercise_id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `token` varchar(256) NOT NULL,
    `created_date` datetime DEFAULT current_timestamp(),
    `last_login` datetime DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_sessions_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    INDEX (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;





DROP TABLE IF EXISTS `workouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workouts` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `start` datetime DEFAULT NULL,
    `end` datetime DEFAULT NULL,
    `notes` varchar(1024) DEFAULT NULL,
    `feel` enum('weak','average','strong') DEFAULT 'average',
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_workouts_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    INDEX (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `log_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `log_type` varchar(32) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `log_types` WRITE;
/*!40000 ALTER TABLE `log_types` DISABLE KEYS */;
INSERT INTO `log_types`
(`log_type`)
VALUES
    ('system'),
    ('error'),
    ('info');
/*!40000 ALTER TABLE `log_types` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `log_type_id` int(10) unsigned DEFAULT 0,
    `user_id` int(10) unsigned DEFAULT NULL,
    `timestamp` datetime DEFAULT NULL,
    `message` varchar(1024) DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_logs_log_type_id` FOREIGN KEY (`log_type_id`) REFERENCES log_types(`id`),
    CONSTRAINT `fk_logs_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    INDEX (`user_id`),
    INDEX (`log_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `system_config_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_config_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `config_type` varchar(32),
    `active` boolean DEFAULT 1,
    PRIMARY KEY (`id`),
    CONSTRAINT `uq_system_config_config_type` UNIQUE(`config_type`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_config_types` WRITE;
/*!40000 ALTER TABLE `system_config_types` DISABLE KEYS */;
INSERT INTO `system_config_types`
(`id`, `config_type`)
VALUES
    (1, 'system'),
    (2, 'workout'),
    (3, 'user');
/*!40000 ALTER TABLE `system_config_types` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `system_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_config` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL DEFAULT 1,
    `system_config_type_id` int(10) unsigned NOT NULL DEFAULT 1,
    `reference` varchar(32) NOT NULL,
    `data` varchar(1024) NOT NULL,
    `active` boolean DEFAULT 1,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_system_config_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    CONSTRAINT `fk_system_config_system_config_type_id` FOREIGN KEY (`system_config_type_id`) REFERENCES system_config_types(`id`),
    INDEX (`user_id`),
    INDEX (`system_config_type_id`),
    CONSTRAINT `uq_system_config_user_id_reference` UNIQUE(`user_id`, `reference`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_config` WRITE;
/*!40000 ALTER TABLE `system_config` DISABLE KEYS */;
INSERT INTO `system_config`
(`user_id`, `reference`, `data`, `system_config_type_id`)
VALUES
    (1, 'default_timezone', '-8', 1),
    (1, 'pagination_default', '30', 1),
    (1, 'rep_rest_default', '60', 2),
    (1, 'set_rest_default', '120', 2),
    (1, 'warm_up_default', '120', 2);
/*!40000 ALTER TABLE `system_config` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;