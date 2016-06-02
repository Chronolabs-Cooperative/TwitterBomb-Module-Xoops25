<?php

	xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
    $module_handler = xoops_gethandler('module');
    $config_handler = xoops_gethandler('config');
    $GLOBALS['twitterbombModule'] = $module_handler->getByDirname('twitterbomb');
    if (is_object($GLOBALS['twitterbombModule'])) {
    	$GLOBALS['twitterbombModuleConfig'] = $config_handler->getConfigList($GLOBALS['twitterbombModule']->getVar('mid'));
		switch ($GLOBALS['twitterbombModuleConfig']['crontype']) {
			case 'preloader':
				if (!$read = XoopsCache::read('twitterbomb_pause_preload_gather_follow')) {
					XoopsCache::write('twitterbomb_pause_preload_gather_follow', true, $GLOBALS['twitterbombModuleConfig']['interval_of_cron']);
					ob_start();
					include(XOOPS_ROOT_PATH.'/modules/twitterbomb/cron/gather.php');
					include(XOOPS_ROOT_PATH.'/modules/twitterbomb/cron/follow.php');
					ob_end_clean();
				}
				break;
		}
    }
    
    ?>