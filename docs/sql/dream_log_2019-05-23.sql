# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 118.89.106.129 (MySQL 5.5.53-0ubuntu0.14.04.1)
# Database: dream_log
# Generation Time: 2019-05-23 07:10:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table access_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `access_logs`;

CREATE TABLE `access_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(300) NOT NULL DEFAULT '' COMMENT '请求referer',
  `target_url` varchar(500) NOT NULL DEFAULT '' COMMENT '请求的url',
  `blog_id` int(11) NOT NULL DEFAULT '0' COMMENT '博文id',
  `source` varchar(100) NOT NULL DEFAULT '' COMMENT '来源域名',
  `user_agent` varchar(200) NOT NULL DEFAULT '' COMMENT '浏览器ua',
  `client_browser` varchar(50) NOT NULL DEFAULT '' COMMENT '浏览器',
  `client_browser_version` varchar(40) NOT NULL DEFAULT '' COMMENT '浏览器版本号',
  `client_os` varchar(20) NOT NULL DEFAULT '' COMMENT '客户端操作系统',
  `client_os_version` varchar(40) NOT NULL DEFAULT '' COMMENT '操作系统版本号',
  `client_device` varchar(20) NOT NULL DEFAULT '' COMMENT '客户端设备',
  `ip` varchar(128) NOT NULL DEFAULT '' COMMENT '客户端ip',
  `uuid` varchar(100) NOT NULL DEFAULT '' COMMENT 'UUID唯一的',
  `client_width` int(11) NOT NULL DEFAULT '0' COMMENT '分辨率宽度',
  `client_height` int(11) NOT NULL DEFAULT '0' COMMENT '分辨率高度',
  `created_time_min` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间 只精确到分',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ad_csp_report
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ad_csp_report`;

CREATE TABLE `ad_csp_report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '链接',
  `report_content` longtext NOT NULL COMMENT '报告内容',
  `blocked_uri` varchar(100) NOT NULL DEFAULT '' COMMENT '屏蔽url',
  `source_file` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `ua` varchar(500) NOT NULL DEFAULT '' COMMENT 'ua',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CSP 全称为 Content Security Policy，即内容安全策略 报告记录';



# Dump of table admin_access_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_access_log`;

CREATE TABLE `admin_access_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型1：admin',
  `target_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型为1：admin.id',
  `act_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '动作类型：1登录  2:访问',
  `login_name` varchar(50) NOT NULL DEFAULT '' COMMENT '账号',
  `refer_url` varchar(255) NOT NULL DEFAULT '' COMMENT '当前访问的refer',
  `target_url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问的url',
  `query_params` longtext NOT NULL COMMENT 'get和post参数',
  `ua` varchar(255) NOT NULL DEFAULT '' COMMENT '访问ua',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '访问ip',
  `note` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json格式备注字段',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：成功 0 失败',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_type_name_status` (`target_type`,`login_name`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='admin端访问记录表';



# Dump of table app_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_logs`;

CREATE TABLE `app_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_name` varchar(30) NOT NULL DEFAULT '' COMMENT 'app 名字',
  `request_uri` varchar(255) NOT NULL DEFAULT '' COMMENT '请求uri',
  `content` text NOT NULL COMMENT '日志内容',
  `ip` varchar(500) NOT NULL DEFAULT '' COMMENT 'ip',
  `ua` varchar(1000) NOT NULL DEFAULT '' COMMENT 'ua信息',
  `cookies` varchar(5000) NOT NULL DEFAULT '' COMMENT 'cookie信息。如果有的话',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app错误日表';



# Dump of table stat_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_access`;

CREATE TABLE `stat_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日总访问数量',
  `total_ip_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日ip总数量',
  `total_uv_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日uv总数量',
  `total_new_user_number` int(11) NOT NULL DEFAULT '0' COMMENT '新用户，历史上从未访问过的',
  `total_returned_user_number` int(11) NOT NULL DEFAULT '0' COMMENT '回访客户总数',
  `avg_pv_per_uv` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平均每个用户访问页面数量',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客访问统计表';



# Dump of table stat_blog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_blog`;

CREATE TABLE `stat_blog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `today_post_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日发布文章数量',
  `total_post_number` int(11) NOT NULL DEFAULT '0' COMMENT '已发布博客数量',
  `total_unpost_number` int(11) NOT NULL DEFAULT '0' COMMENT '未发布博客数量',
  `total_original_number` int(11) NOT NULL DEFAULT '0' COMMENT '原创博客数量',
  `total_hot_number` int(11) NOT NULL DEFAULT '0' COMMENT '热门博客数量',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客统计表';



# Dump of table stat_daily_access_source
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_daily_access_source`;

CREATE TABLE `stat_daily_access_source` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期 20160617',
  `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '来源总次数',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date_source` (`date`,`source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='访问来源日表统计';



# Dump of table stat_daily_browser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_daily_browser`;

CREATE TABLE `stat_daily_browser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
  `client_browser` varchar(50) NOT NULL DEFAULT '' COMMENT '浏览器名称',
  `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '总次数',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date_client_browser` (`date`,`client_browser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='浏览器日表统计';



# Dump of table stat_daily_device
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_daily_device`;

CREATE TABLE `stat_daily_device` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_device` varchar(50) NOT NULL DEFAULT '' COMMENT '设备名称',
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
  `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日总次数',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date_client_device` (`date`,`client_device`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户端设备 日统计';



# Dump of table stat_daily_os
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_daily_os`;

CREATE TABLE `stat_daily_os` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_os` varchar(50) NOT NULL DEFAULT '' COMMENT '操作系统名称',
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
  `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日总次数',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date_client_os` (`date`,`client_os`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作系统 日统计';



# Dump of table stat_daily_uuid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stat_daily_uuid`;

CREATE TABLE `stat_daily_uuid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) NOT NULL DEFAULT '' COMMENT '唯一标示',
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期 20161016',
  `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '总次数',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date_uuid` (`date`,`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='uuid 日统计';



# Dump of table sys_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sys_logs`;

CREATE TABLE `sys_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '类型 1：七牛数据库',
  `file_key` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名',
  `note` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统日志';




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
