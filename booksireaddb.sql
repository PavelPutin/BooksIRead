-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 19 2022 г., 21:29
-- Версия сервера: 5.7.33
-- Версия PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `booksireaddb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `surname` varchar(80) NOT NULL,
  `patronymic` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `name`, `surname`, `patronymic`) VALUES
(1, 'Сергей', 'Виноградов', 'Николаевич'),
(2, 'Лев', 'Толстой', 'Николаевич');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `authorId` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `rating` int(2) DEFAULT NULL,
  `dateStartReading` date DEFAULT NULL,
  `dateFinishReading` date DEFAULT NULL,
  `edition` varchar(255) DEFAULT NULL,
  `yearEdition` varchar(5) NOT NULL,
  `publishingHouse` varchar(255) DEFAULT NULL,
  `review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `title`, `authorId`, `description`, `rating`, `dateStartReading`, `dateFinishReading`, `edition`, `yearEdition`, `publishingHouse`, `review`) VALUES
(1, 'Логика', 1, 'Это учебник логики. По нему учились в СССР', 5, '2022-05-01', NULL, '8-е издание', '2021', 'Концептуал', 'Книга очень понравилась. Советую к прочтению'),
(3, 'Война и мир', 2, 'Великий роман Льва Николаевича Толстого, повествующий о событиях Отечественной войны 1812 года.', 5, '2022-03-01', '2022-05-04', NULL, '1867', NULL, 'Роман очень подробно описывает события начала 19го века. Всем интересующимся этой эпохой обязательно к прочтению.'),
(4, 'После бала', 2, 'Происходит спор о том, что определяет человеческую судьбу.', 4, '2021-10-12', '2022-02-08', NULL, '1911', NULL, 'Книга понравилась, но не мой жанр.');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `userId` int(11) UNSIGNED NOT NULL,
  `bookId` int(11) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `userId`, `bookId`, `text`, `dateTime`) VALUES
(4, 12, 3, 'Комментарий к Войне и миру Оочень длиный. Не следует, однако, забывать, что начало повседневной работы по формированию позиции предоставляет широкие возможности для экономической целесообразности принимаемых решений. Современные технологии достигли такого уровня, что базовый вектор развития, в своём классическом представлении, допускает внедрение благоприятных перспектив! Есть над чем задуматься: некоторые особенности внутренней политики лишь добавляют фракционных разногласий и в равной степени предоставлены сами себе. Задача организации, в особенности же реализация намеченных плановых заданий предполагает независимые способы реализации своевременного выполнения сверхзадачи. В рамках спецификации современных стандартов, тщательные исследования конкурентов в равной степени предоставлены сами себе.', '2022-05-17 15:54:57'),
(5, 14, 1, 'Очень понравилась', '2022-05-17 16:09:39'),
(6, 15, 3, 'Хорошо... усыпляет', '2022-05-17 18:07:40');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) UNSIGNED NOT NULL,
  `photoURI` varchar(255) DEFAULT NULL,
  `bookId` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `photoURI`, `bookId`) VALUES
(1, 'img/Обложка книжки.jpg', 1),
(2, 'img/Оглавление1.jpg', 1),
(3, 'img/Оглавление2.jpg', 1),
(4, 'img/Война и мир.jpg', 3),
(5, 'img/Война и мир2.jpg', 3),
(6, 'img/после бала.jpg', 4),
(7, 'img/После бала 2.jpg', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `startFollowing` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `startFollowing`) VALUES
(1, 'Pavel', 'pavelputin2003@yandex.ru', 'd8578edf8458ce06fbc5bb76a58c5ca4', '2022-05-05 08:47:07'),
(10, 'pavel', 'putin@cs.vsu.ru', 'd6ca3fd0c3a3b462ff2b83436dda495e', '2022-05-16 15:04:04'),
(12, 'p', 'p@mail.ru', 'd6ca3fd0c3a3b462ff2b83436dda495e', '2022-05-17 15:54:03'),
(13, 'паша', 'mail@mail.ru', '81dc9bdb52d04dc20036dbd8313ed055', '2022-05-17 16:03:43'),
(14, 'Люда', 'ludmila@yandex.ru', 'd8578edf8458ce06fbc5bb76a58c5ca4', '2022-05-17 16:09:02'),
(15, 'Сашик', 'sachic@yandex.ru', '4a7d1ed414474e4033ac29ccb8653d9b', '2022-05-17 18:07:04');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorId` (`authorId`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`userId`),
  ADD KEY `comments_ibfk_2` (`bookId`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `photoURI` (`photoURI`),
  ADD KEY `photos_ibfk_1` (`bookId`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
