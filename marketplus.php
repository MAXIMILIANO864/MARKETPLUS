-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2025 a las 18:40:36
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
-- Base de datos: `marketplus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`) VALUES
(1, 'Luis', 'Cordero'),
(2, 'María', 'Gomez'),
(3, 'Santiago', 'Perez'),
(4, 'Lucía', 'Álvarez'),
(5, 'Matías', 'Rivas'),
(6, 'Julián', 'Fernández'),
(7, 'Sofía', 'Benítez'),
(8, 'Ana', 'Mamani'),
(9, 'Carlos', 'Villalba'),
(10, 'Pedro', 'Torres'),
(11, 'Gabriela', 'López'),
(12, 'Fernando', 'Quiroga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_gerente` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `sucursal` varchar(100) DEFAULT 'Centro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_gerente`, `nombre`, `apellido`, `email`, `cargo`, `sucursal`) VALUES
(1, NULL, 'Gerente Juan', NULL, 'admin@marketplus.com', NULL, 'Centro'),
(2, 1, 'Marcos', NULL, 'marcos@marketplus.com', NULL, 'Centro'),
(3, 1, 'Laura', NULL, 'laura@marketplus.com', NULL, 'Centro'),
(4, 1, 'Pedro', NULL, 'pedro@marketplus.com', NULL, 'Centro'),
(5, 1, 'Romina', NULL, 'romina@marketplus.com', NULL, 'Centro'),
(6, 1, 'Elías', NULL, 'elias@marketplus.com', NULL, 'Centro'),
(7, 1, 'Camila', NULL, 'camila@marketplus.com', NULL, 'Centro'),
(8, 1, 'Martín', NULL, 'martin@marketplus.com', NULL, 'Centro'),
(9, 1, 'Agustina', NULL, 'agustina@marketplus.com', NULL, 'Centro'),
(10, 1, 'Daniel', NULL, 'daniel@marketplus.com', NULL, 'Centro'),
(11, 1, 'Valeria', NULL, 'valeria@marketplus.com', NULL, 'Centro'),
(12, 1, 'Lucas', NULL, 'lucas@marketplus.com', NULL, 'Centro'),
(16, NULL, 'ernesto', 'romero', '1@1.1', 'Empleado', 'Centro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numero_venta`
--

CREATE TABLE `numero_venta` (
  `id_numero_venta` int(11) NOT NULL,
  `id_empleados` int(11) DEFAULT NULL,
  `id_clientes` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `numero_venta`
--

INSERT INTO `numero_venta` (`id_numero_venta`, `id_empleados`, `id_clientes`, `fecha`) VALUES
(1, 1, 1, '2025-01-01'),
(2, 2, 2, '2025-01-02'),
(3, 3, 3, '2025-01-03'),
(4, 4, 4, '2025-01-04'),
(5, 5, 5, '2025-01-05'),
(6, 6, 6, '2025-01-06'),
(7, 7, 7, '2025-01-07'),
(8, 8, 8, '2025-01-08'),
(9, 9, 9, '2025-01-09'),
(10, 10, 10, '2025-01-10'),
(11, 11, 11, '2025-01-11'),
(12, 12, 12, '2025-01-12'),
(14, 12, 2, '2025-11-17'),
(15, 12, 6, '2025-11-17'),
(16, 12, 9, '2025-11-17'),
(17, 16, 3, '2025-11-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `id_producto`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 5),
(4, 4, 2),
(5, 5, 7),
(6, 6, 8),
(7, 7, 4),
(8, 8, 6),
(9, 9, 10),
(10, 10, 11),
(11, 11, 12),
(12, 12, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `sucursal` varchar(100) DEFAULT 'Centro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `descripcion`, `precio`, `stock`, `sucursal`) VALUES
(1, 'Gaseosa Coca-Cola 500ml', 950, 5, 'Centro'),
(2, 'Gaseosa Pepsi 500ml', 900, 6, 'Centro'),
(3, 'Agua Mineral 500ml', 600, 8, 'Centro'),
(4, 'Jugo Baggio 1L', 1200, 12, 'Centro'),
(5, 'Chocolate Milka Oreo', 1500, 8, 'Centro'),
(6, 'Caramelos Sugus x10', 300, 2147483647, 'Centro'),
(7, 'Galletitas Oreo', 1100, 12, 'Centro'),
(8, 'Galletitas Pepitos', 1050, 10, 'Centro'),
(9, 'Papas Lays', 1300, 11, 'Centro'),
(10, 'Chicles Topline', 450, 14, 'Centro'),
(11, 'Alfajor Jorgito', 650, 8, 'Centro'),
(12, 'Cerveza Quilmes 1L', 1700, 12, 'Centro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes_guardados`
--

CREATE TABLE `reportes_guardados` (
  `id_reporte` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_generacion` datetime DEFAULT current_timestamp(),
  `total_ventas` decimal(10,2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mejor_cliente` varchar(150) DEFAULT 'N/A',
  `mejor_empleado` varchar(150) DEFAULT 'N/A',
  `producto_estrella` varchar(150) DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes_guardados`
--

INSERT INTO `reportes_guardados` (`id_reporte`, `fecha_inicio`, `fecha_fin`, `fecha_generacion`, `total_ventas`, `id_usuario`, `mejor_cliente`, `mejor_empleado`, `producto_estrella`) VALUES
(2, '1111-11-11', '2025-11-17', '2025-11-17 11:34:50', 31350.00, 1, 'Sofía Benítez ($6,000)', 'Camila ($6,000)', 'Caramelos Sugus x10 (12 un.)'),
(3, '2025-11-20', '2025-12-27', '2025-11-17 11:41:13', 0.00, 1, 'N/A', 'N/A', 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contrasena`, `rol`) VALUES
(1, 'juan', 'admin@marketplus.com', '1234', 'admin'),
(2, 'Marcos', 'marcos@marketplus.com', 'abcd', 'empleado'),
(3, 'Laura', 'laura@marketplus.com', 'abcd', 'empleado'),
(4, 'Pedro', 'pedro@marketplus.com', 'abcd', 'empleado'),
(5, 'Romina', 'romina@marketplus.com', 'abcd', 'empleado'),
(6, 'Elías', 'elias@marketplus.com', 'abcd', 'empleado'),
(7, 'Camila', 'camila@marketplus.com', 'abcd', 'empleado'),
(8, 'Martín', 'martin@marketplus.com', 'abcd', 'empleado'),
(9, 'Agustina', 'agustina@marketplus.com', 'abcd', 'empleado'),
(10, 'Daniel', 'daniel@marketplus.com', 'abcd', 'empleado'),
(11, 'Valeria', 'valeria@marketplus.com', 'abcd', 'empleado'),
(12, 'Lucas', 'lucas@marketplus.com', 'abcd', 'empleado'),
(18, 'ernesto romero', '1@1.1', '1234', 'empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_producto`, `cantidad`) VALUES
(1, 1, 2),
(2, 3, 1),
(3, 5, 4),
(4, 2, 2),
(5, 7, 3),
(6, 8, 1),
(7, 4, 5),
(8, 6, 2),
(9, 10, 1),
(10, 11, 3),
(11, 12, 2),
(12, 9, 1),
(14, 6, 10),
(15, 1, 6),
(16, 2, 1),
(17, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `numero_venta`
--
ALTER TABLE `numero_venta`
  ADD PRIMARY KEY (`id_numero_venta`),
  ADD KEY `id_empleados` (`id_empleados`),
  ADD KEY `id_clientes` (`id_clientes`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `reportes_guardados`
--
ALTER TABLE `reportes_guardados`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `numero_venta`
--
ALTER TABLE `numero_venta`
  MODIFY `id_numero_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reportes_guardados`
--
ALTER TABLE `reportes_guardados`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `numero_venta`
--
ALTER TABLE `numero_venta`
  ADD CONSTRAINT `numero_venta_ibfk_1` FOREIGN KEY (`id_empleados`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `numero_venta_ibfk_2` FOREIGN KEY (`id_clientes`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `reportes_guardados`
--
ALTER TABLE `reportes_guardados`
  ADD CONSTRAINT `reportes_guardados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
