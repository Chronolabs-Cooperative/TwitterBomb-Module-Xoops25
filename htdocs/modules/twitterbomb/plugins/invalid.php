<?php

	function InvalidInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function InvalidGetHook($object, $for_tweet) {
		return $object;
	}
	
?>