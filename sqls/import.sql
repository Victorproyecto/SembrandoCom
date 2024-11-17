CREATE TABLE `actividades` (
                               `id` int(11) NOT NULL,
                               `nombre` varchar(100) NOT NULL,
                               `descripcion` text DEFAULT NULL,
                               `direccion` varchar(255) NOT NULL,
                               `id_municipio` int(11) DEFAULT NULL,
                               `id_cooperativa` int(11) NOT NULL,
                               `id_huerto` int(11) DEFAULT NULL,
                               `fecha` date NOT NULL,
                               `es_premium` tinyint(1) DEFAULT 0,
                               `aforo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cooperativas`
--

CREATE TABLE `cooperativas` (
                                `id` int(11) NOT NULL,
                                `nombre` varchar(100) NOT NULL,
                                `direccion` varchar(255) NOT NULL,
                                `id_usuario` int(11) NOT NULL,
                                `descripcion` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huertos`
--

CREATE TABLE `huertos` (
                           `id` int(11) NOT NULL,
                           `nombre` varchar(100) NOT NULL,
                           `direccion` varchar(255) NOT NULL,
                           `id_municipio` int(11) DEFAULT NULL,
                           `id_cooperativa` int(11) DEFAULT NULL,
                           `aforo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
                            `id` int(11) NOT NULL,
                            `nombre` varchar(50) NOT NULL,
                            `fecha_nacimiento` date NOT NULL,
                            `correo_electronico` varchar(100) NOT NULL,
                            `es_premium` tinyint(1) DEFAULT 0,
                            `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_actividad`
--

CREATE TABLE `usuarios_actividad` (
                                      `id` int(11) NOT NULL,
                                      `id_usuario` int(11) NOT NULL,
                                      `id_actividad` int(11) NOT NULL,
                                      `fecha_inscripcion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
    ADD PRIMARY KEY (`id`),
  ADD KEY `id_cooperativa` (`id_cooperativa`),
  ADD KEY `id_huerto` (`id_huerto`);

--
-- Indices de la tabla `cooperativas`
--
ALTER TABLE `cooperativas`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_id` (`id_usuario`);

--
-- Indices de la tabla `huertos`
--
ALTER TABLE `huertos`
    ADD PRIMARY KEY (`id`),
  ADD KEY `id_cooperativa` (`id_cooperativa`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`);

--
-- Indices de la tabla `usuarios_actividad`
--
ALTER TABLE `usuarios_actividad`
    ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_actividad_ibfk_1` (`id_usuario`),
  ADD KEY `usuarios_actividad_ibfk_2` (`id_actividad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cooperativas`
--
ALTER TABLE `cooperativas`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `huertos`
--
ALTER TABLE `huertos`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_actividad`
--
ALTER TABLE `usuarios_actividad`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
    ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_cooperativa`) REFERENCES `cooperativas` (`id`),
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`id_huerto`) REFERENCES `huertos` (`id`);

--
-- Filtros para la tabla `huertos`
--
ALTER TABLE `huertos`
    ADD CONSTRAINT `huertos_ibfk_1` FOREIGN KEY (`id_cooperativa`) REFERENCES `cooperativas` (`id`);

--
-- Filtros para la tabla `usuarios_actividad`
--
ALTER TABLE `usuarios_actividad`
    ADD CONSTRAINT `usuarios_actividad_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_actividad_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`) ON DELETE CASCADE;