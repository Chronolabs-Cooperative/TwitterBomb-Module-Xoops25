<?php

	function SchedulerInsertHook($object) {
		return $object->getVar('oid');
	}
	
	function SchedulerGetHook($object, $for_tweet) {
		return $object;
	}

	function SchedulerLogPreHook($default, $object) {
		return $object;
	}
	
	function SchedulerLogPostHook($object, $lid) {
		return $lid;
	}
?>