-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 12:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `optical_management`
--
-- --------------------------------------------------------
--
-- Table structure for table `branches`
--
CREATE TABLE
  `branches` (
    `id` int (11) NOT NULL,
    `branch_id` varchar(20) NOT NULL,
    `branch_name` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--
INSERT INTO
  `branches` (`id`, `branch_id`, `branch_name`, `created_at`)
VALUES
  (1, 'F01', 'Fashion Optics', '2025-11-16 10:44:14'),
  (2, 'F02', 'Fashion Group', '2025-11-16 10:44:14'),
  (3, 'FO3', 'Gulshan 01', '2025-11-16 11:09:00');

-- --------------------------------------------------------
--
-- Table structure for table `categories`
--
CREATE TABLE
  `categories` (
    `id` int (11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--
INSERT INTO
  `categories` (`id`, `name`, `description`, `created_at`)
VALUES
  (
    1,
    'Progressive',
    'Progressive lenses',
    '2025-11-16 10:44:14'
  ),
  (
    2,
    'Single Vision',
    'Single vision lenses',
    '2025-11-16 10:44:14'
  ),
  (
    3,
    'Bifocal',
    'Bifocal lenses',
    '2025-11-16 10:44:14'
  );

-- --------------------------------------------------------
--
-- Table structure for table `lenses`
--
CREATE TABLE
  `lenses` (
    `id` int (11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `category_id` int (11) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `lenses`
--
INSERT INTO
  `lenses` (
    `id`,
    `name`,
    `category_id`,
    `description`,
    `created_at`
  )
VALUES
  (
    1,
    'Zion',
    1,
    'Zion progressive lenses',
    '2025-11-16 10:44:14'
  ),
  (
    2,
    'Mr. Blue',
    2,
    'Mr. Blue single vision lenses',
    '2025-11-16 10:44:14'
  ),
  (
    3,
    'Ego',
    3,
    'Ego bifocal lenses',
    '2025-11-16 10:44:14'
  ),
  (
    4,
    'Ego free form',
    1,
    'Ego free form progressive lenses',
    '2025-11-16 10:44:14'
  ),
  (
    5,
    'Zion ',
    1,
    'Zion Progressive Blue Cut.',
    '2025-11-16 11:09:56'
  );

-- --------------------------------------------------------
--
-- Table structure for table `prescriptions`
--
CREATE TABLE
  `prescriptions` (
    `id` int (11) NOT NULL,
    `patient_name` varchar(255) NOT NULL,
    `age` int (11) DEFAULT NULL,
    `date` date NOT NULL,
    `od_sph` varchar(20) DEFAULT NULL,
    `od_cyl` varchar(20) DEFAULT NULL,
    `od_axis` varchar(20) DEFAULT NULL,
    `od_va` varchar(20) DEFAULT NULL,
    `od_prism` varchar(20) DEFAULT NULL,
    `od_base` varchar(20) DEFAULT NULL,
    `os_sph` varchar(20) DEFAULT NULL,
    `os_cyl` varchar(20) DEFAULT NULL,
    `os_axis` varchar(20) DEFAULT NULL,
    `os_va` varchar(20) DEFAULT NULL,
    `os_prism` varchar(20) DEFAULT NULL,
    `os_base` varchar(20) DEFAULT NULL,
    `near_add_od` varchar(20) DEFAULT NULL,
    `near_add_os` varchar(20) DEFAULT NULL,
    `pd_od` varchar(20) DEFAULT NULL,
    `pd_os` varchar(20) DEFAULT NULL,
    `remarks` text DEFAULT NULL,
    `lens_type` varchar(255) DEFAULT NULL,
    `next_examination` varchar(50) DEFAULT NULL,
    `created_by` int (11) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--
INSERT INTO
  `prescriptions` (
    `id`,
    `patient_name`,
    `age`,
    `date`,
    `od_sph`,
    `od_cyl`,
    `od_axis`,
    `od_va`,
    `od_prism`,
    `od_base`,
    `os_sph`,
    `os_cyl`,
    `os_axis`,
    `os_va`,
    `os_prism`,
    `os_base`,
    `near_add_od`,
    `near_add_os`,
    `pd_od`,
    `pd_os`,
    `remarks`,
    `lens_type`,
    `next_examination`,
    `created_by`,
    `created_at`
  )
VALUES
  (
    1,
    'Md. Anis Khan',
    22,
    '2025-11-16',
    '+0.00',
    '+0.25',
    '90',
    '',
    '',
    '4.00',
    '+0.00',
    '-0.25',
    '90',
    '',
    '',
    '4.00',
    '+1.25',
    '+1.25',
    '32',
    '32',
    'NA',
    'Single Vision',
    '2',
    4,
    '2025-11-16 11:31:02'
  );

-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE
  `users` (
    `id` int (11) NOT NULL,
    `employee_id` varchar(50) NOT NULL,
    `username` varchar(100) NOT NULL,
    `full_name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` enum ('admin', 'user') DEFAULT 'user',
    `status` enum ('active', 'inactive') DEFAULT 'active',
    `branch_id` varchar(20) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `users`
--
INSERT INTO
  `users` (
    `id`,
    `employee_id`,
    `username`,
    `full_name`,
    `email`,
    `password`,
    `role`,
    `status`,
    `branch_id`,
    `created_at`
  )
VALUES
  (
    1,
    'EMP001',
    'admin',
    'System Administrator',
    'admin@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    'active',
    '1',
    '2025-11-16 10:44:14'
  ),
  (
    4,
    'EMP1758',
    'anas',
    'Md. Anas Khan',
    'anas.cse.201@gmail.com',
    '$2y$10$sjv7QOpCU08fuToCBOhe4.NROjzXIes6totWwZGUkp5CE4m/MTng6',
    'user',
    'active',
    '1',
    '2025-11-16 11:08:18'
  );

--
-- Indexes for dumped tables
--
--
-- Indexes for table `branches`
--
ALTER TABLE `branches` ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `branch_id` (`branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lenses`
--
ALTER TABLE `lenses` ADD PRIMARY KEY (`id`),
ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions` ADD PRIMARY KEY (`id`),
ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `employee_id` (`employee_id`),
ADD UNIQUE KEY `email` (`email`),
ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `lenses`
--
ALTER TABLE `lenses` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 5;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `lenses`
--
ALTER TABLE `lenses` ADD CONSTRAINT `lenses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions` ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;