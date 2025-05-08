-- Combined and fixed SQL dump for artgallery database with utf8mb4_general_ci collation

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `artworks`;
CREATE TABLE `artworks` (
  `ArtworkID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Catagory` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Image` text NOT NULL,
  `ArtistID` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_reviews` int DEFAULT '0',
  `numberInStock` int NOT NULL,
  PRIMARY KEY (`ArtworkID`),
  KEY `ArtistID` (`ArtistID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `artworks` (`ArtworkID`, `Title`, `Description`, `Catagory`, `Price`, `Image`, `ArtistID`, `created_at`, `total_reviews`, `numberInStock`) VALUES
(1008, 'Mystical Sunset', 'An enchanting painting capturing the beauty of a magical sunset over the ocean', 'Painting', '129.99', 'product-1.jpg', 3, '2024-05-04 17:00:39', 1, 0),
(1009, 'Whimsical Dreams', 'A whimsical artwork depicting surreal dreamscapes and floating castles', 'Painting', '249.99', 'product-2.jpg', 4, '2024-05-04 17:00:39', 0, 0),
(1010, 'Galactic Journey', 'Embark on a cosmic adventure with this captivating space-themed artwork', 'Typography', '199.99', 'product-3.jpg', 6, '2024-05-04 17:00:39', 0, 0),
(1011, 'Ethereal Forest', 'Step into a mystical forest where fairies dance and trees whisper secrets', 'Nature', '149.99', 'product-4.jpg', 3, '2024-05-04 17:00:39', 0, 0),
(1012, 'Serene Bliss', 'Find serenity and inner peace with this tranquil Zen-inspired artwork', 'Spiritual', '79.99', 'product-5.jpg', 4, '2024-05-04 17:00:39', 0, 0),
(1013, 'Enchanted Garden', 'Explore an enchanted garden filled with colorful blooms and magical creatures', 'Fantasy', '169.99', 'product-6.jpg', 6, '2024-05-04 17:00:39', 0, 0),
(1014, 'Timeless Elegance', 'Capture the essence of timeless beauty with this elegant and classic masterpiece', 'Portrait', '299.99', 'product-7.jpg', 3, '2024-05-04 17:00:39', 0, 0);

DROP TABLE IF EXISTS `egiftcards`;
CREATE TABLE `egiftcards` (
  `CardID` int NOT NULL AUTO_INCREMENT,
  `UserID` int DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `RecipientEmail` varchar(255) NOT NULL,
  PRIMARY KEY (`CardID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `EventID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `ArtistID` int DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`EventID`),
  KEY `ArtistID` (`ArtistID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(37, 'Sharm El Sheikh International Water Sports Festival', 'Naama Bay',  '2024-05-21', 4, 'Sharm El Sheikh', 'event-01.jpg', ''),
(38, 'Hurghada International Red Sea Guitar Festival', 'Hurghada Marina', '2024-05-22', 6, 'Hurghada', 'event-01.jpg', ''),
(39, 'Dahab International Yoga Festival', 'Dahab', '2024-05-23', 3, 'Dahab', 'event-01.jpg', ''),
(40, 'Luxor International Marathon', 'Luxor Temple', '2024-05-24', 4, 'Luxor', 'event-01.jpg', '');

DROP TABLE IF EXISTS `productuserrating`;
CREATE TABLE `productuserrating` (
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rate` int DEFAULT '0',
  PRIMARY KEY (`product_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productuserrating` (`product_id`, `user_id`, `rate`) VALUES
(1008, 7, 5);

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `PurchaseID` int NOT NULL AUTO_INCREMENT,
  `UserID` int DEFAULT NULL,
  `ArtworkID` int DEFAULT NULL,
  `Date` date DEFAULT NULL,
  PRIMARY KEY (`PurchaseID`),
  KEY `UserID` (`UserID`),
  KEY `ArtworkID` (`ArtworkID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `referrals`;
CREATE TABLE `referrals` (
  `ReferedID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  PRIMARY KEY (`ReferedID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE `shoppingcart` (
  `CartNo` int NOT NULL AUTO_INCREMENT,
  `userId` int DEFAULT NULL,
  `ItemID` int DEFAULT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`CartNo`),
  KEY `userId` (`userId`),
  KEY `ItemID` (`ItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Fname` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Lanme` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phoneNumber` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Geneder` enum('M','F') DEFAULT NULL,
  `Address` text,
  `Artist` tinyint(1) DEFAULT NULL,
  `Advisor` tinyint(1) DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `City` varchar(250) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`UserID`, `Fname`, `Lanme`, `phoneNumber`, `Email`, `Geneder`, `Address`, `Artist`, `Advisor`, `Password`, `City`) VALUES
(3, 'Marwan', 'Glal', '01021862880', 'marwan.work@gmail.com', 'M', 'Cairo', 1, 0, '%%GGMM$#2', ''),
(4, 'Abdullah', 'Ahmed', '012189320', 'abdullah.sherdy@mail.com', 'M', 'Port_said ', 1, 0, '&6%%5H%%fads\r\n', ''),
(6, 'Ahmed', 'saad', '012189320', 'Ahmed.sadd@mail.com', 'M', 'Port_said ', 0, 0, '&6%%5H900%%fads\r\n', ''),
(7, 'Yousef', 'Sayed', '01121196781', 'yousef.sayed.work@gmail.com', 'M',  'Cairo', 0, 0, 'MTIzNDU2Nzg', ''),
(8, 'Abdallah', 'Ahmed', '0102186200', 'abdallah.sherdy.art@gmail.com', 'M', 'salah el-dein street', 1, 0, 'QTEyMzRINTY3OA', 'Port Said');

DROP TABLE IF EXISTS `virtualgalleries`;
CREATE TABLE `virtualgalleries` (
  `GalleryID` int NOT NULL AUTO_INCREMENT,
  `ArtistID` int DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Title` varchar(250) NOT NULL,
  `Description` varchar(250) NOT NULL,
  PRIMARY KEY (`GalleryID`),
  KEY `UserID` (`ArtistID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `artworks`
  ADD CONSTRAINT `artworks_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

ALTER TABLE `egiftcards`
  ADD CONSTRAINT `egiftcards_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`ArtworkID`) REFERENCES `artworks` (`ArtworkID`) ON DELETE SET NULL;

ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `referrals` (`ReferedID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`UserID`) ON DELETE SET NULL,
  ADD CONSTRAINT `shoppingcart_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `artworks` (`ArtworkID`) ON DELETE SET NULL;

ALTER TABLE `virtualgalleries`
  ADD CONSTRAINT `virtualgalleries_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS=1;
