-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2022 at 08:57 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`) VALUES
(4, 'admin', 'admin@gmail.com', '$2y$10$dmGXYRNPACJ6UW3715HD4OurZBqOdhsZzuXhtgVnoNNQZ1EFE4A3q');

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
(3, 'Keto Creamy Pepper Steak', 'CreamyPepperSteakherorsz_2000x.png', 'While we take extreme measures to ensure our food is free of allergens please be aware that our production facility does handle Fish, Crustacean, Sesame Seeds, Soybeans, Egg, Peanuts, Gluten, Treenuts and Sulphites.\r\n\r\nKeep food chilled between 0 – 4 degrees Celsius at all times before heating, consume within the use-by date.', 5.1, 473, 200, 0, 1),
(4, 'Keto Chicken w Lemon Herb', 'download.png', 'Lemon Herb Chicken', 10, 200, 120, 0, 1),
(5, 'KETO BUFFALO CHICKEN', 'BuffaloChickenherorsz_2000x.png', 'Enjoy the famous Buffalo flavour with these succulent chicken tenders!\r\nThe Chicken tenders are marinated in a selection of spices and served on a creamy red sauce, sided with a charmingly flavoured blue cheese risotto made using broccoli and cauliflower', 6, 250, 100, 0, 2),
(6, 'CHICKEN KATSU', 'KatsuChicken_Eating_March2021_01copy_2000x.jpg', 'CHICKEN KATSU details', 8, 180, 88, 0, 2),
(7, 'BEEF & BACON SPAGHETTI ', 'Beef_BaconSpagBol_Eating_March2021_01copy_2000x.jpg', 'Of course no menu is complete without a hearty spag bol! We’ve combined juicy, protein-rich beef and bacon meatballs and let them cook in a flavoursome sauce. With fettuccine pasta and a parmesan cheese top to finish. Just sit back, relax and enjoy the bold flavours of Italia from your dinner table.', 6, 500, 200, 0, 3),
(8, 'KETO BEEF TACO CASSEROLE', 'TacoBeefCasseroleHerorsz_17c964c4-23ce-4474-94d2-eb5ef4dd6c9d_2000x.png', 'KETO BEEF TACO CASSEROLE KETO BEEF TACO CASSEROLE', 10, 660, 150, 0, 3),
(9, 'KAWAKAWA CHICKEN & STUFFING', 'kawakawa-chicken-WEB_2000x.jpg', 'KAWAKAWA CHICKEN & STUFFING KAWAKAWA CHICKEN & STUFFING KAWAKAWA CHICKEN & STUFFING', 6, 212, 125, 0, 3);

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
(3, 'Keto Chap Pack', 55, 55, 'sdsdsd', 0, 'HeroPackMaster10MealsKETO_400x.png', 2),
(4, 'Keto Hero 10 - Maxi', 65, 500, 'keto hero package', 0, 'Capture.JPG', 1),
(5, 'Beef', 29, 500, 'Beef Package', 0, 'BuffaloChickenherorsz_2000x.png', 2),
(6, 'Succulent chicken package', 55, 600, 'Succulent chicken package Succulent chicken package Succulent chicken package Succulent chicken package', 0, 'CreamyPepperSteakherorsz_2000x.png', 3);

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
(9, 3, 4),
(10, 4, 4),
(11, 3, 3),
(12, 4, 3),
(13, 5, 5),
(14, 6, 5),
(15, 8, 6),
(16, 9, 6);

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
(1, 'The Breakfast Club‬', 'kuwait city', 'clubbreak@gmail.com', '659321', 'Talal Aabed', 'res2.jpg', 'details about restaurants', 0, '$2y$10$0mp7F06mxE.HK/fNcDQzaeYYm7dgEx1ukoHDOFYktl.oVWx0B9UI.'),
(2, 'Maki Marina Waves‬', 'kuwait city', 'hadymarina@yahoo.com', '695124', 'hady abdalla', 'maki.jpg', 'details about restaurant', 1.4, '$2y$10$k2nRYafQFPxT7PmkEIh5VusBAG5WuEVQRQWgl48dQm78cW58peMtS'),
(3, 'Takooz', 'kuwait city', 'takooz@gmail.com', '123456', 'amaar saadoon', NULL, 'dsfdsfds', 0, '$2y$10$FQeRpD83hfj/KjXjYB71Fe1xUU0LoTudxzea.6r.3qhVzywOvVRMi'),
(4, 'Roots Restaurant ', 'kuwait, khafagy', 'roots12@gmail.com', '123458', 'talaal saramad', NULL, 'asdasd', 3, '$2y$10$k2nRYafQFPxT7PmkEIh5VusBAG5WuEVQRQWgl48dQm78cW58peMtS');

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

--
-- Dumping data for table `user_meals`
--

INSERT INTO `user_meals` (`id`, `user_id`, `meal_id`) VALUES
(7, 1, 7),
(8, 3, 8);

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
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `package_meals`
--
ALTER TABLE `package_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
