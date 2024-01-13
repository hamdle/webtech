call addColumn('sessions', 'remote_address', 'VARCHAR(45)');

call addColumn('sessions', 'user_agent', 'VARCHAR(255)');

INSERT INTO `system_config`
(`user_id`, `reference`, `data`, `system_config_type_id`)
VALUES
    (1, 'play_timer_sound', '0', 2),
    (2, 'play_timer_sound', '0', 2);