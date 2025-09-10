-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for lugia
CREATE DATABASE IF NOT EXISTS `lugia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lugia`;

-- Dumping structure for table lugia.tblaircraft
CREATE TABLE IF NOT EXISTS `tblaircraft` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iata` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icao` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `model` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_class` smallint unsigned DEFAULT NULL,
  `business_class` smallint unsigned DEFAULT NULL,
  `economy_class` smallint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblaircraft: ~18 rows (approximately)
DELETE FROM `tblaircraft`;
INSERT INTO `tblaircraft` (`id`, `iata`, `icao`, `model`, `first_class`, `business_class`, `economy_class`) VALUES
	(1, 'DH8D', 'DH8D', 'De Havilland Dash 8-Q400', 10, 20, 80),
	(2, 'AT76', 'AT76', 'ATR 72-600', 10, 20, 80),
	(3, 'AT42', 'AT42', 'ATR 42-600', 10, 20, 80),
	(4, '320', 'A320', 'Airbus A320-200', 10, 20, 80),
	(5, '32N', 'A20N', 'Airbus A320neo', 10, 20, 80),
	(6, '321', 'A321', 'Airbus A321-200', 10, 20, 80),
	(7, '32Q', 'A21N', 'Airbus A321neo', 10, 20, 80),
	(8, '333', 'A333', 'Airbus A330-300', 10, 20, 80),
	(9, '339', 'A339', 'Airbus A330-900neo', 10, 20, 80),
	(10, '359', 'A359', 'Airbus A350-900', 10, 20, 80),
	(11, '35K', 'A35K', 'Airbus A350-1000', 10, 20, 80),
	(12, '77W', 'B77W', 'Boeing 777-300ER', 10, 20, 80),
	(13, '738', 'B738', 'Boeing 737-800', 10, 20, 80),
	(14, '7M8', 'B38M', 'Boeing 737 MAX 8', 10, 20, 80),
	(15, '788', 'B788', 'Boeing 787-8', 10, 20, 80),
	(16, '789', 'B789', 'Boeing 787-9', 10, 20, 80),
	(17, '78X', 'B78X', 'Boeing 787-10', 10, 20, 80),
	(18, '388', 'A388', 'Airbus A380-800', 10, 20, 80);

-- Dumping structure for table lugia.tblairline
CREATE TABLE IF NOT EXISTS `tblairline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iata` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icao` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `airline_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `callsign` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `region` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comments` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblairline: ~12 rows (approximately)
DELETE FROM `tblairline`;
INSERT INTO `tblairline` (`id`, `iata`, `icao`, `airline_name`, `callsign`, `region`, `comments`) VALUES
	(1, '5J', 'CEB', 'Cebu Pacific', 'CEBU', 'Philippines', 'Founded as Cebu Air (1988); began operations in 1996 as Cebu Pacific.'),
	(2, 'PR', 'PAL', 'Philippine Airlines', 'PHILIPPINE', 'Philippines', 'Founded 1930 as Philippine Aerial Taxi Co.; renamed Philippine Airlines in 1970.'),
	(3, 'Z2', 'APG', 'Philippines AirAsia', 'COOL RED', 'Philippines', 'Founded as AirAsia Philippines (2010); renamed Philippines AirAsia in 2015.'),
	(4, 'RW', 'RYL', 'Royal Air Philippines', 'DOUBLE GOLD', 'Philippines', 'Founded 2002 as Royal Air Charter Service; relaunched as Royal Air Philippines in 2017.'),
	(5, 'AO', '', 'Air Juan', 'AIR JUAN', 'Philippines', 'First ever seaplane airline in the Philippines (founded 2012).'),
	(6, 'T6', 'ATX', 'AirSWIFT', 'AIRSWIFT', 'Philippines', 'Founded 2002 as Island Transvoyager.'),
	(7, '0A', 'BIC', 'Alphaland Aviation', 'BALESIN', 'Philippines', 'Founded 2015; operates flights to Balesin Island.'),
	(8, 'DG', 'SRQ', 'Cebgo', 'BLUE JAY', 'Philippines', 'Founded 1995 as South East Asian Airlines; operates as Cebu Pacific.'),
	(9, '2P', 'GAP', 'PAL Express', 'AIRPHIL', 'Philippines', 'Founded 1995 as Air Philippines; operates as Philippine Airlines.'),
	(10, 'M8', 'MSJ', 'SkyJet Airlines', 'MAGNUM AIR', 'Philippines', 'Founded 2005; began operations in 2012.'),
	(11, 'SP', 'WCC', 'Sky Pasada', 'SKY PASADA', 'Philippines', 'Founded 2010; regional services from Manila.'),
	(12, 'ST', 'SEA', 'Sunlight Air', 'BLUE HUMAN', 'Philippines', 'Founded 2020; boutique regional airline.');

