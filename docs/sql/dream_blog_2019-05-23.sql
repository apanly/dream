# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 118.89.106.129 (MySQL 5.5.53-0ubuntu0.14.04.1)
# Database: dream_blog
# Generation Time: 2019-05-23 07:10:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `account` varchar(100) NOT NULL DEFAULT '' COMMENT '账号',
  `pwd` varchar(2000) NOT NULL DEFAULT '' COMMENT '通行证密码',
  `description` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账户列表';



# Dump of table admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '加密后的密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 有效  0 无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`uid`),
  KEY `idx_mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table awe_docs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `awe_docs`;

CREATE TABLE `awe_docs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容 md',
  `status` tinyint(4) NOT NULL DEFAULT '-2' COMMENT '状态 -2 排队中 -1 正在写 0 删除 1 正常',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教程内容列表';



# Dump of table awe_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `awe_menu`;

CREATE TABLE `awe_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `doc_id` int(11) NOT NULL DEFAULT '0' COMMENT '具体菜单指向教程id',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '权重字段',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1 展示 0 不展示',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教程菜单';



# Dump of table blog_sync_mapping
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog_sync_mapping`;

CREATE TABLE `blog_sync_mapping` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL COMMENT '本站blog的id',
  `cto51_id` varchar(64) NOT NULL DEFAULT '' COMMENT '51cto博客的id',
  `csdn_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'csdn的id',
  `sina_id` varchar(64) NOT NULL DEFAULT '' COMMENT '新浪博客的id',
  `netease_id` varchar(64) NOT NULL DEFAULT '' COMMENT '网易博客的id',
  `oschina_id` varchar(64) NOT NULL DEFAULT '' COMMENT '开源中国的id',
  `cnblogs_id` varchar(64) NOT NULL DEFAULT '' COMMENT '博客园的id',
  `chinaunix_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'chinaunix的id',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_blog_id` (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='本站blog_id 与其他同步站点的id关系';



# Dump of table blog_sync_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog_sync_queue`;

