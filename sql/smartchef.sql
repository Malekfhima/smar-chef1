-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 08:48 PM
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
  `cat` varchar(255) NOT NULL,
  `nb` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recetts`
--

INSERT INTO `recetts` (`id`, `name`, `ingredients`, `preparation`, `preparation_time`, `cooking_time`, `servings`, `image_path`, `user_id`, `created_at`, `cat`, `nb`) VALUES
(4, 'Pizza Margherita', 'Pâte à pizza\r\n\r\n150 g de mozzarella\r\n\r\n3 tomates\r\n\r\nBasilic, huile d’olive.', 'Étaler la pâte.\r\n\r\nAjouter les tomates en rondelles, la mozzarella.\r\n\r\nCuire à 220°C. Parsemer de basilic.', 20, 15, 4, 'uploads/681b8932a46b1_Pizza Margherita.jpeg', 2, '2025-05-07 16:24:18', 'salé', ''),
(7, 'Salade César', 'Laitue romaine\r\n\r\nCroûtons\r\n\r\nParmesan\r\n\r\nPoulet grillé\r\n\r\nSauce César.', 'Mélanger tous les ingrédients.\r\n\r\nArroser de sauce.', 15, 0, 4, 'uploads/681b8b81460d6_Salade César.jpeg', 2, '2025-05-07 16:34:09', 'salades', ''),
(8, 'Gratin Dauphinois', '1 kg de pommes de terre\r\n\r\n50 cl de crème\r\n\r\nAil, noix de muscade.', 'Couper les pommes de terre en rondelles.\r\n\r\nSuperposer avec crème et épices. Cuire à 180°C.', 20, 75, 6, 'uploads/681b8c5dd6d53_Gratin Dauphinois.jpeg', 2, '2025-05-07 16:37:49', 'gratins', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` enum('admin','utilisateur') NOT NULL DEFAULT 'utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nom`, `mail`, `pass`, `role`) VALUES
(2, 'MALEKFHIMA', 'malekfhima1@gmail.com', '$2y$10$lni8rgh9YaJVPWCxi7UKuOiGu6YXypKF094qc3/0dqM41v2SnuyPK', 'admin'),
(13, 'rania', 'rania@gmail.com', '$2y$12$L1RBcr4vNgOWeFpTEneRYu9dWwRd5j34Ii8MP97Dya5Jt8w.QJ2tC', 'utilisateur'),
(14, 'yassimn', 'yassmin@gmail.com', '$2y$12$bXClqI6WCwppVAtBlbN5u.1TeBdNntjRTawP862zo9YHZU1V7eH0q', 'utilisateur'),
(18, 'rahma', 'rahma@gmail.com', '$2y$12$xi1nq0QACbfd0GUCSM0dhOYAP.3nfi99ZtdT8FCzeect1KDZ5KR3a', 'utilisateur');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
