<?php

	function MircInsertHook($object) {
		return $object->getVar('sid');
	}
	
	function MircGetHook($object, $for_tweet=false) {
		switch ($for_tweet)
		{
			case false;
				return $object;
				break;
			case true;
				$text = $object->getVar('text');
				$nickstart = strpos($text, '&lt;', 0);
				$convostart = strpos($text, '&gt;', $nickstart+1);
				if ($convostart!=0&&$nickstart!=0) {
					$nick = str_replace(array('@', '%', '+'), '', trim(substr($text, $nickstart+4, $convostart-$nickstart-4)));
					$tweet = trim(substr($text, $convostart+4, strlen($text)-$convostart-4));
				} else {
					$nickstart = strpos($text, ': ', 0);
					$convostart = strpos($text, ' ', $nickstart+3);
					$nick = str_replace(array('@', '%', '+'), '',trim(substr($text, $nickstart+2, $convostart-$nickstart-2)));
					$cut = strpos($text, ')', $convostart);
					if ($cut!=0)
						$tweet = trim(substr($text, $cut+1, strlen($text)-$cut));
					else
						$tweet = trim(substr($text, $convostart+1, strlen($text)-$convostart)); 
				}
				break;	
		}
		
		$parts = explode(' ', strtolower($tweet));
		$common = explode(' ', strtolower($GLOBALS['xoopsModuleConfig']['scheduler_usernames']));
		$usernames_handler = xoops_getmodulehandler('usernames', 'twitterbomb');
		
		if (count($common)==count($parts)&&sizeof($common)==sizeof($parts)) {
			
			$pass = true;
			foreach($common as $key=> $value) {
				switch($value){
					case '%username%':
						if (isset($parts[$key])&&$pass==true)
							$screen_name = str_replace(array('@', '#'), '', $parts[$key]);
						break;
					default:
						if (isset($parts[$key]))
							if ($parts[$key]!=$value)
								$pass=false;
						else 
							$pass=false;
						break;
				}
			}
			
			if ($pass==true&&!empty($screen_name)) {
				$criteria= new CriteriaCompo(new Criteria('screen_name', $screen_name, 'LIKE'));
				$criteria->add(new Criteria('source_nick', strtolower($nick), 'LIKE'));
				$criteria->add(new Criteria('type', 'scheduler'));
				$criteria->add(new Criteria('cid', $object->getVar('cid')));
				$criteria->add(new Criteria('catid', $object->getVar('catid')));
				if ($usernames_handler->getCount($criteria)==0) {
					$username = $usernames_handler->create();
					$username->setVars($object->toArray());
					$username->setVar('screen_name', $screen_name);
					$username->setVar('source_nick', strtolower($nick));
					$username->setVar('type', 'scheduler');
					$usernames_handler->insert($username);
				}
				return '#'. $nick .' '.str_replace($screen_name, '@'.$screen_name, $tweet);
			}
			
		}
		
		$tweetuser = $usernames_handler->getUser($object->getVar('cid'), $object->getVar('catid'), strtolower($nick));
		return '#'. $nick .(!empty($tweetuser)?' @'.$tweetuser.' ':' ').$tweet;
				
	}
	
?>