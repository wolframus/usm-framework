-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 14 2022 г., 15:22
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `auto`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'crossover'),
(2, 'sedan'),
(3, 'hatchback'),
(4, 'uniwersal');

-- --------------------------------------------------------

--
-- Структура таблицы `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221126171425', '2022-11-26 17:14:34', 811),
('DoctrineMigrations\\Version20221126233813', '2022-11-26 23:38:39', 655),
('DoctrineMigrations\\Version20221126235918', '2022-11-26 23:59:26', 893),
('DoctrineMigrations\\Version20221127001454', '2022-11-27 00:15:04', 977),
('DoctrineMigrations\\Version20221127002237', '2022-11-27 00:22:44', 882),
('DoctrineMigrations\\Version20221204144749', '2022-12-04 14:48:42', 188),
('DoctrineMigrations\\Version20221205001754', '2022-12-05 00:17:58', 73),
('DoctrineMigrations\\Version20221205005958', '2022-12-05 01:00:07', 81);

-- --------------------------------------------------------

--
-- Структура таблицы `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `status_id`, `client`, `adress`, `phone`, `email`, `created_at`) VALUES
(1, 3, 'Ion Corlateanu', 'bd. Dacia 32', '069124878', 'i.ion@mail.ru', '2022-12-14 03:12:18'),
(2, 1, 'Vasile Sitari', 'Alexandru cel Bun, 18', '079856718', 'cor@gmail.com', '2022-12-07 04:11:19'),
(3, 1, 'Petru Soltan', 'M. Viteazul 2', '067479632', 'p@ya.ru', '2022-12-04 08:10:07');

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ord_id` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`id`, `product_id`, `ord_id`, `count`) VALUES
(1, 3, 1, 2),
(2, 8, 1, 1),
(3, 1, 1, 3),
(4, 3, 2, 1),
(5, 8, 3, 2),
(6, 2, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `image_url` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `description`, `price`, `image_url`) VALUES
(1, 2, 'BMW', 'BMW X3 xDrive30e:\r\nConsum mixt de combustibil, în l/100 km: 2,0-2,6\r\nEmisii medii de CO2, în g/km: 44 – 59', 25655, '/images/product/bmw.jpg'),
(2, 4, 'Toyota', 'Noul Yaris de generația a 4-a este un automobil ce satisface perfect cerințele stilului urban de viață, oferind, în același timp, o enormă plăcere pe drumurile extraurbane și autostradă.', 23000, '/images/product/toyota.jpg'),
(3, 1, 'Nissan', 'NISSAN MOLDOVA ; New QASHQAI. THE ULTIMATE CROSSOVER. ОТ. 25 900 € ; MICRA. THE AUDACIOUS CITY CAR. ОТ. 14 900 € ; JUKE. CROSSOVER COUPE. ОТ. 19 900 €.', 15500, '/images/product/nissan.jpg'),
(8, 1, 'Mazda', 'Dealer oficial autoturisme Mazda în Moldova. ... Primul SUV plug-in hybrid Mazda pentru piața europeană - noua Mazda CX-60 - va avea un motor electric', 10330, '/images/product/mazda.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`, `full_name`) VALUES
(1, 'in_progress', 'In Progres'),
(2, 'in_delivering', 'Se livreaza'),
(3, 'delivered', 'Livrat'),
(4, 'denied', 'Anulat');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F52993986BF700BD` (`status_id`);

--
-- Индексы таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2530ADE64584665A` (`product_id`),
  ADD KEY `IDX_2530ADE6E636D3F5` (`ord_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993986BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `FK_2530ADE64584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_2530ADE6E636D3F5` FOREIGN KEY (`ord_id`) REFERENCES `order` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
