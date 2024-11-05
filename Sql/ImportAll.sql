-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-11-2024 a las 10:52:07
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `SembrandoCom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(1) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `cooperativa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `lugar`, `cooperativa`) VALUES
(3, 'Plantar tomates', 'Huerta Carrasco', 'Lovegreen'),
(4, 'Recogida libros', 'Huerta Plaza españa', 'WeAreMadrid'),
(5, 'Tarde de teatro', 'Huerto SanJose', 'PalacioVerde'),
(6, 'Revision de olivos', 'Huerto Felicdiad', 'Abuelitas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_usuarios`
--

CREATE TABLE `actividades_usuarios` (
  `id_actividad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ﬁfam
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nom_usuario` varchar(25) DEFAULT NULL,
  `ape_usuario` varchar(100) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tipo_usuario` enum('registrado','no_registrado','superadministrador') NOT NULL DEFAULT 'registrado',
  `fecha_nacimiento` date DEFAULT NULL,
  `imagen_perfil` varchar(255) DEFAULT NULL,
  `is_admin` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nom_usuario`, `ape_usuario`, `email`, `pass`, `tipo_usuario`, `fecha_nacimiento`, `imagen_perfil`, `is_admin`) VALUES
(69, 'Albert', 'Castro Albacete', 'albertus1291@gmail.com', '$2y$10$0VTh0Gz.KFfAgF5DqQLUFe6Nx8dstWZl3NR3EQnHaK76kgkyuRiQO', 'registrado', '1991-02-01', '../vista/img/profile_images/666c15f7b7704.png', NULL),
(73, 'Juan', 'Dalmau Quesada', 'JuanDQ@gmail.com', '$2y$10$TSm4.Zi5s71OlVmi29krOuTg9eq/vmm1/f8MQQ15HqoYVLRZn7C7y', 'registrado', '2024-06-14', '../vista/img/profile_images/666c2b57cc1c6.png', NULL),
(74, 'Juan', 'Quesada Martinez', 'juanqm@gmail.com', '$2y$10$SRMjGbjDrFiEZTP9pq5a0u7.ur2SQO01dD7t8DOkRfzW8VaJQJpTu', 'registrado', '2024-06-14', '../vista/img/profile_images/666c601f13cb5.png', NULL),
(75, 'Bertus', NULL, 'bertus@gmail.com', '$2y$10$fX.h7HMfCytKzQa60fh//ewxKhrvV1678NW5niSOTzgCHMEkDCiQ6', 'registrado', '1991-02-01', '../vista/img/profile_images/profile_default.png', NULL),
(76, 'lil', 'martinez hinojos', 'lil@gmail.com', '$2y$10$Y72a9hnBEgxzrZN4Z9Gw7edZoalf7BtzvCinSXjH4xqPB72cC2HFG', 'registrado', '1994-03-02', '../vista/img/profile_images/672129025db08.png', NULL),
(77, 'Victor', NULL, 'vicmarhin@gmail.com', '$2y$10$DENs94yUAIzZ1DRsqvxJ0.ZZZXPIXY.2MWLZIWbKWd6YH86ixWvsu', 'registrado', '1995-03-02', '../vista/img/profile_images/profile_default.png', NULL),
(78, 'Victor', NULL, 'vicmargdb@gmail.com', '$2y$10$qpE3sVUka07R2IP8G79J7uzExf1iPSGXbokP6s7.bN6HRH/y0.biu', 'registrado', '1995-01-05', '../vista/img/profile_images/profile_default.png', NULL),
(80, 'ikgjgjg', NULL, 'i3riij@gmail.com', '$2y$10$K2m.qt8C6A3SJZuLDKjPkunpJmdwLG2ob89jmpsF07XGKmAxBnHj2', 'registrado', '1994-05-02', '../vista/img/profile_images/profile_default.png', NULL),
(111, 'Victorinoo', NULL, '22vict3ori2n22o@gmail.com', '$2y$10$7s.tJs2fbLRYx26YajmPBezRbl27iphjoanOcBTFWZIt0gXN8LML2', 'registrado', '1997-03-02', '../vista/img/profile_images/profile_default.png', 1),
(112, 'Victorinoo', NULL, '22vict3233orfi2n22eo@gmail.com', '$2y$10$BY3fhdim2UCQOUFD.Y/rg.bSpxJJqWqVAAVixD7WzNQhdLhQRmO/q', 'registrado', '1997-03-02', '../vista/img/profile_images/profile_default.png', 1),
(113, 'alvictor', NULL, 'alvictor@gmail.com', '$2y$10$vIiGuBYd39R1asA0x7NBKuZqimNZfVaCj7rAFiXxNRz6aXuCXXQUW', 'registrado', '1994-03-02', '../vista/img/profile_images/profile_default.png', 1),
(114, 'Victor mar', NULL, 'vicmar@gmail.com', '$2y$10$ri3XkSfCAo7Ftv2MAyKWauU1uKZSZ3WzpMXW.bvS3DLzEdPwqWH2.', 'registrado', '1995-04-02', '../vista/img/profile_images/profile_default.png', 1),
(115, '1234', NULL, 'vicmar@hotmail.com', '$2y$10$WgPkVTOuU9jB33lkeKXtcOZBWWbXopV6eTATWrFdxd5/hxG7c5zo6', 'registrado', '1995-04-02', '../vista/img/profile_images/profile_default.png', 1),
(117, 'jose maria', NULL, 'vicmarin@gmail.com', '$2y$10$BEKGcOiO1MXnhCi/Lv4xCeuEWxjnqrIJEpCB4Lop9loJZ/3jSN7je', 'registrado', '1994-03-02', '../vista/img/profile_images/profile_default.png', 1),
(118, 'jose', NULL, 'eljose@gmail.com', '$2y$10$3hjshAgn2answCFl951KWeGorAmN6j1Hr0LOLx4T9DrKduw9SV8DK', 'registrado', '1995-04-02', '../vista/img/profile_images/profile_default.png', 1),
(120, '1234', NULL, 'vicmarinn@gmail.com', '$2y$10$5rTPrZ6gtvBI7gtkwEcGR.aZF5VxVEISwoYldCI8b9DN9sRG4QGLq', 'registrado', '1994-03-02', '../vista/img/profile_images/profile_default.png', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividades_usuarios`
--
ALTER TABLE `actividades_usuarios`
  ADD KEY `actividad_id` (`id_actividad`),
  ADD KEY `usuario_id` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pass` (`pass`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades_usuarios`
--
ALTER TABLE `actividades_usuarios`
  ADD CONSTRAINT `actividad_id` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`),
  ADD CONSTRAINT `usuario_id` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
