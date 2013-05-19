-- MySQL dump 10.13  Distrib 5.1.67, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: commentsystem
-- ------------------------------------------------------
-- Server version	5.1.67-0ubuntu0.11.10.1

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
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'What is the use of PHP Filters?'),(2,'What Is PHP?');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `ques_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `dislike` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ques_id` (`ques_id`),
  CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`ques_id`) REFERENCES `question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reply`
--

LOCK TABLES `reply` WRITE;
/*!40000 ALTER TABLE `reply` DISABLE KEYS */;
INSERT INTO `reply` VALUES (36,0,1,'dswd','as','dsad',11,2,'2013-05-17 13:05:13'),(77,0,1,'Amber','amber.sharma@osscube.com','I dont Know!!!',2,1,'2013-05-18 15:05:58'),(78,77,1,'debanshu','debanshu.kar@osscube.com','You should Know...So u should Learn it!!!\r\n',NULL,NULL,'2013-05-18 15:05:18'),(79,77,1,'Mohit','mohit.gupta@osscube.com','Not to worry!!! \r\nI will Tell u...\r\n',NULL,NULL,'2013-05-18 15:05:37'),(80,78,1,'Gaurav','gaurav.sharma@osscube.com','Tuje ni lagt ajyada ho raha hai...\r\n',NULL,NULL,'2013-05-18 15:05:52');
/*!40000 ALTER TABLE `reply` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-20  2:20:05
