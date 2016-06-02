<?php

	function ThereInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function ThereGetHook($object) {
		return $object;
	}
	
?>