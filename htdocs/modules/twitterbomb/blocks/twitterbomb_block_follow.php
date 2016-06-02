<?php

function b_twitterbomb_block_follow_show( $options )
{
	if (empty($options[0])) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$options[0] = $xoConfig['root_tweeter']; 
	}
	$GLOBALS['xoTheme']->addScript("http://platform.twitter.com/widgets.js", array("type"=>"text/javascript"));
	$block['tweeter'] = $options[0];
	return $block ;
}


function b_twitterbomb_block_follow_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));
	
	if (empty($options[0])) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$options[0] = $xoConfig['root_tweeter']; 
	}
	$number = new XoopsFormText('', 'options[]', 26, 45, $options[0]);
	$form = ""._BL_TWITTERBOMB_TWEETER.$number->render().'<br/>';
	
	return $form ;
}

?>