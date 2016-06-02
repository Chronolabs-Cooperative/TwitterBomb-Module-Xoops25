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
class TwitterbombUsernames extends XoopsObject
{

    function TwitterbombUsernames($fid = null)
    {
        $this->initVar('tid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('oid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);        
		$this->initVar('screen_name', XOBJ_DTYPE_TXTBOX, null, true, 64);   
		$this->initVar('id', XOBJ_DTYPE_TXTBOX, null, true, 128);
		$this->initVar('avarta', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 128);
		$this->initVar('description', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('indexed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('followed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
		$this->initVar('type', XOBJ_DTYPE_ENUM, 'bomb', false, false, false, array('bomb', 'scheduler','reply','mentions'));
		$this->initVar('source_nick', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('tweeted', XOBJ_DTYPE_INT, null, false);
	}

	function getForm() {
		return tweetbomb_usernames_get_form($this);
	}

	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['tid'].']', $this->getVar('tid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['tid'].'[cid]', $this->getVar('cid'));
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['tid'].'[catid]', $this->getVar('catid'));
		$ele['type'] = new TwitterBombFormSelectType('', $ret['cid'].'[type]', $this->getVar('type'));
		$ele['screen_name'] = new XoopsFormText('', $ret['tid'].'[screen_name]', 45, 64, $this->getVar('screen_name'));
		$ele['source_nick'] = new XoopsFormText('', $ret['tid'].'[source_nick]', 45, 64, $this->getVar('source_nick'));
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
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
		if ($ret['tweeted']>0) {
			$ele['tweeted'] = new XoopsFormLabel('', date(_DATESTRING, $ret['tweeted']));
		} else {
			$ele['tweeted'] = new XoopsFormLabel('', '');
		}
		foreach($ele as $key => $obj) {
			$ret['form'][$key] = $ele[$key]->render(); 
		}
		return $ret;
	}

	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('type').'.php'));
		
		switch ($this->getVar('type')) {
			case 'bomb':
			case 'scheduler':
				$func = ucfirst($this->getVar('type')).'InsertHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('tid');
	}
	
	function runGetPlugin($for_tweet=false) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('type').'.php'));
		
		switch ($this->getVar('type')) {
			case 'bomb':
			case 'scheduler':
				$func = ucfirst($this->getVar('type')).'GetHook';
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
}


