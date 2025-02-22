-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 07:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `world-on-wheels`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL,
  `route_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `text` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `route_id`, `user_id`, `text`, `date`) VALUES
(2, 1, 1, 'Very interesting!', '2025-01-19'),
(5, 3, 1, 'Wonderful place!', '2025-01-20'),
(6, 1, 1, 'Love this route!', '2025-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_route`
--

CREATE TABLE `deleted_route` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `start` varchar(100) NOT NULL,
  `end` varchar(100) NOT NULL,
  `distance` double NOT NULL,
  `distance_unit` enum('kilometers','miles') NOT NULL DEFAULT 'kilometers',
  `short_description` varchar(500) NOT NULL,
  `long_description` varchar(2500) NOT NULL,
  `author_name` varchar(255) NOT NULL DEFAULT 'anonymous',
  `user_id` bigint(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_user`
--

CREATE TABLE `deleted_user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('admin','verified','user') NOT NULL DEFAULT 'user',
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_route`
--

CREATE TABLE `favorite_route` (
  `user_id` bigint(20) NOT NULL,
  `route_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `favorite_route`
--

INSERT INTO `favorite_route` (`user_id`, `route_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `gpx`
--

CREATE TABLE `gpx` (
  `route_id` bigint(20) NOT NULL,
  `name` bigint(20) NOT NULL,
  `extension` enum('gpx') NOT NULL,
  `location_path` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gpx`
--

INSERT INTO `gpx` (`route_id`, `name`, `extension`, `location_path`) VALUES
(1, 1, 'gpx', 'routes/1/1.gpx'),
(2, 2, 'gpx', 'routes/2/2.gpx'),
(3, 3, 'gpx', 'routes/3/3.gpx');

-- --------------------------------------------------------

--
-- Table structure for table `logged_in_user`
--

CREATE TABLE `logged_in_user` (
  `session_id` varchar(100) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `logged_in_user`
--

INSERT INTO `logged_in_user` (`session_id`, `user_id`, `last_update`) VALUES
('nhlacmh8hb14pc2da3u6709ouh', 1, '2025-01-21 19:05:08');

-- --------------------------------------------------------

--
-- Table structure for table `marker`
--

CREATE TABLE `marker` (
  `route_id` bigint(20) NOT NULL,
  `latitude` float(8,6) NOT NULL,
  `longitude` float(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marker`
--

INSERT INTO `marker` (`route_id`, `latitude`, `longitude`) VALUES
(1, -28.685860, 17.557529),
(1, -27.829000, 17.570999),
(1, -24.254868, 15.582143),
(1, -22.565220, 17.084221),
(2, -20.467024, -66.824287),
(2, -20.204264, -67.514992),
(2, -19.850510, -68.249809),
(2, -19.369738, -68.171593),
(2, -19.015022, -68.370682),
(3, 20.070009, -74.489258),
(3, 20.164860, -74.609291),
(3, 20.344009, -74.493492);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `start` varchar(100) NOT NULL,
  `end` varchar(100) NOT NULL,
  `distance` double NOT NULL,
  `distance_unit` enum('kilometers','miles') NOT NULL DEFAULT 'kilometers',
  `short_description` varchar(500) NOT NULL,
  `long_description` varchar(2500) NOT NULL,
  `author_name` varchar(255) NOT NULL DEFAULT 'anonymous',
  `user_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `location_path` varchar(1024) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `title`, `start`, `end`, `distance`, `distance_unit`, `short_description`, `long_description`, `author_name`, `user_id`, `date`, `location_path`) VALUES
(1, 'Southern Namibia', 'Windhoek', 'Felix Unite', 621, 'miles', 'Namibia has the second-lowest population density in the world. Most of its people are in the north, so the south is empty indeed. Not surprisingly, it’s dry and unforgiving land. Towns and amenities are few and far between. Roads are mostly loose gravel. But it’s also unutterably gorgeous.', 'Namibia has the second-lowest population density in the world. Most of its people are in the north, so the south is empty indeed. Not surprisingly, it’s dry and unforgiving land. Towns and amenities are few and far between. Roads are mostly loose gravel. But it’s also unutterably gorgeous.&#13;&#10;&#13;&#10;A seven-day, 621-mile (1000km) unsupported pedal through this astonishing landscape, from Namibia’s capital of Windhoek to the South African border, requires planning, packing, perseverance and profound self-reliance. Factoring in the vast distances between towns, roadhouses, campgrounds and great attractions, an ideal itinerary is to head south-west to Sesriem for a visit to Sossusvlei’s red dunes and salt pans, then turn south via Helmeringhausen and Seeheim to pause in Hobas and view Fish River Canyon (rivalling the Grand Canyon), and then point south again to Felix Unite, near the Noordoewer international crossing to South Africa.', 'anonymous', 1, '2025-01-19', 'routes/1/'),
(2, 'Salar De Uyuni, Bolivia', 'Uyuni', 'Sabaya', 186, 'miles', 'Cycling atop the salt crust of Bolivia’s Salar de Uyuni – and the more petite but perfectly-formed Salar de Coipasa – is an undisputed highlight of many a South America journey. It’s a high-altitude ride that takes five or six days, segmented by an opportunity to resupply with water and food at the midway settlement of Llica.', 'Cycling atop the salt crust of Bolivia’s Salar de Uyuni – and the more petite but perfectly-formed Salar de Coipasa – is an undisputed highlight of many a South America journey. It’s a high-altitude ride that takes five or six days, segmented by an opportunity to resupply with water and food at the midway settlement of Llica.&#13;&#10;&#13;&#10;As the largest salt flat in the world, cycling here provides an other-worldly experience. There’s nothing quite like pitching your tent on a bleached white canvas, seasoning your dinner with the salty ground on which you’re sitting, and awakening in the morning to a glow of ethereal, lavender light.&#13;&#10;&#13;&#10;This journey can only be undertaken in Bolivia’s winter, as during summer the salt lakes are inundated by seasonal rain.', 'anonymous', 1, '2025-01-19', 'routes/2/'),
(3, 'La Farola, Cuba', 'Cajobabo', 'Baracoa', 34, 'miles', 'Hailed as one of the seven modern engineering marvels of Cuba, La Farola (the lighthouse road) links the beach hamlet of Cajobabo on the arid Caribbean coast with the nation’s beguiling oldest city, Baracoa.', 'Hailed as one of the seven modern engineering marvels of Cuba, La Farola (the lighthouse road) links the beach hamlet of Cajobabo on the arid Caribbean coast with the nation’s beguiling oldest city, Baracoa.&#13;&#10;&#13;&#10;Measuring 34 miles (55km) in length, the road traverses the steep-sided Sierra del Puril, snaking its way precipitously through a landscape of granite cliffs and pine-scented cloud forest before falling, with eerie suddenness, upon the lush tropical paradise of the Atlantic coastline.&#13;&#10;&#13;&#10;For cyclists, it offers a classic Tour de France-style challenge with tough climbs, invigorating descents and relatively smooth roads. La Farola starts 124 miles (200km) east of Santiago de Cuba and is thus best incorporated into a wider Cuban cycling excursion. You could also charter a taxi to drop you off at the start point.', 'Anastasiia Hopchuk', 1, '2025-01-19', 'routes/3/');

-- --------------------------------------------------------

--
-- Table structure for table `route_image`
--

CREATE TABLE `route_image` (
  `route_id` bigint(20) NOT NULL,
  `name` enum('main','img1','img2','img3','img4','img5','img6') NOT NULL,
  `extension` enum('png','jpg','jpeg') NOT NULL,
  `alt_text` varchar(512) DEFAULT NULL,
  `location_path` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `route_image`
--

INSERT INTO `route_image` (`route_id`, `name`, `extension`, `alt_text`, `location_path`) VALUES
(1, 'main', 'jpg', '', 'routes/1/main.jpg'),
(1, 'img1', 'jpg', '', 'routes/1/img1.jpg'),
(1, 'img2', 'jpg', '', 'routes/1/img2.jpg'),
(1, 'img3', 'jpg', '', 'routes/1/img3.jpg'),
(1, 'img4', 'jpg', '', 'routes/1/img4.jpg'),
(1, 'img5', 'jpg', '', 'routes/1/img5.jpg'),
(1, 'img6', 'jpg', '', 'routes/1/img6.jpg'),
(2, 'main', 'jpg', '', 'routes/2/main.jpg'),
(2, 'img1', 'jpg', '', 'routes/2/img1.jpg'),
(2, 'img2', 'jpg', '', 'routes/2/img2.jpg'),
(2, 'img3', 'jpg', '', 'routes/2/img3.jpg'),
(2, 'img4', 'jpg', '', 'routes/2/img4.jpg'),
(2, 'img5', 'jpg', '', 'routes/2/img5.jpg'),
(2, 'img6', 'jpg', '', 'routes/2/img6.jpg'),
(3, 'main', 'jpg', '', 'routes/3/main.jpg'),
(3, 'img1', 'jpg', '', 'routes/3/img1.jpg'),
(3, 'img2', 'jpg', '', 'routes/3/img2.jpg'),
(3, 'img3', 'jpg', '', 'routes/3/img3.jpg'),
(3, 'img4', 'jpg', '', 'routes/3/img4.jpg'),
(3, 'img5', 'jpg', '', 'routes/3/img5.jpg'),
(3, 'img6', 'jpg', '', 'routes/3/img6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `route_views`
--

CREATE TABLE `route_views` (
  `route_id` bigint(20) NOT NULL,
  `views` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `route_views`
--

INSERT INTO `route_views` (`route_id`, `views`) VALUES
(1, 18),
(2, 3),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('admin','verified','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `full_name`, `email`, `password`, `status`) VALUES
(1, 'hopchana', 'Anastasiia Hopchuk', 'anastasiiahopch@gmail.com', '$2y$10$FKvo67ojCqRQ4nUMZ106WevZG3..9fP4mQzPRQCyvv0EDs01P6CAy', 'user'),
(2, 'admin', 'Admin Admin', 'admin@wow.com', '$2y$10$TYvvbeoV5GyKCyHQLtFP0.f/FCgVkRgpzr2/Wud0oC1hK/yTserAG', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_id` (`route_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deleted_route`
--
ALTER TABLE `deleted_route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_user`
--
ALTER TABLE `deleted_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite_route`
--
ALTER TABLE `favorite_route`
  ADD PRIMARY KEY (`user_id`,`route_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `gpx`
--
ALTER TABLE `gpx`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `logged_in_user`
--
ALTER TABLE `logged_in_user`
  ADD PRIMARY KEY (`session_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`route_id`,`latitude`,`longitude`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_description` (`short_description`),
  ADD UNIQUE KEY `long_description` (`long_description`) USING HASH,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `route_image`
--
ALTER TABLE `route_image`
  ADD PRIMARY KEY (`route_id`,`name`);

--
-- Indexes for table `route_views`
--
ALTER TABLE `route_views`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_name` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorite_route`
--
ALTER TABLE `favorite_route`
  ADD CONSTRAINT `favorite_route_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorite_route_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gpx`
--
ALTER TABLE `gpx`
  ADD CONSTRAINT `gpx_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logged_in_user`
--
ALTER TABLE `logged_in_user`
  ADD CONSTRAINT `logged_in_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marker`
--
ALTER TABLE `marker`
  ADD CONSTRAINT `marker_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_image`
--
ALTER TABLE `route_image`
  ADD CONSTRAINT `route_image_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_views`
--
ALTER TABLE `route_views`
  ADD CONSTRAINT `route_views_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


GRANT ALL PRIVILEGES ON *.* TO `hopchana`@`%` IDENTIFIED BY PASSWORD '*C5D07E5384FBD55D55F39CF00D0BF13A273BEB5E' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `world-on-wheels`.* TO `hopchana`@`%` WITH GRANT OPTION;