-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: plane
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adminuser`
--

DROP TABLE IF EXISTS `adminuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminuser` (
  `userID` varchar(10) NOT NULL,
  `adminName` varchar(45) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `adminID_UNIQUE` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminuser`
--

LOCK TABLES `adminuser` WRITE;
/*!40000 ALTER TABLE `adminuser` DISABLE KEYS */;
INSERT INTO `adminuser` VALUES ('Bob187','Jack','7e041a6761acebd'),('JohnA19','John','00e109e3f9e970e'),('Jones1','Donald','e4c16b877ddaa7c'),('Mod15','John','24027a4270ebd4b'),('Mod19','Mod01','6bf01e59c1e5b72'),('Ted182','Tom','5ffc5d74a4b720f');
/*!40000 ALTER TABLE `adminuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aircraft`
--

DROP TABLE IF EXISTS `aircraft`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aircraft` (
  `aircraftID` varchar(20) NOT NULL,
  `Manufacturer` varchar(45) NOT NULL,
  `enteredService` int(11) NOT NULL,
  `wingspan` double NOT NULL,
  `topSpeed` int(11) NOT NULL,
  `maxRange` varchar(45) NOT NULL,
  `planeUsage` varchar(45) NOT NULL,
  PRIMARY KEY (`aircraftID`),
  UNIQUE KEY `aircraftID_UNIQUE` (`aircraftID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft`
--

LOCK TABLES `aircraft` WRITE;
/*!40000 ALTER TABLE `aircraft` DISABLE KEYS */;
INSERT INTO `aircraft` VALUES ('A-380','Airbus',2005,79.8,587,'15199','Civilian'),('A320','Airbus',1987,34.09,562,'5700','Civilian'),('An-124','Antonov',1982,73.3,565,'5400','Cargo'),('An-225','Antonov',1988,88.4,528,'4000','Cargo'),('ATR 72','Aerospatiale',1988,27.06,320,'1615','Civilian'),('B-17','Boeing',1935,31.62,288,'3219','Military'),('B777-200LR','Boeing',2006,64.8,590,'16417','Civilian'),('C-130','Lockheed',1954,40.41,417,'5250','Military'),('Concorde','Aerospatiale/BAC',1969,25.55,1448,'7251','Civilian'),('CRJ100','Bombardier',1991,21.21,528,'1815','Civilian'),('CRJ900','Bombardier',2001,24.85,547,'2956','Civilian'),('ERJ 170-100','Embraer',2002,26,541,'3889','Civilian'),('ERJ 190-100','Embraer',2004,28.72,541,'4445','Civilian'),('Hurricane','Hawker',1935,12.19,342,'772','Military'),('P51','North American',1940,11.28,437,'3347','Military'),('TU-144','Tupolev',1968,28.8,1491,'6501','Civilian');
/*!40000 ALTER TABLE `aircraft` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `msgID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(140) NOT NULL,
  `sender` varchar(45) NOT NULL,
  `datetimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msgID`),
  KEY `fk_messages_registereduser_idx` (`sender`),
  CONSTRAINT `fk_messages_registereduser` FOREIGN KEY (`sender`) REFERENCES `registereduser` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Hello evryone.','Bob781','2018-04-16 18:02:56'),(2,'*everyone\r\n','Bob781','2018-04-16 18:03:40'),(3,'I would like to have the Hercules C-130 added.','Bob781','2018-04-16 18:04:09'),(4,'I have alot of info on that plane I\'ll add it\r\n','Fan191','2018-04-19 12:38:01'),(5,'I just added the C-130 and also the Hawker Hurricane. Enjoy.','Fan191','2018-04-21 16:13:41'),(6,'Thanks Paul for adding those 2 iconic aircraft.\r\n**Reminder to all users please don\'t use offensive language**','Bob78','2018-04-21 16:25:07'),(7,'Hello guys just added a bunch of aircraft enjoy','Bob78','2018-04-22 19:24:58'),(8,'Hello fellow enthusiasts this is the admininstator please keep in mind users under the age of 18, please don\'t use offensive language.\r\nTo e','Mod19','2018-04-22 19:30:46'),(9,'Sorry the end of that message wasn\'t sent, thank you for those people who added planes thank you.','Mod19','2018-04-22 19:31:49'),(10,'and could ye discuss what plane should be added and who       should added that plane. ','Mod19','2018-04-22 19:32:41');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registereduser`
--

DROP TABLE IF EXISTS `registereduser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registereduser` (
  `userID` varchar(10) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `favCompany` varchar(45) NOT NULL,
  `Country` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `accountType` varchar(45) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID_UNIQUE` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registereduser`
--

LOCK TABLES `registereduser` WRITE;
/*!40000 ALTER TABLE `registereduser` DISABLE KEYS */;
INSERT INTO `registereduser` VALUES ('A00010','Gerry','Boeing','Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00024','John','Airbus','Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00029','Peter','Airbus','Germany','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00036','Gearóid','Cessna','Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00087','Mary','Bombardier','USA','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00094','Elizabeth','Sukhoi','UK','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00132','Barry','Boeing','Australia','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00231','John','Airbus','France','92df54e5f85ad4267d7f6b26d12994f583b3352c','Enthusiast'),('A00845','John','Airbus','Spain','1234','Enthusiast'),('B11155','Shane','Boeing','Ireland','1234','Enthusiast'),('Bob78','Bob','','','7fb12597e2698e436ab52231667348aa70d1be74','Moderator'),('Bob781','Bobby','Cessna','USA','f085480d5a83c26fdd0631592ad39584da1ba52f','Enthusiast'),('Fan191','Paul','','','6bf01e59c1e5b72ae51c25f325b32aa517d3fa40','Enthusiast'),('Mod19','ModJack','','','6bf01e59c1e5b72ae51c25f325b32aa517d3fa40','Administrator');
/*!40000 ALTER TABLE `registereduser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-22 20:37:15
