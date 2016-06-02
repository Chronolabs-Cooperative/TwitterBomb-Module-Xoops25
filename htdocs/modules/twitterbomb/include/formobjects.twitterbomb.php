<?php

include_once $GLOBALS['xoops']->path('/class/xoopsformloader.php');

include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectbase.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectcampaigns.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectcategories.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectmyalbumcategories.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectmode.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselecttype.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectoauthmode.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectscreenname.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectlanguage.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectmeasurement.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectretweettype.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectlogtype.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselecturls.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formcheckboxretweet.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formcheckboxpictures.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formcheckboxreplies.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formcheckboxmentions.php');

if (file_exists($GLOBALS['xoops']->path('/modules/tag/include/formtag.php')) && $GLOBALS['xoopsModuleConfig']['tags'])
	include_once $GLOBALS['xoops']->path('/modules/tag/include/formtag.php');

xoops_load('pagenav');

?>