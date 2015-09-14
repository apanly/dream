CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '加密后的密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 有效  0 无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'uid',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 文章，2图片 3 视频 4 音频',
  `content` text NOT NULL COMMENT '内容',
  `tags` varchar(250) NOT NULL DEFAULT '' COMMENT 'tag',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 无效 1 有效',
  `updated_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `posts_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL COMMENT '评论内容json',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 有效 0 无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;