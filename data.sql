CREATE TABLE `ezhamon_fields` (`id` varchar(30) NOT NULL default '',`title` varchar(50) NOT NULL default '',`caption` varchar(10) NOT NULL default '', PRIMARY KEY  (`id`)	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ezhamon_monitor` (	  `sid` bigint(20) unsigned NOT NULL default '0',	  `google_pr` char(1) NOT NULL default '0',	  `yandex_cy` varchar(7) NOT NULL default '0',	  `yandex_pages_index` varchar(20) NOT NULL default '0',	  `google_pages_index` varchar(20) NOT NULL default '0',	  `rambler_pages_index` varchar(20) NOT NULL default '0',	  `yandex_references` varchar(20) NOT NULL default '0',	  `google_links` varchar(20) NOT NULL default '0', `yahoo_pages_index` varchar(20) NOT NULL default '', `yahoo_links` varchar(20) NOT NULL default '', `li_day_vis` varchar(20) NOT NULL default '', `timestamp` bigint(20) NOT NULL default '0'	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ezhamon_sites` (`sid` bigint(20) unsigned NOT NULL auto_increment, `url` varchar(40) NOT NULL default '', `active` tinyint(4) NOT NULL default '1', PRIMARY KEY  (`sid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;
INSERT INTO `ezhamon_fields` VALUES ('google_pr', 'PR', 'PR');
INSERT INTO `ezhamon_fields` VALUES ('yandex_cy', 'ИЦ', 'ИЦ');
INSERT INTO `ezhamon_fields` VALUES ('yandex_pages_index', 'Проиндексировано Яндекс', 'YP');
INSERT INTO `ezhamon_fields` VALUES ('google_pages_index', 'Проиндексировано Google', 'GP');
INSERT INTO `ezhamon_fields` VALUES ('rambler_pages_index', 'Проиндексировано Рамблер', 'RP');
INSERT INTO `ezhamon_fields` VALUES ('yandex_references', 'Ссылки Яндекс', 'YL');
INSERT INTO `ezhamon_fields` VALUES ('google_links', 'Ссылки Google', 'GL');
INSERT INTO `ezhamon_fields` VALUES ('yahoo_pages_index', 'Проиндексировано Yahoo', 'YAHP');
INSERT INTO `ezhamon_fields` VALUES ('yahoo_links', 'Ссылки Yahoo', 'YAHL');
INSERT INTO `ezhamon_fields` VALUES ('li_day_vis', 'Хостов', 'Хостов');