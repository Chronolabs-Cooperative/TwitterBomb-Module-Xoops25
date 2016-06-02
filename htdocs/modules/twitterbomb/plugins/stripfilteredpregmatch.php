<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function StripfilteredpregmatchInsertHook($object) {
		return StripInsertHook(FilteredInsertHook(PregmatchInsertHook($object)));
	}
	
	function StripfilteredpregmatchGetHook($object, $for_tweet=false) {
		return StripGetHook(FilteredGetHook(PregmatchGetHook($object, $for_tweet), $for_tweet), $for_tweet);
	}
	
?>