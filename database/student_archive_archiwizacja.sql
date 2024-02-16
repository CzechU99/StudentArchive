-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Sty 2024, 18:07
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

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
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`comment_id`, `author_id`, `file_owner_id`, `file_name`, `comment_content`) VALUES
(1, 1, 1, '1', '1'),
(2, 37, 37, '30daysdraw.jpg', 'asd'),
(81, 37, 37, '30daysdraw.jpg', 'dasdasdsa');

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
  `displayed` int(11) NOT NULL,
  `file` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`msg_id`, `out_msg_id`, `in_msg_id`, `msg_text`, `displayed`, `file`) VALUES
(22, 30, 30, 'siema', 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `universities`
--

CREATE TABLE `universities` (
  `id_universities` int(11) NOT NULL,
  `name_univeristy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` int(11) NOT NULL,
  `is_account_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_surname`, `user_password`, `user_email`, `major_id`, `user_register_date`, `user_account_activation`, `universities_id`, `reset_token_hash`, `reset_token_expires_at`, `account_activation_hash`, `status`, `is_account_archived`) VALUES
(1, NULL, NULL, 'haslo', 'a@kob.com', 2, NULL, 0, 1, NULL, NULL, NULL, 0, 0),
(2, 'Krystian', 'Mały', '123456', 'krycham@gmail.com', 4, '2023-11-07', 1, 2, NULL, NULL, NULL, 0, 0),
(4, 'Adam', 'Lewy', '1234', 'lew@wp.pl', 5, '2023-11-09', 1, 2, NULL, NULL, NULL, 0, 0),
(8, NULL, NULL, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'krzykrzy@wp.pl', NULL, NULL, 0, NULL, '25be5289989379ecd4d6a7ba5841a468301645a24cd544c3d201b35ffcf336f5', '2023-11-16 17:26:37', NULL, 0, 0),
(25, 'Bartosz', 'Jurczyk', 'e43924df6d062bbb500236e55604e585596b3f49acbcd50a7c35a43b840cabd8', 'bartosz.jurczyk154@gmail.com', 1, NULL, 1, 1, '0151f6be48e09a482d1b88648dadd9b534f3fed84ad7f52d5b1e1303488231a8', '2024-01-06 15:49:32', '5c24ea0f6e53c9ad3fac21dea9b01c466755959b208ca38decd52a669330db3f', 0, 0),
(27, NULL, NULL, 'f40da9508ad7111fb893a6002376ad2db7cf130037e0b952fad33f7322d8b5ea', 'abc@abc.abc', NULL, NULL, 0, NULL, NULL, NULL, 'a97b54c05e49d8a944657340a3060e2b555a0b2b224f6709bcaa1f572e112e5d', 0, 0),
(28, 'Admin', 'Admin', '', 'a@m.com', 1, NULL, 1, 1, NULL, NULL, '0441f97a6d7c0a023a65a71a50adc60b08b1cbb9e9cb3c43772e97b086a6bb11', 0, 0),
(30, 'Denis', 'Czech', '015f4785a878f7c64ab52d55f7e53bcf33602614b3234ea0a15d91403c014dac', 'dczech34@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 0, 0),
(35, NULL, NULL, '654475b9eef0ee645549340ae365bad7be41c1a693aaaa53a26811682763cdb0', 'rafalbarton787@wp.pl', 1, NULL, 1, NULL, NULL, NULL, NULL, 0, 0),
(37, 'asdasfa', NULL, '0ae05f002841cb119f3d1ad150c57c10dabaa64b9e30b02401787e87f00e6239', 'hbrzakowski@gmail.com', 1, NULL, 1, 1, NULL, NULL, NULL, 0, 0),
(39, NULL, NULL, '8bb119efa3a02ce0793a5b97026e7ccb4d9b238cc6788c5c68aaeba935af85fa', 'agata@agata.agata', NULL, NULL, 0, NULL, NULL, NULL, '4bb182dcca8f8bee6f55eb21abe78c5bc95b49ef9b9f4719fe01eb37f0e3c2b0', 0, 0);

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
-- Zrzut danych tabeli `views`
--

INSERT INTO `views` (`view_id`, `user_id`, `viewer_id`, `view_date`, `seen`) VALUES
(52, 25, 30, '2024-01-03 16:06:09', 1);

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
-- Zrzut danych tabeli `zgloszenia`
--

INSERT INTO `zgloszenia` (`zgloszenie_id`, `plik`, `sciezka`, `id_wlascicela`, `id_zglaszajacego`, `wiadomosc`) VALUES
(5, 'plik1.txt', 'users/33/Semestr 1/siema/public/plik1.txt', 33, 34, 'Test wiadomosci zgłoszenia'),
(7, 'plik1.txt', 'users/33/Semestr 1/Przedmiot Grafika/public/plik1.txt', 33, 25, 'chuj');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments_ibfk_1` (`author_id`),
  ADD KEY `comments_ibfk_2` (`file_owner_id`);

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
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT dla tabeli `universities`
--
ALTER TABLE `universities`
  MODIFY `id_universities` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT dla tabeli `views`
--
ALTER TABLE `views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  MODIFY `zgloszenie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`file_owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Ograniczenia dla tabeli `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`viewer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
