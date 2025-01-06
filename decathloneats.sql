-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: decathloneats
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `CATEGORIA`
--

DROP TABLE IF EXISTS `CATEGORIA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CATEGORIA` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `url_imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CATEGORIA`
--

LOCK TABLES `CATEGORIA` WRITE;
/*!40000 ALTER TABLE `CATEGORIA` DISABLE KEYS */;
INSERT INTO `CATEGORIA` VALUES (1,'Hamburguesas','Deliciosas hamburguesas con diversos ingredientes.','/PROYECTO1/images/PRODUCTOS/bigKing.webp'),(2,'Menús','Menús completos con bebida y guarnición.','/PROYECTO1/images/PRODUCTOS/menu_bigKing.webp'),(3,'Combos','Combos con productos especiales.','/PROYECTO1/images/PRODUCTOS/combo1.webp'),(4,'Postres','Postres dulces y deliciosos.','/PROYECTO1/images/PRODUCTOS/sundae_Chocolate.webp'),(5,'Patatas','Patatas fritas de varios tamaños.','/PROYECTO1/images/PRODUCTOS/patatasFritas.webp'),(6,'Bebidas','Bebidas frías y refrescantes.','/PROYECTO1/images/PRODUCTOS/COCACOLA.webp'),(7,'Infantiles','Menús pensados para los más pequeños.','/PROYECTO1/images/PRODUCTOS/king_jr.webp'),(8,'Ofertas','Productos en oferta.','/PROYECTO1/images/PRODUCTOS/king_oferta1.webp'),(17,'Hamburguesas','Deliciosas hamburguesas con diversos ingredientes.','/PROYECTO1/images/PRODUCTOS/bigKing.webp'),(18,'Menús','Menús completos con bebida y guarnición.','/PROYECTO1/images/PRODUCTOS/menu_bigKing.webp'),(19,'Combos','Combos con productos especiales.','/PROYECTO1/images/PRODUCTOS/combo1.webp'),(20,'Postres','Postres dulces y deliciosos.','/PROYECTO1/images/PRODUCTOS/sundae_Chocolate.webp'),(21,'Patatas','Patatas fritas de varios tamaños.','/PROYECTO1/images/PRODUCTOS/patatasFritas.webp'),(22,'Bebidas','Bebidas frías y refrescantes.','/PROYECTO1/images/PRODUCTOS/COCACOLA.webp'),(23,'Infantiles','Menús pensados para los más pequeños.','/PROYECTO1/images/PRODUCTOS/king_jr.webp'),(24,'Ofertas','Productos en oferta.','/PROYECTO1/images/PRODUCTOS/king_oferta1.webp');
/*!40000 ALTER TABLE `CATEGORIA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DESCUENTOS`
--

DROP TABLE IF EXISTS `DESCUENTOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DESCUENTOS` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_descuento` varchar(50) DEFAULT NULL,
  `tipo_descuento` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DESCUENTOS`
--

LOCK TABLES `DESCUENTOS` WRITE;
/*!40000 ALTER TABLE `DESCUENTOS` DISABLE KEYS */;
INSERT INTO `DESCUENTOS` VALUES (2,'DESCUENTO20','20%');
/*!40000 ALTER TABLE `DESCUENTOS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `INGREDIENTE`
--

DROP TABLE IF EXISTS `INGREDIENTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `INGREDIENTE` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_ingrediente` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `INGREDIENTE`
--

LOCK TABLES `INGREDIENTE` WRITE;
/*!40000 ALTER TABLE `INGREDIENTE` DISABLE KEYS */;
/*!40000 ALTER TABLE `INGREDIENTE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LINEA_PEDIDO`
--

DROP TABLE IF EXISTS `LINEA_PEDIDO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `LINEA_PEDIDO` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad_productos` int DEFAULT NULL,
  `precio_productos` decimal(10,2) DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `id_descuento` int DEFAULT NULL,
  `numero_pedido` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_producto` (`id_producto`),
  KEY `id_descuento` (`id_descuento`),
  KEY `numero_pedido` (`numero_pedido`),
  CONSTRAINT `LINEA_PEDIDO_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `PRODUCTO` (`id`),
  CONSTRAINT `LINEA_PEDIDO_ibfk_2` FOREIGN KEY (`id_descuento`) REFERENCES `DESCUENTOS` (`id`),
  CONSTRAINT `LINEA_PEDIDO_ibfk_3` FOREIGN KEY (`numero_pedido`) REFERENCES `PEDIDO` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=340 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LINEA_PEDIDO`
--

LOCK TABLES `LINEA_PEDIDO` WRITE;
/*!40000 ALTER TABLE `LINEA_PEDIDO` DISABLE KEYS */;
INSERT INTO `LINEA_PEDIDO` VALUES (306,1,4.99,1,NULL,122),(307,1,6.49,2,NULL,122),(326,1,1.00,20,NULL,121),(327,1,5.00,3,NULL,121),(328,1,7.00,5,NULL,121),(329,1,8.00,7,NULL,121),(330,1,4.00,23,NULL,121),(331,2,4.00,21,NULL,121),(335,1,5.00,1,NULL,123),(336,1,2.00,21,NULL,123),(337,1,2.00,21,NULL,124),(338,1,2.00,19,NULL,124),(339,1,5.99,1,NULL,126);
/*!40000 ALTER TABLE `LINEA_PEDIDO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LINEA_PEDIDO_INGREDIENTE`
--

DROP TABLE IF EXISTS `LINEA_PEDIDO_INGREDIENTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `LINEA_PEDIDO_INGREDIENTE` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int DEFAULT NULL,
  `id_ingrediente` int DEFAULT NULL,
  `numero_pedido` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ingrediente` (`id_ingrediente`),
  KEY `numero_pedido` (`numero_pedido`),
  CONSTRAINT `LINEA_PEDIDO_INGREDIENTE_ibfk_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `INGREDIENTE` (`id`),
  CONSTRAINT `LINEA_PEDIDO_INGREDIENTE_ibfk_2` FOREIGN KEY (`numero_pedido`) REFERENCES `PEDIDO` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LINEA_PEDIDO_INGREDIENTE`
--

LOCK TABLES `LINEA_PEDIDO_INGREDIENTE` WRITE;
/*!40000 ALTER TABLE `LINEA_PEDIDO_INGREDIENTE` DISABLE KEYS */;
/*!40000 ALTER TABLE `LINEA_PEDIDO_INGREDIENTE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OFERTAS`
--

DROP TABLE IF EXISTS `OFERTAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `OFERTAS` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_oferta` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OFERTAS`
--

LOCK TABLES `OFERTAS` WRITE;
/*!40000 ALTER TABLE `OFERTAS` DISABLE KEYS */;
/*!40000 ALTER TABLE `OFERTAS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PEDIDO`
--

DROP TABLE IF EXISTS `PEDIDO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PEDIDO` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha_pedido` datetime DEFAULT NULL,
  `precio_total_pedidos` decimal(10,2) DEFAULT NULL,
  `cantidad_productos` int DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `PEDIDO_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `USUARIO` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PEDIDO`
--

LOCK TABLES `PEDIDO` WRITE;
/*!40000 ALTER TABLE `PEDIDO` DISABLE KEYS */;
INSERT INTO `PEDIDO` VALUES (121,'2025-01-03 23:23:49',31.96,7,3),(122,'2025-01-04 16:28:15',11.48,2,1),(123,'2025-01-04 16:28:32',7.99,2,3),(124,'2025-01-04 16:28:45',4.00,2,11),(126,'2025-01-05 01:53:46',5.99,1,3);
/*!40000 ALTER TABLE `PEDIDO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PRODUCTO`
--

DROP TABLE IF EXISTS `PRODUCTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PRODUCTO` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` text,
  `url_imagen` varchar(255) DEFAULT NULL,
  `id_oferta` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_oferta` (`id_oferta`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `PRODUCTO_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `OFERTAS` (`id`),
  CONSTRAINT `PRODUCTO_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `CATEGORIA` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PRODUCTO`
--

LOCK TABLES `PRODUCTO` WRITE;
/*!40000 ALTER TABLE `PRODUCTO` DISABLE KEYS */;
INSERT INTO `PRODUCTO` VALUES (1,'Long Chicken VEG',5.99,'Hamburguesa de pollo empanado con vegetales, ideal para los que prefieren una opción vegetariana.','/PROYECTO1/images/PRODUCTOS/longChicken_vegetal.webp',NULL,1),(2,'Big King',6.49,'Hamburguesa de ternera con salsa especial y pan con semillas de sésamo.','/PROYECTO1/images/PRODUCTOS/bigKing.webp',NULL,1),(3,'CBK',5.49,'Hamburguesa con una mezcla de ingredientes frescos y suculentos.','/PROYECTO1/images/PRODUCTOS/cbk.webp',NULL,1),(4,'King Cheetos',7.99,'Hamburguesa de ternera con bacon crujiente, queso y una salsa especial Cheetos.','/PROYECTO1/images/PRODUCTOS/kingCheetos.webp',NULL,1),(5,'Menú BigKing',7.99,'Menú completo con Big King, patatas y bebida.','/PROYECTO1/images/PRODUCTOS/menu_bigKing.webp',NULL,2),(6,'Menú Cheese',6.99,'Menú completo con hamburguesa Cheese, patatas y bebida.','/PROYECTO1/images/PRODUCTOS/menu_CheeseBurger.webp',NULL,2),(7,'Menú LCV',8.49,'Menú con Long Chicken Vegetal, patatas y bebida.','/PROYECTO1/images/PRODUCTOS/menu_kingCheetos.webp',NULL,2),(8,'Menú Strekhouse',6.49,'Menú con hamburguesa Strekhouse, patatas y bebida.','/PROYECTO1/images/PRODUCTOS/menu_strekhouse.webp',NULL,2),(9,'Combo1',9.99,'Combo para compartir que incluye dos menus una Bacon y una Cheese.','/PROYECTO1/images/PRODUCTOS/combo1.webp',NULL,3),(10,'Sundae Chocolate',3.49,'Postre de helado con chocolate caliente.','/PROYECTO1/images/PRODUCTOS/sundae_Chocolate.webp',NULL,4),(11,'Danonino',3.49,'Yogur de fresa.','/PROYECTO1/images/PRODUCTOS/danonino.webp',NULL,4),(12,'Gofre',3.99,'Gofre con chocolate por encima','/PROYECTO1/images/PRODUCTOS/gofre.webp',NULL,4),(13,'King Fusion',4.49,'Helado con chocolate y oreo picada por encima','/PROYECTO1/images/PRODUCTOS/kingFusion.webp',NULL,4),(14,'Patatas Fritas',2.49,'Patatas fritas clásicas.','/PROYECTO1/images/PRODUCTOS/patatasFritas.webp',NULL,5),(15,'Patatas Deluxe',3.49,'Patatas fritas deluxe con salsa.','/PROYECTO1/images/PRODUCTOS/patatasDeluxe.webp',NULL,5),(16,'Patatas con Bacon',3.99,'Patatas con bacon y queso.','/PROYECTO1/images/PRODUCTOS/patatasBacon.webp',NULL,5),(17,'Cubo Patatas',2.99,'Cubo de patatas con gran tamaño.','/PROYECTO1/images/PRODUCTOS/cuboPatatas.webp',NULL,5),(18,'Coca-Cola',2.00,'Refresco clásico Coca-Cola.','/PROYECTO1/images/PRODUCTOS/COCACOLA.webp',NULL,6),(19,'Aquarius Limon',2.00,'Refresco de limón y lima.','/PROYECTO1/images/PRODUCTOS/AquariusLimon.webp',NULL,6),(20,'FuzeTea',1.00,'Refresco de te.','/PROYECTO1/images/PRODUCTOS/FUZETEA.webp',NULL,6),(21,'Fanta',2.00,'Refresco de naranja.','/PROYECTO1/images/PRODUCTOS/FANTA.webp',NULL,6),(22,'Menú Infantil 1',5.99,'Menú infantil con mini hamburguesa, patatas y bebida.','/PROYECTO1/images/PRODUCTOS/king_jr.webp',NULL,7),(23,'Oferta 1',4.99,'Oferta especial con Hamburgesa Secreta.','/PROYECTO1/images/PRODUCTOS/king_oferta1.webp',NULL,8);
/*!40000 ALTER TABLE `PRODUCTO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PRODUCTO_INGREDIENTE`
--

DROP TABLE IF EXISTS `PRODUCTO_INGREDIENTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PRODUCTO_INGREDIENTE` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_producto` int DEFAULT NULL,
  `id_ingrediente` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_producto` (`id_producto`),
  KEY `id_ingrediente` (`id_ingrediente`),
  CONSTRAINT `PRODUCTO_INGREDIENTE_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `PRODUCTO` (`id`),
  CONSTRAINT `PRODUCTO_INGREDIENTE_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `INGREDIENTE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PRODUCTO_INGREDIENTE`
--

LOCK TABLES `PRODUCTO_INGREDIENTE` WRITE;
/*!40000 ALTER TABLE `PRODUCTO_INGREDIENTE` DISABLE KEYS */;
/*!40000 ALTER TABLE `PRODUCTO_INGREDIENTE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TIPO`
--

DROP TABLE IF EXISTS `TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TIPO` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `TIPO_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `CATEGORIA` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TIPO`
--

LOCK TABLES `TIPO` WRITE;
/*!40000 ALTER TABLE `TIPO` DISABLE KEYS */;
INSERT INTO `TIPO` VALUES (1,'Pollo',1),(2,'Ternera',1),(3,'Vegetal',1),(4,'Helado',4),(5,'Yogures',4),(6,'Pastas',4);
/*!40000 ALTER TABLE `TIPO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USUARIO`
--

DROP TABLE IF EXISTS `USUARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USUARIO` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `rol` varchar(50) DEFAULT 'cliente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USUARIO`
--

LOCK TABLES `USUARIO` WRITE;
/*!40000 ALTER TABLE `USUARIO` DISABLE KEYS */;
INSERT INTO `USUARIO` VALUES (1,'Marc','marc@gmail.com','$2y$10$uDMUCFJ3hZ5mnXEAxsT7KOM1o7MUznRfAXb.IM9i6UES2zW6Fv6w.','Martorell','678676756',NULL,'usuario'),(3,'admin','admin@gmail.com','$2y$10$IekCfeYwAdEtiTAO1MkQm.bNQVGvGQYBWBnH3scCmyqlyz/19J9Gy','Direccion de Admin','666666666',NULL,'admin'),(11,'pruebaa','prueba@gmail.com','$2y$10$IsWHoAwwPmaXAjae4.AujeS6OdXFsy8YY1Dd4Ukn98a.JCNBQJRQa','Direccion prueba 1',NULL,NULL,'usuario'),(23,'Chris','chris@gmail.com','$2y$10$sZCE0vmkAkxbgAjPAWPLgO12Ikqu/umhv1TJmgEx.TFEIaBN2bTlG','Direccion de Chris',NULL,NULL,'usuario');
/*!40000 ALTER TABLE `USUARIO` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-06 18:12:33
