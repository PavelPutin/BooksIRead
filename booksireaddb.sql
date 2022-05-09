-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2022 at 09:22 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booksireaddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `surname` varchar(80) NOT NULL,
  `patronymic` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `surname`, `patronymic`) VALUES
(1, 'Сергей', 'Виноградов', 'Николаевич'),
(2, 'Лев', 'Толстой', 'Николаевич');

-- --------------------------------------------------------

--
-- Table structure for table `books`
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
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `authorId`, `description`, `rating`, `dateStartReading`, `dateFinishReading`, `edition`, `yearEdition`, `publishingHouse`, `review`) VALUES
(1, 'Логика', 1, 'Это учебник логики. По нему учились в СССР', 5, '2022-05-01', NULL, '8-е издание', '2021', 'Концептуал', 'Книга очень понравилась. Советую к прочтению'),
(3, 'Война и мир', 2, 'Великий роман Льва Николаевича Толстого, повествующий о событиях Отечественной войны 1812 года.', 5, '2022-03-01', '2022-05-04', NULL, '1867', NULL, 'Роман очень подробно описывает события начала 19го века. Всем интересующимся этой эпохой обязательно к прочтению.'),
(4, 'После бала', 2, 'Происходит спор о том, что определяет человеческую судьбу.', 4, '2021-10-12', '2022-02-08', NULL, '1911', NULL, 'Книга понравилась, но не мой жанр.');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `userId` int(11) UNSIGNED NOT NULL,
  `bookId` int(11) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `dateTime` datetime NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `dislikes` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) UNSIGNED NOT NULL,
  `photoURI` varchar(255) DEFAULT NULL,
  `bookId` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `startFollowing` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `startFollowing`) VALUES
(1, 'Pavel', 'pavelputin2003@yandex.ru', 'd8578edf8458ce06fbc5bb76a58c5ca4', '2022-05-05 08:47:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorId` (`authorId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`userId`),
  ADD KEY `comments_ibfk_2` (`bookId`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `photoURI` (`photoURI`),
  ADD KEY `photos_ibfk_1` (`bookId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
