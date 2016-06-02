<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function PregmatchfilteredInsertHook($object) {
		return FilteredInsertHook(PregmatchInsertHook($object));
	}
	
	function PregmatchfilteredGetHook($object, $for_tweet=false) {
		return FilteredGetHook(PregmatchGetHook($object, $for_tweet), $for_tweet);
	}
	
?>