CREATE TABLE `blog_sync_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL COMMENT '本站博客id',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：-1： 待运行 0： 失败 1：成功',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客同步队列';



# Dump of table book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'isbn编号',
  `bartype` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类别:EAN13',
  `name` text COLLATE utf8_unicode_ci NOT NULL COMMENT '书名',
  `subtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '小标题',
  `creator` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `binding` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pages` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '页数',
  `publish_date` date NOT NULL DEFAULT '0000-00-00' COMMENT '出版时间',
  `publishing_house` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tags` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签',
  `summary` text COLLATE utf8_unicode_ci NOT NULL COMMENT '简介',
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '网站内的url',
  `origin_image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '原图url',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 有效 0 无效',
  `read_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '读书状态：-1 在读 0 未读 1 读完',
  `read_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '计划结束读书时间',
  `read_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '计划开始读书时间',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table city
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `province_id` mediumint(9) NOT NULL,
  `province` varchar(20) NOT NULL,
  `province_alias_name` varchar(20) NOT NULL DEFAULT '' COMMENT '省份别名',
  `city_id` mediumint(9) NOT NULL,
  `city` varchar(20) NOT NULL,
  `area_id` int(11) NOT NULL,
  `area` varchar(20) NOT NULL,
  `region_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '区域id，0：其他 1：华北 2：东北 3：西北 4：华南 5：华中 6：西南 7：华东',
  `region_name` varchar(20) NOT NULL DEFAULT '' COMMENT '区域名称 如：华北',
  PRIMARY KEY (`id`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `region_id` (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table doubanmz
# ------------------------------------------------------------

DROP TABLE IF EXISTS `doubanmz`;

CREATE TABLE `doubanmz` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash_key` varchar(32) NOT NULL DEFAULT '' COMMENT 'url md5',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `src_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'url',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_hash_key` (`hash_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table emoticon_library
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emoticon_library`;

CREATE TABLE `emoticon_library` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '表情名字',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '表情url',
  `cdn_source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是cdn源文件  1：是  0 不是',
  `cdn_rule` varchar(500) NOT NULL DEFAULT '' COMMENT 'json cdn图片规则 存储，一个小图，一个大图',
  `self_cdn` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是自己的cdn，1是的 0 不是',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '组id',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '展示 1：展示 0：不展示',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表情库';



# Dump of table emoticon_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emoticon_queue`;

CREATE TABLE `emoticon_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source` tinyint(3) NOT NULL DEFAULT '0' COMMENT '来源：0 无，1：公众号 2：网站',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型 1:pic 2:网页',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '图片名称',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '图片Url地址',
  `uniq_key` varchar(32) NOT NULL DEFAULT '' COMMENT '图片url hash',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：-1 待处理 0 处理失败 1 处理成功',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uniq_key` (`uniq_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='待处理表情队列';



# Dump of table health_day
# ------------------------------------------------------------

DROP TABLE IF EXISTS `health_day`;

CREATE TABLE `health_day` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table health_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `health_log`;

CREATE TABLE `health_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
  `hash_key` varchar(32) NOT NULL DEFAULT '' COMMENT 'md5',
  `quantity` int(11) NOT NULL COMMENT '步数',
  `time_from` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `time_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `lat` float(10,6) NOT NULL DEFAULT '0.000000' COMMENT '经度',
  `lng` float(10,6) NOT NULL DEFAULT '0.000000' COMMENT '维度',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_date` (`date`),
  KEY `idx_hash_key` (`hash_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bucket` varchar(10) NOT NULL DEFAULT 'pic1' COMMENT '图片来源',
  `hash_key` varchar(40) NOT NULL DEFAULT '' COMMENT '文件内容的md5',
  `filepath` varchar(100) NOT NULL DEFAULT '' COMMENT '文件路径',
  `filename` varchar(50) NOT NULL DEFAULT '' COMMENT '文件名称',
  `file_url` varchar(500) NOT NULL DEFAULT '' COMMENT '文件url',
  `target_id` int(11) NOT NULL COMMENT '目标ID,最好可以定位到id',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table index_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `index_search`;

CREATE TABLE `index_search` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `description` text NOT NULL COMMENT '描述',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT 'book id',
  `post_id` int(11) NOT NULL DEFAULT '0' COMMENT 'post id',
  `search_key` varchar(1024) NOT NULL DEFAULT '' COMMENT '搜索字段',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '图片地址',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_search_key` (`search_key`(255)),
  KEY `idx_book_id` (`book_id`),
  KEY `idx_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mate_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mate_list`;

CREATE TABLE `mate_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `person_num` int(11) NOT NULL DEFAULT '1' COMMENT '回校人数',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `login_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户登录用户名',
  `login_pwd` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `salt` varchar(32) NOT NULL DEFAULT '' COMMENT '随机秘钥',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `avatar` varchar(500) NOT NULL DEFAULT '' COMMENT '用户头像',
  `last_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '最后一次登录ip',
  `last_city` varchar(32) NOT NULL DEFAULT '' COMMENT '最后的活跃城市',
  `last_city_id` int(11) NOT NULL DEFAULT '0' COMMENT '最后活跃城市id',
  `last_active_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后活跃时间',
  `reg_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '注册ip',
  `reg_city` varchar(32) NOT NULL DEFAULT '' COMMENT '注册城市',
  `reg_city_id` int(11) NOT NULL DEFAULT '0' COMMENT '注册城市id',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`),
  UNIQUE KEY `idx_login_name` (`login_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';



# Dump of table mobile_range
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mobile_range`;

CREATE TABLE `mobile_range` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` int(11) NOT NULL DEFAULT '0' COMMENT '号段',
  `provice` varchar(50) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '城市',
  `operator` varchar(50) NOT NULL DEFAULT '' COMMENT '运营商',
  `zone` varchar(10) NOT NULL DEFAULT '' COMMENT '区号',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '邮编',
  PRIMARY KEY (`id`),
  KEY `idx_prefix` (`prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table music
# ------------------------------------------------------------

DROP TABLE IF EXISTS `music`;

CREATE TABLE `music` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `song_id` varchar(64) NOT NULL DEFAULT '' COMMENT '歌曲id，调用数据的',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 1：百度  2：qq',
  `cover_image` varchar(500) NOT NULL DEFAULT '' COMMENT '封面url',
  `lrc` text NOT NULL COMMENT '歌词',
  `song_url` varchar(500) NOT NULL DEFAULT '' COMMENT '歌曲地址',
  `song_title` varchar(100) NOT NULL DEFAULT '' COMMENT '歌曲名字',
  `song_author` varchar(30) NOT NULL DEFAULT '' COMMENT '歌手名字',
  `text` text NOT NULL COMMENT '数据存储，json',
  `format_data` text NOT NULL COMMENT '常用的数据格式化出来存放起来',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 1有效 0 无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_song_id_type` (`song_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抓取的music';



# Dump of table oauth_bind
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_bind`;

CREATE TABLE `oauth_bind` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `client_type` varchar(20) NOT NULL DEFAULT '' COMMENT '客户端',
  `openid` varchar(80) NOT NULL DEFAULT '' COMMENT '第三方id',
  `extra` text NOT NULL COMMENT '额外字段',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_client_type_opend_id` (`client_type`,`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方登录绑定关系';



# Dump of table oauth_token
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_token`;

CREATE TABLE `oauth_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_type` varchar(20) NOT NULL DEFAULT '' COMMENT '客户端来源类型',
  `token` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `valid_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '有效期截止日期',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `createdt_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `client_type_token` (`client_type`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pay_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pay_order`;

CREATE TABLE `pay_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(40) NOT NULL DEFAULT '' COMMENT '随机订单号',
  `member_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `target_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商品类型 1:源码',
  `pay_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:微信 2：支付宝 3:其他 ',
  `pay_source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '下单来源:1:pc 2:m',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单应付金额',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `pay_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单实付金额',
  `pay_sn` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方流水号',
  `note` varchar(500) NOT NULL DEFAULT '' COMMENT '备注信息',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1：支付完成 0 无效 -  -8 待支付 ',
  `queue_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送状态 -8 待支付 -2 待发送 1：发送成功 0：发送失败',
  `pay_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '付款到账时间',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_sn` (`order_sn`),
  KEY `idx_member_id_status` (`member_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='在线购买订单表';



# Dump of table pay_order_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pay_order_item`;

CREATE TABLE `pay_order_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pay_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `member_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `quantity` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量 默认1份',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价格，售价 * 数量',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前折扣',
  `target_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商品类型 1:源码',
  `target_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应不同商品表的id字段',
  `note` varchar(500) NOT NULL DEFAULT '' COMMENT '备注信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1：成功 0 失败',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `id_order_id` (`pay_order_id`),
  KEY `idx_target_type_id` (`target_type`,`target_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单详情表';



# Dump of table post_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `post_comments`;

CREATE TABLE `post_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_id` bigint(20) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0' COMMENT '博客id',
  `ds_post_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '多说评论id',
  `ds_thread_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '博客在多说的id',
  `author_name` varchar(40) NOT NULL DEFAULT '' COMMENT '作者显示名',
  `author_email` varchar(50) NOT NULL DEFAULT '' COMMENT '作者邮箱',
  `author_url` varchar(512) NOT NULL DEFAULT '' COMMENT '作者网址',
  `ip` varchar(16) NOT NULL DEFAULT '' COMMENT '作者ip地址',
  `ds_created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '评论创建日期',
  `content` text NOT NULL COMMENT '评论内容',
  `parent_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '父评论id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 有效 0 无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ds_post_id` (`ds_post_id`),
  KEY `idx_post_id` (`post_id`),
  KEY `idx_ds_thread_id` (`ds_thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL DEFAULT '' COMMENT '博文序列号（替代id字段）',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'uid',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 文章，2图片 3 视频 4 音频',
  `original` tinyint(1) NOT NULL DEFAULT '0' COMMENT '原创否 1原创 0 不是',
  `hot` int(11) NOT NULL DEFAULT '0' COMMENT '热门',
  `soul` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是鸡汤文章',
  `content` mediumtext NOT NULL COMMENT '内容',
  `tags` varchar(250) NOT NULL DEFAULT '' COMMENT 'tag',
  `image_url` varchar(256) NOT NULL DEFAULT '' COMMENT '封面图片''',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 无效 1 有效   -2 排队中 -1 正在写',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '评论总数',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '阅读总数',
  `updated_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_status_original` (`status`,`original`),
  KEY `idx_status_view_count` (`status`,`view_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table posts_recommend
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_recommend`;

CREATE TABLE `posts_recommend` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL DEFAULT '0',
  `relation_blog_id` int(11) NOT NULL DEFAULT '0',
  `title_rate` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '标题相识度 百分比',
  `content_rate` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '内容相似度，百分比',
  `tags_rate` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '标签相似度',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '总得分',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_blogid_score` (`blog_id`,`score`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table posts_recommend_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_recommend_queue`;

CREATE TABLE `posts_recommend_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 1：成功  0 失败  -1 待执行',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table posts_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_tags`;

CREATE TABLE `posts_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `posts_id` int(11) NOT NULL DEFAULT '0' COMMENT '博文id',
  `tag` varchar(64) NOT NULL DEFAULT '' COMMENT '博文tag',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique` (`posts_id`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table release_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `release_queue`;

CREATE TABLE `release_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `repo` varchar(20) NOT NULL DEFAULT '' COMMENT '仓库',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态  -2 待运行  -1 运行中  0 失败  1 成功',
  `content` text COMMENT '输出内容',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '发布备注',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='运维发布队列';



# Dump of table report_analyse_files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report_analyse_files`;

CREATE TABLE `report_analyse_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '来源：1：百度 2：umeng',
  `action` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型,1:keyword',
  `file_path` varchar(100) NOT NULL DEFAULT '' COMMENT '文件路径',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态： -1 待处理 0 失败  1 处理完毕',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_action_status` (`action`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='需要分析的报表文件历史表';



# Dump of table report_auth_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report_auth_history`;

CREATE TABLE `report_auth_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:百度 2：umeng',
  `params` varchar(3000) NOT NULL DEFAULT '' COMMENT '用户授权cookie信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_type_status` (`type`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='统计报告登录信息历史表';



# Dump of table report_daily_keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report_daily_keywords`;

CREATE TABLE `report_daily_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型 1：百度 2：umeng',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `word` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `uniq_key` varchar(32) NOT NULL DEFAULT '' COMMENT '唯一key,md5(type_date_word)',
  `click_number` int(11) NOT NULL DEFAULT '0' COMMENT '点击数量',
  `display_number` int(11) NOT NULL DEFAULT '0' COMMENT '展示数量',
  `params` varchar(2000) NOT NULL DEFAULT '' COMMENT '参数json',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uniq_key` (`uniq_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='每日关键词统计';



# Dump of table rich_media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rich_media`;

CREATE TABLE `rich_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '标题',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `src_url` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  `hash_url` varchar(40) NOT NULL DEFAULT '' COMMENT '地址的md5',
  `thumb_url` varchar(500) NOT NULL DEFAULT '' COMMENT '视频缩略图地址',
  `gps` text NOT NULL COMMENT 'gps信息',
  `tiff` text NOT NULL COMMENT 'tiff信息',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '拍照地址',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1 有效 0 无效',
  `exif` text NOT NULL COMMENT '图片额外信息',
  `description` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注，如果有的话',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='富媒体博文';



# Dump of table soft
# ------------------------------------------------------------

DROP TABLE IF EXISTS `soft`;

CREATE TABLE `soft` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL DEFAULT '' COMMENT '序列号',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1： 小程序，2：mac app 3 ：web程序 ',
  `content` mediumtext NOT NULL COMMENT '内容',
  `tags` varchar(250) NOT NULL DEFAULT '' COMMENT 'tag',
  `image_url` varchar(256) NOT NULL DEFAULT '' COMMENT '封面图片''',
  `preview_url` varchar(256) NOT NULL DEFAULT '' COMMENT '演示地址',
  `down_url` varchar(256) NOT NULL DEFAULT '' COMMENT '下载地址',
  `origin_info_url` varchar(256) NOT NULL DEFAULT '' COMMENT '源网站详情地址',
  `need_buy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要购买 1：需要 0：不需要',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购买价格',
  `free_number` int(11) NOT NULL DEFAULT '0' COMMENT '免费名额',
  `apply_number` int(11) NOT NULL DEFAULT '0' COMMENT '已申请名额',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 无效 1 有效 ',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '评论总数',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '阅读总数',
  `updated_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_sn` (`sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='软件下载';



# Dump of table soft_ngrok
# ------------------------------------------------------------

DROP TABLE IF EXISTS `soft_ngrok`;

CREATE TABLE `soft_ngrok` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `pay_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '支付订单id',
  `prefix_domain` varchar(15) NOT NULL DEFAULT '' COMMENT '域名前缀',
  `auth_token` varchar(32) NOT NULL DEFAULT '' COMMENT '认证auth',
  `start_time` date NOT NULL DEFAULT '0000-00-00' COMMENT '开始时间',
  `end_time` date NOT NULL DEFAULT '0000-00-00' COMMENT '结束时间',
  `updated_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_prefix_domain` (`prefix_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品ngrok 或者以后的frp';



# Dump of table soft_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `soft_queue`;

CREATE TABLE `soft_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `pay_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `data` varchar(500) NOT NULL DEFAULT '' COMMENT '队列数据',
  `status` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '状态 -1 待处理 1 已处理',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_member_id` (`member_id`),
  KEY `uni_pay_id` (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='软件队列表';



# Dump of table soft_sale_change_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `soft_sale_change_log`;

CREATE TABLE `soft_sale_change_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `soft_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '售卖数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '售卖金额',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '售卖时间',
  PRIMARY KEY (`id`),
  KEY `idx_soft_id` (`soft_id`),
  KEY `idx_member_soft_id` (`member_id`,`soft_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品销售情况';



# Dump of table spider_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spider_queue`;

CREATE TABLE `spider_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL DEFAULT '',
  `hash_url` varchar(32) NOT NULL DEFAULT '' COMMENT 'url的md5',
  `status` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '-2 等待处理 -1 表示处理中  0 表示失败或者不需要 1 表示成功',
  `post_id` int(11) NOT NULL COMMENT '文章ID',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_hash_url` (`hash_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='爬取文章队列表';



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户uid',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `unique_name` varchar(60) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `avatar` varchar(500) NOT NULL DEFAULT '' COMMENT '用户头像',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '用户手机号码',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `idx_name` (`unique_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';



# Dump of table user_message_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_message_history`;

CREATE TABLE `user_message_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:文本 2：图片',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-1 待审核 0 无效 1 有效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_uid_status` (`uid`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户消息表';



# Dump of table user_openid_unionid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_openid_unionid`;

CREATE TABLE `user_openid_unionid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL COMMENT '用户uid',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '微信openid（授权openid）',
  `unionid` char(50) NOT NULL DEFAULT '' COMMENT '微信unionid',
  `other_openid` varchar(80) NOT NULL DEFAULT '' COMMENT '自己公众号的openid',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uid_openid` (`uid`,`openid`),
  KEY `idx_other_openid` (`other_openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和微信信息绑定';



# Dump of table wx_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_history`;

CREATE TABLE `wx_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_openid` varchar(64) NOT NULL DEFAULT '' COMMENT '发送方帐号',
  `to_openid` varchar(64) NOT NULL DEFAULT '' COMMENT '开发者微信号',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '正文内容',
  `text` text NOT NULL COMMENT '全部内容xml',
  `source` varchar(30) NOT NULL DEFAULT '' COMMENT '来源',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
