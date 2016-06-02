<?php

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class TwitterbombCorePreload extends XoopsPreloadItem
{
	//function eventCoreIncludeCommonEnd($args)
    //{
    //	include('../post.common.end.php');
    //}
    
	function eventCoreFooterEnd($args)
    {
    	include(dirname(dirname(__FILE__)).'/post.common.end.php');
    	include(dirname(dirname(__FILE__)).'/post.footer.end.php');
    }

    function eventCoreHeaderCacheEnd($args)
    {
    	include(dirname(dirname(__FILE__)).'/post.common.end.php');
    	include(dirname(dirname(__FILE__)).'/post.cache.end.php');
    }
    
}
?>