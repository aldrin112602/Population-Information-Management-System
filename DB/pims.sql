-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 02:19 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pims`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `address` varchar(300) NOT NULL,
  `contact` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `profile` varchar(2000) NOT NULL,
  `role` varchar(225) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `unique_id`, `barangay`, `municipality`, `province`, `username`, `password`, `address`, `contact`, `email`, `profile`, `role`, `date`) VALUES
(1, 'null', 'null', 'null', 'Quirino', 'super_admin', 'super_admin', 'Lorem Ipsum Dolor Sit Amet', '09102426684', 'super_admin@gmail.com', './profile/64d19b5b755852.39039664.avif', 'super_admin', '2023-07-29 01:08:00'),
(23, '6541c993c343b', 'Sampaloc', 'Tanay', 'Rizal', 'Staff_Aldrin', 'Staff_Aldrin', '', '', '', '', 'admin', '2023-11-01 03:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(500) NOT NULL,
  `barangay` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `unique_id`, `barangay`, `date`) VALUES
(22, '6541c993c343b', 'Sampaloc', '2023-11-01 03:44:19'),
(23, '6544347251ca3', 'Teresa', '2023-11-02 23:44:50'),
(24, '65489c3a25fee', 'Kaybuto', '2023-11-06 07:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records`
--

