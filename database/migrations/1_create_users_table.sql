 CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `login` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `first_name` varchar(255) DEFAULT NULL,
        `last_name` varchar(255) DEFAULT NULL,
        `signup_token` varchar(255) DEFAULT NULL,
        `active` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE(email),
        UNIQUE(login)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;