CREATE DATABASE IF NOT EXISTS users CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `users`.`user_fields` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ip_address` VARCHAR(15) NOT NULL ,
  `page_url` VARCHAR(6) NOT NULL ,
  `user_agent` CHAR(32) NOT NULL ,
  `view_date` DATETIME NOT NULL ,
  `views_count` INT(11) NOT NULL ,
  PRIMARY KEY (`id`),
  UNIQUE (`ip_address`,`page_url`,`user_agent`))
  ENGINE = InnoDB;