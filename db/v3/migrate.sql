ALTER TABLE users
    ADD COLUMN created_date datetime DEFAULT current_timestamp() AFTER password;

ALTER TABLE users
    ADD COLUMN first_name varchar(128) NOT NULL AFTER created_date;

ALTER TABLE users
    ADD COLUMN last_name varchar(128) NOT NULL AFTER first_name;

ALTER TABLE users
    ADD COLUMN active boolean DEFAULT 1 AFTER last_name;

ALTER TABLE users
    ADD PRIMARY KEY (id);

ALTER TABLE users
    ADD CONSTRAINT uq_users_email UNIQUE(email);

ALTER TABLE users ADD INDEX idx_users_email (email);

UPDATE users SET created_date = '2024-06-02 20:52:06' WHERE id = 1;
UPDATE users SET first_name = 'Eric' WHERE id = 1;
UPDATE users SET last_name = 'Jawaid Marty' WHERE id = 1;
UPDATE users SET active = 1 WHERE id = 1;

ALTER TABLE sessions
    ADD COLUMN created_date datetime DEFAULT current_timestamp() AFTER token;

ALTER TABLE sessions
    ADD COLUMN last_login datetime DEFAULT current_timestamp() AFTER created_date;

ALTER TABLE sessions
    ADD COLUMN remove_address varchar(45) AFTER last_login;

ALTER TABLE sessions
    ADD COLUMN user_agent varchar(255) AFTER remove_address;

ALTER TABLE sessions
    ADD PRIMARY KEY (id);

ALTER TABLE sessions
    ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE sessions ADD INDEX idx_sessions_user_id (user_id);

