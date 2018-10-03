SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `user` int(255) NOT NULL,
  `file` text NOT NULL,
  `event` int(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `region` int(11) NOT NULL,
  `state` int(2) NOT NULL,
  `president` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `code` varchar(100) NOT NULL,
  `state` int(2) NOT NULL,
  `mayor` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `con_queue` (
  `user` int(255) NOT NULL,
  `argument_1` text NOT NULL,
  `argument_2` text NOT NULL,
  `argument_3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `debates` (
  `id` int(11) NOT NULL,
  `event` int(255) NOT NULL,
  `block` int(255) NOT NULL,
  `name` text NOT NULL,
  `explanation` text DEFAULT NULL,
  `pro_speaker` int(255) DEFAULT NULL,
  `con_speaker` int(255) DEFAULT NULL,
  `moderator` int(255) NOT NULL,
  `add_speaker` int(255) DEFAULT NULL,
  `thought_talk` tinyint(1) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `type` int(255) NOT NULL,
  `pro_speaker_2` int(255) DEFAULT NULL,
  `con_speaker_2` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date` date NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `state` varchar(2) NOT NULL,
  `region` int(11) DEFAULT NULL,
  `chapter` INT(11) NULL DEFAULT NULL,
  `zip` int(10) NOT NULL,
  `congress` tinyint(1) NOT NULL,
  `blocks` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `first` text NOT NULL,
  `last` text NOT NULL,
  `fullname` text NOT NULL,
  `email` varchar(65) NOT NULL,
  `password` varchar(255) NOT NULL,
  `state` int(2) NOT NULL,
  `chapter` int(255) NOT NULL,
  `graduation` int(255) NOT NULL,
  `phone` text NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `verified_code` varchar(255) DEFAULT NULL,
  `level` int(10) NOT NULL,
  `debates` int(255) NOT NULL,
  `mods` int(255) NOT NULL,
  `events` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mod_queue` (
  `user` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `other_queue` (
  `user` int(255) NOT NULL,
  `argument_1` text NOT NULL,
  `argument_2` text NOT NULL,
  `argument_3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `pro_queue` (
  `user` int(255) NOT NULL,
  `argument_1` text NOT NULL,
  `argument_2` text NOT NULL,
  `argument_3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `debates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `debates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Deleted Chapter", 0, 0, 0);

INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 1, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 2, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 3, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 4, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 5, 0);

INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 6, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 7, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 8, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 9, 0);
  
INSERT INTO `chapters`(`name`, `region`, `state`, `president`) 
  VALUES ("Temp Chapter", "None", 10, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
