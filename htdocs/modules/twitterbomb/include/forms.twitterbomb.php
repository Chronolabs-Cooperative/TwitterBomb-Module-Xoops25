<?php

	function tweetbomb_retweet_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('retweet', 'twitterbomb');
			$object = $handler->create(); 
		}
		
		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_RETWEET, 'retweet', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_RETWEET, 'retweet', 'index.php', 'post');
		
		$id = $object->getVar('rid');
		if (empty($id)) $id = '0';
		
		$ele = array();	
		$ele['op'] = new XoopsFormHidden('op', 'retweet');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		
		$ele['search'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SEARCH_RETWEET, $id.'[search]', 26,64, $object->getVar('search'));
		$ele['search']->setDescription(_AM_TWEETBOMB_FORM_DESC_SEARCH_RETWEET);
		$ele['skip'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SKIP_RETWEET, $id.'[skip]', 26,64, $object->getVar('skip'));
		$ele['skip']->setDescription(_AM_TWEETBOMB_FORM_DESC_SKIP_RETWEET);
		$ele['geocode'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_GEOCODE_RETWEET, $id.'[geocode]', $object->getVar('geocode'));
		$ele['geocode']->setDescription(_AM_TWEETBOMB_FORM_DESC_GEOCODE_RETWEET);
		$ele['longitude'] = new XoopsFormText(_AM_TWEETBOMB_FORM_LONGITUDE_RETWEET, $id.'[longitude]', 10,24, $object->getVar('longitude'));
		$ele['longitude']->setDescription(_AM_TWEETBOMB_FORM_DESC_LONGITUDE_RETWEET);
		$ele['latitude'] = new XoopsFormText(_AM_TWEETBOMB_FORM_LATITUDE_RETWEET, $id.'[latitude]', 10,24, $object->getVar('latitude'));
		$ele['latitude']->setDescription(_AM_TWEETBOMB_FORM_DESC_LATITUDE_RETWEET);
		$ele['radius'] = new XoopsFormText(_AM_TWEETBOMB_FORM_RADIUS_RETWEET, $id.'[radius]', 8,24, $object->getVar('radius'));
		$ele['radius']->setDescription(_AM_TWEETBOMB_FORM_DESC_RADIUS_RETWEET);
		
		$ele['measurement'] = new TwitterbombFormSelectMeasurement(_AM_TWEETBOMB_FORM_MEASUREMENT_RETWEET, $id.'[measurement]', $object->getVar('measurement'));
		$ele['measurement']->setDescription(_AM_TWEETBOMB_FORM_DESC_MEASUREMENT_RETWEET);
		
		$ele['language'] = new TwitterbombFormSelectLanguage(_AM_TWEETBOMB_FORM_LANGUAGE_RETWEET, $id.'[language]', $object->getVar('language'));
		$ele['language']->setDescription(_AM_TWEETBOMB_FORM_DESC_LANGUAGE_RETWEET);
		
		$ele['type'] = new TwitterbombFormSelectRetweetType(_AM_TWEETBOMB_FORM_TYPE_RETWEET, $id.'[type]', $object->getVar('type'));
		$ele['type']->setDescription(_AM_TWEETBOMB_FORM_DESC_TYPE_RETWEET);
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_RETWEET, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_RETWEET, _MI_TWEETBOMB_ANONYMOUS);
		}
		
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_RETWEET, date(_DATESTRING, $object->getVar('created')));
		}
		
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_RETWEET, date(_DATESTRING, $object->getVar('updated')));
		}
		
		if ($object->getVar('actioned')>0) {
			$ele['actioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_ACTIONED_RETWEET, date(_DATESTRING, $object->getVar('actioned')));
		}	
		
		if ($object->getVar('searched')>0) {
			$ele['searched'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_SEARCHED_RETWEET, date(_DATESTRING, $object->getVar('searched')));
		}	
		
		if ($object->getVar('retweeted')>0) {
			$ele['retweets'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_RETWEETS_RETWEET, $object->getVar('retweets'));
			$ele['retweeted'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_RETWEETED_RETWEET, date(_DATESTRING, $object->getVar('retweeted')));
		}	
		
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('search', 'language', 'type', 'measurement');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
		
		return $sform->render();
		
	}	

	function tweetbomb_pictures_get_form($object) {
	
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('pictures', 'twitterbomb');
			$object = $handler->create();
		}
	
		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_PICTURE, 'pictures', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_PICTURE, 'pictures', 'index.php', 'post');
	
		$id = $object->getVar('picid');
		if (empty($id)) $id = '0';
	
		$ele = array();
		$ele['op'] = new XoopsFormHidden('op', 'pictures');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
	
		$ele['search'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SEARCH_PICTURE, $id.'[search]', 26,64, $object->getVar('search'));
		$ele['search']->setDescription(_AM_TWEETBOMB_FORM_DESC_SEARCH_PICTURE);
		$ele['skip'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SKIP_PICTURE, $id.'[skip]', 26,64, $object->getVar('skip'));
		$ele['skip']->setDescription(_AM_TWEETBOMB_FORM_DESC_SKIP_PICTURE);
		$ele['mcid'] = new TwitterBombFormSelectMyalbumCategories(_AM_TWEETBOMB_FORM_CATEGORY_PICTURE, $id.'[mcid]', $object->getVar('mcid'));
		$ele['mcid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATEGORY_PICTURE);
		$ele['width'] = new XoopsFormText(_AM_TWEETBOMB_FORM_WIDTH_PICTURE, $id.'[width]', 16,20, $object->getVar('width'));
		$ele['width']->setDescription(_AM_TWEETBOMB_FORM_DESC_WIDTH_PICTURE);
		$ele['height'] = new XoopsFormText(_AM_TWEETBOMB_FORM_HEIGHT_PICTURE, $id.'[height]', 16,20, $object->getVar('height'));
		$ele['height']->setDescription(_AM_TWEETBOMB_FORM_DESC_HEIGHT_PICTURE);
		$ele['geocode'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_GEOCODE_PICTURE, $id.'[geocode]', $object->getVar('geocode'));
		$ele['geocode']->setDescription(_AM_TWEETBOMB_FORM_DESC_GEOCODE_PICTURE);
		$ele['longitude'] = new XoopsFormText(_AM_TWEETBOMB_FORM_LONGITUDE_PICTURE, $id.'[longitude]', 10,24, $object->getVar('longitude'));
		$ele['longitude']->setDescription(_AM_TWEETBOMB_FORM_DESC_LONGITUDE_PICTURE);
		$ele['latitude'] = new XoopsFormText(_AM_TWEETBOMB_FORM_LATITUDE_PICTURE, $id.'[latitude]', 10,24, $object->getVar('latitude'));
		$ele['latitude']->setDescription(_AM_TWEETBOMB_FORM_DESC_LATITUDE_PICTURE);
		$ele['radius'] = new XoopsFormText(_AM_TWEETBOMB_FORM_RADIUS_PICTURE, $id.'[radius]', 8,24, $object->getVar('radius'));
		$ele['radius']->setDescription(_AM_TWEETBOMB_FORM_DESC_RADIUS_PICTURE);
	
		$ele['measurement'] = new TwitterbombFormSelectMeasurement(_AM_TWEETBOMB_FORM_MEASUREMENT_PICTURE, $id.'[measurement]', $object->getVar('measurement'));
		$ele['measurement']->setDescription(_AM_TWEETBOMB_FORM_DESC_MEASUREMENT_PICTURE);
	
		$ele['language'] = new TwitterbombFormSelectLanguage(_AM_TWEETBOMB_FORM_LANGUAGE_PICTURE, $id.'[language]', $object->getVar('language'));
		$ele['language']->setDescription(_AM_TWEETBOMB_FORM_DESC_LANGUAGE_PICTURE);
	
		$ele['type'] = new TwitterbombFormSelectRetweetType(_AM_TWEETBOMB_FORM_TYPE_PICTURE, $id.'[type]', $object->getVar('type'));
		$ele['type']->setDescription(_AM_TWEETBOMB_FORM_DESC_TYPE_PICTURE);
	
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_PICTURE, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_PICTURE, _MI_TWEETBOMB_ANONYMOUS);
		}
	
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_PICTURE, date(_DATESTRING, $object->getVar('created')));
		}
	
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_PICTURE, date(_DATESTRING, $object->getVar('updated')));
		}
	
		if ($object->getVar('actioned')>0) {
			$ele['actioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_ACTIONED_PICTURE, date(_DATESTRING, $object->getVar('actioned')));
		}
	
		if ($object->getVar('searched')>0) {
			$ele['searched'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_SEARCHED_PICTURE, date(_DATESTRING, $object->getVar('searched')));
		}
	
		if ($object->getVar('pictured')>0) {
			$ele['pictures'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_PICTURES_PICTURE, $object->getVar('pictures'));
			$ele['pictured'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_PICTURED_PICTURE, date(_DATESTRING, $object->getVar('pictured')));
		}
	
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
	
		$required = array('mcid', 'width', 'height', 'search', 'language', 'type', 'measurement');
	
		foreach($ele as $id => $obj)
			if (in_array($id, $required))
			$sform->addElement($ele[$id], true);
		else
			$sform->addElement($ele[$id], false);
	
		return $sform->render();
	
	}
	
	function tweetbomb_base_matrix_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('base_matrix', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_BASEMATRIX, 'category', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_BASEMATRIX, 'category', 'index.php', 'post');

		$id = $object->getVar('baseid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'base_matrix');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_BASEMATRIX, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'bomb');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_BASEMATRIX);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_BASEMATRIX, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_BASEMATRIX);
		$ele['base1'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASEA_BASEMATRIX, $id.'[base1]', $object->getVar('base1'), 1, false, true, true);
		$ele['base1']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEA_BASEMATRIX);
		$ele['base2'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASEB_BASEMATRIX, $id.'[base2]', $object->getVar('base2'), 1, false, true, true);
		$ele['base2']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEB_BASEMATRIX);
		$ele['base3'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASEC_BASEMATRIX, $id.'[base3]', $object->getVar('base3'), 1, false, true, true);
		$ele['base3']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEC_BASEMATRIX);
		$ele['base4'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASED_BASEMATRIX, $id.'[base4]', $object->getVar('base4'), 1, false, true, true);
		$ele['base4']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASED_BASEMATRIX);
		$ele['base5'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASEE_BASEMATRIX, $id.'[base5]', $object->getVar('base5'), 1, false, true, true);
		$ele['base5']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEE_BASEMATRIX);
		$ele['base6'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASEF_BASEMATRIX, $id.'[base6]', $object->getVar('base6'), 1, false, true, true);
		$ele['base6']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEF_BASEMATRIX);
		$ele['base7'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASEG_BASEMATRIX, $id.'[base7]', $object->getVar('base7'), 1, false, true, true);
		$ele['base7']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEG_BASEMATRIX);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_BASEMATRIX, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_BASEMATRIX, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_BASEMATRIX, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('actioned')>0) {
			$ele['actioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_ACTIONED_BASEMATRIX, date(_DATESTRING, $object->getVar('actioned')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_BASEMATRIX, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('base1', 'base2');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_replies_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('replies', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_REPLIES, 'replies', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_REPLIES, 'replies', 'index.php', 'post');

		$id = $object->getVar('rpid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'replies');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_REPLIES, $id.'[cid]', $object->getVar('cid'), 1, false, true, 'reply');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_REPLIES);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_REPLIES, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_REPLIES);
		$ele['type'] = new TwitterBombFormSelectType(_AM_TWEETBOMB_FORM_TYPE_REPLIES, $id.'[type]', $object->getVar('type'), 1, false, false, 'bomb,reply');
		$ele['type']->setDescription(_AM_TWEETBOMB_FORM_DESC_TYPE_REPLIES);
		$ele['reply'] = new XoopsFormText(_AM_TWEETBOMB_FORM_REPLY_REPLIES, $id.'[reply]', 35,140, $object->getVar('reply'));
		$ele['reply']->setDescription(_AM_TWEETBOMB_FORM_DESC_REPLY_REPLIES);
		$ele['keywords'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_KEYWORDS_REPLIES, $id.'[keywords]', $object->getVar('keywords'), 4, 26);
		$ele['keywords']->setDescription(_AM_TWEETBOMB_FORM_DESC_KEYWORDS_REPLIES);
		$ele['urlid'] = new TwitterBombFormSelectUrls(_AM_TWEETBOMB_FORM_URLS_REPLIES, $id.'[urlid]', $object->getVar('urlid'));
		$ele['urlid']->setDescription(_AM_TWEETBOMB_FORM_DESC_URLS_REPLIES);
		$ele['rcid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_RCID_REPLIES, $id.'[rcid]', $object->getVar('rcid'), 1, false, true, 'bomb');
		$ele['rcid']->setDescription(_AM_TWEETBOMB_FORM_DESC_RCID_REPLIES);
						
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_REPLIES, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_REPLIES, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_REPLIES, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_REPLIES, date(_DATESTRING, $object->getVar('updated')));
		}
		if ($object->getVar('replied')>0) {
			$ele['replied'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_REPLIED_REPLIES, date(_DATESTRING, $object->getVar('replied')));
		}			
		if ($object->getVar('replies')>0) {
			$ele['replies'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_REPLIES_REPLIES, $object->getVar('replies'));
		}						
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('catid', 'type');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}
	
	function tweetbomb_mentions_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('mentions', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_MENTIONS, 'mentions', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_MENTIONS, 'mentions', 'index.php', 'post');

		$id = $object->getVar('mid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'mentions');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_MENTIONS, $id.'[cid]', $object->getVar('cid'), 1, false, true, 'mentions');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_MENTIONS);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_MENTIONS, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_MENTIONS);
		$ele['user'] = new XoopsFormText(_AM_TWEETBOMB_FORM_USER_MENTIONS, $id.'[user]', 26,64, $object->getVar('user'));
		$ele['user']->setDescription(_AM_TWEETBOMB_FORM_DESC_USER_MENTIONS);
		$ele['keywords'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_KEYWORDS_MENTIONS, $id.'[keywords]', $object->getVar('keywords'), 4, 26);
		$ele['keywords']->setDescription(_AM_TWEETBOMB_FORM_DESC_KEYWORDS_MENTIONS);
		$ele['rpids'] = new TwitterbombFormCheckBoxReplies(_AM_TWEETBOMB_FORM_RPIDS_MENTIONS, $id.'[rpids]', $object->getVar('rpids'), '<br/>');
		$ele['rpids']->setDescription(_AM_TWEETBOMB_FORM_DESC_RPIDS_MENTIONS);
		$ele['geocode'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_GEOCODE_MENTIONS, $id.'[geocode]', $object->getVar('geocode'));
		$ele['geocode']->setDescription(_AM_TWEETBOMB_FORM_DESC_GEOCODE_MENTIONS);
		$ele['longitude'] = new XoopsFormText(_AM_TWEETBOMB_FORM_LONGITUDE_MENTIONS, $id.'[longitude]', 10,24, $object->getVar('longitude'));
		$ele['longitude']->setDescription(_AM_TWEETBOMB_FORM_DESC_LONGITUDE_MENTIONS);
		$ele['latitude'] = new XoopsFormText(_AM_TWEETBOMB_FORM_LATITUDE_MENTIONS, $id.'[latitude]', 10,24, $object->getVar('latitude'));
		$ele['latitude']->setDescription(_AM_TWEETBOMB_FORM_DESC_LATITUDE_MENTIONS);
		$ele['radius'] = new XoopsFormText(_AM_TWEETBOMB_FORM_RADIUS_MENTIONS, $id.'[radius]', 8,24, $object->getVar('radius'));
		$ele['radius']->setDescription(_AM_TWEETBOMB_FORM_DESC_RADIUS_MENTIONS);
		$ele['measurement'] = new TwitterbombFormSelectMeasurement(_AM_TWEETBOMB_FORM_MEASUREMENT_MENTIONS, $id.'[measurement]', $object->getVar('measurement'));
		$ele['measurement']->setDescription(_AM_TWEETBOMB_FORM_DESC_MEASUREMENT_MENTIONS);
		$ele['language'] = new TwitterbombFormSelectLanguage(_AM_TWEETBOMB_FORM_LANGUAGE_MENTIONS, $id.'[language]', $object->getVar('language'));
		$ele['language']->setDescription(_AM_TWEETBOMB_FORM_DESC_LANGUAGE_MENTIONS);
		$ele['type'] = new TwitterbombFormSelectRetweetType(_AM_TWEETBOMB_FORM_TYPE_MENTIONS, $id.'[type]', $object->getVar('type'));
		$ele['type']->setDescription(_AM_TWEETBOMB_FORM_DESC_TYPE_MENTIONS);
				
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_MENTIONS, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_MENTIONS, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_MENTIONS, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_MENTIONS, date(_DATESTRING, $object->getVar('updated')));
		}
		if ($object->getVar('mentioned')>0) {
			$ele['mentioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_MENTIONED_MENTIONS, date(_DATESTRING, $object->getVar('mentioned')));
		}			
		if ($object->getVar('mentions')>0) {
			$ele['mentions'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_MENTIONS_MENTIONS, $object->getVar('mentions'));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('name', 'catid', 'type');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}
	function tweetbomb_campaign_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('campaign', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_SCHEDULER, 'campaign', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_SCHEDULER, 'campaign', 'index.php', 'post');

		$id = $object->getVar('cid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'campaign');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_CAMPAIGN, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_CAMPAIGN);
		$ele['type'] = new TwitterBombFormSelectType(_AM_TWEETBOMB_FORM_TYPE_CAMPAIGN, $id.'[type]', $object->getVar('type'));
		$ele['type']->setDescription(_AM_TWEETBOMB_FORM_DESC_TYPE_CAMPAIGN);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_CAMPAIGN, $id.'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_CAMPAIGN);
		$ele['description'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_DESCRIPTION_CAMPAIGN, $id.'[description]', $object->getVar('description'), 4, 26);
		$ele['description']->setDescription(_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_CAMPAIGN);
		$ele['start'] = new XoopsFormTextDateSelect(_AM_TWEETBOMB_FORM_START_CAMPAIGN, $id.'[start]', 15, $object->getVar('start'));
		$ele['start']->setDescription(_AM_TWEETBOMB_FORM_DESC_START_CAMPAIGN);
		$ele['end'] = new XoopsFormTextDateSelect(_AM_TWEETBOMB_FORM_END_CAMPAIGN, $id.'[end]', 15, $object->getVar('end'));
		$ele['end']->setDescription(_AM_TWEETBOMB_FORM_DESC_END_CAMPAIGN);
		$ele['timed'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_TIMED_CAMPAIGN, $id.'[timed]', $object->getVar('timed'));
		$ele['timed']->setDescription(_AM_TWEETBOMB_FORM_DESC_TIMED_CAMPAIGN);
		$ele['rids'] = new TwitterbombFormCheckBoxRetweet(_AM_TWEETBOMB_FORM_RIDS_CAMPAIGN, $id.'[rids]', $object->getVar('rids'));
		$ele['rids']->setDescription(_AM_TWEETBOMB_FORM_DESC_RIDS_CAMPAIGN);
		$ele['mids'] = new TwitterbombFormCheckBoxMentions(_AM_TWEETBOMB_FORM_MIDS_CAMPAIGN, $id.'[mids]', $object->getVar('mids'));
		$ele['mids']->setDescription(_AM_TWEETBOMB_FORM_DESC_MIDS_CAMPAIGN);
		$ele['rpids'] = new TwitterbombFormCheckBoxReplies(_AM_TWEETBOMB_FORM_RPIDS_CAMPAIGN, $id.'[rpids]', $object->getVar('rpids'), '<br/>');
		$ele['rpids']->setDescription(_AM_TWEETBOMB_FORM_DESC_RPIDS_CAMPAIGN);
		if (twitterbomb_doesModuleExist($GLOBALS['twitterbombModuleConfig']['myalbum_dirname'], 306)) {
			$ele['picids'] = new TwitterbombFormCheckBoxPictures(_AM_TWEETBOMB_FORM_PICIDS_CAMPAIGN, $id.'[picids]', $object->getVar('picids'), '<br/>');
			$ele['picids']->setDescription(_AM_TWEETBOMB_FORM_DESC_PICIDS_CAMPAIGN);
		}	
		$ele['cron'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_CRON_CAMPAIGN, $id.'[cron]', $object->getVar('cron'));
		$ele['cron']->setDescription(_AM_TWEETBOMB_FORM_DESC_CRON_CAMPAIGN);
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CAMPAIGN, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CAMPAIGN, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_CAMPAIGN, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_CAMPAIGN, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('name', 'catid', 'type');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_category_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('category', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_CATEGORY, 'category', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_CATEGORY, 'category', 'index.php', 'post');

		$id = $object->getVar('catid');
		if (empty($id)) $id = '0';
		
		$ele['op'] = new XoopsFormHidden('op', 'category');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['pcatdid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_PCATID_CATEGORY, $id.'[pcatdid]', $object->getVar('pcatdid'));
		$ele['pcatdid']->setDescription(_AM_TWEETBOMB_FORM_DESC_PCATID_CATEGORY);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_CATEGORY, $id.'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_CATEGORY);
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CATEGORY, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CATEGORY, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_CATEGORY, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_CATEGORY, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('name', 'description');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}	
	
	function tweetbomb_keywords_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('keywords', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_KEYWORDS, 'keywords', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_KEYWORDS, 'keywords', 'index.php', 'post');

		$id = $object->getVar('kid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'keywords');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_KEYWORDS, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'bomb');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_KEYWORDS);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_KEYWORDS, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_KEYWORDS);
		$ele['base'] = new TwitterBombFormSelectBase(_AM_TWEETBOMB_FORM_BASE_KEYWORDS, $id.'[base]', $object->getVar('base'));
		$ele['base']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASE_KEYWORDS);
		$ele['keyword'] = new XoopsFormText(_AM_TWEETBOMB_FORM_KEYWORD_KEYWORDS, $id.'[keyword]', 30,35, $object->getVar('keyword'));
		$ele['keyword']->setDescription(_AM_TWEETBOMB_FORM_DESC_KEYWORD_KEYWORDS);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_KEYWORDS, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_KEYWORDS, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_KEYWORDS, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('actioned')>0) {
			$ele['actioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_ACTIONED_KEYWORDS, date(_DATESTRING, $object->getVar('actioned')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_KEYWORDS, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('base', 'keyword');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}
	
	function tweetbomb_usernames_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('usernames', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_USERNAMES, 'usernames', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_USERNAMES, 'usernames', 'index.php', 'post');
		
		$id = $object->getVar('tid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'usernames');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_USERNAMES, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'bomb');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_USERNAMES);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_USERNAMES, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_USERNAMES);
		$ele['screen_name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_USERNAME_USERNAMES, $id.'[screen_name]', 30,64, $object->getVar('screen_name'));
		$ele['screen_name']->setDescription(_AM_TWEETBOMB_FORM_DESC_USERNAME_USERNAMES);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_USERNAMES, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_USERNAMES, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_USERNAMES, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_USERNAMES, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('screen_name');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_urls_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('urls', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_URLS, 'urls', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_URLS, 'urls', 'index.php', 'post');

		$id = $object->getVar('urlid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'urls');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_URLS, $id.'[cid]', $object->getVar('cid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_URLS);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_URLS, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_URLS);
		$ele['surl'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SURL_URLS, $id.'[surl]', 40,255, $object->getVar('surl'));
		$ele['surl']->setDescription(_AM_TWEETBOMB_FORM_DESC_SURL_URLS);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_URLS, $id.'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_URLS);
		$ele['description'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_DESCRIPTION_URLS, $id.'[description]', $object->getVar('description'), 4, 26);
		$ele['description']->setDescription(_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_URLS);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_URLS, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_URLS, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_URLS, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_URLS, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('surl', 'name');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_usernames_user_form() {
		
		$sform = new XoopsThemeForm(_MN_TWEETBOMB_FORM_ISNEW_USERNAMES, 'usernames', 'index.php', 'post');
	
		$ele['op'] = new XoopsFormHidden('op', 'usernames');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', '0');
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_MN_TWEETBOMB_FORM_CID_USERNAMES, '0[cid]');
		$ele['cid']->setDescription(_MN_TWEETBOMB_FORM_DESC_CID_USERNAMES);
		$ele['catid'] = new TwitterBombFormSelectCategories(_MN_TWEETBOMB_FORM_CATID_USERNAMES, '0[catid]');
		$ele['catid']->setDescription(_MN_TWEETBOMB_FORM_DESC_CATID_USERNAMES);
		$ele['type'] = new TwitterBombFormSelectType(_MN_TWEETBOMB_FORM_TYPE_USERNAMES, '0[type]', 'bomb');
		$ele['type']->setDescription(_MN_TWEETBOMB_FORM_DESC_TYPE_USERNAMES);
		$ele['screen_name'] = new XoopsFormText(_MN_TWEETBOMB_FORM_USERNAME_USERNAMES, '0[screen_name]', 30,64);
		$ele['screen_name']->setDescription(_MN_TWEETBOMB_FORM_DESC_USERNAME_USERNAMES);
		$ele['source_nick'] = new XoopsFormText(_MN_TWEETBOMB_FORM_NICK_USERNAMES, '0[source_nick]', 30,64);
		$ele['source_nick']->setDescription(_MN_TWEETBOMB_FORM_DESC_NICK_USERNAMES);
				
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('screen_name');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_scheduler_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('scheduler', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_SCHEDULER, 'scheduler', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_SCHEDULER, 'scheduler', 'index.php', 'post');

		$id = $object->getVar('cid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'scheduler');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_SCHEDULER, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'scheduler');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_SCHEDULER);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_SCHEDULER, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_SCHEDULER);
		$ele['mode'] = new TwitterBombFormSelectMode(_AM_TWEETBOMB_FORM_MODE_SCHEDULER, $id.'[mode]', $object->getVar('mode'));
		$ele['mode']->setDescription(_AM_TWEETBOMB_FORM_DESC_MODE_SCHEDULER);
		$ele['pre'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PRE_SCHEDULER, $id.'[pre]', 15, 35, $object->getVar('pre'));
		$ele['pre']->setDescription(_AM_TWEETBOMB_FORM_DESC_PRE_SCHEDULER);
		$ele['text'] = new XoopsFormText(_AM_TWEETBOMB_FORM_TEXT_SCHEDULER, $id.'[text]', 15, 140, $object->getVar('text'));
		$ele['text']->setDescription(_AM_TWEETBOMB_FORM_DESC_TEXT_SCHEDULER);
		$ele['replace'] = new XoopsFormText(_AM_TWEETBOMB_FORM_REPLACE_SCHEDULER, $id.'[replace]', 25, 200, implode('|',$object->getVar('replace')));
		$ele['replace']->setDescription(_AM_TWEETBOMB_FORM_DESC_REPLACE_SCHEDULER);
		$ele['strip'] = new XoopsFormText(_AM_TWEETBOMB_FORM_STRIP_SCHEDULER, $id.'[strip]', 25, 200, implode('|',$object->getVar('strip')));
		$ele['strip']->setDescription(_AM_TWEETBOMB_FORM_DESC_STRIP_SCHEDULER);
		$ele['search'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SEARCH_SCHEDULER, $id.'[search]', 25, 200, implode('|',$object->getVar('search')));
		$ele['search']->setDescription(_AM_TWEETBOMB_FORM_DESC_SEARCH_SCHEDULER);
		$ele['pregmatch'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PREGMATCH_SCHEDULER, $id.'[pregmatch]', 25, 500, $object->getVar('pregmatch'));
		$ele['pregmatch']->setDescription(_AM_TWEETBOMB_FORM_DESC_PREGMATCH_SCHEDULER);		
		$ele['pregmatch_replace'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PREGMATCH_REPLACE_SCHEDULER, $id.'[pregmatch_replace]', 25, 500, $object->getVar('pregmatch_replace'));
		$ele['pregmatch_replace']->setDescription(_AM_TWEETBOMB_FORM_DESC_PREGMATCH_REPLACE_SCHEDULER);		
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_SCHEDULER, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_SCHEDULER, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('text', 'mode');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_scheduler_get_upload_form($handler) {
		
		if (!is_object($handler)) {
			$handler = xoops_getmodulehandler('scheduler', 'twitterbomb');
		}
		
		$object = $handler->create();

		$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_IMPORT_SCHEDULE, 'schedule', 'index.php', 'post');
		$sform->setExtra( "enctype='multipart/form-data'" ) ;
		$id = '0';
		
		$ele['op'] = new XoopsFormHidden('op', 'scheduler');
		$ele['fct'] = new XoopsFormHidden('fct', 'importfile');
		$ele['id'] = new XoopsFormHidden('id', 0);
		$ele['cid'] = new TwitterBombFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_SCHEDULER, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'scheduler');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_SCHEDULER);
		$ele['catid'] = new TwitterBombFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_SCHEDULER, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_SCHEDULER);
		$ele['mode'] = new TwitterBombFormSelectMode(_AM_TWEETBOMB_FORM_MODE_SCHEDULER, $id.'[mode]', $object->getVar('mode'));
		$ele['mode']->setDescription(_AM_TWEETBOMB_FORM_DESC_MODE_SCHEDULER);
		$ele['pre'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PRE_SCHEDULER, $id.'[pre]', 15, 35, $object->getVar('pre'));
		$ele['pre']->setDescription(_AM_TWEETBOMB_FORM_DESC_PRE_SCHEDULER);
		$ele['replace'] = new XoopsFormText(_AM_TWEETBOMB_FORM_REPLACE_SCHEDULER, $id.'[replace]', 25, 200, implode('|',$object->getVar('replace')));
		$ele['replace']->setDescription(_AM_TWEETBOMB_FORM_DESC_REPLACE_SCHEDULER);
		$ele['strip'] = new XoopsFormText(_AM_TWEETBOMB_FORM_STRIP_SCHEDULER, $id.'[strip]', 25, 200, implode('|',$object->getVar('strip')));
		$ele['strip']->setDescription(_AM_TWEETBOMB_FORM_DESC_STRIP_SCHEDULER);
		$ele['search'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SEARCH_SCHEDULER, $id.'[search]', 25, 200, implode('|',$object->getVar('search')));
		$ele['search']->setDescription(_AM_TWEETBOMB_FORM_DESC_SEARCH_SCHEDULER);
		$ele['pregmatch'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PREGMATCH_SCHEDULER, $id.'[pregmatch]', 25, 500, $object->getVar('pregmatch'));
		$ele['pregmatch']->setDescription(_AM_TWEETBOMB_FORM_DESC_PREGMATCH_SCHEDULER);		
		$ele['pregmatch_replace'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PREGMATCH_REPLACE_SCHEDULER, $id.'[pregmatch_replace]', 25, 500, $object->getVar('pregmatch_replace'));
		$ele['pregmatch_replace']->setDescription(_AM_TWEETBOMB_FORM_DESC_PREGMATCH_REPLACE_SCHEDULER);		
		$ele['file'] = new XoopsFormFile(_AM_TWEETBOMB_FORM_FILE_SCHEDULER, $id.'[file]', 1024*1024*10);
		$ele['file']->setDescription(_AM_TWEETBOMB_FORM_DESC_FILE_SCHEDULER);

		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_SCHEDULER, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_SCHEDULER, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('file', 'mode');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}
	
?>