-- Dumping structure for table lugia.tblairlineuser
CREATE TABLE IF NOT EXISTS `tblairlineuser` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pass` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aid` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  CONSTRAINT `tblairlineuser_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `tblairline` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblairlineuser: ~0 rows (approximately)
DELETE FROM `tblairlineuser`;
INSERT INTO `tblairlineuser` (`id`, `user`, `pass`, `type`, `aid`) VALUES
	(1, 'ceb_admin', 'ceb12345', 'admin', 1),
	(2, 'ceb_ops1', 'opsceb01', 'staff', 1),
	(3, 'pal_admin', 'paladmin22', 'admin', 2),
	(4, 'pal_agent1', 'palagent88', 'agent', 2),
	(5, 'pal_pilot1', 'flypal330', 'pilot', 2),
	(6, 'airasia_admin', 'aa2025', 'admin', 3),
	(7, 'airasia_ops', 'ops888', 'staff', 3),
	(8, 'royair_admin', 'roy123', 'admin', 4),
	(9, 'royair_agent1', 'royagent55', 'agent', 4),
	(10, 'airswift_admin', 'swiftHR22', 'admin', 5),
	(11, 'skyjet_admin', 'skyjet01', 'admin', 6),
	(12, 'skyjet_staff1', 'skyops44', 'staff', 6),
	(13, 'sunlight_admin', 'sun2024', 'admin', 7),
	(14, 'palexp_ops1', 'palexp11', 'staff', 8),
	(15, 'cebu2_agent', 'ceb2fly22', 'agent', 9),
	(16, 'philcharter_mgr', 'pcmgr33', 'admin', 10),
	(17, 'seair_admin', 'seair007', 'admin', 11),
	(18, 'zestair_admin', 'zest888', 'admin', 12),
	(19, 'zestair_ops1', 'zestops12', 'staff', 12);

-- Dumping structure for table lugia.tblairport
CREATE TABLE IF NOT EXISTS `tblairport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iata` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icao` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `airport_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `location_serve` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dst` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblairport: ~30 rows (approximately)
DELETE FROM `tblairport`;
INSERT INTO `tblairport` (`id`, `iata`, `icao`, `airport_name`, `location_serve`, `time`, `dst`) VALUES
	(1, 'MNL', 'RPLL', 'Ninoy Aquino International', 'Manila, Philippines', 'UTC+8', 'N'),
	(2, 'CEB', 'RPVM', 'Mactan?Cebu International', 'Cebu, Philippines', 'UTC+8', 'N'),
	(3, 'DVO', 'RPMD', 'Francisco Bangoy International', 'Davao, Philippines', 'UTC+8', 'N'),
	(4, 'CRK', 'RPLC', 'Clark International', 'Angeles, Philippines', 'UTC+8', 'N'),
	(5, 'ILO', 'RPVI', 'Iloilo International', 'Iloilo, Philippines', 'UTC+8', 'N'),
	(6, 'PPS', 'RPVP', 'Puerto Princesa International', 'Palawan, Philippines', 'UTC+8', 'N'),
	(7, 'TAG', 'RPVT', 'Bohol?Panglao International', 'Bohol, Philippines', 'UTC+8', 'N'),
	(8, 'ZAM', 'RPMZ', 'Zamboanga International', 'Zamboanga, Philippines', 'UTC+8', 'N'),
	(9, 'KLO', 'RPVK', 'Kalibo International', 'Kalibo, Philippines', 'UTC+8', 'N'),
	(10, 'LGP', 'RPVP', 'Legazpi (Bicol) International', 'Albay, Philippines', 'UTC+8', 'N'),
	(11, 'CGY', 'RPMY', 'Laguindingan Airport', 'Cagayan de Oro, PH', 'UTC+8', 'N'),
	(12, 'NRT', 'RJAA', 'Narita International', 'Tokyo, Japan', 'UTC+9', 'N'),
	(13, 'HND', 'RJTT', 'Haneda International', 'Tokyo, Japan', 'UTC+9', 'N'),
	(14, 'HKG', 'VHHH', 'Hong Kong International', 'Hong Kong', 'UTC+8', 'N'),
	(15, 'SIN', 'WSSS', 'Singapore Changi', 'Singapore', 'UTC+8', 'N'),
	(16, 'KUL', 'WMKK', 'Kuala Lumpur International', 'Kuala Lumpur, Malaysia', 'UTC+8', 'N'),
	(17, 'BKK', 'VTBS', 'Suvarnabhumi Airport', 'Bangkok, Thailand', 'UTC+7', 'N'),
	(18, 'DXB', 'OMDB', 'Dubai International', 'Dubai, UAE', 'UTC+4', 'N'),
	(19, 'DOH', 'OTHH', 'Hamad International', 'Doha, Qatar', 'UTC+3', 'N'),
	(20, 'LAX', 'KLAX', 'Los Angeles International', 'Los Angeles, USA', 'UTC-8', 'Y'),
	(21, 'SFO', 'KSFO', 'San Francisco International', 'San Francisco, USA', 'UTC-8', 'Y'),
	(22, 'JFK', 'KJFK', 'John F. Kennedy International', 'New York, USA', 'UTC-5', 'Y'),
	(23, 'LHR', 'EGLL', 'London Heathrow', 'London, UK', 'UTC+0', 'Y'),
	(24, 'LGW', 'EGKK', 'London Gatwick', 'London, UK', 'UTC+0', 'Y'),
	(25, 'CDG', 'LFPG', 'Paris Charles de Gaulle', 'Paris, France', 'UTC+1', 'Y'),
	(26, 'FRA', 'EDDF', 'Frankfurt International', 'Frankfurt, Germany', 'UTC+1', 'Y'),
	(27, 'AMS', 'EHAM', 'Amsterdam Schiphol', 'Amsterdam, Netherlands', 'UTC+1', 'Y'),
	(28, 'SYD', 'YSSY', 'Sydney Kingsford Smith', 'Sydney, Australia', 'UTC+10', 'Y'),
	(29, 'MEL', 'YMML', 'Melbourne Tullamarine', 'Melbourne, Australia', 'UTC+10', 'Y'),
	(30, 'ICN', 'RKSI', 'Incheon International', 'Seoul, South Korea', 'UTC+9', 'N');

