<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function StrippregmatchInsertHook($object) {
		return PregmatchInsertHook(StripInsertHook($object));
	}
	
	function StrippregmatchGetHook($object, $for_tweet=false) {
		return PregmatchGetHook(StripGetHook($object, $for_tweet), $for_tweet);
	}
	
?>