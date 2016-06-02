<?php

	function ThenInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function ThenGetHook($object) {
		return $object;
	}
	
?>