-- Dumping structure for table lugia.tblflightroute
CREATE TABLE IF NOT EXISTS `tblflightroute` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aid` int DEFAULT NULL,
  `oapid` int DEFAULT NULL,
  `dapid` int DEFAULT NULL,
  `round_trip` tinyint(1) DEFAULT NULL,
  `acid` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `oapid` (`oapid`),
  KEY `dapid` (`dapid`),
  KEY `acid` (`acid`),
  CONSTRAINT `tblflightroute_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `tblairline` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tblflightroute_ibfk_2` FOREIGN KEY (`oapid`) REFERENCES `tblairport` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tblflightroute_ibfk_3` FOREIGN KEY (`dapid`) REFERENCES `tblairport` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tblflightroute_ibfk_4` FOREIGN KEY (`acid`) REFERENCES `tblaircraft` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblflightroute: ~0 rows (approximately)
DELETE FROM `tblflightroute`;
INSERT INTO `tblflightroute` (`id`, `aid`, `oapid`, `dapid`, `round_trip`, `acid`) VALUES
	(1, 1, 1, 2, 1, 4),
	(2, 1, 2, 3, 1, 4),
	(3, 2, 1, 5, 1, 8),
	(4, 2, 1, 6, 1, 10),
	(5, 2, 1, 8, 1, 12),
	(6, 2, 1, 9, 1, 10),
	(7, 2, 1, 10, 1, 12),
	(8, 3, 1, 6, 1, 4),
	(9, 3, 1, 7, 1, 5),
	(10, 4, 2, 14, 1, 2),
	(11, 5, 1, 2, 1, 1);

-- Dumping structure for table lugia.tblflightschedule
CREATE TABLE IF NOT EXISTS `tblflightschedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `auid` int DEFAULT NULL,
  `frid` int DEFAULT NULL,
  `date_departure` date DEFAULT NULL,
  `time_departure` time DEFAULT NULL,
  `date_arrival` date DEFAULT NULL,
  `time_arrival` time DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_price` decimal(10,2) DEFAULT NULL,
  `business_price` decimal(10,2) DEFAULT NULL,
  `economy_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auid` (`auid`),
  KEY `frid` (`frid`),
  CONSTRAINT `tblflightschedule_ibfk_1` FOREIGN KEY (`auid`) REFERENCES `tblairlineuser` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tblflightschedule_ibfk_2` FOREIGN KEY (`frid`) REFERENCES `tblflightroute` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblflightschedule: ~10 rows (approximately)
