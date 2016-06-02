<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function FilteredpregmatchInsertHook($object) {
		return PregmatchInsertHook(FilteredInsertHook($object));
	}
	
	function FilteredpregmatchGetHook($object, $for_tweet=false) {
		return PregmatchGetHook(FilteredGetHook($object, $for_tweet), $for_tweet);
	}
	
?>