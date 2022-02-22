-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-02-2022 a las 09:25:43
-- Versión del servidor: 5.7.36-log-cll-lve
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inomacmx_pruebas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `id_sector` int(11) NOT NULL,
  `id_variedad` int(11) DEFAULT NULL,
  `nombre` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hectareas` float(10,5) DEFAULT NULL,
  `num_subrancho` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sector`
--

INSERT INTO `sector` (`id_sector`, `id_variedad`, `nombre`, `status`, `hectareas`, `num_subrancho`) VALUES
(1, 5, 'A1', 'Activo', 0.50000, 1),
(2, 5, 'B1', 'Activo', 0.58300, 1),
(3, 5, 'C1', 'Activo', 0.58500, 1),
(4, 4, 'D1', 'Activo', 0.58600, 1),
(5, 4, 'E1', 'Activo', 0.59800, 1),
(6, 4, 'F1', 'Activo', 0.59700, 1),
(7, 3, 'G1', 'Activo', 0.60000, 1),
(8, 2, 'H1', 'Activo', 0.59700, 1),
(9, 7, 'I1', 'Activo', 0.60000, 1),
(10, 8, 'J1', 'Activo', 0.61800, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id_sector`),
  ADD KEY `id_variedad` (`id_variedad`),
  ADD KEY `num_subrancho` (`num_subrancho`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sector`
--
ALTER TABLE `sector`
  ADD CONSTRAINT `sector_ibfk_1` FOREIGN KEY (`id_variedad`) REFERENCES `variedad` (`id_variedad`),
  ADD CONSTRAINT `sector_ibfk_2` FOREIGN KEY (`num_subrancho`) REFERENCES `subrancho` (`num_subrancho`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
