/*
 Navicat Premium Data Transfer

 Source Server         : XAMPP
 Source Server Type    : MySQL
 Source Server Version : 100417
 Source Host           : localhost:3306
 Source Schema         : card24h

 Target Server Type    : MySQL
 Target Server Version : 100417
 File Encoding         : 65001

 Date: 19/12/2020 21:09:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `VND` int NOT NULL DEFAULT 0,
  `banned` int NOT NULL DEFAULT 0,
  `createdate` datetime NULL DEFAULT NULL,
  `updatedate` datetime NOT NULL,
  `ip` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `level` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fullname` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `APIKey` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1243 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES (1242, 'AVTYZXOLMQWK', 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, 0, '2020-12-19 21:08:00', '0000-00-00 00:00:00', '::1', 'ntt2001811@gmail.com', '', '', '', NULL);

-- ----------------------------
-- Table structure for biendongsodu
-- ----------------------------
DROP TABLE IF EXISTS `biendongsodu`;
CREATE TABLE `biendongsodu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mess` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `createdate` datetime NULL DEFAULT NULL,
  `VND` int NOT NULL DEFAULT 0,
  `luongtien` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sotien` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of biendongsodu
-- ----------------------------

-- ----------------------------
-- Table structure for doithe
-- ----------------------------
DROP TABLE IF EXISTS `doithe`;
CREATE TABLE `doithe`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `seri` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pin` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `menhgia` int NOT NULL,
  `thucnhan` int NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'xuly',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doithe
-- ----------------------------

-- ----------------------------
-- Table structure for doithe_auto
-- ----------------------------
DROP TABLE IF EXISTS `doithe_auto`;
CREATE TABLE `doithe_auto`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `seri` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pin` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `menhgia` int NOT NULL,
  `thucnhan` int NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'xuly',
  `mess` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `callback` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1800 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doithe_auto
-- ----------------------------

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `createdate` datetime NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3815 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES (3814, '0947838128', '2020-12-19 21:08:00', 'Đăng ký tài khoản IP (::1).');

-- ----------------------------
-- Table structure for muathe
-- ----------------------------
DROP TABLE IF EXISTS `muathe`;
CREATE TABLE `muathe`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(64) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `loaithe` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `menhgia` int NULL DEFAULT NULL,
  `money` int NULL DEFAULT 0,
  `seri` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `pin` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT 'xuly',
  `createdate` datetime NULL DEFAULT NULL,
  `updatedate` datetime NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_vietnamese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of muathe
-- ----------------------------

-- ----------------------------
-- Table structure for napdt
-- ----------------------------
DROP TABLE IF EXISTS `napdt`;
CREATE TABLE `napdt`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `loaithe` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `sdt` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `menhgia` int NULL DEFAULT 0,
  `money` int NULL DEFAULT 0,
  `passmy` varchar(64) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT 'xuly',
  `note` text CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL,
  `createdate` datetime NULL DEFAULT NULL,
  `updatedate` datetime NULL DEFAULT NULL,
  `code` varchar(64) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_vietnamese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of napdt
-- ----------------------------

-- ----------------------------
-- Table structure for ruttien
-- ----------------------------
DROP TABLE IF EXISTS `ruttien`;
CREATE TABLE `ruttien`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ngan_hang` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chu_tai_khoan` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `stk` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chi_nhanh` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `money` int NOT NULL,
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'xuly',
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 368 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ruttien
-- ----------------------------

-- ----------------------------
-- Table structure for setting_card
-- ----------------------------
DROP TABLE IF EXISTS `setting_card`;
CREATE TABLE `setting_card`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ck` int NOT NULL,
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ON',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_card
-- ----------------------------
INSERT INTO `setting_card` VALUES (3, 'OLRSFDPTIKVY', 'Viettel', 25, 'OFF');
INSERT INTO `setting_card` VALUES (4, 'AVHTEGXCLDJB', 'Vinaphone', 25, 'OFF');
INSERT INTO `setting_card` VALUES (6, 'HFWXEGMASPTQ', 'Mobifone', 25, 'OFF');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int NOT NULL,
  `tenweb` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `baotri` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'OFF',
  `idfb` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tukhoa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cookie` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_luuy_doithe` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_luuy_ruttien` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_hotline` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_gmail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_pass_email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_livechat` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thongbao` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ck_con` int NOT NULL DEFAULT 0,
  `cardvip_vt` int NOT NULL DEFAULT 0,
  `cardvip_mobi` int NOT NULL DEFAULT 0,
  `cardvip_vina` int NOT NULL DEFAULT 0,
  `cardvip_viet` int NOT NULL DEFAULT 0,
  `cardvip_zing` int NOT NULL DEFAULT 0,
  `cardvip_gate` int NOT NULL DEFAULT 0,
  `cardvip_garena` int NOT NULL DEFAULT 0,
  `apikey` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_logo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `site_favicon` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `site_img` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `site_color` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `site_min_bank` int NOT NULL DEFAULT 100000,
  `site_min_momo` int NOT NULL DEFAULT 50000,
  `ck_napdt_vt` int NOT NULL DEFAULT 0,
  `ck_napdt_mobi` int NOT NULL DEFAULT 0,
  `ck_napdt_vina` int NOT NULL DEFAULT 0,
  `status_napdt` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'ON',
  `note_napdt` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `status_auto` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'ON',
  `status_muathe` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'ON',
  `status_cham` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'ON',
  `site_diachi` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `site_fanpage` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (0, 'CARD24H.COM', 'OFF', '100038641389494', 'CARD24H.COM | ĐỔI THẺ CÀO SANG TIỀN MẶT NHANH CHÓNG - ĐƠN GIẢN - AN TOÀN, ĐỔI THẺ CÀO SIÊU TỐC, PHÍ THẤP NHẤT THỊ TRƯỜNG TẠI CARD24H.COM', 'card24h,card24,đổi thẻ cào sàng tiền mặt, đổi thẻ, đổi thẻ cào, gạch thẻ, rữa thẻ, quy đổi thẻ sang tiền mặt, mua thẻ, ex card for cash, đổi card, doi card ra tien mat uy tin,doi the  uy tin nhat thi truong, kiem tien online, doi the cào,doithe24, doi the 24, doi the thanh tien, gach the cao, the cao gia re, doi the cao chiet khau thap, the sieu re, the cao sieu re, tsr,tcsr,card game', 'sb=rSw9X40hatqbbpFabjyHVtzd; locale=en_GB; datr=ziw9X5avmlS8OgeuBsUt2Twj; c_user=100042248661102; xs=11%3AezsN8G3nzMg1mQ%3A2%3A1597869163%3A14203%3A-1%3A%3AAcWk37QS_44coq-6-xZLM9EulBqu1bORtfeHWmu7Sw; spin=r.1002557851_b.trunk_t.1598209630_s.1_v.2_; fr=19sPKsxhGmZNVoRss.AWUiHoo2wPyVlsmEeM6Hd51xT6A.BfPSyt.zB.F9C.0.0.BfQr5i.AWVmnhC8; wd=932x969; presence=EDvF3EtimeF1598209693EuserFA21B42248661102A2EstateFDt3F_5b_5dEutc3F1598209661321G598209693210CEchF_7bCC', '<ul><li>Hệ thống xử lý 5s 1 thẻ.</li><li>Vui lòng gửi đúng mệnh giá, sai mệnh giá thực nhận mệnh giá bé nhất.</li><li>Ví dụ mệnh giá thực là 100k, quý khách nạp 100k thực nhận 100k.</li><li>Ví dụ mệnh giá thực là 100k quý khách nạp 50k thực nhận 50k.</li><li>Mệnh giá 10k, 20k, 30k tính thêm 3% phí.</li></ul>', '<p><span style=\"font-size: 1rem;\">- Rút tiền không mất phí.</span></p><p>- Vui lòng nhập đầy đủ<b> Thông Tin Rút Tiền.</b></p><p>- Trong quá trình <b>Rút Tiền</b>, nếu bạn ghi <b>sai thông tin</b>, vui lòng liên hệ chúng tôi qua <b>Live Chat</b> ngay.</p><p>- Ưu tiên rút tiền qua <b>MOMO</b>, thời gian duyệt rút tiền vài phút.</p><p>- Để tăng tốc độ duyệt rút tiền, sau khi rút tiền, bạn liên hệ cho Fanpage để được xử lý ưu tiên.</p>', '0947838128', 'ntt2001811@gmail.com', '', '', '<p>Vui lòng rút tiền về ngân hàng !</p>', 3, 27, 26, 25, 24, 23, 27, 28, 'b6d1d138-a398-4cf1-9660-bdd96c2b8c72', 'https://card24h.com/upload/logo.png', 'https://card24h.com/upload/favicon.png', 'https://card24h.com/upload/thumbnail.png', '#2681ba', 200000, 100000, 5, 10, 10, 'OFF', '<p>Nạp điện thoại siêu tiết kiệm tại CARD24h.COM</p>', 'ON', 'ON', 'OFF', '5/12 KP4 - Hòa Thành - TP Tây Ninh', '');

SET FOREIGN_KEY_CHECKS = 1;
