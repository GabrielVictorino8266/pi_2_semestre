-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: rotisdb
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `tb_agendamentos`
--

DROP TABLE IF EXISTS `tb_agendamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_agendamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_agendamento` date NOT NULL,
  `receita_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_retirada` date DEFAULT NULL,
  `quantidade_receita` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `tb_agendamentos_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `tb_status` (`id`),
  CONSTRAINT `tb_agendamentos_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `tb_clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_agendamentos`
--

LOCK TABLES `tb_agendamentos` WRITE;
/*!40000 ALTER TABLE `tb_agendamentos` DISABLE KEYS */;
INSERT INTO `tb_agendamentos` VALUES (87,'2024-12-02',2,1,2,'','2024-12-03',1),(88,'2024-12-03',3,6,2,'Retirar no pix.','2024-12-04',1);
/*!40000 ALTER TABLE `tb_agendamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_categorias`
--

DROP TABLE IF EXISTS `tb_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_categorias`
--

LOCK TABLES `tb_categorias` WRITE;
/*!40000 ALTER TABLE `tb_categorias` DISABLE KEYS */;
INSERT INTO `tb_categorias` VALUES (1,'Massas'),(2,'Bolo'),(3,'Doces (bomba)'),(4,'Tortas'),(5,'Pães (com recheio)'),(6,'Pães (sem recheio)'),(7,'Outros');
/*!40000 ALTER TABLE `tb_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_clientes`
--

DROP TABLE IF EXISTS `tb_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_clientes`
--

LOCK TABLES `tb_clientes` WRITE;
/*!40000 ALTER TABLE `tb_clientes` DISABLE KEYS */;
INSERT INTO `tb_clientes` VALUES (1,'Gabriel Victorino','gabriel@gmail.com','55555555555'),(2,'Ana Lima Fernandes','ana_teste@gmail.com','87686868668'),(6,'Isadora Pontes','isadora@gmail.com','19887768655'),(18,'Isabel Pereira','isabel@gmail.com','78999999999');
/*!40000 ALTER TABLE `tb_clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_endereco`
--

DROP TABLE IF EXISTS `tb_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rua` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `tb_endereco_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `tb_clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_endereco`
--

LOCK TABLES `tb_endereco` WRITE;
/*!40000 ALTER TABLE `tb_endereco` DISABLE KEYS */;
INSERT INTO `tb_endereco` VALUES (1,'Rua Crisantemos Lemense','990','Nova Leme','Leme','SP','12345671',1),(3,'Rua Crisantemos Pereira','112','Nova Leme','Leme','SP','55465464',6),(7,'Rua teste 2','3123','Teste 2','Teste 2','SP','76786868',2),(8,'Rua Isabel Santos','123','Nova Isabel','Isabela','IS','77777777',18);
/*!40000 ALTER TABLE `tb_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_estoque`
--

DROP TABLE IF EXISTS `tb_estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL,
  `preco_venda` decimal(10,2) DEFAULT NULL,
  `tipo_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `ativado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `tipo_id` (`tipo_id`),
  CONSTRAINT `tb_estoque_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `tb_categorias` (`id`),
  CONSTRAINT `tb_estoque_ibfk_2` FOREIGN KEY (`tipo_id`) REFERENCES `tb_tipoitem` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_estoque`
--

LOCK TABLES `tb_estoque` WRITE;
/*!40000 ALTER TABLE `tb_estoque` DISABLE KEYS */;
INSERT INTO `tb_estoque` VALUES (1,'atualizar126',30,150.00,150.01,3,1,0),(2,'Bolo Especial de Chocolate com Cobertura',20,49.12,10.12,1,5,0),(3,'Torta Salgada',1,20.00,40.00,2,4,1),(4,'Granulado',20,2.99,0.00,1,7,1),(27,'Nao deve aparecer item',1,2.99,0.00,1,2,0),(28,'Recheio para Tortas',0,19.90,0.00,1,1,1),(29,'Recheio Para Bolo',2,45.99,45.99,1,5,1),(30,'Produto De Teste',1,3.00,30.00,1,3,0),(32,'Farinha',97,2.50,3.00,1,1,1),(33,'Ovos',47,12.00,20.99,1,1,1);
/*!40000 ALTER TABLE `tb_estoque` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER TRG_Registra_Preco_Unitario BEFORE UPDATE 
ON tb_estoque
FOR EACH ROW
BEGIN
	IF OLD.preco_unitario <> NEW.preco_unitario THEN
    	CALL SP_Registra_Alteracao_Preco_Custo(OLD.id, OLD.preco_unitario);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger TRG_Registra_Preco_Venda BEFORE UPDATE
ON tb_estoque
FOR EACH ROW
BEGIN
	IF OLD.preco_venda <> NEW.preco_venda THEN
    	CALL SP_Registra_Preco_Venda(OLD.id, OLD.preco_venda);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tb_funcoes`
--

DROP TABLE IF EXISTS `tb_funcoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_funcoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_funcoes`
--

LOCK TABLES `tb_funcoes` WRITE;
/*!40000 ALTER TABLE `tb_funcoes` DISABLE KEYS */;
INSERT INTO `tb_funcoes` VALUES (1,'Administrador'),(2,'Funcionário');
/*!40000 ALTER TABLE `tb_funcoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_logs_login`
--

DROP TABLE IF EXISTS `tb_logs_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_logs_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `data_horario_acesso` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_logs_login`
--

LOCK TABLES `tb_logs_login` WRITE;
/*!40000 ALTER TABLE `tb_logs_login` DISABLE KEYS */;
INSERT INTO `tb_logs_login` VALUES (1,'teste@gmail.com','2024-11-22 23:41:30'),(2,'teste@gmail.com','2024-11-23 00:20:25'),(3,'teste@gmail.com','2024-11-23 01:56:26'),(4,'teste@gmail.com','2024-11-24 01:03:08'),(5,'teste@gmail.com','2024-11-24 23:00:04'),(6,'teste@gmail.com','2024-11-24 23:23:33'),(7,'teste@gmail.com','2024-11-25 19:44:10'),(8,'teste@gmail.com','2024-11-26 22:18:43'),(9,'teste@gmail.com','2024-11-26 22:24:24'),(10,'teste@gmail.com','2024-11-26 23:32:08'),(11,'teste@gmail.com','2024-11-30 11:10:52'),(12,'teste@gmail.com','2024-11-30 11:16:51'),(13,'teste@gmail.com','2024-11-30 11:21:27'),(14,'teste@gmail.com','2024-11-30 11:22:17'),(15,'teste@gmail.com','2024-11-30 11:23:13'),(16,'teste@gmail.com','2024-11-30 14:15:10'),(17,'teste@gmail.com','2024-11-30 17:23:26'),(18,'teste@gmail.com','2024-11-30 22:47:31'),(19,'teste@gmail.com','2024-12-01 03:27:29'),(20,'teste@gmail.com','2024-12-01 03:30:39'),(21,'teste@gmail.com','2024-12-01 03:31:42'),(22,'teste@gmail.com','2024-12-01 03:42:05'),(23,'teste@gmail.com','2024-12-01 03:42:16'),(24,'teste@gmail.com','2024-12-01 04:24:35'),(25,'teste@gmail.com','2024-12-01 04:26:33'),(26,'teste@gmail.com','2024-12-02 18:47:20'),(27,'teste@gmail.com','2024-12-02 20:26:48'),(28,'teste@gmail.com','2024-12-02 22:43:00'),(29,'teste@gmail.com','2024-12-02 23:10:18'),(30,'teste@gmail.com','2024-12-03 02:00:25'),(31,'teste@gmail.com','2024-12-03 03:05:05'),(32,'teste@gmail.com','2024-12-03 06:53:41'),(33,'teste@gmail.com','2024-12-03 08:20:40'),(34,'teste@gmail.com','2024-12-03 12:57:01');
/*!40000 ALTER TABLE `tb_logs_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_preco_venda`
--

DROP TABLE IF EXISTS `tb_preco_venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_preco_venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estoque` int(11) NOT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `data_atualizacao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_preco_venda`
--

LOCK TABLES `tb_preco_venda` WRITE;
/*!40000 ALTER TABLE `tb_preco_venda` DISABLE KEYS */;
INSERT INTO `tb_preco_venda` VALUES (1,3,25.99,'2024-11-23 02:06:43'),(2,2,52.00,'2024-11-23 02:07:14'),(3,4,10.04,'2024-11-24 01:11:16'),(4,24,0.00,'2024-11-24 01:12:16'),(5,4,20.99,'2024-11-30 23:12:08'),(6,2,2.00,'2024-11-30 23:14:43'),(7,29,0.00,'2024-12-02 02:34:42'),(8,29,0.01,'2024-12-02 02:35:04'),(9,30,222.22,'2024-12-02 02:35:58'),(10,33,1.00,'2024-12-02 21:03:41'),(11,2,25.99,'2024-12-02 21:39:52'),(12,2,25.99,'2024-12-02 21:39:52'),(13,2,0.10,'2024-12-02 21:40:06'),(14,2,0.10,'2024-12-02 21:40:06'),(15,2,1.00,'2024-12-02 21:40:29'),(16,2,1.00,'2024-12-02 21:40:29'),(17,2,100.00,'2024-12-02 21:40:36'),(18,2,100.00,'2024-12-02 21:40:36'),(19,2,10.00,'2024-12-02 21:41:15'),(20,2,10.00,'2024-12-02 21:41:15'),(21,2,1000.00,'2024-12-02 21:41:38'),(22,2,1000.00,'2024-12-02 21:41:38'),(23,2,100000.00,'2024-12-02 21:41:52'),(24,2,100000.00,'2024-12-02 21:41:52'),(28,2,10.00,'2024-12-02 21:44:53'),(29,2,1000.00,'2024-12-02 21:44:58'),(30,2,10.00,'2024-12-02 21:45:36'),(31,29,0.00,'2024-12-02 21:47:03'),(32,29,0.01,'2024-12-02 21:57:17'),(33,30,22222.00,'2024-12-02 21:57:53'),(34,29,100.00,'2024-12-02 21:58:42'),(35,29,10000.00,'2024-12-02 21:59:47'),(36,29,10.01,'2024-12-02 22:01:14'),(37,2,1000.00,'2024-12-02 22:08:18'),(38,2,10.00,'2024-12-02 22:08:37'),(39,29,10.20,'2024-12-02 22:21:18'),(40,29,10.12,'2024-12-02 22:22:37'),(41,29,1012.00,'2024-12-02 22:24:22'),(42,29,10.12,'2024-12-02 22:29:24'),(43,29,1012.00,'2024-12-02 22:29:48'),(44,29,101200.00,'2024-12-02 22:29:58'),(45,29,10120000.00,'2024-12-02 22:30:40'),(46,29,99999999.99,'2024-12-02 22:31:51'),(47,29,44.44,'2024-12-02 22:33:02'),(48,2,1000.00,'2024-12-02 22:33:58'),(49,2,10.00,'2024-12-02 22:38:35'),(50,33,0.00,'2024-12-02 23:10:54');
/*!40000 ALTER TABLE `tb_preco_venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_precos_compra`
--

DROP TABLE IF EXISTS `tb_precos_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_precos_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estoque_id` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `estoque_id` (`estoque_id`),
  CONSTRAINT `tb_precos_compra_ibfk_1` FOREIGN KEY (`estoque_id`) REFERENCES `tb_estoque` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_precos_compra`
--

LOCK TABLES `tb_precos_compra` WRITE;
/*!40000 ALTER TABLE `tb_precos_compra` DISABLE KEYS */;
INSERT INTO `tb_precos_compra` VALUES (1,2,5.20,'2024-11-23 01:54:49'),(2,2,100.00,'2024-11-23 01:55:44'),(3,3,5.90,'2024-11-23 01:56:39'),(4,4,5.60,'2024-11-24 01:11:16'),(6,4,5.99,'2024-11-30 23:12:02'),(7,3,6.00,'2024-11-30 23:13:40'),(8,3,7.00,'2024-11-30 23:13:51'),(9,2,25.99,'2024-11-30 23:14:49'),(10,2,15.99,'2024-11-30 23:35:36'),(11,29,499.00,'2024-12-02 02:34:42'),(12,29,4990.01,'2024-12-02 02:35:04'),(13,30,30.00,'2024-12-02 02:35:58'),(14,28,1.99,'2024-12-02 20:56:22'),(15,33,0.50,'2024-12-02 21:03:41'),(16,33,50.00,'2024-12-02 21:03:56'),(17,28,199.00,'2024-12-02 21:18:33'),(18,2,15.00,'2024-12-02 21:39:52'),(19,2,1500.00,'2024-12-02 21:40:06'),(20,2,150000.00,'2024-12-02 21:40:29'),(21,2,1.50,'2024-12-02 21:40:36'),(22,2,150.00,'2024-12-02 21:41:15'),(23,2,15.00,'2024-12-02 21:41:38'),(24,2,1.50,'2024-12-02 21:41:52'),(28,2,150.00,'2024-12-02 21:44:53'),(29,2,15.00,'2024-12-02 21:44:58'),(30,2,1500.00,'2024-12-02 21:45:36'),(31,29,4.99,'2024-12-02 21:47:03'),(32,29,4990.01,'2024-12-02 21:57:17'),(33,30,3000.00,'2024-12-02 21:57:53'),(34,29,49.90,'2024-12-02 21:58:42'),(35,29,49.99,'2024-12-02 21:59:47'),(36,29,49.01,'2024-12-02 22:01:14'),(37,2,15.00,'2024-12-02 22:08:18'),(38,2,1500.00,'2024-12-02 22:08:37'),(39,29,49.10,'2024-12-02 22:21:18'),(40,29,49.12,'2024-12-02 22:22:37'),(41,29,4912.00,'2024-12-02 22:24:22'),(42,29,49.12,'2024-12-02 22:29:24'),(43,29,4912.00,'2024-12-02 22:29:48'),(44,29,491200.00,'2024-12-02 22:29:58'),(45,29,49120000.00,'2024-12-02 22:30:40'),(46,29,99999999.99,'2024-12-02 22:31:51'),(47,29,45.00,'2024-12-02 22:33:02'),(48,2,15.00,'2024-12-02 22:38:35'),(49,32,2.00,'2024-12-02 22:45:29'),(50,3,20.00,'2024-12-03 00:36:43'),(51,3,200.01,'2024-12-03 00:36:47'),(52,2,49.12,'2024-12-03 08:20:46'),(53,2,49.13,'2024-12-03 12:57:32');
/*!40000 ALTER TABLE `tb_precos_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_receitas`
--

DROP TABLE IF EXISTS `tb_receitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_receitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_final_id` int(11) NOT NULL,
  `ingrediente_id` int(11) NOT NULL,
  `quantidade_necessaria` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_final_id` (`produto_final_id`),
  KEY `ingrediente_id` (`ingrediente_id`),
  CONSTRAINT `tb_receitas_ibfk_1` FOREIGN KEY (`produto_final_id`) REFERENCES `tb_estoque` (`id`),
  CONSTRAINT `tb_receitas_ibfk_2` FOREIGN KEY (`ingrediente_id`) REFERENCES `tb_estoque` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_receitas`
--

LOCK TABLES `tb_receitas` WRITE;
/*!40000 ALTER TABLE `tb_receitas` DISABLE KEYS */;
INSERT INTO `tb_receitas` VALUES (1,3,28,1.00),(2,3,28,2.00),(3,2,4,2.00),(4,2,29,1.00);
/*!40000 ALTER TABLE `tb_receitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_status`
--

DROP TABLE IF EXISTS `tb_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_activated` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_status`
--

LOCK TABLES `tb_status` WRITE;
/*!40000 ALTER TABLE `tb_status` DISABLE KEYS */;
INSERT INTO `tb_status` VALUES (1,'Finalizado',1),(2,'Em Andamento',1),(3,'Cancelado',1);
/*!40000 ALTER TABLE `tb_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tipoitem`
--

DROP TABLE IF EXISTS `tb_tipoitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tipoitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tipoitem`
--

LOCK TABLES `tb_tipoitem` WRITE;
/*!40000 ALTER TABLE `tb_tipoitem` DISABLE KEYS */;
INSERT INTO `tb_tipoitem` VALUES (1,'Ingrediente'),(2,'Produto Final'),(3,'Outros');
/*!40000 ALTER TABLE `tb_tipoitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_usuarios`
--

DROP TABLE IF EXISTS `tb_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funcao_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_email` (`email`),
  KEY `funcao_id` (`funcao_id`),
  CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`funcao_id`) REFERENCES `tb_funcoes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_usuarios`
--

LOCK TABLES `tb_usuarios` WRITE;
/*!40000 ALTER TABLE `tb_usuarios` DISABLE KEYS */;
INSERT INTO `tb_usuarios` VALUES (4,'admin','teste@gmail.com','$2y$10$3LESeYRHARp96oGGxzLuKe269oVdCTA41F28CqyGGj3fwBnNHVB9O',1),(21,'vendedor','vendedor@gmail.com','$2y$10$3LESeYRHARp96oGGxzLuKe269oVdCTA41F28CqyGGj3fwBnNHVB9O',2);
/*!40000 ALTER TABLE `tb_usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-03 13:02:00
