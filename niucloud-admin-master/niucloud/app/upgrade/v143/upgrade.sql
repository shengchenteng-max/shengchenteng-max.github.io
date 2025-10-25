
DROP TABLE IF EXISTS `web_nav`;
CREATE TABLE `web_nav` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `nav_title` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '导航名称',
  `nav_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `sort` INT(11) NOT NULL COMMENT '排序号',
  `is_blank` INT(11) DEFAULT 0 COMMENT '是否新打开',
  `create_time` INT(11) DEFAULT 0 COMMENT '创建时间',
  `update_time` INT(11) DEFAULT 0 COMMENT '修改时间',
  `is_show` SMALLINT(6) NOT NULL DEFAULT 1 COMMENT '是否显示 1显示 0不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='PC导航管理';


DROP TABLE IF EXISTS `web_friendly_link`;
CREATE TABLE `web_friendly_link` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `link_title` VARCHAR(100) NOT NULL COMMENT '标题',
  `link_url` VARCHAR(100) NOT NULL COMMENT '链接',
  `link_pic` VARCHAR(100) NOT NULL COMMENT '图片',
  `sort` INT(11) NOT NULL DEFAULT 0 COMMENT '排序号',
  `is_show` INT(11) NOT NULL DEFAULT 1 COMMENT '是否显示 1.是 2.否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='电脑端友情链接表';


DROP TABLE IF EXISTS `web_adv`;
CREATE TABLE `web_adv` (
  `adv_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `adv_key` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '广告位key',
  `adv_title` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '广告内容描述',
  `adv_url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '广告链接',
  `adv_image` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '广告内容图片',
  `sort` INT(11) NOT NULL DEFAULT 0 COMMENT '排序号',
  `background` VARCHAR(255) NOT NULL DEFAULT '#FFFFFF' COMMENT '背景色',
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='广告表';
