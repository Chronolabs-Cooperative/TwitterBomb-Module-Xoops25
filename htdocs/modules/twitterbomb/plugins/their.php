<?php

	function TheirInsertHook($object) {
		return $object->getVar('kid');
	}
	
	function TheirGetHook($object) {
		return $object;
	}

?>