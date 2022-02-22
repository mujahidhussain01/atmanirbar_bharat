-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2022 at 10:46 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finance_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `upi` varchar(255) DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Email`, `Password`, `account_holder_name`, `bank_name`, `account_no`, `ifsc_code`, `upi`, `mobile`) VALUES
(1, 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `f_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `f_type` enum('HELP','FEEDBACK') DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `f_doc` timestamp NOT NULL DEFAULT current_timestamp(),
  `f_dom` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `read_status` enum('READ','UNREAD') DEFAULT 'UNREAD'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_by` enum('ADMIN','MANAGER') DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 'R9OH5BHSKP8XELMQGMC6OBAZ', 0, 0, 0, '103.61.255.204', 10);

-- --------------------------------------------------------

--
-- Table structure for table `loan_apply`
--

CREATE TABLE `loan_apply` (
  `la_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `loan_status` enum('PENDING','APPROVED','REJECTED','PAID','RUNNING') NOT NULL DEFAULT 'PENDING',
  `loan_start_date` date DEFAULT NULL,
  `loan_end_date` date DEFAULT NULL,
  `reject_comment` varchar(255) DEFAULT NULL,
  `payable_amt` int(11) DEFAULT NULL,
  `remaining_balance` int(11) DEFAULT NULL,
  `loan_closer_amount` int(11) DEFAULT NULL,
  `panelty_status` enum('ACTIVE','INACTIVE','','') NOT NULL DEFAULT 'INACTIVE',
  `panelty_calc_date` date DEFAULT NULL,
  `loan_panelty_days` int(11) NOT NULL,
  `loan_panelty_amount` int(11) NOT NULL,
  `money_paid` enum('ACTIVE','INACTIVE','','') DEFAULT 'INACTIVE',
  `money_return` enum('ACTIVE','INACTIVE','','') NOT NULL DEFAULT 'INACTIVE',
  `amount` varchar(11) DEFAULT NULL,
  `rate_of_interest` varchar(11) DEFAULT NULL,
  `process_fee_percent` varchar(11) DEFAULT NULL,
  `processing_fee` varchar(11) DEFAULT NULL,
  `loan_duration` varchar(11) DEFAULT NULL,
  `payment_mode` enum('daily','weekly','every-15-days','monthly') DEFAULT 'monthly',
  `bouncing_charges_percent` varchar(11) DEFAULT NULL,
  `bouncing_charges` varchar(11) DEFAULT NULL,
  `emi_amount` varchar(11) DEFAULT NULL,
  `la_doc` timestamp NULL DEFAULT current_timestamp(),
  `la_dom` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `la_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_extension`
--

