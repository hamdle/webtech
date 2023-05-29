use workouts;

/* users */
insert into users (id, email, password, created_date, first_name) values
    (1, 'system@localhost.com', md5('system'), now(), 'system'),
    (2, 'eric@localhost.com', md5('eric'), now(), 'Eric');

/* exercises */
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Warm Up', 1, 1, 0, 'warm');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values
('Walk', 1, 1, 0, 'warm');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Pull Ups', 3, 5, 60, 'pull');
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
('Cobras', 3, 40, 60, 'core');
insert into exercise_types
(title, default_sets, default_reps, wait_time, category) values 
('Planks', 3, 40, 60, 'core');

/* workouts */
/* Generate workouts dynamically using page or command line tool */
