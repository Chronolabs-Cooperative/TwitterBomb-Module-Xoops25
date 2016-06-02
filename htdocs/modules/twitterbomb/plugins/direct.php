<?php

	function DirectInsertHook($object) {
		return $object->getVar('sid');
	}
	
	function DirectGetHook($object, $for_tweet=false) {
		return $object;
	}
	
?>