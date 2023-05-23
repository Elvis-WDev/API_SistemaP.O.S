-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 08:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemaposapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT '2023-03-23 21:57:26',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Electrodomésticos', '2023-04-19 05:00:00', NULL, '2023-04-20 03:41:43', '2023-04-20 03:41:43'),
(7, 'Muebles', '2023-04-20 01:30:23', NULL, '2023-04-20 06:30:24', '2023-04-25 18:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras_cliente` int(11) DEFAULT NULL,
  `ultima_compra` date DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `name`, `cedula`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras_cliente`, `ultima_compra`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(3, 'Elvis Macas Michael', '0705537378', 'maicolmacas3@gmail.com', '+(593) 242452452', '24 de mayo', '2023-04-13', 1, '2023-05-14', '2023-04-17', '2023-04-18 04:30:57', '2023-05-14 10:30:21'),
(4, 'Elvis Macas', '0705537389', 'maicolmacas7@gmail.com', '+(593) 456256262', '24 de mayo', '2023-04-17', 3, '2023-05-14', '2023-04-17', '2023-04-18 04:46:18', '2023-05-14 10:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2023_03_21_205122_clientes_table', 1),
(14, '2023_03_22_035020_categorias_table', 1),
(15, '2023_03_22_205721_productos_table', 1),
(16, '2023_03_23_145928_ventas_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(20) UNSIGNED NOT NULL,
  `codigo_producto` varchar(255) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `url_img_producto` varchar(255) DEFAULT NULL,
  `stock_producto` int(11) NOT NULL,
  `precio_compra_producto` decimal(10,2) NOT NULL,
  `precio_venta_producto` decimal(10,2) NOT NULL,
  `ventas_producto` int(11) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `id_category`, `codigo_producto`, `descripcion_producto`, `url_img_producto`, `stock_producto`, `precio_compra_producto`, `precio_venta_producto`, `ventas_producto`, `fecha`, `created_at`, `updated_at`) VALUES
(7, 7, '941475', 'PRODCUTOs', '', 5, '5.00', '3.00', 0, '2023-04-23 11:44:46', '2023-04-23 21:44:47', '2023-05-14 10:35:43'),
(11, 1, '752655', 'POroducto', 'http://localhost:8000/storage/images/productos/7beb39153cc9094674d823f76d04c058.png', 8, '2.00', '1.00', 2, '2023-04-25 08:21:13', '2023-04-25 18:21:14', '2023-05-14 10:36:05'),
(12, 1, '981236', 'Papas', 'http://localhost:8000/storage/images/productos/5085555572fa2cd44c090ff82978c2a5.png', 2, '3.00', '3.00', 0, '2023-04-30 13:29:33', '2023-04-30 23:29:35', '2023-04-30 23:29:35'),
(13, 7, '279733', 'Papitas', '', 1, '4.00', '4.00', 1, '2023-04-30 15:24:03', '2023-05-01 01:24:04', '2023-05-14 10:30:21'),
(14, 7, '892313', 'unproductos', '', 2, '3.00', '1.00', 0, '2023-04-30 19:46:05', '2023-05-01 05:46:06', '2023-05-01 05:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `last_Login` timestamp NOT NULL DEFAULT '2023-03-23 21:57:26',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`, `profile`, `url_image`, `status`, `last_Login`, `remember_token`, `created_at`, `updated_at`) VALUES
(13, 'Elvis Macas', 'mioelij4i32', '$2y$10$WuaQDQh/gP6q/BvGmpX26ufTgMnwf9fede428uT/SoQW6GKweULES', 'Vendedor', NULL, 1, '2023-04-09 19:13:23', NULL, '2023-04-10 00:13:23', '2023-04-14 22:21:30'),
(18, 'Elvis', 'mioelij4i324f3232gaffawe', '$2y$10$kNUJRZAbkNxMMdV5k6gQWO6BB1MUqsZob1nBU/Zb..CM32JgHmXvu', 'Vendedor', 'http://localhost:8000/storage/images/users/1b1ae8fe4911f7c9e4cd4b772e574914.jpeg', 1, '2023-04-14 01:40:45', NULL, '2023-04-10 00:19:18', '2023-04-25 01:34:31'),
(22, 'Elvis', 'bipacma23f31', '$2y$10$C2/tAY0ddxy9AjMTy/.wo.mJk1.jD2Q2UI0UZFu8tMJfJlt6WDitm', 'Especial', NULL, 0, '2023-04-11 00:55:16', NULL, '2023-04-11 05:55:16', '2023-04-15 08:57:35'),
(27, 'Elvis', 'bipacma4', '$2y$10$L44T08JPYXJrj0C4jShCEuBIMwpc27UPvLa/zDfUjCoPizfyJX3xm', 'Admin', NULL, 1, '2023-04-14 15:39:49', NULL, '2023-04-14 20:39:49', '2023-04-14 20:39:49'),
(28, 'Elvis Michael Macas Ceva', 'bipacma', '$2y$10$w1qGjtxlC0Xqsz1DawxxzeGAhVRlVURnrBKdOHC9xZGzdT3sz0knm', 'Especial', NULL, 1, '2023-04-14 15:56:51', NULL, '2023-04-14 20:56:51', '2023-04-19 09:05:46'),
(30, 'Elvis', 'dvxvev3f', '$2y$10$jvGzlczsULmN5bSl57HZDugES4tNO8/uGtjlVSczAA86H9nMG9vaS', 'Especial', NULL, 1, '2023-04-14 17:09:17', NULL, '2023-04-14 22:09:17', '2023-04-14 22:09:17'),
(31, 'Elvis', 'bipamc342', '$2y$10$qjOmzJlamL42ZUx4BBJfPOMjNJuaCWPAV.rXftVVu6CGQwATsZS9e', 'Especial', 'http://localhost:8000/storage/images/users/1d44753419fc4e1d6d2a8c969a3b44d8.jpeg', 0, '2023-04-15 04:06:36', NULL, '2023-04-15 09:06:36', '2023-04-15 09:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_venta` varchar(255) NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_vendedor` bigint(20) UNSIGNED NOT NULL,
  `productos_venta` text NOT NULL,
  `impuesto_venta` decimal(8,2) NOT NULL,
  `neto_venta` decimal(8,2) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `metodo_pago` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `codigo_venta`, `id_cliente`, `id_vendedor`, `productos_venta`, `impuesto_venta`, `neto_venta`, `total`, `metodo_pago`, `fecha`, `created_at`, `updated_at`) VALUES
