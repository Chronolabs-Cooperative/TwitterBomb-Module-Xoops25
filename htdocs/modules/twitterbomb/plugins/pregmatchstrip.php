<?php

	include('strip.php');
	include('filtered.php');
	include('pregmatch.php');
	
	function PregmatchstripInsertHook($object) {
		return StripInsertHook(PregmatchInsertHook($object));
	}
	
	function PregmatchstripGetHook($object, $for_tweet=false) {
		return StripGetHook(PregmatchGetHook($object, $for_tweet), $for_tweet);
	}
	
?>