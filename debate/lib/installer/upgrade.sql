IF COL_LENGTH('events', 'chapter') IS NULL
BEGIN
	ALTER TABLE `events` ADD `chapter` INT(11) NULL DEFAULT NULL AFTER `region`;
END