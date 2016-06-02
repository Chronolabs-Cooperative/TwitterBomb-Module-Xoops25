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
class TwitterbombReplies extends XoopsObject
{

    function TwitterbombReplies($fid = null)
    {
        $this->initVar('rpid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('urlid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('rcid', XOBJ_DTYPE_INT, null, false);    
		$this->initVar('reply', XOBJ_DTYPE_TXTBOX, null, false, 140);
		$this->initVar('keywords', XOBJ_DTYPE_TXTBOX, null, false, 500);    
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('type', XOBJ_DTYPE_ENUM, 'reply', true, false, false, array('bomb','reply'));
		$this->initVar('replies', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
		$this->initVar('replied', XOBJ_DTYPE_INT, null, false);		
		
	}

	function getForm() {
		return tweetbomb_replies_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['rpid'].']', $this->getVar('rpid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['rpid'].'[cid]', $this->getVar('cid'), 1, false, true, 'reply');
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['rpid'].'[catid]', $this->getVar('catid'));
		$ele['urlid'] = new TwitterBombFormSelectUrls('', $ret['rpid'].'[urlid]', $this->getVar('urlid'));
		$ele['rcid'] = new TwitterBombFormSelectCampaigns('', $ret['rpid'].'[rcid]', $this->getVar('rcid'), 1, false, true, 'bomb');
		$ele['type'] = new TwitterBombFormSelectType('', $ret['rpid'].'[type]', $this->getVar('type'), 1, false, false, 'bomb,reply');
		$ele['reply'] = new XoopsFormText('', $ret['rpid'].'[reply]', 26,140, $this->getVar('reply'));
		$ele['keywords'] = new XoopsFormTextArea('', $ret['rpid'].'[keywords]', $this->getVar('keywords'), 4, 26);
		
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($ret['replies']>0) {
			$ele['replies'] = new XoopsFormLabel('', $ret['replies']);
		} else {
			$ele['replies'] = new XoopsFormLabel('', '');
		}
		if ($ret['replied']>0) {
			$ele['replied'] = new XoopsFormLabel('', date(_DATESTRING, $ret['replied']));
		} else {
			$ele['replied'] = new XoopsFormLabel('', '');
		}
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
		foreach($ele as $key => $obj) {
			$ret['form'][$key] = $ele[$key]->render(); 
		}
		return $ret;
	}
	
	function runPrePlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('type').'.php'));
		
		switch ($this->getVar('type')) {
			case 'mixed':
			case 'recent':
			case 'poopular':
				$func = ucfirst($this->getVar('type')).'RepliesPreHook';
				break;
			default:
				return $this;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this;
	}
    
	function runPostPlugin($rid) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('type').'.php'));
		
		switch ($this->getVar('type')) {
			case 'mixed':
			case 'recent':
			case 'poopular':
				$func = ucfirst($this->getVar('type')).'RepliesPostHook';
				break;
			default:
				return $rid;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this, $rid);
		}
		return $rid;	
	}
	
	function runGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('type').'.php'));
		
		switch ($this->getVar('type')) {
			case 'mixed':
			case 'recent':
			case 'poopular':
				$func = ucfirst($this->getVar('type')).'RepliesGetHook';
				break;
			default:
				return $this;
				break;
		}
		
		if (function_exists($func))  {
			$object = @$func($this);
			return is_object($object)?$object:$this;
		}
		return $this;	
	}
	
	function getTweet() {
		switch($this->getVar('type')) {
			case 'reply':
				return $this->getVar('reply');
				break;
			case 'bomb':
				$base_matrix_handler=&xoops_getmodulehandler('base_matrix', 'twitterbomb');
				$campaign_handler=&xoops_getmodulehandler('campaign', 'twitterbomb');
				$campaign = $campaign_handler->get($this->getVar('rcid'));
				if (is_object($campaign)) {
					return $base_matrix_handler->getSentence($campaign->getVar('cid'), $campaign->getVar('catid'));
				}
				break;
		}
		return false;
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
class TwitterbombRepliesHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_replies", 'TwitterbombReplies', "rpid", "phrase");
    }
	
function insert($object, $force = true) {
		
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    		else 
    			$object->setVar('uid', 0);
    	} else {
    		$object->setVar('updated', time());
    	}
    	
    	$run_plugin_action=false;
    	if ($object->vars['type']['changed']==true||$object->vars['language']['changed']==true) {	
			$run_plugin_action=true;
			$object->setVar('actioned', time());
		}
    	if ($run_plugin_action){
    		if ($object->runPrePlugin())
    			$rid = parent::insert($object, $force);
    		else 
    			return false;
    	} else 	
    		$rid = parent::insert($object, $force);		
    	if ($run_plugin_action)
    		return $object->runPostPlugin($rid);
    	else 	
    		return $rid;
    }
    
    function get($id, $fields = '*') {
    	$obj = parent::get($id, $fields);
    	if (is_object($obj))
    		return $obj->runGetPlugin();
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true) {
	   	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
    		if (is_object($obj))
    			$objs[$id] = $obj->runGetPlugin();
    	}
    	return $objs;
    }
    
    
	function getObject($cid, $catid, $tweet, $rpids = null) {
    	$criteriaa = new CriteriaCompo(new Criteria('cid', 0), 'OR');
    	$criteriaa->add(new Criteria('catid', 0), 'OR');
    	$criteriab = new CriteriaCompo(new Criteria('cid', $cid), 'OR');
    	$criteriab->add(new Criteria('catid', $catid), 'OR');
    	$criteriac = new CriteriaCompo(new Criteria('cid', $cid), 'AND');
    	$criteriac->add(new Criteria('catid', $catid), 'AND');
    	$tweet = str_replace(array('@', '#'), '', $tweet);
    	$criteriad = new CriteriaCompo();
    	foreach(explode(' ', $tweet) as $node) {
    		$criteriad->add(new Criteria('`keywords`', '%'.strtolower($node).'%', 'LIKE'), 'OR');
    	}
    	$criteriad->add(new Criteria('`keywords`', '', 'LIKE'), 'OR');
    	$criteriad->add(new Criteria('`keywords`', NULL, 'LIKE'), 'OR');
		$criteriae = new CriteriaCompo();
    	foreach(explode(' ', $tweet) as $node) {
    		$criteriae->add(new Criteria('`keywords`', '%-'.strtolower($node).'%', 'NOT LIKE'), 'AND');
    	}
    	$criteriae->add(new Criteria('`keywords`', '', 'LIKE'), 'OR');
    	$criteriae->add(new Criteria('`keywords`', NULL, 'LIKE'), 'OR');
    	$criteriaf = new CriteriaCompo($criteriaa, 'OR');
    	$criteriaf->add($criteriab, 'OR');
    	$criteriaf->add($criteriac, 'OR');
    	$criteriaf->add($criteriad, 'AND');
    	$criteriaf->add($criteriae, 'AND');
    	$criteria = new CriteriaCompo($criteriaf, 'AND');
    	if (is_array($rpids)&&count($rpids)>0)
    		$criteria->add(new Criteria('`rpid`', '('.implode(',',$rpids).')', 'IN'), 'AND');
    	$criteria->setOrder('DESC');
    	$criteria->setSort('RAND()');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	$obj = $this->getObjects($criteria, false);
    	if (is_object($obj[0])) {
    		return $obj[0];
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
    
    
    function getFilterForm($filter, $field, $sort='created', $op = 'replies', $fct='list') {
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