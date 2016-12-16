
CREATE TABLE `bw_downtable` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FileName` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `Download` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `Permisson` int(11) NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_ftp` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_ip` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `loc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SetName` varchar(255) NOT NULL DEFAULT '',
  `SetValue` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_usertable` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `passmd5` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `lastip` varchar(255) DEFAULT NULL,
  `lastlogindate` datetime DEFAULT NULL,
  `regdate` datetime DEFAULT '2016-06-07 09:00:00',
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_downloadhistory` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `downuser` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `downtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_baneduser` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `btime` int(11) NOT NULL DEFAULT '-1',
  `ifclose` int(11) DEFAULT '1',
  `nowdate` datetime DEFAULT '1970-01-01 00:00:00',
  PRIMARY KEY (`Id`)
); 

CREATE TABLE `bw_admituser` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `oldper` int(11) NOT NULL DEFAULT '1',
  `newper` int(11) NOT NULL DEFAULT '1',
  `nowtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ifs` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
);

CREATE TABLE `bw_pinfile` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) DEFAULT '0',
  `ifok` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
);