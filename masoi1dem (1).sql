-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 03, 2021 lúc 09:03 AM
-- Phiên bản máy phục vụ: 10.1.38-MariaDB
-- Phiên bản PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `masoi1dem`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `room` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '20',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lastping` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `point` int(11) NOT NULL DEFAULT '100',
  `isBot` smallint(1) NOT NULL DEFAULT '0',
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `realrole` int(11) NOT NULL DEFAULT '20',
  `donejob` tinyint(4) NOT NULL DEFAULT '0',
  `showhis` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `game`
--

INSERT INTO `game` (`id`, `username`, `room`, `isAdmin`, `role`, `status`, `lastping`, `point`, `isBot`, `target`, `realrole`, `donejob`, `showhis`) VALUES
(1, 'aaaaaaaaa', 'm3CccC6kc0Ewn7V73qWLCucX88EEYAHD', 1, 21, 1, '2021-03-30 22:21:40', 100, 0, '', 0, 1, 0),
(2, 'Card1', 'm3CccC6kc0Ewn7V73qWLCucX88EEYAHD', 0, 20, 1, '2021-03-30 22:21:40', 100, 1, '', 0, 1, 0),
(3, 'Card2', 'm3CccC6kc0Ewn7V73qWLCucX88EEYAHD', 0, 20, 1, '2021-03-30 22:21:40', 100, 1, '', 0, 1, 0),
(4, 'Card3', 'm3CccC6kc0Ewn7V73qWLCucX88EEYAHD', 0, 20, 1, '2021-03-30 22:21:40', 100, 1, '', 0, 1, 0),
(13, 'Hau', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 1, 21, 1, '2021-04-03 14:02:38', 100, 0, '', 20, 1, 0),
(14, 'Card1', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 23, 1, '2021-04-03 13:41:28', 0, 1, '', 23, 0, 0),
(15, 'Card2', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 5, 1, '2021-04-03 13:41:28', 0, 1, '', 5, 0, 0),
(16, 'Card3', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 6, 1, '2021-04-03 13:41:28', 0, 1, '', 6, 0, 0),
(17, 'Bong', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 3, 1, '2021-04-03 14:02:41', 100, 0, '', 3, 0, 0),
(18, 'Hoi', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 1, 1, '2021-04-03 14:02:41', 100, 0, '', 1, 0, 0),
(19, 'Xuhuhu', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 22, 1, '2021-04-03 14:02:42', 100, 0, '', 22, 0, 0),
(20, 'Bong2', 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 0, 1, 1, '2021-04-03 14:02:40', 100, 0, '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `room` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `dttm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `log`
--

INSERT INTO `log` (`id`, `room`, `log`, `dttm`) VALUES
(138, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Hoi được chỉ định là sói', '2021-04-03 14:02:33'),
(139, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Bong2 được chỉ định là sói', '2021-04-03 14:02:33'),
(140, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Card1 được chỉ định chức năng Kẻ gây rối', '2021-04-03 14:02:33'),
(141, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Xuhuhu được chỉ định chức năng Đạo tặc', '2021-04-03 14:02:33'),
(142, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Bong được chỉ định chức năng Hunter (Thợ săn)', '2021-04-03 14:02:33'),
(143, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Card2 được chỉ định chức năng Seeker (Tiên tri)', '2021-04-03 14:02:33'),
(144, 'gfx7s0p7soecuiiK0Bo5Baq5GPljq6IH', 'Card3 được chỉ định là dân', '2021-04-03 14:02:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `team` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`, `note`, `img`, `team`) VALUES
(1, 'Werewolf  (Ma sói)', 'Vào ban đêm, Ma sói sẽ tỉnh dậy cùng nhau và thống nhất giết 1 nạn nhận nào đó. Sói có thể không giết người nào và không được giết sói khác.', 'werewolf.png', 'Ma sói'),
(3, 'Hunter (Thợ săn)', 'Nếu thợ săn chết, hắn sẽ phép nhắm vào một người và người này sẽ bị chết.', 'hunter.png', 'Dân làng'),
(5, 'Seeker (Tiên tri)', 'Mỗi đêm, Tiên tri chỉ tay vào một người. Quản trò sẽ cho Tiên tri biết người đó có phải là Ma sói hay không bằng cách gật hoặc lắc đầu.', 'seer.png', 'Dân làng'),
(6, 'Village (Dân làng)', 'Không có tính năng đặc biệt nào cả, ngủ suốt đêm và tham gia biểu quyết tìm Sói vào ban ngày.', 'villager.png', 'Dân làng'),
(17, 'Doppelganger (Nhân bản)', 'Vào đêm đầu tiên, Nhân bản tỉnh dậy và lựa chọn một người chơi. Nếu người chơi kia chết trong đêm, Nhân bản sẽ bí mật lấy chức năng của người đó. Trước khi có chức năng mới, Nhân bản theo Phe dân. Sau khi có chức năng mới, Nhân bản theo phe của chức năng này.', 'doppelganger.png', 'Chuyển phe'),
(18, 'Tanner (Chán đời)', 'Chán đời chỉ thắng khi anh ta bị giết. Các điều kiện thắng khác cũng được áp dụng.', 'tanner.png', 'Phe thứ 3'),
(20, 'Chưa Nhận', 'Đang chờ', 'blank.jpg', 'Chưa nhận'),
(21, 'Moderator (Quản trò)', 'Bạn là Quản trò', 'Moderator.jpg', 'Không'),
(22, 'Đạo tặc', 'Đạo tặc là nhân vật có khả năng tráo đổi bài của mình với người chơi khác và được xem nhân vật mà mình tráo đổi.', 'robber.png', 'Dân làng'),
(23, 'Kẻ gây rối', 'Kẻ Gây Rối được tráo đổi 2 lá bài của 2 người chơi khác và không được xem.', 'troublemaker.png', 'Dân làng');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
