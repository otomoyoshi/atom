-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 9 月 04 日 06:31
-- サーバのバージョン： 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atom`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `aviation`
--

CREATE TABLE `aviation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `repaired` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `categories_l1`
--

CREATE TABLE `categories_l1` (
  `id` int(11) NOT NULL,
  `category_l1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `categories_l2`
--

CREATE TABLE `categories_l2` (
  `id` int(11) NOT NULL,
  `category_l2` varchar(255) NOT NULL,
  `category_l1_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `lists_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `item_check` tinyint(1) NOT NULL,
  `categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `lists`
--

CREATE TABLE `lists` (
  `id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `list_image_path` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` int(1) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `profiile_image_path` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `repaired` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `searched_words`
--

CREATE TABLE `searched_words` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `judge` tinyint(1) NOT NULL,
  `word_condition` varchar(255) DEFAULT NULL,
  `classify` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `repaired` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `searchs_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `searchs`
--

CREATE TABLE `searchs` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `judge` tinyint(1) NOT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `classify` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `repaired` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aviation_id` int(11) NOT NULL,
  `categoryies_l2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aviation`
--
ALTER TABLE `aviation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_l1`
--
ALTER TABLE `categories_l1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_l2`
--
ALTER TABLE `categories_l2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `searched_words`
--
ALTER TABLE `searched_words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `searchs`
--
ALTER TABLE `searchs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aviation`
--
ALTER TABLE `aviation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories_l1`
--
ALTER TABLE `categories_l1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories_l2`
--
ALTER TABLE `categories_l2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `searched_words`
--
ALTER TABLE `searched_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `searchs`
--
ALTER TABLE `searchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
