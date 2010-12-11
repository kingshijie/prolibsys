-- phpMyAdmin SQL Dump
-- version 3.3.7deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 12 月 02 日 21:31
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知识点' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_knowledge`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_major`
--

CREATE TABLE IF NOT EXISTS `plib_major` (
  `mid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `mname` varchar(20) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='科目' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_major`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_paper`
--

CREATE TABLE IF NOT EXISTS `plib_paper` (
  `paid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `construction` text NOT NULL,
  `timeNeed` tinyint(3) unsigned NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='题库' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_prolib`
--


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


-- --------------------------------------------------------

--
-- 表的结构 `plib_protype`
--

CREATE TABLE IF NOT EXISTS `plib_protype` (
  `typeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tname` varchar(20) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='题型' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_protype`
--


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
  `title` varchar(40) NOT NULL,
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

