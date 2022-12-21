-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-12-2022 a las 16:18:40
-- Versión del servidor: 10.5.16-MariaDB
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id20019601_tp_integrador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id_sesion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id_sesion`, `usuario_id`) VALUES
('0kea2lc8cadg2ku6vlr019vmt8', 1),
('7p8831kfegsivof3rfp7n53bh9', 1),
('g84og0onph70trldrlt442sibq', 1),
('p5821cnd5c89qr1dsokvts41qo', 1),
('8ldb7l110ich7hro640vr46d8c', 48);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `password`) VALUES
(1, 'Leonardo', 'Rodriguez', 'leonardorodriguez08@gmail.com', '123456'),
(4, 'Martín', 'Zarabia', 'martinzarabia@hotmail.com.ar', '31096675'),
(5, 'José', 'Velez', 'josevelez@hotmail.com.ar', '34269854'),
(6, 'Paula', 'Madariaga', 'paulamadariaga@hotmail.com.ar', '41369852'),
(7, 'Abril', 'Sanchez', 'abrilsanchez@gmail.com', '42369854'),
(8, 'Guadalupe', 'Perez', 'guadalupeperez@yahoo.com.ar', '32145698'),
(9, 'Bernardo', 'pantera', 'bernardopantera@yahoo.com.ar', '32369854'),
(10, 'Carmen', 'Barbieri', 'carmenbarbieri@yahoo.com.ar', '99698547'),
(11, 'Mirta', 'Legrand', 'mirtalegrand@yahoo.com.ar', '1468416'),
(12, 'Moria', 'Casán', 'moriacasan@hotmail.com.ar', '44174599'),
(13, 'Maru', 'Botana', 'marubotana@gmail.com', '73449932'),
(14, 'Nacha', 'Guevara', 'nachaguevara@hotmail.com.ar', '83120973'),
(15, 'Valeria', 'Lynch', 'valerialynch@hotmail.com.ar', '53221735'),
(16, 'Diego', 'Torres', 'diegotorres@gmail.com', '75217165'),
(17, 'Adrián', 'Suar', 'adriansuar@hotmail.com.ar', '29638219'),
(18, 'Esther', 'Vazquez', 'esthervazquez@hotmail.com.ar', '89267109'),
(19, 'Juan', 'López', 'juanlopez@yahoo.com.ar', '31096678'),
(20, 'Pedro', 'Perez', 'pedroperez@yahoo.com.ar', '33698521'),
(21, 'Marti', 'Julia', 'martijulia@gmail.com', '36125896'),
(22, 'Lucia', 'Pesaro', 'luciapesaro@hotmail.com.ar', '36125965'),
(23, 'Maria', 'diamante', 'mariadiamante@yahoo.com.ar', '31236985'),
(24, 'China', 'Suarez', 'chinasuarez@hotmail.com.ar', '17471332'),
(25, 'Graciela', 'Borges', 'gracielaborges@gmail.com', '23741525'),
(26, 'Cris', 'Morena', 'crismorena@yahoo.com.ar', '59943636'),
(27, 'Mauro', 'Viale', 'mauroviale@gmail.com', '83449174'),
(28, 'Cacho', 'Castaña', 'cachocastana@gmail.com', '91896535'),
(29, 'Mariana', 'Lopez', 'marianalopez@yahoo.com.ar', '32698547'),
(30, 'Omar', 'Diaz', 'omardiaz@hotmail.com.ar', '36985471'),
(31, 'Mariano', 'Martinez', 'marianomartinez@hotmail.com.ar', '69687142'),
(32, 'Marcelo', 'Tinelli', 'marcelotinelli@yahoo.com.ar', '37385518'),
(33, 'Fátima', 'Flórez', 'fatimaflorez@hotmail.com.ar', '23456789'),
(34, 'Juan', 'Pepe', 'juan@pepe.com', 'JuanPepe1'),
(35, 'Jose', 'Gadea', 'joseluisgadea@gmail.com', '123456'),
(36, 'Sebastos ', 'POZZi ', 'pozzi@gmail.com', '123456'),
(37, 'mariano', 'fachari', 'lala@gmail.com', '123456'),
(38, 'mariano', 'fachari', 'mfachari@yahoo.com', '123456'),
(39, 'Yj', 'Jb', 'j@e', 'hhhhhh'),
(40, 'Jose', 'Zapata', 'alejandrozapata73@gmail.com', '123456'),
(41, 'Carlos', 'Be', 'cd@gmail.com', '123456'),
(42, 'Juan', 'Ve', 'cb@gmail.com', '654321'),
(43, 'asd', 'asd', 'asd@asd', 'asdasd'),
(44, 'leo', 'Rodríguez ', 'leorodriguez@gmail.com', '12345678'),
(45, 'Juan Manuel', 'Etchehun', 'etchehun@topmail.com', 'aaaaaa'),
(46, 'Juan Manuel', 'Etchehun', 'etchehun@hotmail.com', 'vvvvvv'),
(47, 'ale', 'cabrera', 'alex90o71@gmail.com', 'colgate'),
(48, 'Mariano', 'Facciai', 'mfachari1@gmail.com', '123456');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
