<?php
	
	function FilteredInsertHook($object) {
		if (is_object($object))
			return $object->getVar('sid');
		elseif(is_numeric($object))
			return $object;
	}
	
	function FilteredGetHook($object, $for_tweet=false) {
		switch ($for_tweet)
		{
			case false;
				return $object;
				break;
			case true;
				$object->vars['text']['value'] = str_replace($object->getVar('search'), $object->getVar('replace'), $object->vars['text']['value']);
				return $object;
				break;	
		}
	}
?>