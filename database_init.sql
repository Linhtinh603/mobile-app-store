-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2021 at 05:45 AM
-- Server version: 8.0.13-4
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kGDOb7zsNb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'password hashed',
  `account_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: admin, 1: user, 2: developer',
  `full_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Link avatar image',
  `cmnd_front_image` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Hình cmnd mặt trước (cho dev)',
  `cmnd_back_image` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Hình cmnd mặt sau (cho up dev)',
  `developer_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `developer_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `developer_phone_number` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `developer_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` int(11) NOT NULL DEFAULT '0' COMMENT 'Số tiền dư trong tài khoản'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `email`, `password`, `account_type`, `full_name`, `avatar`, `cmnd_front_image`, `cmnd_back_image`, `developer_name`, `developer_email`, `developer_phone_number`, `developer_address`, `balance`) VALUES
(1, 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 0, 'admin', NULL, NULL, NULL, 'kien', NULL, NULL, NULL, 0),
(2, 'user1@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'Võ Văn Hữu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000),
(3, 'linh@email.com', '202cb962ac59075b964b07152d234b70', 1, 'Linh Vip Pro', 'https://cdn.icon-icons.com/icons2/2643/PNG/512/male_boy_person_people_avatar_icon_159358.png', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 'devaccount@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'Nguyễn Tiến Đạt', 'upload_avatar/5.jpg', 'upload_cmnd/4/img_cmnd_1', 'upload_cmnd/4/img_cmnd_2', 'App Center Park', 'Linhtinh6031@gmail.com', '0987712721', '46 Lê Đại Hành, Phường 9, Quận 5, Tp.HCM', 71000),
(5, 'huuvv@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'vo van huu', 'upload_avatar/5.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 50000),
(6, 'kien@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'phamkien', 'upload_avatar/6.jpg', 'upload_cmnd/6/img_cmnd_1.', 'upload_cmnd/6/img_cmnd_2.', 'kien Develop ', 'kien@gmaail.com', '0908736464', 'kienpham ', 1500000),
(7, 'linh@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'Thomas Taylor', 'upload_avatar/7.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(8, 'abcv@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'kk', 'upload_avatar/8.jpg', 'upload_cmnd/8/img_cmnd_1.jpg', 'upload_cmnd/8/img_cmnd_2.jpg', '111111', 'wwwwww', '222222', 'wwwww', 0);

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Link icon image',
  `images` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'List link images',
  `short_description` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail_description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL COMMENT 'Giá app',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: bản nháp, 1: Đang chờ duyệt, 2: Đã được duyệt, 3: Đã gỡ, 4: Bị từ chối',
  `download_location` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Link download',
  `size` int(11) DEFAULT NULL COMMENT 'Kích thước tập tin',
  `average_rate` tinyint(4) DEFAULT NULL COMMENT 'Đánh giá trung bình (thang điểm 5 sao)',
  `created_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'id account',
  `updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `name`, `icon`, `images`, `short_description`, `detail_description`, `price`, `status`, `download_location`, `size`, `average_rate`, `created_time`, `created_by`, `category_id`) VALUES
(1, 'Facebook t', 'upload_app_icon/16/0.jpg', '[]', 'Ứng dụng chụp hình (short-description).Ứng dụng chụp hình (short-description).', 'Play with friends! Play with Legends. Play the hit Miniclip 8 Ball Pool game on your mobile and become the best! COMPETE 1-ON-1 OR IN 8 PLAYER TOURNAMENTS Refine your skills in the practice arena, take on the world in 1-vs-1 matches', 550000, 2, '5/0.zip', 2, 4, '2021-05-15 17:36:13', 4, 3),
(3, 'Youtube', 'upload_app_icon/16/0.jpg', NULL, ' Ứng dụng thân thiện nhất', 'â', 0, 2, NULL, NULL, NULL, '2021-05-14 19:42:33', 4, 2),
(4, 'Pokemon Go', 'upload_app_icon/16/0.jpg', '[0,1]', 'Tựa game xoay quanh bộ phim hoạt hình pokemon', 'Trò chơi cho phép người chơi bắt, đấu, huấn luyện và trao đổi Pokémon[7] thông qua thế giới thực[4] bằng cách sử dụng GPS và camera của thiết bị. Đây là một trò chơi miễn phí tải về, nhưng có hỗ trợ mua hàng trong ứng dụng để người chơi có thể mua các vật dụng trong game.', 0, 2, NULL, NULL, NULL, '2021-05-14 19:42:55', 4, 1),
(5, 'Yahoo', 'upload_app_icon/16/0.jpg', NULL, ' Ứng dụng thân thiện nhất', '2222', 0, 2, NULL, NULL, NULL, '2021-05-14 20:41:36', 4, 2),
(6, 'Tinder', 'upload_app_icon/16/0.jpg', NULL, ' Ứng dụng thân thiện nhất', '2222', 0, 2, NULL, NULL, NULL, '2021-05-14 20:42:11', 4, 2),
(7, 'Liên quân', 'upload_app_icon/16/0.jpg', NULL, 'Trò chơi thể loại moba', 'Người chơi điều khiển các nhân vật,có những khả năng riêng.. Người chơi đặt mục tiêu phá hủy các trụ (tháp pháo) của đối phương trên bản đồ, đội giành chiến thắng chính là đội phá hủy được nhà chính đối phương, trong những trận đấu này trung bình kéo dài khoảng 15-20 phút.', 0, 2, NULL, NULL, NULL, '2021-05-14 20:47:19', 4, 1),
(11, 'Pacman', 'upload_app_icon/16/0.jpg', '[0,1]', 'trò chơi thập niên 80', 'Người chơi điều khiển Pac-Man trong một mê cung và ăn các chấm pac (pac-dots). Nếu người chơi ăn hết các chấm pac thì Pac-Man được đưa qua màn chơi mới. Có 4 đối thủ là Blinky, Pinky, Inky và Clyde đi rong tự do trong mê cung và cố gắng bắt Pac-Man. Nếu để bị bắt, Pac-Man sẽ bị mất mạng.', 99292929, 2, NULL, NULL, NULL, '2021-05-14 20:50:06', 4, 1),
(16, 'Chrome', 'upload_app_icon/16/0.jpg', '[0,1]', 'abc', 'kkkk', 1111, 2, NULL, 508069, NULL, '2021-05-15 04:24:07', 4, 2),
(17, 'Snake', 'upload_app_icon/16/0.jpg', '[0,1]', 'rắn săn mồi', 'Rắn săn mồi là tựa game đơn giản nhưng vô cùng cuốn hút, người chơi di chuyển con rắn sao cho ăn hết những vật trên đường di chuyển và tránh những chướng ngại vật. Mỗi lần ăn, độ dài của rắn sẽ dài ra và bạn sẽ phải giữ không cho rắn cắn vào đuôi mình', 10000, 2, NULL, NULL, NULL, '2021-05-14 20:50:06', 4, 1),
(18, 'VPN Free', 'upload_app_icon/16/0.jpg', NULL, 'VPN Free cho mọi người', 'Kiwi VPN 2020 là phần mềm đổi IP, có thể vượt tường lửa của công ty, trường học. Truy cập website bị chặn, ứng dụng mượt mà không giới hạn thời gian kết nối, không giới hạn lưu lượng truy cập, VPN không giới hạn băng thông.', 0, 3, NULL, NULL, NULL, '2021-05-15 06:31:28', 4, 1),
(19, 'VPN Free', 'upload_app_icon/16/0.jpg', NULL, '', '', 10000, 3, NULL, NULL, NULL, '2021-05-15 06:34:32', 4, 1),
(28, 'Gmail', 'upload_app_icon/16/0.jpg', '[0,1]', 'â', 'aaa', 111111, 3, '28/0.zip', 508069, NULL, '2021-05-15 09:53:30', 4, 2),
(30, 'Avenger', NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, '2021-05-15 00:00:00', 4, 3),
(69, 'Dr Strange', '', NULL, '123', '123', 0, 3, '', 0, 1, '2021-05-15 00:00:00', 4, 3),
(70, 'APP đánh bài', 'upload_app_icon/70/0.jpg', '[0,1]', 'apppp', 'app tiến lên', 200000, 3, NULL, 508069, NULL, '2021-05-15 15:03:17', 4, 1),
(71, 'App Tiến lên', 'upload_app_icon/71/0.jpg', '[0,1]', 'tiến lên cùng tiến lên', 'tiến lên cùng tiến lên .', 0, 1, '5/0.zip', 508069, NULL, '2021-05-15 15:05:17', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_purchased_history`
--

CREATE TABLE `app_purchased_history` (
  `account_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `purchased_price` int(11) NOT NULL,
  `created_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_purchased_history`
--

INSERT INTO `app_purchased_history` (`account_id`, `app_id`, `purchased_price`) VALUES
(1, 71, 0),
(3, 17, 10000),
(3, 18, 0),
(4, 1, 550000),
(4, 5, 111111),
(4, 18, 0),
(5, 1, 0),
(5, 5, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `seri_number` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `denomination` mediumint(9) NOT NULL COMMENT 'Mệnh giá: 50k -> 500k',
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `seri_number`, `denomination`, `used`) VALUES
(1, '1234567890123456', 20000, 1),
(2, '1234567890123457', 10000, 1),
(3, '609ff8fbd6eb3p97', 50000, 1),
(4, '609ff94f633cf238', 50000, 0),
(5, '609ff94f63499q69', 50000, 0),
(6, '60a093103c7ab03g', 50000, 0),
(7, '60a093103c7ceun4', 50000, 0),
(8, '60a0932aedc1233q', 50000, 0),
(9, '60a0932aedc22ou7', 50000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Trò chơi'),
(2, 'Ứng dụng'),
(3, 'Âm nhạc'),
(4, 'Hình ảnh'),
(5, 'Công cụ'),
(6, 'Giải trí'),
(7, 'Học tập');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_history`
--

CREATE TABLE `deposit_history` (
  `card_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày nạp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `deposit_history`
--

INSERT INTO `deposit_history` (`card_id`, `account_id`) VALUES
(1, 4),
(2, 4),
(3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `app_purchased_history`
--
ALTER TABLE `app_purchased_history`
  ADD PRIMARY KEY (`account_id`,`app_id`),
  ADD KEY `app_id` (`app_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_history`
--
ALTER TABLE `deposit_history`
  ADD PRIMARY KEY (`card_id`,`account_id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apps`
--
ALTER TABLE `apps`
  ADD CONSTRAINT `apps_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `app_purchased_history`
--
ALTER TABLE `app_purchased_history`
  ADD CONSTRAINT `app_purchased_history_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `app_purchased_history_ibfk_2` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`);

--
-- Constraints for table `deposit_history`
--
ALTER TABLE `deposit_history`
  ADD CONSTRAINT `deposit_history_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `deposit_history_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
