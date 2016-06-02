<?php

function b_twitterbomb_block_topranked_show( $options )
{
	if (empty($options[0]))
		return false;

	$module_handler = xoops_gethandler('module');
	$config_handler = xoops_gethandler('config');
	$xoModule = $module_handler->getByDirname('twitterbomb');
	if (is_object($xoModule)) {
		
		$xoModuleConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		
		$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
		$scheduler_handler->recalc();
		
		$criteria = new CriteriaCompo(new Criteria('`rank`', '0', '>'));
		$criteria->setSort('`rank` DESC, `sid`');
		$criteria->setOrder('`ASC`'); 
		$criteria->setLimit($options[0]);
		
		$schedulers = $scheduler_handler->getObjects($criteria, true);
		
		$block['tweets']=array();
		foreach($schedulers as $key => $scheduler) {
			$block['tweets'][$key]['title'] = $scheduler->getTweet();
			$block['tweets'][$key]['link'] = XOOPS_URL;
			$block['tweets'][$key]['description'] = $scheduler->getTweet();
			$block['tweets'][$key]['hits'] = $scheduler->getVar('hits');
			$block['tweets'][$key]['rank'] = number_format(($scheduler->getVar('rank'))/$xoModuleConfig['number_to_rank']*100, 2).'%';
	    }
		return $block ;
	}
	return false;
}


function b_twitterbomb_block_topranked_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));
	
	$number = new XoopsFormText('', 'options[]', 10, 15, $options[0]);
	$form = ""._BL_TWITTERBOMB_NUMBER."&nbsp;".$number->render().'<br/>';
	
	return $form ;
}

?>