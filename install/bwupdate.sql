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