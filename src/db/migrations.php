<?php

/**
 * TODO
 *  Write DPO statements to create following tables:
 *
 *  # airports
 *   - id (unsigned INT, autoincrement)
 *   - name (VARCHAR)
 *   - code (VARCHAR)
 *   - city_id (relation to the cities table)
 *   - state_id (relation to the states table)
 *   - address (VARCHAR)
 *   - timezone (VARCHAR)
 *
 *  # cities
 *   - id (unsigned INT, autoincrement)
 *   - name (VARCHAR)
 *
 *  # states
 *   - id (unsigned INT, autoincrement)
 *   - name (VARCHAR)
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';
// drop tables
// $sql = <<<'SQL'
// drop table if exists airports;
// drop table if exists cities;
// drop table if exists states;
// SQL;
// $pdo->exec($sql);
// cities
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `cities` (
	`id` INT UNSIGNED AUTO_INCREMENT,
	`name` VARCHAR(40) NOT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);
// states
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `states` (
	`id` INT UNSIGNED AUTO_INCREMENT,
	`name` VARCHAR(40) NOT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);
// airports
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS airports(
	`id` INT UNSIGNED AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`code` VARCHAR(3) not null,
	`city_id` INT UNSIGNED, KEY `city_id` (`city_id`), 
	CONSTRAINT `c_airport_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
	`state_id` INT UNSIGNED, KEY `state_id` (`state_id`), 
	CONSTRAINT `c_airport_state` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
	`address` VARCHAR(150) ,
	`timezone` VARCHAR(40),
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);
