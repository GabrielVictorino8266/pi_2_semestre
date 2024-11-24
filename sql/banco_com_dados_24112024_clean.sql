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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_agendamentos`
--

LOCK TABLES `tb_agendamentos` WRITE;
/*!40000 ALTER TABLE `tb_agendamentos` DISABLE KEYS */;
INSERT INTO `tb_agendamentos` VALUES (41,'2024-11-22',10,2,2,'Retirar dia 15/12FDFSDF','2024-11-21',3),(42,'2024-10-29',2,1,2,'Observação 14','2024-11-21',4),(43,'2024-10-29',21,1,2,'Observação 15','2024-11-23',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_clientes`
--

LOCK TABLES `tb_clientes` WRITE;
/*!40000 ALTER TABLE `tb_clientes` DISABLE KEYS */;
INSERT INTO `tb_clientes` VALUES (1,'Gabriel Victorino','gabriel@gmail.com','66678989'),(2,'Ana Lima Fernandes','ana_teste@gmail.com','11987654321dsada'),(6,'Isadora Pontes','isadora@gmail.com','1999899999');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_endereco`
--

LOCK TABLES `tb_endereco` WRITE;
/*!40000 ALTER TABLE `tb_endereco` DISABLE KEYS */;
INSERT INTO `tb_endereco` VALUES (1,'Rua Crisantemos Teste','123','Bairro Teste','Cidade Teste','ES','12345678',1),(3,'Rua Crisantemos Pereira','112','Nova Leme','Leme','SP','2345678',6),(7,'Rua teste 2','3123','Teste 2','Teste 2','SP','321312312',2);
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_estoque`
--

LOCK TABLES `tb_estoque` WRITE;
/*!40000 ALTER TABLE `tb_estoque` DISABLE KEYS */;
INSERT INTO `tb_estoque` VALUES (1,'atualizar126',30,150.00,150.01,3,1,0),(2,'BOLO COBERTURA EXTRA DOCE CHOCOLATE CARAMELO',3,25.99,2.00,2,2,0),(3,'TORTA SALGADA',2,6.00,40.00,2,4,1),(4,'descricao',3,5.99,20.99,2,2,1),(5,'Farinha de Trigo',100,2.50,0.00,1,1,1),(6,'Leite Condensado',80,4.00,0.00,1,3,1),(7,'Queijo Mussarela',50,10.00,NULL,1,5,1),(8,'Bolo de Chocolate',20,5.00,25.00,2,2,1),(9,'Torta de Frango',15,8.00,40.00,2,4,1),(10,'Pão de Queijo',60,1.50,3.00,2,6,1),(11,'Recheio de Doce de Leite',40,3.50,NULL,1,3,1),(12,'Massa de Pizza',30,2.00,8.00,3,1,1),(13,'Pão Francês',100,0.80,1.60,2,6,1),(14,'Brigadeiro Gourmet',25,1.20,5.00,2,3,1),(15,'Margarina',70,3.00,NULL,1,7,1),(16,'Frango Desfiado',50,7.00,NULL,1,4,1),(17,'Quiche de Espinafre',15,6.00,25.00,2,4,1),(18,'Pão de Calabresa',30,1.20,2.40,2,5,1),(19,'Molho de Tomate',40,2.50,NULL,1,7,1),(21,'dsa',3,45.00,45.50,2,4,1),(22,'dasdasda',2,45.45,45.50,1,3,2),(24,'CADASTRO 24',1,5.99,6.00,2,5,1);
/*!40000 ALTER TABLE `tb_estoque` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_logs_login`
--

LOCK TABLES `tb_logs_login` WRITE;
/*!40000 ALTER TABLE `tb_logs_login` DISABLE KEYS */;
INSERT INTO `tb_logs_login` VALUES (1,'teste@gmail.com','2024-11-22 23:41:30'),(2,'teste@gmail.com','2024-11-23 00:20:25'),(3,'teste@gmail.com','2024-11-23 01:56:26'),(4,'teste@gmail.com','2024-11-24 01:03:08');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_preco_venda`
--

LOCK TABLES `tb_preco_venda` WRITE;
/*!40000 ALTER TABLE `tb_preco_venda` DISABLE KEYS */;
INSERT INTO `tb_preco_venda` VALUES (1,3,25.99,'2024-11-23 02:06:43'),(2,2,52.00,'2024-11-23 02:07:14'),(3,4,10.04,'2024-11-24 01:11:16'),(4,24,0.00,'2024-11-24 01:12:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_precos_compra`
--

LOCK TABLES `tb_precos_compra` WRITE;
/*!40000 ALTER TABLE `tb_precos_compra` DISABLE KEYS */;
INSERT INTO `tb_precos_compra` VALUES (1,2,5.20,'2024-11-23 01:54:49'),(2,2,100.00,'2024-11-23 01:55:44'),(3,3,5.90,'2024-11-23 01:56:39'),(4,4,5.60,'2024-11-24 01:11:16'),(5,24,0.00,'2024-11-24 01:12:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_receitas`
--

LOCK TABLES `tb_receitas` WRITE;
/*!40000 ALTER TABLE `tb_receitas` DISABLE KEYS */;
INSERT INTO `tb_receitas` VALUES (1,3,1,2.00),(2,3,4,3.00),(3,2,4,4.00),(4,2,1,5.00);
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
INSERT INTO `tb_status` VALUES (1,'Finalizado',1),(2,'Em Andamento',1),(3,'Cancelado',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_usuarios`
--

LOCK TABLES `tb_usuarios` WRITE;
/*!40000 ALTER TABLE `tb_usuarios` DISABLE KEYS */;
INSERT INTO `tb_usuarios` VALUES (4,'teste','teste@gmail.com','$2y$10$3LESeYRHARp96oGGxzLuKe269oVdCTA41F28CqyGGj3fwBnNHVB9O',1),(13,'','','$2y$10$XDtymEqQ2ZXNneogd3xXFu.exblOiRqoZAzAxY6TCFzCssjfUu1.y',1),(14,'Gabriel','gustavo@gmail.com','$2y$10$lWxluQs.cxv/fGSq0Ewpl.HgSFvSzFe0ekz89lHqW3pWxMf1H3Ww.',2),(16,'fernando','fernado@gmail.com','$2y$10$OHLuAa61/U6vOPYuzKajk.JifOacJRkedrByypPWJP.4bNb4bVUUK',1);
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

-- Dump completed on 2024-11-24  2:00:27
