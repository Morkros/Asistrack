-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         11.2.0-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sistema
CREATE DATABASE IF NOT EXISTS `sistema` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_bin */;
USE `sistema`;

-- Volcando estructura para tabla sistema.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dni` int(8) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nacimiento` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_dni` (`dni`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Volcando datos para la tabla sistema.alumnos: ~3 rows (aproximadamente)
INSERT INTO `alumnos` (`id`, `dni`, `nombre`, `apellido`, `nacimiento`) VALUES
	(10, 40790201, 'Esteban', 'Copello', '1998-02-13'),
	(11, 42850626, 'Lucas', 'Barreiro', '2000-10-04'),
  (12, 45847922, 'Franco', 'Cabrera', '1999-11-12'),
  (13, 43149316, 'Franco Agustin', 'Chappe', '1997-09-14'),
  (14, 43632750, 'Roman', 'Coletti', '1995-01-23'),
  (15, 40790545, 'Daian Exequiel', 'Fernandez', '1996-10-10'),
  (16, 44980999, 'Nicolas Osvaldo', 'Fernandez', '2000-11-25'),
  (17, 44623314, 'Facundo Geronimo', 'Figun', '1999-05-15'),
  (18, 45389325, 'Lucas Jeremias', 'Fiorotto', '1991-06-12'),
  (19, 45048325, 'Felipe', 'Franco', '2000-05-05'),
  (20, 43631803, 'Bruno', 'Godoy', '1989-11-20'),
  (21, 42069298, 'Marcos Damian', 'Godoy', '1997-01-01'),
  (22, 45385675, 'Teo', 'Hildt', '1990-02-21'),
  (23, 41872676, 'Facundo Ariel', 'Janusa', '2001-10-21'),
  (24, 45048950, 'Facundo Martin', 'Jara', '2000-05-04'),
  (25, 45387761, 'Santiago Nicolas', 'Martinez Bender', '1999-09-19'),
  (26, 45741185, 'Pablo Federico', 'Martinez', '1995-08-14'),
  (27, 44981059, 'Federico Jose', 'Martinolich', '1999-04-22'),
  (28, 42070085, 'Maria Pia', 'Melgarejo', '1994-05-06'),
  (29, 43631710, 'Thiago Jeremias', 'Meseguer', '1996-12-21'),
  (30, 44644523, 'Ignacio Agustin', 'Piter', '1992-06-05'),
  (31, 44282007, 'Bianca Ariana', 'Quiroga', '1991-06-08'),
  (32, 40018598, 'Kevin Gustavo', 'Quiroga', '1997-02-20'),
  (33, 38570361, 'Marcos', 'Reynoso', '1993-03-02'),
  (34, 39255959, 'Franco Antonio', 'Robles', '1998-04-21'),
  (35, 43414566, 'Maximiliano', 'Weyler', '1995-05-20');

-- Volcando estructura para tabla sistema.asistencias
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dni_alumno` int(10) NOT NULL,
  `fecha` timestamp NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_dni_fecha` (`dni_alumno`,`fecha`),
  KEY `fkdni` (`dni_alumno`),
  CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`dni_alumno`) REFERENCES `alumnos` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Volcando estructura para tabla sistema.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `dias_clases` int(3) DEFAULT NULL,
  `promocion` int(3) DEFAULT NULL,
  `regular` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Volcando datos para la tabla sistema.parametros: ~1 rows (aproximadamente)
INSERT INTO `parametros` (`dias_clases`, `promocion`, `regular`) VALUES
	(89, 60, 80);

-- Volcando estructura para tabla sistema.profesores
CREATE TABLE IF NOT EXISTS `profesores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dni` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `nacimiento` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `dni_profesor` (`dni`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Volcando datos para la tabla sistema.profesores: ~1 rows (aproximadamente)
INSERT INTO `profesores` (`id`, `dni`, `nombre`, `apellido`, `nacimiento`) VALUES
	(3, 18750223, 'Javier', 'Parra', '1979-10-21');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
