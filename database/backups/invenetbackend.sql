-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2025 a las 01:47:28
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
-- Base de datos: `invenetbackend`
--
CREATE DATABASE IF NOT EXISTS `invenetbackend` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `invenetbackend`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('CPU','netbook','televisor','proyector','monitor','router','switch') NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `ubicacion` enum('Sala Informática 1','Sala Informática 2','Sala Informática 3','Sala Multimedia 1','Sala Multimedia 2','Sala Multimedia 3','Otro') NOT NULL,
  `nro_serie` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` enum('activo','baja','en_reparacion') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`id`, `tipo`, `marca`, `modelo`, `codigo_qr`, `descripcion`, `ubicacion`, `nro_serie`, `created_at`, `updated_at`, `estado`) VALUES
(1, 'CPU', 'HP', 'ProBook 450', NULL, 'nuevo', 'Sala Informática 2', 'SN123456789', '2025-06-10 01:44:02', '2025-06-13 01:30:28', 'activo'),
(2, 'proyector', 'Epson', 'EB-X06', NULL, NULL, 'Sala Informática 1', 'PJ456789', '2025-06-10 01:44:02', '2025-06-10 01:44:02', 'activo'),
(3, 'CPU', 'LG', 'ProBook 450', NULL, NULL, 'Sala Informática 2', NULL, '2025-06-14 02:35:56', '2025-06-14 02:35:56', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'LG', '2025-06-14 02:33:39', '2025-06-14 02:33:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_05_22_213852_create_dispositivos_table', 1),
(4, '2025_05_22_224040_create_personal_access_tokens_table', 1),
(5, '2025_05_22_225959_create_reportes_table', 1),
(7, '2025_06_05_204357_add_completada_to_ordenes_reparacion', 1),
(8, '2025_06_05_211534_create_ordenes_reparacion_table', 2),
(9, '2025_06_05_215453_update_dispositivos_table', 3),
(10, '2025_06_05_221158_add_estado_to_dispositivos_table', 4),
(11, '2025_06_05_234014_create_marcas_table', 5),
(12, '2025_06_10_005501_drop_dispositivo_column_from_ordenes_table', 6),
(13, '2025_06_10_005557_drop_dispositivo_id_column_from_ordenes_reparacions_table', 7),
(14, '2025_06_10_005835_drop_dispositivo_id_column_from_orden_reparacions_table', 8),
(15, '2025_06_12_211006_create_password_resets_codes_table', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_reparacions`
--

CREATE TABLE `orden_reparacions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('pendiente','en_proceso','completada') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reporte_id` bigint(20) UNSIGNED NOT NULL,
  `tecnico_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orden_reparacions`
--

