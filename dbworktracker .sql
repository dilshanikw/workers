-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2021 at 12:55 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbworktracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_subtask`
--

CREATE TABLE `assign_subtask` (
  `assigntaskID` int(11) NOT NULL,
  `subtaskID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL,
  `assign_dte` date NOT NULL,
  `assigntask_targetdte` date NOT NULL,
  `complete_presentage` int(11) DEFAULT NULL,
  `complete_status` int(11) DEFAULT NULL,
  `decline_reason` varchar(900) DEFAULT NULL,
  `assigntask_createby` int(11) NOT NULL,
  `assigntask_createdte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign_subtask`
--

INSERT INTO `assign_subtask` (`assigntaskID`, `subtaskID`, `taskID`, `projectID`, `staffID`, `assign_dte`, `assigntask_targetdte`, `complete_presentage`, `complete_status`, `decline_reason`, `assigntask_createby`, `assigntask_createdte`) VALUES
(1, 1, 2, 1, 1, '2021-08-22', '2021-08-19', 100, 1, NULL, 2, '2021-08-23 01:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `assign_task`
--

CREATE TABLE `assign_task` (
  `assigntask_id` int(11) NOT NULL,
  `task_ID` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_ID` int(11) NOT NULL,
  `taskassign_Date` date NOT NULL,
  `taskassign_targerDate` date NOT NULL,
  `taskassign_complete_presentage` int(11) DEFAULT NULL,
  `taskassign_complete_status` int(11) DEFAULT NULL,
  `taskassign_decline_reason` varchar(900) DEFAULT NULL,
  `taskassign_createby` int(11) NOT NULL,
  `taskassign_createdte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign_task`
--

INSERT INTO `assign_task` (`assigntask_id`, `task_ID`, `project_id`, `staff_ID`, `taskassign_Date`, `taskassign_targerDate`, `taskassign_complete_presentage`, `taskassign_complete_status`, `taskassign_decline_reason`, `taskassign_createby`, `taskassign_createdte`) VALUES
(1, 1, 1, 2, '2021-08-22', '2021-09-04', 100, 1, NULL, 2, '2021-08-23 01:26:18'),
(2, 1, 1, 1, '2021-08-22', '2021-08-19', 0, 0, NULL, 2, '2021-08-23 01:29:24'),
(3, 2, 1, 1, '2021-08-22', '2021-08-31', 100, 1, NULL, 2, '2021-08-23 01:29:52'),
(4, 3, 3, 1, '2021-09-03', '2021-09-04', 100, 1, NULL, 2, '2021-09-03 12:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceID` int(11) NOT NULL,
  `attendDate` date NOT NULL,
  `staffID` int(11) NOT NULL,
  `attendaneCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attendaneCreateBy` int(11) NOT NULL,
  `attendance_outdte` datetime DEFAULT NULL,
  `attendance_outperson` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceID`, `attendDate`, `staffID`, `attendaneCreateDate`, `attendaneCreateBy`, `attendance_outdte`, `attendance_outperson`) VALUES
(1, '2021-07-30', 2, '2021-07-30 08:00:00', 2, '2021-07-30 14:50:00', 2),
(2, '2021-07-30', 1, '2021-07-30 08:27:09', 1, '2021-07-30 15:04:31', 1),
(3, '2021-08-02', 2, '2021-08-02 09:46:16', 2, '2021-08-02 15:04:31', 2),
(4, '2021-08-02', 3, '2021-08-02 09:00:00', 3, '2021-08-02 16:25:34', 3),
(5, '2021-08-03', 2, '2021-08-03 08:25:00', 2, '2021-08-03 17:34:34', 2),
(6, '2021-08-03', 3, '2021-08-03 08:10:00', 3, '2021-08-03 16:25:34', 3),
(7, '2021-08-04', 3, '2021-08-04 09:07:00', 3, '2021-08-04 16:04:32', 3),
(8, '2021-08-05', 2, '2021-08-05 08:34:40', 2, '2021-08-05 15:15:32', 2),
(9, '2021-08-05', 3, '2021-08-05 09:08:20', 3, '2021-08-05 16:15:04', 3),
(10, '2021-08-06', 3, '2021-08-06 10:01:00', 3, '2021-08-06 16:35:34', 3),
(11, '2021-08-02', 1, '2021-08-02 10:01:00', 1, '2021-08-02 16:35:34', 1),
(12, '2021-08-03', 1, '2021-08-03 10:05:00', 1, '2021-08-03 15:35:44', 1),
(13, '2021-08-04', 1, '2021-08-04 09:15:00', 1, '2021-08-04 15:45:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chatID` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `senderuserlevel` varchar(150) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `receiver_userlevel` varchar(150) NOT NULL,
  `message` varchar(600) NOT NULL,
  `sent_dte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coordinator`
--

CREATE TABLE `coordinator` (
  `codinator_key` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(300) DEFAULT NULL,
  `address3` varchar(300) DEFAULT NULL,
  `city` varchar(200) NOT NULL,
  `contactno` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_pic` varchar(300) DEFAULT NULL,
  `user_name` varchar(15) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_level` varchar(20) NOT NULL,
  `theme` varchar(50) DEFAULT NULL,
  `create_dte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coordinator`
--

INSERT INTO `coordinator` (`codinator_key`, `staff_id`, `first_name`, `lastname`, `address1`, `address2`, `address3`, `city`, `contactno`, `email`, `profile_pic`, `user_name`, `password`, `user_level`, `theme`, `create_dte`, `createby`) VALUES
(1, '1', 'admin', '', 'UCSC', 'UCSC', 'UCSC', 'Colombo', '', 'elcucsc@gmail.com', 'admin.jpg', 'admin', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'admin', 'dark-mode', '2021-08-23 00:17:09', 0),
(2, '2', 'Pasan', 'Weerarathna', '87/12', '2nd Avenue', 'Suwarapola', 'Piliyandala', '0778292363', 'dilweeraratne@gmail.com', 'default.png', 'pasan', 'ec53e4bac9095b5868bc7646622730e0', 'Coordinator', 'light-mode', '2021-08-23 00:27:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `leaveID` int(1) NOT NULL,
  `leaveStartDate` date NOT NULL,
  `leaveEndDate` date NOT NULL,
  `staffID` int(11) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `approvelStatus` int(11) DEFAULT NULL,
  `leavecreatedBy` int(11) NOT NULL,
  `leavecreate_dte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`leaveID`, `leaveStartDate`, `leaveEndDate`, `staffID`, `reason`, `approvelStatus`, `leavecreatedBy`, `leavecreate_dte`) VALUES
(1, '2021-08-30', '2021-08-30', 2, 'To attend a wedding', 1, 2, '2021-08-25 20:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `projectID` int(11) NOT NULL,
  `projectName` varchar(100) NOT NULL,
  `projectDesc` varchar(300) NOT NULL,
  `startDate` date NOT NULL,
  `targetDate` date NOT NULL,
  `client` varchar(50) DEFAULT NULL,
  `responsiblePerson` int(50) NOT NULL,
  `complete_dte` date DEFAULT NULL,
  `cancelled_date` date DEFAULT NULL,
  `project_status` int(11) NOT NULL,
  `CreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreateBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projectID`, `projectName`, `projectDesc`, `startDate`, `targetDate`, `client`, `responsiblePerson`, `complete_dte`, `cancelled_date`, `project_status`, `CreateDate`, `CreateBy`) VALUES
(1, 'Content Create for Web Module - BIT', 'Here are the key topics covered under the introduction to web designing:\r\n\r\nHow to design a website\r\nCreating different themes for different layouts\r\nHow to design the look and feel of a website\r\nHow to create and design banners, advertisements, etc.\r\nLearning about the tools and techniques of web d', '2021-07-01', '2021-09-30', 'UCSC', 2, NULL, NULL, 0, '2021-08-23 01:05:05', 2),
(2, 'Online Magazine ', 'A New Online Magazine to be started by ABC College.', '2021-08-27', '2021-12-31', 'ABC College', 2, NULL, NULL, 0, '2021-08-26 13:26:13', 2),
(3, 'Online Examination', 'Assisting for Online Examinations', '2021-08-01', '2021-09-30', 'Education Faculty', 1, '2021-09-03', NULL, 1, '2021-08-26 13:28:02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `empno` int(50) NOT NULL,
  `staff_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `namewithinitials` varchar(100) NOT NULL,
  `address1` text NOT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `city` varchar(200) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `qualifications` varchar(500) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `job_description` varchar(400) DEFAULT NULL,
  `profile_pic` varchar(300) DEFAULT NULL,
  `user_name` varchar(15) NOT NULL,
  `user_level` varchar(20) NOT NULL,
  `password` varchar(150) NOT NULL,
  `theme` varchar(50) DEFAULT NULL,
  `resetpawrequest_status` int(11) DEFAULT NULL,
  `create_dte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`empno`, `staff_id`, `firstname`, `lastname`, `namewithinitials`, `address1`, `address2`, `address3`, `city`, `contact_no`, `email`, `qualifications`, `appointment_date`, `job_description`, `profile_pic`, `user_name`, `user_level`, `password`, `theme`, `resetpawrequest_status`, `create_dte`, `create_by`) VALUES
(1, '100', 'Janaki', 'Senevirathna', 'J. A. P. Senevirathna', 'No. 12', 'Araliya Road', '', 'Nugegoda', '0778292363', 'janaki@ucsc.lk', NULL, '2021-01-02', 'Staff Member', 'default.png', 'Janaki', 'Staff', '1b4f0f64bcd7f33cca2536623c84baec', 'light-mode', NULL, '2021-08-23 00:28:58', 1),
(2, '101', 'Malinga', 'Weerasinghe', 'M. Weerasinghe', '92/C', 'Sunimal Lane', 'Walana Road', 'Panadura', '0776543522', 'malinga@gmail.com', 'BIT (UCSC)', '2020-08-01', 'staff member', 'prof2.png', 'malinga', 'Staff', '0f0e418e0223e9310b8654d57e58bfde', 'light-mode', NULL, '2021-08-23 00:32:20', 1),
(3, '105', 'Thilina', 'Rathnayake', 'T. A. D. Rathnayake', '342', '1st Lane', '', 'Nugegoda', '0778457896', 'thilini@ucsc.lk', NULL, '2021-04-01', 'In addition to staff activities, taking attendace reports, leave reports', 'default.png', 'thilina', 'Management Assistant', '6cfc9656d8f9d42fdd8eee0f141d4f30', 'light-mode', NULL, '2021-08-30 15:17:17', 1),
(4, '104', 'Thamali', 'Ranasinghe', 'T. M. Ranasinghe', '43', 'Lawrence Road', '', 'Colombo-03', '0786253651', 'thamali@ucsc.lk', NULL, '2020-02-05', 'Managing Attendance Reports and Leave Reports', 'default.png', 'thamali', 'Assistant Registrar', '222197ab09c7b01128f609058a4910fb', 'dark-mode', NULL, '2021-08-30 15:51:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffmaintask_progress_details`
--

CREATE TABLE `staffmaintask_progress_details` (
  `staffmaintask_progress_details_key` int(11) NOT NULL,
  `assignmaintaskID` int(11) NOT NULL,
  `maintaskID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL,
  `maintaskprogress_description` varchar(500) DEFAULT NULL,
  `maintaskprogress_progress` int(11) NOT NULL,
  `maintaskprogress_submit_date` date NOT NULL,
  `maintaskprogress_approve_status` int(11) NOT NULL,
  `maintaskprogress_feedback` varchar(1000) DEFAULT NULL,
  `maintaskprogress_createdte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maintaskprogress_createby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffmaintask_progress_details`
--

INSERT INTO `staffmaintask_progress_details` (`staffmaintask_progress_details_key`, `assignmaintaskID`, `maintaskID`, `projectID`, `staffID`, `maintaskprogress_description`, `maintaskprogress_progress`, `maintaskprogress_submit_date`, `maintaskprogress_approve_status`, `maintaskprogress_feedback`, `maintaskprogress_createdte`, `maintaskprogress_createby`) VALUES
(1, 1, 1, 1, 2, 'Task Completed', 100, '2021-08-25', 1, 'Good', '2021-08-25 20:22:07', 2),
(2, 3, 2, 1, 1, 'Completed', 100, '2021-09-03', 1, 'Good!', '2021-09-03 12:39:20', 1),
(3, 4, 3, 3, 1, 'Questonnaire Typed ', 100, '2021-09-03', 1, 'Good!', '2021-09-03 12:51:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffmaintask_progress_image_details`
--

CREATE TABLE `staffmaintask_progress_image_details` (
  `staffmaintask_progress_image_details_key` int(1) NOT NULL,
  `maintaskprogress_ID` int(11) NOT NULL,
  `maintask_image_path` varchar(500) NOT NULL,
  `maintask_imgupd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maintask_imgupd_createby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffmaintask_progress_image_details`
--

INSERT INTO `staffmaintask_progress_image_details` (`staffmaintask_progress_image_details_key`, `maintaskprogress_ID`, `maintask_image_path`, `maintask_imgupd_date`, `maintask_imgupd_createby`) VALUES
(1, 1, 'b1.jpeg', '2021-08-25 20:22:07', 2),
(2, 2, 'b2.jpg', '2021-09-03 12:39:20', 1),
(3, 3, 'b3.jpg', '2021-09-03 12:51:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffsubtask_progress_details`
--

CREATE TABLE `staffsubtask_progress_details` (
  `subtaskprogress_ID` int(11) NOT NULL,
  `assigntaskID` int(11) NOT NULL,
  `subtaskID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `presentage` int(11) NOT NULL,
  `feedback` varchar(800) DEFAULT NULL,
  `submit_date` date NOT NULL,
  `approve_status` int(11) DEFAULT NULL,
  `staffsubtaskprogress_createdte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `staffsubtaskprogress_createby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffsubtask_progress_details`
--

INSERT INTO `staffsubtask_progress_details` (`subtaskprogress_ID`, `assigntaskID`, `subtaskID`, `taskID`, `projectID`, `staffID`, `description`, `presentage`, `feedback`, `submit_date`, `approve_status`, `staffsubtaskprogress_createdte`, `staffsubtaskprogress_createby`) VALUES
(1, 1, 1, 2, 1, 1, 'Done', 100, 'Well Done!', '2021-09-03', 1, '2021-09-03 12:18:29', 1),
(2, 1, 1, 2, 1, 1, 'Done', 100, '', '2021-09-03', 1, '2021-09-03 12:20:07', 1),
(3, 1, 1, 2, 1, 1, 'Done', 100, '', '2021-09-03', 1, '2021-09-03 12:21:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffsubtask_progress_image_details`
--

CREATE TABLE `staffsubtask_progress_image_details` (
  `staffsubtask_progress_image_details_key` int(11) NOT NULL,
  `subtaskprogress_ID` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `staffsubtask_progress_image_details_createby` int(11) NOT NULL,
  `staffsubtask_progress_image_details_createdte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffsubtask_progress_image_details`
--

INSERT INTO `staffsubtask_progress_image_details` (`staffsubtask_progress_image_details_key`, `subtaskprogress_ID`, `image_path`, `staffsubtask_progress_image_details_createby`, `staffsubtask_progress_image_details_createdte`) VALUES
(1, 1, 'a1.jpg', 1, '2021-09-03 12:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `subtask`
--

CREATE TABLE `subtask` (
  `subtaskID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `subtaskName` varchar(300) NOT NULL,
  `subtaskDesc` varchar(500) NOT NULL,
  `subtaskstartDate` date NOT NULL,
  `subtasktargetDate` date NOT NULL,
  `subtaskendDate` date DEFAULT NULL,
  `subtask_status` int(11) NOT NULL,
  `subtaskomplete_presentage` int(11) NOT NULL,
  `create_dte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subtask`
--

INSERT INTO `subtask` (`subtaskID`, `taskID`, `projectID`, `subtaskName`, `subtaskDesc`, `subtaskstartDate`, `subtasktargetDate`, `subtaskendDate`, `subtask_status`, `subtaskomplete_presentage`, `create_dte`, `create_by`) VALUES
(1, 2, 1, 'Create Presentation for Day 1', 'HTML Basic Tags', '2021-08-22', '2021-08-24', '2021-09-03', 1, 0, '2021-08-23 01:28:38', 2),
(2, 2, 1, 'Create Presentation for Day 1', 'HTML Basic Tags', '2021-08-22', '2021-08-31', '2021-09-03', 1, 0, '2021-08-23 01:30:44', 2);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `taskID` int(1) NOT NULL,
  `projectID` int(11) NOT NULL,
  `taskName` varchar(300) NOT NULL,
  `taskDescription` varchar(500) NOT NULL,
  `startDate` date NOT NULL,
  `targetDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `task_status` int(11) NOT NULL,
  `complete_percent` int(11) NOT NULL,
  `create_dte` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskID`, `projectID`, `taskName`, `taskDescription`, `startDate`, `targetDate`, `endDate`, `task_status`, `complete_percent`, `create_dte`, `create_by`) VALUES
(1, 1, 'Create  presentation - Introduction to web design', 'Under the topic of introduction to web technologies in the web designing course syllabus, students get to learn about technical aspects of creating a website as well as types of websites. Here are the key topics covered under this section:\r\n\r\nHow does a website work?\r\nWeb standards and W3C elements\r\nDomains and Hosting\r\nClients and Server Scripting Languages\r\nResponsive Web Designing', '2021-08-22', '2021-09-05', '2021-09-03', 1, 0, '2021-08-23 01:25:51', 2),
(2, 1, 'Create  presentation - Basics of HTML', 'HTML is an integral part of a web design course syllabus and is described as hypermark text language. It is a key element of creating a website, in this subject, you will get to understand how HTML elaborates the general structure of a web page design as well as tags and the concept of HTML files. After which designing a web page will be taught along with hyperlinking and the tools that you can use in a web page design process. The recent version of HTML is HTML 5 on which you will get familiari', '2021-08-22', '2021-09-19', '2021-09-03', 1, 0, '2021-08-23 01:27:36', 2),
(3, 3, 'Create Questionnaire', 'Create Online Questionnaire \r\nMCQ 30\r\nSEQ 3', '2021-09-03', '2021-09-04', '2021-09-03', 1, 0, '2021-09-03 12:49:56', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_subtask`
--
ALTER TABLE `assign_subtask`
  ADD PRIMARY KEY (`assigntaskID`);

--
-- Indexes for table `assign_task`
--
ALTER TABLE `assign_task`
  ADD PRIMARY KEY (`assigntask_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceID`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatID`);

--
-- Indexes for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD PRIMARY KEY (`codinator_key`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`leaveID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`projectID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`empno`);

--
-- Indexes for table `staffmaintask_progress_details`
--
ALTER TABLE `staffmaintask_progress_details`
  ADD PRIMARY KEY (`staffmaintask_progress_details_key`);

--
-- Indexes for table `staffmaintask_progress_image_details`
--
ALTER TABLE `staffmaintask_progress_image_details`
  ADD PRIMARY KEY (`staffmaintask_progress_image_details_key`);

--
-- Indexes for table `staffsubtask_progress_details`
--
ALTER TABLE `staffsubtask_progress_details`
  ADD PRIMARY KEY (`subtaskprogress_ID`);

--
-- Indexes for table `staffsubtask_progress_image_details`
--
ALTER TABLE `staffsubtask_progress_image_details`
  ADD PRIMARY KEY (`staffsubtask_progress_image_details_key`);

--
-- Indexes for table `subtask`
--
ALTER TABLE `subtask`
  ADD PRIMARY KEY (`subtaskID`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`taskID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_subtask`
--
ALTER TABLE `assign_subtask`
  MODIFY `assigntaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assign_task`
--
ALTER TABLE `assign_task`
  MODIFY `assigntask_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chatID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coordinator`
--
ALTER TABLE `coordinator`
  MODIFY `codinator_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `leaveID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `empno` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staffmaintask_progress_details`
--
ALTER TABLE `staffmaintask_progress_details`
  MODIFY `staffmaintask_progress_details_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staffmaintask_progress_image_details`
--
ALTER TABLE `staffmaintask_progress_image_details`
  MODIFY `staffmaintask_progress_image_details_key` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staffsubtask_progress_details`
--
ALTER TABLE `staffsubtask_progress_details`
  MODIFY `subtaskprogress_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staffsubtask_progress_image_details`
--
ALTER TABLE `staffsubtask_progress_image_details`
  MODIFY `staffsubtask_progress_image_details_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subtask`
--
ALTER TABLE `subtask`
  MODIFY `subtaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `taskID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
