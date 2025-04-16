-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 02:15 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recetts`
--

INSERT INTO `recetts` (`id`, `name`, `ingredients`, `preparation`, `preparation_time`, `cooking_time`, `servings`, `image_path`, `user_id`, `created_at`) VALUES
(5, 'fa9ous', '1kg fa9ous', 'tlifha bi sac w thotha fi tizik ', 25, 1, 1, 'uploads/67ff76fa06f14_Capture d\'écran 2025-04-02 002724.png', 2, '2025-04-16 09:23:06'),
(7, 'makarouna', 'djej\r\nbsal\r\nmii\r\n', 'fgkklfgikfd:;llimbkj;', 22, 2, 4, 'uploads/67ff85979f735_Capture d\'écran 2025-04-11 104221.png', 2, '2025-04-16 10:25:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
