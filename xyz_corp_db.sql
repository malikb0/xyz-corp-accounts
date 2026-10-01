-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2022 at 07:47 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xyz_corp_db`
--
CREATE DATABASE IF NOT EXISTS `xyz_corp_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `xyz_corp_db`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_accounts`
--

CREATE TABLE `tb_accounts` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) NOT NULL,
  `address3` varchar(100) NOT NULL,
  `address4` varchar(100) NOT NULL,
  `arabic_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `arabic_address` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `phones` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `contact_person` varchar(30) DEFAULT NULL,
  `contact_person_phone` varchar(50) DEFAULT NULL,
  `account_type` varchar(20) NOT NULL,
  `bank_details` varchar(250) DEFAULT NULL,
  `vat_reg_no` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `account_balance` decimal(11,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_arbdescription`
--

CREATE TABLE `tb_arbdescription` (
  `arbdes_id` int(5) NOT NULL,
  `eng_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `arb_description` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_arblocation`
--

CREATE TABLE `tb_arblocation` (
  `arbloc_id` int(11) NOT NULL,
  `eng_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `arb_location` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_assignment_co`
--

CREATE TABLE `tb_assignment_co` (
  `asi_id` int(11) NOT NULL,
  `company_Id` int(11) NOT NULL,
  `coordinator_Id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `status` enum('ended','assigned','','') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'assigned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_callout_trips`
--

CREATE TABLE `tb_callout_trips` (
  `trip_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `vendor_type` varchar(20) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `place_from` varchar(200) CHARACTER SET utf8 NOT NULL,
  `place_to` varchar(200) CHARACTER SET utf8 NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `trip_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delay_charges` int(11) NOT NULL DEFAULT '0',
  `customer_vat` int(2) NOT NULL DEFAULT '0',
  `vendor_charges` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `vendor_vat_amount` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `traveling_distance_kms` int(11) NOT NULL DEFAULT '0',
  `trip_description` varchar(100) NOT NULL,
  `waiting_description` varchar(100) CHARACTER SET utf8 NOT NULL,
  `arbdes_id` int(5) DEFAULT NULL,
  `trip_comments` varchar(100) DEFAULT NULL,
  `trip_docs` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_contract_items`
--

CREATE TABLE `tb_contract_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item` int(11) DEFAULT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `customer_vat` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_employees`
--

CREATE TABLE `tb_employees` (
  `emp_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `joining_date` date DEFAULT NULL,
  `emp_status` enum('working','left') NOT NULL DEFAULT 'working',
  `emp_group` enum('administration','operation') DEFAULT NULL,
  `contact_no` char(40) NOT NULL,
  `iqama_no` varchar(10) NOT NULL,
  `voc_balance` int(11) NOT NULL,
  `base_salary` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `housing_allowance` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `emp_pic_url` varchar(80) NOT NULL,
  `Iqama_expire` date DEFAULT NULL,
  `license_expire` date DEFAULT NULL,
  `aramco_id_expire` date DEFAULT NULL,
  `passport_expire` date DEFAULT NULL,
  `iqama_url` varchar(80) DEFAULT NULL,
  `license_url` varchar(80) DEFAULT NULL,
  `aramco_id_url` varchar(80) DEFAULT NULL,
  `passport_url` varchar(80) DEFAULT NULL,
  `other_file` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_expenses`
--

CREATE TABLE `tb_expenses` (
  `exp_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `exp_date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` decimal(12,4) NOT NULL,
  `fatora_url` varchar(80) DEFAULT NULL,
  `vendor_name` varchar(60) DEFAULT NULL,
  `vat_reg_no` varchar(20) DEFAULT NULL,
  `vat_amount` decimal(11,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_investments`
--

CREATE TABLE `tb_investments` (
  `inv_id` int(11) NOT NULL,
  `owner_account` int(11) NOT NULL,
  `cash_account` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `investment_date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `reference_url` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orders`
--

CREATE TABLE `tb_orders` (
  `order_id` int(11) NOT NULL,
  `order_name` varchar(50) NOT NULL,
  `qr_inv` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `order_start_date` date NOT NULL,
  `order_source` varchar(30) NOT NULL,
  `order_type` varchar(20) NOT NULL,
  `order_complete` tinyint(1) NOT NULL DEFAULT '0',
  `order_description` varchar(100) NOT NULL,
  `po_number` varchar(20) DEFAULT '-',
  `invoice_url` varchar(80) DEFAULT NULL,
  `invoice_submission` date DEFAULT NULL,
  `invoicing_term` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_profits`
--

CREATE TABLE `tb_profits` (
  `profit_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `dist_date` date NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rental_equipments`
--

CREATE TABLE `tb_rental_equipments` (
  `re_id` int(11) NOT NULL,
  `equipment_name` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `vendor_type` varchar(30) NOT NULL,
  `rental_date` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `usage_hours` int(11) NOT NULL,
  `vendor_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vendor_vat_amount` decimal(11,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `rental_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_vat` int(2) NOT NULL DEFAULT '0',
  `description` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_salaries`
--

CREATE TABLE `tb_salaries` (
  `sl_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `_date` date DEFAULT NULL,
  `base_salary` int(11) NOT NULL DEFAULT '0',
  `other_allowance` int(11) NOT NULL DEFAULT '0',
  `net_salary` int(11) NOT NULL DEFAULT '0',
  `all_comments` varchar(500) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sf_login`
--

CREATE TABLE `tb_sf_login` (
  `sf_id` int(11) NOT NULL,
  `sf_name` varchar(100) NOT NULL,
  `sf_email` varchar(50) NOT NULL,
  `sf_password` varchar(50) NOT NULL,
  `role` varchar(30) DEFAULT 'standard',
  `db_user` varchar(20) NOT NULL,
  `acnt_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transactions`
--

CREATE TABLE `tb_transactions` (
  `transaction_id` int(11) NOT NULL,
  `cash_amount` decimal(15,4) NOT NULL,
  `account_from` int(11) NOT NULL,
  `account_to` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `reference_url` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_vehicles`
--

CREATE TABLE `tb_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `door_no` varchar(5) DEFAULT NULL,
  `insurance_expire` date DEFAULT NULL,
  `tafweez_expire` date DEFAULT NULL,
  `fahas_expire` date DEFAULT NULL,
  `istamara_expire` date DEFAULT NULL,
  `sticker_expire` date DEFAULT NULL,
  `mzn_card_expire` date DEFAULT NULL,
  `insurance_url` varchar(80) DEFAULT NULL,
  `tafweez_url` varchar(80) NOT NULL,
  `fahas_url` varchar(80) DEFAULT NULL,
  `istamara_url` varchar(80) DEFAULT NULL,
  `sticker_url` varchar(80) DEFAULT NULL,
  `mzn_card_url` varchar(80) DEFAULT NULL,
  `other_file` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_vendor_contracts`
--

CREATE TABLE `tb_vendor_contracts` (
  `contract_id` int(11) NOT NULL,
  `contract_name` varchar(50) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_complete` tinyint(1) NOT NULL,
  `contract_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_vendor_items`
--

CREATE TABLE `tb_vendor_items` (
  `item_id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `item_date` date NOT NULL,
  `drivers` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(13,4) NOT NULL,
  `item_vat_amount` decimal(11,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_accounts`
--
ALTER TABLE `tb_accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_name` (`account_name`);

--
-- Indexes for table `tb_arbdescription`
--
ALTER TABLE `tb_arbdescription`
  ADD PRIMARY KEY (`arbdes_id`),
  ADD UNIQUE KEY `eng_description` (`eng_description`);

--
-- Indexes for table `tb_arblocation`
--
ALTER TABLE `tb_arblocation`
  ADD PRIMARY KEY (`arbloc_id`),
  ADD UNIQUE KEY `eng_location` (`eng_location`);

--
-- Indexes for table `tb_assignment_co`
--
ALTER TABLE `tb_assignment_co`
  ADD PRIMARY KEY (`asi_id`),
  ADD KEY `company_name` (`company_Id`),
  ADD KEY `coordinator_name` (`coordinator_Id`);

--
-- Indexes for table `tb_callout_trips`
--
ALTER TABLE `tb_callout_trips`
  ADD PRIMARY KEY (`trip_id`),
  ADD UNIQUE KEY `orderwise_trips` (`trip_id`,`order_id`) USING BTREE,
  ADD UNIQUE KEY `vendorwise_trips` (`trip_id`,`vendor_id`),
  ADD UNIQUE KEY `driverwise_trips` (`trip_id`,`driver_id`),
  ADD UNIQUE KEY `vehicleswise_trips` (`trip_id`,`vehicle_id`),
  ADD UNIQUE KEY `ukey_order_driver_time` (`order_id`,`driver_id`,`start_time`),
  ADD UNIQUE KEY `arbdeswise_trips` (`trip_id`,`arbdes_id`),
  ADD KEY `vendor_restrict` (`vendor_id`),
  ADD KEY `driver_restrict` (`driver_id`),
  ADD KEY `arbdes_restrict` (`arbdes_id`);

--
-- Indexes for table `tb_contract_items`
--
ALTER TABLE `tb_contract_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `order_wise` (`item_id`,`order_id`),
  ADD KEY `restrict_orders` (`order_id`);

--
-- Indexes for table `tb_employees`
--
ALTER TABLE `tb_employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `Account_ID` (`account_id`);

--
-- Indexes for table `tb_expenses`
--
ALTER TABLE `tb_expenses`
  ADD PRIMARY KEY (`exp_id`),
  ADD UNIQUE KEY `account_idWise` (`exp_id`,`account_id`),
  ADD KEY `restrict_accountid` (`account_id`);

--
-- Indexes for table `tb_investments`
--
ALTER TABLE `tb_investments`
  ADD PRIMARY KEY (`inv_id`),
  ADD UNIQUE KEY `owner_restrict` (`inv_id`,`owner_account`),
  ADD KEY `equity_exist` (`owner_account`);

--
-- Indexes for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_name` (`order_name`),
  ADD KEY `client_orders` (`client_id`,`order_id`);

--
-- Indexes for table `tb_profits`
--
ALTER TABLE `tb_profits`
  ADD PRIMARY KEY (`profit_id`),
  ADD UNIQUE KEY `owner_accout_wise` (`profit_id`,`account_id`),
  ADD KEY `restrict_owner_accounts` (`account_id`);

--
-- Indexes for table `tb_rental_equipments`
--
ALTER TABLE `tb_rental_equipments`
  ADD PRIMARY KEY (`re_id`),
  ADD UNIQUE KEY `orderWise_rentals` (`re_id`,`order_id`),
  ADD UNIQUE KEY `vendorWise_rentals` (`re_id`,`vendor_id`),
  ADD UNIQUE KEY `arabicWise_rentals` (`re_id`),
  ADD KEY `restrict_order` (`order_id`),
  ADD KEY `restrict_vendor` (`vendor_id`);

--
-- Indexes for table `tb_salaries`
--
ALTER TABLE `tb_salaries`
  ADD PRIMARY KEY (`sl_id`),
  ADD UNIQUE KEY `account_id_wise` (`sl_id`,`account_id`);

--
-- Indexes for table `tb_sf_login`
--
ALTER TABLE `tb_sf_login`
  ADD PRIMARY KEY (`sf_id`);

--
-- Indexes for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `accountFromwise_transactions` (`transaction_id`,`account_from`),
  ADD UNIQUE KEY `accountTowise_transactions` (`transaction_id`,`account_to`) USING BTREE,
  ADD KEY `account_restrict` (`account_from`),
  ADD KEY `account_restrict2` (`account_to`);

--
-- Indexes for table `tb_vehicles`
--
ALTER TABLE `tb_vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `Account_ID` (`account_id`);

--
-- Indexes for table `tb_vendor_contracts`
--
ALTER TABLE `tb_vendor_contracts`
  ADD PRIMARY KEY (`contract_id`),
  ADD UNIQUE KEY `contract_name` (`contract_name`),
  ADD UNIQUE KEY `contract_name_2` (`contract_name`,`vendor_id`),
  ADD KEY `vendor_restrict2` (`vendor_id`);

--
-- Indexes for table `tb_vendor_items`
--
ALTER TABLE `tb_vendor_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `vc_id` (`item_id`,`contract_id`),
  ADD KEY `restrict_vendor_contract` (`contract_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_accounts`
--
ALTER TABLE `tb_accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_arbdescription`
--
ALTER TABLE `tb_arbdescription`
  MODIFY `arbdes_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_arblocation`
--
ALTER TABLE `tb_arblocation`
  MODIFY `arbloc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_callout_trips`
--
ALTER TABLE `tb_callout_trips`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_contract_items`
--
ALTER TABLE `tb_contract_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_employees`
--
ALTER TABLE `tb_employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_expenses`
--
ALTER TABLE `tb_expenses`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_investments`
--
ALTER TABLE `tb_investments`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_orders`
--
ALTER TABLE `tb_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_profits`
--
ALTER TABLE `tb_profits`
  MODIFY `profit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_rental_equipments`
--
ALTER TABLE `tb_rental_equipments`
  MODIFY `re_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_salaries`
--
ALTER TABLE `tb_salaries`
  MODIFY `sl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_sf_login`
--
ALTER TABLE `tb_sf_login`
  MODIFY `sf_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_vehicles`
--
ALTER TABLE `tb_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_vendor_contracts`
--
ALTER TABLE `tb_vendor_contracts`
  MODIFY `contract_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_vendor_items`
--
ALTER TABLE `tb_vendor_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_assignment_co`
--
ALTER TABLE `tb_assignment_co`
  ADD CONSTRAINT `company_name` FOREIGN KEY (`company_Id`) REFERENCES `tb_accounts` (`account_id`),
  ADD CONSTRAINT `coordinator_name` FOREIGN KEY (`coordinator_Id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_callout_trips`
--
ALTER TABLE `tb_callout_trips`
  ADD CONSTRAINT `arbdes_restrict` FOREIGN KEY (`arbdes_id`) REFERENCES `tb_arbdescription` (`arbdes_id`),
  ADD CONSTRAINT `driver_restrict` FOREIGN KEY (`driver_id`) REFERENCES `tb_accounts` (`account_id`),
  ADD CONSTRAINT `order_restrict` FOREIGN KEY (`order_id`) REFERENCES `tb_orders` (`order_id`),
  ADD CONSTRAINT `vendor_restrict` FOREIGN KEY (`vendor_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_contract_items`
--
ALTER TABLE `tb_contract_items`
  ADD CONSTRAINT `restrict_orders` FOREIGN KEY (`order_id`) REFERENCES `tb_orders` (`order_id`);

--
-- Constraints for table `tb_employees`
--
ALTER TABLE `tb_employees`
  ADD CONSTRAINT `account_restrict1` FOREIGN KEY (`account_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_expenses`
--
ALTER TABLE `tb_expenses`
  ADD CONSTRAINT `restrict_accountid` FOREIGN KEY (`account_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_investments`
--
ALTER TABLE `tb_investments`
  ADD CONSTRAINT `equity_exist` FOREIGN KEY (`owner_account`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD CONSTRAINT `restrict_client_account` FOREIGN KEY (`client_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_profits`
--
ALTER TABLE `tb_profits`
  ADD CONSTRAINT `restrict_owner_accounts` FOREIGN KEY (`account_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_rental_equipments`
--
ALTER TABLE `tb_rental_equipments`
  ADD CONSTRAINT `restrict_order` FOREIGN KEY (`order_id`) REFERENCES `tb_orders` (`order_id`),
  ADD CONSTRAINT `restrict_vendor` FOREIGN KEY (`vendor_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  ADD CONSTRAINT `account_restrict` FOREIGN KEY (`account_from`) REFERENCES `tb_accounts` (`account_id`),
  ADD CONSTRAINT `account_restrict2` FOREIGN KEY (`account_to`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_vehicles`
--
ALTER TABLE `tb_vehicles`
  ADD CONSTRAINT `account_restrict3` FOREIGN KEY (`account_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_vendor_contracts`
--
ALTER TABLE `tb_vendor_contracts`
  ADD CONSTRAINT `vendor_restrict2` FOREIGN KEY (`vendor_id`) REFERENCES `tb_accounts` (`account_id`);

--
-- Constraints for table `tb_vendor_items`
--
ALTER TABLE `tb_vendor_items`
  ADD CONSTRAINT `restrict_vendor_contract` FOREIGN KEY (`contract_id`) REFERENCES `tb_vendor_contracts` (`contract_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