CREATE TABLE `survey_form_records` (
  `id` int(11) NOT NULL,
  `belongs_to` varchar(100) DEFAULT NULL,
  `household_id` varchar(100) DEFAULT NULL,
  `household` varchar(100) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `artificialFamilyPlanningMethod` text NOT NULL,
  `permanentFamilyPlanningMethod` text NOT NULL,
  `naturalFamilyPlanningMethod` text NOT NULL,
  `attendedResponsibleParentingMovementClass` varchar(255) NOT NULL,
  `typeOfHousingUnitOccupied` varchar(255) NOT NULL,
  `subTypeOfHousingUnitOccupied` text NOT NULL,
  `typeOfHouseLightUsed` varchar(255) NOT NULL,
  `typeOfWaterSupply` text NOT NULL,
  `typeOfToilet` varchar(255) NOT NULL,
  `typeOfGarbageDisposal` text NOT NULL,
  `communicationFacility` text NOT NULL,
  `transportFacility` text NOT NULL,
  `agriculturalProduct` text NOT NULL,
  `poultryNumberOfHeadsChicken` varchar(255) NOT NULL,
  `poultryNumberOfHeadsDuck` varchar(255) NOT NULL,
  `poultryNumberOfHeadsGeese` varchar(255) NOT NULL,
  `poultryNumberOfHeadsTurkey` varchar(255) NOT NULL,
  `poultryOthers` varchar(255) NOT NULL,
  `poultryNumberOfHeadsOthers` varchar(255) NOT NULL,
  `livestockNumberPig` varchar(255) NOT NULL,
  `livestockNumberGoat` varchar(255) NOT NULL,
  `livestockNumberSheep` varchar(255) NOT NULL,
  `livestockNumberCoat` varchar(255) NOT NULL,
  `livestockNumberCarabao` varchar(2555) NOT NULL,
  `livestockNumberHorse` varchar(255) NOT NULL,
  `othersLivestock` varchar(255) NOT NULL,
  `livestockNumberOthers` varchar(255) NOT NULL,
  `otherSourceOfIncome` text NOT NULL,
  `fishpondOwned` varchar(255) NOT NULL,
  `fishpondOwnedArea` varchar(255) NOT NULL,
  `landOwned` varchar(255) NOT NULL,
  `landOwnedRiceFieldArea` varchar(255) NOT NULL,
  `landOwnedCornFieldArea` varchar(255) NOT NULL,
  `land` varchar(255) NOT NULL,
  `caretakerRiceArea` varchar(255) NOT NULL,
  `caretakerCornArea` varchar(255) NOT NULL,
  `caretakerOthersLandOwned` varchar(255) NOT NULL,
  `monthlyAverageFamilyIncome` varchar(255) NOT NULL,
  `filter_month` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records`
--

INSERT INTO `survey_form_records` (`id`, `belongs_to`, `household_id`, `household`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `artificialFamilyPlanningMethod`, `permanentFamilyPlanningMethod`, `naturalFamilyPlanningMethod`, `attendedResponsibleParentingMovementClass`, `typeOfHousingUnitOccupied`, `subTypeOfHousingUnitOccupied`, `typeOfHouseLightUsed`, `typeOfWaterSupply`, `typeOfToilet`, `typeOfGarbageDisposal`, `communicationFacility`, `transportFacility`, `agriculturalProduct`, `poultryNumberOfHeadsChicken`, `poultryNumberOfHeadsDuck`, `poultryNumberOfHeadsGeese`, `poultryNumberOfHeadsTurkey`, `poultryOthers`, `poultryNumberOfHeadsOthers`, `livestockNumberPig`, `livestockNumberGoat`, `livestockNumberSheep`, `livestockNumberCoat`, `livestockNumberCarabao`, `livestockNumberHorse`, `othersLivestock`, `livestockNumberOthers`, `otherSourceOfIncome`, `fishpondOwned`, `fishpondOwnedArea`, `landOwned`, `landOwnedRiceFieldArea`, `landOwnedCornFieldArea`, `land`, `caretakerRiceArea`, `caretakerCornArea`, `caretakerOthersLandOwned`, `monthlyAverageFamilyIncome`, `filter_month`) VALUES
(1, '', '654899e1b4485', '', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'Pills', 'Vasectomy', 'Two-day Method', 'Yes', 'Owned', 'Duplex', 'Electricity', '', 'Water-sealed shared with other HH', 'Burying', 'Television, Radio, Mobile Phone', 'Van', 'Rice, Corn, Taro/Gabi', '23', '1', '8', '20', '', '', '10', '5', '5', '34', '2', '1', 'Dinosaur', '12', 'Sari-sari store, Restaurant', 'Without', '', '', '', '', 'Lease, Teanant', '', '', '', '30,000.00 - 69,000.00', '2023-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_children`
--

CREATE TABLE `survey_form_records_children` (
  `id` int(11) NOT NULL,
  `belongs_to` varchar(100) DEFAULT NULL,
  `household_id` varchar(100) DEFAULT NULL,
  `household` varchar(100) NOT NULL,
  `life_status` varchar(100) DEFAULT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `educationalAttainment` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthPlace` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `placeOfWork` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `ethnicGroup` varchar(255) DEFAULT NULL,
  `filter_month` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_children`
--

INSERT INTO `survey_form_records_children` (`id`, `belongs_to`, `household_id`, `household`, `life_status`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`, `filter_month`) VALUES
(6, '', '6541ca148585e', 'Genersito Caballero', '', '6541c993c343b', '3', 'Sampaloc', 'Tanay', 'Rizal', 'Aldrin E Caballero', 'Single', 'children', '2002-11-26', 'some-college', 20, 'Male', 'Sta. Maria Laguna', 'NA', 'NA', 'Members of the Church of God International', ' Tagalog', '2023-11-06'),
(10, '', '654899e1b4485', 'Lorem Ipsum', 'Living', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'John Doe', 'Single', 'children', '2002-02-22', ' bachelor-degree', 21, 'Male', 'Lorem ipsum', 'Construction', 'Secret', ' Iglesia ni Cristo', ' Ifugao', '2023-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_household_member`
--

CREATE TABLE `survey_form_records_household_member` (
  `id` int(11) NOT NULL,
  `belongs_to` varchar(100) DEFAULT NULL,
  `household_id` varchar(100) DEFAULT NULL,
  `household` varchar(100) NOT NULL,
  `life_status` varchar(100) DEFAULT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `educationalAttainment` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthPlace` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `placeOfWork` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `ethnicGroup` varchar(255) DEFAULT NULL,
  `filter_month` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_household_member`
--

INSERT INTO `survey_form_records_household_member` (`id`, `belongs_to`, `household_id`, `household`, `life_status`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`, `filter_month`) VALUES
(1, '', '6541ca148585e', 'Genersito Caballero', '', '6541c993c343b', '3', 'Sampaloc', 'Tanay', 'Rizal', 'Lhiana C Montances', 'Single', 'household', '2015-11-01', 'elementary-school', 8, 'Female', 'Sampaloc', 'NA', 'NA', ' Iglesia ni Cristo', ' Tagalog', '2023-11-06'),
(4, '', '654899e1b4485', '', 'Living', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'kevin Durant', 'Divorced', 'household', '2003-03-31', ' some-college', 20, 'Male', 'Negross Occidental', 'Farmer', 'Awan', ' Buddhism', ' Bisaya', '2023-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_husband`
--

CREATE TABLE `survey_form_records_husband` (
  `id` int(11) NOT NULL,
  `belongs_to` varchar(100) DEFAULT NULL,
  `household_id` varchar(100) DEFAULT NULL,
  `household` varchar(100) NOT NULL,
  `life_status` varchar(100) DEFAULT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `educationalAttainment` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthPlace` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `placeOfWork` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `ethnicGroup` varchar(255) DEFAULT NULL,
  `filter_month` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_husband`
--

INSERT INTO `survey_form_records_husband` (`id`, `belongs_to`, `household_id`, `household`, `life_status`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`, `filter_month`) VALUES
(1, NULL, '6541ca148585e', 'Genersito Caballero', 'Living', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'Genersito A Caballero', 'Married', 'husband', '1954-07-23', 'elementary-school', 69, 'Male', 'Negross Occidental', 'farmer', 'sampaloc', 'Members of the Church of God International', 'Bisaya', '2023-11-06'),
(7, '', '654899e1b4485', 'Lorem Ipsum', 'Living', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'Lorem Ipsum', 'Married', 'husband', '2000-11-26', 'bachelor-degree', 22, 'Male', 'Lorem ipsum', 'web dev', 'Pampanga', 'Roman Catholicism', 'English', '2023-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_wife`
--

CREATE TABLE `survey_form_records_wife` (
  `id` int(11) NOT NULL,
  `belongs_to` varchar(100) DEFAULT NULL,
  `household_id` varchar(100) DEFAULT NULL,
  `household` varchar(100) NOT NULL,
  `life_status` varchar(100) DEFAULT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `educationalAttainment` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthPlace` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `placeOfWork` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `ethnicGroup` varchar(255) DEFAULT NULL,
  `filter_month` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_wife`
--

INSERT INTO `survey_form_records_wife` (`id`, `belongs_to`, `household_id`, `household`, `life_status`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`, `filter_month`) VALUES
(1, '', '6541ca148585e', 'Genersito Caballero', '', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'Servina Caballero', 'Married', 'wife', '1964-05-02', 'elementary-school', 59, 'Female', 'Zamboanga', 'Vendor', 'sampaloc', ' Roman Catholicism', ' Bisaya', '2023-11-06'),
(6, '', '654899e1b4485', 'Lorem Ipsum', 'Living', '6541c993c343b', '1', 'Sampaloc', 'Tanay', 'Rizal', 'Lorem Ipsum', 'Married', 'wife', '2000-11-11', ' master-degree', 22, 'Female', 'Lorem ipsum', 'NA', 'Secret', ' Islam', ' Ilocano', '2023-11-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form_records`
--
ALTER TABLE `survey_form_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form_records_children`
--
ALTER TABLE `survey_form_records_children`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form_records_household_member`
--
ALTER TABLE `survey_form_records_household_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form_records_husband`
--
ALTER TABLE `survey_form_records_husband`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form_records_wife`
--
ALTER TABLE `survey_form_records_wife`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `survey_form_records`
--
ALTER TABLE `survey_form_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `survey_form_records_children`
--
ALTER TABLE `survey_form_records_children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `survey_form_records_household_member`
--
ALTER TABLE `survey_form_records_household_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `survey_form_records_husband`
--
ALTER TABLE `survey_form_records_husband`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `survey_form_records_wife`
--
ALTER TABLE `survey_form_records_wife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
