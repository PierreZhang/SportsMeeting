###############################
###############################
# MySQL Scripts - sportsmeeting
###############################
###############################

DROP SCHEMA IF EXISTS `sportsmeeting`;
CREATE SCHEMA `sportsmeeting` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

###############################

CREATE TABLE `sportsmeeting`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` VARCHAR(45) NOT NULL COMMENT '用户名',
  `credential` VARCHAR(65) NOT NULL COMMENT '用户密码',
  `enabled` TINYINT(1) NOT NULL COMMENT '是否启用？',
  `description` TEXT NULL COMMENT '用户描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
AUTO_INCREMENT = 10001
COMMENT = '用户表。这个表记录用户信息。';

INSERT INTO `sportsmeeting`.`users` (`id`, `name`, `credential`, `enabled`, `description`) VALUES ('1', 'peter', '$2y$10$KLQEB5lu18SU1zNTKi1eqOO.Mma2tzcLzd7f9s8knih4oYl8hSx/C', '1', '系统管理员'); # 新建账号，ID=1，用户名=peter，密码=peter

###############################

CREATE TABLE `sportsmeeting`.`users_authority` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '授权ID',
  `user_id` INT NOT NULL COMMENT '用户ID',
  `authority_id` VARCHAR(45) NOT NULL COMMENT '权限ID',
  `description` TEXT NULL COMMENT '授权描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 101
COMMENT = '授权表。这个表用来记录身份。\nauthority_id: Z0=管理员，A3=台长，B3=总编辑，B6=副总编辑，C6=播音员，D6=单位用户。';

INSERT INTO `sportsmeeting`.`users_authority` (`user_id`, `authority_id`) VALUES ('1', 'Z0'); # 给新建的账号授权，管理员

###############################

CREATE TABLE `sportsmeeting`.`users_institution` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '分配ID',
  `user_id` INT NOT NULL COMMENT '用户ID',
  `institution_id` INT NOT NULL COMMENT '单位ID',
  `description` TEXT NULL COMMENT '分配描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 1001
COMMENT = '单位分配表。这个表记录用户所属单位。';

###############################

CREATE TABLE `sportsmeeting`.`users_session` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '会话ID',
  `user_id` INT NOT NULL COMMENT '用户ID',
  `session_id` VARCHAR(45) NULL COMMENT '浏览器会话ID',
  `ip` VARCHAR(45) NOT NULL COMMENT 'IP地址',
  `mac` VARCHAR(45) NOT NULL COMMENT 'MAC地址',
  `created` DATETIME NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 10001
COMMENT = '会话表。这个表记录用户会话。';

###############################

CREATE TABLE `sportsmeeting`.`institutions` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '单位ID',
  `name` VARCHAR(45) NOT NULL COMMENT '单位名称',
  `description` TEXT NULL COMMENT '单位描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
AUTO_INCREMENT = 101
COMMENT = '单位表。这个表记录单位信息。';

INSERT INTO `sportsmeeting`.`institutions` (`id`, `name`) VALUES ('1', '校园之声');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('机电学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('光电学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('自动化学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('通信学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('计算机学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('经济管理学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('信息管理学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('政教学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('公共管理与传媒学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('外国语学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('理学院');
INSERT INTO `sportsmeeting`.`institutions` (`name`) VALUES ('国际交流学院');

###############################

CREATE TABLE `sportsmeeting`.`system_configurations` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `property` VARCHAR(45) NULL COMMENT '配置名称',
  `value` TEXT NULL COMMENT '配置值',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 101
COMMENT = '系统配置表。这个表存放系统动态配置与信息。';

INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('1', 'allow_login', '0');
INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('2', 'allow_contribute', '0');
INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('3', 'contribute_interval', '10');
INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('4', 'audit_1_ideal_pass_rate', '0.5');
INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('5', 'audit_2_ideal_pass_rate', '0.5');
INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('6', 'site_name', '2016信息科大运动会空中宣传阵地');
INSERT INTO `sportsmeeting`.`system_configurations` (`id`, `property`, `value`) VALUES ('7', 'emergency_contact', '如有任何紧急情况，请您与广播台运动会宣传阵地负责人联系：张三13800138000，李四13700137000。');

###############################

CREATE TABLE `sportsmeeting`.`contributions` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '稿件ID',
  `user_id` INT NOT NULL COMMENT '用户ID',
  `institution_id` INT NOT NULL COMMENT '单位ID',
  `originality` TINYINT(1) NOT NULL COMMENT '原创标记',
  `text` TEXT NOT NULL COMMENT '稿件正文',
  `created` DATETIME NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 100001
COMMENT = '稿件表。这个表记录投稿信息。';

###############################

CREATE TABLE `sportsmeeting`.`contributions_action` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '稿件操作ID',
  `contribution_id` INT NOT NULL COMMENT '稿件ID',
  `user_id` INT NULL COMMENT '操作人ID',
  `action_id` TINYINT(1) NULL COMMENT '操作ID',
  `created` DATETIME NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
AUTO_INCREMENT = 1000001
COMMENT = '稿件操作表。这个表记录稿件审查信息。
action_id: 已提交=11,已初审-通过=21,已初审-未通过=25,已终审-通过=31,已终审-未通过=35,备稿=51,已播送=55';

###############################
USE `sportsmeeting`; # 以下创建视图

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`contributions_status` AS
    SELECT 
        `contributions_action`.`contribution_id` AS `id`,
        MAX(`contributions_action`.`action_id`) AS `status_id`,
        `contributions`.`institution_id` AS `institution_id`
    FROM
        (`contributions`
        JOIN `contributions_action`)
    WHERE
        (`contributions`.`id` = `contributions_action`.`contribution_id`)
    GROUP BY `contributions_action`.`contribution_id`;
    
###############################

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`statistics_A11` AS
    SELECT 
    `contributions`.`institution_id` AS `institution_id`,
        COUNT(*) AS `A11`
    FROM
        `contributions_action` `actions` LEFT JOIN `contributions` `contributions`
        ON `actions`.`contribution_id`=`contributions`.`id`
    WHERE
        `actions`.`action_id`=11
    GROUP BY `contributions`.`institution_id`;

###############################

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`statistics_A21` AS
    SELECT 
    `contributions`.`institution_id` AS `institution_id`,
        COUNT(*) AS `A21`
    FROM
        `contributions_action` `actions` LEFT JOIN `contributions` `contributions`
        ON `actions`.`contribution_id`=`contributions`.`id`
    WHERE
        `actions`.`action_id`=21
    GROUP BY `contributions`.`institution_id`;

###############################

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`statistics_A25` AS
    SELECT 
    `contributions`.`institution_id` AS `institution_id`,
        COUNT(*) AS `A25`
    FROM
        `contributions_action` `actions` LEFT JOIN `contributions` `contributions`
        ON `actions`.`contribution_id`=`contributions`.`id`
    WHERE
        `actions`.`action_id`=25
    GROUP BY `contributions`.`institution_id`;

###############################

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`statistics_A31` AS
    SELECT 
    `contributions`.`institution_id` AS `institution_id`,
        COUNT(*) AS `A31`
    FROM
        `contributions_action` `actions` LEFT JOIN `contributions` `contributions`
        ON `actions`.`contribution_id`=`contributions`.`id`
    WHERE
        `actions`.`action_id`=31
    GROUP BY `contributions`.`institution_id`;

###############################

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`statistics_A35` AS
    SELECT 
    `contributions`.`institution_id` AS `institution_id`,
        COUNT(*) AS `A35`
    FROM
        `contributions_action` `actions` LEFT JOIN `contributions` `contributions`
        ON `actions`.`contribution_id`=`contributions`.`id`
    WHERE
        `actions`.`action_id`=35
    GROUP BY `contributions`.`institution_id`;

###############################

CREATE
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `sportsmeeting`.`statistics_A55` AS
    SELECT 
    `contributions`.`institution_id` AS `institution_id`,
        COUNT(*) AS `A55`
    FROM
        `contributions_action` `actions` LEFT JOIN `contributions` `contributions`
        ON `actions`.`contribution_id`=`contributions`.`id`
    WHERE
        `actions`.`action_id`=55
    GROUP BY `contributions`.`institution_id`;

###############################

CREATE 
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `statistics_a0` AS
    SELECT 
        `statistics_a11`.`institution_id` AS `institution_id`,
        `statistics_a11`.`A11` AS `A11`,
        `statistics_a21`.`A21` AS `A21`,
        `statistics_a25`.`A25` AS `A25`,
        `statistics_a31`.`A31` AS `A31`,
        `statistics_a35`.`A35` AS `A35`,
        `statistics_a55`.`A55` AS `A55`
    FROM
        (((((`statistics_a11`
        LEFT JOIN `statistics_a21` ON ((`statistics_a11`.`institution_id` = `statistics_a21`.`institution_id`)))
        LEFT JOIN `statistics_a25` ON ((`statistics_a11`.`institution_id` = `statistics_a25`.`institution_id`)))
        LEFT JOIN `statistics_a31` ON ((`statistics_a11`.`institution_id` = `statistics_a31`.`institution_id`)))
        LEFT JOIN `statistics_a35` ON ((`statistics_a11`.`institution_id` = `statistics_a35`.`institution_id`)))
        LEFT JOIN `statistics_a55` ON ((`statistics_a11`.`institution_id` = `statistics_a55`.`institution_id`)));

###############################

CREATE 
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `statistics_a0_sum` AS
    SELECT 
        SUM(`statistics_a11`.`A11`) AS `SUM_A11`,
        SUM(`statistics_a21`.`A21`) AS `SUM_A21`,
        SUM(`statistics_a25`.`A25`) AS `SUM_A25`,
        SUM(`statistics_a31`.`A31`) AS `SUM_A31`,
        SUM(`statistics_a35`.`A35`) AS `SUM_A35`,
        SUM(`statistics_a55`.`A55`) AS `SUM_A55`
    FROM
        (((((`statistics_a11`
        LEFT JOIN `statistics_a21` ON ((`statistics_a11`.`institution_id` = `statistics_a21`.`institution_id`)))
        LEFT JOIN `statistics_a25` ON ((`statistics_a11`.`institution_id` = `statistics_a25`.`institution_id`)))
        LEFT JOIN `statistics_a31` ON ((`statistics_a11`.`institution_id` = `statistics_a31`.`institution_id`)))
        LEFT JOIN `statistics_a35` ON ((`statistics_a11`.`institution_id` = `statistics_a35`.`institution_id`)))
        LEFT JOIN `statistics_a55` ON ((`statistics_a11`.`institution_id` = `statistics_a55`.`institution_id`)));

###############################

CREATE 
    ALGORITHM = UNDEFINED
    SQL SECURITY DEFINER
VIEW `users_tree` AS
    SELECT 
        `users`.`id`, `users_authority`.`authority_id`, `users_institution`.`institution_id`
    FROM
        (`users` LEFT JOIN `users_authority` ON `users`.`id`=`users_authority`.`user_id`)
        RIGHT JOIN `users_institution` ON `users`.`id`=`users_institution`.`user_id`;

###############################