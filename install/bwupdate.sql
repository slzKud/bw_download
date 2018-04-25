CREATE TABLE `bw_filelinks` (
  `FileID` int(11) NOT NULL,
  `LinkDesc` varchar(255) DEFAULT NULL,
  `B64Links` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `bw_chkid` (
  `chkid` varchar(255) NOT NULL,
  `chkname` varchar(255) NOT NULL,
  `motherid` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `bw_downtable` ADD `chkid` VARCHAR(255) CHARACTER SET utf8  utf8_general_ci NULL AFTER `adddate`;