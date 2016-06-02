<?php


function xoops_module_update_twitterbomb(&$module) {
	
	$recovery = array();
	$sql = array();
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `type` ENUM('bomb','scheduler', 'retweet') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `cron` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `rids` VARCHAR(750) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `picids` VARCHAR(750) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` CHANGE COLUMN `type` `type` ENUM('bomb','scheduler','retweet','reply','mention', 'pictures') DEFAULT 'bomb'";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler')."` ADD COLUMN `pregmatch_replace` VARCHAR(500) DEFAULT NULL";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `type` ENUM('bomb','secheduler','retweet','reply','mention') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `source_nick` VARCHAR(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `tweeted` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `id` VARCHAR(128) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `avarta` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `name` VARCHAR(128) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `description` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `indexed` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `followed` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `actioned` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `oid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` CHANGE COLUMN `twitter_username` `screen_name` VARCHAR(64) DEFAULT NULL";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `oid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `tid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `id` VARCHAR(128) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `tags` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `cid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `catid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `rank` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` CHANGE COLUMN `provider` `provider` ENUM('bomb','scheduler','retweet','reply','mention', 'pictures') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `rid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `picid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `about_id` INT(13) UNSIGNED DEFAULT '0'";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base1` `base1` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base2` `base2` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base3` `base3` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base4` `base4` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base5` `base5` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base6` `base6` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base7` `base7` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` ADD COLUMN `id` VARCHAR(255) DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` ADD COLUMN `friends` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` ADD COLUMN `mentions` INT(13) UNSIGNED DEFAULT '0'";
	
$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler')."` (
  `sid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0',
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `mode` ENUM('direct','filtered','pregmatch','strip','pregmatchstrip','strippregmatch','filteredstrip','stripfiltered','filteredpregmatch','pregmatchfiltered','filteredpregmatchstrip','filteredstrippregmatch','pregmatchfilteredstrip','pregmatchstripfiltered','strippregmatchfiltered','stripfilteredpregmatch','mirc') DEFAULT 'direct',
  `pre` VARCHAR(35) DEFAULT NULL,
  `text` VARCHAR(500) DEFAULT NULL,
  `search` VARCHAR(1000) DEFAULT NULL,
  `replace` VARCHAR(1000) DEFAULT NULL,
  `strip` VARCHAR(1000) DEFAULT NULL,
  `pregmatch` VARCHAR(500) DEFAULT NULL,
  `pregmatch_replace` VARCHAR(500) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `hits` INT(13) UNSIGNED DEFAULT '0',
  `rank` INT(13) UNSIGNED DEFAULT '0',
  `when` INT(13) UNSIGNED DEFAULT '0',
  `tweeted` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (`sid`),
  KEY `COMMON` (`cid`,`catid`,`mode`,`pre`(15),`text`(15),`search`(15),`replace`(15),`strip`(15),`pregmatch`(15),`pregmatch_replace`(15),`uid`,`hits`,`rank`,`when`,`tweeted`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_pictures')."` (
	`picid` int(20) unsigned NOT NULL auto_increment,
	`search` varchar(128) default NULL,
	`skip` varchar(128) default 'RT',
	`width` int(13) unsigned default '0',
	`height` int(13) unsigned default '0',
	`mcid` int(13) unsigned default '0',
	`geocode` tinyint(1) unsigned default '0',
	`longitude` decimal(10,6) default '0.000000',
	`latitude` decimal(10,6) default '0.000000',
	`radius` int(13) unsigned default '0',
	`measurement` enum('mi','km') default 'km',
	`language` enum('aa','ab','af','am','ar','AS','ay','az','ba','be','bg','bh','bi','bn','bo','br','ca','co','cs','cy','da','de','dz','el','en','eo','es','et','eu','fa','fi','fj','fo','fr','fy','ga','gd','gl','gn','gu','ha','he','hi','hr','hu','hy','ia','id','ie','ik','IS','it','iu','ja','jw','ka','kk','kl','km','kn','ko','ks','ku','ky','la','LN','lo','lt','lv','mg','mi','mk','ml','mn','mo','mr','ms','mt','my','na','ne','nl','NO','oc','om','OR','pa','pl','ps','pt','qu','rm','rn','ro','ru','rw','sa','sd','sg','sh','si','sk','sl','sm','sn','so','sq','sr','ss','st','su','sv','sw','ta','te','tg','th','ti','tk','tl','tn','TO','tr','ts','tt','tw','ug','uk','ur','uz','vi','vo','wo','xh','yi','yo','za','zh','zu') default 'en',
	`type` enum('mixed','recent','popular') default 'mixed',
	`uid` int(13) unsigned default '0',
	`pictures` int(13) unsigned default '0',
	`searched` int(13) unsigned default '0',
	`pictured` int(13) unsigned default '0',
	`created` int(13) unsigned default '0',
	`updated` int(13) unsigned default '0',
	`actioned` int(13) unsigned default '0',
	PRIMARY KEY  (`picid`),
	KEY `COMMON` (`search`(15),`skip`(15),`geocode`,`longitude`,`latitude`,`radius`,`measurement`,`language`,`type`,`uid`,`pictures`,`searched`,`created`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";

	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` (	
  `lid` int(13) unsigned NOT NULL auto_increment,
  `provider` enum('bomb','scheduler','retweet','reply','mention','pictures') default 'bomb',
  `cid` int(13) unsigned default '0',
  `catid` int(13) unsigned default '0',
  `uid` int(13) unsigned default '0',
  `sid` int(13) unsigned default '0',
  `oid` int(13) unsigned default '0',
  `tid` int(13) unsigned default '0',
  `rid` int(13) unsigned default '0',
  `rpid` int(13) unsigned default '0',
  `mid` int(13) unsigned default '0',
  `picid` int(13) unsigned default '0',
  `alias` varchar(64) default NULL,
  `tweet` varchar(140) default NULL,
  `url` varchar(500) default NULL,
  `date` int(13) unsigned default '0',
  `hits` int(13) unsigned default '0',
  `rank` int(13) unsigned default '0',
  `active` int(13) unsigned default '0',
  `tags` varchar(255) default NULL,
  `id` bigint(42) default NULL,
  `about_id` int(13) unsigned default '0',
  PRIMARY KEY  (`lid`),
  KEY `COMMON` (`provider`,`alias`,`tweet`(15),`url`(15),`date`,`cid`,`catid`,`hits`,`rank`,`active`,`tags`(25),`id`,`rid`,`about_id`),
  KEY `COMMON_INDEX` (`lid`,`provider`,`uid`,`sid`,`oid`,`tid`,`cid`,`catid`,`hits`,`rank`,`active`,`id`,`rid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";

	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` (
  `oid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cids` VARCHAR(1000) DEFAULT NULL,
  `catids` VARCHAR(1000) DEFAULT NULL,
  `mode` ENUM('valid','invalid','expired','disabled','other') DEFAULT NULL,
  `consumer_key` VARCHAR(255) DEFAULT NULL,
  `consumer_secret` VARCHAR(255) DEFAULT NULL,
  `oauth_token` VARCHAR(255) DEFAULT NULL,
  `oauth_token_secret` VARCHAR(255) DEFAULT NULL,
  `username` VARCHAR(64) DEFAULT NULL,
  `id` VARCHAR(255) DEFAULT '0',
  `ip` VARCHAR(64) DEFAULT NULL,
  `netbios` VARCHAR(255) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `tweeted` INT(13) UNSIGNED DEFAULT '0',
  `friends` INT(13) UNSIGNED DEFAULT '0',
  `mentions` INT(13) UNSIGNED DEFAULT '0',
  `tweets` INT(13) UNSIGNED DEFAULT '0',
  `calls` INT(13) UNSIGNED DEFAULT '0',
  `remaining_hits` INT(13) UNSIGNED DEFAULT '0',
  `hourly_limit` INT(13) UNSIGNED DEFAULT '0',
  `api_resets` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (`oid`),
  KEY `COMMON` (`cids`(25),`catids`(25),`mode`,`consumer_key`(15),`consumer_secret`(15),`oauth_token`(15),`oauth_token_secret`(15),`username`(15),`id`(15),`ip`(15),`netbios`(15),`uid`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_following')."` (
  `fid` int(20) unsigned NOT NULL auto_increment,
  `id` varchar(128) default NULL,
  `flid` varchar(128) default NULL,
  `followed` int(13) unsigned default '0',
  `created` int(13) unsigned default '0',
  `updated` int(13) unsigned default '0',
  `actioned` int(13) unsigned default '0',
  PRIMARY KEY  (`fid`),
  KEY `COMMON` (`id`(25),`flid`(25),`followed`),
  KEY `SECONDARY` (`id`(12),`flid`(12),`followed`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";

	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_retweet')."` (
  `rid` int(20) unsigned NOT NULL auto_increment,
  `search` varchar(128) default NULL,
  `skip` varchar(128) default 'RT',
  `geocode` tinyint(1) unsigned default '0',
  `longitude` decimal(10,6) default '0.000000',
  `latitude` decimal(10,6) default '0.000000',
  `radius` int(13) unsigned default '0',
  `measurement` enum('mi','km') default 'km',
  `language` enum('aa','ab','af','am','ar','AS','ay','az','ba','be','bg','bh','bi','bn','bo','br','ca','co','cs','cy','da','de','dz','el','en','eo','es','et','eu','fa','fi','fj','fo','fr','fy','ga','gd','gl','gn','gu','ha','he','hi','hr','hu','hy','ia','id','ie','ik','IS','it','iu','ja','jw','ka','kk','kl','km','kn','ko','ks','ku','ky','la','LN','lo','lt','lv','mg','mi','mk','ml','mn','mo','mr','ms','mt','my','na','ne','nl','NO','oc','om','OR','pa','pl','ps','pt','qu','rm','rn','ro','ru','rw','sa','sd','sg','sh','si','sk','sl','sm','sn','so','sq','sr','ss','st','su','sv','sw','ta','te','tg','th','ti','tk','tl','tn','TO','tr','ts','tt','tw','ug','uk','ur','uz','vi','vo','wo','xh','yi','yo','za','zh','zu') default 'en',
  `type` enum('mixed','recent','popular') default 'mixed',
  `uid` int(13) unsigned default '0',
  `retweets` int(13) unsigned default '0',
  `searched` int(13) unsigned default '0',
  `created` int(13) unsigned default '0',
  `updated` int(13) unsigned default '0',
  `actioned` int(13) unsigned default '0',
  `retweeted` int(13) unsigned default '0',
  PRIMARY KEY  (`rid`),
  KEY `COMMON` (`search`(15),`skip`(15),`geocode`,`longitude`,`latitude`,`radius`,`measurement`,`language`,`type`,`uid`,`retweets`,`searched`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql['onfail_truncate_A_1'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_retweet')."` ADD KEY `COMMON` (`search`(15),`skip`(15),`geocode`,`longitude`,`latitude`,`radius`,`measurement`,`language`,`type`,`uid`,`retweets`,`searched`,`created`)";
	$sql['onfail_truncate_A_2'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_following')."` ADD KEY `COMMON` (`id`(25),`flid`(25),`followed`)";
	$sql['onfail_truncate_A_3'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_following')."` ADD KEY `SECONDARY` (`id`(12),`flid`(12),`followed`,`created`)";
	$sql['onfail_truncate_A_4'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` ADD KEY `COMMON` (`cids`(25),`catids`(25),`mode`,`consumer_key`(15),`consumer_secret`(15),`oauth_token`(15),`oauth_token_secret`(15),`username`(15),`id`(15),`ip`(15),`netbios`(15),`uid`,`created`)";
	$sql['onfail_truncate_A_5'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD KEY `COMMON` (`catid`,`name`(15),`start`,`end`,`timed`,`hits`,`uid`,`created`)";
	$sql['onfail_truncate_A_6'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD KEY `COMMON` (`pcatdid`,`name`(15),`hits`,`uid`,`created`,`updated`,`active`)";
	$sql['onfail_truncate_A_7'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD KEY `COMMON` (`cid`,`oid`,`catid`,`screen_name`(15),`id`(12),`name`(25),`uid`,`indexed`,`followed`)";
	$sql['onfail_truncate_A_8'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_urls')."` ADD KEY `COMMON` (`cid`,`catid`,`surl`(25),`name`(25),`uid`,`created`)";
	$sql['onfail_truncate_A_9'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD KEY `COMMON` (`provider`,`alias`,`tweet`(15),`url`(15),`date`,`cid`,`catid`,`hits`,`rank`,`active`,`tags`(25),`id`(15),`rid`,`about_id`)";
	$sql['onfail_truncate_A_10'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD KEY `COMMON_INDEX` (`lid`,`provider`,`uid`,`sid`,`oid`,`tid`,`cid`,`catid`,`hits`,`rank`,`active`,`id`(15),`rid`)";
	$sql['onfail_truncate_A_11'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler')."` ADD KEY `COMMON` (`cid`,`catid`,`mode`,`pre`(15),`text`(15),`search`(15),`replace`(15),`strip`(15),`pregmatch`(15),`pregmatch_replace`(15),`uid`,`hits`,`rank`,`when`,`tweeted`,`created`)";
	$sql['onfail_truncate_A_12'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_keywords')."` ADD KEY `COMMON` (`cid`,`catid`,`base`,`keyword`(15),`uid`,`created`)";
	$sql['onfail_truncate_A_13'] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` ADD KEY `COMMON` (`cid`,`catid`,`base1`,`base2`,`base3`,`base4`,`base5`,`base6`,`base7`,`uid`,`created`)";
	
	$recovery['onfail']['truncate']['A']['1']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_retweet').'';
	$recovery['onfail']['truncate']['A']['2']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_following').'';
	$recovery['onfail']['truncate']['A']['3']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_following').'';
	$recovery['onfail']['truncate']['A']['4']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth').'';
	$recovery['onfail']['truncate']['A']['5']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign').'';
	$recovery['onfail']['truncate']['A']['6']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_category').'';
	$recovery['onfail']['truncate']['A']['7']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames').'';
	$recovery['onfail']['truncate']['A']['8']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_urls').'';
	$recovery['onfail']['truncate']['A']['9']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_log').'';
	$recovery['onfail']['truncate']['A']['10']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_log').'';
	$recovery['onfail']['truncate']['A']['11']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler').'';
	$recovery['onfail']['truncate']['A']['12']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_keywords').'';
	$recovery['onfail']['truncate']['A']['13']['A'] = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix').'';
	
	$recovery['onfail']['truncate']['A']['1']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_retweet').'';
	$recovery['onfail']['truncate']['A']['2']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_following').'';
	$recovery['onfail']['truncate']['A']['3']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_following').'';
	$recovery['onfail']['truncate']['A']['4']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth').'';
	$recovery['onfail']['truncate']['A']['5']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign').'';
	$recovery['onfail']['truncate']['A']['6']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_category').'';
	$recovery['onfail']['truncate']['A']['7']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames').'';
	$recovery['onfail']['truncate']['A']['8']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_urls').'';
	$recovery['onfail']['truncate']['A']['9']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_log').'';
	$recovery['onfail']['truncate']['A']['10']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_log').'';
	$recovery['onfail']['truncate']['A']['11']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler').'';
	$recovery['onfail']['truncate']['A']['12']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_keywords').'';
	$recovery['onfail']['truncate']['A']['13']['B'] = 'TRUNCATE '.$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix').'';

	$recovery['onfail']['truncate']['A']['1']['C'] = $sql['onfail_truncate_A_1'];
	$recovery['onfail']['truncate']['A']['2']['C'] = $sql['onfail_truncate_A_2'];
	$recovery['onfail']['truncate']['A']['3']['C'] = $sql['onfail_truncate_A_3'];
	$recovery['onfail']['truncate']['A']['4']['C'] = $sql['onfail_truncate_A_4'];
	$recovery['onfail']['truncate']['A']['5']['C'] = $sql['onfail_truncate_A_5'];
	$recovery['onfail']['truncate']['A']['6']['C'] = $sql['onfail_truncate_A_6'];
	$recovery['onfail']['truncate']['A']['7']['C'] = $sql['onfail_truncate_A_7'];
	$recovery['onfail']['truncate']['A']['8']['C'] = $sql['onfail_truncate_A_8'];
	$recovery['onfail']['truncate']['A']['9']['C'] = $sql['onfail_truncate_A_9'];
	$recovery['onfail']['truncate']['A']['10']['C'] = $sql['onfail_truncate_A_10'];
	$recovery['onfail']['truncate']['A']['11']['C'] = $sql['onfail_truncate_A_11'];
	$recovery['onfail']['truncate']['A']['12']['C'] = $sql['onfail_truncate_A_12'];
	$recovery['onfail']['truncate']['A']['13']['C'] = $sql['onfail_truncate_A_13'];
	
	$recovery['onfail']['truncate']['A']['1']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_retweet').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['2']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_following').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['3']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_following').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['4']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['5']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['6']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_category').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['7']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['8']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_urls').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['9']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_log').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['10']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_log').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['11']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['12']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_keywords').' (%s) VALUES (%s)';
	$recovery['onfail']['truncate']['A']['13']['D'] = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix').' (%s) VALUES (%s)';
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` CHANGE COLUMN `id` `id` bigint(42) default '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` CHANGE COLUMN `id` `id` bigint(42) default '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` CHANGE COLUMN `rids` `rids` varchar(750) default ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `rpids` varchar(750) default ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `mids` varchar(750) default ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `cron` tinyint(4) unsigned default '1'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_following')."` CHANGE COLUMN `id` `id` bigint(42) default '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_following')."` CHANGE COLUMN `flid` `flid` bigint(42) default '0'";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_replies')."` (
  `rpid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0',
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `urlid` INT(13) UNSIGNED DEFAULT '0',
  `rcid` INT(13) UNSIGNED DEFAULT '0',
  `reply` VARCHAR(140) DEFAULT NULL,
  `keywords` VARCHAR(500) DEFAULT NULL,
  `type` enum('bomb','reply') default 'reply',
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `replies` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  `replied` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (`rpid`),
  KEY `COMMON` (`cid`,`catid`,`keywords`(45),`type`,`uid`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";

	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_mentions')."` (
  `mid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0',
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `user` VARCHAR(64) DEFAULT NULL,
  `keywords` VARCHAR(500) DEFAULT NULL,
  `geocode` tinyint(1) unsigned default '0',
  `longitude` decimal(10,6) default '0.000000',
  `latitude` decimal(10,6) default '0.000000',
  `radius` int(13) unsigned default '0',
  `measurement` enum('mi','km') default 'km',
  `language` enum('aa','ab','af','am','ar','AS','ay','az','ba','be','bg','bh','bi','bn','bo','br','ca','co','cs','cy','da','de','dz','el','en','eo','es','et','eu','fa','fi','fj','fo','fr','fy','ga','gd','gl','gn','gu','ha','he','hi','hr','hu','hy','ia','id','ie','ik','IS','it','iu','ja','jw','ka','kk','kl','km','kn','ko','ks','ku','ky','la','LN','lo','lt','lv','mg','mi','mk','ml','mn','mo','mr','ms','mt','my','na','ne','nl','NO','oc','om','OR','pa','pl','ps','pt','qu','rm','rn','ro','ru','rw','sa','sd','sg','sh','si','sk','sl','sm','sn','so','sq','sr','ss','st','su','sv','sw','ta','te','tg','th','ti','tk','tl','tn','TO','tr','ts','tt','tw','ug','uk','ur','uz','vi','vo','wo','xh','yi','yo','za','zh','zu') default 'en',
  `type` enum('mixed','recent','popular') default 'mixed',
  `rpids` VARCHAR(750) DEFAULT NULL,  
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `mentions` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `mentioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (`mid`),
  KEY `COMMON` (`cid`,`catid`,`keywords`(45),`type`,`uid`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	foreach($sql as $id => $question) {
		$GLOBALS['xoopsDB']->close();	
		$GLOBALS['xoopsDB']->connect(true);
		if ($GLOBALS['xoopsDB']->queryF($question))
			xoops_error($question, 'SQL Executed Successfully!!!');
		else {
			switch ($GLOBALS['xoopsDB']->errno()) {
				default:
					//xoops_error($question, 'Error Number: '.$GLOBALS['xoopsDB']->errno().' - SQL Did Not Executed! ('.$GLOBALS['xoopsDB']->error().'!!!)');
					break;
				case 2006:
				case 1317:
					set_time_limit($GLOBALS['seconds_executed']=$GLOBALS['seconds_executed']+60);
					$setting = explode('_', $id);
					if (count($setting)==4) {
						foreach($recovery[$setting[0]][$setting[1]][$setting[2]][$setting[3]] as $option => $recoveryquestion) {
							if (strpos(' '.$recoveryquestion, 'SELECT * FROM')>0) {
								$GLOBALS['xoopsDB']->close();	
								$GLOBALS['xoopsDB']->connect(true);								
								$result = $GLOBALS['xoopsDB']->queryF($recoveryquestion);
								$i=0;
								$md5tag = md5($setting[0].$setting[1].$setting[2].$setting[3]);
								while($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
									$i++;
									XoopsCache::write('twitterbomb_dump_'.$md5tag.'_'.$i, $row, 36000);
								} 
								XoopsCache::write('twitterbomb_dump_'.$md5tag, $i, 36000);
								xoops_error('Executed SQL '.$recoveryquestion.'<br/>Dumped '.$i.' Records for Recovery', 'SQL Recovery Executed!');
							} elseif (strpos(' '.$recoveryquestion, 'INSERT INTO')>0) {
								$GLOBALS['xoopsDB']->close();	
								$GLOBALS['xoopsDB']->connect(true);
								$md5tag = md5($setting[0].$setting[1].$setting[2].$setting[3]);
								if ($amount = XoopsCache::read('twitterbomb_dump_'.$md5tag)) {
									for($i=1;$i<$amount;$i++) {
										if ($row = XoopsCache::read('twitterbomb_dump_'.$md5tag.'_'.$i)) {
											$k=0;
											$fields = '';
											$values = '';
											foreach($row as $field => $value) {
												$k++;
												$fields .= "`".$field."`".(count($row)<$k?", ":'');
												$values .= $GLOBALS['xoopsDB']->quote($value).(count($row)<$k?", ":'');
											}
											$result = $GLOBALS['xoopsDB']->queryF(sprintf($recoveryquestion, $fields, $values));			
										}
										XoopsCache::delete('twitterbomb_dump_'.$md5tag.'_'.$i);
									}
								}
								xoops_error('Executed SQL '.$recoveryquestion.'<br/>Restored '.$amount.' Records from Dump, deleted temporary files', 'SQL Recovery Executed!');
							} else {
								$GLOBALS['xoopsDB']->close();	
								$GLOBALS['xoopsDB']->connect(true);
								if (!$GLOBALS['xoopsDB']->queryF($recoveryquestion)) {
									xoops_error($question, 'Error Number: '.$GLOBALS['xoopsDB']->errno().' - SQL Recovery Executed! ('.$GLOBALS['xoopsDB']->error().'!!!)');
								} else {
									xoops_error($question, 'SQL Recovery Executed Successfully!');
								}
							}
							
						}			
					}							
					break;
			}
		
		}
	}
	return true;
	
}

?>