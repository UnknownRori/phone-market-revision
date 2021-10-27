-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2021 at 12:09 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone-market-revision`
--

-- --------------------------------------------------------

--
-- Table structure for table `buy_history`
--

CREATE TABLE `buy_history` (
  `id` int(11) NOT NULL,
  `usersid` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_requested` int(11) NOT NULL,
  `buy_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `vendor_read_status` tinyint(1) NOT NULL,
  `delivery_product_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buy_history`
--

INSERT INTO `buy_history` (`id`, `usersid`, `product_id`, `total_requested`, `buy_timestamp`, `delivery_timestamp`, `vendor_read_status`, `delivery_product_status`) VALUES
(3, 1, 2, 5, '2021-08-27 06:25:17', '2021-08-27 06:25:17', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feature`
--

CREATE TABLE `feature` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feature_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feature`
--

INSERT INTO `feature` (`id`, `product_id`, `feature_name`) VALUES
(1, 12, 'Can Selfie'),
(2, 12, 'Water Proof');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `fromuser` int(11) NOT NULL,
  `touser` int(11) NOT NULL,
  `notificationtype` int(11) NOT NULL,
  `topic` varchar(128) NOT NULL,
  `content` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `fromuser`, `touser`, `notificationtype`, `topic`, `content`) VALUES
(7, 1, 9, 1, 'catpitalism', 'test'),
(8, 1, 4, 2, '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'),
(17, 1, 4, 1, 'catspitalism', '123123123'),
(18, 9, 1, 1, 'Reported UsersCats', 'This users is doing wrong way'),
(19, 9, 10, 1, 'Reported UsersCats', 'This users is doing wrong way'),
(20, 9, 1, 1, 'Reported Users&nbspCats', 'This users is doing wrong way'),
(21, 9, 10, 1, 'Reported Users&nbspCats', 'This users is doing wrong way'),
(22, 9, 1, 1, 'Reported Users Cats', 'This users is doing wrong way'),
(23, 9, 10, 1, 'Reported Users Cats', 'This users is doing wrong way');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(32) NOT NULL,
  `photo_name` varchar(36) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `warned_status` tinyint(1) NOT NULL,
  `keyword` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `user_id`, `product_name`, `photo_name`, `price`, `stock`, `description`, `warned_status`, `keyword`) VALUES
(2, 4, 'No Phone Air', 'No Phone Air.png', 0, 0, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam doloremque numquam autem enim quia\r\nexplicabo, quisquam illo eius illum laborum minus maiores! Corrupti non ullam aspernatur neque impedit natus culpa! Lorem ipsum dolor sit amet consectetur, a', 1, 'Phone, Nothing'),
(12, 1, 'No Phone Selfie', 'No Phone Selfie.png', 1000000, 5, 'urraaa', 0, ''),
(13, 1, 'No Phone Employee ', 'No Phone Employee Pack.png', 4000000, 1, 'The no phone employee pack\r\n', 0, ''),
(14, 1, 'No Phone', 'No Phone.png', 50000, 10, '', 0, ''),
(15, 4, '123', 'No Phone Family Pack.png', 50, 1, '', 1, ''),
(21, 4, 'aaaaaaaaaaaaaaaaaa', 'No Phone.png', 2, 0, '', 0, ''),
(22, 4, 'E', '', 1, 0, '', 0, ''),
(23, 4, 'U', '', 1, 0, '', 0, ''),
(24, 4, 'ree', '', 11, 0, '', 0, ''),
(26, 4, '<script>alert(\'Cat\')</script>', '', 2, 0, '', 0, ''),
(27, 4, 'ret', 'No Phone Employee Pack.png', 123, 1, '', 0, ''),
(28, 1, '44444', 'No Phone Employee Pack.png', 222, 444, '111', 0, ''),
(29, 4, 'Catpitalism HO', '', 150, 5, '12', 0, ''),
(30, 4, 'test123', '', 12, 12, 'test', 0, ''),
(32, 1, 'sqltest', '', 1231, 21231, '', 0, ''),
(33, 1, 'No Phone 2', 'nophone2.png', 1234, 1234, '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `review_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` int(11) NOT NULL,
  `review_at_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `star_review` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `type_notification`
--

