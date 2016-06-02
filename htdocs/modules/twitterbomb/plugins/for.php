<?php

	function ForInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function ForGetHook($object) {
		return $object;
	}
	
?>
