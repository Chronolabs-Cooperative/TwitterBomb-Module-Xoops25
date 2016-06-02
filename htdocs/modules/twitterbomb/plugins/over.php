<?php

	function OverInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function OverGetHook($object) {
		return $object;
	}
	
?>