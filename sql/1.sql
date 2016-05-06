############################
############################
# SportsMeeting2 SQL Scripts
############################
############################

DROP SCHEMA IF EXISTS `sportsmeeting2`;
CREATE SCHEMA `sportsmeeting2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

############################

CREATE TABLE `sportsmeeting2`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` VARCHAR(45) NOT NULL COMMENT '用户名',
  `credential` VARCHAR(65) NOT NULL COMMENT '用户密码',
  `enabled` TINYINT(1) NOT NULL COMMENT '是否启用？',
  `description` TEXT NULL COMMENT '用户描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
AUTO_INCREMENT = 10001
COMMENT = '这个表记录用户信息。';

INSERT INTO `sportsmeeting2`.`users` (`id`, `name`, `credential`, `enabled`, `description`) VALUES ('1', 'peter', '$2y$10$KLQEB5lu18SU1zNTKi1eqOO.Mma2tzcLzd7f9s8knih4oYl8hSx/C', '1', '系统管理员');
# peter:peter

############################

CREATE TABLE `sportsmeeting2`.`users_authority` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `authority_id` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 101
COMMENT = '这个表用来记录身份。\nauthority_id: Z0=管理员，A3=台长，B3=总编辑，B6=副总编辑，C6=播音员，D6=单位用户。';

INSERT INTO `sportsmeeting2`.`users_authority` (`user_id`, `authority_id`) VALUES ('1', 'Z0');

############################

CREATE TABLE `sportsmeeting2`.`users_institution` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `institution_id` INT NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 1001
COMMENT = '这个表记录用户所属单位。';

############################

CREATE TABLE `sportsmeeting2`.`users_session` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `session_id` VARCHAR(45) NULL,
  `ip` VARCHAR(45) NOT NULL,
  `mac` VARCHAR(45) NOT NULL,
  `created` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 10001
COMMENT = '这个表记录用户会话。';

############################

CREATE TABLE `sportsmeeting2`.`institutions` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '单位ID',
  `name` VARCHAR(45) NOT NULL COMMENT '单位名称',
  `description` TEXT NULL COMMENT '单位描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
AUTO_INCREMENT = 101
COMMENT = '这个表记录单位信息。';

INSERT INTO `sportsmeeting2`.`institutions` (`id`, `name`) VALUES ('1', '校园之声');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('机电学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('光电学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('自动化学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('通信学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('计算机学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('经济管理学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('信息管理学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('政教学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('公共管理与传媒学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('外国语学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('理学院');
INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('国际交流学院');

############################

CREATE TABLE `sportsmeeting2`.`system_configurations` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property` VARCHAR(45) NULL,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 101
COMMENT = '这个表存放系统动态配置与信息。';

INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('1', 'allow_login', '0');
INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('2', 'allow_contribution', '0');

############################

CREATE TABLE `sportsmeeting2`.`contributions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `institution_id` INT NOT NULL,
  `originality` TINYINT(1) NOT NULL,
  `text` TEXT NOT NULL,
  `created_time` DATETIME NOT NULL,
  `broadcast_user_id` INT NULL,
  `broadcast_time` DATETIME NULL,
  `broadcast_result` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 100001
COMMENT = '这个表记录投稿信息。';

############################

CREATE TABLE `sportsmeeting2`.`contributions_audit_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contributions_id` INT NOT NULL,
  `audit_user_id` INT NULL,
  `audit_level` INT NULL,
  `audit_time` DATETIME NULL,
  `audit_result` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 1000001
COMMENT = '这个表记录稿件审查信息。';

############################