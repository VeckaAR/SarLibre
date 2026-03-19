-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2016 a las 10:41:17
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `idalumno` int(11) NOT NULL,
  `carnet` varchar(8) NOT NULL DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT '0',
  `horas` int(11) NOT NULL DEFAULT '0',
  `nombres` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupacion`
--

CREATE TABLE `ocupacion` (
  `id_ocupa` int(11) NOT NULL,
  `carnet` varchar(8) NOT NULL,
  `sala` int(11) NOT NULL,
  `hora_entrada` datetime NOT NULL,
  `hora_salida` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ocupacion`
--

INSERT INTO `ocupacion` (`id_ocupa`, `carnet`, `sala`, `hora_entrada`, `hora_salida`) VALUES
(6, 'PP121165', 5, '2016-07-01 09:10:36', '2016-07-10 10:00:00'),
(7, 'CC123456', 4, '2016-07-01 08:13:14', '2016-07-01 15:18:10'),
(8, 'BB123456', 5, '2016-07-01 07:33:09', '2016-07-01 09:08:07'),
(9, 'SC050158', 1, '2016-07-01 07:31:12', '2016-07-01 13:14:16'),
(10, 'YU123456', 5, '2016-07-01 06:17:13', '2016-07-01 11:14:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `idreserva` int(11) NOT NULL,
  `idalumno` varchar(8) NOT NULL DEFAULT '0',
  `hora_entra` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hora_salida` datetime DEFAULT NULL,
  `idsala` int(11) NOT NULL DEFAULT '0',
  `ciclo` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`idreserva`, `idalumno`, `hora_entra`, `hora_salida`, `idsala`, `ciclo`) VALUES
(58, 'PP121165', '2016-07-13 17:16:27', '2016-07-13 17:17:38', 7, '02 2016'),
(59, 'PP121165', '2016-07-13 17:18:14', '2016-07-19 10:17:03', 7, '02 2016'),
(60, 'AM130118', '2016-07-14 09:37:48', '2016-07-14 09:38:54', 7, '02 2016'),
(61, 'AM130118', '2016-07-14 09:39:16', '2016-07-14 09:39:52', 7, '02 2016'),
(62, 'AM130118', '2016-07-14 09:40:06', '2016-07-14 09:40:49', 7, '02 2016'),
(63, 'AM130118', '2016-07-14 09:41:01', '2016-07-14 09:41:11', 2, '02 2016'),
(64, 'AM130118', '2016-07-14 09:41:54', '2016-07-14 09:42:26', 2, '02 2016'),
(65, 'AM130118', '2016-07-14 09:42:51', '2016-07-14 09:43:16', 2, '02 2016'),
(66, 'AM130118', '2016-07-14 09:45:45', '2016-07-14 09:47:54', 1, '02 2016'),
(67, 'AM130118', '2016-07-19 09:15:14', '2016-07-19 09:15:21', 1, '02 2016'),
(68, 'AM130118', '2016-07-19 09:15:55', '2016-07-19 09:16:02', 1, '02 2016'),
(69, 'AM130118', '2016-07-19 09:16:44', '2016-07-19 09:16:52', 1, '02 2016'),
(70, 'AM130118', '2016-07-19 09:19:00', '2016-07-19 09:19:13', 1, '02 2016'),
(71, 'AM130118', '2016-07-19 09:20:38', '2016-07-19 09:20:43', 1, '02 2016'),
(72, 'AM130118', '2016-07-19 09:22:08', '2016-07-19 09:22:17', 1, '02 2016'),
(73, 'AM130118', '2016-07-19 10:21:32', '2016-07-19 10:21:37', 1, '02 2016'),
(74, 'AM130118', '2016-07-19 10:22:28', '2016-07-19 10:25:58', 1, '02 2016'),
(75, 'MM020754', '2016-07-19 10:23:42', '2016-07-19 10:25:58', 2, '02 2016'),
(76, 'GB132402', '2016-07-19 10:24:15', '2016-07-19 10:25:58', 5, '02 2016'),
(77, 'MM020754', '2016-07-19 10:26:57', '2016-07-19 10:27:03', 1, '02 2016');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `idsala` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL DEFAULT '0',
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`idsala`, `capacidad`, `estado`) VALUES
(1, 19, 'A'),
(2, 19, 'A'),
(3, 23, 'A'),
(4, 19, 'A'),
(5, 2, 'A'),
(6, 19, 'A'),
(7, 19, 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`idalumno`);

--
-- Indices de la tabla `ocupacion`
--
ALTER TABLE `ocupacion`
  ADD PRIMARY KEY (`id_ocupa`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`idreserva`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`idsala`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `idalumno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ocupacion`
--
ALTER TABLE `ocupacion`
  MODIFY `id_ocupa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `idreserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `idsala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
