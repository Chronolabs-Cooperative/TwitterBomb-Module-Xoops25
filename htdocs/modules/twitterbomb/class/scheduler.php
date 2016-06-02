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
class TwitterbombScheduler extends XoopsObject
{
	
    function TwitterbombScheduler($fid = null)
    {
        $this->initVar('sid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, 0, false);         
        $this->initVar('mode', XOBJ_DTYPE_ENUM, 'direct', false, false, false, array('direct','filtered','pregmatch','strip','pregmatchstrip','strippregmatch','filteredstrip','stripfiltered','filteredpregmatch','pregmatchfiltered','filteredpregmatchstrip','filteredstrippregmatch','pregmatchfilteredstrip','pregmatchstripfiltered','strippregmatchfiltered','stripfilteredpregmatch','mirc'));
        $this->initVar('pre', XOBJ_DTYPE_TXTBOX, null, false, 35);
        $this->initVar('text', XOBJ_DTYPE_TXTBOX, null, true, 500);
		$this->initVar('search', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('replace', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('strip', XOBJ_DTYPE_ARRAY, array('[', ']', '{', '}', '|', '@', '#'), false);
		$this->initVar('pregmatch', XOBJ_DTYPE_TXTBOX, null, false, 500);
		$this->initVar('pregmatch_replace', XOBJ_DTYPE_TXTBOX, null, false, 500);        
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('hits', XOBJ_DTYPE_INT, null, false);
		$this->initVar('rank', XOBJ_DTYPE_INT, null, false);
		$this->initVar('when', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('tweeted', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		
   	}

	function getForm() {
		return tweetbomb_scheduler_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['sid'].']', $this->getVar('sid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['sid'].'[cid]', $this->getVar('cid'), 1, false, false, 'scheduler');
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['sid'].'[catid]', $this->getVar('catid'));
		$ele['mode'] = new TwitterBombFormSelectMode('', $ret['sid'].'[mode]', $this->getVar('mode'), 1, false, false);
		$ele['text'] = new XoopsFormText('', $ret['sid'].'[text]', 38, 500, $this->getVar('text'));
		$ele['pre'] = new XoopsFormText('', $ret['sid'].'[pre]', 25, 35, $this->getVar('pre'));
		$ele['replace'] = new XoopsFormText('', $ret['sid'].'[replace]', 25, 200, implode('|', $this->getVar('replace')));
		$ele['strip'] = new XoopsFormText('', $ret['sid'].'[strip]', 25, 200, implode('|', $this->getVar('strip')));
		$ele['search'] = new XoopsFormText('', $ret['sid'].'[search]', 25, 200, implode('|', $this->getVar('search')));
		$ele['pregmatch'] = new XoopsFormText('', $ret['sid'].'[pregmatch]', 25, 500, $this->getVar('pregmatch'));
		$ele['pregmatch_replace'] = new XoopsFormText('', $ret['sid'].'[pregmatch_replace]', 25, 500, $this->getVar('pregmatch_replace'));
		$ele['hits'] = new XoopsFormLabel('', $ret['hits']);
		$ele['rank'] = new XoopsFormLabel('', number_format(($this->getVar('rank')/$this->_modConfig['number_to_rank'])*100, 2).'%');
	    if ($this->_modConfig['tags']) {
	    	$log_handler = xoops_getmodulehandler('log', 'twitterbomb');
	    	if ($log_handler->getCount(new Criteria('sid', $this->getVar('sid')))>0) {
	    		$logs = $log_handler->getObjects(new Criteria('sid', $this->getVar('sid')), false);
	    		if (is_object($logs[0])) {
			    	include_once XOOPS_ROOT_PATH."/modules/tag/include/tagbar.php";
					$ret['tagbar'] = tagBar($logs[0]->getVar('lid'), $logs[0]->getVar('catid'));
	    		}
	    	}
    	}
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($ret['when']>0) {
			$ele['when'] = new XoopsFormLabel('', date(_DATESTRING, $ret['when']));
		} else {
			$ele['when'] = new XoopsFormLabel('', '');
		}
		if ($ret['tweeted']>0) {
			$ele['tweeted'] = new XoopsFormLabel('', date(_DATESTRING, $ret['tweeted']));
		} else {
			$ele['tweeted'] = new XoopsFormLabel('', '');
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

    function getTweet() {
    	
    	$myts = MyTextSanitizer::getInstance();
    	
    	if (is_object($this))
    		$ret = $this->runGetPlugin(true);
    		
    	if (is_string($ret)&&!is_object($ret)) {
    		return array('sid'=> $this->getVar('sid'), 'tweet' => ucfirst(trim((strlen($this->getVar('pre'))>0?$this->getVar('pre').' ':'').$myts->censorString($ret))));
    	} else {
	    	if (is_object($ret))
	    		return array('sid'=> $this->getVar('sid'), 'tweet' => ucfirst(trim((strlen($this->getVar('pre'))>0?$this->getVar('pre').' ':'').$myts->censorString($ret->getVar('text')))));
	    	else 
	    		return '';
    	}
    	
    }
    
	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('mode').'.php'));
		
		switch ($this->getVar('mode')) {
			case 'direct':
			case 'filtered':
			case 'pregmatch':
			case 'strip':
			case 'pregmatchstrip':
			case 'strippregmatch':
			case 'filteredstrip':
			case 'stripfiltered':
			case 'filteredpregmatch':
			case 'pregmatchfiltered':
			case 'filteredpregmatchstrip':
			case 'filteredstrippregmatch':
			case 'pregmatchfilteredstrip':
			case 'pregmatchstripfiltered':
			case 'strippregmatchfiltered':
			case 'stripfilteredpregmatch':
			case 'mirc':				
				$func = ucfirst($this->getVar('mode')).'InsertHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('sid');
	}
	
	function runGetPlugin($for_tweet=false) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('mode').'.php'));
		
		switch ($this->getVar('mode')) {
			case 'direct':
			case 'filtered':
			case 'pregmatch':
			case 'strip':
			case 'pregmatchstrip':
			case 'strippregmatch':
			case 'filteredstrip':
			case 'stripfiltered':
			case 'filteredpregmatch':
			case 'pregmatchfiltered':
			case 'filteredpregmatchstrip':
			case 'filteredstrippregmatch':
			case 'pregmatchfilteredstrip':
			case 'pregmatchstripfiltered':
			case 'strippregmatchfiltered':
			case 'stripfilteredpregmatch':
			case 'mirc':				
				$func = ucfirst($this->getVar('mode')).'GetHook';
				break;
			default:
				return false;
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
class TwitterbombSchedulerHandler extends XoopsPersistableObjectHandler
{
	var $_mod = NULL;
	var $_modConfig = array();
	
	function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_scheduler", 'TwitterbombScheduler', "sid", "text");
        
        $module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$this->_mod = $module_handler->getByDirname('twitterbomb');
		$this->_modConfig = $config_handler->getConfigList($this->_mod->getVar('mid'));
    }
	
    function insert($obj, $force=true) {
    	$this->recalc();
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$obj->setVar('updated', time());
    	}
    	$run_plugin = false;
    	if ($obj->vars['mode']['changed']==true) {	
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
    
    function getTweet($cid='0', $catid='0', $when='0', $tweeted='0') {
    	$this->recalc();
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
    	$criteria->add(new Criteria('`when`', $when, '='), 'AND');
    	$criteria->add(new Criteria('`tweeted`', $tweeted, '='), 'AND');
    	$criteria->setOrder('ASC');
    	$criteria->setSort('`created`, `sid`, `when`, `tweeted`');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	$obj = parent::getObjects($criteria, false);
    	
    	if (is_object($obj[0])) {
    		
    		if ($obj[0]->getVar('when')==0) {
	    		$obj[0]->setVar('when', time(), true);
	    		@parent::insert($obj[0], true);
    		}	
    		if (is_object($obj[0]))
    			$tweet = $obj[0]->getTweet(true);
    		else 
    			$tweet = null;
    	}
    	
    	return $tweet;
    }
    
    function get($id, $fields = '*') {
    	$obj = parent::get($id, $fields);
    	if (is_object($obj))
    		return @$obj->runGetPlugin(false);
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true) {
    	if ($criteria->limit==0)
    		$criteria->setLimit($this->_modConfig['scheduler_items']);
	   	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
    		if (is_object($obj))
    			$objs[$id] = @$obj->runGetPlugin(false);
    	}
    	return $objs;
    }
    
	function getUploadForm() {
		return tweetbomb_scheduler_get_upload_form($this);
	}
	
	function plusHit($sid) {
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler').' SET `hits` = `hits` + 1 WHERE `sid` = '.$sid;
        $GLOBALS['xoopsDB']->queryF($sql);
        return $this->recalc();
	}
	
    function recalc() {
    	// Recalculating Ranking Tweets
    	if ($this->_modConfig['number_to_rank']!=0) {
    		// Reset Rank
	   		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler'). ' SET `rank` = 0 WHERE `rank` <> 0';
	   		@$GLOBALS['xoopsDB']->queryF($sql);
	    	//Recalculate rank
    		$criteria = new CriteriaCompo(new Criteria('`hits`', 0, '>'));
		    $criteria->setOrder('DESC');
		    $criteria->setSort('`hits`');
		    $criteria->setStart(0);
		    $criteria->setLimit($this->_modConfig['number_to_rank']);
		    $rank = $this->_modConfig['number_to_rank'];
		    $objs = parent::getObjects($criteria, true);
		    foreach($objs as $sid=>$obj) {
		    	$obj->setVar('rank', $rank);
		    	parent::insert($obj, true);
		    	$rank--;
		    }
    	}
    	
    	// Kill Old Tweets
    	if ($this->_modConfig['kill_tweeted']!=0) {
	    	$criteria = new CriteriaCompo(new Criteria('tweeted', time()-$this->_modConfig['kill_tweeted'], '<'));
	    	$criteria->add(new Criteria('when', time()-$this->_modConfig['kill_tweeted'], '<'));
	    	$criteria->add(new Criteria('rank', 0, '='));
	    	$criteria->add(new Criteria('when', 0, '>'));
	    	$criteria->add(new Criteria('tweeted', 0, '>'));
	    	@$this->deleteAll($criteria, $force);
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
    
       
    function getFilterForm($filter, $field, $sort='sid', $op = 'scheduler', $fct='list') {
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