-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 05 月 16 日 10:19
-- 服务器版本: 5.1.36
-- PHP 版本: 5.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `e7_wofeng`
--

-- --------------------------------------------------------

--
-- 表的结构 `acm_func2role`
--

CREATE TABLE IF NOT EXISTS `acm_func2role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menuId` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '对应菜单定义文件中的id',
  `roleId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FuncId` (`menuId`),
  KEY `RoleId` (`roleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_func2role`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_funcdb`
--

CREATE TABLE IF NOT EXISTS `acm_funcdb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(10) NOT NULL DEFAULT '0',
  `funcName` varchar(20) COLLATE utf8_bin NOT NULL,
  `leftId` int(10) NOT NULL DEFAULT '0',
  `rightId` int(10) NOT NULL DEFAULT '0',
  `usedByStandard` tinyint(1) NOT NULL DEFAULT '1' COMMENT '标准本是否可用',
  `usedByJingji` tinyint(1) NOT NULL DEFAULT '1' COMMENT '经济版是否可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_funcdb`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_roledb`
--

CREATE TABLE IF NOT EXISTS `acm_roledb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `GroupName` (`roleName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_roledb`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_sninfo`
--

CREATE TABLE IF NOT EXISTS `acm_sninfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL,
  `sninfo` varchar(1000) NOT NULL,
  `userId` int(10) NOT NULL COMMENT '用户名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='动态密码卡信息' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_sninfo`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_user2message`
--

CREATE TABLE IF NOT EXISTS `acm_user2message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT '用户Id',
  `messageId` int(10) NOT NULL COMMENT '通知Id',
  `kind` int(1) NOT NULL DEFAULT '0' COMMENT '0表示查看信息，1表示弹出窗但未查看信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户查看通知表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `acm_user2message`
--

INSERT INTO `acm_user2message` (`id`, `userId`, `messageId`, `kind`) VALUES
(1, 1, 1, 0),
(2, 14, 1, 1),
(3, 1, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `acm_user2role`
--

CREATE TABLE IF NOT EXISTS `acm_user2role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL DEFAULT '0',
  `roleId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserId` (`userId`,`roleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_user2role`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_user2trader`
--

CREATE TABLE IF NOT EXISTS `acm_user2trader` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL DEFAULT '0',
  `traderId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserId` (`userId`,`traderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_user2trader`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_userdb`
--

CREATE TABLE IF NOT EXISTS `acm_userdb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userName` varchar(10) COLLATE utf8_bin NOT NULL,
  `realName` varchar(10) COLLATE utf8_bin NOT NULL,
  `shenfenzheng` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '身份证号',
  `passwd` varchar(10) COLLATE utf8_bin NOT NULL,
  `lastLoginTime` date NOT NULL COMMENT '最后一次登录日期',
  `loginCnt` int(10) NOT NULL COMMENT '当前日登录次数',
  `sn` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '动态密码卡sn',
  `snInfo` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '动态密码的字符串',
  PRIMARY KEY (`id`),
  KEY `UserId` (`userName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `acm_userdb`
--

INSERT INTO `acm_userdb` (`id`, `userName`, `realName`, `shenfenzheng`, `passwd`, `lastLoginTime`, `loginCnt`, `sn`, `snInfo`) VALUES
(1, 'admin', '管理员', '', 'admin', '2014-04-04', 4, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_fapiao`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_fapiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '台头',
  `fapiaoHead` varchar(20) COLLATE utf8_bin NOT NULL,
  `fapiaoCode` varchar(20) COLLATE utf8_bin NOT NULL,
  `clientId` int(11) NOT NULL COMMENT '客户Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '客户发票抬头',
  `fukuanFangshi` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '付款方式',
  `money` decimal(20,2) NOT NULL DEFAULT '0.00',
  `huilv` decimal(10,4) NOT NULL DEFAULT '1.0000' COMMENT '开票汇率',
  `bizhong` varchar(20) COLLATE utf8_bin NOT NULL,
  `fapiaoDate` date NOT NULL DEFAULT '0000-00-00',
  `memo` text COLLATE utf8_bin NOT NULL,
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `yixiangId` (`clientId`),
  KEY `fapiaoCode` (`fapiaoCode`),
  KEY `head` (`head`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='开票表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `caiwu_ar_fapiao`
--

INSERT INTO `caiwu_ar_fapiao` (`id`, `head`, `fapiaoHead`, `fapiaoCode`, `clientId`, `taitou`, `fukuanFangshi`, `money`, `huilv`, `bizhong`, `fapiaoDate`, `memo`, `creater`, `dt`) VALUES
(1, '', '', 'P001', 2, '', '', 500.00, 1.0000, 'RMB', '2014-05-15', 0x73616661736466, '管理员', '2014-05-15 09:34:34');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_guozhang`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_guozhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `ord2proId` int(11) NOT NULL,
  `chukuId` int(10) NOT NULL COMMENT '出库id,原料或成品出库',
  `chuku2proId` int(10) NOT NULL,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '区别原料与成品出库',
  `productId` int(10) NOT NULL,
  `cnt` decimal(10,2) NOT NULL,
  `unit` char(20) COLLATE utf8_bin NOT NULL,
  `danjia` decimal(10,2) NOT NULL,
  `bizhong` char(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `huilv` decimal(10,4) NOT NULL COMMENT '汇率',
  `guozhangDate` date NOT NULL,
  `clientId` int(11) NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `chukuDate` date NOT NULL COMMENT '出库日期',
  `qitaMemo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '其他描述',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `ord2proId` (`ord2proId`),
  KEY `orderId` (`orderId`),
  KEY `guozhangDate` (`guozhangDate`),
  KEY `yixiangId` (`clientId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='发货入账表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `caiwu_ar_guozhang`
--

INSERT INTO `caiwu_ar_guozhang` (`id`, `orderId`, `ord2proId`, `chukuId`, `chuku2proId`, `kind`, `productId`, `cnt`, `unit`, `danjia`, `bizhong`, `huilv`, `guozhangDate`, `clientId`, `money`, `memo`, `chukuDate`, `qitaMemo`, `creater`, `dt`) VALUES
(6, 1, 1, 1, 1, '成品出库', 1, 200.00, 'M', 15.00, 'RMB', 1.0000, '2014-05-15', 2, 3000.00, '', '2014-05-07', '品名：ox1 规格：25 颜色：无色', '管理员', '2014-05-15 14:22:05');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_income`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '台头',
  `bankId` int(11) NOT NULL COMMENT '账户Id',
  `type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '收汇方式',
  `shouhuiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '收汇单号',
  `shouhuiDate` date NOT NULL COMMENT '收汇日期',
  `clientId` int(11) NOT NULL,
  `bizhong` char(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `huilv` decimal(10,4) NOT NULL COMMENT '汇率',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shouhuiDate` (`shouhuiDate`),
  KEY `yixiangId` (`clientId`),
  KEY `head` (`head`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='收汇登记表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `caiwu_ar_income`
--

INSERT INTO `caiwu_ar_income` (`id`, `head`, `bankId`, `type`, `shouhuiCode`, `shouhuiDate`, `clientId`, `bizhong`, `huilv`, `money`, `memo`, `creater`, `dt`) VALUES
(2, '', 1, '支付宝', 'S001', '2014-05-15', 2, 'RMB', 1.0000, 500.00, '', '管理员', '2014-05-15 09:50:00');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_bank`
--

CREATE TABLE IF NOT EXISTS `caiwu_bank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(40) COLLATE utf8_bin NOT NULL,
  `address` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `manger` char(10) COLLATE utf8_bin NOT NULL COMMENT '负责人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `contacter` char(10) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '营业厅电话',
  `acountCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '开户账号',
  `xingzhi` char(10) COLLATE utf8_bin NOT NULL COMMENT '性质(基本户|一般户|税务专用)',
  PRIMARY KEY (`id`),
  KEY `itemName` (`itemName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='银行帐号' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `caiwu_bank`
--

INSERT INTO `caiwu_bank` (`id`, `itemName`, `address`, `manger`, `tel`, `contacter`, `phone`, `acountCode`, `xingzhi`) VALUES
(1, '武进科教城工商银行支行', '常州武进科教城', '王二', '158536842145', '', '', '', '基本户');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_fapiao`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_fapiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) NOT NULL COMMENT '台头',
  `fapiaoCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `supplierId` int(11) NOT NULL COMMENT '加工户',
  `money` decimal(20,2) NOT NULL DEFAULT '0.00',
  `fapiaoDate` date NOT NULL DEFAULT '0000-00-00',
  `memo` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `creater` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fapiaoCode` (`fapiaoCode`),
  KEY `jghId` (`supplierId`),
  KEY `fapiaoDate` (`fapiaoDate`),
  KEY `head` (`head`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='应付发票' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `caiwu_yf_fapiao`
--

INSERT INTO `caiwu_yf_fapiao` (`id`, `head`, `fapiaoCode`, `supplierId`, `money`, `fapiaoDate`, `memo`, `creater`, `dt`) VALUES
(4, '', '001', 1, 1000.00, '2014-05-13', 0x61647366617364, '管理员', '2014-05-13 16:58:04');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_fukuan`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_fukuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '台头',
  `fukuanCode` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '收汇单号',
  `fukuanDate` date NOT NULL COMMENT '付款日期',
  `supplierId` int(11) NOT NULL COMMENT '供应商id',
  `fkType` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '付款方式',
  `money` decimal(15,2) NOT NULL COMMENT '付款金额',
  `memo` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fukuanDate` (`fukuanDate`),
  KEY `jghId` (`supplierId`),
  KEY `head` (`head`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='付款表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `caiwu_yf_fukuan`
--

INSERT INTO `caiwu_yf_fukuan` (`id`, `head`, `fukuanCode`, `fukuanDate`, `supplierId`, `fkType`, `money`, `memo`, `creater`, `dt`) VALUES
(1, '', '0012', '2014-05-14', 1, '支付宝', 1200.00, '阿萨德发生', '管理员', '2014-05-14 10:39:33');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_guozhang`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_guozhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rukuId` int(11) NOT NULL,
  `ruku2ProId` int(11) NOT NULL,
  `supplierId` int(10) NOT NULL COMMENT '加工户Id',
  `guozhangDate` date NOT NULL,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '应付款类型',
  `cnt` decimal(10,2) NOT NULL,
  `unit` char(20) COLLATE utf8_bin NOT NULL,
  `productId` int(10) NOT NULL COMMENT '产品id',
  `kuweiId` int(10) NOT NULL COMMENT '库位id',
  `danjia` decimal(10,2) NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `zhekouMoney` decimal(10,2) NOT NULL COMMENT '折扣金额',
  `huilv` decimal(10,4) NOT NULL COMMENT '汇率',
  `bizhong` char(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `qitaMemo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '制单人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  `rukuDate` date NOT NULL COMMENT '应付发生日期',
  `_money` decimal(10,2) NOT NULL COMMENT '发生金额，入库单价*数量',
  PRIMARY KEY (`id`),
  KEY `ord2proId` (`ruku2ProId`),
  KEY `orderId` (`rukuId`),
  KEY `guozhangDate` (`guozhangDate`),
  KEY `kind` (`kind`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='应付入账表' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `caiwu_yf_guozhang`
--

INSERT INTO `caiwu_yf_guozhang` (`id`, `rukuId`, `ruku2ProId`, `supplierId`, `guozhangDate`, `kind`, `cnt`, `unit`, `productId`, `kuweiId`, `danjia`, `money`, `zhekouMoney`, `huilv`, `bizhong`, `qitaMemo`, `memo`, `creater`, `dt`, `rukuDate`, `_money`) VALUES
(15, 6, 7, 1, '2014-05-15', '色坯纱入库过账', 15.00, '', 3, 0, 8.00, 100.00, 20.00, 0.0000, '', '品名：OE20 规格：精梳 批号/缸号:H1452014', '', '管理员', '2014-05-15 14:21:19', '2014-05-10', 120.00);

-- --------------------------------------------------------

--
-- 表的结构 `cangku_chuku`
--

CREATE TABLE IF NOT EXISTS `cangku_chuku` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `kind` smallint(6) NOT NULL COMMENT '0发货出库1客户退货9其他入库',
  `chukuDate` date NOT NULL COMMENT '领料日期',
  `chukuNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '领料单号',
  `clientId` int(10) NOT NULL COMMENT '客户id',
  `incomeId` int(10) NOT NULL COMMENT '收款id',
  `operatorId` int(10) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `chukuOrder` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '出库流转单号',
  `kind2` smallint(6) NOT NULL COMMENT '1为半成品出库2为原料出库',
  `depId` int(11) NOT NULL COMMENT '部门id',
  PRIMARY KEY (`id`),
  KEY `chukuDate` (`chukuDate`),
  KEY `chukuNum` (`chukuNum`),
  KEY `clientId` (`clientId`),
  KEY `operatorId` (`operatorId`),
  KEY `orderId` (`orderId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `cangku_chuku`
--

INSERT INTO `cangku_chuku` (`id`, `orderId`, `kind`, `chukuDate`, `chukuNum`, `clientId`, `incomeId`, `operatorId`, `memo`, `dt`, `chukuOrder`, `kind2`, `depId`) VALUES
(20, 0, 1, '2014-04-02', 'BC1404003', 1, 0, 14, '退纱操作', '2014-04-02 13:45:17', '', 0, 0),
(12, 0, 0, '2014-04-01', 'BC1404001', 1, 0, 14, '', '2014-04-02 11:17:54', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cangku_chuku2product`
--

CREATE TABLE IF NOT EXISTS `cangku_chuku2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order2productId` int(11) NOT NULL,
  `guozhangId` int(11) NOT NULL COMMENT '财务过账记录id',
  `chukuId` int(10) NOT NULL,
  `productId` int(10) NOT NULL,
  `kuweiId` int(10) NOT NULL COMMENT '库位Id',
  `danjia` decimal(10,3) NOT NULL,
  `cnt` decimal(15,2) NOT NULL,
  `WACP` decimal(15,2) NOT NULL COMMENT '加权平均产品进货价',
  `money` decimal(10,3) NOT NULL,
  `money2` decimal(10,3) NOT NULL COMMENT '其它金额,汽配中用于磨损费',
  `type` tinyint(1) NOT NULL COMMENT '类型, 默认为0,三包胎为1',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL,
  `width` decimal(10,0) NOT NULL COMMENT '宽度',
  `colorId` int(11) NOT NULL COMMENT '颜色id',
  `danjia1` decimal(10,0) NOT NULL COMMENT '过账时单价',
  `ruku2proId` int(10) NOT NULL COMMENT '入库明细表id',
  `zxDanjia` decimal(10,6) NOT NULL COMMENT '装卸单价',
  `chuku2proId` int(10) NOT NULL COMMENT '出库退纱关联老出库明细id',
  `danjiack` decimal(15,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chukuId` (`chukuId`),
  KEY `productId` (`productId`),
  KEY `guozhangId` (`guozhangId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `cangku_chuku2product`
--

INSERT INTO `cangku_chuku2product` (`id`, `order2productId`, `guozhangId`, `chukuId`, `productId`, `kuweiId`, `danjia`, `cnt`, `WACP`, `money`, `money2`, `type`, `memo`, `width`, `colorId`, `danjia1`, `ruku2proId`, `zxDanjia`, `chuku2proId`, `danjiack`) VALUES
(23, 0, 0, 20, 0, 0, 0.000, -5.00, 0.00, 0.000, 0.000, 0, '', 0, 0, 0, 18, 200.000000, 15, 0.000000),
(15, 0, 0, 12, 0, 0, 0.000, 10.00, 0.00, 0.000, 0.000, 0, '', 0, 0, 0, 18, 200.000000, 0, 100.000000);

-- --------------------------------------------------------

--
-- 表的结构 `cangku_init`
--

CREATE TABLE IF NOT EXISTS `cangku_init` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `productId` int(10) NOT NULL,
  `initCnt` decimal(15,2) NOT NULL,
  `initMoney` decimal(20,2) NOT NULL,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kucunCnt` decimal(15,3) NOT NULL COMMENT '当前库存',
  `cntCi` decimal(15,3) NOT NULL COMMENT '次品数',
  `kucunMoney` decimal(20,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品库存初始化兼做当前库存表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `cangku_init`
--

INSERT INTO `cangku_init` (`id`, `productId`, `initCnt`, `initMoney`, `memo`, `dt`, `kucunCnt`, `cntCi`, `kucunMoney`) VALUES
(1, 1, 0.00, 0.00, '', '2014-04-02 09:20:30', 0.000, 0.000, 0.00),
(2, 2, 0.00, 0.00, '', '2014-04-02 09:20:51', 0.000, 0.000, 0.00);

-- --------------------------------------------------------

--
-- 表的结构 `cangku_kucun`
--

CREATE TABLE IF NOT EXISTS `cangku_kucun` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ruku2proId` int(10) NOT NULL,
  `kucunDate` date NOT NULL COMMENT '库存发生日期',
  `kucunCnt` decimal(15,4) NOT NULL,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `productId` (`kucunDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品库存表' AUTO_INCREMENT=88 ;

--
-- 转存表中的数据 `cangku_kucun`
--

INSERT INTO `cangku_kucun` (`id`, `ruku2proId`, `kucunDate`, `kucunCnt`, `memo`, `dt`) VALUES
(10, 1, '2014-04-01', 25.0000, '', '2014-04-02 09:11:00'),
(11, 5, '2014-04-02', 62.0000, '', '2014-04-02 09:20:09'),
(8, 4, '2014-04-01', 12.0000, '', '2014-04-02 09:10:14'),
(9, 2, '2014-04-01', 1.0000, '', '2014-04-02 09:10:14'),
(12, 6, '2014-04-02', 23.0000, '', '2014-04-02 09:20:09'),
(44, 7, '2014-04-02', 50.0000, '', '2014-04-02 11:06:19'),
(46, 8, '2014-04-02', 32.0000, '', '2014-04-02 11:06:22'),
(45, 9, '2014-04-02', 2.0000, '', '2014-04-02 11:06:22'),
(30, 11, '2014-04-02', 5.0000, '', '2014-04-02 09:30:33'),
(26, 13, '2014-04-02', 5.0000, '', '2014-04-02 09:30:19'),
(47, 14, '2014-04-02', 12.0000, '', '2014-04-02 11:06:22'),
(34, 16, '2014-04-02', 1.0000, '', '2014-04-02 09:41:07'),
(42, 17, '2014-04-01', 120.0000, '', '2014-04-02 09:50:02'),
(83, 18, '2014-04-01', 5.0000, '', '2014-04-02 13:16:00'),
(54, 20, '2014-04-02', 5.0000, '', '2014-04-02 11:17:19'),
(86, 18, '2014-04-02', 20.0000, '', '2014-04-02 13:45:17'),
(81, 26, '2014-04-02', 4.0000, '', '2014-04-02 13:07:30'),
(79, 34, '2014-04-02', 1.0000, '', '2014-04-02 13:06:49'),
(85, 36, '2014-04-02', 5.0000, '', '2014-04-02 13:40:23'),
(87, 38, '2014-04-02', 5.0000, '', '2014-04-02 13:45:17');

-- --------------------------------------------------------

--
-- 表的结构 `cangku_ruku`
--

CREATE TABLE IF NOT EXISTS `cangku_ruku` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` smallint(6) NOT NULL COMMENT '0正常入库1初始化2退纱3调库9其他',
  `rukuNum` varchar(20) COLLATE utf8_bin NOT NULL,
  `songhuCode` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '送货单号',
  `rukuDate` date NOT NULL,
  `supplierId` int(10) NOT NULL COMMENT '供应商Id',
  `jiagonghuId` int(11) NOT NULL COMMENT '加工户id',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kind2` smallint(6) NOT NULL DEFAULT '0' COMMENT '1为半成品入库2为原料入库',
  `kuweiId` int(11) NOT NULL COMMENT '库位id',
  `rukuType` smallint(6) NOT NULL COMMENT '入库类型',
  PRIMARY KEY (`id`),
  KEY `ruKuDate` (`rukuDate`),
  KEY `ruKuNum` (`rukuNum`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=38 ;

--
-- 转存表中的数据 `cangku_ruku`
--

INSERT INTO `cangku_ruku` (`id`, `kind`, `rukuNum`, `songhuCode`, `rukuDate`, `supplierId`, `jiagonghuId`, `memo`, `dt`, `kind2`, `kuweiId`, `rukuType`) VALUES
(37, 3, 'CR1404002', '', '2014-04-02', 1, 0, '客户退货自动调货的记录，原始入库编号为BR1404001', '2014-04-02 13:45:17', 0, 0, 0),
(17, 0, 'BR1404001', '', '2014-04-02', 4, 0, '', '2014-04-09 10:56:17', 0, 0, 0),
(36, 3, 'CR1404002', '', '2014-04-02', 1, 0, '客户退货自动调货的记录，原始入库编号为BR1404001', '2014-04-02 13:45:17', 0, 0, 0),
(34, 3, 'CR1404001', '', '2014-04-02', 1, 0, '客户退货自动调货的记录，原始入库编号为BR1404001', '2014-04-02 13:40:23', 0, 0, 0),
(35, 3, 'CR1404001', '', '2014-04-02', 1, 0, '客户退货自动调货的记录，原始入库编号为BR1404001', '2014-04-02 13:40:23', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cangku_ruku2product`
--

CREATE TABLE IF NOT EXISTS `cangku_ruku2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order2productId` int(11) NOT NULL COMMENT '订单明细Id',
  `guozhangId` int(10) NOT NULL COMMENT '过账Id',
  `rukuId` int(10) NOT NULL,
  `productId` int(10) NOT NULL,
  `danjia` decimal(15,6) NOT NULL,
  `cnt` decimal(15,4) NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `memo` varchar(500) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `kuweiId` int(11) NOT NULL,
  `WACP` decimal(10,2) NOT NULL COMMENT '加权平均单价',
  `isGuozhang` tinyint(1) NOT NULL COMMENT '是否过账审核0是1否',
  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `czMoneyDate` date NOT NULL COMMENT '仓租费开始日期',
  `czDanjia` decimal(15,6) NOT NULL COMMENT '仓租费单价',
  `zxDanjia` decimal(15,6) NOT NULL COMMENT '装卸单价',
  `ruku2ProId` int(10) NOT NULL COMMENT '退纱操作，关联原来的id',
  `chuku2proId` int(10) NOT NULL COMMENT '客户退库后重新入库的记录，关联的退库id',
  PRIMARY KEY (`id`),
  KEY `rukuId` (`rukuId`),
  KEY `productId` (`productId`),
  KEY `order2productId` (`order2productId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `cangku_ruku2product`
--

INSERT INTO `cangku_ruku2product` (`id`, `order2productId`, `guozhangId`, `rukuId`, `productId`, `danjia`, `cnt`, `money`, `memo`, `kuweiId`, `WACP`, `isGuozhang`, `pihao`, `czMoneyDate`, `czDanjia`, `zxDanjia`, `ruku2ProId`, `chuku2proId`) VALUES
(18, 0, 0, 17, 1, 2000.000000, 20.0000, 40000.00, '', 1, 0.00, 0, '1402', '2014-04-02', 200.000000, 100.000000, 0, 0),
(38, 0, 0, 37, 1, 2000.000000, 5.0000, 10000.00, '', 1, 0.00, 1, '1402', '0000-00-00', 0.000000, 0.000000, 0, 23),
(35, 0, 0, 34, 1, 2000.000000, -5.0000, -10000.00, '', 1, 0.00, 1, '1402', '0000-00-00', 0.000000, 0.000000, 18, 0),
(36, 0, 0, 35, 1, 2000.000000, 5.0000, 10000.00, '', 1, 0.00, 1, '1402', '0000-00-00', 0.000000, 0.000000, 0, 0),
(37, 0, 0, 36, 1, 2000.000000, -5.0000, -10000.00, '', 1, 0.00, 1, '1402', '0000-00-00', 0.000000, 0.000000, 18, 23);

-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_chuku`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_chuku` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` smallint(6) NOT NULL COMMENT '0正常领料1其他出库2车间退库3调库4委外9其他出库',
  `chukuDate` date NOT NULL COMMENT '领料日期',
  `chukuNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '领料单号',
  `depId` int(10) NOT NULL COMMENT '部门Id',
  `operatorId` int(10) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `orderType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单据类型(1为正常, 2为退货, 3为补发)',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `chukuDate` (`chukuDate`),
  KEY `chukuNum` (`chukuNum`),
  KEY `chejianId` (`depId`),
  KEY `operatorId` (`operatorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `cangku_yl_chuku`
--


-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_chuku2yl`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_chuku2yl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `chukuId` int(10) NOT NULL,
  `ylId` int(10) NOT NULL COMMENT '原料ID',
  `kuweiId` int(10) NOT NULL COMMENT '库位Id',
  `len` decimal(10,2) NOT NULL COMMENT '长度',
  `zhishu` decimal(11,2) NOT NULL COMMENT '支数',
  `danjia` decimal(15,4) NOT NULL,
  `cnt` decimal(15,3) NOT NULL,
  `danwei` int(11) NOT NULL COMMENT '单位',
  `money` decimal(20,2) NOT NULL,
  `memo` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chukuId` (`chukuId`),
  KEY `ylId` (`ylId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=45 ;

--
-- 转存表中的数据 `cangku_yl_chuku2yl`
--


-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_init`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_init` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ylId` int(10) NOT NULL,
  `initCnt` float(10,3) NOT NULL,
  `initMoney` decimal(15,2) NOT NULL,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kucunCnt` decimal(15,3) NOT NULL COMMENT '当前库存',
  `kucunZhishu` decimal(11,2) NOT NULL,
  `kucunLen` decimal(10,2) NOT NULL COMMENT '库存长度',
  `kucunMoney` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ylId` (`ylId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='原料库存初始化兼做当前库存表' AUTO_INCREMENT=154 ;

--
-- 转存表中的数据 `cangku_yl_init`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cpck`
--

CREATE TABLE IF NOT EXISTS `chengpin_cpck` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '发生类别',
  `guozhangId` int(11) NOT NULL COMMENT '过账id',
  `cpckCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '成品出库号',
  `orderId` int(10) NOT NULL COMMENT '生产订单号',
  `cpckDate` date NOT NULL COMMENT '成品出库日期',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` int(10) NOT NULL COMMENT '创建人',
  `dt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `kid` int(1) NOT NULL DEFAULT '0' COMMENT '是否返修，0否1是',
  PRIMARY KEY (`id`),
  KEY `cpckCode` (`cpckCode`),
  KEY `orderId` (`orderId`),
  KEY `dateCpck` (`cpckDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品出库' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `chengpin_cpck`
--

INSERT INTO `chengpin_cpck` (`id`, `kind`, `guozhangId`, `cpckCode`, `orderId`, `cpckDate`, `memo`, `creater`, `dt`, `kid`) VALUES
(1, '正常出库', 0, 'CC', 1, '2014-05-07', '', 0, '2014-05-07 16:58:32', 0);

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cpck2product`
--

CREATE TABLE IF NOT EXISTS `chengpin_cpck2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '出库主表ID',
  `chukuId` int(10) NOT NULL,
  `productId` int(10) NOT NULL COMMENT '产品id',
  `ord2proId` int(10) NOT NULL COMMENT '订单明细表ID',
  `cntDuan` int(10) NOT NULL COMMENT '出库件数',
  `cnt` decimal(15,2) NOT NULL COMMENT '原始数量',
  `unit` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '原始单位',
  `danjia` decimal(10,2) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  `cntKg` decimal(15,1) NOT NULL COMMENT '折合公斤数',
  `memo` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='成品出库明细表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `chengpin_cpck2product`
--

INSERT INTO `chengpin_cpck2product` (`id`, `chukuId`, `productId`, `ord2proId`, `cntDuan`, `cnt`, `unit`, `danjia`, `money`, `cntKg`, `memo`) VALUES
(1, 1, 1, 1, 2, 200.00, 'M', 15.00, 3000.00, 11.5, '');

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cprk`
--

CREATE TABLE IF NOT EXISTS `chengpin_cprk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '发生类别',
  `cprkCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '成品入库号',
  `orderId` int(10) NOT NULL COMMENT '生产订单号',
  `cprkDate` date NOT NULL COMMENT '入库时间',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注 ',
  `creater` int(10) NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `cprkCode` (`cprkCode`),
  KEY `orderId` (`orderId`),
  KEY `dateCprk` (`cprkDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品入库' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `chengpin_cprk`
--

INSERT INTO `chengpin_cprk` (`id`, `kind`, `cprkCode`, `orderId`, `cprkDate`, `memo`, `creater`, `dt`) VALUES
(1, '正常出库', 'CPCK140507001', 1, '2014-05-07', '', 1, '2014-05-14 16:54:39');

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cprk2product`
--

CREATE TABLE IF NOT EXISTS `chengpin_cprk2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `rukuId` int(10) NOT NULL COMMENT '入库主表id',
  `cntDuan` int(4) NOT NULL COMMENT '段数',
  `cnt` decimal(10,1) NOT NULL COMMENT '原始数量',
  `unit` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '计量单位',
  `danjia` decimal(10,2) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  `cntKg` decimal(10,1) NOT NULL COMMENT '折合公斤数',
  `productId` int(10) NOT NULL COMMENT '产品id',
  `ord2proId` int(10) NOT NULL COMMENT '订单明细表id',
  `dajuanKind` smallint(1) NOT NULL COMMENT '0单卷单匹1打包',
  `memo` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='入库明细表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_cprk2product`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_kucun`
--

CREATE TABLE IF NOT EXISTS `chengpin_kucun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateFasheng` date NOT NULL COMMENT '发生日期',
  `orderId` int(11) NOT NULL COMMENT '生产订单号',
  `ord2proId` int(11) NOT NULL COMMENT '订单明细表id',
  `productId` int(11) NOT NULL COMMENT '产品id',
  `rukuId` int(11) NOT NULL COMMENT '入库id',
  `chukuId` int(11) NOT NULL COMMENT '出库id',
  `duanFasheng` int(5) NOT NULL COMMENT '段数',
  `cntFasheng` decimal(10,1) NOT NULL COMMENT '原始数量',
  `unitFasheng` varchar(10) NOT NULL COMMENT '发生单位',
  `cntKgFasheng` decimal(15,1) NOT NULL COMMENT '发生公斤数,针织产品一般以公斤数为库存核算单位',
  `danjiaFasheng` decimal(10,2) NOT NULL COMMENT '单价',
  `moneyFasheng` decimal(15,2) NOT NULL COMMENT '发生金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='成品库存表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_kucun`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_madan`
--

CREATE TABLE IF NOT EXISTS `chengpin_madan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dajuanKind` smallint(1) NOT NULL COMMENT '0单卷单匹1打包',
  `orderId` int(11) NOT NULL,
  `ord2proId` int(11) NOT NULL,
  `madanDate` date NOT NULL COMMENT '码单日期',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL,
  `cprkId` int(11) NOT NULL,
  `cpckId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`orderId`,`ord2proId`),
  KEY `ord2proId` (`ord2proId`),
  KEY `dajuanKind` (`dajuanKind`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='码单登记表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_madan`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_madan_son`
--

CREATE TABLE IF NOT EXISTS `chengpin_madan_son` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cprk2proId` int(10) NOT NULL COMMENT '入库明细表id',
  `number` smallint(4) NOT NULL COMMENT '件号',
  `cnt` double(10,2) NOT NULL COMMENT '码数',
  `cnt_format` varchar(100) COLLATE utf8_bin NOT NULL,
  `lot` char(5) COLLATE utf8_bin NOT NULL COMMENT '质量等级',
  `cpck2proId` int(11) NOT NULL COMMENT '出库明细表id',
  PRIMARY KEY (`id`),
  KEY `cpckId` (`cpck2proId`),
  KEY `madanId` (`cprk2proId`),
  KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='码单登记表从表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_madan_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `jichu_client`
--

CREATE TABLE IF NOT EXISTS `jichu_client` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `traderId` int(10) NOT NULL COMMENT '本单位联系人',
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司编码',
  `zhujiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `codeAtOrder` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '合同简称',
  `people` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '对方联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `accountId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '帐号',
  `taxId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '税号',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `kaipiao` text COLLATE utf8_bin NOT NULL,
  `zhizaoPic` varchar(100) COLLATE utf8_bin NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `comeFrom` char(10) COLLATE utf8_bin NOT NULL COMMENT '来源',
  `isVip` int(10) NOT NULL COMMENT '0受限制，1不受限制',
  `isStop` tinyint(1) NOT NULL COMMENT '是否停止往来',
  `letters` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户名转换字母',
  PRIMARY KEY (`id`),
  UNIQUE KEY `compName` (`compName`),
  KEY `compCode` (`compCode`),
  KEY `traderId` (`traderId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户档案' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_client`
--

INSERT INTO `jichu_client` (`id`, `traderId`, `compCode`, `zhujiCode`, `compName`, `codeAtOrder`, `people`, `tel`, `fax`, `mobile`, `email`, `accountId`, `taxId`, `address`, `kaipiao`, `zhizaoPic`, `memo`, `comeFrom`, `isVip`, `isStop`, `letters`) VALUES
(1, 1, 'x1', '', '测试公司1', '', 'xj', '123', '', '123', '', '', '', '', '', '', '', '', 0, 0, ''),
(2, 2, 'x2', '', '测试公司2', '', 'cxy', '345', '', '345', '', '', '', '', '', '', '', '', 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_client_taitou`
--

CREATE TABLE IF NOT EXISTS `jichu_client_taitou` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `clientId` int(10) NOT NULL COMMENT '客户Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '客户的开票抬头',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户发票抬头' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jichu_client_taitou`
--


-- --------------------------------------------------------

--
-- 表的结构 `jichu_department`
--

CREATE TABLE IF NOT EXISTS `jichu_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '部门名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `depName` (`depName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='部门档案' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jichu_department`
--

INSERT INTO `jichu_department` (`id`, `depName`) VALUES
(1, '业务部');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_employ`
--

CREATE TABLE IF NOT EXISTS `jichu_employ` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `employCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工编码',
  `employName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工名称',
  `codeAtEmploy` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '简称',
  `sex` smallint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `depId` int(10) NOT NULL COMMENT '部门ID',
  `gongzhong` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '工种',
  `fenlei` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '修布工分类',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `address` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `dateEnter` date NOT NULL COMMENT '入厂时间',
  `isFire` tinyint(1) NOT NULL COMMENT '是否离职：1为是',
  `dateLeave` date NOT NULL COMMENT '离厂时间',
  `shenfenNo` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '身份证号',
  `hetongCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '劳动合同号',
  `isCaiyang` smallint(1) NOT NULL DEFAULT '0' COMMENT '是否可以采样',
  `isDayang` tinyint(1) NOT NULL COMMENT '是否打样人',
  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别',
  `paixu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `employName` (`employName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='员工档案' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_employ`
--

INSERT INTO `jichu_employ` (`id`, `employCode`, `employName`, `codeAtEmploy`, `sex`, `depId`, `gongzhong`, `fenlei`, `mobile`, `address`, `dateEnter`, `isFire`, `dateLeave`, `shenfenNo`, `hetongCode`, `isCaiyang`, `isDayang`, `type`, `paixu`) VALUES
(1, 'xj', '员工名字1', '', 0, 1, '', '', '', '', '0000-00-00', 0, '0000-00-00', '', '', 0, 0, '', 0),
(2, 'cxy', '员工名字2', '', 0, 1, '', '', '', '', '0000-00-00', 0, '0000-00-00', '', '', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `jichu_kuwei`
--

CREATE TABLE IF NOT EXISTS `jichu_kuwei` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kuweiName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '库位名称',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='库位' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `jichu_kuwei`
--

INSERT INTO `jichu_kuwei` (`id`, `kuweiName`, `memo`) VALUES
(1, '库位1', ''),
(2, '库位2', ''),
(3, '库位3', ''),
(4, '库位4', '');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_product`
--

CREATE TABLE IF NOT EXISTS `jichu_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '坯纱,色纱,针织布,其他',
  `zhongLei` varchar(30) COLLATE utf8_bin NOT NULL,
  `proCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '产品编号',
  `proName` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '品名',
  `color` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '颜色',
  `guige` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '规格',
  `chengFen` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '成份',
  `menfu` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `proCode` (`proCode`),
  KEY `pinming` (`proName`),
  KEY `guige` (`guige`),
  KEY `kind` (`kind`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `jichu_product`
--

INSERT INTO `jichu_product` (`id`, `kind`, `zhongLei`, `proCode`, `proName`, `color`, `guige`, `chengFen`, `menfu`, `kezhong`, `memo`) VALUES
(1, '坯纱', '', '002', 'ox1', '无色', '25', '', '', '', ''),
(3, '色纱', '', '001', 'OE20', '靛蓝', '精梳', '', '', '', ''),
(4, '坯纱', '', '1', '2', '3', '4', '5', '6', '7', '8'),
(6, '', '', 'WF721835-ZQ', '丈青活性大毛圈', '', '21sc*21s*70D', 'C95% SP5%', '180CM', '350G/M2 ', ''),
(7, '', '', 'WFI711722', '靛蓝小毛圈', '', '20S蓝*40S白*30D', 'C97% SP3%', '170CM', '220g/m2', ''),
(8, '', '', 'WFI711733', '靛蓝小毛圈', '', '20S蓝*21S白*70D', 'C95% SP5%', '170CM', '330g/m2', '');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_supplier`
--

CREATE TABLE IF NOT EXISTS `jichu_supplier` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `traderId` int(10) NOT NULL COMMENT '本单位联系人',
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '加工户编码',
  `zhujiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '加工户名称',
  `people` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `accountId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '帐号',
  `taxId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '税号',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `comeFrom` char(10) COLLATE utf8_bin NOT NULL COMMENT '来源',
  `isVip` int(10) NOT NULL COMMENT '0受限制，1不受限制',
  PRIMARY KEY (`id`),
  UNIQUE KEY `compName` (`compName`),
  KEY `compCode` (`compCode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='加工户档案' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_supplier`
--

INSERT INTO `jichu_supplier` (`id`, `traderId`, `compCode`, `zhujiCode`, `compName`, `people`, `tel`, `fax`, `mobile`, `accountId`, `taxId`, `address`, `memo`, `comeFrom`, `isVip`) VALUES
(1, 0, '', '', '供应商1', '', '', '', '', '', '', '', '', '', 0),
(2, 0, '', '', '供应商2', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `jichu_supplier_taitou`
--

CREATE TABLE IF NOT EXISTS `jichu_supplier_taitou` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `supplierId` int(10) NOT NULL COMMENT '坯纱供应商Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '供应商的开票抬头',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户发票抬头' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jichu_supplier_taitou`
--


-- --------------------------------------------------------

--
-- 表的结构 `jichu_yuanliao`
--

CREATE TABLE IF NOT EXISTS `jichu_yuanliao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '坯纱或者色纱',
  `proCode` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '产品编码',
  `zhujiCode` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '助记码',
  `zhonglei` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '纱支成分',
  `proName` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '产品名称',
  `guige` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT '规格',
  `color` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '颜色',
  `unit` char(10) CHARACTER SET utf8 NOT NULL COMMENT '单位',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `proName` (`proName`),
  KEY `guige` (`guige`),
  KEY `proCode` (`proCode`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_yuanliao`
--

INSERT INTO `jichu_yuanliao` (`id`, `kind`, `proCode`, `zhujiCode`, `zhonglei`, `proName`, `guige`, `color`, `unit`, `memo`) VALUES
(1, '0', '原料测试1', '', '', '原料1', 'aabb', '', '', ''),
(2, '0', '原料测试2', '', '', '原料2', 'aacc', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_yuanliao_kind`
--

CREATE TABLE IF NOT EXISTS `jichu_yuanliao_kind` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '类别',
  PRIMARY KEY (`id`),
  KEY `itemName` (`itemName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_yuanliao_kind`
--

INSERT INTO `jichu_yuanliao_kind` (`id`, `itemName`) VALUES
(1, '色纱'),
(2, '坯纱');

-- --------------------------------------------------------

--
-- 表的结构 `jifen_comp`
--

CREATE TABLE IF NOT EXISTS `jifen_comp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `remoteCompId` int(10) NOT NULL COMMENT '远程公司表id',
  `compCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '公司编码',
  `compName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `compFullName` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '公司全称',
  `initJingyan` int(10) NOT NULL COMMENT '初始经验',
  `remoteJingyan` int(10) NOT NULL COMMENT '生效经验',
  `jingyan` int(10) NOT NULL COMMENT '本地经验',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='积分企业身份表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_comp`
--


-- --------------------------------------------------------

--
-- 表的结构 `jifen_comp_rank`
--

CREATE TABLE IF NOT EXISTS `jifen_comp_rank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `compId` int(10) NOT NULL COMMENT '网站端的公司ID',
  `compCode` varchar(20) COLLATE utf8_bin NOT NULL,
  `compName` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `compFullName` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '公司全称',
  `jinyan` int(10) NOT NULL COMMENT '当前的经验值',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '操作人',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '最后操作日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='公司积分排名表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_comp_rank`
--


-- --------------------------------------------------------

--
-- 表的结构 `jifen_upbyuser_log`
--

CREATE TABLE IF NOT EXISTS `jifen_upbyuser_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT '操作用户',
  `jifen` smallint(20) NOT NULL COMMENT '本次上传积分',
  `shishiPeo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '上传者(实施人员)',
  `upLogDate` date NOT NULL COMMENT '上传日期',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='本地用户积分上传日志' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_upbyuser_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `jifen_up_error`
--

CREATE TABLE IF NOT EXISTS `jifen_up_error` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '登录用户名',
  `error` text COLLATE utf8_bin NOT NULL COMMENT '错误描述',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_up_error`
--


-- --------------------------------------------------------

--
-- 表的结构 `jifen_up_log`
--

CREATE TABLE IF NOT EXISTS `jifen_up_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `jifen` smallint(20) NOT NULL COMMENT '本次上传公司积分',
  `shishiPeo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '上传者(实施人员)',
  `upLogDate` date NOT NULL COMMENT '上次日期',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='本地积分上传日志' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_up_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `jifen_user`
--

CREATE TABLE IF NOT EXISTS `jifen_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `remoteUserId` int(10) NOT NULL COMMENT '远程用户表id',
  `shenfenzheng` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '身份证号码',
  `realName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '真实姓名',
  `userCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '用户编号',
  `passwd` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `remoteJifen` int(10) NOT NULL COMMENT '生效积分',
  `jifen` int(10) NOT NULL COMMENT '本地积分',
  `remoteJingyan` int(10) NOT NULL COMMENT '生效经验',
  `jingyan` int(10) NOT NULL COMMENT '本地经验',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='积分用户身份表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_user`
--


-- --------------------------------------------------------

--
-- 表的结构 `jifen_user_rank`
--

CREATE TABLE IF NOT EXISTS `jifen_user_rank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '用户编号',
  `userName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '姓名',
  `compId` int(10) NOT NULL COMMENT 'jifen_comp_rank表中的compId',
  `compName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '所属公司名称',
  `jinyan` int(10) NOT NULL COMMENT '经验值',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户积分排名表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jifen_user_rank`
--


-- --------------------------------------------------------

--
-- 表的结构 `mail_db`
--

CREATE TABLE IF NOT EXISTS `mail_db` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `senderId` int(10) NOT NULL COMMENT '发件人',
  `accepterId` int(10) NOT NULL COMMENT '收件人',
  `title` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `attachment` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '附件',
  `mailCode` int(10) NOT NULL COMMENT '邮件编码，纯数字',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timeRead` datetime NOT NULL COMMENT '查看日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='邮件' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `mail_db`
--


-- --------------------------------------------------------

--
-- 表的结构 `oa_message`
--

CREATE TABLE IF NOT EXISTS `oa_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kindName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '生产通知或生产变更通知',
  `title` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `buildDate` date NOT NULL COMMENT '发布日期',
  `orderId` int(10) NOT NULL COMMENT '订单id',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产通知' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `oa_message`
--

INSERT INTO `oa_message` (`id`, `kindName`, `title`, `content`, `buildDate`, `orderId`, `creater`, `dt`) VALUES
(1, '行政通知', 'qweqweqw', 0x65717765656565656565656565656565656565656565, '2014-05-08', 0, '管理员', '2014-05-07 17:05:20'),
(2, '行政通知', '112121', 0x3c696d67207372633d22687474703a2f2f6d6170732e676f6f676c65617069732e636f6d2f6d6170732f6170692f7374617469636d61703f63656e7465723d33312e323233343835322532433132312e3437393032393926616d703b7a6f6f6d3d313126616d703b73697a653d3535387833363026616d703b6d6170747970653d726f61646d617026616d703b6d61726b6572733d33312e323233343835322532433132312e3437393032393926616d703b6c616e67756167653d7a685f434e26616d703b73656e736f723d66616c73652220616c743d2222202f3e3c696d67207372633d222f6a78635f776f66656e672f5265736f757263652f5363726970742f6b696e64656469746f722f61747461636865642f696d6167652f32303134303530382f32303134303530383135313935335f32383135322e6a70672220616c743d2222202f3e, '2014-05-08', 0, '管理员', '2014-05-08 15:20:00');

-- --------------------------------------------------------

--
-- 表的结构 `oa_message_class`
--

CREATE TABLE IF NOT EXISTS `oa_message_class` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `className` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别名称',
  `isWindow` tinyint(1) NOT NULL COMMENT '是否弹出窗0否1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `oa_message_class`
--

INSERT INTO `oa_message_class` (`id`, `className`, `isWindow`) VALUES
(1, '行政通知', 0);

-- --------------------------------------------------------

--
-- 表的结构 `shengchan_chanliang`
--

CREATE TABLE IF NOT EXISTS `shengchan_chanliang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderId` int(10) NOT NULL COMMENT '订单id',
  `ord2proId` int(10) NOT NULL COMMENT '订单明细Id',
  `chanpinId` int(10) NOT NULL COMMENT '产品Id',
  `chanliangDate` date NOT NULL COMMENT '产量日期',
  `workCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `cnt` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数量',
  `outputSource` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '产量来源',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `ord2proId` (`ord2proId`),
  KEY `chanpinId` (`chanpinId`),
  KEY `chanliangDate` (`chanliangDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='产量表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `shengchan_chanliang`
--

INSERT INTO `shengchan_chanliang` (`id`, `orderId`, `ord2proId`, `chanpinId`, `chanliangDate`, `workCode`, `cnt`, `outputSource`, `memo`, `dt`) VALUES
(6, 3, 7, 2, '2014-04-29', '1', 1.00, '', '1', '2014-04-29 14:58:15');

-- --------------------------------------------------------

--
-- 表的结构 `sys_dbchange_log`
--

CREATE TABLE IF NOT EXISTS `sys_dbchange_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileName` varchar(40) NOT NULL COMMENT '文件名',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `memo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fileName` (`fileName`),
  KEY `dt` (`dt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='数据补丁执行表' AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `sys_dbchange_log`
--

INSERT INTO `sys_dbchange_log` (`id`, `fileName`, `dt`, `content`, `memo`) VALUES
(1, 'jeff_140414_0.txt', '2014-04-15 08:42:11', 'ALTER TABLE `yuanliao_cgrk`\nMODIFY COLUMN `kind`  varchar(10) NOT NULL COMMENT ''入库类型文字说明即可'' AFTER `id`;\nALTER TABLE `yuanliao_llck`\nMODIFY COLUMN `kind`  varchar(10) NOT NULL COMMENT ''入库类型，文字说明即可'' AFTER `id`;', ''),
(2, 'jeff_140414_1.txt', '2014-04-15 08:42:12', 'ALTER TABLE `yuanliao_cgrk`\nADD COLUMN `kuwei`  varchar(20) NOT NULL COMMENT ''库位'' AFTER `kind`;\nALTER TABLE `yuanliao_llck`\nADD COLUMN `kuwei`  varchar(10) NOT NULL COMMENT ''库位'' AFTER `kind`;', ''),
(3, 'jeff_140414_2.txt', '2014-04-15 08:42:12', 'ALTER TABLE `yuanliao_cgrk`\nADD COLUMN `money`  decimal(15,2) NOT NULL COMMENT ''入库金额'' AFTER `danjia`;\nALTER TABLE `yuanliao_llck`\nADD COLUMN `danjia`  decimal(15,2) NOT NULL COMMENT ''出库单价'' AFTER `cnt`,\nADD COLUMN `money`  decimal(15,2) NOT NULL COMMENT ''出库金额'' AFTER `danjia`;', ''),
(4, 'jeff_140414_3.txt', '2014-04-15 08:42:12', 'CREATE TABLE `yuanliao_kucun` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `dateFasheng` date DEFAULT NULL COMMENT ''发生日期'',\n  `rukuId` int(11) NOT NULL COMMENT ''入库表id'',\n  `chukuId` int(11) NOT NULL COMMENT ''出库表id'',\n  `kind` varchar(10) NOT NULL COMMENT ''出入库类型'',\n  `kuwei` varchar(10) NOT NULL COMMENT ''库位'',\n  `type` int(1) NOT NULL COMMENT ''原料类型'',\n  `supplierId` int(11) NOT NULL COMMENT ''供应商id'',\n  `yuanliaoId` int(11) NOT NULL COMMENT ''原料id'',\n  `pihao` varchar(50) NOT NULL COMMENT ''批号'',\n  `cntFasheng` decimal(15,2) NOT NULL COMMENT ''发生数量,入库为+，出库为-'',\n  `danjiaFasheng` decimal(15,2) NOT NULL COMMENT ''单价'',\n  `moneyFasheng` decimal(15,2) NOT NULL COMMENT ''金额'',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=''原料库存表'';', ''),
(5, 'jeff_140414_4.txt', '2014-04-15 08:42:12', 'ALTER TABLE `shengchan_chanliang`\nADD COLUMN `workCode`  varchar(20) NOT NULL COMMENT ''工号'' AFTER `chanliangDate`;', ''),
(6, 'jeff_140414_5.txt', '2014-04-15 08:42:12', 'ALTER TABLE `chengpin_cprk`\nADD COLUMN `kind`  varchar(10) NOT NULL COMMENT ''发生类别'' AFTER `id`;\nALTER TABLE `chengpin_cpck`\nADD COLUMN `kind`  varchar(10) NOT NULL COMMENT ''发生类别'' AFTER `id`;\nCREATE TABLE `chengpin_kucun` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `dateFasheng` date NOT NULL COMMENT ''发生日期'',\n  `orderId` int(11) NOT NULL COMMENT ''生产订单号'',\n  `ord2proId` int(11) NOT NULL COMMENT ''订单明细表id'',\n  `duanFasheng` int(5) NOT NULL COMMENT ''段数'',\n  `cntFasheng` decimal(10,1) NOT NULL COMMENT ''原始数量'',\n  `unitFasheng` varchar(10) NOT NULL COMMENT ''发生单位'',\n  `cntKgFasheng` decimal(15,1) NOT NULL COMMENT ''发生公斤数,针织产品一般以公斤数为库存核算单位'',\n  `danjiaFasheng` decimal(10,2) NOT NULL COMMENT ''单价'',\n  `moneyFasheng` decimal(15,2) NOT NULL COMMENT ''发生金额'',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=''成品库存表'';', ''),
(7, 'jeff_140418_0.txt', '2014-04-18 13:44:46', 'ALTER TABLE `trade_order`\nADD COLUMN `finalDate`  date NOT NULL COMMENT ''最终交期'' AFTER `orderDate`,\nADD COLUMN `xsType`  varchar(20) NOT NULL AFTER `clientOrder`;', '程序员提交，不需执行'),
(8, 'xj_140418_0.txt', '2014-04-18 13:45:32', 'ALTER TABLE `trade_order`\nADD COLUMN `finalDate`  date NOT NULL COMMENT ''最终交期'' AFTER `orderDate`,\nADD COLUMN `xsType`  varchar(20) NOT NULL AFTER `clientOrder`;', '程序员提交，不需执行'),
(9, 'xj_140418_1.txt', '2014-04-18 17:14:32', 'ALTER TABLE `trade_order`\nMODIFY COLUMN `checkDate`  timestamp NOT NULL DEFAULT ''0000-00-00'' ON UPDATE CURRENT_TIMESTAMP COMMENT ''审核日期'' AFTER `checkPeo`;', ''),
(10, 'xj_140422_0.txt', '2014-04-22 10:06:13', 'ALTER TABLE `yuanliao_cgrk`\nDROP COLUMN `kuwei`,\nDROP COLUMN `type`,\nDROP COLUMN `yuanliaoId`,\nDROP COLUMN `pihao`,\nDROP COLUMN `cnt`,\nDROP COLUMN `danjia`,\nDROP COLUMN `money`,\nDROP COLUMN `memo`,\nDROP COLUMN `return4id`,\nMODIFY COLUMN `rukuCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''入库单号'' AFTER `kind`,\nMODIFY COLUMN `rukuDate`  date NOT NULL COMMENT ''入库日期'' AFTER `supplierId`,\nMODIFY COLUMN `isGuozhang`  int(1) NOT NULL DEFAULT 0 COMMENT ''是否过账:0是1否'' AFTER `rukuDate`;\n', '程序员提交，不需执行'),
(11, 'xj_140422_1.txt', '2014-04-22 10:24:33', 'CREATE TABLE `yuanliao_cgrk2product` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `rukuId` int(10) NOT NULL COMMENT ''入库Id'',\n  `productId` int(10) NOT NULL COMMENT ''原料产品id'',\n  `pihao` varchar(50) NOT NULL COMMENT ''批号'',\n  `cnt` decimal(15,2) NOT NULL COMMENT ''数量'',\n  `danjia` decimal(15,1) NOT NULL COMMENT ''单价'',\n  `money` decimal(15,2) NOT NULL COMMENT ''金额'',\n  `memo` varchar(100) NOT NULL COMMENT ''注释'',\n  `return4id` int(11) NOT NULL COMMENT ''退库时相关入库id'',\n  `kuweiId` int(10) NOT NULL COMMENT ''库位id'',\n  `type` int(10) NOT NULL COMMENT ''原料类型'',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1', '程序员提交，不需执行'),
(12, 'xj_140422_2.txt', '2014-04-22 16:25:07', 'ALTER TABLE `yuanliao_cgrk`\nADD COLUMN `memo`  varchar(200) NOT NULL COMMENT ''备注'' AFTER `dt`;', '程序员提交，不需执行'),
(13, 'xj_140423_0.txt', '2014-04-23 11:56:33', 'ALTER TABLE `trade_order`\nDROP COLUMN `finalDate`,\nMODIFY COLUMN `traderId`  int(11) NOT NULL COMMENT ''业务员ID'' AFTER `orderDate`;', '程序员提交，不需执行'),
(14, 'xj_140424_0.txt', '2014-04-24 11:04:54', 'CREATE TABLE `yuanliao_llck2product` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `chukuId` int(10) NOT NULL COMMENT '' 出库id'',\n  `productId` int(10) NOT NULL COMMENT ''原料产品id'',\n  `pihao` varchar(50) NOT NULL COMMENT ''批号'',\n  `cnt` decimal(15,2) NOT NULL COMMENT ''数量'',\n  `danjia` decimal(15,1) NOT NULL COMMENT ''单价'',\n  `money` decimal(15,2) NOT NULL COMMENT ''金额'',\n  `type` int(10) NOT NULL COMMENT ''原料类型'',\n  `memo` varchar(100) NOT NULL COMMENT ''备注'',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT=''出库子表''', '程序员提交，不需执行'),
(15, 'xj_140424_1.txt', '2014-04-24 11:07:22', 'ALTER TABLE `yuanliao_llck`\nDROP COLUMN `type`,\nDROP COLUMN `yuanliaoId`,\nDROP COLUMN `pihao`,\nDROP COLUMN `cnt`,\nDROP COLUMN `danjia`,\nDROP COLUMN `money`,\nMODIFY COLUMN `yuanyin`  varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''出库原因'' AFTER `kuwei`,\nMODIFY COLUMN `chukuCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''出库单号'' AFTER `supplierId`,\nMODIFY COLUMN `memo`  varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''备注'' AFTER `chukuCode`;\n', '程序员提交，不需执行'),
(16, 'xj_140424_2.txt', '2014-04-24 11:08:48', 'ALTER TABLE `yuanliao_llck`\nMODIFY COLUMN `kind`  varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''出库类型，文字说明即可'' AFTER `id`;\n', '程序员提交，不需执行'),
(17, 'jeff_140414_6.txt', '2014-04-25 13:15:30', '', '人工标记为已执行'),
(18, 'jeff_140425_0.txt', '2014-04-25 13:15:34', 'ALTER TABLE `jichu_yuanliao`\nMODIFY COLUMN `zhonglei`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT ''纱支成分'' AFTER `zhujiCode`;\nALTER TABLE `jichu_yuanliao`\nMODIFY COLUMN `kind`  smallint(6) NOT NULL COMMENT ''坯纱或者色纱'' AFTER `id`,\nMODIFY COLUMN `proCode`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''产品编码'' AFTER `kind`,\nMODIFY COLUMN `zhujiCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''助记码'' AFTER `proCode`,\nMODIFY COLUMN `zhonglei`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''纱支成分'' AFTER `zhujiCode`,\nMODIFY COLUMN `guige`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''规格'' AFTER `proName`,\nMODIFY COLUMN `color`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''颜色'' AFTER `guige`,\nMODIFY COLUMN `unit`  char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''单位'' AFTER `color`,\nMODIFY COLUMN `memo`  varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''备注'' AFTER `unit`;\nALTER TABLE `jichu_yuanliao`\nMODIFY COLUMN `kind`  varchar(10) NOT NULL COMMENT ''坯纱或者色纱'' AFTER `id`;', ''),
(19, 'xj_140425_0.txt', '2014-04-25 13:18:55', 'ALTER TABLE `jichu_product`\nADD COLUMN `kind`  varchar(10) NOT NULL COMMENT ''坯纱，色纱，针织，其他'' AFTER `id`;\nALTER TABLE `jichu_product`\nADD INDEX `kind` (`kind`) ;\nALTER TABLE `jichu_product`\nADD COLUMN `zhonglei`  varchar(10) NOT NULL AFTER `kind`,\nADD INDEX `zhonglei` (`zhonglei`) ;\nALTER TABLE `jichu_product`\nCHANGE COLUMN `pinming` `proName`  varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ''品名'' AFTER `pinzhong`;', '程序员提交，不需执行'),
(20, 'xj_140426_0.txt', '2014-04-28 08:18:36', 'ALTER TABLE `yuanliao_kucun`\nMODIFY COLUMN `pihao`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''批号'' AFTER `type`,\nMODIFY COLUMN `supplierId`  int(11) NOT NULL COMMENT ''供应商id'' AFTER `pihao`,\nCHANGE COLUMN `yuanliaoId` `productId`  int(11) NOT NULL COMMENT ''原料id'' AFTER `supplierId`,\nMODIFY COLUMN `cntFasheng`  decimal(15,2) NOT NULL COMMENT ''发生数量,入库为+，出库为-'' AFTER `productId`;\nALTER TABLE `yuanliao_cgrk`\nADD COLUMN `kuwei`  varchar(10) NOT NULL COMMENT ''库位，一般一笔记录只会有一个库位'' AFTER `kind`;\n', ''),
(21, 'xj_140428_0.txt', '2014-04-28 14:27:41', 'ALTER TABLE `yuanliao_llck`\nADD COLUMN `orderId`  int(10) NOT NULL COMMENT ''订单id'' AFTER `kind`;', '程序员提交，不需执行'),
(22, 'xj_140428_1.txt', '2014-04-28 14:51:41', 'ALTER TABLE `yuanliao_llck`\nADD COLUMN `depId`  int(10) NOT NULL COMMENT ''部门id'' AFTER `chukuDate`;', '程序员提交，不需执行'),
(23, 'xj_140428_2.txt', '2014-04-28 17:49:20', 'ALTER TABLE `yuanliao_cgrk2product`\nDROP COLUMN `kuweiId`,\nMODIFY COLUMN `type`  int(10) NOT NULL COMMENT ''原料类型'' AFTER `return4id`;', '程序员提交，不需执行'),
(24, 'xj_140429_0.txt', '2014-04-29 19:31:55', 'CREATE TABLE `chengpin_cprk2product` (\n  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT ''主键'',\n  `rukuId` int(10) NOT NULL COMMENT ''入库主表id'',\n  `cntDuan` int(4) NOT NULL COMMENT ''段数'',\n  `cnt` decimal(10,1) NOT NULL COMMENT ''原始数量'',\n  `unit` varchar(10) NOT NULL COMMENT ''计量单位'',\n  `danjia` decimal(10,2) NOT NULL COMMENT ''单价'',\n  `money` decimal(15,2) NOT NULL COMMENT ''金额'',\n  `cntKg` decimal(10,1) NOT NULL COMMENT ''折合公斤数'',\n  `ord2proId` int(10) NOT NULL COMMENT ''产品编号'',\n  `dajuanKind` smallint(1) NOT NULL COMMENT ''0单卷单匹1打包'',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT=''入库明细表''', '程序员提交，不需执行'),
(25, 'xj_140429_1.txt', '2014-04-29 19:32:20', 'ALTER TABLE `chengpin_madan_son`\nCHANGE COLUMN `madanId` `cprk2pro`  int(10) NOT NULL COMMENT ''入库明细表id'' AFTER `id`;', '程序员提交，不需执行'),
(26, 'xj_140429_2.txt', '2014-04-29 19:32:33', 'ALTER TABLE `chengpin_cprk`\nDROP COLUMN `ord2proId`,\nDROP COLUMN `cntDuan`,\nDROP COLUMN `cnt`,\nDROP COLUMN `unit`,\nDROP COLUMN `danjia`,\nDROP COLUMN `money`,\nDROP COLUMN `cntKg`,\nMODIFY COLUMN `cprkDate`  date NOT NULL COMMENT ''入库时间'' AFTER `orderId`;', '程序员提交，不需执行'),
(27, 'xj_140429_3.txt', '2014-04-29 19:41:18', 'ALTER TABLE `chengpin_madan_son`\nCHANGE COLUMN `cprk2pro` `cprk2proId`  int(10) NOT NULL COMMENT ''入库明细表id'' AFTER `id`,\nCHANGE COLUMN `cpckId` `cpck2proId`  int(11) NOT NULL COMMENT ''出库明细表id'' AFTER `lot`;', '程序员提交，不需执行'),
(28, 'xj_140429_4.txt', '2014-04-29 19:51:05', 'ALTER TABLE `chengpin_cpck`\nDROP COLUMN `ord2proId`,\nDROP COLUMN `cntDuan`,\nDROP COLUMN `cnt`,\nDROP COLUMN `unit`,\nDROP COLUMN `danjia`,\nDROP COLUMN `money`,\nDROP COLUMN `cntKg`,\nMODIFY COLUMN `cpckDate`  date NOT NULL COMMENT ''成品出库日期'' AFTER `orderId`;', '程序员提交，不需执行'),
(29, 'xj_140429_5.txt', '2014-04-29 19:51:53', 'CREATE TABLE `chengpin_cpck2product` (\n  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT ''出库主表ID'',\n  `chukuId` int(10) NOT NULL,\n  `ord2proId` int(10) NOT NULL COMMENT ''产品编号'',\n  `cntDuan` int(10) NOT NULL COMMENT ''出库件数'',\n  `cnt` decimal(15,2) NOT NULL COMMENT ''原始数量'',\n  `unit` varchar(10) NOT NULL COMMENT ''原始单位'',\n  `danjia` decimal(10,2) NOT NULL COMMENT ''单价'',\n  `money` decimal(15,2) NOT NULL COMMENT ''金额'',\n  `cntKg` decimal(15,1) NOT NULL COMMENT ''折合公斤数'',\n  `memo` varchar(100) NOT NULL COMMENT ''备注'',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT=''成品出库明细表''', '程序员提交，不需执行'),
(30, 'xj_140429_6.txt', '2014-04-29 19:55:09', 'ALTER TABLE `chengpin_cprk2product`\nADD COLUMN `memo`  varchar(100) NOT NULL COMMENT ''备注'' AFTER `dajuanKind`;', '程序员提交，不需执行'),
(31, 'xj_140429_7.txt', '2014-04-29 20:17:12', 'ALTER TABLE `chengpin_cprk2product`\nMODIFY COLUMN `ord2proId`  int(10) NOT NULL COMMENT ''订单明细表id'' AFTER `cntKg`;', '程序员提交，不需执行'),
(32, 'xj_140429_8.txt', '2014-04-29 20:17:25', 'ALTER TABLE `chengpin_cpck2product`\nMODIFY COLUMN `ord2proId`  int(10) NOT NULL COMMENT ''订单明细表ID'' AFTER `chukuId`;', '程序员提交，不需执行'),
(33, 'xj_140429_9.txt', '2014-04-29 20:19:38', 'ALTER TABLE `chengpin_cpck2product`\nADD COLUMN `productId`  int(10) NOT NULL COMMENT ''产品id'' AFTER `chukuId`;', '程序员提交，不需执行'),
(34, 'xj_140429_10.txt', '2014-04-29 20:19:51', 'ALTER TABLE `chengpin_cprk2product`\nADD COLUMN `productId`  int(10) NOT NULL COMMENT ''产品id'' AFTER `cntKg`;', '程序员提交，不需执行'),
(35, 'xj_140513_0.txt', '2014-05-13 13:28:22', 'ALTER TABLE  `caiwu_yf_guozhang` ADD INDEX (  `kind` );', '程序员提交，不需执行'),
(36, 'xj_140504_0.txt', '2014-05-14 16:38:38', 'ALTER TABLE `chengpin_cprk2product`\nMODIFY COLUMN `unit`  varchar(10) CHARACTER SET utf8 NOT NULL COMMENT ''计量单位'' AFTER `cnt`,\nMODIFY COLUMN `memo`  varchar(100) CHARACTER SET utf8 NOT NULL COMMENT ''备注'' AFTER `dajuanKind`;', ''),
(37, 'xj_140505_0.txt', '2014-05-14 16:38:38', 'ALTER TABLE `chengpin_cpck2product`\nMODIFY COLUMN `unit`  varchar(10) CHARACTER SET utf8 NOT NULL COMMENT ''原始单位'' AFTER `cnt`,\nMODIFY COLUMN `memo`  varchar(100) CHARACTER SET utf8 NOT NULL COMMENT ''备注'' AFTER `cntKg`;', ''),
(38, 'xj_140505_1.txt', '2014-05-14 16:38:38', 'ALTER TABLE `chengpin_kucun`\nADD COLUMN `productId`  int(11) NOT NULL COMMENT ''产品id'' AFTER `ord2proId`,\nADD COLUMN `rukuId`  int(11) NOT NULL COMMENT ''入库id'' AFTER `productId`,\nADD COLUMN `chukuId`  int(11) NOT NULL COMMENT ''出库id'' AFTER `rukuId`;', '');

-- --------------------------------------------------------

--
-- 表的结构 `sys_pop`
--

CREATE TABLE IF NOT EXISTS `sys_pop` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `content` text NOT NULL,
  `dateFrom` date NOT NULL COMMENT '其实日期',
  `dateTo` date NOT NULL COMMENT '截止日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='工具箱中设置的弹窗信息' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `sys_pop`
--


-- --------------------------------------------------------

--
-- 表的结构 `sys_set`
--

CREATE TABLE IF NOT EXISTS `sys_set` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item` varchar(20) COLLATE utf8_bin NOT NULL,
  `itemName` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='系统参数设置' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `sys_set`
--


-- --------------------------------------------------------

--
-- 表的结构 `trade_order`
--

CREATE TABLE IF NOT EXISTS `trade_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '类型',
  `orderCode` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '订单号',
  `orderDate` date NOT NULL COMMENT '签订日期',
  `traderId` int(11) NOT NULL COMMENT '业务员ID',
  `traderName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '业务员名字',
  `clientId` int(11) NOT NULL COMMENT '客户ID',
  `lianxiren` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户联系人',
  `clientOrder` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户合同号',
  `xsType` varchar(20) COLLATE utf8_bin NOT NULL,
  `huilv` decimal(10,4) NOT NULL DEFAULT '1.0000' COMMENT '汇率',
  `bizhong` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `overflow` smallint(1) NOT NULL COMMENT '溢短装',
  `pichang` smallint(2) NOT NULL COMMENT '匹长',
  `moneyDayang` decimal(10,2) NOT NULL COMMENT '打样收费',
  `packing` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '包装要求',
  `checking` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '检验要求',
  `warpShrink` smallint(2) NOT NULL COMMENT '经向缩率',
  `weftShrink` smallint(2) NOT NULL COMMENT '纬向缩率',
  `orderItem1` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem2` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem3` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem4` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem5` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem6` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem7` varchar(300) COLLATE utf8_bin NOT NULL,
  `memoTrade` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '经营要求',
  `memoYongjin` varchar(500) COLLATE utf8_bin NOT NULL COMMENT '佣金备注',
  `memoWaigou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '外购备注',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `isOver` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否完成',
  `isCheck` tinyint(1) NOT NULL COMMENT '是否审核',
  `checkPeo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '审核人',
  `checkDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '审核日期',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '制表人(当前用户)',
  PRIMARY KEY (`id`),
  KEY `orderCode` (`orderCode`),
  KEY `orderDate` (`orderDate`),
  KEY `traderId` (`traderId`),
  KEY `clientId` (`clientId`),
  KEY `clientOrder` (`clientOrder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='订单基本信息' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `trade_order`
--

INSERT INTO `trade_order` (`id`, `kind`, `orderCode`, `orderDate`, `traderId`, `traderName`, `clientId`, `lianxiren`, `clientOrder`, `xsType`, `huilv`, `bizhong`, `overflow`, `pichang`, `moneyDayang`, `packing`, `checking`, `warpShrink`, `weftShrink`, `orderItem1`, `orderItem2`, `orderItem3`, `orderItem4`, `orderItem5`, `orderItem6`, `orderItem7`, `memoTrade`, `memoYongjin`, `memoWaigou`, `memo`, `isOver`, `isCheck`, `checkPeo`, `checkDate`, `creater`) VALUES
(1, '', 'DS140417001', '2014-04-17', 1, '', 2, '', 'ox11', '内销', 1.0000, 'USD', 3, 10, 100.00, '无', '无', 3, 3, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决：(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '无', '无', '无', '', 0, 1, '', '2014-04-25 13:36:16', ''),
(3, '', 'DS140418002', '2014-04-18', 1, '', 1, '', 'xj', '外销', 1.0000, 'RMB', 3, 10, 100.00, '无', '无', 3, 3, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决：(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', 'ok', 'ok', 'ok', '', 0, 1, '', '2014-04-25 13:36:33', ''),
(4, '', 'DS140418003', '2014-04-18', 1, '', 1, '', 'xxxnnn', '内销', 1.0000, 'RMB', 1, 1, 1.00, '1', '1', 1, 1, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决：(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '56', '56', '56', '1', 0, 0, '', '2014-04-23 13:41:34', ''),
(8, '', 'DS140423001', '2014-04-23', 2, '', 1, '', 'xx', '外销', 1.0000, '', 1, 1, 1.00, '1', '1', 1, 1, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决：(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '78', '78', '78', '', 0, 0, '', '2014-04-23 15:31:50', ''),
(7, '', 'DS140422002', '2014-04-22', 2, '', 2, '', 'xuejiao', '内销', 1.0000, 'RMB', 11, 11, 11.00, '11', '11', 11, 11, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决：(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '1', '1', '1', '11', 0, 0, '', '0000-00-00 00:00:00', ''),
(9, '', 'DS140423002', '2014-04-23', 2, '', 1, '', 'xx1', '内销', 1.0000, 'RMB', 11, 1, 1.00, '1', '1', 11, 1, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '21', '21', '21', '', 0, 0, '', '2014-05-08 16:19:09', ''),
(11, '', 'DS140508001', '2014-05-08', 1, '', 1, '', '', '内销', 1.0000, '', 0, 0, 0.00, '', '', 0, 0, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '', '', '', '', 0, 0, '', '0000-00-00 00:00:00', ''),
(10, '', 'DS140507001', '2014-05-07', 1, '', 1, '', '1', '外销', 1.0000, 'RMB', 1, 1, 1.00, '1', '1', 11, 1, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '123', '', '', '', 0, 1, '', '2014-05-07 17:04:25', ''),
(12, '', 'DS140508002', '2014-05-08', 1, '', 2, '', '', '', 1.0000, '', 0, 0, 0.00, '', '', 0, 0, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '', '', '', '', 0, 0, '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- 表的结构 `trade_order2product`
--

CREATE TABLE IF NOT EXISTS `trade_order2product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numId` int(10) NOT NULL,
  `orderId` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '订单主表id',
  `chanpinId` int(10) NOT NULL COMMENT '产品Id',
  `supplierId` int(10) NOT NULL COMMENT '供应商Id',
  `menfu` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `cntYaohuo` decimal(10,2) NOT NULL COMMENT '要货数量',
  `dateJiaohuo` date NOT NULL COMMENT '交货日期 ',
  `unit` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '单位(m/y/kg)',
  `danjia` decimal(10,3) NOT NULL COMMENT '单价',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `spic` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '小图路径',
  `bpic` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '大图路径',
  `huaxingMemo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '花型备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `chanpinId` (`chanpinId`),
  KEY `numId` (`numId`),
  KEY `dateJiaohuo` (`dateJiaohuo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='合同与产品的对应表' AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `trade_order2product`
--

INSERT INTO `trade_order2product` (`id`, `numId`, `orderId`, `chanpinId`, `supplierId`, `menfu`, `kezhong`, `cntYaohuo`, `dateJiaohuo`, `unit`, `danjia`, `memo`, `spic`, `bpic`, `huaxingMemo`, `dt`) VALUES
(1, 0, '1', 1, 0, '', '', 11.00, '2014-04-17', '', 11.000, 'xx', '', '', '', '2014-04-23 12:00:22'),
(15, 0, '8', 2, 0, '', '', 88.00, '2014-04-24', '吨', 88.000, '8', '', '', '', '2014-04-23 11:33:00'),
(6, 0, '3', 1, 0, '', '', 100.00, '2014-04-18', '吨', 30.000, '数量100', '', '', '', '2014-04-23 12:00:10'),
(7, 0, '3', 2, 0, '', '', 130.00, '2014-04-18', '吨', 45.000, '数量130', '', '', '', '2014-04-23 12:00:10'),
(8, 0, '4', 1, 0, '', '', 55.00, '2014-04-18', '吨', 55.000, '55', '', '', '', '2014-04-23 12:00:33'),
(14, 0, '8', 1, 0, '', '', 77.00, '2014-04-24', '吨', 77.000, '7', '', '', '', '2014-04-23 11:33:00'),
(12, 0, '7', 1, 0, '', '', 111.00, '2014-04-22', '吨', 111.000, '11', '', '', '', '2014-04-23 12:00:01'),
(13, 0, '7', 2, 0, '', '', 222.00, '2014-04-22', '吨', 222.000, '22', '', '', '', '2014-04-23 12:00:01'),
(16, 0, '9', 1, 0, '', '', 21.00, '2014-04-26', '吨', 21.000, '21', '', '', '', '2014-04-23 16:45:15'),
(17, 0, '10', 1, 0, '', '', 1.00, '2014-05-07', '吨', 2.000, '3', '', '', '', '2014-05-07 17:00:16'),
(18, 0, '10', 4, 0, '', '', 3.00, '2014-05-07', '吨', 4.000, '4', '', '', '', '2014-05-07 17:00:16'),
(19, 0, '10', 1, 0, '', '', 5.00, '2014-05-07', '吨', 6.000, '3', '', '', '', '2014-05-07 17:00:16'),
(20, 0, '10', 4, 0, '', '', 2.00, '2014-05-07', '吨', 3.000, '', '', '', '', '2014-05-07 17:00:16'),
(21, 0, '11', 6, 2, '', '', 11.00, '2014-05-08', '', 11.000, '2', '', '', '', '2014-05-08 18:51:05'),
(22, 0, '12', 3, 1, '', '', 88.00, '2014-05-08', '公斤', 88.000, '8888', '', '', '', '2014-05-08 18:50:03');

-- --------------------------------------------------------

--
-- 表的结构 `yuanliao_cgrk`
--

CREATE TABLE IF NOT EXISTS `yuanliao_cgrk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '入库类型文字说明即可',
  `kuwei` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '库位，一般一笔记录只会有一个库位',
  `rukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '入库单号',
  `songhuoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '送货编号',
  `supplierId` int(10) NOT NULL COMMENT '供应商ID',
  `rukuDate` date NOT NULL COMMENT '入库日期',
  `isGuozhang` int(1) NOT NULL DEFAULT '0' COMMENT '是否过账:0是1否',
  `creater` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `rukuCode` (`rukuCode`),
  KEY `songhuCode` (`songhuoCode`),
  KEY `supplierId` (`supplierId`),
  KEY `rukuDate` (`rukuDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱采购入库' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `yuanliao_cgrk`
--

INSERT INTO `yuanliao_cgrk` (`id`, `kind`, `kuwei`, `rukuCode`, `songhuoCode`, `supplierId`, `rukuDate`, `isGuozhang`, `creater`, `dt`, `memo`) VALUES
(3, '采购入库', '2', 'YR140428001', '234123', 1, '2014-04-28', 0, '', '2014-04-28 18:21:41', '41234'),
(4, '采购入库', '2', 'YR140428001', '234123', 1, '2014-04-28', 0, '', '2014-04-28 18:22:42', '41234'),
(5, '其他入库', '1', 'YR140428002', '22', 1, '2014-04-28', 0, '', '2014-04-28 18:57:28', '22'),
(6, '', '3', 'YR140510001', '', 1, '2014-05-10', 0, '', '2014-05-10 11:17:10', '');

-- --------------------------------------------------------

--
-- 表的结构 `yuanliao_cgrk2product`
--

CREATE TABLE IF NOT EXISTS `yuanliao_cgrk2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rukuId` int(10) NOT NULL COMMENT '入库Id',
  `productId` int(10) NOT NULL COMMENT '原料产品id',
  `pihao` varchar(50) NOT NULL COMMENT '批号',
  `cnt` decimal(15,2) NOT NULL COMMENT '数量',
  `danjia` decimal(15,1) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  `memo` varchar(100) NOT NULL COMMENT '注释',
  `return4id` int(11) NOT NULL COMMENT '退库时相关入库id',
  `type` int(10) NOT NULL COMMENT '原料类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='入库子表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `yuanliao_cgrk2product`
--

INSERT INTO `yuanliao_cgrk2product` (`id`, `rukuId`, `productId`, `pihao`, `cnt`, `danjia`, `money`, `memo`, `return4id`, `type`) VALUES
(3, 3, 3, '1', 1.00, 0.0, 0.00, '1', 0, 0),
(4, 4, 3, '1', 1.00, 0.0, 0.00, '1', 0, 0),
(5, 5, 3, '11', 11.00, 9.0, 99.00, '11', 0, 0),
(7, 6, 3, 'H1452014', 15.00, 8.0, 120.00, '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yuanliao_kucun`
--

CREATE TABLE IF NOT EXISTS `yuanliao_kucun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateFasheng` date DEFAULT NULL COMMENT '发生日期',
  `rukuId` int(11) NOT NULL COMMENT '入库表id',
  `chukuId` int(11) NOT NULL COMMENT '出库表id',
  `kind` varchar(10) NOT NULL COMMENT '出入库类型',
  `kuwei` varchar(10) NOT NULL COMMENT '库位',
  `type` int(1) NOT NULL COMMENT '原料类型',
  `pihao` varchar(50) NOT NULL COMMENT '批号',
  `supplierId` int(11) NOT NULL COMMENT '供应商id',
  `productId` int(11) NOT NULL COMMENT '原料id',
  `cntFasheng` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `danjiaFasheng` decimal(15,2) NOT NULL COMMENT '单价',
  `moneyFasheng` decimal(15,2) NOT NULL COMMENT '金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='原料库存表' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `yuanliao_kucun`
--

INSERT INTO `yuanliao_kucun` (`id`, `dateFasheng`, `rukuId`, `chukuId`, `kind`, `kuwei`, `type`, `pihao`, `supplierId`, `productId`, `cntFasheng`, `danjiaFasheng`, `moneyFasheng`) VALUES
(1, '2014-04-28', 4, 0, '', '2', 0, '1', 1, 3, 1.00, 0.00, 0.00),
(20, '2014-04-30', 0, 8, '', '1', 0, '1', 1, 1, -100.00, 0.00, -100.00),
(27, '2014-04-28', 5, 0, '', '1', 0, '11', 1, 3, 11.00, 0.00, 99.00),
(18, '2014-04-30', 0, 9, '', '2', 0, '2', 2, 1, -100.00, 0.00, -200.00),
(22, '2014-04-30', 0, 10, '', '3', 0, '3', 2, 1, -100.00, 0.00, -300.00),
(26, '2014-05-10', 7, 0, '', '3', 0, 'H1452014', 1, 3, 15.00, 0.00, 120.00);

-- --------------------------------------------------------

--
-- 表的结构 `yuanliao_llck`
--

CREATE TABLE IF NOT EXISTS `yuanliao_llck` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '出库类型，文字说明即可',
  `orderId` int(10) NOT NULL COMMENT '订单id',
  `kuwei` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '库位',
  `yuanyin` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '出库原因',
  `chukuDate` date NOT NULL COMMENT '出库日期',
  `depId` int(10) NOT NULL COMMENT '部门id',
  `clientId` int(10) NOT NULL COMMENT '客户id',
  `supplierId` int(11) NOT NULL COMMENT '供应商id',
  `chukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出库单号',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `chukuDate` (`chukuDate`),
  KEY `supplierId` (`supplierId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='原料出库登记' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `yuanliao_llck`
--

INSERT INTO `yuanliao_llck` (`id`, `kind`, `orderId`, `kuwei`, `yuanyin`, `chukuDate`, `depId`, `clientId`, `supplierId`, `chukuCode`, `memo`, `creater`, `dt`) VALUES
(7, '其他出库', 3, '2', '2', '2014-04-30', 1, 0, 2, 'YC140430002', '2', '', '2014-04-30 11:01:10'),
(6, '采购出库', 3, '1', '1', '2014-04-30', 1, 2, 1, 'YC140430001', '1', '', '2014-04-30 10:59:58'),
(8, '生产领用', 3, '3', '3', '2014-04-30', 1, 0, 2, 'YC140430003', '3', '', '2014-04-30 11:17:18');

-- --------------------------------------------------------

--
-- 表的结构 `yuanliao_llck2product`
--

CREATE TABLE IF NOT EXISTS `yuanliao_llck2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `chukuId` int(10) NOT NULL COMMENT ' 出库id',
  `productId` int(10) NOT NULL COMMENT '原料产品id',
  `pihao` varchar(50) NOT NULL COMMENT '批号',
  `cnt` decimal(15,2) NOT NULL COMMENT '数量',
  `danjia` decimal(15,1) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  `type` int(10) NOT NULL COMMENT '原料类型',
  `memo` varchar(100) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='出库子表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `yuanliao_llck2product`
--

INSERT INTO `yuanliao_llck2product` (`id`, `chukuId`, `productId`, `pihao`, `cnt`, `danjia`, `money`, `type`, `memo`) VALUES
(8, 6, 1, '1', 100.00, 1.0, 100.00, 0, '1'),
(9, 7, 1, '2', 100.00, 2.0, 200.00, 0, '2'),
(10, 8, 1, '3', 100.00, 3.0, 300.00, 0, '3');
