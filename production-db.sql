/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50742 (5.7.42)
 Source Host           : 127.0.0.1:3306
 Source Schema         : databasedefault

 Target Server Type    : MySQL
 Target Server Version : 50742 (5.7.42)
 File Encoding         : 65001

 Date: 09/07/2023 03:23:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for requests
-- ----------------------------
DROP TABLE IF EXISTS `requests`;
CREATE TABLE `requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `document` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `benefit_number` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'pending',
  `attachment` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of requests
-- ----------------------------
BEGIN;
INSERT INTO `requests` (`id`, `document`, `benefit_number`, `status`, `attachment`, `description`, `client_id`, `created_at`, `updated_at`) VALUES (1, '46692183871', '414498276', 'pending', 'files/2023/07/46692183871.pdf', 'aaaaaa', 2, '2023-07-09 04:26:10', '2023-07-09 04:57:10');
INSERT INTO `requests` (`id`, `document`, `benefit_number`, `status`, `attachment`, `description`, `client_id`, `created_at`, `updated_at`) VALUES (2, '46692183871', '41361529', 'pending', NULL, NULL, 2, '2023-07-09 05:56:29', '2023-07-09 05:56:29');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL DEFAULT '1',
  `forget` varchar(255) DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `document` varchar(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'registered' COMMENT 'registered, confirmed',
  `phone` varchar(255) DEFAULT NULL,
  `wallet` float(10,2) DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  FULLTEXT KEY `full_text` (`first_name`,`last_name`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `level`, `forget`, `genre`, `datebirth`, `document`, `photo`, `status`, `phone`, `wallet`, `created_at`, `updated_at`) VALUES (1, 'Jhonatan', 'Martimiano', 'jhonatan_martimiano@hotmail.com', '$2y$10$B5zHSK0SlqWeOnX7Tr69BuKEKyurK5C4uO0J0tHq1uj8YJTNdw6g.', 5, NULL, 'male', '1995-02-21', '46692183871', 'images/2023/07/jhonatan-martimiano.png', 'registered', '11910584136', 0.00, '2021-08-03 06:01:09', '2023-07-09 05:21:54');
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `level`, `forget`, `genre`, `datebirth`, `document`, `photo`, `status`, `phone`, `wallet`, `created_at`, `updated_at`) VALUES (2, 'Clayton', 'Martimiano', 'clayton@hotmail.com', '$2y$10$Cnbr8VbU2RCvQzMpNWoaBeuPggbWn/fBVpprMfCnxR7CjmH640Z5W', 1, NULL, 'male', '1995-04-06', '11111111111', NULL, 'registered', '11910584136', 500.00, '2023-07-09 04:00:05', '2023-07-09 06:10:06');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
