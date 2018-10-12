CREATE DATABASE  IF NOT EXISTS `plane` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `plane`;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Shane
 * Created: 04-Apr-2018
 */
--
-- Table structure for table `planes`
--
DROP TABLE IF EXISTS `planes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes` (
  `Name` varchar(45) NOT NULL,
  `Manufacturer` varchar(45) NOT NULL,
  `enteredService` int(11) NOT NULL,
  `Wingspan` double NOT NULL,
  `topSpeed` int(11) NOT NULL,
  `maxRange` int(11) NOT NULL,
  `Use` varchar(45) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `planes`
--
LOCK TABLES `planes` WRITE;
/*!40000 ALTER TABLE `planes` DISABLE KEYS */;
INSERT INTO `planes` VALUES ('B777-200LR','Boeing', 2006, 64.8, 590, 16417, 'Civilian');
/*!40000 ALTER TABLE `planes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adminUser`
--
DROP TABLE IF EXISTS `adminUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminUser` (
  `userName` varchar(15) NOT NULL,
  `name` varchar(45) NOT NULL,
  `country` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `adminuser`
--
LOCK TABLES `adminUser` WRITE;
/*!40000 ALTER TABLE `adminUser` DISABLE KEYS */;
INSERT INTO `adminUser` VALUES ('A00055','Shane', 'Ireland','1234');
/*!40000 ALTER TABLE `adminUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registereduser`
--
DROP TABLE IF EXISTS `registereduser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registereduser` (
  `userName` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `favouriteCompany` varchar(45) NOT NULL,
  `country` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `registereduser`
--
LOCK TABLES `registereduser` WRITE;
/*!40000 ALTER TABLE `registereduser` DISABLE KEYS */;
INSERT INTO `registereduser` VALUES ('A00900','Gerry','Boeing', 'Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00024','John','Airbus', 'Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00029','Peter','Airbus', 'Germany','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00036','Gearóid','Embraer', 'United States of America','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00087','Mary','Embraer', 'United Kingdom','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00094','Elizabeth','Embraer', 'Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00132','Barry','Embraer', 'Ireland','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00231','John','Boeing', 'Australia','92df54e5f85ad4267d7f6b26d12994f583b3352c'),('A00845','John','Aerospatiale', 'Canada','1234');
/*!40000 ALTER TABLE `registereduser` ENABLE KEYS */;
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
  CONSTRAINT `fk_messages_registereduser` FOREIGN KEY (`sender`) REFERENCES `registereduser` (`userName`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (3,'test1','A00010','2018-03-19 12:52:04'),(4,'test2','A00024','2018-03-19 12:52:04'),(8,'hello','A00010','2018-03-19 14:07:14'),(9,'hello','A00010','2018-03-19 14:07:32'),(10,'hello\r\nnew','A00010','2018-03-19 14:07:48'),(11,'line 1\r\nli','A00010','2018-03-19 14:08:20'),(12,'qwerty','A00010','2018-03-19 14:09:39'),(13,'','A00010','2018-03-19 14:26:01'),(14,'gfgfd','A00010','2018-03-19 14:26:12'),(15,'fdfg','A00010','2018-03-19 14:26:17'),(16,'','A00010','2018-03-19 14:28:03'),(17,'Hello Agai','A00010','2018-03-19 19:40:23'),(18,'hjhjk\r\njkj','A00010','2018-03-19 19:48:53'),(19,'Line 1\r\nLi','A00010','2018-03-19 19:55:36'),(20,'The rain in spain\r\nFalls mainly in the plain','A00010','2018-03-19 19:57:14'),(21,'The rain in spain\r\nFalls mainly in the plain','A00010','2018-03-19 19:59:40');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'plane'
--
