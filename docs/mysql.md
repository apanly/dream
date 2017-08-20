## 20170819

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

## 20161226
    ALTER TABLE `posts` ADD `sn` VARCHAR(20)  NOT NULL  DEFAULT ''  COMMENT '博文序列号（替代id字段）'  AFTER `id`;
    ALTER TABLE `posts` ADD INDEX `idx_sn` (`sn`);
    update posts set sn = id ;

## 20161021
    ALTER TABLE `access_logs` ADD `client_browser` VARCHAR(50)  NOT NULL  DEFAULT ''  COMMENT '浏览器'  AFTER `user_agent`;
    ALTER TABLE `access_logs` ADD `client_os` VARCHAR(20)  NOT NULL  DEFAULT ''  COMMENT '客户端操作系统'  AFTER `client_browser`;
    ALTER TABLE `access_logs` ADD `client_device` VARCHAR(20)  NOT NULL  DEFAULT ''  COMMENT '客户端设备'  AFTER `client_os`;
    ALTER TABLE `access_logs` ADD `client_browser_version` VARCHAR(40)  NOT NULL  DEFAULT ''  COMMENT '浏览器版本号'  AFTER `client_browser`;
    ALTER TABLE `access_logs` ADD `client_os_version` VARCHAR(40)  NOT NULL  DEFAULT ''  COMMENT '操作系统版本号'  AFTER `client_os`;
    ALTER TABLE `access_logs` ADD `client_width` INT(11)  NOT NULL  DEFAULT '0'  COMMENT '分辨率宽度'  AFTER `uuid`;
    ALTER TABLE `access_logs` ADD `client_height` INT(11)  NOT NULL  DEFAULT '0'  COMMENT '分辨率高度'  AFTER `client_width`;
    ALTER TABLE `stat_daily_access_source` ADD UNIQUE INDEX `idx_date_source` (`date`, `source`);
    ALTER TABLE `stat_daily_uuid` ADD UNIQUE INDEX `idx_date_uuid` (`date`, `uuid`);
    ALTER TABLE `stat_daily_os` ADD UNIQUE INDEX `idx_date_client_os` (`date`, `client_os`);


## 20160615
    ALTER TABLE `user_openid_unionid` ADD INDEX `idx_other_openid` (`other_openid`);


## 20160531
    
    ALTER TABLE `user_openid_unionid` ADD `other_openid` VARCHAR(80)  NOT NULL  DEFAULT ''  COMMENT '自己公众号的openid'  AFTER `unionid`;
    ALTER TABLE `user_openid_unionid` CHANGE `openid` `openid` VARCHAR(50)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT ''  COMMENT '微信openid（授权openid）';
    ALTER TABLE `user` ADD `avatar` VARCHAR(500)  NOT NULL  DEFAULT ''  COMMENT '用户头像'  AFTER `nickname`;
    ALTER TABLE `user` ADD `unique_name` VARCHAR(60)  NOT NULL  DEFAULT ''  COMMENT '唯一标识'  AFTER `nickname`;
    update `user`  a 
    left join user_openid_unionid b on a.uid = b.uid 
    set a.unique_name = md5(b.openid);
    
    ALTER TABLE `user` ADD UNIQUE INDEX `idx_name` (`unique_name`);



## table schema

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


    CREATE TABLE `blog_sync_queue` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `blog_id` int(11) NOT NULL COMMENT '本站博客id',
      `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：-1： 待运行 0： 失败 1：成功',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客同步队列';


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


    CREATE TABLE `health_day` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
      `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`),
      UNIQUE KEY `idx_date` (`date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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



    CREATE TABLE `index_search` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
      `description` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
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

    CREATE TABLE `posts` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'uid',
      `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
      `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 文章，2图片 3 视频 4 音频',
      `original` tinyint(1) NOT NULL DEFAULT '0' COMMENT '原创否 1原创 0 不是',
      `hot` int(11) NOT NULL DEFAULT '0' COMMENT '热门',
      `content` text NOT NULL COMMENT '内容',
      `tags` varchar(250) NOT NULL DEFAULT '' COMMENT 'tag',
      `image_url` varchar(256) NOT NULL DEFAULT '' COMMENT '封面图片''',
      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 无效 1 有效',
      `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '评论总数',
      `updated_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
      `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
      PRIMARY KEY (`id`),
      KEY `idx_hot` (`hot`),
      KEY `idx_original` (`original`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

    CREATE TABLE `posts_recommend_queue` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `blog_id` int(11) NOT NULL DEFAULT '0',
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 1：成功  0 失败  -1 待执行',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE `posts_tags` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `posts_id` int(11) NOT NULL DEFAULT '0' COMMENT '博文id',
      `tag` varchar(64) NOT NULL DEFAULT '' COMMENT '博文tag',
      PRIMARY KEY (`id`),
      UNIQUE KEY `idx_unique` (`posts_id`,`tag`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
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

    CREATE TABLE `user` (
      `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户uid',
      `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
      `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '用户手机号码',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`uid`),
      UNIQUE KEY `idx_nickname` (`nickname`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

    CREATE TABLE `user_openid_unionid` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `uid` bigint(20) NOT NULL COMMENT '用户uid',
      `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '微信openid',
      `unionid` char(50) NOT NULL DEFAULT '' COMMENT '微信unionid',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`),
      UNIQUE KEY `idx_uid_openid` (`uid`,`openid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和微信信息绑定';


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
    
    CREATE TABLE `stat_access` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
      `total_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日总访问数量',
      `total_ip_number` int(11) NOT NULL DEFAULT '0' COMMENT '当日ip总数量',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`),
      UNIQUE KEY `idx_date` (`date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客访问统计表';
    
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
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='账户列表';
    
    CREATE TABLE `admin_access_log` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `target_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型1：admin',
      `target_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型为1：admin.id',
      `act_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '动作类型：1登录  2:访问',
      `login_name` varchar(50) NOT NULL DEFAULT '' COMMENT '账号',s
      `refer_url` varchar(255) NOT NULL DEFAULT '' COMMENT '当前访问的refer',
      `target_url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问的url',
      `query_params` varchar(1000) NOT NULL DEFAULT '' COMMENT 'get和post参数',
      `ua` varchar(255) NOT NULL DEFAULT '' COMMENT '访问ua',
      `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '访问ip',
      `note` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json格式备注字段',
      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：成功 0 失败',
      `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_type_name_status` (`target_type`,`login_name`,`status`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='admin端访问记录表';
    
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

