<?php

function b_twitterbomb_block_usernames_show( $options )
{
	$block = array();
				
	$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
	$following_handler =& xoops_getmodulehandler('following', 'twitterbomb');
	
	if (!empty($options[0]))
		$criteria = $following_handler->criteriaAssocWithID($options[0]);
	else 
		$criteria = new Criteria('1','1');

	$criteria = new CriteriaCompo($criteria);
	$criterib = new CriteriaCompo(new Criteria('`name`', '', 'NOT LIKE'));
	$criterib->add(new Criteria('`description`', '', 'NOT LIKE'));
	$criterib->add(new Criteria('`avarta`', '', 'NOT LIKE'));
	$criterib->add(new Criteria('`name`', 'NULL', 'NOT LIKE'));
	$criterib->add(new Criteria('`description`', 'NULL', 'NOT LIKE'));
	$criterib->add(new Criteria('`avarta`', 'NULL', 'NOT LIKE'));
	$criteria->add($criterib, 'AND');
		
	if ($options[3]==true) {
		$criteria->setSort('RAND()');
		$criteria->setOrder('DESC');
	} else {
		$criteria->setSort('`actioned`');
		$criteria->setOrder('ASC');
	}
	
	$block['table']['columns'] = $options[1];
	$block['table']['rows'] = $options[2];
	$block['mode']['name'] = $options[4];
	$block['mode']['description'] = $options[5];
	$block['mode']['screenname'] = $options[6];
	$block['mode']['picture'] = $options[7];
	$block['image']['width'] = $options[8];
	$block['mode']['url'] = $options[9];
	
	$criteria->setStart(0);
	$criteria->setLimit($options[1]*$options[2]);
	$row=1;
	$col=0;
	foreach($usernames_handler->getObjects($criteria, true) as $key=>$username) {
		$col++;
		$i++;
		if ($col>$options[1]) {
			$col=1;
			$row++;
		}
		if ($col==$options[1]) {
			$block['data'][$i]['newrow']  = true;
		} else { 
			$block['data'][$i]['newrow']  = false;
		}
		if ($row==$options[2]) {
			$block['data'][$i]['lastrow']  = true;
		} else { 
			$block['data'][$i]['lastrow']  = false;
		}
		$block['data'][$i]['col'] = $col;
		$block['data'][$i]['row'] = $row;
		$block['data'][$i]['screenname'] = $username->getVar('screen_name');
		$block['data'][$i]['name'] = $username->getVar('name');
		$block['data'][$i]['description'] = $username->getVar('description');
		$block['data'][$i]['picture'] = $username->getVar('avarta');
		$block['data'][$i]['last']  = false;
		$block['data'][$i]['colspan']  = 0; 
		$username->setVar('actioned', time());
		$usernames_handler->insert($username, true);
	}
	$block['data'][$i]['last']  = true;
	$block['data'][$i]['colspan']  = $options[1]-$col;
	
	return $block ;
}


function b_twitterbomb_block_usernames_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));

	$form .="<table><tr><td>";
	$users = new TwitterBombFormSelectScreenname('', 'options[0]', $options[0], 1, false, true);
	$form .= ""._BL_TWITTERBOMB_USERS."&nbsp;".$users->render();
	$form .="</td></tr><tr><td>";
	$columns = new XoopsFormText('', 'options[1]', 10,15, $options[1]);
	$form .= "<br/>"._BL_TWITTERBOMB_COLUMNS."&nbsp;".$columns->render();
	$form .="</td></tr><tr><td>";
	$rows = new XoopsFormText('', 'options[2]', 10,15, $options[2]);
	$form .= "<br/>"._BL_TWITTERBOMB_ROWS."&nbsp;".$rows->render();
	$form .="</td></tr><tr><td>";
	$random = new XoopsFormRadioYN('', 'options[3]', $options[3]);
	$form .= "<br/>"._BL_TWITTERBOMB_RANDOM."&nbsp;".$random->render();
	$form .="</td></tr><tr><td>";
	$name = new XoopsFormRadioYN('', 'options[4]', $options[4]);
	$form .= "<br/>"._BL_TWITTERBOMB_NAME."&nbsp;".$name->render();
	$form .="</td></tr><tr><td>";
	$description = new XoopsFormRadioYN('', 'options[5]', $options[5]);
	$form .= "<br/>"._BL_TWITTERBOMB_DESCRIPTION."&nbsp;".$description->render();
	$form .="</td></tr><tr><td>";
	$username = new XoopsFormRadioYN('', 'options[6]', $options[6]);
	$form .= "<br/>"._BL_TWITTERBOMB_SCREENNAME."&nbsp;".$username->render();
	$form .="</td></tr><tr><td>";
	$picture = new XoopsFormRadioYN('', 'options[7]', $options[7]);
	$form .= "<br/>"._BL_TWITTERBOMB_PICTURE."&nbsp;".$picture->render();
	$form .="</td></tr><tr><td>";
	$width = new XoopsFormText('', 'options[8]', 10,15, $options[8]);
	$form .= "<br/>"._BL_TWITTERBOMB_WIDTH."&nbsp;".$width->render();
	$form .="</td></tr><tr><td>";
	$url = new XoopsFormText('', 'options[9]', 30,128, $options[9]);
	$form .= "<br/>"._BL_TWITTERBOMB_URL."&nbsp;".$url->render();
	$form .="</td></tr></table>";
	return $form ;
}

?>