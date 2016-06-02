<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function FilteredpregmatchstripInsertHook($object) {
		return FilteredInsertHook(PregmatchInsertHook(StripInsertHook($object)));
	}
	
	function FilteredpregmatchstripGetHook($object, $for_tweet=false) {
		return FilteredGetHook(PregmatchGetHook(StripGetHook($object, $for_tweet), $for_tweet), $for_tweet);
	}
	
?>