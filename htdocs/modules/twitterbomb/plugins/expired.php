<?php

	function ExpiredInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function ExpiredGetHook($object, $for_tweet) {
		return $object;
	}
	
?>