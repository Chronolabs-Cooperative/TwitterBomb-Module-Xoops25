<?php

function b_twitterbomb_block_retweet_show( $options )
{
	if (empty($options[0]))
		return false;
				
	$block['tweets']=array();				
	$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
	$campaign = $campaign_handler->get($options[0]);
	if (!is_object($campaign)) {
		$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_CAMPAIGN, date('Y-m-d H:i:s', time()));
		$block['tweets'][0]['link'] = XOOPS_URL;
		$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_CAMPAIGN, date('Y-m-d H:i:s', time()));
		return $block;
	}
	$cid = $campaign->getVar('cid');
	$catid = $campaign->getVar('catid');
	$cacheid = md5($cid.$catid);
	
    xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	if ($campaign->getVar('timed')!=0) {
		if ($campaign->getVar('start')<time()&&$campaign->getVar('end')>time()) {
			if (!$block['tweets'] = XoopsCache::read('tweetbomb_retweet_'.$cacheid)) {
				$log_handler =& xoops_getmodulehandler('log', 'twitterbomb');
				$criteria = new CriteriaCompo(new Criteria('cid', $cid));
				$criteria->setSort('`date`');
				$criteria->setOrder('DESC');
				$criteria->setLimit($options[1]);
				if ($logs = $log_handler->getObjects($criteria, true)) {
					foreach ($logs as $id => $log) {
						$block['tweets'][$id]['title'] = $log->getVar('tweet');
						$block['tweets'][$id]['link'] = (strlen($log->getVar('url'))>0?$log->getVar('url'):XOOPS_URL);
						$block['tweets'][$id]['description'] = $log->getVar('tweet');
					}
				} else {
					$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
					$block['tweets'][0]['link'] = XOOPS_URL;
					$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
				}
		    }
		} else {
			$block['tweets']=array();
			$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_RSS_TIMED_TITLE, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));
			$block['tweets'][0]['link'] = XOOPS_URL;
			$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_RSS_TIMED_DESCRIPTION, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));		
		}
	} else {
		if (!$block['tweets']  = XoopsCache::read('tweetbomb_retweet_'.$cacheid)) {
			$log_handler =& xoops_getmodulehandler('log', 'twitterbomb');
			$criteria = new CriteriaCompo(new Criteria('cid', $cid));
			$criteria->setSort('`date`');
			$criteria->setOrder('DESC');
			$criteria->setLimit($options[1]);
			if ($logs = $log_handler->getObjects($criteria, true)) {
				foreach ($logs as $id => $log) {
					$block['tweets'][$id]['title'] = $log->getVar('tweet');
					$block['tweets'][$id]['link'] = (strlen($log->getVar('url'))>0?$log->getVar('url'):XOOPS_URL);
					$block['tweets'][$id]['description'] = $log->getVar('tweet');
				}
			} else {
				$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
				$block['tweets'][0]['link'] = XOOPS_URL;
				$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
			}
		}
	}
	foreach($block['tweets'] as $key => $tweet) {
		$i++;
		if ($i>$options[1]) {
			unset($block['tweets'][$key]);
		}
	}	
	return $block ;
}


function b_twitterbomb_block_retweet_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));

	$campaign = new TwitterBombFormSelectCampaigns('', 'options[]', $options[0], 1, false, false, 'retweet');
	$form = ""._BL_TWITTERBOMB_CID."&nbsp;".$campaign->render();
	$display = new XoopsFormText('', 'options[]', 10,15, $options[1]);
	$form .= "<br/>"._BL_TWITTERBOMB_DISPLAY."&nbsp;".$display->render();
	
	return $form ;
}

?>