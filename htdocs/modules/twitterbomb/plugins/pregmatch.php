<?php
	function PregmatchInsertHook($object) {
		if (is_object($object))
			return $object->getVar('sid');
		elseif(is_numeric($object))
			return $object;
	}
	
	function PregmatchGetHook($object, $for_tweet=false) {
		switch ($for_tweet)
		{
			case false;
				return $object;
				break;
			case true;
				$object->vars['text']['value'] = preg_replace((strpos($object->getVar('pregmatch'), '|',0)>0?explode('|',$object->getVar('pregmatch')):$object->getVar('pregmatch')), (strpos($object->getVar('pregmatch_replace'), '|',0)>0?explode('|',$object->getVar('pregmatch_replace')):$object->getVar('pregmatch_replace')), $object->vars['text']['value']);
				return $object;
				break;	
		}
	}