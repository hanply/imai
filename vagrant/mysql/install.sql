SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `account` varchar(20) NOT NULL COMMENT '登录帐号',
  `nickname` varchar(20) NOT NULL COMMENT '昵称',
  `realname` varchar(20) NOT NULL COMMENT '真实姓名',
  `mobile` varchar(15) DEFAULT NULL COMMENT '电话',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `headimg` varchar(255) DEFAULT NULL COMMENT '头像',
  `passwd` varchar(60) NOT NULL COMMENT '密码',
  `department_id` int(10) unsigned DEFAULT '0' COMMENT '部门ID',
  `sex` tinyint(2) unsigned DEFAULT '1' COMMENT '性别 1：男 2：女',
  `intro` varchar(300) DEFAULT NULL COMMENT '备注',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，2冻结，-1删除',
  `aid` int(10) unsigned NOT NULL COMMENT '操作员ID',
  `updated_at` int(10) unsigned NOT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`),
  KEY `nickname` (`nickname`),
  KEY `realname` (`realname`),
  KEY `mobile` (`mobile`),
  KEY `email` (`email`),
  KEY `passwd` (`passwd`),
  KEY `department_id` (`department_id`),
  KEY `aid` (`aid`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '超级管理员', '超级管理员', '18516888570', null, '/headimg/avatar1.png', '$2y$13$36NYghcmLau3QEF73IF/DOxW7Czo824io.4KQlhEzCvaWIX1HaH8q', '0', '1', null, '1', '0', '1540551235', '1540551235');

-- ----------------------------
-- Table structure for `rbac_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_admin_role`;
CREATE TABLE `rbac_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `admin_id` int(10) unsigned NOT NULL COMMENT '管理员id',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，-1删除',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色关联表';

-- ----------------------------
-- Records of rbac_admin_role
-- ----------------------------

-- ----------------------------
-- Table structure for `rbac_auth`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_auth`;
CREATE TABLE `rbac_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module` varchar(30) NOT NULL COMMENT '模块',
  `controller` varchar(30) NOT NULL COMMENT '控制器',
  `action` varchar(30) NOT NULL COMMENT '方法',
  `desc` varchar(100) NOT NULL COMMENT '描述',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，2冻结，-1删除',
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `controller` (`controller`),
  KEY `action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='方法表';

-- ----------------------------
-- Records of rbac_auth
-- ----------------------------

