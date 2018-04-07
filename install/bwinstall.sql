-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2018-04-07 19:59:43
-- 服务器版本： 5.6.36-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bw_download`
--

-- --------------------------------------------------------

--
-- 表的结构 `bw_admituser`
--

CREATE TABLE IF NOT EXISTS `bw_admituser` (
  `Id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `oldper` int(11) NOT NULL DEFAULT '1',
  `newper` int(11) NOT NULL DEFAULT '1',
  `nowtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ifs` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `bw_baneduser`
--

CREATE TABLE IF NOT EXISTS `bw_baneduser` (
  `Id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `btime` int(11) NOT NULL DEFAULT '-1',
  `ifclose` int(11) DEFAULT '1',
  `nowdate` datetime DEFAULT '1970-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `bw_downloadhistory`
--

CREATE TABLE IF NOT EXISTS `bw_downloadhistory` (
  `Id` int(11) NOT NULL,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `downuser` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `downtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bw_downtable`
--

CREATE TABLE IF NOT EXISTS `bw_downtable` (
  `Id` int(11) NOT NULL,
  `FileName` varchar(255) NOT NULL DEFAULT '',
  `Download` varchar(255) NOT NULL DEFAULT '',
  `Permisson` int(11) NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bw_ftp`
--

CREATE TABLE IF NOT EXISTS `bw_ftp` (
  `Id` int(11) NOT NULL,
  `account` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bw_ip`
--

CREATE TABLE IF NOT EXISTS `bw_ip` (
  `Id` int(11) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `loc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bw_pinfile`
--

CREATE TABLE IF NOT EXISTS `bw_pinfile` (
  `Id` int(11) NOT NULL,
  `fileid` int(11) DEFAULT '0',
  `ifok` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bw_settings`
--

CREATE TABLE IF NOT EXISTS `bw_settings` (
  `Id` int(11) NOT NULL,
  `SetName` varchar(255) NOT NULL DEFAULT '',
  `SetValue` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bw_usertable`
--

CREATE TABLE IF NOT EXISTS `bw_usertable` (
  `Id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `passmd5` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `lastip` varchar(255) DEFAULT NULL,
  `lastlogindate` datetime DEFAULT NULL,
  `regdate` datetime DEFAULT '2016-06-07 09:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bw_admituser`
--
ALTER TABLE `bw_admituser`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_baneduser`
--
ALTER TABLE `bw_baneduser`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_downloadhistory`
--
ALTER TABLE `bw_downloadhistory`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_downtable`
--
ALTER TABLE `bw_downtable`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_ftp`
--
ALTER TABLE `bw_ftp`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_ip`
--
ALTER TABLE `bw_ip`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_pinfile`
--
ALTER TABLE `bw_pinfile`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_settings`
--
ALTER TABLE `bw_settings`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `bw_usertable`
--
ALTER TABLE `bw_usertable`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bw_admituser`
--
ALTER TABLE `bw_admituser`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_baneduser`
--
ALTER TABLE `bw_baneduser`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_downloadhistory`
--
ALTER TABLE `bw_downloadhistory`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_downtable`
--
ALTER TABLE `bw_downtable`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_ftp`
--
ALTER TABLE `bw_ftp`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_ip`
--
ALTER TABLE `bw_ip`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_pinfile`
--
ALTER TABLE `bw_pinfile`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_settings`
--
ALTER TABLE `bw_settings`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bw_usertable`
--
ALTER TABLE `bw_usertable`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;