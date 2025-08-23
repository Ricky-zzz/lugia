-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2025 at 11:22 AM
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
-- Database: `lugia`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaircraft`
--

CREATE TABLE `tblaircraft` (
  `id` int(11) NOT NULL,
  `iata` varchar(10) DEFAULT NULL,
  `icao` varchar(10) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblaircraft`
--

INSERT INTO `tblaircraft` (`id`, `iata`, `icao`, `model`) VALUES
(1, 'DH8D', 'DH8D', 'De Havilland Dash 8-Q400'),
(2, 'AT76', 'AT76', 'ATR 72-600'),
(3, 'AT42', 'AT42', 'ATR 42-600'),
(4, '320', 'A320', 'Airbus A320-200'),
(5, '32N', 'A20N', 'Airbus A320neo'),
(6, '321', 'A321', 'Airbus A321-200'),
(7, '32Q', 'A21N', 'Airbus A321neo'),
(8, '333', 'A333', 'Airbus A330-300'),
(9, '339', 'A339', 'Airbus A330-900neo'),
(10, '359', 'A359', 'Airbus A350-900'),
(11, '35K', 'A35K', 'Airbus A350-1000'),
(12, '77W', 'B77W', 'Boeing 777-300ER'),
(13, '738', 'B738', 'Boeing 737-800'),
(14, '7M8', 'B38M', 'Boeing 737 MAX 8'),
(15, '788', 'B788', 'Boeing 787-8'),
(16, '789', 'B789', 'Boeing 787-9'),
(17, '78X', 'B78X', 'Boeing 787-10'),
(18, '388', 'A388', 'Airbus A380-800');

-- --------------------------------------------------------

--
-- Table structure for table `tblairline`
--

CREATE TABLE `tblairline` (
  `id` int(11) NOT NULL,
  `iata` varchar(10) DEFAULT NULL,
  `icao` varchar(10) DEFAULT NULL,
  `airline_name` varchar(100) DEFAULT NULL,
  `callsign` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `comments` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblairline`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `tblairlineuser`
--

CREATE TABLE `tblairlineuser` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblairlineuser`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `tblairport`
--

CREATE TABLE `tblairport` (
  `id` int(11) NOT NULL,
  `iata` varchar(10) DEFAULT NULL,
  `icao` varchar(10) DEFAULT NULL,
  `airport_name` varchar(100) DEFAULT NULL,
  `location_serve` varchar(50) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `dst` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblairport`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `tblflightroute`
--

CREATE TABLE `tblflightroute` (
  `id` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL,
  `oapid` int(11) DEFAULT NULL,
  `dapid` int(11) DEFAULT NULL,
  `round_trip` tinyint(1) DEFAULT NULL,
  `acid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblflightroute`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `tblflightschedule`
--

CREATE TABLE `tblflightschedule` (
  `id` int(11) NOT NULL,
  `auid` int(11) DEFAULT NULL,
  `frid` int(11) DEFAULT NULL,
  `date_departure` date DEFAULT NULL,
  `time_departure` time DEFAULT NULL,
  `date_arrival` date DEFAULT NULL,
  `time_arrival` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblflightschedule`
--

INSERT INTO `tblflightschedule` (`id`, `auid`, `frid`, `date_departure`, `time_departure`, `date_arrival`, `time_arrival`, `status`) VALUES
(1, 1, 1, '2025-09-01', '08:30:00', '2025-09-01', '11:15:00', 'scheduled'),
(2, 2, 2, '2025-09-02', '14:00:00', '2025-09-02', '16:45:00', 'scheduled'),
(3, 3, 3, '2025-09-03', '06:15:00', '2025-09-03', '08:40:00', 'delayed'),
(4, 4, 4, '2025-09-04', '20:00:00', '2025-09-04', '00:15:00', 'scheduled'),
(5, 5, 5, '2025-09-05', '09:45:00', '2025-09-05', '13:10:00', 'cancelled'),
(6, 6, 6, '2025-09-06', '12:30:00', '2025-09-06', '15:55:00', 'arrived'),
(7, 7, 7, '2025-09-07', '05:30:00', '2025-09-07', '07:20:00', 'scheduled'),
(8, 8, 8, '2025-09-08', '17:25:00', '2025-09-08', '21:00:00', 'scheduled'),
(9, 9, 9, '2025-09-09', '10:00:00', '2025-09-09', '13:25:00', 'scheduled'),
(10, 10, 10, '2025-09-10', '19:45:00', '2025-09-10', '22:30:00', 'scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaircraft`
--
ALTER TABLE `tblaircraft`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblairline`
--
ALTER TABLE `tblairline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblairlineuser`
--
ALTER TABLE `tblairlineuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `tblairport`
--
ALTER TABLE `tblairport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblflightroute`
--
ALTER TABLE `tblflightroute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`),
  ADD KEY `oapid` (`oapid`),
  ADD KEY `dapid` (`dapid`),
  ADD KEY `acid` (`acid`);

--
-- Indexes for table `tblflightschedule`
--
ALTER TABLE `tblflightschedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auid` (`auid`),
  ADD KEY `frid` (`frid`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaircraft`
--
ALTER TABLE `tblaircraft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblairline`
--
ALTER TABLE `tblairline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblairlineuser`
--
ALTER TABLE `tblairlineuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblairport`
--
ALTER TABLE `tblairport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tblflightroute`
--
ALTER TABLE `tblflightroute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblflightschedule`
--
ALTER TABLE `tblflightschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblairlineuser`
--
ALTER TABLE `tblairlineuser`
  ADD CONSTRAINT `tblairlineuser_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `tblairline` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tblflightroute`
--
ALTER TABLE `tblflightroute`
  ADD CONSTRAINT `tblflightroute_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `tblairline` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tblflightroute_ibfk_2` FOREIGN KEY (`oapid`) REFERENCES `tblairport` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tblflightroute_ibfk_3` FOREIGN KEY (`dapid`) REFERENCES `tblairport` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tblflightroute_ibfk_4` FOREIGN KEY (`acid`) REFERENCES `tblaircraft` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tblflightschedule`
--
ALTER TABLE `tblflightschedule`
  ADD CONSTRAINT `tblflightschedule_ibfk_1` FOREIGN KEY (`auid`) REFERENCES `tblairlineuser` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tblflightschedule_ibfk_2` FOREIGN KEY (`frid`) REFERENCES `tblflightroute` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
