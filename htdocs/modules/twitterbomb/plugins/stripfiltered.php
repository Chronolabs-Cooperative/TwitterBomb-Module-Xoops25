<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function StripfilteredInsertHook($object) {
		return FilteredInsertHook(StripInsertHook($object));
	}
	
	function StripfilteredGetHook($object, $for_tweet=false) {
		return FilteredGetHook(StripGetHook($object, $for_tweet), $for_tweet);
	}
	
?>