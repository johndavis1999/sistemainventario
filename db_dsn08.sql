-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2023 a las 09:32:23
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_dsn08`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id`, `nombre`, `direccion`, `estado`) VALUES
(1, 'Bodega Guasmo', 'Guayaquil guasmo sur', 1),
(2, 'Bodega Centro', 'Parque centenario', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_egreso`
--

CREATE TABLE `detalle_egreso` (
  `id_recibo_egreso` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_egreso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_egreso`
--

INSERT INTO `detalle_egreso` (`id_recibo_egreso`, `id_producto`, `cantidad_egreso`) VALUES
(1, 10, 70),
(1, 3, 400),
(1, 4, 100),
(2, 26, 2),
(2, 4, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura_item`
--

CREATE TABLE `detalle_factura_item` (
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `factura_producto_cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `monto_final_item` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_factura_item`
--

INSERT INTO `detalle_factura_item` (`factura_id`, `producto_id`, `factura_producto_cantidad`, `precio_unitario`, `monto_final_item`) VALUES
(15, 20, 12, 22, 264),
(15, 20, 12, 33, 396),
(30, 15, 22, 11, 242),
(32, 18, 45, 2, 0),
(33, 20, 12, 22222, 266664),
(34, 9, 500, 800, 2000000),
(0, 20, 87978, 852, 74957300),
(15, 20, 12, 22, 264),
(15, 20, 12, 33, 396),
(30, 15, 22, 11, 242),
(32, 18, 45, 2, 0),
(33, 20, 12, 22222, 266664),
(34, 9, 500, 800, 2000000),
(0, 20, 87978, 852, 74957300),
(45, 20, 5, 70, 350),
(46, 15, 5, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `id_recibo_ingreso` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_ingreso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`id_recibo_ingreso`, `id_producto`, `cantidad_ingreso`) VALUES
(2, 6, 100),
(2, 3, 500),
(2, 1, 400),
(1, 10, 400),
(1, 5, 20),
(1, 1, 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido_item`
--

CREATE TABLE `detalle_pedido_item` (
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `pedido_producto_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `num_fact` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` int(11) NOT NULL,
  `id_cajero` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`num_fact`, `id_cliente`, `fechahora`, `metodo_pago`, `id_cajero`, `estado`, `iva`, `subtotal`, `total`) VALUES
(32, 3, '2023-04-02 03:19:07', 3, 1, 1, 12, 0, 0),
(33, 8, '2023-04-02 03:21:52', 3, 1, 2, 12, 266664, 298664),
(34, 19, '2023-04-02 03:41:03', 1, 1, 1, 12, 2000000, 2240000),
(35, 7, '2023-04-05 21:45:16', 2, 1, 2, 12, 74957300, 83952100),
(39, 14, '2023-04-05 21:50:18', 2, 1, 2, 12, 0, 0),
(40, 14, '2023-04-05 21:50:44', 2, 1, 2, 12, 0, 0),
(45, 6, '2023-04-06 08:28:18', 3, 1, 99, 12, 350, 392),
(46, 11, '2023-04-06 08:42:52', 1, 1, 99, 12, 4000, 4480);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefebodega`
--

CREATE TABLE `jefebodega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cedula` int(10) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jefebodega`
--

INSERT INTO `jefebodega` (`id`, `nombre`, `apellido`, `cedula`, `celular`, `correo`, `estado`) VALUES
(1, 'Angel', 'Cruz', 985637482, '0956897412', 'angelcruz@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefecompras`
--

CREATE TABLE `jefecompras` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(250) NOT NULL,
  `Apellido` varchar(250) NOT NULL,
  `Identificacion` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `Correo` varchar(155) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jefecompras`
--

INSERT INTO `jefecompras` (`id`, `Nombre`, `Apellido`, `Identificacion`, `Estado`, `Correo`, `Telefono`) VALUES
(1, 'Marcos', 'Palacios', 923896591, 1, 'nohaybolo@gmail.com', 1234567890);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `IdJefeBodega` int(11) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `IdJefeBodega`, `fechaHora`, `Estado`) VALUES
(5, 1, '2023-03-26 00:07:20', 1),
(7, 1, '2023-03-26 00:07:36', 0),
(8, 1, '2023-03-26 20:19:00', 1),
(10, 1, '2023-03-01 15:19:00', 1),
(11, 1, '2023-04-02 20:24:04', 1),
(12, 1, '2023-04-02 20:24:16', 2),
(16, 1, '2023-04-02 20:24:36', 1),
(17, 1, '2023-04-02 20:24:41', 0),
(18, 1, '2023-04-02 20:24:45', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `idTipo` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`, `stock`, `estado`, `marca`, `idTipo`, `codigo`) VALUES
(1, 'Teclado', 20, 680, 1, NULL, 0, '78945'),
(2, 'Mouse', 10, 100, 1, NULL, 0, '34345'),
(3, 'Iphone', 1000, 6900, 1, 'apple', 15, 'iphone13'),
(4, 'Samsung Galaxy', 300, 185, 0, 'samsung', 16, 'galaxys20'),
(5, 'LG Monitor', 100, 100, 1, 'LG', 15, 'LG4K27'),
(6, 'HP Laptop', 480, 150, 0, 'HP', 16, 'HPEnvy13'),
(7, 'Bose Speaker', 50, 8, 1, 'Bose', 15, 'BoseSoundlink'),
(8, 'Cámara Sony', 180, 100, 0, 'Sony', 16, 'sonyalpha7'),
(9, 'Asus Laptop', 1200, 503, 1, 'Asus', 15, 'AsusZenbook'),
(10, 'Xbox Series X', 700, 400, 0, 'Microsoft', 16, 'xboxseriesx'),
(11, 'PS5', 900, 5099, 1, 'Sony', 15, 'ps5'),
(12, 'Smartwatch', 250, 400, 0, 'Samsung', 16, 'galaxywatch4'),
(14, 'Headphones', 80, 10, 0, 'JBL', 16, 'jbltune'),
(15, 'MacBook Pro', 800, 60, 1, 'Apple', 15, 'macbookpro'),
(17, 'GoPro Camera', 150, 6, 1, 'GoPro', 15, 'goprohero9'),
(18, 'Auriculares Sony', 70, 5, 0, 'Sony', 16, 'sonyheadphones'),
(19, 'Smart TV LG', 1000, 2, 1, 'LG', 15, 'lgsmarttv'),
(20, 'Audífonos Inalámbricos', 70, 3, 0, 'Samsung', 16, 'samsungbuds'),
(21, 'Laptop HP', 1300, 0, 1, 'HP', 15, 'hpnotebook'),
(22, 'Tablet Samsung', 150, 0, 0, 'Samsung', 16, 'samsungtablet'),
(23, 'Proyector Epson', 160, 2500, 1, 'Epson', 15, 'epsonprojector'),
(24, 'Impresora Canon', 100, 4, 0, 'Canon', 16, 'canonprinter'),
(25, 'Bose Speaker', 90, 3, 1, 'Bose', 15, 'boseaudio'),
(26, 'Reloj inteligente Garmin', 300, 3, 0, 'Garmin', 16, 'garminwatch'),
(27, 'Teléfono Samsung', 200, 0, 1, 'Samsung', 15, 'samsunggalaxy'),
(28, 'Plancha de vapor', 60, 6, 0, 'Philips', 16, 'philipsiron'),
(29, 'Silla de escritorio', 170, 120, 100, 'Ikea', 15, 'ikeachair'),
(30, 'Refrigerador LG1231312312', 500, 1, 30, 'LG', 2, 'lgfridge'),
(31, 'Tablet Amazon Fire', 350, 0, 90, 'Amazon', 12, 'amazonfiretablet'),
(32, 'Altavoz Harman Kardon123123', 50, 3, 70, 'Harman Kardon', 0, 'hkaudiospeaker'),
(33, 'Cafetera Nespresso2', 70, 4, 60, 'Nespresso', 0, 'nespressomachine'),
(34, 'Micrófono Rode1asasdassad', 30, 1, 80, 'Rode', 0, 'rodemic'),
(35, 'Smartwatch Fitbitasds', 90, 0, 50, 'Fitbit', 0, 'fitbitsmartwatch'),
(37, 'Consola de juegos retro1', 100, 1, 100, 'Retro Games', 0, 'retroconsole'),
(43, 'prueba tipo1', 12, 12, 1, 'asdas', 12, 'sdasd'),
(64, 'pc gamer', 800, 10, 600, 'Asus', 4, 'PCG-AS01'),
(66, 'kukfvhjfhj', 8, 5, 0, '', 0, '852');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo_egreso`
--

CREATE TABLE `recibo_egreso` (
  `id_egreso` int(11) NOT NULL,
  `id_jefebodega` int(11) NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_factura` int(11) NOT NULL,
  `id_bodega` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recibo_egreso`
--

INSERT INTO `recibo_egreso` (`id_egreso`, `id_jefebodega`, `fechahora`, `id_factura`, `id_bodega`, `estado`) VALUES
(1, 1, '2023-04-09 07:22:33', 39, 2, 2),
(2, 1, '2023-04-09 07:28:15', 40, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo_ingreso`
--

CREATE TABLE `recibo_ingreso` (
  `id_ingreso` int(11) NOT NULL,
  `id_jefebodega` int(11) NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_bodega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recibo_ingreso`
--

INSERT INTO `recibo_ingreso` (`id_ingreso`, `id_jefebodega`, `fechahora`, `estado`, `id_pedido`, `id_bodega`) VALUES
(1, 1, '2023-04-09 07:20:59', 2, 12, 2),
(2, 1, '2023-04-09 07:21:23', 2, 11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `Descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `Descripcion`) VALUES
(2, 'asdasdas'),
(15, 'asdasdasdasd'),
(16, 'asdsdaasd'),
(17, 'fsdsdfsdf'),
(18, 'ewfsdfsd'),
(19, 'sdfdsf'),
(20, 'ytutyutyutyutyut'),
(21, '1'),
(22, '2'),
(26, '123231');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`num_fact`);

--
-- Indices de la tabla `jefecompras`
--
ALTER TABLE `jefecompras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recibo_egreso`
--
ALTER TABLE `recibo_egreso`
  ADD PRIMARY KEY (`id_egreso`);

--
-- Indices de la tabla `recibo_ingreso`
--
ALTER TABLE `recibo_ingreso`
  ADD PRIMARY KEY (`id_ingreso`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `num_fact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `jefecompras`
--
ALTER TABLE `jefecompras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `recibo_egreso`
--
ALTER TABLE `recibo_egreso`
  MODIFY `id_egreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recibo_ingreso`
--
ALTER TABLE `recibo_ingreso`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
