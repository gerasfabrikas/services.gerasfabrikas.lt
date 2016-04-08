SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci COMMENT='Categories for tasks';

INSERT INTO `category` (`id`, `reference`, `name`) VALUES
(1, 'gerasfabrikas:programming', 'Programavimas'),
(2, 'gerasfabrikas:infrastructure', 'Infrastruktūra'),
(3, 'gerasfabrikas:content', 'Turinio valdymas'),
(4, 'gerasfabrikas:other', 'Kita');

CREATE TABLE `company` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

INSERT INTO `company` (`id`, `name`) VALUES
(1, 'UAB "Estina"'),
(2, '"Baltosios pirštinės"');

CREATE TABLE `company_stats_by_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `hours` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

CREATE TABLE `company_stats_by_project` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `hours` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

CREATE TABLE `project` (
  `id` int(10) UNSIGNED NOT NULL,
  `phid` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

CREATE TABLE `task` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `phid` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `project` varchar(64) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `author` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `owner` varchar(64) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `status` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `description` text COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `hours` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `date_created` int(10) UNSIGNED NOT NULL,
  `date_modified` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `phid` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `real_name` varchar(128) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

CREATE TABLE `user_stats_by_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hours` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

CREATE TABLE `user_stats_by_project` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hours` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;


ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `company_stats_by_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `company_stats_by_project`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phid` (`phid`);

ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phid` (`phid`);

ALTER TABLE `user_stats_by_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_stats_by_project`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `company`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `company_stats_by_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `company_stats_by_project`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `project`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `task`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_stats_by_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_stats_by_project`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
