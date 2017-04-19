/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : graduate_hnis

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-03-16 10:56:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hnis_admin
-- ----------------------------
DROP TABLE IF EXISTS `hnis_admin`;
CREATE TABLE `hnis_admin` (
  `admin_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(30) NOT NULL COMMENT '账号',
  `admin_password` char(64) NOT NULL COMMENT '密码',
  `admin_is_use` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用 1:启用 0:禁用',
  `admin_is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 1:删除 0:未删除',
  `admin_addtime` timestamp NOT NULL COMMENT '管理员添加时间',
  `admin_adder` varchar(30) NOT NULL COMMENT '添加管理员账户的管理员名称',
  PRIMARY KEY (`admin_id`),
  KEY `admin_addtime` (`admin_addtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Table structure for hnis_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `hnis_admin_role`;
CREATE TABLE `hnis_admin_role` (
  `admin_id` tinyint(3) unsigned NOT NULL COMMENT '管理员的ID',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色的ID',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `hnis_admin_role_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `hnis_admin` (`admin_id`),
  CONSTRAINT `hnis_admin_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `hnis_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

-- ----------------------------
-- Table structure for hnis_category
-- ----------------------------
DROP TABLE IF EXISTS `hnis_category`;
CREATE TABLE `hnis_category` (
  `cate_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(30) NOT NULL COMMENT '分类名称',
  `cate_parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID,0:代表顶级',
  `cate_sort_num` smallint(11) NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='医生分类表';

-- ----------------------------
-- Table structure for hnis_clicked_admire_or_hate
-- ----------------------------
DROP TABLE IF EXISTS `hnis_clicked_admire_or_hate`;
CREATE TABLE `hnis_clicked_admire_or_hate` (
  `pat_id` mediumint(8) unsigned NOT NULL COMMENT '患者ID',
  `clicked_type` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0:没有点击过 1:admire 2:hate',
  KEY `pat_id` (`pat_id`),
  KEY `clicked_type` (`clicked_type`),
  CONSTRAINT `hnis_clicked_admire_or_hate_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `hnis_patient` (`pat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户赞或厌恶';

-- ----------------------------
-- Table structure for hnis_clicked_use
-- ----------------------------
DROP TABLE IF EXISTS `hnis_clicked_use`;
CREATE TABLE `hnis_clicked_use` (
  `pat_id` mediumint(8) unsigned NOT NULL COMMENT '评论者',
  `com_id` mediumint(8) unsigned NOT NULL COMMENT '评论的ID',
  KEY `pat_id` (`pat_id`),
  KEY `com_id` (`com_id`),
  CONSTRAINT `hnis_clicked_use_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `hnis_patient` (`pat_id`),
  CONSTRAINT `hnis_clicked_use_ibfk_2` FOREIGN KEY (`com_id`) REFERENCES `hnis_comment` (`com_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户点击过有用的评论';

-- ----------------------------
-- Table structure for hnis_comment
-- ----------------------------
DROP TABLE IF EXISTS `hnis_comment`;
CREATE TABLE `hnis_comment` (
  `com_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `com_content` varchar(1000) NOT NULL COMMENT '评论内容',
  `com_star` tinyint(3) unsigned NOT NULL DEFAULT '3' COMMENT '打的分',
  `com_addtime` timestamp NOT NULL COMMENT '评论时间',
  `pat_id` mediumint(8) unsigned NOT NULL COMMENT '评论者',
  `doc_id` mediumint(8) unsigned NOT NULL COMMENT '医生ID',
  `com_is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '该评论是否删除, 0:未删除 1:删除',
  PRIMARY KEY (`com_id`),
  KEY `com_addtime` (`com_addtime`),
  KEY `pat_id` (`pat_id`),
  KEY `doc_id` (`doc_id`),
  CONSTRAINT `hnis_comment_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `hnis_patient` (`pat_id`),
  CONSTRAINT `hnis_comment_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `hnis_doctor` (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='医生评论表';

-- ----------------------------
-- Table structure for hnis_doctor
-- ----------------------------
DROP TABLE IF EXISTS `hnis_doctor`;
CREATE TABLE `hnis_doctor` (
  `doc_id` mediumint(8) unsigned NOT NULL,
  `doc_name` varchar(45) NOT NULL COMMENT '医生名称',
  `doc_face` varchar(150) NOT NULL DEFAULT '' COMMENT '医生头像',
  `doc_sm_face` varchar(150) NOT NULL DEFAULT '' COMMENT '医生头像缩略图',
  `doc_score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '医生得分',
  `doc_seo_keyword` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo_关键字',
  `doc_seo_description` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo_描述',
  `doc_sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序数字',
  `doc_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '医生描述',
  `doc_tel` char(11) NOT NULL COMMENT '医生的移动电话',
  `doc_password` char(64) NOT NULL COMMENT '医生的登录密码',
  `doc_follow_number` int(11) NOT NULL DEFAULT '0' COMMENT '医生的用户收藏数量',
  `doc_admire_number` int(11) NOT NULL DEFAULT '0' COMMENT '医生的点赞数量',
  `doc_hate_number` int(11) NOT NULL DEFAULT '0' COMMENT '医生的厌恶数量',
  `doc_room_title` varchar(200) NOT NULL COMMENT '房间名称',
  `doc_is_new` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否新医生',
  `doc_is_online` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否在线：1:在线，0:下线',
  `doc_is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经删除，1:已经删除 0:未删除',
  `doc_addtime` timestamp NOT NULL COMMENT '添加时间',
  `doc_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '医生账户余额',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '医生所属主分类id',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '医生所属类型id',
  PRIMARY KEY (`doc_id`),
  KEY `doc_is_new` (`doc_is_new`),
  KEY `doc_sort_num` (`doc_sort_num`),
  KEY `doc_is_online` (`doc_is_online`),
  KEY `doc_is_delete` (`doc_is_delete`),
  KEY `doc_addtime` (`doc_addtime`),
  KEY `cate_id` (`cate_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `hnis_doctor_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `hnis_category` (`cate_id`),
  CONSTRAINT `hnis_doctor_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `hnis_type` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='医生';

-- ----------------------------
-- Table structure for hnis_doc_cate
-- ----------------------------
DROP TABLE IF EXISTS `hnis_doc_cate`;
CREATE TABLE `hnis_doc_cate` (
  `doc_id` mediumint(8) unsigned NOT NULL COMMENT '医生ID',
  `cate_id` smallint(5) unsigned NOT NULL COMMENT '分类id',
  KEY `doc_id` (`doc_id`),
  KEY `cate_id` (`cate_id`),
  CONSTRAINT `hnis_doc_cate_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `hnis_doctor` (`doc_id`),
  CONSTRAINT `hnis_doc_cate_ibfk_2` FOREIGN KEY (`cate_id`) REFERENCES `hnis_category` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='医生扩展分类表';

-- ----------------------------
-- Table structure for hnis_patient
-- ----------------------------
DROP TABLE IF EXISTS `hnis_patient`;
CREATE TABLE `hnis_patient` (
  `pat_id` mediumint(8) unsigned NOT NULL,
  `pat_name` varchar(45) NOT NULL DEFAULT '' COMMENT '患者名称',
  `pat_nickname` varchar(45) NOT NULL DEFAULT '' COMMENT '患者昵称',
  `pat_face` varchar(150) NOT NULL DEFAULT '' COMMENT '患者头像',
  `pat_sm_face` varchar(150) NOT NULL DEFAULT '' COMMENT '患者头像缩略图',
  `pat_is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经删除，1：已经删除 0：未删除',
  `pat_addtime` timestamp NOT NULL COMMENT '注册时间',
  `pat_email` varchar(60) NOT NULL DEFAULT '' COMMENT '患者邮箱',
  `pat_email_code` char(32) NOT NULL DEFAULT '' COMMENT '邮箱验证的验证码,当会员验证通过,清空该字段,为空,说明会员已通过验证',
  `pat_tel` char(11) NOT NULL DEFAULT '' COMMENT '患者电话号码',
  `pat_password` char(64) NOT NULL COMMENT '密码',
  `pat_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户账户余额',
  PRIMARY KEY (`pat_id`),
  KEY `pat_is_delete` (`pat_is_delete`),
  KEY `pat_addtime` (`pat_addtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='患者';

-- ----------------------------
-- Table structure for hnis_privilege
-- ----------------------------
DROP TABLE IF EXISTS `hnis_privilege`;
CREATE TABLE `hnis_privilege` (
  `pri_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `pri_module_name` varchar(20) NOT NULL COMMENT '模块名称',
  `pri_controller_name` varchar(20) NOT NULL COMMENT '控制器名称',
  `pri_action_name` varchar(20) NOT NULL COMMENT '方法名称',
  `pri_parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上级权限ID,0:代表顶级权限',
  PRIMARY KEY (`pri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Table structure for hnis_reply
-- ----------------------------
DROP TABLE IF EXISTS `hnis_reply`;
CREATE TABLE `hnis_reply` (
  `reply_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `reply_content` varchar(1000) NOT NULL COMMENT '回复内容',
  `reply_addtime` timestamp NOT NULL COMMENT '回复时间',
  `pat_id` mediumint(8) unsigned NOT NULL COMMENT '患者ID',
  `com_id` mediumint(8) unsigned NOT NULL COMMENT '评论ID',
  PRIMARY KEY (`reply_id`),
  KEY `reply_addtime` (`reply_addtime`),
  KEY `pat_id` (`pat_id`),
  KEY `com_id` (`com_id`),
  CONSTRAINT `hnis_reply_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `hnis_patient` (`pat_id`),
  CONSTRAINT `hnis_reply_ibfk_2` FOREIGN KEY (`com_id`) REFERENCES `hnis_comment` (`com_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户回复表';

-- ----------------------------
-- Table structure for hnis_role
-- ----------------------------
DROP TABLE IF EXISTS `hnis_role`;
CREATE TABLE `hnis_role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Table structure for hnis_role_privilege
-- ----------------------------
DROP TABLE IF EXISTS `hnis_role_privilege`;
CREATE TABLE `hnis_role_privilege` (
  `pri_id` smallint(5) unsigned NOT NULL COMMENT '权限的ID',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色的ID',
  KEY `pri_id` (`pri_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `hnis_role_privilege_ibfk_1` FOREIGN KEY (`pri_id`) REFERENCES `hnis_privilege` (`pri_id`),
  CONSTRAINT `hnis_role_privilege_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `hnis_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Table structure for hnis_type
-- ----------------------------
DROP TABLE IF EXISTS `hnis_type`;
CREATE TABLE `hnis_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(30) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='医生类型表';
SET FOREIGN_KEY_CHECKS=1;
