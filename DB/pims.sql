-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 02:16 AM
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
(21, '641af565454dda', 'Kalawi', 'Ambot', 'Quirino', 'Xammp', 'Tuto', 'Lorem Ipsum', '09512793354', 'caballeroaldrin02@gmail.com', './profile/64d0960f5296f3.98859780.ico', 'admin', '2023-07-30 10:57:15');

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
(9, '64c348b42d880', 'Ipsum Dolor', '2023-07-28 04:48:52'),
(11, '641af565454dda', 'Kalawi', '2023-07-28 05:00:32'),
(12, '64c34b78a5762', 'Timang', '2023-07-28 05:00:40'),
(16, '64c4772513c07', 'Kaybuto', '2023-07-29 02:19:17'),
(18, '64c6397e2b055', 'Sampaloc', '2023-07-30 10:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records`
--

CREATE TABLE `survey_form_records` (
  `id` int(11) NOT NULL,
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
  `monthlyAverageFamilyIncome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records`
--

INSERT INTO `survey_form_records` (`id`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `artificialFamilyPlanningMethod`, `permanentFamilyPlanningMethod`, `naturalFamilyPlanningMethod`, `attendedResponsibleParentingMovementClass`, `typeOfHousingUnitOccupied`, `subTypeOfHousingUnitOccupied`, `typeOfHouseLightUsed`, `typeOfWaterSupply`, `typeOfToilet`, `typeOfGarbageDisposal`, `communicationFacility`, `transportFacility`, `agriculturalProduct`, `poultryNumberOfHeadsChicken`, `poultryNumberOfHeadsDuck`, `poultryNumberOfHeadsGeese`, `poultryNumberOfHeadsTurkey`, `poultryOthers`, `poultryNumberOfHeadsOthers`, `livestockNumberPig`, `livestockNumberGoat`, `livestockNumberSheep`, `livestockNumberCoat`, `livestockNumberCarabao`, `livestockNumberHorse`, `othersLivestock`, `livestockNumberOthers`, `otherSourceOfIncome`, `fishpondOwned`, `fishpondOwnedArea`, `landOwned`, `landOwnedRiceFieldArea`, `landOwnedCornFieldArea`, `land`, `caretakerRiceArea`, `caretakerCornArea`, `caretakerOthersLandOwned`, `monthlyAverageFamilyIncome`) VALUES
(1, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Pills, Condom, IUD, DMPA', 'Tubal Ligation, Vasectomy', 'Basal Body Temperature (BBT), Cervical Mucus or Billing Method, Sympto-Thermal Method, Lactational Amenorrhea Method (LAM), Standard Days Method (SDM), Two-day Method', 'Yes', 'Rented', 'Temporary - wooden, Makeshift - cogon/bamboo, Single, Duplex, Commercial/industrial/agricultural, Apartment/accessoria/condominium, Improvised barong-barong', 'Buron', 'Tap - (Inside house), Spring, Dug Well, Deep Well, Public Faucet, Public Well, None, on', 'Water-sealed shared with other HH', 'Picked By Garbage Truck, Waste Segregation, Composting, Burning, Burying', 'Cable, Television, Radio, Two-way Radio, Mobile Phone, Landline Phone, None', 'Bicycle, Motorcycle, Tricycle, Jeep, Car, Truck, Van, Kuliglig', 'Rice, Corn, Banana, Taro/Gabi, Cassava', '4', '5', '6', '7', 'Pugo', '8', '9', '10', '11', '12', '13', '14', 'Dinosaur', '15', 'Sari-sari store, Restaurant, Bakeshop, on', 'With', 'Lorem ipsum', 'Rice Field, Corn Field, Lorem ipsum', 'Lorem ipsum', 'Lorem ipsum', 'Lease, Teanant, Caretaker, Corn Field', 'Lorem ipsum', 'Lorem ipsum', 'Lorem ipsum', '70,000 above'),
(2, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Pills, Condom, IUD, DMPA', 'Tubal Ligation, Vasectomy', 'Basal Body Temperature (BBT), Cervical Mucus or Billing Method, Sympto-Thermal Method, Lactational Amenorrhea Method (LAM), Standard Days Method (SDM), Two-day Method', 'Yes', 'Rented', 'Temporary - wooden, Makeshift - cogon/bamboo, Single, Duplex, Commercial/industrial/agricultural, Apartment/accessoria/condominium, Improvised barong-barong', 'Buron', 'Tap - (Inside house), Spring, Dug Well, Deep Well, Public Faucet, Public Well, None, on', 'Water-sealed shared with other HH', 'Picked By Garbage Truck, Waste Segregation, Composting, Burning, Burying', 'Cable, Television, Radio, Two-way Radio, Mobile Phone, Landline Phone, None', 'Bicycle, Motorcycle, Tricycle, Jeep, Car, Truck, Van, Kuliglig', 'Rice, Corn, Banana, Taro/Gabi, Cassava', '4', '5', '6', '7', 'Pugo', '8', '9', '10', '11', '12', '13', '14', 'Dinosaur', '15', 'Sari-sari store, Restaurant, Bakeshop, on', 'With', 'Lorem ipsum', 'Rice Field, Corn Field, Lorem ipsum', 'Lorem ipsum', 'Lorem ipsum', 'Lease, Teanant, Caretaker, Corn Field', 'Lorem ipsum', 'Lorem ipsum', 'Lorem ipsum', '70,000 above'),
(3, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Pills, Condom, IUD, DMPA', 'Tubal Ligation, Vasectomy', 'Basal Body Temperature (BBT), Cervical Mucus or Billing Method, Sympto-Thermal Method, Lactational Amenorrhea Method (LAM), Standard Days Method (SDM), Two-day Method', 'Yes', 'Rented', 'Temporary - wooden, Makeshift - cogon/bamboo, Single, Duplex, Commercial/industrial/agricultural, Apartment/accessoria/condominium, Improvised barong-barong', 'Buron', 'Tap - (Inside house), Spring, Dug Well, Deep Well, Public Faucet, Public Well, None, on', 'Water-sealed shared with other HH', 'Picked By Garbage Truck, Waste Segregation, Composting, Burning, Burying', 'Cable, Television, Radio, Two-way Radio, Mobile Phone, Landline Phone, None', 'Bicycle, Motorcycle, Tricycle, Jeep, Car, Truck, Van, Kuliglig', 'Rice, Corn, Banana, Taro/Gabi, Cassava', '4', '5', '6', '7', 'Pugo', '8', '9', '10', '11', '12', '13', '14', 'Dinosaur', '15', 'Sari-sari store, Restaurant, Bakeshop, on', 'With', 'Lorem ipsum', 'Rice Field, Corn Field, Lorem ipsum', 'Lorem ipsum', 'Lorem ipsum', 'Lease, Teanant, Caretaker, Corn Field', 'Lorem ipsum', 'Lorem ipsum', 'Lorem ipsum', '70,000 above');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_children`
--

CREATE TABLE `survey_form_records_children` (
  `id` int(11) NOT NULL,
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
  `ethnicGroup` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_children`
--

INSERT INTO `survey_form_records_children` (`id`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`) VALUES
(1, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Name 1', 'Single', 'children', '2013-11-01', ' elementary-school', 9, 'Male', 'Lorem ipsum', 'NA', 'Lorem ipsum', ' Iglesia ni Cristo', ' Tagalog'),
(2, '641af565454dda', 'Purok 2', 'Kalawi', 'Ambot', 'Quirino', '10', 'Single', 'children', '2015-04-04', ' elementary-school', 10, 'Female', 'Lorem ipsum', 'NA', 'Lorem ipsum', 'MCGI', 'Ilocano'),
(3, '641af565454dda', 'Purok 3', 'Kalawi', 'Ambot', 'Quirino', '11', 'Single', 'children', '2015-04-04', ' elementary-school', 11, 'Female', 'Lorem ipsum', 'NA', 'Lorem ipsum', 'MCGI', 'Kapampangan');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_household_member`
--

CREATE TABLE `survey_form_records_household_member` (
  `id` int(11) NOT NULL,
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
  `ethnicGroup` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_household_member`
--

INSERT INTO `survey_form_records_household_member` (`id`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`) VALUES
(1, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Name 1', 'Single', 'household', '2014-04-04', ' elementary-school', 9, 'Female', 'Lorem ipsum', 'NA', 'Lorem ipsum', ' Iglesia ni Cristo', ' Tagalog'),
(2, '641af565454dda', 'Purok 2', 'Kalawi', 'Ambot', 'Quirino', 'Name 2', 'Married', 'household', '1999-04-04', ' bachelor-degree', 24, 'Male', 'Lorem ipsum', 'web dev', 'Lorem ipsum', 'Shinto', 'Cebuano');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_husband`
--

CREATE TABLE `survey_form_records_husband` (
  `id` int(11) NOT NULL,
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
  `ethnicGroup` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_husband`
--

INSERT INTO `survey_form_records_husband` (`id`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`) VALUES
(1, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Name  1', 'Single', 'husband', '2002-02-22', 'bachelor-degree', 21, 'Male', 'Birth Place 1', 'NA', 'Lorem ipsum', 'Roman Catholicism', 'Tagalog'),
(3, '641af565454dda', 'Purok 2', 'Kalawi', 'Ambot', 'Quirino', 'Name  2', 'Widowed', 'husband', '2002-02-22', 'bachelor-degree', 21, 'Male', 'Birth Place 2', 'NA', 'Lorem ipsum', 'Iglesia ni Cristo', 'English'),
(4, '641af565454dda', 'Purok 3', 'Kalawi', 'Ambot', 'Quirino', 'Name 3', 'Single', 'husband', '2002-02-22', 'bachelor-degree', 21, 'Male', 'Birth Place 3', 'NA', 'Lorem ipsum', 'Buddhism', 'Tagalog');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form_records_wife`
--

CREATE TABLE `survey_form_records_wife` (
  `id` int(11) NOT NULL,
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
  `ethnicGroup` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_form_records_wife`
--

INSERT INTO `survey_form_records_wife` (`id`, `unique_id`, `purok`, `barangay`, `municipality`, `province`, `name`, `status`, `type`, `dateOfBirth`, `educationalAttainment`, `age`, `sex`, `birthPlace`, `occupation`, `placeOfWork`, `religion`, `ethnicGroup`) VALUES
(1, '641af565454dda', 'Purok 1', 'Kalawi', 'Ambot', 'Quirino', 'Name 1', 'Married', 'wife', '2002-11-11', ' master-degree', 20, 'Female', 'Birth Place 1', 'NA', 'Lorem ipsum', 'Jehovah\'s Witnesses', ' Tagalog'),
(12, '641af565454dda', 'Purok 2', 'Kalawi', 'Ambot', 'Quirino', 'Name 1', 'Divorce', 'wife', '2002-11-11', ' master-degree', 20, 'Female', 'Birth Place 1', 'NA', 'Lorem ipsum', 'Buddhism', 'Cebuano'),
(13, '641af565454dda', 'Purok 3', 'Kalawi', 'Ambot', 'Quirino', 'Name 1', 'Single', 'wife', '2002-11-11', ' master-degree', 20, 'Female', 'Birth Place 1', 'lorem', 'Lorem ipsum', 'Jewish', 'Cebuano'),
(14, '641af565454dda', 'Purok 4', 'Kalawi', 'Ambot', 'Quirino', 'Name 1', 'Married', 'wife', '2002-11-11', ' master-degree', 20, 'Female', 'Birth Place 1', 'NA', 'Lorem ipsum', 'Jehovah\'s Witnesses', 'Spanish');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `survey_form_records`
--
ALTER TABLE `survey_form_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `survey_form_records_children`
--
ALTER TABLE `survey_form_records_children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `survey_form_records_household_member`
--
ALTER TABLE `survey_form_records_household_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `survey_form_records_husband`
--
ALTER TABLE `survey_form_records_husband`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `survey_form_records_wife`
--
ALTER TABLE `survey_form_records_wife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
