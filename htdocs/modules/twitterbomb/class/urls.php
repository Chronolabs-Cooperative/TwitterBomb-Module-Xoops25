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
class TwitterbombUrls extends XoopsObject
{

    function TwitterbombUrls($fid = null)
    {
        $this->initVar('urlid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('surl', XOBJ_DTYPE_TXTBOX, null, true, 255);    
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);    
		$this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);		
	}

	function getForm() {
		return tweetbomb_urls_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['urlid'].']', $this->getVar('urlid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['urlid'].'[cid]', $this->getVar('cid'));
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['urlid'].'[catid]', $this->getVar('catid'));
		$ele['surl'] = new XoopsFormText('', $ret['urlid'].'[surl]', 45,255, $this->getVar('surl'));
		$ele['name'] = new XoopsFormText('', $ret['urlid'].'[name]', 26,64, $this->getVar('name'));
		$ele['description'] = new XoopsFormTextArea('', $ret['urlid'].'[catid]', 26, 4, $this->getVar('description'));
		
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
class TwitterbombUrlsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_urls", 'TwitterbombUrls', "urlid", "surl");
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
    
	function getUrl($cid, $catid) {
    	$criteriaa = new CriteriaCompo(new Criteria('cid', 0), 'OR');
    	$criteriaa->add(new Criteria('catid', 0), 'OR');
    	$criteriab = new CriteriaCompo(new Criteria('cid', $cid), 'AND');
    	$criteriab->add(new Criteria('catid', $catid), 'OR');
    	$criteriac = new CriteriaCompo(new Criteria('cid', $cid), 'AND');
    	$criteriac->add(new Criteria('catid', $catid), 'AND');
    	$criteriad = new CriteriaCompo($criteriaa, 'OR');
    	$criteriad->add($criteriab, 'OR');
    	$criteriad->add($criteriac, 'OR');
    	$criteria = new CriteriaCompo($criteriad, 'OR');
    	$criteria->setOrder('DESC');
    	$criteria->setSort('RAND()');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	$obj = parent::getObjects($criteria, false);
    	if (is_object($obj[0])) {
    		return trim($obj[0]->getVar('surl'));
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
    
    
    function getFilterForm($filter, $field, $sort='created', $op = 'urls', $fct='list') {
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