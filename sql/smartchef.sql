-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 03:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartchef`
--

-- --------------------------------------------------------

--
-- Table structure for table `recetts`
--

CREATE TABLE `recetts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ingredients` text NOT NULL,
  `preparation` text NOT NULL,
  `preparation_time` int(11) NOT NULL,
  `cooking_time` int(11) NOT NULL,
  `servings` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recetts`
--

INSERT INTO `recetts` (`id`, `name`, `ingredients`, `preparation`, `preparation_time`, `cooking_time`, `servings`, `image_path`, `user_id`, `created_at`, `cat`) VALUES
(8, 'Pâtes Carbonara', '200 g de pâtes (spaghetti de préférence)\r\n\r\n100 g de pancetta ou de lardons fumés\r\n\r\n2 gros œufs (ou 3 jaunes d\'œuf pour une texture plus onctueuse)\r\n\r\n40 g de parmesan râpé (et un peu plus pour servir)\r\n\r\n1 gousse d’ail (facultatif)\r\n\r\nPoivre noir fraîchement moulu\r\n\r\nSel', 'Faire cuire les pâtes :\r\n\r\nDans une grande casserole, porter de l’eau salée à ébullition.\r\n\r\nAjouter les pâtes et les cuire al dente (environ 1 minute de moins que le temps indiqué sur le paquet).\r\n\r\nPréparer la sauce :\r\n\r\nDans un bol, battre les œufs avec le parmesan râpé et une bonne pincée de poivre.\r\n\r\nCuire les lardons :\r\n\r\nDans une poêle à feu moyen, faire revenir les lardons (et l’ail écrasé si utilisé) jusqu’à ce qu’ils soient croustillants. Retirer l’ail.\r\n\r\nÉteindre le feu et laisser tiédir 1 minute.\r\n\r\nMonter la carbonara :\r\n\r\nÉgoutter les pâtes en gardant un peu d’eau de cuisson.\r\n\r\nAjouter les pâtes dans la poêle avec les lardons.\r\n\r\nHors du feu, verser la préparation aux œufs en mélangeant rapidement pour créer une sauce crémeuse (ajouter un peu d’eau de cuisson si nécessaire).', 30, 10, 9, 'uploads/680cda63ed1da_#carbonara #pates.jpeg', 2, '2025-04-26 13:06:43', 'Salé');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nom`, `mail`, `pass`) VALUES
(2, 'MALEKFHIMA', 'malekfhima1@gmail.com', '$2y$10$lni8rgh9YaJVPWCxi7UKuOiGu6YXypKF094qc3/0dqM41v2SnuyPK'),
(3, 'mariem', 'mariem@gmail.com', '$2y$10$L7iD6dIvD6eHaAKP0enHfuEAA4bvFV2Ney7qVM0SoET1wEk16J0LG'),
(4, 'mohamed', 'mohamed@gmail.com', '$2y$10$tK3uz6Pa4N/pli0DVi7eHuqiTkBGqLMoJKAvjtk4hIMZwOKHwWY6q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recetts`
--
ALTER TABLE `recetts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recetts`
--
ALTER TABLE `recetts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recetts`
--
ALTER TABLE `recetts`
  ADD CONSTRAINT `recetts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
