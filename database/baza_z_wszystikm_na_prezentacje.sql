-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2023 at 06:17 PM
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
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `file_owner_id` int(11) NOT NULL,
  `file_name` varchar(50) NOT NULL,
  `comment_content` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `author_id`, `file_owner_id`, `file_name`, `comment_content`) VALUES
(1, 1, 1, '1', '1'),
(2, 37, 37, '30daysdraw.jpg', 'asd'),
(3, 37, 33, 'plik1.txt', 'asd'),
(10, 37, 33, 'Przechwytywanie.PNG', 'fvv'),
(11, 37, 33, 'Przechwytywanie.PNG', 'asdasdsa'),
(70, 37, 33, 'Przechwytywanie.PNG', '1'),
(78, 37, 33, 'plik1.txt', '12'),
(79, 37, 33, 'plik1.txt', '21'),
(80, 37, 33, 'plik1.txt', '21'),
(81, 37, 37, '30daysdraw.jpg', 'dasdasdsa'),
(82, 25, 25, 'student_archive (4).sql', 'dvfdsb');

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
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `out_msg_id` int(11) NOT NULL,
  `in_msg_id` int(11) NOT NULL,
  `msg_text` varchar(1000) NOT NULL,
  `displayed` int(11) NOT NULL,
  `file` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `out_msg_id`, `in_msg_id`, `msg_text`, `displayed`, `file`) VALUES
(1, 29, 8, 'siema', 1, 0),
(2, 29, 8, 'co tam?', 1, 0),
(3, 8, 29, 'Siemka, wyszystko gitarka', 1, 0),
(4, 8, 29, 'A tam?', 1, 0),
(5, 30, 29, 'Siemka', 1, 0),
(6, 29, 30, 'co tam?', 1, 0),
(7, 29, 30, 'siema', 1, 0),
(8, 29, 30, 'co tam?', 1, 0),
(9, 30, 29, 'ok', 1, 0),
(10, 29, 30, 'spoko', 1, 0),
(15, 29, 29, 'siema', 1, 0),
(16, 29, 29, 'co tam', 1, 0),
(17, 29, 2, 'siema', 1, 0),
(18, 30, 29, 'siema', 1, 0),
(19, 30, 29, 'co tam?\n', 1, 0),
(20, 30, 29, 'siema\n', 1, 0),
(21, 30, 29, 'co tam\n', 1, 0),
(22, 30, 30, 'siema', 1, 0),
(23, 29, 29, 'siema', 1, 0),
(24, 30, 29, 'halo\n', 1, 0),
(25, 30, 29, 'siema\n', 1, 0),
(26, 30, 29, 'co tam', 1, 0),
(27, 30, 29, 'siema', 1, 0),
(28, 29, 30, 'halo', 1, 0),
(29, 29, 30, 'halo', 1, 0),
(30, 29, 30, 'siema', 1, 0),
(31, 29, 30, 'halo', 1, 0),
(32, 29, 30, 'halo', 1, 0),
(33, 29, 30, 'asd', 1, 0),
(34, 29, 30, 'as', 1, 0),
(35, 29, 30, 'as', 1, 0),
(36, 29, 30, 'halo', 1, 0),
(37, 29, 30, 'halo', 1, 0),
(38, 29, 30, 'halo', 1, 0),
(39, 29, 30, 'halo', 1, 0),
(40, 29, 30, 'halo', 1, 0),
(41, 29, 30, 'halo', 1, 0),
(42, 29, 30, 'halo', 1, 0),
(43, 29, 30, 'halo', 1, 0),
(44, 29, 30, 'raz', 1, 0),
(45, 29, 30, 'raz', 1, 0),
(46, 29, 30, 'asd', 1, 0),
(47, 30, 29, 'siema', 1, 0),
(48, 30, 29, 'siema', 1, 0),
(49, 29, 30, 'siema', 1, 0),
(50, 29, 30, 'halo', 1, 0),
(51, 29, 30, 'halo', 1, 0),
(52, 29, 30, 'co ta?\n', 1, 0),
(53, 29, 30, 'halo', 1, 0),
(54, 29, 30, 'halo', 1, 0),
(55, 29, 30, 'halo', 1, 0),
(56, 29, 30, 'raz', 1, 0),
(57, 29, 30, 'dwa', 1, 0),
(58, 30, 29, 'siema', 1, 0),
(59, 30, 29, 'halko', 1, 0),
(60, 30, 29, 'halo', 1, 0),
(61, 30, 29, 'raz', 1, 0),
(62, 30, 29, 'dwa', 1, 0),
(63, 30, 29, 'raz', 1, 0),
(64, 30, 29, 'raz', 1, 0),
(65, 30, 29, 'dwa', 1, 0),
(66, 30, 29, 'halo', 1, 0),
(67, 30, 29, 'halo', 1, 0),
(68, 29, 30, 'no siema', 1, 0),
(69, 29, 30, 'klasa', 1, 0),
(70, 30, 29, 'siemka', 1, 0),
(71, 30, 29, 'co tam?\n', 1, 0),
(72, 29, 30, 'lab3_4.m', 1, 1),
(73, 29, 30, 'Lab3-4_Rafal_Barton.pdf', 1, 1),
(74, 29, 30, 'Lab3-4_Rafal_Barton.pdf', 1, 1),
(75, 29, 30, 'Lab3-4_Rafal_Barton.pdf', 1, 1),
(76, 29, 30, 'Lab3-4_Rafal_Barton.pdf', 1, 1),
(77, 29, 30, 'Lab3-4_Rafal_Barton.pdf', 1, 1),
(78, 29, 30, 'Lab3-4_Rafal_Barton.pdf', 1, 1),
(79, 29, 30, 'lab3_4.m', 1, 1),
(80, 29, 30, 'PA_DenisCzech_LAB3_4.doc', 1, 1),
(81, 29, 30, 'lab3_4.m', 1, 1),
(82, 29, 30, 'lab3_4.m', 1, 1),
(83, 29, 30, 'strzaleczka.txt', 1, 1),
(84, 29, 29, 'student_archive.sql', 1, 1),
(85, 30, 29, 'strzaleczka.txt', 1, 1),
(86, 29, 30, 'siemasz', 0, 0);

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
  `account_activation_hash` varchar(64) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_surname`, `user_password`, `user_email`, `major_id`, `user_register_date`, `user_account_activation`, `universities_id`, `reset_token_hash`, `reset_token_expires_at`, `account_activation_hash`, `status`) VALUES
(1, NULL, NULL, 'haslo', 'a@kob.com', 2, NULL, 0, 1, NULL, NULL, NULL, 0),
(2, 'Krystian', 'Mały', '123456', 'krycham@gmail.com', 4, '2023-11-07', 1, 2, NULL, NULL, NULL, 0),
(4, 'Adam', 'Lewy', '1234', 'lew@wp.pl', 5, '2023-11-09', 1, 2, NULL, NULL, NULL, 0),
(8, NULL, NULL, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'krzykrzy@wp.pl', NULL, NULL, 0, NULL, '25be5289989379ecd4d6a7ba5841a468301645a24cd544c3d201b35ffcf336f5', '2023-11-16 17:26:37', NULL, 0),
(25, NULL, NULL, 'e43924df6d062bbb500236e55604e585596b3f49acbcd50a7c35a43b840cabd8', 'bartosz.jurczyk154@gmail.com', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0),
(26, NULL, NULL, '181693d050b05bd67e980a04995c1fc57c331c0185052d97c6ed6ef7476fa17b', 'pis@pis.pis', NULL, NULL, 0, NULL, NULL, NULL, '44d6961a44896f35b86c52e78a2eac6f59591ef9c2d14b1298b6979622ccaf6b', 0),
(27, NULL, NULL, 'f40da9508ad7111fb893a6002376ad2db7cf130037e0b952fad33f7322d8b5ea', 'abc@abc.abc', NULL, NULL, 0, NULL, NULL, NULL, 'a97b54c05e49d8a944657340a3060e2b555a0b2b224f6709bcaa1f572e112e5d', 0),
(28, 'Admin', 'Admin', '', 'a@m.com', 1, NULL, 1, 1, NULL, NULL, '0441f97a6d7c0a023a65a71a50adc60b08b1cbb9e9cb3c43772e97b086a6bb11', 0),
(29, 'Denis', 'Czech', '4a11b14422b5f6e42f2cc6e6deff35aec0d5ce35f9da15bb64556d01fa738641', 'd39052964@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 0),
(30, 'Denis', 'Czech', '015f4785a878f7c64ab52d55f7e53bcf33602614b3234ea0a15d91403c014dac', 'dczech34@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 0),
(33, 'Rafał', 'Bartoń', '654475b9eef0ee645549340ae365bad7be41c1a693aaaa53a26811682763cdb0', 'polska69kaszanka@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 0),
(35, NULL, NULL, '654475b9eef0ee645549340ae365bad7be41c1a693aaaa53a26811682763cdb0', 'rafalbarton787@wp.pl', 1, NULL, 1, NULL, NULL, NULL, NULL, 0),
(37, 'asdasfa', NULL, '0ae05f002841cb119f3d1ad150c57c10dabaa64b9e30b02401787e87f00e6239', 'hbrzakowski@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `views`
--

CREATE TABLE `views` (
  `view_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `viewer_id` int(11) NOT NULL,
  `view_date` datetime NOT NULL,
  `seen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`view_id`, `user_id`, `viewer_id`, `view_date`, `seen`) VALUES
(39, 37, 33, '2023-12-17 18:08:43', 1),
(40, 37, 25, '2023-12-17 18:15:20', 1),
(41, 25, 37, '2023-12-17 18:13:53', 0),
(42, 25, 33, '2023-12-17 18:14:24', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgloszenia`
--

