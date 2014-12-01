-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-11-27 10:37:51
-- 服务器版本： 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cyg`
--

-- --------------------------------------------------------

--
-- 表的结构 `cyg_admin`
--

CREATE TABLE IF NOT EXISTS `cyg_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `real_name` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `roles` varchar(256) NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `last_login_time` int(10) unsigned NOT NULL,
  `last_login_ip` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cyg_admin_log`
--

CREATE TABLE IF NOT EXISTS `cyg_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `actor` varchar(32) NOT NULL,
  `operate` varchar(64) NOT NULL,
  `related_id` varchar(128) NOT NULL,
  `detail` varchar(64) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cyg_role`
--

CREATE TABLE IF NOT EXISTS `cyg_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) NOT NULL,
  `actions` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
