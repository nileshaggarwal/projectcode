CREATE DATABASE LoginSystem;

use LoginSystem;

CREATE TABLE IF NOT EXISTS `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `email` varchar(50) NOT NULL,
 `password` varchar(50) NOT NULL,
 `create_datetime` datetime NOT NULL,
 `otp` int(6) NOT NULL,
 `status` varchar(10) NOT NULL,
 `role` varchar(8) NOT NULL,
 `phone` int(15),
 PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `car`(
    `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
    `engine` varchar(50) NOT NULL,
    `mileage` int(4) NOT NULL,
    `brand` varchar(20) NOT NULL,
    `manufacturer` varchar(20) NOT NULL,
    `transmission` varchar(20) NOT NULL,
    `color` varchar(20) NOT NULL,
    `model` int(4) NOT NULL,
    `type` varchar(15) NOT NULL,
    `yearto_invent` int(4) NOT NULL,
    `price` int(10) NOT NULL,
    `make` varchar(20) NOT NULL,
    `img_url` varchar(150) NOT NULL,
    `stock` int(2) DEFAULT 1,
    PRIMARY KEY(`vehicle_id`) 
);

CREATE TABLE IF NOT EXISTS `customer`(
    `email` varchar(50) NOT NULL,
    `firstname` varchar(30) NOT NULL,
    `lastname` varchar(30) NOT NULL,
    `username` varchar(20) NOT NULL,
    `dob` DATE,
    `userid` int,
    FOREIGN KEY (`userid`) REFERENCES `users`(`id`)
);

CREATE TABLE IF NOT EXISTS `accessories`(
    `name` varchar(50) NOT NULL,
    `product_id` int(11),
    `material_type` varchar(20) NOT NULL,
    `price` int(5) NOT NULL,
    `car_type` varchar(10) NOT NULL,
    PRIMARY KEY(`product_id`)
);

CREATE TABLE IF NOT EXISTS `purchases`(
    `purchase_id` int(11) NOT NULL,
    `vehicle_id` int,
    `user_id` int,
    `purchaser_name` varchar(20) NOT NULL,
    `purchase_date` DATE NOT NULL,
    `address` varchar(200) NOT NULL,
    `payment_mode` varchar(10) NOT NULL,
    PRIMARY KEY(`purchase_id`),
    FOREIGN KEY (`vehicle_id`) REFERENCES `car`(`vehicle_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE IF NOT EXISTS `purchaseinfor`(
    `cardnumber` int(16) NOT NULL,
    `purchase_id` int,
    `nameoncard` varchar(10) NOT NULL,
    `expirymm` int(2) NOT NULL,
    `expiryy` int(4) NOT NULL,
    FOREIGN KEY (`purchase_id`) REFERENCES `purchases`(`purchase_id`)
);

CREATE TABLE IF NOT EXISTS `dealers`(
    `email` varchar(50) NOT NULL,
    `firstname` varchar(30) NOT NULL,
    `lastname` varchar(30) NOT NULL,
    `username` varchar(20) NOT NULL,
    `dob` DATE,
    `dealer_id` int,
    FOREIGN KEY (`dealer_id`) REFERENCES `users`(`id`)
);

