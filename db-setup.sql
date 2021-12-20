CREATE DATABASE LoginSystem;

use LoginSystem;

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
    `verified` int(2) NOt NULL DEFAULT 0,
    `lastloggedintime` time
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
    `verified` int(2) NOt NULL DEFAULT 0,
    `lastloggedintime` time
);

CREATE TABLE IF NOT EXISTS `manufacturer`(
    `mname` varchar(20) NOT NULL,
    `manufacturerid` int(3) AUTO_INCREMENT,
    `location` varchar(20) NOT NULL,
    PRIMARY KEY(`manufacturerid`)
);

CREATE TABLE IF NOT EXISTS `car`(
    `name` varchar(30) NOT NULL,
    `carid` int(4) AUTO_INCREMENT,
    `cartype` varchar(10),
    `mileage` varchar(3) NOT NULL,
    `color` varchar(20) NOT NULL,
    `status` varchar(20) NOT NULL,
    `fueltype` varchar(20) NOT NULL,
    `manufacturedate` varchar(10) NOT NULL,
    `manufacturerid` int,
    `uploadedtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `licenseplateno` varchar(15),
    PRIMARY KEY(`carid`),
    FOREIGN KEY(`manufacturerid`) REFERENCES `manufacturer`(`manufaturerid`) 
);

CREATE TABLE IF NOT EXISTS `owns`(
    `carid` int,
    `dealerid` int,
    FOREIGN KEY(`carid`) REFERENCES `car`(`carid`),
    FOREIGN KEY(`dealerid`) REFERENCES `dealer`(`dealerid`)
);

CREATE TABLE IF NOT EXISTS `newcar`(
    `newcarid` int,
    `price` int(10),
    `discount` varchar(4),
    `customerid` int(4),
    `paymentstatus` varchar(15),
    `paymentdate` datetime,
    `paymentstatuschangetime` datetime,
    `totalprice` int(15),
    FOREIGN KEY(`newcarid`) REFERENCES `car`(`carid`)
);

CREATE TABLE IF NOT EXISTS `features`(
    `car_id` int,
    `features` varchar(20),
    FOREIGN KEY(`car_id`) REFERENCES `car`(`carid`)
);

CREATE TABLE IF NOT EXISTS `images`(
    `carid` int,
    `images` varchar(30),
    FOREIGN KEY(`carid`) REFERENCES `car`(`carid`)
);

CREATE TABLE IF NOT EXISTS `preownedcar`(
    `preownedcarid` int,    
    `kmdriven` int(7),
    `resaleprice` int(15) NOT NULL,
    `discount` varchar(4),
    `customerid` int(4),
    `paymentstatus` varchar(15),
    `paymentdate` datetime,
    `paymentstatuschangetime` datetime,
    `totalprice` int(15),
    FOREIGN KEY(`preownedcarid`) REFERENCES `car`(`carid`)
);

CREATE TABLE IF NOT EXISTS `accessories`(
    `accessoryid` int(3) AUTO_INCREMENT,
    `accessoryname` varchar(30),
    `accessoryprice` int(5),
    `accessoryphoto` varchar(300),
    `accessorydescription` varchar(150),
    PRIMARY KEY(`accessoryid`)
);

CREATE TABLE IF NOT EXISTS `accessorychosen`(
    `accessoryid` int,
    `carid` int,
    FOREIGN KEY(`carid`) REFERENCES `car`(`carid`),
    FOREIGN KEY(`accessoryid`) REFERENCES `accessories`(`accessoryid`)
);