CREATE TABLE `zgloszenia` (
  `zgloszenie_id` int(11) NOT NULL,
  `plik` varchar(255) NOT NULL,
  `sciezka` text NOT NULL,
  `id_wlascicela` int(11) NOT NULL,
  `id_zglaszajacego` int(11) NOT NULL,
  `wiadomosc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zgloszenia`
--

INSERT INTO `zgloszenia` (`zgloszenie_id`, `plik`, `sciezka`, `id_wlascicela`, `id_zglaszajacego`, `wiadomosc`) VALUES
(5, 'plik1.txt', 'users/33/Semestr 1/siema/public/plik1.txt', 33, 34, 'Test wiadomosci zgłoszenia'),
(6, 'Przechwytywanie.PNG', 'users/33/Semestr 1/Przedmiot Grafika/public/Przechwytywanie.PNG', 33, 35, 'Nie fajne zdjecie');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

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
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `out_msg_id` (`out_msg_id`,`in_msg_id`),
  ADD KEY `in_msg_id` (`in_msg_id`);

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
-- Indeksy dla tabeli `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`view_id`),
  ADD UNIQUE KEY `unique_view` (`user_id`,`viewer_id`,`view_date`),
  ADD KEY `viewer_id` (`viewer_id`);

--
-- Indeksy dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  ADD PRIMARY KEY (`zgloszenie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id_universities` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `zgloszenia`
--
ALTER TABLE `zgloszenia`
  MODIFY `zgloszenie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`file_owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`folder_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`out_msg_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`in_msg_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`universities_id`) REFERENCES `universities` (`id_universities`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id_major`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`viewer_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
