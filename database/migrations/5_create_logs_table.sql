 CREATE TABLE IF NOT EXISTS `logs` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `client` varchar(15) DEFAULT NULL,
        `notice` varchar(255) DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;