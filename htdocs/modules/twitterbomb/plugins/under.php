<?php

	function UnderInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function UnderGetHook($object) {
		return $object;
	}
	
?>