<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room TwitterBomb Log
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class TwitterBombLog extends XoopsObject
{

    function TwitterBombLog($id = null)
    {
        $this->initVar('lid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('provider', XOBJ_DTYPE_ENUM, 'bomb', false, false, false, array('bomb', 'scheduler', 'retweet', 'reply', 'mention', 'pictures'));
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('tid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('oid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rpid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('picid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('alias', XOBJ_DTYPE_TXTBOX, false, false, 64);
		$this->initVar('tweet', XOBJ_DTYPE_TXTBOX, false, false, 140);
		$this->initVar('url', XOBJ_DTYPE_TXTBOX, false, false, 500);
		$this->initVar('date', XOBJ_DTYPE_INT, null, false);
		$this->initVar('cid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('hits', XOBJ_DTYPE_INT, null, false);
		$this->initVar('rank', XOBJ_DTYPE_INT, null, false);
		$this->initVar('active', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tags', XOBJ_DTYPE_TXTBOX, false, false, 255);
		$this->initVar('id', XOBJ_DTYPE_INT, false, false, 128);
		$this->initVar('about_id', XOBJ_DTYPE_INT, false, false, 128);
    }

    function getTotalHitsOnAlias() {
    	$sql = "SELECT SUM(`hits`) as `hits` FROM `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log').'` WHERE `alias` = "' . $this->getVar('alias'). '" AND  `provider` = "' . $this->getVar('provider'). '"';
    	list($hits) = $GLOBALS['xoopsDB']->fetchRow($GLOBALS['xoopsDB']->queryF($sql));
    	return $hits;
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	if ($this->getVar('date')<>0)
    		$ret['date_datetime'] = date(_DATESTRING, $this->getVar('date'));
    	if ($this->getVar('active')<>0)
    		$ret['active_datetime'] = date(_DATESTRING, $this->getVar('active'));
    	$ret['provider'] = ucfirst($this->getVar('provider'));
    	$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
    	if ($this->getVar('cid')<>0) {
    		$campaign = $campaign_handler->get($this->getVar('cid'));
    		if (is_object($campaign))
    			$ret['cid_text'] = $campaign->getVar('name');
    	}
	    $category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
    	if ($this->getVar('catid')<>0) {
    		$category = $category_handler->get($this->getVar('cid'));
    		if (is_object($category))
    			$ret['catid_text'] = $category->getVar('name');
    	}
    	if ($GLOBALS['twitterbombModuleConfig']['tags']) {
	    	include_once XOOPS_ROOT_PATH."/modules/tag/include/tagbar.php";
			$ret['tagbar'] = tagBar($this->getVar('lid'), $this->getVar('catid'));
    	}
    	foreach($ret as $key => $value)
    		$ret[str_replace('-', '_', $key)] = $value;
    	return $ret;
    }
    
    function runPrePlugin($default = true) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('provider').'.php'));
		
		switch ($this->getVar('provider')) {
			case 'bomb':
			case 'scheduler':
			case 'retweet':
				$func = ucfirst($this->getVar('action')).'LogPreHook';
				break;
			default:
				return $default;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($default, $this);
		}
		return $default;
	}
    
	function runPostPlugin($lid) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('provider').'.php'));
		
		switch ($this->getVar('provider')) {
			case 'bomb':
			case 'scheduler':
			case 'retweet':
				$func = ucfirst($this->getVar('action')).'LogPostHook';
				break;
			default:
				return $lid;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this, $lid);
		}
		return $lid;
	}
}


/**
* XOOPS TwitterBomb Log handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class TwitterBombLogHandler extends XoopsPersistableObjectHandler
{
	var $_mod = NULL;
	var $_modConfig = array();
	
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'twitterbomb_log', 'TwitterBombLog', "lid", "tweet");
        
        $module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$this->_mod = $module_handler->getByDirname('twitterbomb');
		$this->_modConfig = $config_handler->getConfigList($this->_mod->getVar('mid'));
        
    }
	
    private function getAlias($object) {
    	$tweet = $object->getVar('tweet');
    	foreach(explode(' ', $tweet) as $node) {
    		if (in_array(substr($node, 0, 1), array('@','#'))) {
    			return $node;
    		}
    	}
    	
    }
    
	function plusHit($lid) {
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('twitterbomb_log').' SET `hits` = `hits` + 1, `active` = "'.time().'" WHERE `lid` = '.$lid;
        $GLOBALS['xoopsDB']->queryF($sql);
        return $this->recalc();
	}
    
	function recalc() {
    	// Recalculating Ranking Tweets
    	if ($this->_modConfig['number_to_rank']!=0) {
    		// Reset Rank
	   		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('twitterbomb_log'). ' SET `rank` = 0 WHERE `rank` <> 0';
	   		@$GLOBALS['xoopsDB']->queryF($sql);
	    	//Recalculate rank
    		$criteria = new CriteriaCompo(new Criteria('`hits`', 0, '>'));
		    $criteria->setOrder('DESC');
		    $criteria->setSort('`hits`');
		    $criteria->setStart(0);
		    $criteria->setLimit($this->_modConfig['number_to_rank']);
		    $rank = $this->_modConfig['number_to_rank'];
		    $objs = parent::getObjects($criteria, true);
		    foreach($objs as $lid=>$obj) {
		    	$obj->setVar('rank', $rank);
		    	parent::insert($obj, true);
		    	$rank--;
		    }
    	}
    	return true;
	}
	
    function insert($object, $force = true) {
		
		$criteria = new Criteria('`date`', time()-$this->_modConfig['logdrops'], '<=');
		parent::deleteAll($criteria, $force);
		
    	if ($object->isNew()) {
    		$object->setVar('date', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    		else 
    			$object->setVar('uid', 0);
    	}
    	
    	$object->setVar('alias', $this->getAlias($object));
    	
		$run_plugin_action=false;
    	if ($obj->vars['provider']['changed']==true) {	
			$run_plugin_action=true;
		}
    	if ($run_plugin_action){
    		if ($object->runPrePlugin($this->_modConfig['save_'.$object->getVar('provider')])==true)
    			$lid = parent::insert($object, $force);
    		else 
    			return false;
    	} else 	
    		$lid = parent::insert($object, $force);		
    	if ($run_plugin_action)
    		return $object->runPostPlugin($lid);
    	else 	
    		return $lid;
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
     
    function getFilterForm($filter, $field, $sort='date', $op = 'log', $fct='list') {
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