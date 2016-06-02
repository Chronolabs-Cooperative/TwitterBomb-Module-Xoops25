<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function FilteredstripInsertHook($object) {
		return StripInsertHook(FilteredInsertHook($object));
	}
	
	function FilteredstripGetHook($object, $for_tweet=false) {
		return StripGetHook(FilteredGetHook($object, $for_tweet), $for_tweet);
	}
	
?>