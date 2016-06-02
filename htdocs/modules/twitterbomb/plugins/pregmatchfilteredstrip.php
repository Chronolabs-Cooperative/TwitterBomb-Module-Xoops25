<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function PregmatchfilteredstripInsertHook($object) {
		return StripInsertHook(FilteredInsertHook(PregmatchInsertHook($object)));
	}
	
	function PregmatchfilteredstripGetHook($object, $for_tweet=false) {
		return StripInsertHook(FilteredGetHook(PregmatchGetHook($object, $for_tweet), $for_tweet), $for_tweet);
	}
	
?>