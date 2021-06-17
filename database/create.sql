CREATE DATABASE IF NOT EXISTS `taskmanager` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `taskmanager`;

CREATE TABLE IF NOT EXISTS `users` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_role` varchar(20) CHARACTER SET utf8 NOT NULL,
  `full_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;

INSERT INTO `users` (`username`, `password`, `user_role`, `full_name`) VALUES 
('nishant', md5('password'), 'manager', 'Nishant V'),
('alok', md5('password'), 'employee', 'Alok C');

CREATE TABLE IF NOT EXISTS `tasks` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `task_description` text CHARACTER SET utf8 NOT NULL,
  `assigned_by` bigint(20) NOT NULL,
  `assigned_to` bigint(20) NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0 = Pending | 1 - Processing | 2 - Failed | 3 - Completed',
  `due_date` timestamp NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`assigned_by`) REFERENCES `users`(`ID`),
  FOREIGN KEY (`assigned_to`) REFERENCES `users`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;
