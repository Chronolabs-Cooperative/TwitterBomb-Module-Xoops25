<?php



function xoops_module_pre_install_twitterbomb(&$module) {
	return true;
}

function xoops_module_install_twitterbomb(&$module) {
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix('twitterbomb_urls')."` (`cid`, `catid`, `surl`, `name`, `description`, `uid`, `created`) VALUES(0, 0, '".XOOPS_URL."/modules/twitterbomb/search.php?action=results&query=%s&andor=OR', 'Search ".$GLOBALS['xoopsConfig']['sitename']."', 'Searches your local site')";
	
	foreach($sql as $id => $question)
		$GLOBALS['xoopsDB']->queryF($question);
			
	return true;
}

?>