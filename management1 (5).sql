-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 19 2024 г., 10:32
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `management1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_task` int NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `id_user`, `id_task`, `content`, `created_at`, `updated_at`) VALUES
(1, 11, 13, 'fgh', '2024-10-31 05:45:20', '2024-10-31 05:45:20'),
(2, 11, 18, 'klj;/', '2024-11-02 01:14:47', '2024-11-02 01:14:47'),
(3, 11, 16, 'задача сделал', '2024-11-05 04:37:14', '2024-11-05 04:37:14'),
(4, 31, 23, 'Задача только начата, в нее вносятся корректировки', '2024-11-06 01:30:02', '2024-11-06 01:30:02');

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` enum('Создан','В процессе','Завершен') NOT NULL DEFAULT 'Создан',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `id_manager` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `date_start`, `date_end`, `status`, `created_at`, `updated_at`, `id_manager`) VALUES
(25, 'новый проект 2', 'описание нового проекта', '2024-10-25', '2024-11-09', 'Создан', '2024-10-28 04:09:01', '2024-11-05 04:20:57', 13),
(28, 'Проект новый9', 'описание нового проекта', '2024-11-08', '2024-11-28', 'Создан', '2024-11-05 03:42:08', '2024-11-05 04:21:16', 13),
(29, 'Проект новыйы', 'новый проект', '2024-11-03', '2024-11-29', 'Создан', '2024-11-05 03:43:18', '2024-11-05 04:21:12', 13),
(32, 'Проект новый5', 'ЫФВАЫАВ', '2024-11-21', '2024-11-22', 'Создан', '2024-11-06 04:28:02', '2024-11-06 04:28:02', 11),
(33, 'Проект manager', 'сделать проект для задач', '2024-11-01', '2024-12-08', 'Создан', '2024-11-06 01:30:58', '2024-11-06 01:30:58', 11);

-- --------------------------------------------------------

--
-- Структура таблицы `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `id_project` int NOT NULL,
  `date_start` date NOT NULL,
  `id_user` int NOT NULL,
  `statistics` json NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `id_project` int NOT NULL,
  `id_user` int NOT NULL,
  `priority` enum('Низкий','Средний','Высокий') NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` enum('Назначена','Выполняется','Завершена') NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `id_project`, `id_user`, `priority`, `date_start`, `date_end`, `status`, `created_at`, `updated_at`) VALUES
(13, 'ваы', 'аыва', 25, 11, 'Средний', '2024-10-01', '2024-10-10', 'Завершена', '2024-10-28 07:30:55', '2024-10-31 04:19:19'),
(16, 'уампв', 'пвпавапв', 25, 11, 'Низкий', '2024-10-02', '2024-10-29', 'Завершена', '2024-10-31 09:54:40', '2024-11-05 04:36:53'),
(17, 'уампв', 'пвпавапв', 25, 11, 'Низкий', '2024-10-02', '2024-10-29', 'Завершена', '2024-10-31 09:54:43', '2024-11-02 01:05:13'),
(18, 'уампв', 'пвпавапв', 25, 11, 'Низкий', '2024-10-02', '2024-10-29', 'Завершена', '2024-10-31 09:54:47', '2024-11-02 01:14:31'),
(19, 'уампв', 'пвпавапв', 25, 11, 'Низкий', '2024-10-02', '2024-10-29', 'Назначена', '2024-10-31 09:54:50', '2024-10-31 09:54:50'),
(23, 'НОВАЯ ЗАДАЧА', 'ВАЫВАЫВ', 32, 31, 'Низкий', '2024-11-21', '2024-11-22', 'Назначена', '2024-11-06 04:29:39', '2024-11-06 04:29:39');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','user','editor') NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(8, 'natalya', 'natalya1@mail.ru', 'admin', '$2y$10$xltVQa5AodhzuHX1l360EeDzCyN3Hrg0gSJb5cIXiGv1e0Yq1zUay', '2024-10-10 03:58:21', '2024-10-10 03:58:21'),
(11, 'natalya@mail.ru', 'natalya@mail.ru', 'editor', '$2y$10$W6g/uzcVK7nS/E.d.iyD0efGpw7QtMIAF3ItxxN629kVQ5jtnQCky', '2024-10-12 02:27:49', '2024-10-12 02:27:49'),
(13, 'миронова', 'mir@mail.ru', 'user', '$2y$10$oZGQT5L4qSGPueILgITBXexj3z6CExOu/qLmt1EUTl2EPyu/RArpi', '2024-10-16 08:33:00', '2024-10-16 09:45:40'),
(31, 'Татьяна', 'tany@mail.ru', 'user', '$2y$10$Y69r6r4NIXFU1DN3S1NqE.zFVZT1n/fqju/4r2Zzty1OocpwKB1bu', '2024-11-06 01:29:12', '2024-11-06 01:29:12');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`,`id_task`),
  ADD KEY `id_task` (`id_task`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_manager` (`id_manager`);

--
-- Индексы таблицы `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_project` (`id_project`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_project` (`id_project`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`id_manager`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
