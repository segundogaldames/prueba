-- MySQL dump 10.13  Distrib 5.7.26, for osx10.9 (x86_64)
--
-- Host: localhost    Database: prueba
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text,
  `producto_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (1,'Polera 2','Prueba de subida',15,'polera_2.jpeg','2020-05-22 20:52:33','2020-05-22 20:52:33'),(2,'Imagen 1 de pantalon','',14,'pantalon_1.jpeg','2020-05-22 20:55:36','2020-05-22 20:55:36'),(3,'Polera Deportiva 3','Una polera espectacular para la prÃ¡ctica del deporte dentro y fuera del hogar',15,'polera3.jpeg','2020-05-22 21:35:24','2020-05-22 21:35:24'),(4,'Camisa 1','Camisa celeste',11,'camisa_hombre _1.jpeg','2020-05-23 13:11:59','2020-05-23 13:11:59'),(5,'Chaqueta 1','Chaqueta de cuero femenina',10,'chaqueta_cuero1.jpeg','2020-05-23 13:14:39','2020-05-23 13:14:39');
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `precio` int(11) DEFAULT NULL,
  `activo` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (3,'Polera','P003-K',2590,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(4,'Camiseta deportiva','CD983-1',9890,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(6,'Chaqueta de cuero','ch0002-2',25990,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(7,'Sweeter','P003-1',12500,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(8,'Calceta nylon','P003-3',3500,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(9,'Chaleco lana','P003-2',349990,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(10,'Chaqueta de cuero','P003-4',35000,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(11,'Camisa de vestir','CV009-2',12990,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(12,'Pantalon de cuero','PC5678',9990,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(13,'Jeans','J8000',0,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(14,'Pantalon dama','PD789',9,1,'2020-05-22 20:58:00','2020-05-22 20:58:00'),(15,'Polera manga larga','PML001',9990,1,'2020-05-16 13:50:39','2020-05-16 13:50:39'),(16,'Camisa manga corta','CC0001',12990,2,'2020-05-22 21:54:25','2020-05-22 21:54:25');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','2020-05-29 13:05:04','2020-05-29 13:26:34'),(2,'Supervisor(a)','2020-05-29 14:49:54','2020-05-29 14:51:44'),(3,'Vendedor','2020-05-29 14:50:03','2020-05-29 14:57:37');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Segundo Galdames','segundogaldames@gmail.com','7c222fb2927d828af22f592134e8932480637c0d',1,1,'2020-05-29 15:49:26','2020-05-29 15:49:26');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-29 15:59:18
