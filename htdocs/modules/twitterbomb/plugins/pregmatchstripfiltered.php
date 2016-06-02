<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function PregmatchstripfilteredInsertHook($object) {
		return FilteredInsertHook(StripInsertHook(PregmatchInsertHook($object)));
	}
	
	function PregmatchfilteredstripGetHook($object, $for_tweet=false) {
		return FilteredGetHook(StripInsertHook(PregmatchGetHook($object, $for_tweet), $for_tweet), $for_tweet);
	}
	
?>