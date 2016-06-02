<?php

	function WhenInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function WhenGetHook($object) {
		return $object;
	}
	
?>