-- ----------------------------
-- Table structure for `area_province`
-- ----------------------------
DROP TABLE IF EXISTS `area_province`;
CREATE TABLE `area_province` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `pid` tinyint(3) unsigned NOT NULL COMMENT '上级地区ID',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=Mysiam DEFAULT CHARSET=utf8 COMMENT='省';

-- ----------------------------
-- Records of area_province
-- ----------------------------
INSERT INTO `area_province` VALUES ('11', '北京市', '0');
INSERT INTO `area_province` VALUES ('12', '天津市', '0');
INSERT INTO `area_province` VALUES ('13', '河北省', '0');
INSERT INTO `area_province` VALUES ('14', '山西省', '0');
INSERT INTO `area_province` VALUES ('15', '内蒙古自治区', '0');
INSERT INTO `area_province` VALUES ('21', '辽宁省', '0');
INSERT INTO `area_province` VALUES ('22', '吉林省', '0');
INSERT INTO `area_province` VALUES ('23', '黑龙江省', '0');
INSERT INTO `area_province` VALUES ('31', '上海市', '0');
INSERT INTO `area_province` VALUES ('32', '江苏省', '0');
INSERT INTO `area_province` VALUES ('33', '浙江省', '0');
INSERT INTO `area_province` VALUES ('34', '安徽省', '0');
INSERT INTO `area_province` VALUES ('35', '福建省', '0');
INSERT INTO `area_province` VALUES ('36', '江西省', '0');
INSERT INTO `area_province` VALUES ('37', '山东省', '0');
INSERT INTO `area_province` VALUES ('41', '河南省', '0');
INSERT INTO `area_province` VALUES ('42', '湖北省', '0');
INSERT INTO `area_province` VALUES ('43', '湖南省', '0');
INSERT INTO `area_province` VALUES ('44', '广东省', '0');
INSERT INTO `area_province` VALUES ('45', '广西壮族自治区', '0');
INSERT INTO `area_province` VALUES ('46', '海南省', '0');
INSERT INTO `area_province` VALUES ('50', '重庆市', '0');
INSERT INTO `area_province` VALUES ('51', '四川省', '0');
INSERT INTO `area_province` VALUES ('52', '贵州省', '0');
INSERT INTO `area_province` VALUES ('53', '云南省', '0');
INSERT INTO `area_province` VALUES ('54', '西藏自治区', '0');
INSERT INTO `area_province` VALUES ('61', '陕西省', '0');
INSERT INTO `area_province` VALUES ('62', '甘肃省', '0');
INSERT INTO `area_province` VALUES ('63', '青海省', '0');
INSERT INTO `area_province` VALUES ('64', '宁夏回族自治区', '0');
INSERT INTO `area_province` VALUES ('65', '新疆维吾尔自治区', '0');