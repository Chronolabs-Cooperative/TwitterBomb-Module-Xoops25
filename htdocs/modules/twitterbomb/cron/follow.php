<?php

include_once('../../../mainfile.php');
$GLOBALS['xoopsLogger']->activated = false;
if (!defined('NLB')) {
	if (!isset($_SERVER['HTTP_HOST']))
		define('NLB', "\n");
	else 
		define('NLB', "<br/>");
}

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$GLOBALS['twitterbombModule'] = $module_handler->getByDirname('twitterbomb');
$GLOBALS['twitterbombModuleConfig'] = $config_handler->getConfigList($GLOBALS['twitterbombModule']->getVar('mid'));

if (!isset($GLOBALS['cron_run_for']))
	$GLOBALS['cron_run_for'] = ceil($GLOBALS['twitterbombModuleConfig']['interval_of_cron'] / (($GLOBALS['twitterbombModuleConfig']['cron_follow']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_gather']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0)));
$GLOBALS['cron_start'] = microtime(true);

if ($GLOBALS['twitterbombModuleConfig']['cron_follow']) {
	echo 'Follower Cron Started: '.date('Y-m-d D H:i:s', time()).NLB;
	xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	$campaign_handler = xoops_getmodulehandler('campaign', 'twitterbomb');
	$following_handler=&xoops_getmodulehandler('following', 'twitterbomb');
	$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
	$oauth_handler=&xoops_getmodulehandler('oauth', 'twitterbomb');
	
	$oauth = $oauth_handler->getRootOauth(true);
	if (!is_object($oauth)) {
		xoops_error('Critical Error: No OAuth Root Object');
		echo 'Follower Cron Ended: '.date('Y-m-d D H:i:s', time()).NLB;
		return false;
	}
	$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 120;
	set_time_limit($GLOBALS['execution_time']);
	
	$criteria = new Criteria('followed', 0, '=');
	$criteria->setLimit($GLOBALS['twitterbombModuleConfig']['follow_per_session']);
	$usernames = $usernames_handler->getObjects($criteria, true);
	foreach($usernames as $uid => $username) {
		if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for'])
			continue;
		if ($username->getVar('id') == 0) {
			$user = $oauth->getUsers($username->getVar('screen_name'), 'screen_name');
			$username->setVar('id', $user['id']);		
			$username->setVar('avarta', $user['profile_image_url']);
			$username->setVar('name', $user['name']);
			$username->setVar('description', $user['description']);
			$usernames_handler->insert($username, true);		
		}
		if ($user = $oauth->createFollow($username->getVar('id'))) {
			echo 'Followed: '.$username->getVar('screen_name').NLB;
			$username->setVar('followed', time());
			$usernames_handler->insert($username, true);
		} else {
			echo 'Follow Failed: '.$username->getVar('screen_name').NLB;
		}
	}
	echo 'Follower Cron Ended: '.date('Y-m-d D H:i:s', time()).NLB;
}

?>