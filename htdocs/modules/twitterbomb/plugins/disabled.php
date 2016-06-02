<?php

	function DisabledInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function DisabledGetHook($object, $for_tweet) {
		return $object;
	}
	
?>