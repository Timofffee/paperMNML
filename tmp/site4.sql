-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 29 2020 г., 15:14
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `site4`
--

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `post_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(80) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `publish_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`post_id`, `title`, `text`, `user_id`, `publish_date`) VALUES
(1, 'Тот самый первый пост', 'Кажется, это первый пост и он хорош. Да, он действительно очень хорош! Вы только посмотрите на то, сколько полезных вещей происходят в этот момент! Ещё буквально вчера я пил кофе с сахаром, а сегодня мне ужасно плохо, потому что я не спал неделю. Или спал? Это определенно останется загадкой для тех, кто будет читать этот текст.\r\n\r\nА что для начала? Давайте для начала я покажу вам котика:\r\n\r\n!img 2.png\r\n\r\nА знаете в чём ещё забава? Этот текст без редактора, который вот-вот появится у на сайте в ближайшее время. Почему? Потому что я только сейчас создал эту таблицу и пишу эту запись. И? И редактора ещё нет, а мне сдавать курсовую через неделю!\r\n\r\n!video umaruuu.mp4\r\n\r\nЗнаете зачем я всё это вам рассказываю? Да просто так! Мне просто надо забить место в поле ввода текста. Остроумно? Не думаю. Нормальный программист бы просто использовал Lorem ipsum. Я серьёзно. Если вы столкнётесь когда-нибудь с такой же проблемой, то ни при каком условии не пишите подобный текст вручную! \r\n\r\nЯ хотел добавить поддержку gif/webm, но я попросту не успеваю это сделать, поэтому вам придётся наслаждаться тем что я успею сделать. Простите. Я пытался. Возможно позже добавлю. \r\n\r\n!youtube 78S0ZTUbm00', 7, '2020-04-28 16:49:16'),
(2, 'Game Developer', 'Это моя маленькая история, как я писал первый настоящий пост.. ', 8, '2020-04-29 12:11:02');

-- --------------------------------------------------------

--
-- Структура таблицы `post_comment`
--

CREATE TABLE `post_comment` (
  `comment_id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `parrent_id` int(11) UNSIGNED DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post_comment`
--

INSERT INTO `post_comment` (`comment_id`, `post_id`, `user_id`, `text`, `parrent_id`, `date`) VALUES
(1, 1, 7, 'First comment', NULL, '2020-04-27 20:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tag`
--

INSERT INTO `tag` (`tag_id`, `name`) VALUES
(1, 'первый'),
(2, 'длиннопост'),
(4, 'game'),
(5, 'noice');

-- --------------------------------------------------------

--
-- Структура таблицы `tag_post_con`
--

CREATE TABLE `tag_post_con` (
  `tpc_id` int(11) UNSIGNED NOT NULL,
  `tag_id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tag_post_con`
--

INSERT INTO `tag_post_con` (`tpc_id`, `tag_id`, `post_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `login` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `role` tinyint(1) UNSIGNED DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `login`, `email`, `session_id`, `pass_hash`, `role`, `reg_date`, `avatar`) VALUES
(7, 'Admin123', 'timofffee@gmail.com', '7xxjEOEVzT7HZCZD95iyWf78s7M9IPVyJDIyV10HDqTAWQ1jZFADLJW8toCaLDnL', '$2y$10$qhu39jDkjx1qebBRY8QHHuFJlg4ibOgW4jd84SujzRO4OHSvF0SnK', 0, '2020-04-26 10:21:39', ''),
(8, 'Login123', 'timfffee@gmail.com', 'Mu4Rhl1U5s8HZ82v18lgo77bvqqDLbm8f11EeaOd7McbEqyVZZYBwyPIEv02jQ6u', '$2y$10$g09LoEQpm8gseW1XV4oprOzxHNGCiXxRaaxeCAg0BeScN4n50CaFq', 0, '2020-04-28 22:52:05', '/img/profile/8_J31daG.png');

-- --------------------------------------------------------

--
-- Структура таблицы `vote`
--

CREATE TABLE `vote` (
  `vote_id` int(11) UNSIGNED NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `where_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `positive` tinyint(1) UNSIGNED DEFAULT 1,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vote`
--

INSERT INTO `vote` (`vote_id`, `type`, `where_id`, `user_id`, `positive`, `date`) VALUES
(2, 0, 1, 7, 1, '2020-04-28 17:53:23'),
(3, 0, 1, 8, 1, '2020-04-29 08:43:41');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Индексы таблицы `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Индексы таблицы `tag_post_con`
--
ALTER TABLE `tag_post_con`
  ADD PRIMARY KEY (`tpc_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`vote_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tag_post_con`
--
ALTER TABLE `tag_post_con`
  MODIFY `tpc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `vote`
--
ALTER TABLE `vote`
  MODIFY `vote_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
