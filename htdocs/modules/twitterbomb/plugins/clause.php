<?php

	function ClauseInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function ClauseGetHook($object) {
		return $object;
	}
	
?>