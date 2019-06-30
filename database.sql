create table `tasks` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`type` INT(10) NOT NULL,
	`place` VARCHAR(255),
	`date` date,
	`time` time DEFAULT NULL,
	`duration` INT(10),
	`comment` text,
	`done` ENUM('yes', 'no') DEFAULT 'no',
	PRIMARY KEY(`id`)
	);
