-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 25 2015 г., 08:02
-- Версия сервера: 5.6.14
-- Версия PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `restservice`
--

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `originalname` varchar(256) COLLATE utf8_bin NOT NULL,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `hash` varchar(32) COLLATE utf8_bin NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL,
  `directory` varchar(11) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Структура таблицы `thumbnails`
--

CREATE TABLE IF NOT EXISTS `thumbnails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `originalname` varchar(256) COLLATE utf8_bin NOT NULL,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `hash` varchar(32) COLLATE utf8_bin NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `directory` varchar(11) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=32 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
