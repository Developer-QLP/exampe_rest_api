-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: rest_api_mysql
-- Время создания: Авг 05 2020 г., 10:56
-- Версия сервера: 8.0.21
-- Версия PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `debug`
--
CREATE DATABASE IF NOT EXISTS `debug` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `debug`;

-- --------------------------------------------------------

--
-- Структура таблицы `models_auto`
--

CREATE TABLE `models_auto` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` year NOT NULL,
  `color` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `models_auto`
--

INSERT INTO `models_auto` (`id`, `name`, `year`, `color`) VALUES
(1, 'Volkswagen Golf', 1996, 'white'),
(2, 'Fiat Punto', 1996, 'black'),
(3, 'Peugeot 206/206 SW', 2003, 'green'),
(4, 'Ford Focus', 2003, 'blue'),
(5, 'Ford Fiesta', 2005, 'red');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `models_auto`
--
ALTER TABLE `models_auto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `models_auto`
--
ALTER TABLE `models_auto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