DELETE FROM `tblflightschedule`;
INSERT INTO `tblflightschedule` (`id`, `auid`, `frid`, `date_departure`, `time_departure`, `date_arrival`, `time_arrival`, `status`, `first_price`, `business_price`, `economy_price`) VALUES
	(1, 1, 1, '2025-09-01', '08:30:00', '2025-09-01', '11:15:00', 'scheduled', NULL, NULL, NULL),
	(2, 2, 2, '2025-09-02', '14:00:00', '2025-09-02', '16:45:00', 'scheduled', NULL, NULL, NULL),
	(3, 3, 3, '2025-09-03', '06:15:00', '2025-09-03', '08:40:00', 'delayed', NULL, NULL, NULL),
	(4, 4, 4, '2025-09-04', '20:00:00', '2025-09-04', '00:15:00', 'scheduled', NULL, NULL, NULL),
	(5, 5, 5, '2025-09-05', '09:45:00', '2025-09-05', '13:10:00', 'cancelled', NULL, NULL, NULL),
	(6, 6, 6, '2025-09-06', '12:30:00', '2025-09-06', '15:55:00', 'arrived', NULL, NULL, NULL),
	(7, 7, 7, '2025-09-07', '05:30:00', '2025-09-07', '07:20:00', 'scheduled', NULL, NULL, NULL),
	(8, 8, 8, '2025-09-08', '17:25:00', '2025-09-08', '21:00:00', 'scheduled', NULL, NULL, NULL),
	(9, 9, 9, '2025-09-09', '10:00:00', '2025-09-09', '13:25:00', 'scheduled', NULL, NULL, NULL),
	(10, 10, 10, '2025-09-10', '19:45:00', '2025-09-10', '22:30:00', 'scheduled', NULL, NULL, NULL);

-- Dumping structure for table lugia.tblseats
CREATE TABLE IF NOT EXISTS `tblseats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fid` int DEFAULT NULL,
  `ticket_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `seat_name` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `class` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  CONSTRAINT `tblseats_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `tblflightschedule` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tblseats: ~0 rows (approximately)
DELETE FROM `tblseats`;

-- Dumping structure for table lugia.tbluser
CREATE TABLE IF NOT EXISTS `tbluser` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pass` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lugia.tbluser: ~10 rows (approximately)
DELETE FROM `tbluser`;
INSERT INTO `tbluser` (`id`, `user`, `pass`, `role`) VALUES
	(11, 'mark_admin', 'admin123', 'admin'),
	(12, 'anna_user', 'password1', 'user'),
	(13, 'juan_pilot', 'flyhigh', 'user'),
	(14, 'cebu_manager', 'cebupass', 'user'),
	(15, 'peter_staff', 'staff123', 'user'),
	(16, 'lucy_ops', 'opspass', 'user'),
	(17, 'maria_agent', 'agent2025', 'user'),
	(18, 'john_dev', 'devpass', 'user'),
	(19, 'karen_checkin', 'checkin123', 'user'),
	(20, 'samir_support', 'supportpass', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
