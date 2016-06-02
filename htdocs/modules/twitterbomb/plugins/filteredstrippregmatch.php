<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function FilteredstrippregmatchInsertHook($object) {
		return FilteredInsertHook(StripInsertHook(FilteredInsertHook($object)));
	}
	
	function FilteredstrippregmatchGetHook($object, $for_tweet=false) {
		return FilteredGetHook(StripGetHook(FilteredGetHook($object, $for_tweet), $for_tweet), $for_tweet);
	}
	
?>