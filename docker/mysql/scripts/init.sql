CREATE DATABASE IF NOT EXISTS `debug` COLLATE 'utf8_general_ci' ;
CREATE USER 'developer'@'%' IDENTIFIED BY 'password' ;
GRANT ALL ON `debug`.* TO 'developer'@'%' ;
FLUSH PRIVILEGES ;