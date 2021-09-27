-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2021 at 12:26 AM
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
(3, 1, 2, 5, '2021-08-27 06:25:17', '2021-08-27 06:25:17', 0, 0),
(4, 1, 6, 2, '2021-08-27 06:38:41', '2021-08-27 06:38:41', 0, 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `fromuser` int(11) NOT NULL,
  `touser` int(11) NOT NULL,
  `notificationtype` varchar(64) NOT NULL,
  `topic` varchar(128) NOT NULL,
  `content` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `fromuser`, `touser`, `notificationtype`, `topic`, `content`) VALUES
(1, 8, 4, 'info', 'testing notification', 'test 123 ');

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
  `description` varchar(144) NOT NULL,
  `warned_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `user_id`, `product_name`, `photo_name`, `price`, `stock`, `description`, `warned_status`) VALUES
(2, 4, 'No Phone Air', 'No Phone Air.png', 0, 0, 'default', 0),
(3, 4, 'A', '', 0, 0, 'default', 1),
(5, 4, 'Q', '', 0, 0, 'default', 0),
(6, 4, 'asd', '', 1, 1, 'as', 0),
(12, 1, 'No Phone Selfie', 'No Phone Selfie.png', 1000000, 5, 'urraaa', 0),
(13, 1, 'No Phone Employee ', 'No Phone Employee Pack.png', 4000000, 1, 'The no phone employee pack\r\n', 0),
(14, 1, 'No Phone', 'No Phone.png', 50000, 10, '', 0),
(15, 4, '123', 'No Phone Family Pack.png', 50, 1, '', 0),
(17, 8, 'row[\'stock\']//', '', 2, 5000, 'r', 0),
(18, 8, 'cat', '', 2, 0, '', 0),
(19, 8, '123123123123', '', 1231231, 1111, '', 0),
(20, 4, 'catpitalism', 'No Phone Air.png', 50000, 0, '', 0),
(21, 4, 'aaaaaaaaaaaaaaaaaa', 'No Phone.png', 2, 0, '', 0),
(22, 4, 'E', '', 1, 0, '', 0),
(23, 4, 'U', '', 1, 0, '', 0),
(24, 4, 'ree', '', 11, 0, '', 0),
(26, 4, '<script>alert(\'Cat\')</script>', '', 2, 0, '', 0),
(27, 4, 'ret', 'No Phone Employee Pack.png', 123, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `vendor` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `admin`, `vendor`) VALUES
(1, 'UnknownRori', '$2y$10$IljSgc5IKyNG1guC5LefRepHfr7tkrsw.IcDrqSHEV62Y.b6HwgRa', 1, 1),
(4, 'Akashi', '$2y$10$ysoqrHnWjfUFMm/V.U7Zr.oeqDdzjTTutAdLa4d6hx.dAfylONZCG', 0, 1),
(5, 'a', '$2y$10$sCVIA3UqHGsQSUgO/f890e5g5qZiIQavAptp0/2twIFNDnqfsvi72', 0, 0),
(6, 'w', '$2y$10$z0d2EyTwZn.ziCC24g2CDO3FoxYUxgdPluMwGq15qpQVM3O74Lj5S', 0, 0),
(7, 'q', '$2y$10$yT7byvvZTl6yftvuB1NVeehp9BBthsU.bfzq4jimYOG0kfNzrKV1S', 0, 0),
(8, 'Super Admin', '$2y$10$RiVy5FYUPeoH.OlSk7Ozb.lTRngTbSzCmnhOOsJ5kDZLrjbCmIFW6', 1, 1);

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
  ADD KEY `users_receive` (`touser`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `users_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `users_receive` FOREIGN KEY (`touser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_sent` FOREIGN KEY (`fromuser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
