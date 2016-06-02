<?php

	function BombInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function BombGetHook($object, $for_tweet) {
		return $object;
	}

	function BombLogPreHook($default, $object) {
		return $object;
	}
	
	function BombLogPostHook($object, $lid) {
		return $lid;
	}
?>