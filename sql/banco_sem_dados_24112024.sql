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
-- Dumping routines for database 'rotisdb'
--
/*!50003 DROP PROCEDURE IF EXISTS `SP_Registra_Acesso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Registra_Acesso`(IN email VARCHAR(255))
BEGIN
	INSERT INTO tb_logs_login (email, data_horario_acesso)
    VALUES (email, NOW());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_Registra_Alteracao_Preco_Custo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Registra_Alteracao_Preco_Custo`(IN id_estoque INT,IN preco_antigo DECIMAL(10,2))
BEGIN
    INSERT INTO tb_precos_compra (estoque_id, preco_unitario, data_atualizacao) 
    VALUES (id_estoque, preco_antigo, NOW());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_Registra_Preco_Venda` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Registra_Preco_Venda`(IN id_estoque INT, IN preco_venda DECIMAL(10,2))
BEGIN
	INSERT INTO tb_preco_venda (id_estoque, preco_venda, data_atualizacao)
    VALUES (id_estoque, preco_venda, NOW());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-24  1:42:06
