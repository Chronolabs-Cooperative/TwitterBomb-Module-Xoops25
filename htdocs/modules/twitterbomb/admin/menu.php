<?php
/**
 * @package     xortify
 * @subpackage  module
 * @description	Sector Network Security Drone
 * @author	    Simon Roberts WISHCRAFT <simon@chronolabs.coop>
 * @copyright	copyright (c) 2010-2013 XOOPS.org
 * @licence		GPL 2.0 - see docs/LICENCE.txt
 */

include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/functions.php');

global $adminmenu;
$adminmenu=array();
$adminmenu[0]['title'] = _MI_TWEETBOMB_TITLE_ADMENU0;
$adminmenu[0]['icon'] = _MI_TWEETBOMB_ICON_ADMENU0;
$adminmenu[0]['image'] = _MI_TWEETBOMB_ICON_ADMENU0;
$adminmenu[0]['link'] = _MI_TWEETBOMB_LINK_ADMENU0;
$adminmenu[1]['title'] = _MI_TWEETBOMB_TITLE_ADMENU1;
$adminmenu[1]['icon'] = _MI_TWEETBOMB_ICON_ADMENU1;
$adminmenu[1]['image'] = _MI_TWEETBOMB_ICON_ADMENU1;
$adminmenu[1]['link'] = _MI_TWEETBOMB_LINK_ADMENU1;
$adminmenu[2]['title'] = _MI_TWEETBOMB_TITLE_ADMENU2;
$adminmenu[2]['icon'] = _MI_TWEETBOMB_ICON_ADMENU2;
$adminmenu[2]['image'] = _MI_TWEETBOMB_ICON_ADMENU2;
$adminmenu[2]['link'] = _MI_TWEETBOMB_LINK_ADMENU2;
$adminmenu[3]['title'] = _MI_TWEETBOMB_TITLE_ADMENU3;
$adminmenu[3]['icon'] = _MI_TWEETBOMB_ICON_ADMENU3;
$adminmenu[3]['image'] = _MI_TWEETBOMB_ICON_ADMENU3;
$adminmenu[3]['link'] = _MI_TWEETBOMB_LINK_ADMENU3;
$adminmenu[4]['title'] = _MI_TWEETBOMB_TITLE_ADMENU4;
$adminmenu[4]['icon'] = _MI_TWEETBOMB_ICON_ADMENU4;
$adminmenu[4]['image'] = _MI_TWEETBOMB_ICON_ADMENU4;
$adminmenu[4]['link'] = _MI_TWEETBOMB_LINK_ADMENU4;
$adminmenu[5]['title'] = _MI_TWEETBOMB_TITLE_ADMENU5;
$adminmenu[5]['icon'] = _MI_TWEETBOMB_ICON_ADMENU5;
$adminmenu[5]['image'] = _MI_TWEETBOMB_ICON_ADMENU5;
$adminmenu[5]['link'] = _MI_TWEETBOMB_LINK_ADMENU5;
$adminmenu[6]['title'] = _MI_TWEETBOMB_TITLE_ADMENU6;
$adminmenu[6]['icon'] = _MI_TWEETBOMB_ICON_ADMENU6;
$adminmenu[6]['image'] = _MI_TWEETBOMB_ICON_ADMENU6;
$adminmenu[6]['link'] = _MI_TWEETBOMB_LINK_ADMENU6;
$adminmenu[7]['title'] = _MI_TWEETBOMB_TITLE_ADMENU7;
$adminmenu[7]['icon'] = _MI_TWEETBOMB_ICON_ADMENU7;
$adminmenu[7]['image'] = _MI_TWEETBOMB_ICON_ADMENU7;
$adminmenu[7]['link'] = _MI_TWEETBOMB_LINK_ADMENU7;
$adminmenu[9]['title'] = _MI_TWEETBOMB_TITLE_ADMENU9;
$adminmenu[9]['icon'] = _MI_TWEETBOMB_ICON_ADMENU9;
$adminmenu[9]['image'] = _MI_TWEETBOMB_ICON_ADMENU9;
$adminmenu[9]['link'] = _MI_TWEETBOMB_LINK_ADMENU9;
$adminmenu[8]['title'] = _MI_TWEETBOMB_TITLE_ADMENU8;
$adminmenu[8]['icon'] = _MI_TWEETBOMB_ICON_ADMENU8;
$adminmenu[8]['image'] = _MI_TWEETBOMB_ICON_ADMENU8;
$adminmenu[8]['link'] = _MI_TWEETBOMB_LINK_ADMENU8;
$adminmenu[10]['title'] = _MI_TWEETBOMB_TITLE_ADMENU10;
$adminmenu[10]['icon'] = _MI_TWEETBOMB_ICON_ADMENU10;
$adminmenu[10]['image'] = _MI_TWEETBOMB_ICON_ADMENU10;
$adminmenu[10]['link'] = _MI_TWEETBOMB_LINK_ADMENU10;
if (twitterbomb_doesModuleExist($GLOBALS['twitterbombModuleConfig']['myalbum_dirname'], 306)) {
	$adminmenu[11]['title'] = _MI_TWEETBOMB_TITLE_ADMENU11;
	$adminmenu[11]['icon'] = _MI_TWEETBOMB_ICON_ADMENU11;
	$adminmenu[11]['image'] = _MI_TWEETBOMB_ICON_ADMENU11;
	$adminmenu[11]['link'] = _MI_TWEETBOMB_LINK_ADMENU11;
}
$adminmenu[12]['title'] = _MI_TWEETBOMB_TITLE_ADMENU12;
$adminmenu[12]['icon'] = _MI_TWEETBOMB_ICON_ADMENU12;
$adminmenu[12]['image'] = _MI_TWEETBOMB_ICON_ADMENU12;
$adminmenu[12]['link'] = _MI_TWEETBOMB_LINK_ADMENU12;
$adminmenu[13]['title'] = _MI_TWEETBOMB_TITLE_ADMENU13;
$adminmenu[13]['icon'] = _MI_TWEETBOMB_ICON_ADMENU13;
$adminmenu[13]['image'] = _MI_TWEETBOMB_ICON_ADMENU13;
$adminmenu[13]['link'] = _MI_TWEETBOMB_LINK_ADMENU13;
$adminmenu[14]['title'] = _MI_TWEETBOMB_TITLE_ADMENU14;
$adminmenu[14]['icon'] = _MI_TWEETBOMB_ICON_ADMENU14;
$adminmenu[14]['image'] = _MI_TWEETBOMB_ICON_ADMENU14;
$adminmenu[14]['link'] = _MI_TWEETBOMB_LINK_ADMENU14;
?>