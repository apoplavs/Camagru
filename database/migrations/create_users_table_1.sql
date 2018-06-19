 CREATE TABLE IF NOT EXISTS `user` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `login` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `last_name` varchar(255) NOT NULL,
        `first_name` varchar(255) NOT NULL,
        `gender` varchar(255) NOT NULL,
        `signup_token` varchar(255) DEFAULT NULL,
        `password_token` varchar(255) DEFAULT NULL,
        `active` tinyint(1) NOT NULL,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;