INSERT INTO `orden_reparacions` (`id`, `usuario_id`, `descripcion`, `estado`, `created_at`, `updated_at`, `reporte_id`, `tecnico_id`) VALUES
(1, 1, 'finalizado', 'completada', '2025-06-10 01:44:02', '2025-06-14 01:41:18', 1, 2),
(2, 2, 'Proyector con imagen borrosa', 'en_proceso', '2025-06-10 01:44:02', '2025-06-10 01:44:02', 1, 2),
(3, 1, NULL, 'pendiente', '2025-06-10 03:04:38', '2025-06-10 03:04:38', 1, 2),
(4, NULL, NULL, 'pendiente', '2025-06-14 01:40:10', '2025-06-14 01:40:10', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets_codes`
--

CREATE TABLE `password_resets_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_resets_codes`
--

INSERT INTO `password_resets_codes` (`id`, `email`, `code`, `created_at`) VALUES
(1, 'docente@invenet.com', '132622', '2025-06-14 01:41:28'),
(2, 'adminis@invenet.com', '272444', '2025-06-13 02:21:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(8, 'App\\Models\\User', 2, 'auth_token', 'e5393d55691eb6d3145e2efef05410c212c22e1a2b6116cff1311bb4f1788996', '[\"*\"]', '2025-06-12 23:55:45', NULL, '2025-06-12 23:54:30', '2025-06-12 23:55:45'),
(12, 'App\\Models\\User', 2, 'auth_token', '56c1fb3348ac122e50ccaf28ced929baf9779f112411050a291fd3813188d35e', '[\"*\"]', '2025-06-14 01:41:18', NULL, '2025-06-14 01:41:05', '2025-06-14 01:41:18'),
(14, 'App\\Models\\User', 1, 'auth_token', '67a99719d5e9e43205c470d17f4236bf34890af4a782f17a9c324198b0c2d17d', '[\"*\"]', '2025-06-14 02:01:42', NULL, '2025-06-14 02:00:23', '2025-06-14 02:01:42'),
(15, 'App\\Models\\User', 2, 'auth_token', 'e0646cadfb9fc02829926c10cf91117f3cb15f2ca7a0f7f334f46d5620424b36', '[\"*\"]', '2025-06-14 02:18:29', NULL, '2025-06-14 02:03:01', '2025-06-14 02:18:29'),
(16, 'App\\Models\\User', 1, 'auth_token', 'bc9d35771f95998853b1264b29a30bb83f0d0466ce69d5fc61a55f7c56e70480', '[\"*\"]', '2025-06-14 02:04:25', NULL, '2025-06-14 02:04:15', '2025-06-14 02:04:25'),
(17, 'App\\Models\\User', 1, 'auth_token', 'e431bb95257ab9f12d58a071a933d7baafcdea2b2d7392498b0e617715c925e3', '[\"*\"]', '2025-06-14 02:08:45', NULL, '2025-06-14 02:08:07', '2025-06-14 02:08:45'),
(18, 'App\\Models\\User', 1, 'auth_token', 'b0f10d26d66c53d18a86925c19f38f7be67e98021e56d1ba0725dbed49f3a063', '[\"*\"]', '2025-06-14 02:12:24', NULL, '2025-06-14 02:11:38', '2025-06-14 02:12:24'),
(19, 'App\\Models\\User', 1, 'auth_token', 'cf442b46b8f96e5e2f5e4c6fd046983066dc14a7e296cb94ffb325e2724ffec5', '[\"*\"]', '2025-06-14 02:13:19', NULL, '2025-06-14 02:13:00', '2025-06-14 02:13:19'),
(20, 'App\\Models\\User', 1, 'auth_token', 'fbb3d9a71662339696b3b98f31d4f1479d1662d4b3930df27a08605b6434e8bd', '[\"*\"]', '2025-06-14 02:17:21', NULL, '2025-06-14 02:13:26', '2025-06-14 02:17:21'),
(21, 'App\\Models\\User', 1, 'auth_token', '7f1afc31ccf10fb1c6a58c04c1135922f285d89d6dc69d777a4d2c520ea7ff15', '[\"*\"]', '2025-06-14 02:20:29', NULL, '2025-06-14 02:18:33', '2025-06-14 02:20:29'),
(22, 'App\\Models\\User', 1, 'auth_token', '2967aae1da609d8d0b3f5678263a485c1974abb26ac5c3a9f7a0dcbe83472168', '[\"*\"]', '2025-06-14 02:21:04', NULL, '2025-06-14 02:20:36', '2025-06-14 02:21:04'),
(23, 'App\\Models\\User', 1, 'auth_token', 'd3eebd8934325890ceb6b0035cbfa98aa58af10ab323c8846657771e1374006f', '[\"*\"]', '2025-06-14 02:36:41', NULL, '2025-06-14 02:30:53', '2025-06-14 02:36:41'),
(24, 'App\\Models\\User', 1, 'auth_token', '3b5c3b0522b3e42c87da4a67e6721bfe1338d9536bf66e24b32b111ef7f1139b', '[\"*\"]', '2025-06-14 02:38:29', NULL, '2025-06-14 02:34:10', '2025-06-14 02:38:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dispositivo_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('pendiente','revisado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id`, `user_id`, `dispositivo_id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'No funciona', 'revisado', '2025-06-10 02:41:45', '2025-06-13 01:06:42'),
(2, 1, 1, 'No funciona', 'pendiente', '2025-06-12 23:44:51', '2025-06-12 23:44:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BpGrI7OVpBRE5cvIHylc20y2stWyR2o38ZAYhWwk', NULL, '127.0.0.1', 'PostmanRuntime/7.44.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWJZMW9ESnUwb2s5ZjZHeGVqNU1vT0ViRnpydUl0alBjVjF6c1pLayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749856829);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('administrador','tecnico','docente') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'adminis@invenet.com', NULL, '$2y$12$74XKpsSfLrm55oWVOBl5feWy3eiWnXQ2OEaPkSr9Q7itud4hUCwnu', 'administrador', NULL, '2025-06-10 01:44:02', '2025-06-10 01:44:02'),
(2, 'Técnico Juan', 'tecnico@invenet.com', NULL, '$2y$12$wn1wu.jIXpFP2FCf1MLkquJyGjN320W9J3Q23YGKF4L9cC4I26X2G', 'tecnico', NULL, '2025-06-10 01:44:02', '2025-06-10 01:44:02'),
(3, 'Docente María', 'docente@invenet.com', NULL, '$2y$12$KtkUAgXeHZK2YThc9ls1eOMkZzzqZ1RPB51596o2MJ5ZwQgyENXtm', 'docente', NULL, '2025-06-10 01:44:02', '2025-06-10 01:44:02'),
(4, 'Juan', 'juan2@gmail.com', NULL, '$2y$12$XiFNiRl9k08.CECEArz.q.e7zE7aOqH8Cn.IwLwS0vSaG75ftBMb.', 'docente', NULL, '2025-06-10 03:11:27', '2025-06-10 03:13:01'),
(5, 'Juan', 'juan@gmail.com', NULL, '$2y$12$9zPmeEPJ4otPCS3wnf3jGebIOnYJ2q7V8LqYz0DdSdKBwkyQaLrpC', 'docente', NULL, '2025-06-14 01:35:29', '2025-06-14 01:35:29'),
(6, 'Juan', 'juan5@gmail.com', NULL, '$2y$12$S.a5PpnisjIQi5qP7LoHNev5.YKnMswsf1XApqrW/zgtq6a.I/ZUm', 'docente', NULL, '2025-06-14 02:21:04', '2025-06-14 02:21:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dispositivos_codigo_qr_unique` (`codigo_qr`),
  ADD UNIQUE KEY `dispositivos_nro_serie_unique` (`nro_serie`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marcas_nombre_unique` (`nombre`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `nombre_2` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_reparacions`
--
ALTER TABLE `orden_reparacions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordenes_reparacion_usuario_id_foreign` (`usuario_id`),
  ADD KEY `reporte_id` (`reporte_id`),
  ADD KEY `tecnico_id` (`tecnico_id`);

--
-- Indices de la tabla `password_resets_codes`
--
ALTER TABLE `password_resets_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_codes_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reportes_user_id_foreign` (`user_id`),
  ADD KEY `reportes_dispositivo_id_foreign` (`dispositivo_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `orden_reparacions`
--
ALTER TABLE `orden_reparacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `password_resets_codes`
--
ALTER TABLE `password_resets_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orden_reparacions`
--
ALTER TABLE `orden_reparacions`
  ADD CONSTRAINT `orden_reparacions_ibfk_1` FOREIGN KEY (`reporte_id`) REFERENCES `reportes` (`id`),
  ADD CONSTRAINT `orden_reparacions_ibfk_2` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ordenes_reparacion_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_dispositivo_id_foreign` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reportes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
