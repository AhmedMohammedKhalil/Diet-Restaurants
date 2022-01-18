-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2022 at 10:39 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diet_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `photo` text NOT NULL,
  `details` text NOT NULL,
  `price` double NOT NULL,
  `calories` double NOT NULL,
  `weight` double NOT NULL,
  `count_rating` double NOT NULL DEFAULT 0,
  `restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`, `photo`, `details`, `price`, `calories`, `weight`, `count_rating`, `restaurant_id`) VALUES
(2, 'meal', 'menu-13.jpg', 'details', 150, 15, 0.55, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `calories` double NOT NULL,
  `details` text NOT NULL,
  `count_rating` double NOT NULL DEFAULT 0,
  `photo` text DEFAULT NULL,
  `restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `calories`, `details`, `count_rating`, `photo`, `restaurant_id`) VALUES
(3, 'sswdsd', 55, 55, 'sdsdsd', 0, 'menu-13.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `package_meals`
--

CREATE TABLE `package_meals` (
  `id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package_meals`
--

INSERT INTO `package_meals` (`id`, `meal_id`, `package_id`) VALUES
(7, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `type`, `type_id`, `rating`, `user_id`) VALUES
(24, 'restaurant', 4, 3, 3),
(25, 'restaurant', 2, 1.4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `photo` text DEFAULT NULL,
  `description` text NOT NULL,
  `count_rating` double NOT NULL DEFAULT 0,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `email`, `phone`, `owner_name`, `photo`, `description`, `count_rating`, `password`) VALUES
(1, 'Qayssars', 'kuwait city', 'qayssar@gmail.com', '659321', 'Talal Aabed', 'res2.jpg', 'details about restaurants', 0, '$2y$10$/Nr6La57vBGmqbG.mhIglufVR/S37VYrNlHqjsTPFXCTisURwwmWS'),
(2, 'Fish Restaurant', 'kuwait city', 'adam@yahoo.com', '695124', 'adam abdalla', 'res2.jpg', 'details about restaurant', 1.4, '$2y$10$k2nRYafQFPxT7PmkEIh5VusBAG5WuEVQRQWgl48dQm78cW58peMtS'),
(3, 'erwrwer', 'sdfsdfds', 'a.m.k.y.2013@gmail.com', '123456', 'werewrewr', NULL, 'dsfdsfds', 0, '$2y$10$FQeRpD83hfj/KjXjYB71Fe1xUU0LoTudxzea.6r.3qhVzywOvVRMi'),
(4, 'asdas', 'adasdsad', 'a.m.k.ysdsa.2013@gmail.com', '123458', 'asdsad', NULL, 'asdasd', 3, '$2y$10$k2nRYafQFPxT7PmkEIh5VusBAG5WuEVQRQWgl48dQm78cW58peMtS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `photo` text DEFAULT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `address`, `password`) VALUES
(1, 'ahmed', 'amk@gmail.com', '8.jpg', 'kuwait city', '$2y$10$WEFE2xFUWjXtFBbpmbuhnOqtEBxEZoRZenitaGZZ1xnSh98DpTmba'),
(2, 'sds', 'a.m2013@gmail.com', NULL, 'sds', '$2y$10$VV68JAW0F/iz1e0D5DSNVOi/FNItgARH64Kz9r6zctVksR7ndQ786'),
(3, 'asdas', 'a.3@gmail.com', NULL, ';sld;sdl', '$2y$10$oOcdFM4ymAeed2iXLAV4GOTjOsBfHRdyqpjMdHhtxsCYEcxfAK5Vm');

-- --------------------------------------------------------

--
-- Table structure for table `user_meals`
--

CREATE TABLE `user_meals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_subscripes`
--

CREATE TABLE `user_subscripes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `start` varchar(50) NOT NULL,
  `end` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_subscripes`
--

INSERT INTO `user_subscripes` (`id`, `user_id`, `package_id`, `start`, `end`) VALUES
(5, 1, 3, '10/01/2022', '09/02/2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `package_meals`
--
ALTER TABLE `package_meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meal_id` (`meal_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_meals`
--
ALTER TABLE `user_meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meal_id` (`meal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_subscripes`
--
ALTER TABLE `user_subscripes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package_meals`
--
ALTER TABLE `package_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_meals`
--
ALTER TABLE `user_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_subscripes`
--
ALTER TABLE `user_subscripes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

--
-- Constraints for table `package_meals`
--
ALTER TABLE `package_meals`
  ADD CONSTRAINT `package_meals_ibfk_1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`),
  ADD CONSTRAINT `package_meals_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_meals`
--
ALTER TABLE `user_meals`
  ADD CONSTRAINT `user_meals_ibfk_1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`),
  ADD CONSTRAINT `user_meals_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_subscripes`
--
ALTER TABLE `user_subscripes`
  ADD CONSTRAINT `user_subscripes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_subscripes_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
