<?php

	function ValidInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function ValidGetHook($object, $for_tweet) {
		return $object;
	}
	
?>