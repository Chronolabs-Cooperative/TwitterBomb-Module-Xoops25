<?php

	require dirname(dirname(dirname(__FILE__))).'/mainfile.php';
	
	if (!defined('_CHARSET'))
		define("_CHARSET","UTF-8");
	if (!defined('_CHARSET_ISO'))
		define("_CHARSET_ISO","ISO-8859-1");
		
	$GLOBALS['myts'] = MyTextSanitizer::getInstance();
	
	$module_handler = xoops_gethandler('module');
	$config_handler = xoops_gethandler('config');
	$GLOBALS['twitterbombModule'] = $module_handler->getByDirname('twitterbomb');
	$GLOBALS['twitterbombModuleConfig'] = $config_handler->getConfigList($GLOBALS['twitterbombModule']->getVar('mid')); 
	
	include(dirname(__FILE__).'/include/functions.php');	
	include(dirname(__FILE__).'/include/formobjects.twitterbomb.php');
	include(dirname(__FILE__).'/include/forms.twitterbomb.php');
	
?>