-- ----------------------------
-- Table structure for `rbac_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_privilege`;
CREATE TABLE `rbac_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `code` smallint(5) unsigned NOT NULL COMMENT '功能编号',
  `name` varchar(10) NOT NULL COMMENT '功能名称',
  `pid` int(10) unsigned DEFAULT '0' COMMENT '父功能id',
  `link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `icon` varchar(30) DEFAULT NULL COMMENT '菜单图标',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '功能类型 1：普通 2：按钮',
  `is_show` tinyint(2) unsigned DEFAULT '2' COMMENT '菜单是否显示：1显示，2不显示',
  `sort` smallint(5) unsigned DEFAULT '0' COMMENT '排序值',
  `desc` varchar(30) DEFAULT NULL COMMENT '功能描述',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态：1启用，2冻结，-1删除',
  `aid` int(10) unsigned NOT NULL COMMENT '操作员ID',
  `updated_at` int(10) unsigned NOT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `pid` (`pid`),
  KEY `sort` (`sort`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of rbac_privilege
-- ----------------------------

-- ----------------------------
-- Table structure for `rbac_privilege_auth`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_privilege_auth`;
CREATE TABLE `rbac_privilege_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `privilege_id` int(10) unsigned NOT NULL COMMENT '功能id',
  `auth_id` int(10) unsigned NOT NULL COMMENT '方法id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，-1删除',
  PRIMARY KEY (`id`),
  KEY `privilege_id` (`privilege_id`),
  KEY `auth_id` (`auth_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限方法关联表';

-- ----------------------------
-- Records of rbac_privilege_auth
-- ----------------------------

-- ----------------------------
-- Table structure for `rbac_role`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_role`;
CREATE TABLE `rbac_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(30) NOT NULL COMMENT '名称',
  `desc` varchar(100) DEFAULT NULL COMMENT '描述',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，2冻结，-1删除',
  `aid` int(10) unsigned NOT NULL COMMENT '操作员ID',
  `updated_at` int(10) unsigned NOT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of rbac_role
-- ----------------------------

-- ----------------------------
-- Table structure for `rbac_role_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_role_privilege`;
CREATE TABLE `rbac_role_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `privilege_id` int(10) unsigned NOT NULL COMMENT '功能id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，-1删除',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `privilege_id` (`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色功能关联表';

-- ----------------------------
-- Records of rbac_role_privilege
-- ----------------------------

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `ftitle` varchar(80) DEFAULT NULL COMMENT '副标题',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '作者ID',
  `author` varchar(30) DEFAULT NULL,
  `cate_ids` varchar(60) NOT NULL COMMENT '分类IDs',
  `tag_ids` varchar(60) DEFAULT NULL COMMENT '标签IDs',
  `keywords` varchar(255) DEFAULT NULL COMMENT '文章关键词',
  `summary` varchar(300) DEFAULT NULL COMMENT '简述',
  `is_original` tinyint(2) unsigned DEFAULT '1' COMMENT '是否原创：1是，2不是',
  `origin` varchar(50) DEFAULT NULL COMMENT '来源',
  `reprint_url` varchar(255) DEFAULT NULL COMMENT '转载地址',
  `type` tinyint(2) unsigned DEFAULT '2' COMMENT '文章类型：1无图 2单图 3多图',
  `show_platform` varchar(10) DEFAULT '0' COMMENT '文章展示平台：1PC，2H5，3小程序 4.android 5.ios',
  `is_top` tinyint(2) unsigned DEFAULT '2' COMMENT '1 是 2否',
  `top_at` int(10) unsigned DEFAULT NULL COMMENT '指定时间',
  `is_hot` tinyint(2) unsigned DEFAULT NULL,
  `hot_real` int(10) unsigned DEFAULT '0' COMMENT '真实最热值',
  `hot_virtual` int(10) unsigned DEFAULT '0' COMMENT '虚拟最热值',
  `visit_count` int(10) unsigned DEFAULT '0' COMMENT '浏览量',
  `comment_count` int(10) unsigned DEFAULT '0' COMMENT '评论量',
  `collect_count` int(10) unsigned DEFAULT '0' COMMENT '收藏量',
  `praise_count` int(10) unsigned DEFAULT '0' COMMENT '点赞量',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态：-1：删除，1发布，2下架，3待发布，4草稿，5垃圾箱',
  `on_at` int(10) unsigned DEFAULT '0' COMMENT '发布时间',
  `off_at` int(10) unsigned DEFAULT '0' COMMENT '下架时间',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `uid` (`uid`),
  KEY `cate_ids` (`cate_ids`),
  KEY `tag_ids` (`tag_ids`),
  KEY `keywords` (`keywords`),
  KEY `type` (`type`),
  KEY `hot_real` (`hot_real`),
  KEY `hot_virtual` (`hot_virtual`),
  KEY `visit_count` (`visit_count`),
  KEY `comment_count` (`comment_count`),
  KEY `status` (`status`),
  KEY `on_at` (`on_at`),
  KEY `off_at` (`off_at`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------

-- ----------------------------
-- Table structure for `article_cate`
-- ----------------------------
DROP TABLE IF EXISTS `article_cate`;
CREATE TABLE `article_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `pid` int(10) unsigned DEFAULT '0' COMMENT '父分类id',
  `code` int(2) unsigned NOT NULL COMMENT '类目编号',
  `name` varchar(8) NOT NULL COMMENT '名称',
  `name_en` varchar(50) NOT NULL COMMENT '英文名称',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `desc` varchar(50) DEFAULT NULL COMMENT '描述',
  `article_count` int(10) unsigned DEFAULT '0' COMMENT '文章数量',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1：删除 1：启用 2：停用',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `name_en` (`name_en`),
  KEY `sort` (`sort`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COMMENT='类目表';

-- ----------------------------
-- Records of article_cate
-- ----------------------------
INSERT INTO `article_cate` VALUES ('1', '0', '101', '热点', 'hot news', 'https://layer.layui.com/images/tong.jpg', '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('2', '0', '102', '体育', 'sport', 'https://layer.layui.com/images/tong.jpg', '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('3', '0', '103', '教育', '', null, '7', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('4', '0', '104', '科技', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('5', '0', '105', '娱乐', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('6', '0', '106', '历史', '', null, '8', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('7', '0', '107', '军事', '', null, '6', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('8', '0', '108', '搞笑', '', null, '4', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('9', '0', '109', '教育', '', null, '9', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('10', '0', '110', '旅游', '', null, '5', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('11', '0', '111', '探索', '', null, '10', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('12', '0', '112', '游戏', '', null, '11', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('13', '0', '113', '互联网', '', null, '12', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('14', '0', '114', '美食', '', null, '13', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('15', '0', '115', '职场', '', null, '14', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('16', '0', '116', '财经', '', 'https://layer.layui.com/images/tong.jpg', '15', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('17', '0', '117', '星座', '', 'https://layer.layui.com/images/tong.jpg', '16', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('18', '0', '118', '股票', '', 'https://layer.layui.com/images/tong.jpg', '17', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('19', '0', '119', '汽车', '', null, '18', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('20', '0', '120', '房产', '', null, '19', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('21', '0', '121', '居家', '', null, '20', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('22', '0', '122', '育儿', '', null, '21', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('23', '0', '123', '高考', '', null, '22', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('24', '0', '124', '数码', '', null, '23', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('25', '0', '125', '国际', '', null, '24', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('26', '0', '126', '电影', '', null, '25', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('27', '0', '127', '时尚', '', null, '26', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('28', '0', '128', '出行', '', null, '27', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('29', '0', '129', '生活', '', null, '28', null, '0', '-1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('30', '0', '130', '程序猿', '', null, '29', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('51', '2', '10201', '综合', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('52', '2', '10202', '足球', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('53', '2', '10303', '篮球', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('54', '51', '1020101', '排球', '', null, '6', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('55', '51', '1020102', '乒乓球', '', null, '5', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('56', '51', '1020103', '游泳', '', null, '4', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('57', '51', '1020104', '体操', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('58', '51', '1020105', '网球', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('59', '51', '1020106', '冰雪', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('60', '51', '1020107', '赛车', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('61', '52', '1020201', '中超', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('62', '52', '1020202', '西甲', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('63', '52', '1020203', '英超', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('64', '52', '1020204', '德甲', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('65', '30', '13001', '后端开发', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('66', '30', '13002', '前端开发', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('67', '30', '13003', '数据库', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('68', '30', '13004', '移动端', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('69', '65', '1300101', 'PHP', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('70', '65', '1300102', 'JAVA', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('71', '65', '1300103', 'Python', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('72', '68', '1300401', 'IOS', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('73', '68', '1300402', 'Android', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('74', '67', '1300301', 'MySQL', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `article_cate` VALUES ('75', '67', '1300302', 'Oracle', '', null, '0', null, '0', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for `article_cate_assign`
-- ----------------------------
DROP TABLE IF EXISTS `article_cate_assign`;
CREATE TABLE `article_cate_assign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `article_id` int(10) unsigned NOT NULL COMMENT '管理员id',
  `cate_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：1启用，-1删除',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`article_id`),
  KEY `role_id` (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='文章分类关联表';

-- ----------------------------
-- Records of article_cate_assign
-- ----------------------------
INSERT INTO `article_cate_assign` VALUES ('1', '1', '1', '1');
INSERT INTO `article_cate_assign` VALUES ('2', '1', '2', '1');
INSERT INTO `article_cate_assign` VALUES ('3', '2', '1', '1');
INSERT INTO `article_cate_assign` VALUES ('4', '5', '4', '1');
INSERT INTO `article_cate_assign` VALUES ('5', '11', '1', '1');
INSERT INTO `article_cate_assign` VALUES ('6', '12', '2', '1');
INSERT INTO `article_cate_assign` VALUES ('7', '12', '3', '1');
INSERT INTO `article_cate_assign` VALUES ('8', '13', '2', '1');
INSERT INTO `article_cate_assign` VALUES ('9', '15', '3', '1');
INSERT INTO `article_cate_assign` VALUES ('10', '9', '1', '1');
INSERT INTO `article_cate_assign` VALUES ('11', '16', '3', '1');

-- ----------------------------
-- Table structure for `article_collect`
-- ----------------------------
DROP TABLE IF EXISTS `article_collect`;
CREATE TABLE `article_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `good_id` int(10) unsigned NOT NULL COMMENT '对象id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1 删除 1启用',
  `delete_at` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`good_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

-- ----------------------------
-- Records of article_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `article_content`
-- ----------------------------
DROP TABLE IF EXISTS `article_content`;
CREATE TABLE `article_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `article_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `content` text COMMENT '文章内容',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章详情表';

-- ----------------------------
-- Records of article_content
-- ----------------------------
INSERT INTO `article_content` VALUES ('1', '2', '<p>dsadasda</p>');

-- ----------------------------
-- Table structure for `article_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `article_recommend`;
CREATE TABLE `article_recommend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '推荐类型 1:置顶 2:最热 3:精 4:今日推荐',
  `article_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `on_at` int(10) unsigned DEFAULT '0' COMMENT '发布时间',
  `off_at` int(10) unsigned DEFAULT '0' COMMENT '下架时间',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态：-1：删除，1发布，2下架，3待发布',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `on_at` (`on_at`),
  KEY `off_at` (`off_at`),
  KEY `sort` (`sort`),
  KEY `status` (`status`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章推荐设置表';

-- ----------------------------
-- Records of article_recommend
-- ----------------------------

-- ----------------------------
-- Table structure for `good`
-- ----------------------------
DROP TABLE IF EXISTS `good`;
CREATE TABLE `good` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `code` int(10) unsigned NOT NULL COMMENT '商品编号',
  `name` varchar(150) NOT NULL COMMENT '商品名称',
  `remark` varchar(150) NOT NULL COMMENT '商品备注',
  `use_coupons` tinyint(2) unsigned DEFAULT '1' COMMENT '是否可用优惠券 1:是 2:否',
  `jifen_price` int(2) unsigned DEFAULT '0' COMMENT '积分价',
  `jifen_buy` tinyint(2) unsigned DEFAULT '2' COMMENT '积分购买 1:可以 2:不可以',
  `jifen` int(10) DEFAULT '0' COMMENT '商品积分 0:按系统设置 -1 没有积分',
  `shipping_total` int(10) DEFAULT '0' COMMENT '商品运费 0:按系统设置 -1 免运费',
  `visit_count` int(10) unsigned DEFAULT '0' COMMENT '浏览数量',
  `visit_count_xn` int(10) unsigned DEFAULT '0' COMMENT '虚拟浏览数量',
  `sale_count` int(10) unsigned DEFAULT '0' COMMENT '售卖数量',
  `sale_count_xn` int(10) unsigned DEFAULT '0' COMMENT '虚拟售卖数量',
  `collect_count` int(10) unsigned DEFAULT '0' COMMENT '收藏数量',
  `collect_count_xn` int(10) unsigned DEFAULT '0' COMMENT '虚拟收藏数量',
  `hot_weight` int(10) unsigned DEFAULT '0' COMMENT '最热值',
  `hot_weight_xn` int(10) unsigned DEFAULT '0' COMMENT '虚拟最热值',
  `is_new` tinyint(2) unsigned DEFAULT '2' COMMENT '新品 1:是 2:否',
  `is_new_yxq` varchar(21) DEFAULT '0' COMMENT '新品有效期',
  `status` tinyint(2) DEFAULT '6' COMMENT '状态 -2:回收站 -1:删除 1:上架 2:下架 3:待上架 4:无货 5:进货中 6:草稿',
  `auto_onoff` tinyint(2) DEFAULT '1' COMMENT '自动上下架 1:开启 2:关闭',
  `on_at` int(10) DEFAULT '0' COMMENT '上架时间',
  `off_at` int(10) DEFAULT '0' COMMENT '下架时间',
  `delete_at` int(10) DEFAULT '0' COMMENT '删除时间',
  `detail_attr` text COMMENT '商品属性描述',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `use_coupons` (`use_coupons`),
  KEY `jifen_price` (`jifen_price`),
  KEY `jifen_buy` (`jifen_buy`),
  KEY `jifen` (`jifen`),
  KEY `shipping_total` (`shipping_total`),
  KEY `visit_count` (`visit_count`),
  KEY `visit_count_xn` (`visit_count_xn`),
  KEY `sale_count` (`sale_count`),
  KEY `sale_count_xn` (`sale_count_xn`),
  KEY `collect_count` (`collect_count`),
  KEY `collect_count_xn` (`collect_count_xn`),
  KEY `hot_weight` (`hot_weight`),
  KEY `hot_weight_xn` (`hot_weight_xn`),
  KEY `is_new` (`is_new`),
  KEY `is_new_yxq` (`is_new_yxq`),
  KEY `status` (`status`),
  KEY `auto_onoff` (`auto_onoff`),
  KEY `on_at` (`on_at`),
  KEY `off_at` (`off_at`),
  KEY `delete_at` (`delete_at`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of good
-- ----------------------------

-- ----------------------------
-- Table structure for `good_cate`
-- ----------------------------
DROP TABLE IF EXISTS `good_cate`;
CREATE TABLE `good_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `pid` int(10) unsigned DEFAULT '0' COMMENT '父分类id',
  `code` int(2) unsigned NOT NULL COMMENT '类目编号',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `name_en` varchar(50) NOT NULL COMMENT '英文名称',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `desc` varchar(50) DEFAULT NULL COMMENT '描述',
  `good_count` int(10) unsigned DEFAULT '0' COMMENT '商品数量',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1：删除 1：启用 2：停用',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `name_en` (`name_en`),
  KEY `sort` (`sort`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COMMENT='商品类目表';

-- ----------------------------
-- Records of good_cate
-- ----------------------------
INSERT INTO `good_cate` VALUES ('1', '0', '201', '手机/数码/配件', 'hot news', 'https://layer.layui.com/images/tong.jpg', '0', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('2', '0', '202', '电脑/办公/外设', 'sport', 'https://layer.layui.com/images/tong.jpg', '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('3', '0', '203', '厨卫电器/生活电器', '', null, '7', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('4', '0', '204', '大家电', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('5', '0', '205', '家居/日用/厨具', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('6', '0', '206', '服装鞋帽配饰', '', null, '8', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('7', '0', '207', '家具/家装/建材', '', null, '6', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('8', '0', '208', '美妆/个护清洁', '', null, '4', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('9', '0', '209', '运动/户外', '', null, '9', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('10', '0', '210', '钟表/礼品/乐器', '', null, '5', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('11', '0', '211', '箱包/珠宝/钟表', '', null, '10', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('12', '0', '212', '酒水/食品/特产', '', null, '11', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('13', '0', '213', '汽车用品', '', null, '12', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('14', '0', '214', '母婴/玩具', '', null, '13', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('15', '0', '215', '图书/音像/电子书', '', null, '14', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('16', '0', '216', '医药保健/计生情趣', '', 'https://layer.layui.com/images/tong.jpg', '15', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('17', '0', '117', '星座', '', 'https://layer.layui.com/images/tong.jpg', '16', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('18', '0', '118', '股票', '', 'https://layer.layui.com/images/tong.jpg', '17', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('19', '0', '119', '汽车', '', null, '18', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('20', '0', '120', '房产', '', null, '19', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('21', '0', '121', '居家', '', null, '20', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('22', '0', '122', '育儿', '', null, '21', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('23', '0', '123', '高考', '', null, '22', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('24', '0', '124', '数码', '', null, '23', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('25', '0', '125', '国际', '', null, '24', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('26', '0', '126', '电影', '', null, '25', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('27', '0', '127', '时尚', '', null, '26', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('28', '0', '128', '出行', '', null, '27', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('29', '0', '129', '生活', '', null, '28', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('30', '0', '130', '程序猿', '', null, '29', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('51', '2', '10201', '综合', '', null, '0', null, '0', '-1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('52', '2', '10202', '足球', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('53', '2', '10303', '篮球', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('54', '51', '1020101', '排球', '', null, '6', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('55', '51', '1020102', '乒乓球', '', null, '5', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('56', '51', '1020103', '游泳', '', null, '4', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('57', '51', '1020104', '体操', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('58', '51', '1020105', '网球', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('59', '51', '1020106', '冰雪', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('60', '51', '1020107', '赛车', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('61', '52', '1020201', '中超', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('62', '52', '1020202', '西甲', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('63', '52', '1020203', '英超', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('64', '52', '1020204', '德甲', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('65', '30', '13001', '后端开发', '', null, '3', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('66', '30', '13002', '前端开发', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('67', '30', '13003', '数据库', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('68', '30', '13004', '移动端', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('69', '65', '1300101', 'PHP', '', null, '2', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('70', '65', '1300102', 'JAVA', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('71', '65', '1300103', 'Python', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('72', '68', '1300401', 'IOS', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('73', '68', '1300402', 'Android', '', null, '0', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('74', '67', '1300301', 'MySQL', '', null, '1', null, '0', '1', '0', '0', '0');
INSERT INTO `good_cate` VALUES ('75', '67', '1300302', 'Oracle', '', null, '0', null, '0', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for `good_collect`
-- ----------------------------
DROP TABLE IF EXISTS `good_collect`;
CREATE TABLE `good_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `good_id` int(10) unsigned NOT NULL COMMENT '对象id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1 删除 1启用',
  `delete_at` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`good_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

-- ----------------------------
-- Records of good_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `good_detail`
-- ----------------------------
DROP TABLE IF EXISTS `good_detail`;
CREATE TABLE `good_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `good_id` int(10) unsigned DEFAULT '0' COMMENT '商品ID',
  `title` varchar(20) NOT NULL COMMENT '详情名称',
  `content` text COMMENT '内容',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态 -1:删除 1:显示 2:不显示',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`),
  KEY `status` (`status`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品详情表';

-- ----------------------------
-- Records of good_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `good_order`
-- ----------------------------
DROP TABLE IF EXISTS `good_order`;
CREATE TABLE `good_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `code` int(10) unsigned NOT NULL COMMENT '订单编号',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `recipient_id` int(10) unsigned DEFAULT NULL COMMENT '用户收货信息ID',
  `title` varchar(150) DEFAULT NULL COMMENT '订单名称',
  `serial_no` varchar(30) DEFAULT NULL COMMENT '流水号',
  `total` int(10) unsigned NOT NULL COMMENT '订单总金额',
  `activity_id` int(10) unsigned DEFAULT '0' COMMENT '活动ID',
  `activity_info` varchar(150) DEFAULT NULL COMMENT '活动信息',
  `activity_total` int(10) unsigned DEFAULT '0' COMMENT '活动减免金额',
  `coupon_id` int(10) unsigned DEFAULT '0' COMMENT '优惠券ID',
  `coupon_info` varchar(150) DEFAULT NULL COMMENT '优惠券信息',
  `coupon_total` int(10) unsigned DEFAULT '0' COMMENT '优惠券减免金额',
  `shipping_total` int(10) unsigned DEFAULT '0' COMMENT '订单运费',
  `sys_reduce` int(10) unsigned DEFAULT '0' COMMENT '系统减免金额',
  `sys_reduce_reason` varchar(150) DEFAULT NULL COMMENT '减免原因',
  `sys_reduce_at` int(10) unsigned DEFAULT '0' COMMENT '减免时间',
  `pay_total` int(10) unsigned NOT NULL COMMENT '订单实际支付金额',
  `remark` varchar(300) DEFAULT NULL COMMENT '订单备注',
  `pay_type` tinyint(2) unsigned DEFAULT '1' COMMENT '支付类型 1:微信 2:支付宝 3:其它',
  `delete_status` tinyint(2) unsigned DEFAULT '0' COMMENT '1:用户删除 2:系统删除',
  `status` tinyint(2) unsigned DEFAULT '2' COMMENT '状态 1:已完成 2:待支付 3:待发货 4:已发货 5:已退货 6:交易关闭 7:后台取消 8:用户取消',
  `sys_cancel_at` int(10) unsigned DEFAULT '0' COMMENT '系统取消时间',
  `sys_cancel_reason` varchar(150) DEFAULT NULL COMMENT '取消原因',
  `user_cancel_at` int(10) unsigned DEFAULT '0' COMMENT '用户取消时间',
  `pay_at` int(10) unsigned DEFAULT '0' COMMENT '支付时间',
  `delete1_at` int(10) unsigned DEFAULT '0' COMMENT '删除时间',
  `delete2_at` int(10) unsigned DEFAULT '0' COMMENT '删除时间',
  `send_at` int(10) unsigned DEFAULT '0' COMMENT '发货时间',
  `refund_info` varchar(150) DEFAULT NULL COMMENT '退款信息',
  `refund_total` int(10) unsigned DEFAULT '0' COMMENT '退款金额',
  `refund_at` int(10) unsigned DEFAULT '0' COMMENT '退货时间',
  `refund_reason` varchar(150) DEFAULT NULL COMMENT '退货原因',
  `refund_serial_no` varchar(60) DEFAULT NULL COMMENT '退款流水号',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作人ID',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `uid` (`uid`),
  KEY `recipient_id` (`recipient_id`),
  KEY `serial_no` (`serial_no`),
  KEY `total` (`total`),
  KEY `activity_id` (`activity_id`),
  KEY `activity_total` (`activity_total`),
  KEY `coupon_id` (`coupon_id`),
  KEY `coupon_total` (`coupon_total`),
  KEY `shipping_total` (`shipping_total`),
  KEY `sys_reduce` (`sys_reduce`),
  KEY `pay_total` (`pay_total`),
  KEY `pay_type` (`pay_type`),
  KEY `delete_status` (`delete_status`),
  KEY `status` (`status`),
  KEY `pay_at` (`pay_at`),
  KEY `delete1_at` (`delete1_at`),
  KEY `delete2_at` (`delete2_at`),
  KEY `send_at` (`send_at`),
  KEY `refund_total` (`refund_total`),
  KEY `refund_at` (`refund_at`),
  KEY `refund_serial_no` (`refund_serial_no`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of good_order
-- ----------------------------

-- ----------------------------
-- Table structure for `good_order_detail`
-- ----------------------------
DROP TABLE IF EXISTS `good_order_detail`;
CREATE TABLE `good_order_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `good_id` int(10) unsigned NOT NULL COMMENT '订单对象ID',
  `amount` smallint(5) unsigned NOT NULL COMMENT '对象数量',
  `send_amount` smallint(5) unsigned NOT NULL COMMENT '对象发货数量',
  `total` int(10) unsigned DEFAULT NULL COMMENT '总价',
  `activity_id` int(10) unsigned DEFAULT '0' COMMENT '活动ID',
  `activity_info` varchar(150) DEFAULT NULL COMMENT '活动信息',
  `activity_total` int(10) unsigned DEFAULT '0' COMMENT '活动减免金额',
  `coupon_id` int(10) unsigned DEFAULT '0' COMMENT '优惠券ID',
  `coupon_info` varchar(150) DEFAULT NULL COMMENT '优惠券信息',
  `coupon_total` int(10) unsigned DEFAULT '0' COMMENT '优惠券减免金额',
  `pay_total` int(10) unsigned NOT NULL COMMENT '实际支付金额',
  `is_gift` tinyint(2) unsigned DEFAULT '2' COMMENT '赠品 1:是 2:否',
  `refund_info` varchar(150) DEFAULT NULL COMMENT '退款信息',
  `refund_total` int(10) unsigned DEFAULT '0' COMMENT '退款金额',
  `status` tinyint(2) unsigned DEFAULT '2' COMMENT '状态 -1:删除 1:正常',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作人ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `obj_id` (`good_id`),
  KEY `amount` (`amount`),
  KEY `send_amount` (`send_amount`),
  KEY `total` (`total`),
  KEY `activity_id` (`activity_id`),
  KEY `activity_total` (`activity_total`),
  KEY `coupon_id` (`coupon_id`),
  KEY `coupon_total` (`coupon_total`),
  KEY `pay_total` (`pay_total`),
  KEY `is_gift` (`is_gift`),
  KEY `refund_total` (`refund_total`),
  KEY `status` (`status`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单产品表';

-- ----------------------------
-- Records of good_order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `good_praise`
-- ----------------------------
DROP TABLE IF EXISTS `good_praise`;
CREATE TABLE `good_praise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `good_id` int(10) unsigned NOT NULL COMMENT '对象id',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`good_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品点赞表';

-- ----------------------------
-- Records of good_praise
-- ----------------------------

-- ----------------------------
-- Table structure for `good_visit`
-- ----------------------------
DROP TABLE IF EXISTS `good_visit`;
CREATE TABLE `good_visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `good_id` int(10) unsigned NOT NULL COMMENT '对象id',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`good_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户浏览记录表';

-- ----------------------------
-- Records of good_visit
-- ----------------------------

-- ----------------------------
-- Table structure for `hot_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `hot_keyword`;
CREATE TABLE `hot_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型 1文章',
  `name` varchar(10) NOT NULL COMMENT '名称',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) unsigned DEFAULT '2' COMMENT '状态：-1删除 1使用 2停用',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sort` (`sort`),
  KEY `status` (`status`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='热门搜索词表';

-- ----------------------------
-- Records of hot_keyword
-- ----------------------------

-- ----------------------------
-- Table structure for `hot_keyword_copy`
-- ----------------------------
DROP TABLE IF EXISTS `hot_keyword_copy`;
CREATE TABLE `hot_keyword_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型 1文章',
  `name` varchar(10) NOT NULL COMMENT '名称',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) unsigned DEFAULT '2' COMMENT '状态：-1删除 1使用 2停用',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sort` (`sort`),
  KEY `status` (`status`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='热门搜索词表';

-- ----------------------------
-- Records of hot_keyword_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `log_user_balance`
-- ----------------------------
DROP TABLE IF EXISTS `log_user_balance`;
CREATE TABLE `log_user_balance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `desc` varchar(200) DEFAULT NULL COMMENT '收支备注',
  `total` int(10) NOT NULL COMMENT '金额',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型 1:购买商品 2:充值 3:提现',
  `balance` int(10) unsigned DEFAULT '0' COMMENT '余额',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `total` (`total`),
  KEY `type` (`type`),
  KEY `balance` (`balance`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户收支表';

-- ----------------------------
-- Records of log_user_balance
-- ----------------------------

-- ----------------------------
-- Table structure for `log_user_jifen`
-- ----------------------------
DROP TABLE IF EXISTS `log_user_jifen`;
CREATE TABLE `log_user_jifen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `rule_id` smallint(5) unsigned DEFAULT '0' COMMENT '积分事件ID',
  `total` int(10) NOT NULL COMMENT '积分值',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `rule_id` (`rule_id`),
  KEY `total` (`total`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分日志表';

-- ----------------------------
-- Records of log_user_jifen
-- ----------------------------

-- ----------------------------
-- Table structure for `log_user_login`
-- ----------------------------
DROP TABLE IF EXISTS `log_user_login`;
CREATE TABLE `log_user_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `login_at` int(10) unsigned NOT NULL COMMENT '登录时间',
  `logout_at` int(10) unsigned DEFAULT NULL COMMENT '退出登录时间',
  `platform` tinyint(2) unsigned DEFAULT '1' COMMENT '登录平台1：PC 2：H5 3：小程序',
  `ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `login_at` (`login_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志表';

-- ----------------------------
-- Records of log_user_login
-- ----------------------------

-- ----------------------------
-- Table structure for `log_user_login_copy`
-- ----------------------------
DROP TABLE IF EXISTS `log_user_login_copy`;
CREATE TABLE `log_user_login_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `login_at` int(10) unsigned NOT NULL COMMENT '登录时间',
  `logout_at` int(10) unsigned DEFAULT NULL COMMENT '退出登录时间',
  `platform` tinyint(2) unsigned DEFAULT '1' COMMENT '登录平台1：PC 2：H5 3：小程序',
  `ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `login_at` (`login_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志表';

-- ----------------------------
-- Records of log_user_login_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `log_verify_code`
-- ----------------------------
DROP TABLE IF EXISTS `log_verify_code`;
CREATE TABLE `log_verify_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型：1手机 2邮箱',
  `account` varchar(50) NOT NULL COMMENT '手机号或邮箱',
  `verify_code` smallint(6) unsigned NOT NULL COMMENT '验证码',
  `expire_at` int(10) unsigned DEFAULT NULL COMMENT '过期时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `verify_code` (`verify_code`),
  KEY `expire_at` (`expire_at`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码表';

-- ----------------------------
-- Records of log_verify_code
-- ----------------------------

-- ----------------------------
-- Table structure for `material`
-- ----------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cate_id` tinyint(10) unsigned DEFAULT '0' COMMENT '类目ID',
  `url` varchar(255) NOT NULL COMMENT '地址',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-2 彻底删除 -1：删除 1：启用',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='素材库表';

-- ----------------------------
-- Records of material
-- ----------------------------

-- ----------------------------
-- Table structure for `material_copy`
-- ----------------------------
DROP TABLE IF EXISTS `material_copy`;
CREATE TABLE `material_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cate_id` tinyint(10) unsigned DEFAULT '0' COMMENT '类目ID',
  `url` varchar(255) NOT NULL COMMENT '地址',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-2 彻底删除 -1：删除 1：启用',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='素材库表';

-- ----------------------------
-- Records of material_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `poster`
-- ----------------------------
DROP TABLE IF EXISTS `poster`;
CREATE TABLE `poster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `position` tinyint(2) unsigned DEFAULT '1' COMMENT '1文章首页轮播 2文章首页轮播右侧',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `img` varchar(255) NOT NULL COMMENT '图片',
  `on_at` int(10) unsigned DEFAULT NULL COMMENT '上架时间',
  `off_at` int(10) unsigned DEFAULT NULL COMMENT '下架时间',
  `detail` varchar(255) NOT NULL COMMENT '广告内容',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型：1：文章ID 2：html页面',
  `show_platform` tinyint(2) unsigned DEFAULT '1' COMMENT '显示平台：1：PC 2：H5 3：小程序',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态：-1：删除 1：发布 2：待发布',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `title` (`title`),
  KEY `on_at` (`on_at`),
  KEY `off_at` (`off_at`),
  KEY `sort` (`sort`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of poster
-- ----------------------------

-- ----------------------------
-- Table structure for `poster_copy`
-- ----------------------------
DROP TABLE IF EXISTS `poster_copy`;
CREATE TABLE `poster_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `position` tinyint(2) unsigned DEFAULT '1' COMMENT '1文章首页轮播 2文章首页轮播右侧',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `img` varchar(255) NOT NULL COMMENT '图片',
  `on_at` int(10) unsigned DEFAULT NULL COMMENT '上架时间',
  `off_at` int(10) unsigned DEFAULT NULL COMMENT '下架时间',
  `detail` varchar(255) NOT NULL COMMENT '广告内容',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型：1：文章ID 2：html页面',
  `show_platform` tinyint(2) unsigned DEFAULT '1' COMMENT '显示平台：1：PC 2：H5 3：小程序',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态：-1：删除 1：发布 2：待发布',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `title` (`title`),
  KEY `on_at` (`on_at`),
  KEY `off_at` (`off_at`),
  KEY `sort` (`sort`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of poster_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `praise`
-- ----------------------------
DROP TABLE IF EXISTS `praise`;
CREATE TABLE `praise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '1文章',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `obj_id` int(10) unsigned NOT NULL COMMENT '对象id',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户点赞表';

-- ----------------------------
-- Records of praise
-- ----------------------------


-- ----------------------------
-- Table structure for `search`
-- ----------------------------
DROP TABLE IF EXISTS `search`;
CREATE TABLE `search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型 1文章',
  `uid` int(10) unsigned DEFAULT NULL COMMENT '用户id',
  `name` varchar(100) NOT NULL COMMENT '搜索内容',
  `status` tinyint(2) unsigned DEFAULT '2' COMMENT '状态：-1删除 1使用',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `name` (`name`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户搜索记录表';

-- ----------------------------
-- Records of search
-- ----------------------------

-- ----------------------------
-- Table structure for `search_copy`
-- ----------------------------
DROP TABLE IF EXISTS `search_copy`;
CREATE TABLE `search_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型 1文章',
  `uid` int(10) unsigned DEFAULT NULL COMMENT '用户id',
  `name` varchar(100) NOT NULL COMMENT '搜索内容',
  `status` tinyint(2) unsigned DEFAULT '2' COMMENT '状态：-1删除 1使用',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `name` (`name`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户搜索记录表';

-- ----------------------------
-- Records of search_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `tag`
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类目类型 1：文章',
  `name` varchar(8) NOT NULL COMMENT '名称',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否可选：1是 2否',
  `sort_show` int(10) unsigned DEFAULT '0' COMMENT '选择排序',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1删除 1启用 2停用',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `name` (`name`),
  KEY `sort_show` (`sort_show`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签表';

-- ----------------------------
-- Records of tag
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `account` varchar(60) NOT NULL COMMENT '账号',
  `unionid` varchar(255) DEFAULT NULL COMMENT '微信unionid',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `nickname` varchar(30) DEFAULT NULL COMMENT '昵称',
  `jifen` int(10) unsigned DEFAULT '0' COMMENT '积分值',
  `balance` int(10) unsigned DEFAULT '0' COMMENT '余额',
  `passwd` varchar(60) DEFAULT NULL COMMENT '密码',
  `passwd_pay` varchar(60) DEFAULT NULL COMMENT '支付密码',
  `head_img` varchar(255) DEFAULT NULL COMMENT '头像地址',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1删除 1启用 2冻结 3禁止评论 4禁止发布文章',
  `last_login_at` int(10) unsigned DEFAULT '0' COMMENT '最后登录时间',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `unionid` (`unionid`),
  KEY `mobile` (`mobile`),
  KEY `email` (`email`),
  KEY `nickname` (`nickname`),
  KEY `jifen` (`jifen`),
  KEY `balance` (`balance`),
  KEY `last_login_at` (`last_login_at`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `user_address`
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `tag` varchar(10) DEFAULT NULL COMMENT '标签',
  `reciver` varchar(30) NOT NULL COMMENT '收货人',
  `phone` varchar(15) NOT NULL COMMENT '手机号',
  `province` int(10) unsigned NOT NULL COMMENT '省',
  `province_name` varchar(20) NOT NULL COMMENT '省',
  `city` int(10) unsigned NOT NULL COMMENT '市',
  `city_name` varchar(20) NOT NULL COMMENT '市',
  `county` int(10) unsigned NOT NULL COMMENT '县区',
  `county_name` varchar(20) NOT NULL COMMENT '县区',
  `town` int(10) unsigned NOT NULL COMMENT '街道',
  `town_name` varchar(20) NOT NULL COMMENT '街道',
  `post_code` int(10) unsigned NOT NULL COMMENT '邮编',
  `area` varchar(100) NOT NULL COMMENT '详细地址',
  `is_default` tinyint(2) unsigned DEFAULT '1' COMMENT '默认 1:是 2:否',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态 -1:删除 1:正常',
  `delete_at` int(10) unsigned DEFAULT '0' COMMENT '删除时间',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `tag` (`tag`),
  KEY `province` (`province`),
  KEY `city` (`city`),
  KEY `county` (`county`),
  KEY `town` (`town`),
  KEY `is_default` (`is_default`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收货地址信息表';

-- ----------------------------
-- Records of user_address
-- ----------------------------

-- ----------------------------
-- Table structure for `user_address_tag`
-- ----------------------------
DROP TABLE IF EXISTS `user_address_tag`;
CREATE TABLE `user_address_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(8) NOT NULL COMMENT '名称',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '选择排序',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态：-1删除 1启用 2停用',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '操作员ID',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sort_show` (`sort`),
  KEY `admin_id` (`admin_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签表';

-- ----------------------------
-- Records of user_address_tag
-- ----------------------------

-- ----------------------------
-- Table structure for `user_cart`
-- ----------------------------
DROP TABLE IF EXISTS `user_cart`;
CREATE TABLE `user_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `obj_id` int(10) unsigned NOT NULL COMMENT '对象ID',
  `type` tinyint(2) unsigned DEFAULT '0' COMMENT '类型 1:商品',
  `amount` int(10) unsigned DEFAULT '0' COMMENT '数量',
  `total` int(10) unsigned DEFAULT '0' COMMENT '总价',
  `status` tinyint(2) DEFAULT '2' COMMENT '状态 -1:删除 1:已结算 2:待结算',
  `delete_at` int(10) unsigned DEFAULT '0' COMMENT '删除时间',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`obj_id`),
  KEY `type` (`type`),
  KEY `amount` (`amount`),
  KEY `total` (`total`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户购物车表';

-- ----------------------------
-- Records of user_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `nickname_wx` varchar(255) DEFAULT NULL COMMENT '微信昵称',
  `head_img_wx` varchar(255) DEFAULT NULL COMMENT '微信头像',
  `openid_h5` varchar(255) DEFAULT NULL COMMENT '微信H5openid',
  `openid_xcx` varchar(255) DEFAULT NULL COMMENT '微信小程序openid',
  `mobile_id` varchar(255) DEFAULT NULL COMMENT '手机ID',
  `latitude` varchar(20) DEFAULT NULL COMMENT '经纬度',
  `birth` int(10) unsigned DEFAULT NULL COMMENT '生日',
  `gender` tinyint(2) unsigned DEFAULT '1' COMMENT '性别 1：男 2：女',
  `desc` varchar(500) DEFAULT NULL COMMENT '自我介绍',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `register_type` tinyint(2) unsigned DEFAULT '1' COMMENT '注册类型 1手机号 2邮箱 3微信 4QQ 5微博',
  `register_platform` tinyint(2) unsigned DEFAULT '1' COMMENT '注册平台 1PC 2公众号 3APP 4微信小程序',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息表';

-- ----------------------------
-- Records of user_info
-- ----------------------------

-- ----------------------------
-- Table structure for `verify_code`
-- ----------------------------
DROP TABLE IF EXISTS `verify_code`;
CREATE TABLE `verify_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '类型：1手机 2邮箱',
  `account` varchar(50) NOT NULL COMMENT '手机号或邮箱',
  `verify_code` smallint(6) unsigned NOT NULL COMMENT '验证码',
  `expire_at` int(10) unsigned DEFAULT NULL COMMENT '过期时间',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `verify_code` (`verify_code`),
  KEY `expire_at` (`expire_at`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码表';

-- ----------------------------
-- Records of verify_code
-- ----------------------------

-- ----------------------------
-- Table structure for `visit`
-- ----------------------------
DROP TABLE IF EXISTS `visit`;
CREATE TABLE `visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(2) unsigned DEFAULT '1' COMMENT '1文章',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `obj_id` int(10) unsigned NOT NULL COMMENT '对象id',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户浏览记录表';

-- ----------------------------
-- Records of visit
-- ----------------------------