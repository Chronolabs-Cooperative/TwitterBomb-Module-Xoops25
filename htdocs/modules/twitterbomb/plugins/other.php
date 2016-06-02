<?php

	function OtherInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function OtherGetHook($object, $for_tweet) {
		return $object;
	}
	
?>