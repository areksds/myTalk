ALTER TABLE `events` ADD `chapter` INT(11) NULL DEFAULT NULL AFTER `region`;
ALTER TABLE `debates` CHANGE `moderator` `moderator` INT(255) NULL DEFAULT NULL;