# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 118.89.106.129 (MySQL 5.5.53-0ubuntu0.14.04.1)
# Database: dream_wechat
# Generation Time: 2019-05-23 07:11:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table market_qrcode
# ------------------------------------------------------------

DROP TABLE IF EXISTS `market_qrcode`;

CREATE TABLE `market_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名字',
  `qrcode` varchar(62) NOT NULL DEFAULT '' COMMENT '二维码内容',
  `extra` varchar(2000) NOT NULL DEFAULT '' COMMENT '接口返回的信息',
  `expired_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '过期时间',
  `total_scan_count` int(11) NOT NULL DEFAULT '0' COMMENT '总扫码关注量',
  `total_reg_count` int(11) NOT NULL DEFAULT '0' COMMENT '总注册数量',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道二维码';



# Dump of table oauth_access_token
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_access_token`;

CREATE TABLE `oauth_access_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(600) NOT NULL DEFAULT '',
  `expired_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '过期时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_expired_time` (`expired_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信的access_token 用于调用其他接口的';



# Dump of table oauth_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_member`;

CREATE TABLE `oauth_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT 'openid',
  `nickname` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '会员名',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 1：男 2：女',
  `country` varchar(100) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(100) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '城市',
  `headimgurl` varchar(300) NOT NULL DEFAULT '' COMMENT '微信头像url',
  `avatar` varchar(300) NOT NULL DEFAULT '' COMMENT '内部头像地址',
  `subscribe` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否关注 ',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';



# Dump of table qrcode_scan_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qrcode_scan_history`;

CREATE TABLE `qrcode_scan_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT 'openid',
  `qrcode_id` int(11) NOT NULL DEFAULT '0' COMMENT '二维码id',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道二维码扫码openid记录';



# Dump of table wx_msg_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_msg_history`;

CREATE TABLE `wx_msg_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_openid` varchar(64) NOT NULL DEFAULT '' COMMENT '发送方帐号',
  `to_openid` varchar(64) NOT NULL DEFAULT '' COMMENT '开发者微信号',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
  `content` varchar(500) NOT NULL COMMENT '正文内容',
  `text` text NOT NULL COMMENT '全部内容xml',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信内容历史';



# Dump of table wx_queue_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_queue_list`;

CREATE TABLE `wx_queue_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(30) NOT NULL DEFAULT '' COMMENT '队列名字',
  `data` varchar(500) NOT NULL DEFAULT '' COMMENT '队列数据',
  `status` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '状态 -1 待处理 1 已处理',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件队列表';



# Dump of table wx_wall_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_wall_history`;

CREATE TABLE `wx_wall_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:文本 2：图片',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-1 待审核 0 无效 1 有效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_uid_status` (`member_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信墙信息';




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
