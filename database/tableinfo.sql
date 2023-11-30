-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: onlinefoodstore.c2zn58sjaobh.us-west-1.rds.amazonaws.com    Database: onlinefoodstore
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address_information`
--

DROP TABLE IF EXISTS `address_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_information` (
  `user_id` int NOT NULL,
  `address_line1` varchar(50) NOT NULL,
  `address_line2` varchar(50) DEFAULT NULL,
  `city` varchar(30) NOT NULL,
  `state_province` varchar(3) NOT NULL,
  `zip_code` char(5) NOT NULL,
  `country` char(2) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `address_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `featured`
--

DROP TABLE IF EXISTS `featured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `featured` (
  `item_id` int NOT NULL,
  `sale_price` decimal(5,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_data` date DEFAULT NULL,
  KEY `item_id` (`item_id`),
  CONSTRAINT `featured_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `global_variables`
--

DROP TABLE IF EXISTS `global_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_variables` (
  `name` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `global_variables`
--

LOCK TABLES `global_variables` WRITE;
/*!40000 ALTER TABLE `global_variables` DISABLE KEYS */;
INSERT INTO `global_variables` VALUES ('masterkey','group6'),('sales_tax','0.083');
/*!40000 ALTER TABLE `global_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `item_id` int NOT NULL,
  `target_quantity` int NOT NULL,
  `item_stock` int NOT NULL,
  `item_ordered` int DEFAULT NULL,
  `current_price` decimal(5,2) NOT NULL,
  `total_value` decimal(6,2) NOT NULL,
  KEY `item_id` (`item_id`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(30) NOT NULL,
  `item_description` varchar(300) NOT NULL,
  `item_weight` decimal(5,2) NOT NULL,
  `item_price` decimal(5,2) NOT NULL,
  `times_bought` int NOT NULL DEFAULT '0',
  `item_keywords` varchar(300) DEFAULT NULL,
  `inv_count` int DEFAULT NULL,
  `image_address` varchar(300) DEFAULT NULL,
  `is_featured` tinyint DEFAULT '0',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_name` (`item_name`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_history`
--

DROP TABLE IF EXISTS `order_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_history` (
  `u_id` int NOT NULL,
  `order_id` int NOT NULL AUTO_INCREMENT,
  `total_weight` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(5,2) NOT NULL DEFAULT '0.00',
  `completed` tinyint DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_information`
--

DROP TABLE IF EXISTS `order_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_information` (
  `o_id` int NOT NULL,
  `i_id` int NOT NULL,
  `quantity` int NOT NULL,
  KEY `i_id` (`i_id`),
  CONSTRAINT `order_information_ibfk_2` FOREIGN KEY (`i_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `payment_information`
--

DROP TABLE IF EXISTS `payment_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_information` (
  `user_id` int NOT NULL,
  `card_type` varchar(30) NOT NULL,
  `card_number` char(16) NOT NULL,
  `card_expiry` varchar(5) DEFAULT NULL,
  `card_cvv` char(3) NOT NULL,
  `billing_address` varchar(75) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `payment_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopping_cart` (
  `u_id` int NOT NULL,
  `i_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  KEY `user_id` (`u_id`),
  KEY `item_id` (`i_id`),
  CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`i_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `is_employee` tinyint NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-30 14:34:57
