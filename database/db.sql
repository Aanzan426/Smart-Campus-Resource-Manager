CREATE TABLE users (
	user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    dept VARCHAR(50) NULL,
    roll_number VARCHAR(20) NOT NULL,
    user_code VARCHAR(30) UNIQUE NOT NULL,
    role ENUM('admin','student','staff') NOT NULL DEFAULT 'student',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login_at DATETIME NULL,
    last_logout_at DATETIME NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE resources (
	resource_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resource_name VARCHAR(100) NOT NULL,
    resource_code VARCHAR(100) UNIQUE NOT NULL,
    resource_type ENUM ('classroom','lab','equipment','seminar_hall','library','board_room','auditorium','gymnasium') NOT NULL DEFAULT 'classroom',
    capacity SMALLINT UNSIGNED NULL,
    location VARCHAR(120) NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    max_booking_minutes SMALLINT UNSIGNED NULL,
    daily_open_time TIME NULL,
    daily_closing_time TIME NULL
);
 CREATE TABLE bookings (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(90) UNIQUE NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    resource_id INT UNSIGNED NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    buffer_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    purpose VARCHAR(255) NULL,
    status ENUM('confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
    booked_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cancelled_at DATETIME NULL,
    notes TEXT NULL
);
CREATE TABLE departments (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dept_name VARCHAR(100) UNIQUE NOT NULL,
    dept_code VARCHAR(10) UNIQUE NOT NULL,
    dept_pass_hash VARCHAR(255) UNIQUE NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
//  This is the limit - What shall be visible on the github, rest will be saved in the directory itself but on the system only


INSERT INTO departments (dept_name, dept_code, dept_pass_hash)
VALUES ('Electronics and Telecommunication', 'entc_060', '$2y$12$ghcOTgCrhtCW.hZVxuNi3unJgVZFojx/O5KiLrD16O8CFXE3B4eQO'), ('Mechanical', 'mech_070', '$2y$12$NLIRanIcuPVgunCmXGRP1OrY7dvT2hAGrEl9ECs2WhSAgvwlulUUi'), ('Electronics and Computer Engineering', 'ece_080', '$2y$12$Ttl0htGffRjGepYGxuzI8eakRRpjL.3P2Ez8qhP1aBnNVUTcWpB6u');

INSERT INTO users (name, email, phone, dept, roll_number, user_code, role, password)
VALUES ('Zatch Winston', 'zw@gmail.com', '1593572468', NULL, '001', 'adm-426-titan', 'admin', '$2y$12$s4QMqmPWEJIR1PP1OtmFNO11nimpBVEJ2l2I/1cs/2dXt4SV2S46u');

SELECT * FROM `users`;
DROP TABLE `users`;
DROP TABLE `resources`;
 SELECT * FROM `resources`;
 
 
ALTER TABLE `bookings` ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;
ALTER TABLE `bookings` ADD INDEX `idx_booking_lookup` (`resource_id`, `start_time`, `end_time`, `status`);

ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE restrict ON UPDATE CASCADE;
ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_resource` FOREIGN KEY (`resource_id`) REFERENCES `resources`(`resource_id`) ON DELETE restrict ON UPDATE CASCADE;

ALTER TABLE bookings DROP FOREIGN KEY `fk_bookings_user`;
ALTER TABLE bookings DROP FOREIGN KEY `fk_bookings_resource`;

SELECT resource_id, resource_name, daily_open_time, daily_closing_time, max_booking_minutes FROM resources;

UPDATE resources 
SET daily_open_time='10:00:00', 
	daily_closing_time='18:00:00', 
	max_booking_minutes=120 
WHERE resource_type='classroom';

UPDATE resources
SET daily_open_time='09:00:00',
    daily_closing_time='18:00:00',
    max_booking_minutes=180
WHERE resource_type='lab';

UPDATE resources
SET daily_open_time='10:00:00',
    daily_closing_time='18:00:00',
    max_booking_minutes=240
WHERE resource_type IN ('seminar_hall','board_room');

UPDATE resources
SET daily_open_time='10:00:00',
    daily_closing_time='20:00:00',
    max_booking_minutes=300
WHERE resource_type='auditorium';

UPDATE resources
SET daily_open_time='06:00:00',
    daily_closing_time='15:00:00',
    max_booking_minutes=180
WHERE resource_type='gymnasium';

UPDATE resources
SET daily_open_time='09:00:00',
    daily_closing_time='17:00:00',
    max_booking_minutes=120
WHERE resource_type='equipment';

SET SQL_SAFE_UPDATES = 0;
SET SQL_SAFE_UPDATES = 1;

SELECT * FROM `bookings`;


