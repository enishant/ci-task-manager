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
