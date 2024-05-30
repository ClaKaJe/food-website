-- Active: 1716527985679@@127.0.0.1@3306@food_db2
CREATE TABLE `admin` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(20),
  `password` varchar(50)
);

CREATE TABLE `cart` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  FOREIGN KEY `user_id` REFERENCES 'users' ('id'),
  `name` varchar(100),
  `price` int(10),
  `quantity` int(10),
  `image` varchar(100)
);

CREATE TABLE `messages` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(100),
  `message` varchar(500)
);

CREATE TABLE `orders` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(100),
  `payement_method_id` int(100),
  `total_products` varchar(1000),
  `total_price` int(100),
  `placed_on` date,
  `payment_status` varchar(20)
);

CREATE TABLE `products` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `admin_id` int(100),
  `name` varchar(100),
  `price` int(10),
  `image` varchar(100)
);

CREATE TABLE `address` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `flat_no` int(10),
  `building_no` int(10),
  `area_name` varchar(45),
  `city_name` varchar(45),
  `state_name` varchar(45),
  `country_name` varchar(45),
  `pin_code` int(10)
);

CREATE TABLE `users` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `address_id` int(100),
  `name` varchar(20),
  `email` varchar(50),
  `number` varchar(10),
  `password` varchar(50)
);

CREATE TABLE `categories` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `products_id` int(100),
  `name` varchar(50)
);

CREATE TABLE `payement_method` (
  `id` int(100) UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(45)
);

ALTER TABLE `cart` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `messages` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);

ALTER TABLE `categories` ADD FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`payement_method_id`) REFERENCES `payement_method` (`id`);
