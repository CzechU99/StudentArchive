-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 18, 2023 at 09:52 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_archive`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `folders`
--

CREATE TABLE `folders` (
  `folder_id` int(11) NOT NULL,
  `folder_name` varchar(100) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `majors`
--

CREATE TABLE `majors` (
  `id_major` int(11) NOT NULL,
  `major_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id_major`, `major_name`) VALUES
(1, 'Informatyka'),
(2, 'Muzyka'),
(3, 'Mechanika'),
(4, 'Fizyka'),
(5, 'Matematyka'),
(6, 'Architektura');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `universities`
--

CREATE TABLE `universities` (
  `id_universities` int(11) NOT NULL,
  `name_univeristy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id_universities`, `name_univeristy`) VALUES
(1, 'Politechnika Opolska'),
(2, 'Politechnika Wrocławska');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_surname` varchar(50) DEFAULT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `major_id` int(100) DEFAULT NULL,
  `user_register_date` date DEFAULT NULL,
  `user_account_activation` tinyint(1) NOT NULL DEFAULT 0,
  `universities_id` int(11) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `account_activation_hash` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_surname`, `user_password`, `user_email`, `major_id`, `user_register_date`, `user_account_activation`, `universities_id`, `reset_token_hash`, `reset_token_expires_at`, `account_activation_hash`) VALUES
(1, NULL, NULL, 'haslo', 'a@kob.com', 2, NULL, 0, 1, NULL, NULL, NULL),
(2, 'Krystian', 'Mały', '123456', 'krycham@gmail.com', 4, '2023-11-07', 1, 2, NULL, NULL, NULL),
(4, 'Adam', 'Lewy', '1234', 'lew@wp.pl', 5, '2023-11-09', 1, 2, NULL, NULL, NULL),
(8, NULL, NULL, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'krzykrzy@wp.pl', NULL, NULL, 0, NULL, '25be5289989379ecd4d6a7ba5841a468301645a24cd544c3d201b35ffcf336f5', '2023-11-16 17:26:37', NULL),
(25, NULL, NULL, 'e43924df6d062bbb500236e55604e585596b3f49acbcd50a7c35a43b840cabd8', 'bartosz.jurczyk154@gmail.com', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(26, NULL, NULL, '181693d050b05bd67e980a04995c1fc57c331c0185052d97c6ed6ef7476fa17b', 'pis@pis.pis', NULL, NULL, 0, NULL, NULL, NULL, '44d6961a44896f35b86c52e78a2eac6f59591ef9c2d14b1298b6979622ccaf6b'),
(27, NULL, NULL, 'f40da9508ad7111fb893a6002376ad2db7cf130037e0b952fad33f7322d8b5ea', 'abc@abc.abc', NULL, NULL, 0, NULL, NULL, NULL, 'a97b54c05e49d8a944657340a3060e2b555a0b2b224f6709bcaa1f572e112e5d'),
(28, 'Admin', 'Admin', '', 'a@m.com', 1, NULL, 1, 1, NULL, NULL, '0441f97a6d7c0a023a65a71a50adc60b08b1cbb9e9cb3c43772e97b086a6bb11');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `folder_id` (`folder_id`);

--
-- Indeksy dla tabeli `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`folder_id`),
  ADD KEY `major_id` (`major_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indeksy dla tabeli `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id_major`);

--
-- Indeksy dla tabeli `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id_universities`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD UNIQUE KEY `account_activation_hash` (`account_activation_hash`),
  ADD KEY `cos` (`universities_id`),
  ADD KEY `major_id` (`major_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id_major` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id_universities` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`folder_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`universities_id`) REFERENCES `universities` (`id_universities`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id_major`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
