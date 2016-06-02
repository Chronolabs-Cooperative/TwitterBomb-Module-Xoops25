<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function StrippregmatchfilteredInsertHook($object) {
		return FilteredInsertHook(PregmatchInsertHook(StripInsertHook($object)));
	}
	
	function StrippregmatchfilteredGetHook($object, $for_tweet=false) {
		return FilteredGetHook(PregmatchGetHook(StripInsertHook($object, $for_tweet), $for_tweet), $for_tweet);
	}
	
?>