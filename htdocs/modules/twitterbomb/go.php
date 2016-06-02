<?php
	include('header.php');	
	
	$cid = isset($_REQUEST['cid'])?intval($_REQUEST['cid']):0;
	$sid = isset($_REQUEST['sid'])?intval($_REQUEST['sid']):0;
	$lid = isset($_REQUEST['lid'])?intval($_REQUEST['lid']):0;
	$catid = isset($_REQUEST['catid'])?intval($_REQUEST['catid']):0;
	$uri = isset($_REQUEST['uri'])?$_REQUEST['uri']:'';
	
	if ($cid==0||$url=''||$catid==0) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.XOOPS_URL);
		exit(0);
	}
	
	if ($sid!=0) {
		$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
		$scheduler_handler->plusHit($sid);
	}           	
	if ($lid!=0) {
		$log_handler =& xoops_getmodulehandler('log', 'twitterbomb');
		$log_handler->plusHit($lid);
	}
	if ($cid!=0) {
		$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
		$campaign_handler->plusHit($cid);
	}
	if ($catid!=0) {
		$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
		$category_handler->plusHit($catid);
	}	
	header( "HTTP/1.1 301 Moved Permanently" ); 
	header('Location: '.$uri);

?>