/**
* XOOPS Spider handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class TwitterbombUsernamesHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_usernames", 'TwitterbombUsernames', "tid", "screen_name");
    }
	
    function insert($obj, $force=true) {
    	
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    		if ($this->getCount(new Criteria('`screen_name`', $obj->getVar('screen_name')))) {
    			return false;
    		}
    	} else {
    		if ($obj->vars['screen_name']['changed']==true)
	    		if ($this->getCount(new Criteria('`screen_name`', $obj->getVar('screen_name')))) {
	    			return false;
	    		}
    		$obj->setVar('updated', time());
    	}
        
    	$run_plugin = false;
    	if ($obj->vars['type']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
     	
    	if ($run_plugin == true) {
    		$id = parent::insert($obj, $force);
    		$obj = parent::get($id);
    		if (is_object($obj)) {
	    		$ret = $obj->runInsertPlugin();
	    		return ($ret!=0)?$ret:$id;
    		} else {
    			return $id;
    		}
    	} else {
    		return parent::insert($obj, $force);
    	}
    }
    
    function getUser($cid, $catid, $source_nick='') {
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
    	if (!empty($source_nick)) {
    		$criteria->add(new Criteria('source_nick', $source_nick, 'LIKE'));
    		$criteria->add(new Criteria('`type`', 'scheduler'));
    	} else {
    		$criteria->add(new Criteria('`type`', 'bomb'));
    	}
    	$criteria->setOrder('DESC');
    	$criteria->setSort('RAND()');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	$obj = parent::getObjects($criteria, false);
    	if (is_object($obj[0])) {
    		$obj[0]->setVar('tweeted', time());
    		parent::insert($obj[0], true);
    		return trim($obj[0]->getVar('screen_name'));
    	}
    }

    function getSourceUser($cid, $catid, $sentence='', $type='',$for_tweet=false, $as_object=true, $start=0, $limit=1, $id_as_key=true) {
    	if ($limit>0) {
    		if (empty($type))
    			$sql = "SELECT * FROM " . $GLOBALS['xoopsDB']->prefix('twitterbomb_usernames'). ' WHERE ((`cid`=0 OR `catid`=0) OR (`cid`='.$cid.' AND `catid`='.$catid.') OR (`cid`='.$cid.' OR `catid`='.$catid.')) AND (("'.$sentence.'" LIKE concat("%", `source_nick`, "%") AND (`source_nick` <> "")) ORDER BY RAND() DESC LIMIT '.$start.','.$limit;
    		else 
    		 	$sql = "SELECT * FROM " . $GLOBALS['xoopsDB']->prefix('twitterbomb_usernames'). ' WHERE ((`cid`=0 OR `catid`=0) OR (`cid`='.$cid.' AND `catid`='.$catid.') OR (`cid`='.$cid.' OR `catid`='.$catid.')) AND (("'.$sentence.'" LIKE concat("%", `source_nick`, "%") AND (`source_nick` <> "" AND `type` = "'.$type.'")) ORDER BY RAND() DESC LIMIT '.$start.','.$limit;
    	} else { 
    		if (empty($type))
    			$sql = "SELECT * FROM " . $GLOBALS['xoopsDB']->prefix('twitterbomb_usernames'). ' WHERE ((`cid`=0 OR `catid`=0) OR (`cid`='.$cid.' AND `catid`='.$catid.') OR (`cid`='.$cid.' OR `catid`='.$catid.')) AND (("'.$sentence.'" LIKE concat("%", `source_nick`, "%") AND (`source_nick` <> "")) ORDER BY RAND() DESC';
    		else 
    			$sql = "SELECT * FROM " . $GLOBALS['xoopsDB']->prefix('twitterbomb_usernames'). ' WHERE ((`cid`=0 OR `catid`=0) OR (`cid`='.$cid.' AND `catid`='.$catid.') OR (`cid`='.$cid.' OR `catid`='.$catid.')) AND (("'.$sentence.'" LIKE concat("%", `source_nick`, "%") AND (`source_nick` <> "" AND `type` = "'.$type.'")) ORDER BY RAND() DESC';
    	}
		$result = $GLOBALS['xoopsDB']->queryF($sql);
		$ret = array();
    	while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    		if ($limit==1) {
	    		if ($as_object==false)
	    			return $row;
	    		else {
	    			$object = new TwitterbombUsernames();
	    			$object->assignVars($row);
	    			return $object->runGetPlugin($for_tweet);
	    		}
    		} elseif ($limit==0 || $limit>1) {
    			if ($as_object==false)
	    			if ($id_as_key==true)
    					$ret[$row['tid']] = $row;
    				else 
    					$ret[] = $row;
	    		else {
	    			$object = new TwitterbombUsernames();
	    			$object->assignVars($row);
	    			if ($id_as_key==true)
	    				$ret[$row['tid']] = $object->runGetPlugin($for_tweet);
	    			else 
	    				$ret[] = $object->runGetPlugin($for_tweet);
	    		}
    		}
    	}
    	return $ret;
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
    				$criteria->add(new Criteria('`'.$var[0].'`', "%".$var[1]."%", (isset($var[2])?$var[2]:'LIKE')));
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
    			$criteria->add(new Criteria("'".$var[0]."'", $var[1]));
    		}
    	}
    	return $criteria;
    }
       
    function getFilterForm($filter, $field, $sort='created', $op = 'usernames', $fct='list') {
    	$ele = tweetbomb_getFilterElement($filter, $field, $sort, $op, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
    function get($id, $fields = '*', $for_tweet=false) {
    	$obj = parent::get($id, $fields);
    	if (is_object($obj))
    		return $obj->runGetPlugin($for_tweet);
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true, $for_tweet=false) {
	   	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
    		if (is_object($obj))
    			$objs[$id] = $obj->runGetPlugin($for_tweet);
    	}
    	return $objs;
    }
    
	function delete($id_or_object, $force = true) {
    	if (is_numeric($id_or_object))
    		return parent::deleteAll(new Criteria('`'.$this->keyName.'`', $id_or_object), $force);
    	elseif (is_object($id_or_object))
    		return parent::delete($id_or_object, $force);
    }
    
}
?>