
DROP TABLE IF EXISTS `users`;

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

INSERT INTO `users` VALUES
    (1,'system@localhost.com','21232f297a57a5a743894a0e4a801fc3',now(),'System','User',1);


DROP TABLE IF EXISTS `exercise_types`;

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

INSERT INTO `exercise_types`
(`id`, `user_id`, `title`, `default_sets`, `default_reps`, `wait_time`)
VALUES
    (1, 1, 'Warm Up',       1,  1,  0),
    (2, 1, 'Pull Ups',      3,  5,  60),
    (3, 1, 'Dips',          3,  5,  60),
    (4, 1, 'Push Ups',      3,  5,  60),
    (5, 1, 'Leg Raises',    3,  5,  60),
    (6, 1, 'Lunges',        3,  5,  60),
    (7, 1, 'Cobras',        3,  40, 30),
    (8, 1, 'Planks',        3,  5,  60),
    (9, 1, 'Run',           3,  10, 60),
    (10, 1, 'Pistols',       3,  5, 60),
    (11, 1, 'Inverted rows', 3,  5, 60);


DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `token` varchar(256) NOT NULL,
    `created_date` datetime DEFAULT current_timestamp(),
    `last_login` datetime DEFAULT current_timestamp(),
    `remove_address` varchar(45),
    `user_agent` varchar(255),
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_sessions_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    INDEX (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS `workouts`;

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


DROP TABLE IF EXISTS `exercises`;

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


DROP TABLE IF EXISTS `reps`;

CREATE TABLE `reps` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `exercise_id` int(10) unsigned NOT NULL,
    `amount` varchar(8) DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_reps_exercise_id` FOREIGN KEY (`exercise_id`) REFERENCES exercises(`id`),
    INDEX (`exercise_id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS `log_types`;

CREATE TABLE `log_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `log_type` varchar(32) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `log_types`
(`log_type`)
VALUES
    ('system'),
    ('error'),
    ('info');


DROP TABLE IF EXISTS `logs`;

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


DROP TABLE IF EXISTS `system_config_types`;

CREATE TABLE `system_config_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `config_type` varchar(32),
    `active` boolean DEFAULT 1,
    PRIMARY KEY (`id`),
    CONSTRAINT `uq_system_config_config_type` UNIQUE(`config_type`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `system_config_types`
(`id`, `config_type`)
VALUES
    (1, 'system'),
    (2, 'workout'),
    (3, 'user');


DROP TABLE IF EXISTS `system_config`;

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

INSERT INTO `system_config`
(`user_id`, `reference`, `data`, `system_config_type_id`)
VALUES
    (1, 'default_timezone', '-8', 1),
    (1, 'pagination_default', '30', 1),
    (1, 'rep_rest_default', '60', 2),
    (1, 'set_rest_default', '120', 2),
    (1, 'warm_up_default', '120', 2),
    (1, 'play_timer_sound', '0', 2),
    (1, 'takepicture_purge_days', '7', 1),
    (1, 'ping_purge_days', '31', 1);

DROP TABLE IF EXISTS `timesheet`;

CREATE TABLE `timesheet` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL DEFAULT 1,
    `tag` varchar(64) NOT NULL,
    `file` text NOT NULL,
    `active` boolean DEFAULT 1,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_timesheet_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    INDEX (`user_id`),
    INDEX (`tag`),
    CONSTRAINT `uq_timesheet_user_id_tag` UNIQUE(`user_id`, `tag`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `purgelog`;

CREATE TABLE `purge_log` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `tag` varchar(64) NOT NULL,
    `timestamp` datetime NOT NULL,
    PRIMARY KEY (`id`),
    INDEX (`tag`),
    CONSTRAINT `uq_purgelog_id_tag` UNIQUE(`id`, `tag`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
