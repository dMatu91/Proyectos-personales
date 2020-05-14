-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.50-community


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema farmacia
--

CREATE DATABASE IF NOT EXISTS farmacia;
USE farmacia;

--
-- Definition of table `farmaceuticos`
--

DROP TABLE IF EXISTS `farmaceuticos`;
CREATE TABLE `farmaceuticos` (
  `nColegiado` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  PRIMARY KEY (`nColegiado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `farmaceuticos`
--

/*!40000 ALTER TABLE `farmaceuticos` DISABLE KEYS */;
INSERT INTO `farmaceuticos` (`nColegiado`,`nombre`,`apellidos`,`contrasena`) VALUES 
 (1,'Mariano','Perez Castro','1'),
 (2,'Luisa','Rodriguez Abad','2');
/*!40000 ALTER TABLE `farmaceuticos` ENABLE KEYS */;


--
-- Definition of table `medicamentosfarmacia`
--

DROP TABLE IF EXISTS `medicamentosfarmacia`;
CREATE TABLE `medicamentosfarmacia` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` int(10) unsigned NOT NULL,
  `caducidad` date NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicamentosfarmacia`
--

/*!40000 ALTER TABLE `medicamentosfarmacia` DISABLE KEYS */;
INSERT INTO `medicamentosfarmacia` (`codigo`,`cantidad`,`caducidad`) VALUES 
 (1,6,'2030-12-12'),
 (2,0,'2018-04-02'),
 (3,1,'2020-07-25'),
 (4,9,'2020-12-02'),
 (5,2,'2015-01-05'),
 (6,7,'2018-11-17'),
 (7,2,'2030-10-10'),
 (8,3,'2025-02-13'),
 (9,0,'2017-03-23'),
 (10,7,'2016-07-27'),
 (11,2,'2020-09-12'),
 (12,12,'2019-03-08'),
 (13,1,'2021-10-23'),
 (14,4,'2016-03-12'),
 (15,1,'2018-05-27'),
 (16,0,'2020-12-12'),
 (17,7,'2021-01-17'),
 (18,3,'2015-07-20'),
 (19,0,'2018-02-19');
/*!40000 ALTER TABLE `medicamentosfarmacia` ENABLE KEYS */;


--
-- Definition of table `medicamentosgeneral`
--

DROP TABLE IF EXISTS `medicamentosgeneral`;
CREATE TABLE `medicamentosgeneral` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(130) NOT NULL,
  `precio` double NOT NULL,
  `iva` double NOT NULL,
  `laboratorio` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicamentosgeneral`
--

/*!40000 ALTER TABLE `medicamentosgeneral` DISABLE KEYS */;
INSERT INTO `medicamentosgeneral` (`codigo`,`nombre`,`descripcion`,`precio`,`iva`,`laboratorio`) VALUES 
 (1,'Paracetamol','medicamento usado para el dolor en general',1.2,0.04,'Bayer'),
 (2,'Ibuprofeno','medicamento usado para el dolor en general y las inflamaciones',0.9,0.04,'Cinfa'),
 (3,'Aspirina','medicamento usado para el dolor de cabeza y corporal',1.3,0.04,'Bayer'),
 (4,'Frenadol','medicamentos usado para la gripe, el catarro y congestion nasal',2.2,0.04,'Apotex'),
 (5,'Dalsy','medicamento para menores que trata la fiebre',1.5,0.04,'Abbot'),
 (6,'Omeprazol','medicamento usado para el dolor de estomago, protector gastrico',2,0.04,'Pensa'),
 (7,'Alprazolam','medicamento usado para tratar la ansiedad',2,0.04,'Cinfa'),
 (8,'Almax','medicamento para tratar el ardor de estomago',1.4,0.04,'Normon'),
 (9,'Gaviscon','medicamento para tratar el ardor de estomago',1.6,0.04,'Pensa'),
 (10,'Zolpidem','medicamento para tratar la falta de sueño ,  insomnio',3.8,0.04,'Apotex'),
 (11,'Lorazepam','medicamento tranquilizante',2.1,0.04,'Abbot'),
 (12,'Sintrom','medicamento antiagregante plaquetario, anticoagulante',0.8,0.04,'Normon'),
 (13,'Sertralina','medicamento usado para tratar depresion',4.4,0.04,'Cinfa'),
 (14,'Citalopram','medicamento usado para tratar depresion',4.35,0.04,'Apotex'),
 (15,'Bilaxten','medicamento para tratar alergia',2.2,0.12,'Pensa'),
 (16,'Ibis','medicamento para tratar alergia',1.75,0.12,'Almirall'),
 (17,'Ebastel','medicamento para tratar alergia',1.3,0.12,'Abbot'),
 (18,'Eliquis','medicamento antiagregante plaquetario, anticoagulante',1.1,0.04,'Almirall'),
 (19,'Ranitidina','medicamento usado para el dolor de estomago',0.75,0.04,'Cinfa');
/*!40000 ALTER TABLE `medicamentosgeneral` ENABLE KEYS */;


--
-- Definition of table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigoMedicamento` int(10) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `estadoPedido` int(10) unsigned NOT NULL,
  `fechaPedido` date DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedidos`
--

/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`codigo`,`codigoMedicamento`,`cantidad`,`estadoPedido`,`fechaPedido`) VALUES 
 (2,2,2,2,'2016-04-24'),
 (8,3,6,2,'2016-04-24'),
 (10,5,7,2,'2016-04-24'),
 (13,2,9,2,'2016-05-08'),
 (14,5,3,2,'2016-05-08'),
 (15,5,7,2,'2016-05-08'),
 (17,1,4,2,'2016-05-22'),
 (18,8,3,2,'2016-05-22'),
 (19,17,2,2,'2016-05-22');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;


--
-- Definition of table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigoVenta` int(10) unsigned NOT NULL,
  `codigoMedicamento` int(10) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `estadoVenta` int(10) unsigned NOT NULL,
  `fechaVenta` date DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ventas`
--

/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` (`codigo`,`codigoVenta`,`codigoMedicamento`,`cantidad`,`estadoVenta`,`fechaVenta`) VALUES 
 (1,1,2,4,2,NULL),
 (9,2,4,4,2,'2016-05-15'),
 (10,2,1,5,2,'2016-05-15'),
 (11,3,1,3,2,'2016-05-15'),
 (12,4,6,2,2,'2016-05-15'),
 (13,5,12,3,2,'2016-05-22'),
 (14,5,6,1,2,'2016-05-22');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
