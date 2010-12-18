-- phpMyAdmin SQL Dump
-- version 3.3.7deb2build0.10.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 12 月 18 日 21:36
-- 服务器版本: 5.1.49
-- PHP 版本: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `prolib`
--

-- --------------------------------------------------------

--
-- 表的结构 `plib_group`
--

CREATE TABLE IF NOT EXISTS `plib_group` (
  `groupid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `plib_group`
--

INSERT INTO `plib_group` (`groupid`, `groupname`) VALUES
(1, '超级管理员'),
(2, '普通管理员');

-- --------------------------------------------------------

--
-- 表的结构 `plib_group_permission`
--

CREATE TABLE IF NOT EXISTS `plib_group_permission` (
  `groupid` smallint(6) unsigned NOT NULL,
  `perid` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`groupid`,`perid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-权限 对照表';

--
-- 转存表中的数据 `plib_group_permission`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_knowledge`
--

CREATE TABLE IF NOT EXISTS `plib_knowledge` (
  `kid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `kname` varchar(20) NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='知识点' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `plib_knowledge`
--

INSERT INTO `plib_knowledge` (`kid`, `kname`, `mid`) VALUES
(1, '英国历史', 1),
(2, '美国历史', 1);

-- --------------------------------------------------------

--
-- 表的结构 `plib_major`
--

CREATE TABLE IF NOT EXISTS `plib_major` (
  `mid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `mname` varchar(20) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='科目' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `plib_major`
--

INSERT INTO `plib_major` (`mid`, `mname`) VALUES
(1, '英语视听说'),
(2, '英语四级');

-- --------------------------------------------------------

--
-- 表的结构 `plib_paper`
--

CREATE TABLE IF NOT EXISTS `plib_paper` (
  `paid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `construction` text NOT NULL,
  `timeNeed` tinyint(3) unsigned NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`paid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='试卷' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_paper`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_permission`
--

CREATE TABLE IF NOT EXISTS `plib_permission` (
  `perid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pername` varchar(20) NOT NULL,
  PRIMARY KEY (`perid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_permission`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_prolib`
--

CREATE TABLE IF NOT EXISTS `plib_prolib` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `ans` text NOT NULL,
  `typeid` tinyint(3) unsigned NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  `autocheck` tinyint(1) NOT NULL COMMENT '0-客观题 1-主观题',
  `isexer` tinyint(1) NOT NULL COMMENT '0-考试 1-练习',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='题库' AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `plib_prolib`
--

INSERT INTO `plib_prolib` (`pid`, `description`, `ans`, `typeid`, `mid`, `autocheck`, `isexer`) VALUES
(1, 'Which of the following is not a characteristic of the Englishman?#1#4#The Englishman is outspoken.#He is class-conscious.#He is suspicous of change.#He is racist.', 'A', 1, 1, 1, 0),
(2, '#、#and#were the three Germanic tribes that came to be the basis of modern English race.', 'tom#jerry#randy', 2, 1, 1, 1),
(3, '3考试管理：1）添加考试、添加考试组3）编辑、删除试卷\r\n	1）关联考试用户组，考试时间判断有无已过期\r\n	流程：选择考试成员（运用用户组）-》选择考试试卷-》设置考试开始时间、结束时间', 'xiexienidewendu', 3, 1, 0, 1),
(4, '2试卷管理：1）添加试卷，编辑、删除试卷\r\n	1）选择科目，填考试标题，选择题型，由知识点列出可选题目\r\n	流程：选择考试科目-》填试卷标题-》点添加考题类型，填考题类型标题-》在考题类型中点添加题目*注一*-》列出所有该科目该题型的题-》选择知识点-》过滤题目  或  *注一*-》点新增题目-》跳入新增题目模块', 'hahahahahahahkfjsadkljrwesjkfv', 5, 1, 1, 1),
(5, 'Today is sunday.Let''s see what will happen!这是组合题的例子，看看能不能用吧#1#2#3#4', 'A#asdfsgs#sdfsagsfwe#gghassdf', 4, 1, 1, 0),
(6, 'Who can benefit from business competition? #1#4#Honest businessmen. #Both businessmen and their customers. #People with ideals of equality and freedom. #Both business institutions and government. ', 'A', 1, 1, 1, 0),
(7, 'Research findings show we spend about two hours dreaming every night, no matter what we # during the day. ', 'big', 2, 1, 0, 0),
(8, 'Research findings show we spend about two hours dreaming every night, no matter what we # during the day. ', 'big', 2, 1, 0, 0),
(9, 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', 'kkkkkkkkkkkkkkkkkkkkkkkkkjjjjjjjjjjjjjjjjjjjjjjjjjjj', 3, 2, 0, 0),
(10, 'kjh#1##', '', 1, 2, 0, 0),
(11, 'kjh#1##', '', 1, 2, 0, 0),
(12, 'jklnjnkjbnjkbkj', 'jkh', 5, 2, 0, 0),
(13, 'jjbkjbkj', 'bkjbhjvhjv', 2, 1, 0, 0),
(14, 'jnkjnj', 'jhkjhk', 3, 1, 0, 0),
(15, 'hj', 'kjhub', 2, 1, 0, 0),
(16, 'jjj', 'jjj', 2, 1, 0, 0),
(17, 'jjj', 'jjj', 2, 1, 0, 0),
(18, '好机会库 ', '很快集合', 2, 1, 0, 0),
(19, '好机会库 ', '很快集合', 2, 1, 0, 0),
(20, '哈哈哈', '科技后', 2, 1, 0, 0),
(21, 'sb#1#2#yes#no', 'A', 1, 1, 0, 0),
(22, 'bbbb', 'jjjjjj', 2, 1, 0, 0),
(23, 'nknkn', 'njkbnkjb', 2, 1, 0, 0),
(24, '君不见就', '君不见环保局后', 2, 1, 0, 0),
(25, '看看看看看看看看看看看看', '斤斤计较斤斤计较斤斤计较就', 3, 1, 0, 0),
(26, '交换机后', '获奖拷贝后', 5, 1, 0, 0),
(27, '撒娇发那我就课三大疯狂就科技阿斯#25#26', '', 4, 1, 0, 0),
(28, 'sdkfjewklnzxjkvaewfsag#0#2#sdgsda#sdgsdaf', 'SDAFWEXXZC', 1, 1, 1, 0),
(29, 'big apple#28', '', 4, 1, 0, 0),
(30, 'sdfas', 'sdagsdf', 3, 1, 0, 0),
(31, '#28#30', '', 4, 1, 0, 0),
(32, 'sadgsdaa编号', 'gsadfas', 3, 1, 0, 0),
(33, 'sadgsad', 'fsadf', 5, 1, 0, 0),
(34, '测试哈哈哈哈#32#33', '', 4, 1, 0, 0),
(35, 'F#1#5#FD#DF#SFD#EF/DS#SDF', 'FS', 1, 1, 1, 0),
(36, 'F#1#4#FDS#A#S#B', 'A', 1, 1, 0, 0),
(37, '纷纷的#1#4#的#发#4#23', '2', 1, 1, 0, 0),
(38, '纷纷的#1#4#34#64#345#345', '啊', 1, 1, 0, 0),
(39, '来#1#4#fg3#453#234#435', '1', 1, 1, 0, 0),
(40, '#32#33#39', '', 4, 1, 0, 0),
(41, 'agfasdf#1##', 'SD', 1, 1, 0, 0),
(42, 'haohaozuoren#32#33#41', '', 4, 1, 0, 0),
(43, 'fdsf#1##', 'DSF', 1, 1, 0, 0),
(44, 'sdf#1##', 'SDAF', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `plib_prolib_knowledge`
--

CREATE TABLE IF NOT EXISTS `plib_prolib_knowledge` (
  `pid` int(10) unsigned NOT NULL,
  `kid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`pid`,`kid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='题-知识点 对照表';

--
-- 转存表中的数据 `plib_prolib_knowledge`
--

INSERT INTO `plib_prolib_knowledge` (`pid`, `kid`) VALUES
(8, 1),
(8, 2),
(13, 2),
(14, 2),
(15, 2),
(21, 1),
(22, 2),
(23, 2),
(25, 2),
(26, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(33, 1),
(34, 1),
(34, 2),
(35, 1),
(40, 1),
(40, 2),
(41, 1),
(45, 1),
(46, 1);

-- --------------------------------------------------------

--
-- 表的结构 `plib_protype`
--

CREATE TABLE IF NOT EXISTS `plib_protype` (
  `typeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tname` varchar(20) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='题型' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `plib_protype`
--

INSERT INTO `plib_protype` (`typeid`, `tname`) VALUES
(1, '选择题'),
(2, '填空题'),
(3, '简答题'),
(4, '组合题'),
(5, '名词解释');

-- --------------------------------------------------------

--
-- 表的结构 `plib_result`
--

CREATE TABLE IF NOT EXISTS `plib_result` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `ans` text NOT NULL,
  `score` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生做题结果' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_result`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_test`
--

CREATE TABLE IF NOT EXISTS `plib_test` (
  `tid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `paid` mediumint(8) unsigned NOT NULL,
  `stime` datetime NOT NULL,
  `etime` datetime NOT NULL,
  `groupids` text NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='考试' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_test`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_user`
--

CREATE TABLE IF NOT EXISTS `plib_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `uname` varchar(18) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `plib_user`
--

INSERT INTO `plib_user` (`uid`, `username`, `password`, `uname`) VALUES
(1, 'admin', 'b605e86d02eef8bfd0646f6a704c17c9', 'admin'),
(2, 'randy', '97f2469de75d40552ef281d18ca56970', 'Randy');

-- --------------------------------------------------------

--
-- 表的结构 `plib_user_group`
--

CREATE TABLE IF NOT EXISTS `plib_user_group` (
  `uid` mediumint(8) unsigned NOT NULL,
  `groupid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户-用户组 对照表';

--
-- 转存表中的数据 `plib_user_group`
--

INSERT INTO `plib_user_group` (`uid`, `groupid`) VALUES
(1, 1);
