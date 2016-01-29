-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-01-2016 a las 08:26:44
-- Versión del servidor: 5.5.45-cll-lve
-- Versión de PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `controlm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_movimiento`
--

CREATE TABLE IF NOT EXISTS `detalle_movimiento` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `id_movimiento` int(12) NOT NULL,
  `id_elemento` int(12) NOT NULL,
  `cantidad` double NOT NULL,
  `pendiente` double NOT NULL,
  `tipo` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `ticket` int(12) NOT NULL,
  `factura` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `catalogo` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `valor` double NOT NULL,
  `observaciones` longtext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_movimiento` (`id_movimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `detalle_movimiento`
--

INSERT INTO `detalle_movimiento` (`id`, `id_movimiento`, `id_elemento`, `cantidad`, `pendiente`, `tipo`, `estado`, `ticket`, `factura`, `catalogo`, `valor`, `observaciones`) VALUES
(1, 1, 3298, 2, 1, 'REPUESTO', 'ACTIVO', 0, '', 'Bodega', 45000, ''),
(2, 1, 3296, 2, 2, 'REPUESTO', 'ACTIVO', 0, '', 'Bodega', 43000, ''),
(3, 2, 3298, 1, 0, 'REPUESTO', 'ACTIVO', 60734, '12345', 'Bodega', 45000, ''),
(4, 2, 3298, 1, 0, 'REPUESTO', 'ACTIVO', 12345, '0', 'Bodega', 45000, ''),
(5, 3, 5013, 20, 20, 'INSUMO', 'ACTIVO', 0, '', 'Bodega', 100, ''),
(6, 3, 5240, 2, 1, '', 'ACTIVO', 0, '', 'Bodega', 200000, ''),
(7, 4, 5013, 10, 0, 'INSUMO', 'ACTIVO', 75236, '12345', 'Bodega', 100, ''),
(8, 4, 5240, 1, 0, '', 'ACTIVO', 75236, '', 'Bodega', 200000, ''),
(9, 5, 5240, 2, 2, '', 'ACTIVO', 0, '', 'Bodega', 0, ''),
(10, 5, 5349, 20, 20, '', 'ACTIVO', 0, '', 'Bodega', 363165, ''),
(11, 5, 3775, 30, 30, 'REPUESTO', 'ACTIVO', 0, '', 'Bodega', 100000, ''),
(12, 6, 5013, 20, 20, 'INSUMO', 'ACTIVO', 0, '', 'Bodega', 2000, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE IF NOT EXISTS `kardex` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `fecha_movimiento` date NOT NULL,
  `id_detalle_mov` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `id_detalle` int(12) NOT NULL,
  `cantidad_anterior` double NOT NULL,
  `cantidad_actual` double NOT NULL,
  `tipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_detalle` (`id_detalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `kardex`
--

INSERT INTO `kardex` (`id`, `fecha_movimiento`, `id_detalle_mov`, `id_detalle`, `cantidad_anterior`, `cantidad_actual`, `tipo`) VALUES
(1, '2016-01-27', '0', 1, 0, 2, ''),
(2, '2016-01-27', '0', 2, 0, 2, ''),
(3, '2016-01-27', '1', 3, 0, 1, 'Compra Sitio'),
(4, '2016-01-27', '1', 4, 2, 1, 'Legalización Bodega'),
(5, '2016-01-27', '0', 5, 0, 20, ''),
(6, '2016-01-27', '0', 6, 0, 2, ''),
(7, '2016-01-27', '5', 7, 0, 10, 'Compra Sitio'),
(8, '2016-01-27', '6', 8, 2, 1, 'Legalización Bodega'),
(9, '2016-01-28', '0', 9, 0, 2, ''),
(10, '2016-01-28', '0', 10, 0, 20, ''),
(11, '2016-01-28', '0', 11, 0, 30, ''),
(12, '2016-01-28', '0', 12, 0, 20, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `fecha_movimiento` date NOT NULL,
  `tipo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `quien_entrega` int(12) NOT NULL,
  `quien_recibe` int(12) NOT NULL,
  `estado` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `requisicion` int(12) NOT NULL,
  `usuario` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `fecha_movimiento`, `tipo`, `quien_entrega`, `quien_recibe`, `estado`, `requisicion`, `usuario`) VALUES
(1, '2016-01-27', 'Salida', 1073238640, 80071860, 'Terminado', 1569, 3),
(2, '2016-01-27', 'Entrada', 80071860, 1073238640, 'Terminado', 0, 3),
(3, '2016-01-27', 'Salida', 1070958781, 1055272950, 'Terminado', 0, 3),
(4, '2016-01-27', 'Entrada', 1055272950, 1070958781, 'Terminado', 0, 3),
(5, '2016-01-28', 'Salida', 1070958781, 80071860, 'Terminado', 13, 4),
(6, '2016-01-28', 'Salida', 0, 80071860, 'Terminado', 0, 4),
(7, '2016-01-28', 'Entrada', 80071860, 0, 'Terminado', 0, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email`, `contrasena`) VALUES
(3, 'David Cubides', 'dcubides@nesitelco.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(4, 'Jorge Buitrago', 'jbuitrago@nesitelco.com', 'e10adc3949ba59abbe56e057f20f883e');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
