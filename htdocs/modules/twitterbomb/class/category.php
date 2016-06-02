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
class TwitterbombCategory extends XoopsObject
{

    function TwitterbombCategory($fid = null)
    {
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('pcatdid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 128);
		$this->initVar('hits', XOBJ_DTYPE_INT, null, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('active', XOBJ_DTYPE_INT, null, false);
		    
	}

	function getForm() {
		return tweetbomb_category_get_form($this);
	}

	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['catid'].']', $this->getVar('catid'));
		$ele['pcatdid'] = new TwitterBombFormSelectCategories('', $ret['catid'].'[pcatdid]', $this->getVar('pcatdid'), 1, false, $this->getVar('catid'));
		$ele['name'] = new XoopsFormText('', $ret['catid'].'[name]', 26,64, $this->getVar('name'));
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		}
		if (isset($ret['created']))
			if ($ret['created']>0) {
				$ele['created'] = new XoopsFormLabel('', date(_DATESTRING, $ret['created']));
			} else {
				$ele['created'] = new XoopsFormLabel('', '');
			}
		if (isset($ret['actioned']))
			if ($ret['actioned']>0) {
				$ele['actioned'] = new XoopsFormLabel('', date(_DATESTRING, $ret['actioned']));
			} else {
				$ele['actioned'] = new XoopsFormLabel('', '');
			}
		if (isset($ret['updated']))
			if ($ret['updated']>0) {
				$ele['updated'] = new XoopsFormLabel('', date(_DATESTRING, $ret['updated']));
			} else {
				$ele['updated'] = new XoopsFormLabel('', '');
			}
		if (isset($ret['active']))
			if ($ret['active']>0) {
				$ele['active'] = new XoopsFormLabel('', date(_DATESTRING, $ret['active']));
			} else {
				$ele['active'] = new XoopsFormLabel('', '');
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
class TwitterbombCategoryHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_category", 'TwitterbombCategory', "catid", "name");
    }
    
    function insert($obj, $force=true) {
    	
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$obj->setVar('updated', time());
    	}
    	
    	return parent::insert($obj, $force);
    }
    
    function renderSmarty($catid) {
    	if ($catid>0)
    		$criteria = new CriteriaCompo(new Criteria('pcatdid', $catid));
    	else { 
    		$criteria = new CriteriaCompo(new Criteria('pcatdid', '0'));
    	}
    	$objs = parent::getObjects($criteria, true);
    	$ret = array();
    	$id = array();
    	foreach($objs as $catid => $category) {
    		if (!in_array($catid, $id)) {
	    		$id[] = $catid;
	    		$ret[$catid]['catid'] = $catid;
	    		$ret[$catid]['name'] = $category->getVar('name');
	    		$ret[$catid]['hits'] = $category->getVar('hits');	
	    		$ret[$catid]['subitems'] = parent::getCount(new Criteria('pcatdid', $catid));
	    		if ($ret[$catid]['subitems']>0) {
	    			foreach(parent::getObjects(new Criteria('pcatdid', $catid), true) as $scatid => $scategory) {
	    				if (!in_array($scatid, $id)) {
	    					$id[] = $scatid;
		    				$ret[$catid]['subcategories'][$scatid]['catid'] = $scatid;
		    				$ret[$catid]['subcategories'][$scatid]['name'] = $scategory->getVar('name');
		    				$ret[$catid]['subcategories'][$scatid]['hits'] = $scategory->getVar('hits');
	    				}
	    			}
	    		}
    		}
    	}
    	return $ret;
    }
    
    function plusHit($catid=0) {
    	if ($catid==0)
    		return false;
    	$sql = "UPDATE " . $GLOBALS['xoopsDB']->prefix('twitterbomb_category') . " SET 	`hits` = `hits` + 1, `active` = '".time()."' WHERE `catid` = '".$catid."'";
    	if ($GLOBALS['xoopsDB']->queryF($sql)) {
    		return true;
    	} else {
    		return false;
    	}
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
    
    
    function getFilterForm($filter, $field, $sort='created', $op = 'category', $fct='list') {
    	$ele = tweetbomb_getFilterElement($filter, $field, $sort, $op, $fct);
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