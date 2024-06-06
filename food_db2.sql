-- Active: 1716527985679@@127.0.0.1@3306@food_db
CREATE TABLE `admin` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL,
    `password` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `address` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `flat_no` int(10) DEFAULT NULL,
    `building_no` int(10) DEFAULT NULL,
    `area_name` varchar(45) NOT NULL,
    `city_name` varchar(45) NOT NULL,
    `postal_code` int(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `users` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `address_id` int(100) NOT NULL,
    `name` varchar(20) NOT NULL,
    `email` varchar(50) NOT NULL,
    `number` varchar(20) NOT NULL,
    `password` varchar(50) NOT NULL,
    `registered_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `address_id` (`address_id`),
    CONSTRAINT `users_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `categories` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `products` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `price` int(10) NOT NULL,
    `image` varchar(100) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `description` varchar(500) DEFAULT 'NULL',
    `categories_id` int(100) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `categories_id` (`categories_id`),
    CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `cart` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `user_id` int(100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `price` int(10) NOT NULL,
    `quantity` int(10) NOT NULL,
    `image` varchar(100) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `messages` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `user_id` int(100) NOT NULL,
    `message` varchar(500) NOT NULL,
    `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `payment_method` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `name` varchar(45) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE `orders` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `user_id` int(100) NOT NULL,
    `payment_method_id` int(100) NOT NULL,
    `total_products` varchar(1000) NOT NULL,
    `total_price` int(100) NOT NULL,
    `placed_on` timestamp NOT NULL DEFAULT current_timestamp(),
    `payment_status` varchar(20) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `payement_method_id` (`payment_method_id`),
    CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci