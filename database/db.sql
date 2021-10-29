-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: teachaway
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table `starship`
--

DROP TABLE IF EXISTS `starship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `starship` (
  `name` varchar(80) NOT NULL,
  `model` varchar(100) NOT NULL,
  `manufacturer` varchar(200) NOT NULL,
  `cost_in_credits` varchar(15) NOT NULL,
  `length` varchar(7) NOT NULL,
  `max_atmosphering_speed` varchar(10) NOT NULL,
  `crew` varchar(4) NOT NULL,
  `passengers` varchar(4) NOT NULL,
  `cargo_capacity` varchar(7) NOT NULL,
  `consumables` varchar(15) NOT NULL,
  `hyperdrive_rating` varchar(5) NOT NULL,
  `mglt` varchar(7) NOT NULL,
  `starship_class` varchar(100) NOT NULL,
  `pilots` text,
  `films` text,
  `created` timestamp NOT NULL,
  `edited` timestamp NOT NULL,
  `url` varchar(100) NOT NULL,
  `count` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `starship`
--

LOCK TABLES `starship` WRITE;
/*!40000 ALTER TABLE `starship` DISABLE KEYS */;
/*!40000 ALTER TABLE `starship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `name` varchar(80) NOT NULL,
  `model` varchar(100) NOT NULL,
  `manufacturer` varchar(200) NOT NULL,
  `cost_in_credits` varchar(15) NOT NULL,
  `length` varchar(7) NOT NULL,
  `max_atmosphering_speed` varchar(10) NOT NULL,
  `crew` varchar(4) NOT NULL,
  `passengers` varchar(4) NOT NULL,
  `cargo_capacity` varchar(7) NOT NULL,
  `consumables` varchar(15) NOT NULL,
  `vehicle_class` varchar(50) NOT NULL,
  `pilots` text NOT NULL,
  `films` text NOT NULL,
  `created` timestamp NOT NULL,
  `edited` timestamp NOT NULL,
  `url` varchar(100) NOT NULL,
  `count` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-28 22:03:32