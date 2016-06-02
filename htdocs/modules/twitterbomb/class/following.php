<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Spiders
 * @author Simon Roberts (simon@xoops.org)
 * @copyright copyright (c) 2000-2009 XOOPS.org
 * @package kernel
 */
class TwitterbombFollowing extends XoopsObject
{

    function TwitterbombFollowing($fid = null)
    {
        $this->initVar('fid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('id', XOBJ_DTYPE_INT, null, false, 128);
        $this->initVar('flid', XOBJ_DTYPE_INT, null, false, 128);
        $this->initVar('followed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
	}

	function toArray() {
		$ret = parent::toArray();
		if ($ret['created']>0) {
			$ele['created'] = new XoopsFormLabel('', date(_DATESTRING, $ret['created']));
		} else {
			$ele['created'] = new XoopsFormLabel('', '');
		}
		if ($ret['actioned']>0) {
			$ele['actioned'] = new XoopsFormLabel('', date(_DATESTRING, $ret['actioned']));
		} else {
			$ele['actioned'] = new XoopsFormLabel('', '');
		}
		if ($ret['updated']>0) {
			$ele['updated'] = new XoopsFormLabel('', date(_DATESTRING, $ret['updated']));
		} else {
			$ele['updated'] = new XoopsFormLabel('', '');
		}
		if ($ret['followed']>0) {
			$ele['followed'] = new XoopsFormLabel('', date(_DATESTRING, $ret['followed']));
		} else {
			$ele['followed'] = new XoopsFormLabel('', '');
		}
		foreach($ele as $key => $obj) {
			$ret['form'][$key] = $ele[$key]->render(); 
		}
		return $ret;
	}

}


/**
* XOOPS Spider handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class TwitterbombFollowingHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_following", 'TwitterbombFollowing', "fid", "flid");
    }
	
    function insert($obj, $force=true) {
    	
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    	} else {
    		$obj->setVar('updated', time());
    	}
        
    	return parent::insert($obj, $force);
    }
    
    function criteriaAssocWithID($ids, $field = 'id') {
    	if (is_array($ids)) {
	    	$criteria = new Criteria('id', '('.implode(',', $ids).')', 'IN');
	    	$ret = array();
	    	foreach($this->getObjects($criteria, true) as $fid => $following) {
	    		$ret[$following->getVar('flid')] = $following->getVar('flid');
	    		$ret[$following->getVar('id')] = $following->getVar('id');
	    	}
	    	if (is_array($ret)&&!empty($ret)) {
	   	 		return new Criteria($field, '('.implode(',', $ret).')', 'IN');
	    	} else { 
	   	 		return new Criteria('1', '1', '=');
	    	}
    	} elseif (is_numeric($ids)&&intval($ids)!=0) {
    		$criteria = new Criteria('id', $ids, '=');
	    	$ret = array();
	    	foreach($this->getObjects($criteria, true) as $fid => $following) {
	    		$ret[$following->getVar('flid')] = $following->getVar('flid');
	    		$ret[$following->getVar('id')] = $following->getVar('id');
	    	}
	    	if (is_array($ret)&&!empty($ret)) {
	   	 		return new Criteria($field, '('.implode(',', $ret).')', 'IN');
	    	} else { 
	   	 		return new Criteria('1', '1', '=');
	    	}
    	}
    	return new Criteria('1', '1', '=');
    }
    
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria($var[0], $var[1]));
    		}
    	}
    	return $criteria;
    }
       
    function getFilterForm($filter, $field, $sort='created') {
    	$ele = tweetbomb_getFilterElement($filter, $field, $sort);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }

    function delete($id_or_object, $force = true) {
    	if (is_numeric($id_or_object))
    		return parent::deleteAll(new Criteria('`'.$this->keyName.'`', $id_or_object), $force);
    	elseif (is_object($id_or_object))
    		return parent::delete($id_or_object, $force);
    }
    
}
?>