-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2018 a las 16:50:46
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `posivan`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(1, 'Equipos Para Construcción', '2018-08-13 20:38:46'),
(2, 'Equipos Electromecánicos', '2018-08-14 19:54:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `tipo_Cliente` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_Documento` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `documento` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `contacto` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `total_compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_Cliente`, `nombre`, `tipo_Documento`, `documento`, `email`, `contacto`, `direccion`, `fecha_nacimiento`, `total_compras`, `ultima_compra`, `fecha`) VALUES
(1, 'C', 'Pepito Perez', 'CE', '123456789', 'pepito@hotmail.com', '(111) 111-1111', 'Carrera 36a 75D134', '1990-12-11', 1, '2018-09-06 09:39:18', '2018-09-06 14:39:18'),
(3, 'C', 'Claudia Roldán', 'C', '21323842', 'claudiaroldan@gmail.com', '(300) 000-0000', 'Carrera 36a 75D134', '1980-02-03', 3, '2018-09-07 02:54:36', '2018-09-07 19:54:36'),
(4, 'C', 'Yesica Gallego Tobón', 'CE', 'ce15289745', 'yegato00@yahoo.es', '(454) 546-5456', 'Carrera 36a 75D134', '1998-02-02', 1, '2018-09-06 09:29:41', '2018-09-06 14:29:41'),
(5, 'P', 'Industrias Cargo', 'N', '908147541', 'inducargo@info.com', '(564) 565-4897', 'Carrera 36a 75D134', '0000-00-00', 0, '0000-00-00 00:00:00', '2018-08-31 19:43:00'),
(6, 'C', 'Luz Marina Alzate Gómez', 'C', '789456123', 'marinaa@hotmail.com', '(300) 000-0046', 'Carrera 36a 75D134', '1953-04-20', 0, '0000-00-00 00:00:00', '2018-09-09 18:08:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_recibo`
--

CREATE TABLE `detalles_recibo` (
  `id` int(11) NOT NULL,
  `num_recibo` int(11) NOT NULL,
  `pago` float NOT NULL,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalles_recibo`
--

INSERT INTO `detalles_recibo` (`id`, `num_recibo`, `pago`, `metodo_pago`, `fecha`) VALUES
(1, 1, 50000, 'T-4568974', '2018-09-07 19:54:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `iva` int(11) NOT NULL,
  `valor_Iva` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `stock`, `precio_compra`, `iva`, `valor_Iva`, `precio_venta`, `ventas`, `fecha`) VALUES
(1, 1, '118', 'Taladro Rojo', 49, 34500, 11, 3795, 40000, 1, '2018-09-05 18:40:20'),
(3, 2, '3080', 'Compresor De Aire', 85, 123000, 15, 18450, 155000, 0, '2018-09-03 18:24:32'),
(4, 1, '208', 'Aspiradora Industrial', 45, 153000, 19, 29070, 190000, 0, '2018-09-03 18:24:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` int(11) NOT NULL,
  `num_recibo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `num_recibo`, `id_usuario`, `id_cliente`, `observaciones`, `fecha`) VALUES
(1, 1, 1, 3, 'Disco Duro Para Portátil Hp De 1 Tb', '2018-09-07 19:54:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `iniciada` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `estado`, `iniciada`, `ultimo_login`, `fecha`) VALUES
(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87aa5OnE8ZHik1IMuyu7UDZ0iqRRCxxPudXKG', 'Administrador', 1, 1, '2018-09-10 09:45:31', '2018-09-10 14:45:31'),
(2, 'Demo', 'demo', '$2a$07$asxx54ahjppf45sd87aa5O3NFiRx/xnpLTmIPO.yU9dHDwSC.FqwO', 'Administrador', 1, 0, '2018-08-20 11:36:53', '2018-08-20 16:36:53'),
(3, 'especial uno', 'espeuno', '$2a$07$asxx54ahjppf45sd87aa5O06oHOq8hPjJ5Be3/zEb/VGTTnblamcy', 'Especial', 1, 0, '2018-08-23 08:52:29', '2018-08-23 13:52:29'),
(4, 'Vendedor Uno', 'vendeuno', '$2a$07$asxx54ahjppf45sd87aa5OoCl9hieBQ/.P6vRwRFQn/XE/Evradqa', 'Vendedor', 1, 0, '2018-08-23 08:52:03', '2018-08-23 13:52:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `factura` text COLLATE utf8_spanish_ci NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `subtotalventa` float NOT NULL,
  `sumaiva` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `factura`, `id_cliente`, `id_vendedor`, `productos`, `subtotalventa`, `sumaiva`, `total`, `metodo_pago`, `estado`, `fecha`) VALUES
(1, '1', 3, 1, '[{\"codigo\":\"118\",\"descripcion\":\"Taladro Rojo\",\"cantidad\":\"1\",\"stock\":49,\"precio\":\"40000\",\"total\":\"40000\"}]', 40000, 3795, 40000, 'T-5456465', 'AC', '2018-09-07 18:45:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_recibo`
--
ALTER TABLE `detalles_recibo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`,`num_recibo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalles_recibo`
--
ALTER TABLE `detalles_recibo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
