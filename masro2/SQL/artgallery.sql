-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2024 at 04:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artgallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `ArtworkID` int NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Catagory` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Image` text NOT NULL,
  `ArtistID` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_reviews` int DEFAULT '0',
  `numberInStock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`ArtworkID`, `Title`, `Description`, `Catagory`, `Price`, `Image`, `ArtistID`, `created_at`, `total_reviews`, `numberInStock`) VALUES
(1008, 'Mystical Sunset', 'An enchanting painting capturing the beauty of a magical sunset over the ocean', 'Painting', '129.99', 'product-1.jpg', 3, '2024-05-04 17:00:39', 1, 0),
(1009, 'Whimsical Dreams', 'A whimsical artwork depicting surreal dreamscapes and floating castles', 'Painting', '249.99', 'product-2.jpg', 4, '2024-05-04 17:00:39', 0, 0),
(1010, 'Galactic Journey', 'Embark on a cosmic adventure with this captivating space-themed artwork', 'Typography', '199.99', 'product-3.jpg', 6, '2024-05-04 17:00:39', 0, 0),
(1011, 'Ethereal Forest', 'Step into a mystical forest where fairies dance and trees whisper secrets', 'Nature', '149.99', 'product-4.jpg', 3, '2024-05-04 17:00:39', 0, 0),
(1012, 'Serene Bliss', 'Find serenity and inner peace with this tranquil Zen-inspired artwork', 'Spiritual', '79.99', 'product-5.jpg', 4, '2024-05-04 17:00:39', 0, 0),
(1013, 'Enchanted Garden', 'Explore an enchanted garden filled with colorful blooms and magical creatures', 'Fantasy', '169.99', 'product-6.jpg', 6, '2024-05-04 17:00:39', 0, 0),
(1014, 'Timeless Elegance', 'Capture the essence of timeless beauty with this elegant and classic masterpiece', 'Portrait', '299.99', 'product-7.jpg', 3, '2024-05-04 17:00:39', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `egiftcards`
--

CREATE TABLE `egiftcards` (
  `CardID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `RecipientEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int NOT NULL,
  `Title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `ArtistID` int DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `Title`, `Location`, `Date`, `ArtistID`, `City`, `Image`, `Description`) VALUES
(21, 'Cairo International Film Festival', 'Cairo Opera House', '2024-05-05', 3, 'Cairo', 'event-01.jpg', ''),
(22, 'Giza International Book Fair', 'Giza Convention Center', '2024-05-06', 4, 'Giza', 'event-01.jpg', ''),
(23, 'Luxor African Film Festival', 'Luxor Temple', '2024-05-07', 6, 'Luxor', 'event-01.jpg', ''),
(24, 'Aswan International Women\'s Day Festival', 'Aswan High Dam', '2024-05-08', 3, 'Aswan', 'event-01.jpg', ''),
(25, 'Alexandria Mediterranean Film Festival', 'Alexandria Library', '2024-05-09', 4, 'Alexandria', 'event-01.jpg', ''),
(26, 'Cairo Jazz Festival', 'Cairo Jazz Club', '2024-05-10', 6, 'Cairo', 'event-01.jpg', ''),
(27, 'Sharm El Sheikh International Half Marathon', 'Naama Bay', '2024-05-11', 3, 'Sharm El Sheikh', 'event-01.jpg', ''),
(28, 'El Gouna Film Festival', 'El Gouna', '2024-05-12', 4, 'El Gouna', 'event-01.jpg', ''),
(29, 'Hurghada International Fishing Tournament', 'Hurghada Marina', '2024-05-13', 6, 'Hurghada', 'event-01.jpg', ''),
(30, 'Dahab International Festival of Culture and Arts', 'Dahab Promenade', '2024-05-14', 3, 'Dahab', 'event-01.jpg', ''),
(31, 'Luxor International Dance Festival', 'Luxor Temple', '2024-05-15', 4, 'Luxor', 'event-01.jpg', ''),
(32, 'Aswan International Sculpture Symposium', 'Aswan', '2024-05-16', 6, 'Aswan', 'event-01.jpg', ''),
(33, 'Fayoum International Ceramic Symposium', 'Fayoum', '2024-05-17', 3, 'Fayoum', 'event-01.jpg', ''),
(34, 'Siwa Oasis International Date Festival', 'Siwa Oasis', '2024-05-18', 4, 'Siwa', 'event-01.jpg', ''),
(35, 'Cairo Fashion Festival', 'Cairo International Convention Center', '2024-05-19', 6, 'Cairo', 'event-01.jpg', ''),
(36, 'Gouna Film Festival', 'El Gouna', '2024-05-20', 3, 'El Gouna', 'event-01.jpg', ''),
(37, 'Sharm El Sheikh International Water Sports Festival', 'Naama Bay', '2024-05-21', 4, 'Sharm El Sheikh', 'event-01.jpg', ''),
(38, 'Hurghada International Red Sea Guitar Festival', 'Hurghada Marina', '2024-05-22', 6, 'Hurghada', 'event-01.jpg', ''),
(39, 'Dahab International Yoga Festival', 'Dahab', '2024-05-23', 3, 'Dahab', 'event-01.jpg', ''),
(40, 'Luxor International Marathon', 'Luxor Temple', '2024-05-24', 4, 'Luxor', 'event-01.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `productuserrating`
--

CREATE TABLE `productuserrating` (
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rate` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productuserrating`
--

INSERT INTO `productuserrating` (`product_id`, `user_id`, `rate`) VALUES
(1008, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `PurchaseID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `ArtworkID` int DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `ReferedID` int NOT NULL,
  `UserID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `CartNo` int NOT NULL,
  `userId` int DEFAULT NULL,
  `ItemID` int DEFAULT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int NOT NULL,
  `Fname` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Lanme` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phoneNumber` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Geneder` enum('M','F') DEFAULT NULL,
  `Address` text,
  `Artist` tinyint(1) DEFAULT NULL,
  `Advisor` tinyint(1) DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `City` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Fname`, `Lanme`, `phoneNumber`, `Email`, `Geneder`, `Address`, `Artist`, `Advisor`, `Password`, `City`) VALUES
(3, 'Marwan', 'Glal', '01021862880', 'marwan.work@gmail.com', 'M', 'Cairo', 1, 0, '%%GGMM$#2', ''),
(4, 'Abdullah', 'Ahmed', '012189320', 'abdullah.sherdy@mail.com', 'M', 'Port_said ', 1, 0, '&6%%5H%%fads\r\n', ''),
(6, 'Ahmed', 'saad', '012189320', 'Ahmed.sadd@mail.com', 'M', 'Port_said ', 0, 0, '&6%%5H900%%fads\r\n', ''),
(7, 'Yousef', 'Sayed', '01121196781', 'yousef.sayed.work@gmail.com', 'M', 'Cairo', 0, 0, 'MTIzNDU2Nzg', ''),
(8, 'Abdallah', 'Ahmed', '0102186200', 'abdallah.sherdy.art@gmail.com', 'M', 'salah el-dein street', 1, 0, 'QTEyMzRINTY3OA', 'Port Said');

-- --------------------------------------------------------

--
-- Table structure for table `virtualgalleries`
--

CREATE TABLE `virtualgalleries` (
  `GalleryID` int NOT NULL,
  `ArtistID` int DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Title` varchar(250) NOT NULL,
  `Description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`ArtworkID`),
  ADD KEY `ArtistID` (`ArtistID`);

--
-- Indexes for table `egiftcards`
--
ALTER TABLE `egiftcards`
  ADD PRIMARY KEY (`CardID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `ArtistID` (`ArtistID`);

--
-- Indexes for table `productuserrating`
--
ALTER TABLE `productuserrating`
  ADD PRIMARY KEY (`product_id`,`user_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PurchaseID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ArtworkID` (`ArtworkID`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`ReferedID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`CartNo`),
  ADD KEY `userId` (`userId`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `virtualgalleries`
--
ALTER TABLE `virtualgalleries`
  ADD PRIMARY KEY (`GalleryID`),
  ADD KEY `UserID` (`ArtistID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `ArtworkID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

--
-- AUTO_INCREMENT for table `egiftcards`
--
ALTER TABLE `egiftcards`
  MODIFY `CardID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `CartNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `virtualgalleries`
--
ALTER TABLE `virtualgalleries`
  MODIFY `GalleryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artworks`
--
ALTER TABLE `artworks`
  ADD CONSTRAINT `artworks_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

--
-- Constraints for table `egiftcards`
--
ALTER TABLE `egiftcards`
  ADD CONSTRAINT `egiftcards_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`ArtworkID`) REFERENCES `artworks` (`ArtworkID`) ON DELETE SET NULL;

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `referrals` (`ReferedID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`UserID`) ON DELETE SET NULL,
  ADD CONSTRAINT `shoppingcart_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `artworks` (`ArtworkID`) ON DELETE SET NULL;

--
-- Constraints for table `virtualgalleries`
--
ALTER TABLE `virtualgalleries`
  ADD CONSTRAINT `virtualgalleries_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
