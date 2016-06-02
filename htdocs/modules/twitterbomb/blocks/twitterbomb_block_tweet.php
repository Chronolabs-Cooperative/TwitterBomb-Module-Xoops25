<?php

function b_twitterbomb_block_tweet_show( $options )
{
	if (empty($options[0])) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$options[0] = $xoConfig['root_tweeter']; 
	}
	
	if (empty($options[1]))
		$options[1] = 'horizontal';
		
	$GLOBALS['xoTheme']->addScript("http://platform.twitter.com/widgets.js", array("type"=>"text/javascript"));
	
	$block['data_via'] = $options[0];
	$block['data_count'] = $options[1];
	return $block ;
}


function b_twitterbomb_block_tweet_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));
	
	if (empty($options[0])) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$options[0] = $xoConfig['root_tweeter']; 
	}
	
	if (empty($options[1]))
		$options[1] = 'horizontal';
		
	$number = new XoopsFormText('', 'options[]', 26, 45, $options[0]);
	$form = ""._BL_TWITTERBOMB_TWEETER.$number->render().'<br/>';
	$count = new XoopsFormSelect('', 'options[]', $options[1]);
	$count->addOption('vertical', _BL_TWITTERBOMB_TWEET_COUNT_VERTICAL);
	$count->addOption('horizontal', _BL_TWITTERBOMB_TWEET_COUNT_HORIZONTAL);
	$count->addOption('none', _BL_TWITTERBOMB_TWEET_COUNT_NONE);
	$form .= ""._BL_TWITTERBOMB_TWEET_COUNT.$count->render().'<br/>';
	return $form ;
}

?>