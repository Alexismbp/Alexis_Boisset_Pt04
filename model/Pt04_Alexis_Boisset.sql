-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-10-2024 a las 03:57:50
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Pt04_Alexis_Boisset`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equips`
--

CREATE TABLE `equips` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equips`
--

INSERT INTO `equips` (`id`, `nom`) VALUES
(16, 'Alavés'),
(7, 'Athletic Club'),
(3, 'Atlético de Madrid'),
(18, 'Cádiz CF'),
(9, 'Celta de Vigo'),
(19, 'Elche CF'),
(14, 'Espanyol'),
(1, 'FC Barcelona'),
(11, 'Getafe CF'),
(15, 'Granada CF'),
(17, 'Mallorca'),
(12, 'Osasuna'),
(13, 'Rayo Vallecano'),
(6, 'Real Betis'),
(2, 'Real Madrid'),
(5, 'Real Sociedad'),
(4, 'Sevilla FC'),
(8, 'Valencia CF'),
(10, 'Villarreal CF');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partits`
--

CREATE TABLE `partits` (
  `id` int(11) NOT NULL,
  `equip_local_id` int(11) NOT NULL,
  `equip_visitant_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `gols_local` tinyint(4) DEFAULT NULL,
  `gols_visitant` tinyint(4) DEFAULT NULL,
  `jugat` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partits`
--

INSERT INTO `partits` (`id`, `equip_local_id`, `equip_visitant_id`, `data`, `gols_local`, `gols_visitant`, `jugat`) VALUES
(9, 1, 2, '2024-08-20', NULL, NULL, 0),
(10, 3, 4, '2024-08-21', NULL, NULL, 0),
(13, 9, 10, '2024-08-24', NULL, NULL, 0),
(14, 11, 12, '2024-08-25', NULL, NULL, 0),
(15, 13, 14, '2024-08-26', NULL, NULL, 0),
(16, 15, 16, '2024-08-27', NULL, NULL, 0),
(17, 17, 18, '2024-08-28', NULL, NULL, 0),
(18, 2, 3, '2024-09-01', NULL, NULL, 0),
(19, 4, 5, '2024-09-02', NULL, NULL, 0),
(20, 6, 1, '2024-09-03', NULL, NULL, 0),
(21, 7, 9, '2024-09-04', NULL, NULL, 0),
(23, 12, 13, '2024-09-06', NULL, NULL, 0),
(24, 10, 15, '2024-09-07', NULL, NULL, 0),
(25, 16, 17, '2024-09-08', NULL, NULL, 0),
(26, 18, 14, '2024-09-09', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

CREATE TABLE `usuaris` (
  `id` int(11) NOT NULL,
  `nom_usuari` varchar(50) NOT NULL,
  `correu_electronic` varchar(100) NOT NULL,
  `contrasenya` varchar(255) NOT NULL,
  `equip_favorit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `nom_usuari`, `correu_electronic`, `contrasenya`, `equip_favorit`) VALUES
(1, 'Marcos', 'm.lopez@sapalomera.cat', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2', 'Real Betis'),
(2, 'Alexis', 'a.boisset@sapalomera.cat', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2', 'Valencia CF'),
(3, 'Xavi Martin', 'x.martin@sapalomera.cat', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2', 'Rayo Vallecano');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equips`
--
ALTER TABLE `equips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indices de la tabla `partits`
--
ALTER TABLE `partits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equip_local_id` (`equip_local_id`),
  ADD KEY `equip_visitant_id` (`equip_visitant_id`);

--
-- Indices de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_usuari` (`nom_usuari`),
  ADD UNIQUE KEY `correu_electronic` (`correu_electronic`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equips`
--
ALTER TABLE `equips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `partits`
--
ALTER TABLE `partits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partits`
--
ALTER TABLE `partits`
  ADD CONSTRAINT `partits_ibfk_1` FOREIGN KEY (`equip_local_id`) REFERENCES `equips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partits_ibfk_2` FOREIGN KEY (`equip_visitant_id`) REFERENCES `equips` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
