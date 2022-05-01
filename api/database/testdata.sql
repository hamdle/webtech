use workouts;

/* users */
insert into users (email, password) values ('admin@localhost.com', md5('admin'));
/*
insert into users (email, password) values ('eric@testmail.dev', md5('password456'));
insert into users (email, password) values ('user1@localhost.co', md5('testpass'));
*/

/* exercises */
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Warm Up', 1, 1, 0, 'warm');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Pull Ups', 2, 5, 60, 'pull');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Dips', 3, 5, 60, 'push');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Push Ups', 3, 5, 60, 'push');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Leg Raises', 3, 5, 60, 'core');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Lunges', 4, 5, 60, 'legs');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Cobras', 3, 40, 30, 'core');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Planks', 3, 5, 60, 'core');
/*
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Inverted Rows', 4, 5, 60, 'core');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Plyo Burpees', 4, 5, 60, 'legs');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Hollow Body', 3, 5, 60, 'core');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Chin Up', 2, 5, 60, 'pull');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Pistol Squats', 4, 5, 60, 'legs');
*/

/* workouts */
INSERT INTO `workouts` VALUES 
(1,1,'2021-02-24 21:11:04','2021-02-24 21:55:40','','strong');
INSERT INTO `exercises` VALUES 
(1,1,1,1,1,'none'),
(2,2,1,1,2,'none'),
(3,4,1,1,3,'none'),
(4,6,1,1,2,'none'),
(5,7,1,1,3,'none');
INSERT INTO `reps` VALUES 
(1,1,'1'),
(2,2,'5'),
(3,2,'5'),
(4,3,'6'),
(5,3,'6'),
(6,3,'6'),
(7,4,'10'),
(8,4,'10'),
(9,5,'30'),
(10,5,'30'),
(11,5,'30');

INSERT INTO `workouts` VALUES 
(2,1,'2021-03-01 18:27:21','2021-03-01 18:55:01','Com Truise - Persuasion System','average');
INSERT INTO `exercises` VALUES 
(6,1,1,1,1,'none'),
(7,2,1,1,2,'none'),
(8,4,1,1,3,'none'),
(9,6,1,1,2,'none'),
(10,7,1,1,3,'none');
INSERT INTO `reps` VALUES 
(12,1,'1'),
(13,2,'5'),
(14,2,'5'),
(15,3,'6'),
(16,3,'6'),
(17,3,'6'),
(18,4,'10'),
(19,4,'10'),
(20,5,'30'),
(21,5,'30'),
(22,5,'30');

/*
(1, '2021-03-04 14:42:11', '2019-02-11 01:36:02', 'Hammerhedd - Essence of Iron', 'average');
(1, '2021-03-08 12:40:40', '2019-01-01 13:22:03', 'Cate le Bon - Crab Day', 'average');
(1, '2021-03-10 21:04:44', '2019-09-09 21:34:55', 'Spotify new releases playlist', 'weak');
(1, '2021-03-14 15:00:00', '2019-02-14 15:34:00', 'Danny Brown uknowwhatimsayin 9/10', 'strong');
(1, '2021-03-16 22:13:04', '2019-11-16 22:55:40', '', 'average');
(1, '2021-03-19 20:22:44', '2019-11-16 22:55:40', '', 'average');
(1, '2021-03-22 18:10:24', '2019-11-16 22:55:40', 'History Audiobook', 'average');
(1, '2021-03-26 17:33:19', '2019-11-16 22:55:40', 'Linux Podcast', 'strong');
(1, '2021-03-29 09:02:29', '2019-11-16 22:55:40', '', 'weak');
*/
