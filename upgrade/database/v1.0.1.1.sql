#预约客户  - 新增字段
ALTER TABLE `fixture_client` ADD COLUMN `cityid`  int(11) NULL DEFAULT NULL COMMENT '城市id' AFTER `storeid`;
#预约客户 -数据同步
UPDATE fixture_client a,fixture_store b SET a.cityid = b.cityid WHERE a.storeid = b.id AND a.storeid>0;
#预约客户 - 新增字段
ALTER TABLE `fixture_client` ADD COLUMN `clientcity`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客户所在城市' AFTER `content`;
#预约客户 - 字段说明同步
ALTER TABLE `fixture_client` MODIFY COLUMN `userid`  int(11) NULL DEFAULT NULL COMMENT '当前跟进者id,对应用户user表id' AFTER `followcontent`;
#公司 - 新增字段
ALTER TABLE `fixture_company` ADD COLUMN `covermap`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '封面图' AFTER `deadline`;
#公司服务通知模板 - 新增表结构
CREATE TABLE `fixture_company_mptemplate` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`companyid`  int(11) NULL DEFAULT NULL COMMENT '公司id' ,
`datatemplateid`  int(11) NULL DEFAULT NULL COMMENT '模板类型id,对应data_mptemplate表的id' ,
`mptemplateid`  varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信公众号号模板id' ,
`status`  tinyint(1) NULL DEFAULT 1 COMMENT '是否禁用  1正常 0关闭' ,
`created_at`  datetime NULL DEFAULT NULL COMMENT '创建时间' ,
`updated_at`  datetime NULL DEFAULT NULL COMMENT '修改时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact;
#公司成员 - 新增表
CREATE TABLE `fixture_company_participant` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`uuid`  char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '唯一索引' ,
`companyid`  int(11) NULL DEFAULT NULL COMMENT '公司id' ,
`positionid`  int(11) NULL DEFAULT NULL COMMENT '职位id' ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名，也就是对用户昵称的一个别名' ,
`userid`  int(11) NULL DEFAULT NULL COMMENT '创建者id,对应用户表id' ,
`created_at`  datetime NULL DEFAULT NULL COMMENT '创建时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Compact;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `value`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `name`;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `text`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标准版value' AFTER `value`;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `vipvalue`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'vip版value' AFTER `text`;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `viptext`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `vipvalue`;
#VIP配置 -修改表结构
ALTER TABLE `fixture_conf_vipfunctionpoint` MODIFY COLUMN `content`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '说明' AFTER `viptext`;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `type`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型 max has' AFTER `content`;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `controller`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '控制器' AFTER `type`;
#VIP配置 -新增结构
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `mehod`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '方法' AFTER `controller`;
#VIP配置 -删除结构
ALTER TABLE `fixture_conf_vipfunctionpoint` DROP COLUMN `vipmechanismid`;
#数据源 - 视野 - 修改表类型
ALTER TABLE `fixture_data_authorityscan` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 客户跟进状态 - 修改表类型
ALTER TABLE `fixture_data_client_followstatus` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源-服务通知 - 新增表
CREATE TABLE `fixture_data_mptemplate` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '模板名称' ,
`format`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '格式，' ,
`content`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '模板格式json' ,
`status`  tinyint(1) NULL DEFAULT 0 COMMENT '是否显示 1显示 0不显示' ,
`created_at`  datetime NULL DEFAULT NULL COMMENT '创建时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact;
#数据源-服务通知 - 新增数据
INSERT INTO `fixture_data_mptemplate` VALUES ('1', '客户预约', '{\r\n    \"first\":\"{{first.DATA}}\",\r\n    \"keyword1\":\"{{keyword1.DATA}}\",\r\n    \"keyword2\":\"{{keyword2.DATA}}\",\r\n    \"keyword3\":\"{{keyword3.DATA}}\",\r\n    \"keyword4\":\"{{keyword4.DATA}}\",\r\n    \"remark\":\"{{remark.DATA}}\"\r\n}', '{\r\n    \"first\":\"有新的客户预约，请及时确认\",\r\n    \"客户姓名\":\"张某\",\r\n    \"客户手机\":\"13888888888\",\r\n    \"预约时间\":\"2018-07-11 14:07\",\r\n    \"预约内容\":\"免费量房\",\r\n    \"remark\":\"客户在 陕西省 西安市发起了预约,住房面积为25平米\"\r\n}', '1', '2018-07-11 14:05:22');
INSERT INTO `fixture_data_mptemplate` VALUES ('2', '客户留言通知', '{\r\n    \"first\":\"{{first.DATA}}\",\r\n    \"keyword1\":\"{{keyword1.DATA}}\",\r\n    \"keyword2\":\"{{keyword2.DATA}}\",\r\n    \"keyword3\":\"{{keyword3.DATA}}\",\r\n    \"remark\":\"{{remark.DATA}}\"\r\n}', '{\r\n    \"first\":\"客户有新留言了，赶快看吧\",\r\n    \"客户姓名\":\"小王\",\r\n    \"留言内容\":\"您好，我要参观工地\",\r\n    \"预约时间\":\"2018-07-11 14:07\"\r\n}', '1', '2018-07-11 14:05:25');
#数据源-活动参与方式 - 修改表类型
ALTER TABLE `fixture_data_participatory` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 职位 -新增字段
ALTER TABLE `fixture_data_position` ADD COLUMN `roleid`  int(11) NULL DEFAULT NULL COMMENT '角色id' AFTER `companyid`;
#数据源 - 职位 - 修改数据
UPDATE  `fixture_data_position` SET `status`=0,roleid=1 WHERE  id=1;
#用户 - 职位 - 修改数据
UPDATE fixture_user SET positionid=1 WHERE isadmin=1;
#数据源 - 职位 - 修改表类型
ALTER TABLE `fixture_data_position` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 抽奖活动奖项等级 - 修改表类型
ALTER TABLE `fixture_data_prize_level` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 装修方式 - 修改表类型
ALTER TABLE `fixture_data_renovationmode` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 装修风格 - 修改表类型
ALTER TABLE `fixture_data_roomstyle` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 户型- 修改表类型
ALTER TABLE `fixture_data_roomtype` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 默认数据（ 职位、装修方式、装修风格、户型）- 修改表类型
ALTER TABLE `fixture_data_select_default` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 客户来源- 修改表类型
ALTER TABLE `fixture_data_source` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 客户来源分类- 修改表类型
ALTER TABLE `fixture_data_sourcecate` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#数据源 - 会员机制- 修改表类型
ALTER TABLE `fixture_data_vipmechanism` ENGINE=MyISAM,
ROW_FORMAT=Dynamic;
#日志 - 会员升级记录- 新增字段
ALTER TABLE `fixture_log_vipupgrade` ADD COLUMN `status`  tinyint(4) NULL DEFAULT 0 COMMENT '状态 0申请中  1已申请' AFTER `deadline`;
#日志 - 会员升级记录- 新增字段
ALTER TABLE `fixture_log_vipupgrade` ADD COLUMN `updated_at`  datetime NULL DEFAULT NULL COMMENT '更新时间' AFTER `created_at`;
#项目- 新增字段
ALTER TABLE `fixture_site` ADD COLUMN `roomshapnumber`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '房型按照英文逗号写入' AFTER `acreage`;
#项目- 修改数据
UPDATE fixture_site SET roomshapnumber=REPLACE(REPLACE(REPLACE(REPLACE(roomshap,'室',','),'厅',','),'厨',','),'卫','');
#参与者被邀请的工地/工地成员 - 新增字段
ALTER TABLE `fixture_site_invitation` ADD COLUMN `participantid`  int(11) NULL DEFAULT NULL COMMENT '新建的成员信息id,对应成员表' AFTER `siteid`;
#参与者被邀请的工地/工地成员 - 新增字段
ALTER TABLE `fixture_site_invitation` ADD COLUMN `joinuserid`  int(11) NULL DEFAULT NULL COMMENT '参与者id' AFTER `userid`;
#小程序授权 - 新增字段
ALTER TABLE `fixture_small_program` ADD COLUMN `codestatus`  tinyint(1) NULL DEFAULT NULL COMMENT '1.完善用户信息2.设置类目3.设置url4.上传代码5.提交审核6.审核发布7.发布成功' AFTER `seturl`;
#小程序授权 - 新增字段
ALTER TABLE `fixture_small_program` ADD COLUMN `union_wechat_mp_appid`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信公众号appid' AFTER `auditid`;
#小程序授权 - 新增字段
ALTER TABLE `fixture_small_program` ADD COLUMN `union_wechat_mp_appsecret`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信公众号密钥' AFTER `union_wechat_mp_appid`;
#小程序授权 - 删除字段
ALTER TABLE `fixture_small_program` DROP COLUMN `verify_ticket`;
#小程序授权 - 删除字段
ALTER TABLE `fixture_small_program` DROP COLUMN `uploadcode`;
#小程序授权 - 删除字段
ALTER TABLE `fixture_small_program` DROP COLUMN `sourcecode`;
#小程序授权 - 删除字段
ALTER TABLE `fixture_small_program` DROP COLUMN `seturl`;
#用户 - 修改字段
ALTER TABLE `fixture_user` MODIFY COLUMN `faceimg`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像' AFTER `resume`;
#用户 - 新增字段
ALTER TABLE `fixture_user` ADD COLUMN `oid`  int(11) NULL DEFAULT NULL COMMENT '之前的用户id,解绑后需要恢复的用户id' AFTER `token`;
#用户 - 新增字段
ALTER TABLE `fixture_user` ADD COLUMN `jguser`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '极光账号' AFTER `oid`;
#用户 - 动态点赞-新增表
CREATE TABLE `fixture_user_dynamic_give` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`companyid`  int(11) NULL DEFAULT NULL COMMENT '公司ID' ,
`dynamicid`  int(11) NULL DEFAULT NULL COMMENT '动态id' ,
`userid`  int(11) NULL DEFAULT NULL COMMENT '用户id' ,
`created_at`  datetime NULL DEFAULT NULL ,
`updated_at`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Compact;
#用户 - 已申请的微信公众号服务通知模板 - 新增表
CREATE TABLE `fixture_user_mptemplate` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`companyid`  int(11) NULL DEFAULT NULL COMMENT '公司id' ,
`userid`  int(11) NULL DEFAULT NULL COMMENT '用户id' ,
`companytempid`  int(11) NULL DEFAULT NULL COMMENT '公司微信公众号模板绑定id，对应company_mptemplate表id' ,
`datatemplateid`  int(11) NULL DEFAULT NULL COMMENT '数据源模板id,对应 data_mptemplate表id' ,
`mpopenid`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信公众号openid' ,
`mpstatus`  tinyint(1) NULL DEFAULT 1 COMMENT '是否开启发送,1开启 0关闭' ,
`isdefault`  tinyint(1) NULL DEFAULT 0 COMMENT '是否公司超管0 非超管 1超管' ,
`created_at`  datetime NULL DEFAULT NULL COMMENT '创建时间' ,
`updated_at`  datetime NULL DEFAULT NULL COMMENT '修改时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact;
#工地成员 - 删除表
DROP TABLE `fixture_site_participant`;
#权限方法
TRUNCATE `fixture_filter_function`;
INSERT INTO `fixture_filter_function` VALUES ('1', 'a62045a65ff211e889fa94de807e34a0', '活动管理', '0', '1', '1', '活动管理', '1', '', null, '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('2', 'a620486f5ff211e889fa94de807e34a0', '项目管理', '0', '2', '1', '项目管理', '1', '', null, '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('3', 'a620498d5ff211e889fa94de807e34a0', '客户管理', '0', '3', '1', '客户管理', '1', '', null, '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('4', 'a6204aa75ff211e889fa94de807e34a0', '门店管理', '0', '5', '1', '门店管理', '1', 'StoreController', 'store-index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('5', 'a6204b8e5ff211e889fa94de807e34a0', '角色管理', '0', '6', '1', '角色管理', '1', 'RolesController', 'roles-index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('6', 'a6204c755ff211e889fa94de807e34a0', '用户管理', '0', '7', '1', '用户管理', '1', 'AdminController', 'admin-index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('7', 'a6204d5f5ff211e889fa94de807e34a0', '系统属性', '0', '8', '1', '系统属性', '1', 'DataController', 'data-index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('8', '817dee2788e211e89e1f94de807e34a0', '服务通知', '0', '4', '1', '服务通知', '1', 'WeChatPublicNumberController', 'mp-send-index', '1', '2018-07-16 18:25:05');
INSERT INTO `fixture_filter_function` VALUES ('101', 'a6204e405ff211e889fa94de807e34a0', '幸运抽奖', '1', '1', '1', '幸运抽奖', '2', 'ActivityLuckyController', 'lucky-index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('201', 'a62055235ff211e889fa94de807e34a0', '项目列表', '2', '1', '1', '项目列表', '2', 'SiteController', 'site.index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('202', 'a62056155ff211e889fa94de807e34a0', '新建项目', '2', '2', '1', '新建项目', '2', 'SiteController', 'site.create', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('203', 'a62056f55ff211e889fa94de807e34a0', '阶段模板', '2', '3', '1', '阶段模板', '2', 'SiteTemplateController', 'site-template.index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('204', '751e6d517b8111e89f8694de807e34a0', '工地动态', '2', '4', '0', '工地动态', '2', 'DynamicController', 'dynamic-index', '1', '2018-06-29 17:47:38');
INSERT INTO `fixture_filter_function` VALUES ('301', 'a6205c485ff211e889fa94de807e34a0', '预约客户', '3', '1', '1', '预约客户', '3', 'ClientController', 'client.index', '1', '2018-05-25 16:07:00');
INSERT INTO `fixture_filter_function` VALUES ('302', 'a6205d325ff211e889fa94de807e34a0', '抽奖客户', '3', '2', '1', '抽奖客户', '3', 'ClientController', 'lucky-client', '1', '2018-05-25 16:07:00');

#将动态权限加入有已经有项目管理的角色里。
DROP PROCEDURE IF EXISTS pro_role_function;
delimiter //
CREATE PROCEDURE pro_role_function()
BEGIN
  DECLARE strRoleid int;
  DECLARE strIslook int;
  DECLARE stop int default 0;
  DECLARE cur cursor for(
		SELECT roleid,islook FROM `fixture_filter_role_function` WHERE functionid=2 and roleid not in (
			SELECT roleid FROM `fixture_filter_role_function` WHERE functionid=204 GROUP BY roleid
		) GROUP BY roleid
	);
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET stop = null;
  OPEN cur;
		FETCH cur INTO strRoleid,strIslook;
		WHILE (stop is not null)DO
		INSERT INTO `fixture_filter_role_function` VALUES ('', REPLACE(UUID(),"-",""), strRoleid, '204', strIslook, now());
		FETCH cur INTO strRoleid,strIslook;
    END WHILE;
	CLOSE cur;
END;//
delimiter ;
call pro_role_function();
DROP PROCEDURE IF EXISTS pro_role_function;