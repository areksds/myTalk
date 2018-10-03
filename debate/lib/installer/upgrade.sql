ALTER TABLE `events` ADD `chapter` INT(11) NULL DEFAULT NULL AFTER `region`;
ALTER TABLE `debates` CHANGE `moderator` `moderator` INT(255) NULL DEFAULT NULL;
ALTER TABLE `events` DROP COLUMN `region`;
ALTER TABLE `events` ADD `region` INT(11) NULL DEFAULT NULL AFTER `state`;
ALTER TABLE `chapters` DROP COLUMN `region`;
ALTER TABLE `chapters` ADD `region` INT(11) NOT NULL DEFAULT '0' AFTER `name`;