(2, '407389099', 3, 27, '[{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"},{\"id\":\"12\",\"nombre\":\"Papas\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"},{\"id\":\"13\",\"nombre\":\"Papitas\",\"precio_base\":\"4.00\",\"precio_total\":\"4.00\",\"cantidad\":\"1\"},{\"id\":\"14\",\"nombre\":\"unproductos\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"}]', '0.00', '12.00', '12.00', 'efectivo', '2023-05-12', '2023-05-13 04:28:32', '2023-05-13 04:28:32'),
(3, '269671739', 3, 27, '[{\"id\":\"14\",\"nombre\":\"unproductos\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"13\",\"nombre\":\"Papitas\",\"precio_base\":\"4.00\",\"precio_total\":\"4.00\",\"cantidad\":\"1\"},{\"id\":\"12\",\"nombre\":\"Papas\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"},{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"}]', '0.00', '12.00', '12.00', 'efectivo', '2023-05-12', '2023-05-13 05:41:37', '2023-05-13 05:41:37'),
(4, '955391480', 3, 27, '[{\"id\":\"14\",\"nombre\":\"unproductos\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"13\",\"nombre\":\"Papitas\",\"precio_base\":\"4.00\",\"precio_total\":\"4.00\",\"cantidad\":\"1\"},{\"id\":\"12\",\"nombre\":\"Papas\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"},{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"}]', '0.00', '12.00', '12.00', 'efectivo', '2023-05-12', '2023-05-13 05:47:48', '2023-05-13 05:47:48'),
(6, '456516002', 4, 27, '[{\"id\":\"14\",\"nombre\":\"unproductos\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"13\",\"nombre\":\"Papitas\",\"precio_base\":\"4.00\",\"precio_total\":\"4.00\",\"cantidad\":\"1\"},{\"id\":\"12\",\"nombre\":\"Papas\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"},{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"},{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"}]', '3.00', '12.00', '12.36', 'efectivo', '2023-05-13', '2023-05-13 19:24:17', '2023-05-13 19:24:17'),
(7, '493302925', 4, 27, '[{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"6\",\"cantidad\":\"2\"}]', '3.00', '6.00', '6.18', 'efectivo', '2023-05-13', '2023-05-13 19:27:54', '2023-05-13 19:27:54'),
(8, '110796090', 4, 27, '[{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"3.00\",\"cantidad\":\"1\"}]', '0.00', '3.00', '3.00', 'efectivo', '2023-05-13', '2023-05-13 19:52:29', '2023-05-13 19:52:29'),
(9, '354525818', 4, 27, '[{\"id\":\"7\",\"nombre\":\"PRODCUTOs\",\"precio_base\":\"3.00\",\"precio_total\":\"21\",\"cantidad\":\"7\"}]', '4.00', '21.00', '21.84', 'efectivo', '2023-05-13', '2023-05-13 19:52:53', '2023-05-13 19:52:53'),
(10, '429576169', 4, 27, '[{\"id\":\"13\",\"nombre\":\"Papitas\",\"precio_base\":\"4.00\",\"precio_total\":\"8\",\"cantidad\":\"2\"}]', '3.00', '8.00', '8.24', 'efectivo', '2023-05-13', '2023-05-14 09:52:16', '2023-05-14 09:52:16'),
(11, '674579896', 3, 27, '[{\"id\":\"13\",\"nombre\":\"Papitas\",\"precio_base\":\"4.00\",\"precio_total\":\"4\",\"cantidad\":\"1\"}]', '0.00', '4.00', '4.00', 'efectivo', '2023-05-14', '2023-05-14 10:30:21', '2023-05-14 10:30:21'),
(12, '829352706', 4, 27, '[{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"2\",\"cantidad\":\"2\"}]', '0.00', '2.00', '2.00', 'efectivo', '2023-05-14', '2023-05-14 10:32:42', '2023-05-14 10:32:42'),
(13, '13069711', 4, 27, '[{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"1.00\",\"cantidad\":\"1\"}]', '0.00', '1.00', '1.00', 'efectivo', '2023-05-14', '2023-05-14 10:33:20', '2023-05-14 10:33:20'),
(14, '819227977', 4, 27, '[{\"id\":\"11\",\"nombre\":\"POroducto\",\"precio_base\":\"1.00\",\"precio_total\":\"2\",\"cantidad\":\"2\"}]', '0.00', '2.00', '2.00', 'efectivo', '2023-05-14', '2023-05-14 10:36:05', '2023-05-14 10:36:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_categoria_unique` (`categoria`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_cedula_unique` (`cedula`),
  ADD UNIQUE KEY `clientes_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_codigo_producto_unique` (`codigo_producto`),
  ADD KEY `productos_id_category_foreign` (`id_category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_unique` (`user`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_id_cliente_foreign` (`id_cliente`),
  ADD KEY `ventas_id_vendedor_foreign` (`id_vendedor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categorias` (`id`);

--
-- Constraints for table `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_id_vendedor_foreign` FOREIGN KEY (`id_vendedor`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