CREATE TABLE `loan_extension` (
  `le_id` int(11) NOT NULL,
  `la_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ext_days` int(11) DEFAULT NULL,
  `ext_charges` int(11) DEFAULT NULL,
  `extention_status` enum('PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `last_loan_end_date` timestamp NULL DEFAULT NULL,
  `le_doc` timestamp NOT NULL DEFAULT current_timestamp(),
  `le_dom` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `reject_comment` longtext DEFAULT NULL,
  `le_status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_payments`
--

CREATE TABLE `loan_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `loan_apply_id` int(11) DEFAULT NULL,
  `amount_received_by` enum('ADMIN','MANAGER') DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `amount_received` int(11) DEFAULT NULL,
  `amount_received_at` datetime DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `bounce_charges` int(11) DEFAULT NULL,
  `status` enum('INACTIVE','ACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_setting`
--

CREATE TABLE `loan_setting` (
  `lsid` int(11) NOT NULL,
  `loan_name` varchar(100) DEFAULT NULL,
  `loan_type` enum('NORMAL','GROUP','','') NOT NULL DEFAULT 'NORMAL',
  `amount` varchar(11) DEFAULT NULL,
  `rate_of_interest` varchar(11) DEFAULT NULL,
  `process_fee_percent` varchar(11) DEFAULT NULL,
  `processing_fee` varchar(11) DEFAULT NULL,
  `loan_duration` varchar(11) DEFAULT NULL,
  `payment_mode` enum('daily','weekly','every-15-days','monthly') DEFAULT 'monthly',
  `bouncing_charges_percent` varchar(11) DEFAULT NULL,
  `bouncing_charges` varchar(11) DEFAULT NULL,
  `emi_amount` varchar(11) DEFAULT NULL,
  `ls_doc` timestamp NULL DEFAULT current_timestamp(),
  `ls_dom` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ls_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pass_word` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','','') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `name`, `email`, `mobile`, `city`, `pass_word`, `token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'manager 1', 'manager@gmail.com', '8319278918', 'test', 'e10adc3949ba59abbe56e057f20f883e', 'xcq2ofp3gjvcwwjq7a26v4pmfflvf5dp9wb', 'ACTIVE', '2022-02-22 12:10:07', '2022-02-22 12:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `manual_loan_setting`
--

CREATE TABLE `manual_loan_setting` (
  `id` int(11) NOT NULL,
  `rate_of_interest` decimal(4,2) DEFAULT NULL,
  `process_fee_percent` decimal(4,2) DEFAULT NULL,
  `bouncing_charges_percent` decimal(4,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manual_loan_setting`
--

INSERT INTO `manual_loan_setting` (`id`, `rate_of_interest`, `process_fee_percent`, `bouncing_charges_percent`, `created_at`, `updated_at`) VALUES
(1, '8.00', '5.00', '1.00', '2022-02-19 18:47:19', '2022-02-21 11:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notify_id` int(11) NOT NULL,
  `notify_content` varchar(255) DEFAULT NULL,
  `redirect_link` varchar(255) DEFAULT NULL,
  `notifi_for` enum('ADMIN','USER') DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `read_status` enum('ACTIVE','INACTIVE') DEFAULT 'INACTIVE',
  `notify_doc` timestamp NOT NULL DEFAULT current_timestamp(),
  `notify_dom` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `notifi_status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `otp_id` int(20) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `otp` varchar(4) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `past_modified_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'INACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(50) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `adhar_card_front` varchar(255) DEFAULT NULL,
  `adhar_card_back` varchar(255) DEFAULT NULL,
  `pan_card_image` varchar(255) DEFAULT NULL,
  `passbook_image` varchar(255) DEFAULT NULL,
  `pan_card_approved_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') DEFAULT 'NOT_AVAILABLE',
  `pan_card_approved_status_comment` varchar(255) NOT NULL DEFAULT 'Approal Pending',
  `passbook_approved_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `passbook_approved_status_comment` varchar(255) DEFAULT 'Approal Pending',
  `address` varchar(255) DEFAULT NULL,
  `web_user_status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `deviceId` int(25) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `deviceType` int(25) DEFAULT NULL,
  `fcm_token` longtext DEFAULT NULL,
  `userCreationDate` timestamp NULL DEFAULT current_timestamp(),
  `pastModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `p_c_status` enum('INCOMPLETE','COMPLETE') NOT NULL DEFAULT 'INCOMPLETE',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `ecr1` varchar(255) DEFAULT NULL,
  `aadhar_no` varchar(255) DEFAULT NULL,
  `ecr2` varchar(255) DEFAULT NULL,
  `ec1` varchar(255) DEFAULT NULL,
  `ec2` varchar(255) DEFAULT NULL,
  `socialStatus` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `admin_email_shoot` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `aadhar_upload_status` enum('INCOMPLETE','COMPLETE') NOT NULL DEFAULT 'INCOMPLETE',
  `company_upload_status` enum('INCOMPLETE','COMPLETE') DEFAULT 'INCOMPLETE',
  `company_approve_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `company_approve_status_comment` varchar(255) DEFAULT NULL,
  `bank_upload_status` enum('INCOMPLETE','COMPLETE') NOT NULL DEFAULT 'INCOMPLETE',
  `bda_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `bda_status_comment` longtext DEFAULT NULL,
  `ecv_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `ecv_status_comment` longtext DEFAULT NULL,
  `ba_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `ba_status_comment` longtext DEFAULT NULL,
  `pa_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `pa_status_comment` longtext DEFAULT NULL,
  `docv_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `docv_status_comment` longtext DEFAULT NULL,
  `sa_status` enum('PENDING','APPROVED','REJECTED','NOT_AVAILABLE') NOT NULL DEFAULT 'NOT_AVAILABLE',
  `sa_status_comment` longtext DEFAULT NULL,
  `cpa_status` enum('VERIFIED','NOT_VERIFIED') NOT NULL DEFAULT 'NOT_VERIFIED',
  `bank_name` varchar(255) DEFAULT NULL,
  `acc_holder_name` varchar(255) DEFAULT NULL,
  `ifcs_code` varchar(255) DEFAULT NULL,
  `acc_no` varchar(255) DEFAULT NULL,
  `check_image` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `job_type` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `monthly_salary` int(11) DEFAULT NULL,
  `pay_slip_image` varchar(255) DEFAULT NULL,
  `pdf_password` varchar(255) DEFAULT NULL,
  `office_telephone` bigint(11) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `years_of_working` int(2) DEFAULT NULL,
  `income_by` int(11) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `company_address` longtext DEFAULT NULL,
  `default_message` longtext DEFAULT NULL,
  `default_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_app_contacts`
--

CREATE TABLE `user_app_contacts` (
  `uac_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mobileNumber` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uac_doc` timestamp NOT NULL DEFAULT current_timestamp(),
  `uac_dom` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `uac_status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_app_temp_table`
--

CREATE TABLE `user_app_temp_table` (
  `uatt` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `contact` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `loan_apply`
--
ALTER TABLE `loan_apply`
  ADD PRIMARY KEY (`la_id`);

--
-- Indexes for table `loan_extension`
--
ALTER TABLE `loan_extension`
  ADD PRIMARY KEY (`le_id`);

--
-- Indexes for table `loan_payments`
--
ALTER TABLE `loan_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_setting`
--
ALTER TABLE `loan_setting`
  ADD PRIMARY KEY (`lsid`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manual_loan_setting`
--
ALTER TABLE `manual_loan_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`otp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `user_app_contacts`
--
ALTER TABLE `user_app_contacts`
  ADD PRIMARY KEY (`uac_id`);

--
-- Indexes for table `user_app_temp_table`
--
ALTER TABLE `user_app_temp_table`
  ADD PRIMARY KEY (`uatt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_apply`
--
ALTER TABLE `loan_apply`
  MODIFY `la_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_extension`
--
ALTER TABLE `loan_extension`
  MODIFY `le_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_payments`
--
ALTER TABLE `loan_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_setting`
--
ALTER TABLE `loan_setting`
  MODIFY `lsid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manual_loan_setting`
--
ALTER TABLE `manual_loan_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `otp_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_app_contacts`
--
ALTER TABLE `user_app_contacts`
  MODIFY `uac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_app_temp_table`
--
ALTER TABLE `user_app_temp_table`
  MODIFY `uatt` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
