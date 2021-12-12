CREATE DATABASE LoginSystem;

use LoginSystem;

CREATE TABLE IF NOT EXISTS `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(50) NOT NULL,
 `email` varchar(50) NOT NULL,
 `password` varchar(50) NOT NULL,
 `phone` int(10) NOT NULL,
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
    `dealer` int,
    FOREIGN KEY (`dealer`) REFERENCES `dealers`(`dealer_id`),
    PRIMARY KEY(`vehicle_id`) 
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

CREATE TABLE IF NOT EXISTS `DEALER`(
    `dealerID` int(4)  NOT NULL AUTO_INCREMENT,
    `DName` varchar(50) NOT NULL,
    `PhoneNo` varchar(10) NOT NULL,
    `Website` varchar(50) ,
    `D_Email` varchar(50) NOT NULL,
    PRIMARY KEY(`dealerID`)
);

CREATE TABLE IF NOT EXISTS `branch`(
    `dealerID` int(4),
    `branch` varchar(100),
    `location` varchar(100),
    FOREIGN KEY(`dealerID`) REFERENCES `DEALER`(`dealerID`)
);

CREATE TABLE IF NOT EXISTS `DEALER_LOGIN`(
    `D_Email` varchar(50),
    `Password` varchar(50) NOT NULL,
    `vkey` int(6) NOT NULL,
    `verified` int(2) NOt NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `CUSTOMER`(
    `customerID` int(4)  NOT NULL AUTO_INCREMENT,
    `CustomerName` varchar(50) NOT NULL,
    `DOB` varchar(15),
    `PhoneNo` varchar(10) NOT NULL,
    `Address` varchar(100) NOT NULL,
    `DrivingLicense` varchar(20) NOT NULL,
    `C_Email` varchar(50) NOT NULL,
    PRIMARY KEY(`customerID`)
);

CREATE TABLE IF NOT EXISTS `CUSTOMER_LOGIN` (
    `C_Email` varchar(50) NOT NULL,
    `Password` varchar(50) NOT NULL,
    `vkey` int(6) NOT NULL,
    `verified` int(2) NOt NULL DEFAULT 0
);
