<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */
if (!defined('NLB')) {
	if (!isset($_SERVER['HTTP_HOST']))
		define('NLB', "\n");
	else 
		define('NLB', "<br/>");
}

ini_set('memory_limit', '256M');
include_once('../../../mainfile.php');
include_once(XOOPS_ROOT_PATH.'/modules/twitterbomb/include/functions.php');
$GLOBALS['xoopsLogger']->activated = false;
error_reporting(E_ALL);
ini_set("log_errors" , "1");
ini_set("error_log" , XOOPS_ROOT_PATH."/uploads/cron.errors.log.".md5(XOOPS_ROOT_PATH).".txt");
ini_set("display_errors" , "1");


$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$GLOBALS['twitterbombModule'] = $module_handler->getByDirname('twitterbomb');
$GLOBALS['twitterbombModuleConfig'] = $config_handler->getConfigList($GLOBALS['twitterbombModule']->getVar('mid'));
$GLOBALS['myalbumModule'] = $module_handler->getByDirname($GLOBALS['twitterbombModuleConfig']['myalbum_dirname']);
if (is_object($GLOBALS['myalbumModule'])) {
	$GLOBALS['myalbumModuleConfig'] = $config_handler->getConfigList($GLOBALS['myalbumModule']->getVar('mid'));
}		
if (!isset($GLOBALS['cron_run_for']))
	$GLOBALS['cron_run_for'] = ceil($GLOBALS['twitterbombModuleConfig']['interval_of_cron'] / (($GLOBALS['twitterbombModuleConfig']['cron_follow']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_gather']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0)));
$GLOBALS['cron_start'] = microtime(true);

if ($GLOBALS['twitterbombModuleConfig']['cron_tweet']||$GLOBALS['twitterbombModuleConfig']['cron_retweet']) {
	echo 'Tweeter Cron Started: '.date('Y-m-d D H:i:s', time()).NLB;
	xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	$scheduler_handler=&xoops_getmodulehandler('scheduler', 'twitterbomb');
	$base_matrix_handler=&xoops_getmodulehandler('base_matrix', 'twitterbomb');
	$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
	$urls_handler=&xoops_getmodulehandler('urls', 'twitterbomb');
	$campaign_handler = xoops_getmodulehandler('campaign', 'twitterbomb');
	$retweet_handler=&xoops_getmodulehandler('retweet', 'twitterbomb');
	$replies_handler=&xoops_getmodulehandler('replies', 'twitterbomb');
	$mention_handler=&xoops_getmodulehandler('mentions', 'twitterbomb');
	$pictures_handler=&xoops_getmodulehandler('pictures', 'twitterbomb');
	
	$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
	@$oauth = $oauth_handler->getRootOauth(true);
	if (!is_object($oauth)) {
		xoops_error('Critical Error: No OAuth Root Object');
		echo 'Tweeter Cron Ended: '.date('Y-m-d D H:i:s', time()).NLB;
		return false;
	}
	
	if (!$cids = XoopsCache::read('twitterbomb_cids_cron')) {
		$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
		$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
		$criteria_b->add(new Criteria('start', time(), '<'));
		$criteria_b->add(new Criteria('end', time(), '>'));
		$criteria = new CriteriaCompo($criteria_a);
		$criteria->add($criteria_b, 'OR');
	} else {
		XoopsCache::delete('twitterbomb_cids_cron');
		$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
		$criteria_a->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
		$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
		$criteria_b->add(new Criteria('start', time(), '<'));
		$criteria_b->add(new Criteria('end', time(), '>'));
		$criteria_b->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
		$criteria = new CriteriaCompo($criteria_a);
		$criteria->add($criteria_b, 'OR');
	}
	$types = array();
	if ($GLOBALS['twitterbombModuleConfig']['cron_reply']) {
		$types[] = 'reply';
	}
	if ($GLOBALS['twitterbombModuleConfig']['cron_mention']) {
		$types[] = 'mention';
	}
	if ($GLOBALS['twitterbombModuleConfig']['cron_retweet']) {
		$types[] = 'retweet';
	}
	if ($GLOBALS['twitterbombModuleConfig']['cron_pictures']) {
		$types[] = 'pictures';
	}
	if ($GLOBALS['twitterbombModuleConfig']['cron_tweet']) {
		$types[] = 'scheduler';
		$types[] = 'bomber';
	}	
	$criteria->add(new Criteria('`type`', '("'.implode('","',$types).'")', 'IN'));
	$criteria->add(new Criteria('`cron`', true), 'AND');
	$criteria->setOrder(mt_rand(0,1)==1?'ASC':'DESC');
	$criteria->setSort('RAND()');
	$campaigns = $campaign_handler->getObjects($criteria, true);
	$campaignCount = $campaign_handler->getCount($criteria);
	if ($campaignCount==0) {
		XoopsCache::delete('twitterbomb_cids_cron');
		$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
		$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
		$criteria_b->add(new Criteria('start', time(), '<'));
		$criteria_b->add(new Criteria('end', time(), '>'));
		$criteria = new CriteriaCompo($criteria_a);
		$criteria->add($criteria_b, 'OR');
		if ($GLOBALS['twitterbombModuleConfig']['cron_retweet']&&$GLOBALS['twitterbombModuleConfig']['cron_tweet']) {
			$criteria->add(new Criteria('`type`', '("scheduler", "bomber", "retweet")', 'IN')); 
		} elseif ($GLOBALS['twitterbombModuleConfig']['cron_tweet']) {
			$criteria->add(new Criteria('`type`', '("scheduler", "bomber")', 'IN'));
		} elseif ($GLOBALS['twitterbombModuleConfig']['cron_retweet']) {
			$criteria->add(new Criteria('`type`', '("retweet")', 'IN'));		
		}
		$criteria->setOrder(mt_rand(0,1)==1?'ASC':'DESC');
		$criteria->setSort('RAND()');
		$campaigns = $campaign_handler->getObjects($criteria, true);
		$campaignCount = $campaign_handler->getCount($criteria);
	}
	while ($c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&$loopsb<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))*1.75&&$campaignCount>0) {
		if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
			return endtweeter($cids);
		}
		$loopsb++;
		$cids=array();
		foreach($campaigns as $cid => $campaign) {
			$cids[$cid] = $cid;	
		}
		foreach($campaigns as $cid => $campaign) {
			unset ($cids[$cid]);
			XoopsCache::write('twitterbomb_cids_cron', $cids, 3600*48);
			if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
				return endtweeter($cids);
			}
			$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 45;
			set_time_limit($GLOBALS['execution_time']);
			$catid = $campaign->getVar('catid');
			if ($c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))) {
				if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
					return endtweeter($cids);
				}
				$campaign->setCron();
				echo $campaign->getVar('type');
				switch($campaign->getVar('type')) {
					case "bomb":
						if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
							return endtweeter($cids);
						}
						$ret = XoopsCache::read('tweetbomb_channel_last');
						if (!isset($ret['last']))
							$ret = array('last'=>time()-(60*65));
						if (isset($ret['last']))
							if ($ret['last']+(60*60)<time()) {
								$item=0;
								$items = 0;
								$loop=0;
								$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
								while((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['items']))*2>$loop) {
									if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
										return endtweeter($cids);
									}
									$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 15;
									set_time_limit($GLOBALS['execution_time']);
									$sentence = $base_matrix_handler->getSentence($cid, $catid);
									$username = $usernames_handler->getUser($cid, $catid);
									$url = $urls_handler->getUrl($cid, $catid);
									$sourceuser = $usernames_handler->getSourceUser($cid, $catid, $sentence);
									if ((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
										if (strlen($sentence)>0) {
											$mtr=mt_rand($GLOBALS['twitterbombModuleConfig']['odds_lower'],$GLOBALS['twitterbombModuleConfig']['odds_higher']);
											$tweet = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').(strlen($username)>0&&($mtr<=$GLOBALS['twitterbombModuleConfig']['odds_minimum']||$mtr>=$GLOBALS['twitterbombModuleConfig']['odds_maximum'])?'#'.$username.' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence), $GLOBALS['twitterbombModuleConfig']['aggregate'], $GLOBALS['twitterbombModuleConfig']['wordlength']))));
											$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
									   		$log = $log_handler->create();
									   		$log->setVar('cid', $cid);
									   		$log->setVar('catid', $catid);
									   		$log->setVar('provider', $campaign->getVar('type'));
									   		$log->setVar('url', $ret[$c]['link']);
									   		$log->setVar('tweet', substr($tweet,0,139));
									  		$log->setVar('tags', twitterbomb_ExtractTags($tweet));
									   		$lid = $log_handler->insert($log, true);
									   		$log = $log_handler->get($lid, true);
									   		$link = XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence))));
									   		$link = twitterbomb_shortenurl($link);
									   		$log->setVar('url', $link);
									   		$log = $log_handler->get($lid = $log_handler->insert($log, true));
									   		if ($id = $oauth->sendTweet($tweet, $link, true)) {
									   			echo 'Tweet Sent: '.$tweet.' - '.$link.NLB;
										   		if ($GLOBALS['twitterbombModuleConfig']['tags']) {
										   			$tag_handler = xoops_getmodulehandler('tag', 'tag');
													$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $GLOBALS['twitterbombModule']->getVar("dirname"), $catid);
										   		}
										   		$log->setVar('id', $id);
										   		$lid = $log_handler->insert($log, true);
										   		$ret[]['title'] = $tweet;	  
												$ret[sizeof($ret)-1]['link'] = $link;
												$ret[sizeof($ret)-1]['description'] = (strlen($username)>0&&($mtr<=$GLOBALS['twitterbombModuleConfig']['odds_minimum']||$mtr>=$GLOBALS['twitterbombModuleConfig']['odds_maximum'])?'@'.$username.' ':'').htmlspecialchars_decode($sentence);
												$ret[sizeof($ret)-1]['lid'] = $lid;
												$item++;
									   		} else {
									   			echo 'Tweet Failed: '.$tweet.' - '.$link.NLB;
									   			$log_handler->delete($log, true);
									   		}
									   		$c++;
									   		$items++;
										}
									}
									$loop++;
								}
								if (count($ret)>$GLOBALS['twitterbombModuleConfig']['items']) {
									foreach($ret as $key => $value) {
										if (count($ret)>$GLOBALS['twitterbombModuleConfig']['items'])
											unset($ret[$key]);
									}
								}	
								XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']+$GLOBALS['twitterbombModuleConfig']['cache']);
							} else {
								$loopsb++;
							}
						break;
					case "scheduler":
						if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
							return endtweeter($cids);
						}
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_channel_last');
						if (!isset($ret['last']))
							$ret = array('last'=>time()-(60*65));
						if (isset($ret['last']))
							if ($ret['last']+(60*60)<time()) {
								$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
								while((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['scheduler_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['scheduler_items']))*2>$loop) {
									$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 15;
									set_time_limit($GLOBALS['execution_time']);
									if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
										return endtweeter($cids);
									}
									$sentence = $scheduler_handler->getTweet($cid, $catid, 0, 0);
									if ((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
										if (is_array($sentence)) {
											$sourceuser = $usernames_handler->getSourceUser($cid, $catid, $sentence['tweet']);
											$url = $urls_handler->getUrl($cid, $catid);
											$tweet = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', $sentence['tweet'])));	  
											$link = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$tweet))));
											if (strlen($tweet)!=0) {
												$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
								    			$log = $log_handler->create();
								    			$log->setVar('provider', $campaign->getVar('type'));
								    			$log->setVar('cid', $cid);
								    			$log->setVar('catid', $catid);
								    			$log->setVar('sid', $ret[$c]['sid']);
								    			$log->setVar('url', $link);
								    			$log->setVar('tweet', substr($tweet,0,139));
								    			$log->setVar('tags', twitterbomb_ExtractTags($tweet));
								    			$lid = $log_handler->insert($log, true);
												$log = $log_handler->get($lid, true);
										   		$link = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
										   		$link = twitterbomb_shortenurl($link);
										   		$log->setVar('url', $link);
										   		$log = $log_handler->get($lid = $log_handler->insert($log, true));
										   		if ($id = $oauth->sendTweet($tweet, $link, true)) {
										   			echo 'Tweet Sent: '.$tweet.' - '.$link.NLB;
											   		if ($GLOBALS['twitterbombModuleConfig']['tags']) {
														$tag_handler = xoops_getmodulehandler('tag', 'tag');
														$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $GLOBALS['twitterbombModule']->getVar("dirname"), $catid);
									    			}
									    			$log->setVar('id', $id);
										   			$lid = $log_handler->insert($log, true);
										   	   		$ret[]['title'] = $tweet;	  
													$ret[sizeof($ret)-1]['link'] = $link;
													$ret[sizeof($ret)-1]['description'] = htmlspecialchars_decode($sentence['tweet']);
													$ret[sizeof($ret)-1]['lid'] = $lid;
													$ret[sizeof($ret)-1]['sid'] = $sentence['sid'];
													$item++;
										   		} else {
										   			echo 'Tweet Failed: '.$tweet.' - '.$link.NLB;
										   			$scheduler = $scheduler_handler->get($sentence['sid']);
										   			if (is_object($scheduler)) {
										   				$scheduler->setVar('when', 0);
										   				$scheduler_handler->insert($scheduler);
										   			}
										   			@$log_handler->delete($log, true);
										   		}
								    			$c++;
										   		$items++;
								    		}
										}
									}
									$loop++;
								}
								if (count($ret)>$GLOBALS['twitterbombModuleConfig']['scheduler_items']) {
									foreach($ret as $key => $value) {
										if (count($ret)>$GLOBALS['twitterbombModuleConfig']['scheduler_items'])
											unset($ret[$key]);
									}
								}						
								XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']+$GLOBALS['twitterbombModuleConfig']['scheduler_cache']);
							} else {
								$loopsb++;
							}
						break;
					case "retweet":
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_channel_last');
						if (!isset($ret['last']))
							$ret = array('last'=>time()-(60*65));
						if (isset($ret['last']))
							if ($ret['last']+(60*60)<time()) { 

							$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
							while((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
								if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
									return endtweeter($cids);
								}
								$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 30;
								set_time_limit($GLOBALS['execution_time']);
								$search = $retweet_handler->doSearchForTweet($cid, $catid, $campaign->getVar('rids'));
								if (is_array($search)) {
									foreach ($search as $rid => $results) {
										if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
											return endtweeter($cids);
										}
										if (!empty($results)) {
											foreach($results as $id => $tweet) {
												if ((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
													if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
														return endtweeter($cids);
													}
													$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 15;
													set_time_limit($GLOBALS['execution_time']);
													if (is_array($tweet)) {
														$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
														$pass=true;
														$criteria = new Criteria('id', $id);
														if ($log_handler->getCount($criteria)==0&&$pass==true) {
															$log = $log_handler->create();
															$log->setVar('provider', $campaign->getVar('type'));
															$log->setVar('cid', $cid);
															$log->setVar('catid', $catid);
															$log->setVar('alias', '@'.$tweet['from_user']);
															$log->setVar('rid', $rid);
															$log->setVar('id', $id);
															$log->setVar('url', '');
															$log->setVar('tweet', substr($tweet['text'],0,140));
															$log->setVar('tags', twitterbomb_ExtractTags($tweet['text']));
															$log = $log_handler->get($lid = $log_handler->insert($log, true));
															if ($retweet = $oauth->sendRetweet($id, true)) {
																$retweet_handler->setReweeted($rid);
																echo 'Retweet Sent: '.$id.' - '.$tweet['text'].NLB;
																if ($GLOBALS['twitterbombModuleConfig']['tags']) {
																	$tag_handler = xoops_getmodulehandler('tag', 'tag');
																	$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet['text']), $lid, $GLOBALS['twitterbombModule']->getVar("dirname"), $catid);
																}
																$url = $urls_handler->getUrl($cid, $catid);
																$link = XOOPS_URL.'/modules/twitterbomb/go.php?rid='.$rid.'&cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$tweet['text']))));
																$criteria = new Criteria('`screen_name`', $tweet['from_user']);
																if ($usernames_handler->getCount($criteria)==0) {
																	$username = $usernames_handler->create();
																	$username->setVar('screen_name', $tweet['from_user']);
																	$username->setVar('type' , 'bomb');
																	$tid = $usernames_handler->insert($username,  true);
																} else {
																	$usernames = $usernames_handler->getObjects($criteria, false);
																	if (is_object($usernames[0]))
																		$tid = $usernames[0]->getVar('tid');
																	else 
																		$tid = 0;
																}
																$log->setVar('tweet', substr($retweet['text'],0,140));
																$log->setVar('url', $link);
																$log->setVar('tid', $tid);
																$log_handler->insert($log, true);
																$ret[]['title'] = $retweet['text'];	  
																$ret[sizeof($ret)-1]['link'] = $link;
																$ret[sizeof($ret)-1]['description'] = htmlspecialchars_decode($retweet['text']);
																$ret[sizeof($ret)-1]['lid'] = $lid;
																$ret[sizeof($ret)-1]['rid'] = $rid;
																$item++;
																$c++;
																$items++;
															} else {
																echo 'Retweet Failed(api): '.$id.' - '.$tweet['text'].NLB;
																@$log_handler->delete($log, true);
															}
														} else {
															if ($pass==false)
																echo 'Retweet Failed (exceptions): ';
															else 
																echo 'Retweet Failed (exists): ';
															echo $id.' - '.$tweet['text'].NLB;
														}
													}
												}
											}
										}
									}
								}
								$loop++;
							}
							if (count($ret)>$GLOBALS['twitterbombModuleConfig']['retweet_items']) {
								foreach($ret as $key => $value) {
									if (count($ret)>$GLOBALS['twitterbombModuleConfig']['retweet_items'])
										unset($ret[$key]);
								}
							}
							XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']+$GLOBALS['twitterbombModuleConfig']['retweet_cache']);
						} else {
							$loopsb++;
						}
						break;
					case "pictures":
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_channel_last');
						if (!isset($ret['last']))
							$ret = array('last'=>time()-(60*65));
						if (isset($ret['last']))
							if ($ret['last']+(60*60)<time()) {
					
							$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
							while((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['pictures_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['picturess_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['picturess_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items'])/$GLOBALS['twitterbombModuleConfig']['pictures_items']))*2>$loop) {
								if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0))) {
									return endtweeter($cids);
								}
								$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 30;
								set_time_limit($GLOBALS['execution_time']);
								$search = $pictures_handler->doSearchForPictureCrawl($cid, $catid, $campaign->getVar('picids'));
								if (is_array($search)) {
									foreach ($search as $picid => $results) {
										if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0))) {
											return endtweeter($cids);
										}
										if (!empty($results)) {
											foreach($results as $id => $picture) {
												if ((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['picturess_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['pictures_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['picturess_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['picturess_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items'])/$GLOBALS['twitterbombModuleConfig']['pictures_items']))*2>$loop) {
													if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0))) {
														return endtweeter($cids);
													}
													$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 15;
													set_time_limit($GLOBALS['execution_time']);
													if (is_array($tweet)) {
														$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
														$pass=true;
														$criteria = new Criteria('id', $picture['id']);
														if ($log_handler->getCount($criteria)==0&&$pass==true) {
															$log = $log_handler->create();
															$log->setVar('provider', $campaign->getVar('type'));
															$log->setVar('cid', $cid);
															$log->setVar('catid', $catid);
															$log->setVar('alias', '@'.$picture['user']);
															$log->setVar('picid', $picid);
															$log->setVar('id', $picture['id']);
															$log->setVar('url', $picture['url']);
															$log->setVar('tweet', substr($picture['text'],0,140));
															$log->setVar('tags', twitterbomb_ExtractTags($picture['text']));
															$log = $log_handler->get($lid = $log_handler->insert($log, true));
															$photos_handler = xoops_getmodulehandler('photos', $GLOBALS['twitterbombModuleConfig']['myalbum_dirname']);
															$text_handler = xoops_getmodulehandler('text', $GLOBALS['twitterbombModuleConfig']['myalbum_dirname']);
															foreach(twitterbomb_getLargestImages($picture['url'], $picture['width'], $picture['height']) as $uri) {
																$photo = $photos_handler->create();
																$photo->setVar('title', substr($picture['text'],0,97).'...');
																$photo->setVar('ext', 'jpg');
																$photo->setVar('status', $GLOBALS['twitterbombModuleConfig']['myalbum_status']);
																$photo->setVar('cid', $picture['cid']);
																$photo->setVar('date', time());
																$photo->setVar('submitter', $picture['submitter']);
																$photo = $photos_handler->get($pid = $photos_handler->insert($photo));
																if ($dimensions = twitterbomb_downloadImage($uri, $pid)) {
																	$photo->setVar('res_x', $dimensions[0]);
																	$photo->setVar('res_y', $dimensions[1]);
																	$pid = $photos_handler->insert($photo);
																	$text = $text_handler->create();
																	$text->setVar('lid', $pid);
																	$text->setVar('description', sprintf("From: http://twitter.com/%s<br/>Tweet: %s", $picture['user'], $picture['text']));
																	$text_handler->insert($text);
																	if ($GLOBALS['twitterbombModuleConfig']['tags']) {
																		$tag_handler = xoops_getmodulehandler('tag', 'tag');
																		$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet['text']), $lid, $GLOBALS['twitterbombModule']->getVar("dirname"), $catid);
																	}
																	if ($GLOBALS['myalbumModuleConfig']['tags']) {
																		$tag_handler = xoops_getmodulehandler('tag', 'tag');
																		$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet['text']), $pid, $GLOBALS['myalbumModule']->getVar("dirname"), $picture['cid']);
																	}
																	echo 'Picture Retrieved: '.$uri.' - '.$picture['text'].NLB;
																} else {
																	echo 'Picture Failed: '.$uri.' - '.$picture['text'].NLB;
																	@$photos_handler->delete($photo, true);
																	@$log_handler->delete($log, true);
																}
															}
														}
													}
												}
											}
										}
									}
								}
								$loop++;
							}
							if (count($ret)>$GLOBALS['twitterbombModuleConfig']['pictures_items']) {
								foreach($ret as $key => $value) {
									if (count($ret)>$GLOBALS['twitterbombModuleConfig']['pictures_items'])
										unset($ret[$key]);
								}
							}
							XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']+$GLOBALS['twitterbombModuleConfig']['pictures_cache']);
						} else {
							$loopsb++;
						}
						break;
					
					case "reply":
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_channel_last');
						if (!isset($ret['last']))
							$ret = array('last'=>time()-(60*65));
						if (isset($ret['last']))
							if ($ret['last']+(60*60)<time()) { 

							$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
							while((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
								if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
									return endtweeter($cids);
								}
								$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 30;
								set_time_limit($GLOBALS['execution_time']);
								$search = $retweet_handler->doSearchForTweet($cid, $catid, $campaign->getVar('rids'));
								if (is_array($search)) {
									foreach ($search as $rid => $results) {
										if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
											return endtweeter($cids);
										}
										if (!empty($results)) {
											foreach($results as $id => $tweet) {
												if ((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
													if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
														return endtweeter($cids);
													}
													$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 15;
													set_time_limit($GLOBALS['execution_time']);
													if (is_array($tweet)) {
														$reply = $replies_handler->getObject($cid, $catid, substr($tweet['text'],0,140), $campaign->getVar('rpids'));
														if (is_object($reply)) {
															$replytweet = $reply->getTweet();
															$urlobj = $urls_handler->get($reply->getVar('urlid'));
															if (is_object($urlobj)) {
																$url = sprintf($urlobj->getVar('surl'), urlencode(str_replace(array('#', '@'), '',$replytweet)));
															}
															$link = XOOPS_URL.'/modules/twitterbomb/go.php?rpid='.$rid.'&cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode($url);  
															$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
															$pass=true;
															$criteria = new Criteria('id', $id);
															if ($log_handler->getCount($criteria)==0&&$pass==true) {
																$log = $log_handler->create();
																$log->setVar('provider', $campaign->getVar('type'));
																$log->setVar('cid', $cid);
																$log->setVar('catid', $catid);
																$log->setVar('alias', '@'.$tweet['from_user']);
																$log->setVar('rpid', $rid);
																$log->setVar('id', $id);
																$log->setVar('url', '');
																$log->setVar('tweet', substr($replytweet,0,140));
																$log->setVar('tags', twitterbomb_ExtractTags($replytweet));
																$log = $log_handler->get($lid = $log_handler->insert($log, true));
																if ($replied = $oauth->sendReply($replytweet, twitterbomb_shortenurl($link), $id)) {
																	$reply->setVar('replies', $reply->getVar('replies')+1);
																	$reply->setVar('replied', time());
																	$replies_handler->insert($reply);
																	echo 'Reply Sent: '.$replied['id_str'].' - '.$replytweet.NLB;
																	if ($GLOBALS['twitterbombModuleConfig']['tags']) {
																		$tag_handler = xoops_getmodulehandler('tag', 'tag');
																		$tag_handler->updateByItem(twitterbomb_ExtractTags($replytweet), $lid, $GLOBALS['twitterbombModule']->getVar("dirname"), $catid);
																	}
																	$criteria = new Criteria('`screen_name`', $tweet['from_user']);
																	if ($usernames_handler->getCount($criteria)==0) {
																		$username = $usernames_handler->create();
																		$username->setVar('screen_name', $tweet['from_user']);
																		$username->setVar('type' , 'bomb');
																		$tid = $usernames_handler->insert($username,  true);
																	} else {
																		$usernames = $usernames_handler->getObjects($criteria, false);
																		if (is_object($usernames[0]))
																			$tid = $usernames[0]->getVar('tid');
																		else 
																			$tid = 0;
																	}
																	$log->setVar('tweet', substr($replytweet,0,140));
																	$log->setVar('url', $link);
																	$log->setVar('tid', $tid);
																	$log_handler->insert($log, true);
																	$ret[]['title'] = $replytweet;	  
																	$ret[sizeof($ret)-1]['link'] = $link;
																	$ret[sizeof($ret)-1]['description'] = htmlspecialchars_decode($replytweet);
																	$ret[sizeof($ret)-1]['lid'] = $lid;
																	$ret[sizeof($ret)-1]['rid'] = $rid;
																	$item++;
																	$c++;
																	$items++;
																} else {
																	echo 'Reply Failed(api): '.$id.' - '.$replytweet.NLB;
																	@$log_handler->delete($log, true);
																}
															} else {
																if ($pass==false)
																	echo 'Retweet Failed (exceptions): ';
																else 
																	echo 'Retweet Failed (exists): ';
																echo $id.' - '.$replytweet.NLB;
															}
														}
													}
												}
											}
										}
									}
								}
								$loop++;
							}
							if (count($ret)>$GLOBALS['twitterbombModuleConfig']['replies_items']) {
								foreach($ret as $key => $value) {
									if (count($ret)>$GLOBALS['twitterbombModuleConfig']['replies_items'])
										unset($ret[$key]);
								}
							}
							XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']+$GLOBALS['twitterbombModuleConfig']['retweet_cache']);
						} else {
							$loopsb++;
						}
						break;						
					case "mention":
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_channel_last');
						if (!isset($ret['last']))
							$ret = array('last'=>time()-(60*65));
						if (isset($ret['last']))
							if ($ret['last']+(60*60)<time()) { 

							$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
							while((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
								if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
									return endtweeter($cids);
								}
								$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 30;
								set_time_limit($GLOBALS['execution_time']);
								$search = $mention_handler->doSearchForReply($cid, $catid, $campaign->getVar('mids'));
								if (is_array($search)) {
									foreach ($search as $mid => $results) {
										$mention = $mention_handler->get($mid);
										if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
											return endtweeter($cids);
										}
										if (!empty($results)) {
											foreach($results as $id => $tweet) {
												if ((((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))>$items&&$c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))&&(((($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))/$campaignCount)*(($GLOBALS['twitterbombModuleConfig']['items']+$GLOBALS['twitterbombModuleConfig']['scheduler_items']+$GLOBALS['twitterbombModuleConfig']['retweet_items']+$GLOBALS['twitterbombModuleConfig']['pictures_items'])/$GLOBALS['twitterbombModuleConfig']['retweet_items']))*2>$loop) {
													if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
														return endtweeter($cids);
													}
													$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 15;
													set_time_limit($GLOBALS['execution_time']);
													if (is_array($tweet)) {
														$reply = $replies_handler->getObject($cid, $catid, substr($tweet['text'],0,140), $mention->getVar('rpids'));
														if (is_object($reply)) {
															$replytweet = $reply->getTweet();
															$urlobj = $urls_handler->get($reply->getVar('urlid'));
															if (is_object($urlobj)) {
																$url = sprintf($urlobj->getVar('surl'), urlencode(str_replace(array('#', '@'), '',$replytweet)));
															}
															$link = XOOPS_URL.'/modules/twitterbomb/go.php?rpid='.$rid.'&cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode($url);  
															$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
															$pass=true;
															$criteria = new Criteria('id', $id);
															if ($log_handler->getCount($criteria)==0&&$pass==true) {
																$log = $log_handler->create();
																$log->setVar('provider', $campaign->getVar('type'));
																$log->setVar('cid', $cid);
																$log->setVar('catid', $catid);
																$log->setVar('alias', '@'.$tweet['from_user']);
																$log->setVar('mid', $mid);
																$log->setVar('id', $id);
																$log->setVar('url', '');
																$log->setVar('tweet', substr($replytweet,0,140));
																$log->setVar('tags', twitterbomb_ExtractTags($replytweet));
																$log = $log_handler->get($lid = $log_handler->insert($log, true));
																if ($replied = $oauth->sendReply($replytweet, twitterbomb_shortenurl($link), $id)) {
																	$mention->setVar('mention', $mention->getVar('mention')+1);
																	$mention->setVar('mentioned', time());
																	$mention_handler->insert($mention);
																	echo 'Reply Sent: '.$replied['id_str'].' - '.$replytweet.NLB;
																	if ($GLOBALS['twitterbombModuleConfig']['tags']) {
																		$tag_handler = xoops_getmodulehandler('tag', 'tag');
																		$tag_handler->updateByItem(twitterbomb_ExtractTags($replytweet), $lid, $GLOBALS['twitterbombModule']->getVar("dirname"), $catid);
																	}
																	$criteria = new Criteria('`screen_name`', $tweet['from_user']);
																	if ($usernames_handler->getCount($criteria)==0) {
																		$username = $usernames_handler->create();
																		$username->setVar('screen_name', $tweet['from_user']);
																		$username->setVar('type' , 'bomb');
																		$tid = $usernames_handler->insert($username,  true);
																	} else {
																		$usernames = $usernames_handler->getObjects($criteria, false);
																		if (is_object($usernames[0]))
																			$tid = $usernames[0]->getVar('tid');
																		else 
																			$tid = 0;
																	}
																	$log->setVar('tweet', substr($replytweet,0,140));
																	$log->setVar('url', $link);
																	$log->setVar('tid', $tid);
																	$log_handler->insert($log, true);
																	$ret[]['title'] = $replytweet;	  
																	$ret[sizeof($ret)-1]['link'] = $link;
																	$ret[sizeof($ret)-1]['description'] = htmlspecialchars_decode($replytweet);
																	$ret[sizeof($ret)-1]['lid'] = $lid;
																	$ret[sizeof($ret)-1]['rid'] = $rid;
																	$item++;
																	$c++;
																	$items++;
																} else {
																	echo 'Reply Failed(api): '.$id.' - '.$replytweet.NLB;
																	@$log_handler->delete($log, true);
																}
															} else {
																if ($pass==false)
																	echo 'Retweet Failed (exceptions): ';
																else 
																	echo 'Retweet Failed (exists): ';
																echo $id.' - '.$replytweet.NLB;
															}
														}
													}
												}
											}
										}
									}
								}
								$loop++;
							}
							if (count($ret)>$GLOBALS['twitterbombModuleConfig']['mention_items']) {
								foreach($ret as $key => $value) {
									if (count($ret)>$GLOBALS['twitterbombModuleConfig']['mention_items'])
										unset($ret[$key]);
								}
							}
							XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']+$GLOBALS['twitterbombModuleConfig']['retweet_cache']);
						} else {
							$loopsb++;
						}
						break;												
				}
			}
		}
		if ($c<=(($GLOBALS['twitterbombModuleConfig']['tweets_per_session']+$GLOBALS['twitterbombModuleConfig']['retweets_per_session']+$GLOBALS['twitterbombModuleConfig']['pictures_per_session']))) {
			if (count($cids)==0) {
				$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
				$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
				$criteria_b->add(new Criteria('start', time(), '<'));
				$criteria_b->add(new Criteria('end', time(), '>'));
				$criteria = new CriteriaCompo($criteria_a);
				$criteria->add($criteria_b, 'OR');
				$criteria->setOrder(mt_rand(0,1)==0?'ASC':'DESC');
				$criteria->setSort('RAND()');
			} else {
				
				$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
				$criteria_a->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
				$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
				$criteria_b->add(new Criteria('start', time(), '<'));
				$criteria_b->add(new Criteria('end', time(), '>'));
				$criteria_b->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
				$criteria = new CriteriaCompo($criteria_a);
				$criteria->add($criteria_b, 'OR');
				$criteria->setOrder(mt_rand(0,1)==0?'ASC':'DESC');
				$criteria->setSort('RAND()');
			}
			$types = array();
			if ($GLOBALS['twitterbombModuleConfig']['cron_reply']) {
				$types[] = 'reply';
			}
			if ($GLOBALS['twitterbombModuleConfig']['cron_mention']) {
				$types[] = 'mention';
			}
			if ($GLOBALS['twitterbombModuleConfig']['cron_retweet']) {
				$types[] = 'retweet';
			}
			if ($GLOBALS['twitterbombModuleConfig']['cron_pictures']) {
				$types[] = 'pictures';
			}
			if ($GLOBALS['twitterbombModuleConfig']['cron_tweet']) {
				$types[] = 'scheduler';
				$types[] = 'bomber';
			}	
			$criteria->add(new Criteria('`type`', '("'.implode('","',$types)).'")', 'IN');
			$criteria->add(new Criteria('`cron`', true), 'AND');
			$criteria->setOrder(mt_rand(0,1)==0?'ASC':'DESC');
			$criteria->setSort('RAND()');
			$campaigns = $campaign_handler->getObjects($criteria, true);
			$campaignCount = $campaign_handler->getCount($criteria);
			if ($campaignCount==0) {
				XoopsCache::delete('twitterbomb_cids_cron');
				$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
				$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
				$criteria_b->add(new Criteria('start', time(), '<'));
				$criteria_b->add(new Criteria('end', time(), '>'));
				$criteria = new CriteriaCompo($criteria_a);
				$criteria->add($criteria_b, 'OR');
				$types = array();
				if ($GLOBALS['twitterbombModuleConfig']['cron_reply']) {
					$types[] = 'reply';
				}
				if ($GLOBALS['twitterbombModuleConfig']['cron_mention']) {
					$types[] = 'mention';
				}
				if ($GLOBALS['twitterbombModuleConfig']['cron_retweet']) {
					$types[] = 'retweet';
				}
				if ($GLOBALS['twitterbombModuleConfig']['cron_pictures']) {
					$types[] = 'pictures';
				}
				if ($GLOBALS['twitterbombModuleConfig']['cron_tweet']) {
					$types[] = 'scheduler';
					$types[] = 'bomber';
				}	
				$criteria->add(new Criteria('`type`', '("'.implode('","',$types).'")', 'IN'));
				$criteria->setOrder(mt_rand(0,1)==1?'ASC':'DESC');
				$criteria->setSort('RAND()');
				$campaigns = $campaign_handler->getObjects($criteria, true);
				$campaignCount = $campaign_handler->getCount($criteria);
			}
			$criteria->add(new Criteria('`cron`', true), 'AND');
		}
		if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($GLOBALS['twitterbombModuleConfig']['cron_pictures']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_tweet']?1:0)+($GLOBALS['twitterbombModuleConfig']['cron_retweet']?1:0))) {
			return endtweeter($cids);
		}
	}
	return endtweeter($cids);
}

function endtweeter($cids) {
	if (count($cids)==0) {
		XoopsCache::delete('twitterbomb_cids_cron');
	} else {
		XoopsCache::write('twitterbomb_cids_cron', $cids, 3600*48);
	}
	echo 'Tweeter Cron Ended: '.date('Y-m-d D H:i:s', time()).NLB;
}
?>