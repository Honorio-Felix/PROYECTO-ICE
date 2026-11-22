-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2026 a las 22:22:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ice_comercio_exterior`
--
CREATE DATABASE IF NOT EXISTS `ice_comercio_exterior` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ice_comercio_exterior`;
SET FOREIGN_KEY_CHECKS=0;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_registrar_solicitud`$$
CREATE PROCEDURE `sp_registrar_solicitud` (IN `p_id_prospecto` INT, IN `p_id_programa` INT, IN `p_mensaje` TEXT)   INSERT INTO solicitudes (id_prospecto, id_programa, mensaje)
VALUES (p_id_prospecto, p_id_programa, p_mensaje)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `uq_categorias_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Comercio Exterior', 'Programas de importacion y exportacion.'),
(2, 'Gestion Aduanera', 'Programas de normativa y despacho aduanero.'),
(3, 'Almacenes y Distribucion', 'Programas de almacenamiento e inventarios.'),
(4, 'Cadena de Suministro', 'Programas de logistica integral y operaciones portuarias.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE IF NOT EXISTS `docentes` (
  `id_docente` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `especialidad` varchar(150) NOT NULL,
  `perfil_profesional` text DEFAULT NULL,
  PRIMARY KEY (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id_docente`, `nombres`, `apellidos`, `especialidad`, `perfil_profesional`) VALUES
(1, 'Carlos', 'Ramirez Torres', 'Operaciones de importacion y exportacion', 'Profesional enfocado en operaciones de comercio exterior, documentacion de importaciones y exportaciones, coordinacion logistica y seguimiento de procesos comerciales internacionales. Cuenta con conocimientos sobre procedimientos operativos y gestion documental.'),
(2, 'Maria', 'Fernandez Lopez', 'Gestion aduanera y despacho', 'Profesional orientada a la gestion aduanera, revision de documentacion y procedimientos de despacho. Maneja conceptos relacionados con clasificacion arancelaria, normativa aduanera y coordinacion de operaciones de importacion y exportacion.'),
(3, 'Jorge', 'Salazar Rios', 'Gestion de almacenes e inventarios', 'Profesional especializado en procesos de almacenamiento, control de inventarios y organizacion de operaciones logisticas. Tiene conocimientos sobre recepcion, ubicacion, preparacion de pedidos y seguimiento de existencias.'),
(4, 'Ana', 'Castillo Mendoza', 'Supply Chain y operaciones portuarias', 'Profesional orientada a la gestion de la cadena de suministro, coordinacion de operaciones logisticas y procesos portuarios. Maneja conceptos de planificacion de operaciones, distribucion de mercancias y coordinacion de actividades de transporte.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

DROP TABLE IF EXISTS `matriculas`;
CREATE TABLE IF NOT EXISTS `matriculas` (
  `id_matricula` int(11) NOT NULL AUTO_INCREMENT,
  `id_prospecto` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `fecha_matricula` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(30) NOT NULL DEFAULT 'Registrada',
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id_matricula`),
  KEY `fk_matriculas_prospectos` (`id_prospecto`),
  KEY `fk_matriculas_programas` (`id_programa`),
  KEY `idx_matriculas_fecha` (`fecha_matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`id_matricula`, `id_prospecto`, `id_programa`, `fecha_matricula`, `estado`, `observaciones`) VALUES
(1, 1, 1, '2026-11-01 16:07:24', 'Registrada', 'Matricula de prueba.'),
(2, 2, 2, '2026-11-01 16:07:24', 'Pendiente', 'Documentacion pendiente de completar.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidades`
--

DROP TABLE IF EXISTS `modalidades`;
CREATE TABLE IF NOT EXISTS `modalidades` (
  `id_modalidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_modalidad`),
  UNIQUE KEY `uq_modalidades_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modalidades`
--

INSERT INTO `modalidades` (`id_modalidad`, `nombre`, `descripcion`) VALUES
(1, 'Virtual', 'Clases mediante plataformas digitales.'),
(2, 'Semipresencial', 'Combina clases virtuales y actividades presenciales.'),
(3, 'Presencial', 'Clases en las instalaciones de la institucion.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_programa`
--

DROP TABLE IF EXISTS `modulos_programa`;
CREATE TABLE IF NOT EXISTS `modulos_programa` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `id_programa` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `horas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_modulo`),
  UNIQUE KEY `uq_modulo_orden` (`id_programa`,`orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modulos_programa`
--

INSERT INTO `modulos_programa` (`id_modulo`, `id_programa`, `nombre`, `descripcion`, `orden`, `horas`) VALUES
(1, 1, 'Fundamentos del Comercio Exterior', 'Conceptos generales de comercio internacional.', 1, 10),
(2, 1, 'Gestion de Importaciones y Exportaciones', 'Procesos y documentacion de operaciones.', 2, 15),
(3, 1, 'Logistica y Documentacion Internacional', 'Coordinacion logistica y documentos de comercio exterior.', 3, 15),
(4, 2, 'Normativa Aduanera', 'Marco normativo y procedimientos aduaneros.', 1, 20),
(5, 2, 'Clasificacion Arancelaria', 'Criterios de clasificacion de mercancias.', 2, 20),
(6, 2, 'Valoracion y Despacho Aduanero', 'Procedimientos de valoracion y despacho de mercancias.', 3, 40),
(7, 3, 'Control de Inventarios', 'Metodos de control y gestion de existencias.', 1, 15),
(8, 3, 'Gestion de Almacenamiento', 'Recepcion, ubicacion y preparacion de pedidos.', 2, 20),
(9, 4, 'Gestion de la Cadena de Suministro', 'Procesos de la cadena logistica internacional.', 1, 20),
(10, 4, 'Operaciones Portuarias y Transporte', 'Coordinacion de operaciones portuarias y transporte.', 2, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

DROP TABLE IF EXISTS `programas`;
CREATE TABLE IF NOT EXISTS `programas` (
  `id_programa` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `id_modalidad` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion_horas` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `brochure` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_programa`),
  UNIQUE KEY `uq_programas_nombre` (`nombre`),
  KEY `fk_programas_categorias` (`id_categoria`),
  KEY `fk_programas_modalidades` (`id_modalidad`),
  KEY `fk_programas_docentes` (`id_docente`),
  KEY `idx_programas_fecha_inicio` (`fecha_inicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id_programa`, `id_categoria`, `id_modalidad`, `id_docente`, `nombre`, `descripcion`, `duracion_horas`, `fecha_inicio`, `brochure`) VALUES
(1, 1, 1, 1, 'Operaciones de Importacion y Exportacion', 'Aprende a nacionalizar mercancias y gestionar envios internacionales.', 40, '2026-12-01', 'brochure-import-export.pdf'),
(2, 2, 2, 2, 'Gestion Aduanera y Despacho', 'Especializacion en valoracion aduanera, clasificacion arancelaria y despacho.', 80, '2026-12-10', 'brochure-aduanas.pdf'),
(3, 3, 1, 3, 'Gestion de Almacenes y Control de Inventarios', 'Tecnicas de almacenamiento, control de stock y optimizacion de almacenes.', 35, '2026-12-15', 'brochure-almacenes.pdf'),
(4, 4, 3, 4, 'Supply Chain Management y Operaciones Portuarias', 'Formacion en logistica global, transporte multimodal y operaciones portuarias.', 60, '2027-01-10', 'brochure-supply-chain.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prospectos`
--

DROP TABLE IF EXISTS `prospectos`;
CREATE TABLE IF NOT EXISTS `prospectos` (
  `id_prospecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombres_apellidos` varchar(150) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  PRIMARY KEY (`id_prospecto`),
  UNIQUE KEY `uq_prospectos_correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prospectos`
--

INSERT INTO `prospectos` (`id_prospecto`, `nombres_apellidos`, `correo`, `telefono`, `perfil`) VALUES
(1, 'Luis Alberto Perez', 'luis.perez@example.com', '987654321', 'Estudiante'),
(2, 'Carla Mendoza Ruiz', 'carla.mendoza@example.com', '986123456', 'Operador'),
(3, 'Jose Ramirez Soto', 'jose.ramirez@example.com', '985456123', 'Emprendedor'),
(4, 'Andrea Torres Diaz', 'andrea.torres@example.com', '984321654', 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
CREATE TABLE IF NOT EXISTS `solicitudes` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `id_prospecto` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(30) NOT NULL DEFAULT 'Pendiente',
  PRIMARY KEY (`id_solicitud`),
  KEY `fk_solicitudes_prospectos` (`id_prospecto`),
  KEY `fk_solicitudes_programas` (`id_programa`),
  KEY `idx_solicitudes_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `id_prospecto`, `id_programa`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
(1, 1, 1, 'Deseo conocer los requisitos para inscribirme.', '2026-11-01 16:07:24', 'Pendiente'),
(2, 2, 2, 'Solicito informacion sobre el contenido del programa.', '2026-11-01 16:07:24', 'Atendida'),
(3, 3, 3, 'Quisiera recibir informacion sobre proximas fechas.', '2026-11-01 16:07:24', 'Pendiente'),
(4, 4, 4, 'Deseo conocer los horarios de las clases.', '2026-11-01 16:07:24', 'Pendiente'),
(5, 1, 2, 'Tambien estoy interesado en Gestion Aduanera.', '2026-11-01 16:07:24', 'Pendiente');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `fk_matriculas_programas` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `fk_matriculas_prospectos` FOREIGN KEY (`id_prospecto`) REFERENCES `prospectos` (`id_prospecto`);

--
-- Filtros para la tabla `modulos_programa`
--
ALTER TABLE `modulos_programa`
  ADD CONSTRAINT `fk_modulos_programas` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `fk_programas_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `fk_programas_docentes` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id_docente`),
  ADD CONSTRAINT `fk_programas_modalidades` FOREIGN KEY (`id_modalidad`) REFERENCES `modalidades` (`id_modalidad`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `fk_solicitudes_programas` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `fk_solicitudes_prospectos` FOREIGN KEY (`id_prospecto`) REFERENCES `prospectos` (`id_prospecto`);
SET FOREIGN_KEY_CHECKS=1;

--
-- Restricciones CHECK del modelo
--

ALTER TABLE `programas`
  ADD CONSTRAINT `chk_programas_duracion`
  CHECK (`duracion_horas` > 0);

ALTER TABLE `modulos_programa`
  ADD CONSTRAINT `chk_modulos_orden`
  CHECK (`orden` > 0);

ALTER TABLE `modulos_programa`
  ADD CONSTRAINT `chk_modulos_horas`
  CHECK (`horas` IS NULL OR `horas` > 0);

ALTER TABLE `solicitudes`
  ADD CONSTRAINT `chk_solicitudes_estado`
  CHECK (`estado` IN ('Pendiente', 'Atendida'));

ALTER TABLE `matriculas`
  ADD CONSTRAINT `chk_matriculas_estado`
  CHECK (`estado` IN ('Registrada', 'Pendiente'));

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
