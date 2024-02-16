-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Lis 2023, 16:12
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `student_archive`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `majors`
--

CREATE TABLE `majors` (
  `id_major` int(11) NOT NULL,
  `major_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `majors`
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
  `displayed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`msg_id`, `out_msg_id`, `in_msg_id`, `msg_text`, `displayed`) VALUES
(1, 29, 8, 'siema', 1),
(2, 29, 8, 'co tam?', 1),
(3, 8, 29, 'Siemka, wyszystko gitarka', 1),
(4, 8, 29, 'A tam?', 1),
(5, 30, 29, 'Siemka', 1),
(6, 29, 30, 'co tam?', 1),
(7, 29, 30, 'siema', 1),
(8, 29, 30, 'co tam?', 1),
(9, 30, 29, 'ok', 1),
(10, 29, 30, 'spoko', 1),
(15, 29, 29, 'siema', 1),
(16, 29, 29, 'co tam', 1),
(17, 29, 2, 'siema', 1),
(18, 30, 29, 'siema', 1),
(19, 30, 29, 'co tam?\n', 1),
(20, 30, 29, 'siema\n', 1),
(21, 30, 29, 'co tam\n', 1),
(22, 30, 30, 'siema', 1),
(23, 29, 29, 'siema', 1),
(24, 30, 29, 'halo\n', 1),
(25, 30, 29, 'siema\n', 1),
(26, 30, 29, 'co tam', 1),
(27, 30, 29, 'siema', 1),
(28, 29, 30, 'halo', 1),
(29, 29, 30, 'halo', 1),
(30, 29, 30, 'siema', 1),
(31, 29, 30, 'halo', 1),
(32, 29, 30, 'halo', 1),
(33, 29, 30, 'asd', 1),
(34, 29, 30, 'as', 1),
(35, 29, 30, 'as', 1),
(36, 29, 30, 'halo', 1),
(37, 29, 30, 'halo', 1),
(38, 29, 30, 'halo', 1),
(39, 29, 30, 'halo', 1),
(40, 29, 30, 'halo', 1),
(41, 29, 30, 'halo', 1),
(42, 29, 30, 'halo', 1),
(43, 29, 30, 'halo', 1),
(44, 29, 30, 'raz', 1),
(45, 29, 30, 'raz', 1),
(46, 29, 30, 'asd', 1),
(47, 30, 29, 'siema', 1),
(48, 30, 29, 'siema', 1),
(49, 29, 30, 'siema', 1),
(50, 29, 30, 'halo', 1),
(51, 29, 30, 'halo', 1),
(52, 29, 30, 'co ta?\n', 1),
(53, 29, 30, 'halo', 1),
(54, 29, 30, 'halo', 1),
(55, 29, 30, 'halo', 1),
(56, 29, 30, 'raz', 1),
(57, 29, 30, 'dwa', 1),
(58, 30, 29, 'siema', 1),
(59, 30, 29, 'halko', 1),
(60, 30, 29, 'halo', 1),
(61, 30, 29, 'raz', 1),
(62, 30, 29, 'dwa', 1),
(63, 30, 29, 'raz', 1),
(64, 30, 29, 'raz', 1),
(65, 30, 29, 'dwa', 1),
(66, 30, 29, 'halo', 1),
(67, 30, 29, 'halo', 1),
(68, 29, 30, 'no siema', 1),
(69, 29, 30, 'klasa', 1),
(70, 30, 29, 'siemka', 0),
(71, 30, 29, 'co tam?\n', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `universities`
--

CREATE TABLE `universities` (
  `id_universities` int(11) NOT NULL,
  `name_univeristy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `universities`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
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
(30, NULL, NULL, '015f4785a878f7c64ab52d55f7e53bcf33602614b3234ea0a15d91403c014dac', 'dczech34@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 0);

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
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `folders`
--
ALTER TABLE `folders`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `majors`
--
ALTER TABLE `majors`
  MODIFY `id_major` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT dla tabeli `universities`
--
ALTER TABLE `universities`
  MODIFY `id_universities` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`folder_id`);

--
-- Ograniczenia dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`out_msg_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`in_msg_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`universities_id`) REFERENCES `universities` (`id_universities`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id_major`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
