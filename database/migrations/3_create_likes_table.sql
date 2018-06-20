CREATE TABLE IF NOT EXISTS `likes` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `user` int(11) UNSIGNED NOT NULL,
        `image` int(11) UNSIGNED NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),

        FOREIGN KEY (`user`)
        REFERENCES `users`(`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,

        FOREIGN KEY (`image`)
        REFERENCES `images`(`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;