CREATE TABLE `type_notification` (
  `id` int(11) NOT NULL,
  `notification_name` varchar(36) NOT NULL,
  `type` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_notification`
--

INSERT INTO `type_notification` (`id`, `notification_name`, `type`) VALUES
(1, 'Information', 'information'),
(2, 'Message', 'message'),
(3, 'Warning', 'warning'),
(4, 'Last Warning', 'last-warning');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `vendor` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `super_admin` tinyint(1) NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `warned` tinyint(1) NOT NULL,
  `reported` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `create_time`, `last_login`, `vendor`, `admin`, `super_admin`, `bio`, `warned`, `reported`) VALUES
(1, 'UnknownRori', '$2y$10$N8M0JUrDlDr2n80ETWd.A.Weuo4OY22zNgECBVmBIFHr5C/Q7nrES', '2021-10-15 22:42:21', '2021-10-27 21:46:34', 1, 1, 1, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam doloremque numquam autem enim quia\r\nexplicabo, quisquam illo eius illum laborum minus maiores! Corrupti non ullam aspernatur neque impedit natus culpa! Lorem ipsum dolor sit amet consectetur, a', 0, 0),
(4, 'Akashi', '$2y$10$LNO80hUeVGfliaZwWupIU.kFDoMZAripFQ7R.mysKAInOSnBExUEu', '2021-10-15 22:42:21', '2021-10-26 23:32:54', 1, 0, 0, NULL, 0, 0),
(9, 'Admin', '$2y$10$hpoZo.aFIF84Anu.6w4CwuSj3T9w4gB7oMF64Mbg4Ug91VyNwxySa', '2021-10-15 22:42:21', '2021-10-27 21:46:54', 0, 1, 0, NULL, 0, 0),
(10, '<script>alert(\"cats\");</script>', '$2y$10$/AaYuOfeljJjqArU4a0AQeRp6XNiKhe4W.04./HBrvIA44ENPnVXS', '2021-10-15 22:42:21', '2021-10-15 22:42:21', 1, 1, 1, NULL, 0, 0),
(11, 'Kawaiikaze', '$2y$10$I3PVxR/cKo8BVBjiRQ01NuQ8dJt5p3R8r/GUIas/o2sTjAn8kVHSW', '2021-10-15 22:49:02', '2021-10-15 22:49:02', 0, 0, 0, NULL, 0, 0),
(12, 'q', '$2y$10$G/48JoFO0WB6jkXuqFNaQuSZNIZK.ccuyV7/5rQdG6LohhqIETJ0u', '2021-10-15 22:56:07', '2021-10-21 01:12:36', 0, 0, 0, NULL, 1, 0),
(13, 'Cats', '$2y$10$3duejlTmVqmzXkxOi6gxuuO0uvpKLVEOx0YGTsoPGbWFsVfCRzuw2', '2021-10-20 10:05:46', '2021-10-22 10:13:50', 0, 0, 0, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `view_history`
--

CREATE TABLE `view_history` (
  `id` int(11) NOT NULL,
  `view_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buy_history`
--
ALTER TABLE `buy_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_request` (`product_id`),
  ADD KEY `users_request` (`usersid`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`product_id`),
  ADD KEY `user_id` (`users_id`);

--
-- Indexes for table `feature`
--
ALTER TABLE `feature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_sent` (`fromuser`),
  ADD KEY `users_receive` (`touser`),
  ADD KEY `type` (`notificationtype`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `users_id` (`user_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `type_notification`
--
ALTER TABLE `type_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `view_history`
--
ALTER TABLE `view_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product_id`),
  ADD KEY `users` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buy_history`
--
ALTER TABLE `buy_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feature`
--
ALTER TABLE `feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_notification`
--
ALTER TABLE `type_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `view_history`
--
ALTER TABLE `view_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buy_history`
--
ALTER TABLE `buy_history`
  ADD CONSTRAINT `product_request` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_request` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `products_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feature`
--
ALTER TABLE `feature`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `type` FOREIGN KEY (`notificationtype`) REFERENCES `type_notification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_receive` FOREIGN KEY (`touser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_sent` FOREIGN KEY (`fromuser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_reviewed_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_reviewed_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `view_history`
--
ALTER TABLE `view_history`
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
