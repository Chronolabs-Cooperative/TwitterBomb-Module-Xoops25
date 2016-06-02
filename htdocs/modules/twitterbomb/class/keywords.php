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
class TwitterbombKeywords extends XoopsObject
{

    function TwitterbombKeywords($fid = null)
    {
        $this->initVar('kid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);         
        $this->initVar('base', XOBJ_DTYPE_ENUM, null, true, false, false, array('for','when','clause','then','over','under','their','there'));
		$this->initVar('keyword', XOBJ_DTYPE_TXTBOX, null, true, 35);    
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
   	}

	function getForm() {
		return tweetbomb_keywords_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['kid'].']', $this->getVar('kid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['kid'].'[cid]', $this->getVar('cid'), 1, false, false, 'bomb');
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['kid'].'[catid]', $this->getVar('catid'));
		$ele['base'] = new TwitterBombFormSelectBase('', $ret['kid'].'[base]', $this->getVar('base'), 1, false, false);
		$ele['keyword'] = new XoopsFormText('', $ret['kid'].'[keyword]', 26, 35, $this->getVar('keyword'));
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
		foreach($ele as $key => $obj) {
			$ret['form'][$key] = $ele[$key]->render(); 
		}
		return $ret;
	}
	
	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('base').'.php'));
		
		switch ($this->getVar('base')) {
			case 'for':
			case 'when';
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':				
				$func = ucfirst($this->getVar('base')).'InsertHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('kid');
	}
	
	function runGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('base').'.php'));
		
		switch ($this->getVar('base')) {
			case 'for':
			case 'when';
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':				
				$func = ucfirst($this->getVar('base')).'GetHook';
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
class TwitterbombKeywordsHandler extends XoopsPersistableObjectHandler
{
	
	var $_mod = NULL;
	var $_modConfig = array();
	
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_keywords", 'TwitterbombKeywords', "kid", "keyword");
        
        xoops_load('xoopscache');
		if (!class_exists('XoopsCache')) {
			// XOOPS 2.4 Compliance
			xoops_load('cache');
			if (!class_exists('XoopsCache')) {
				include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
			}
		}
		
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$this->_mod = $module_handler->getByDirname('twitterbomb');
		$this->_modConfig = $config_handler->getConfigList($this->_mod->getVar('mid'));
    }
	
    function insert($obj, $force=true) {
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$obj->setVar('updated', time());
    	}
    	$run_plugin = false;
    	if ($obj->vars['base']['changed']==true) {	
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
    
    function getKeyword($base, $cid, $catid) {
    	switch ($base) {
			case 'for':
			case 'when':
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':				
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
		    	$criteria->add(new Criteria('base', $base), 'AND');
		    	$criteria->setOrder('DESC');
		    	$criteria->setSort('RAND()');
		    	$criteria->setLimit(1);
		    	$criteria->setStart(0);
		    	$obj = parent::getObjects($criteria, false);
		    	if (is_object($obj[0])) {
		    		if (is_object($obj[0]))
		    			$ret = $obj[0]->runGetPlugin();
		    		if (is_string($ret)&&!is_object($ret))
		    			return strtolower(trim($ret));
		    		else {
			    		if (is_object($ret))
			    			return strtolower(trim($ret->getVar('keyword')));
			    		else 
			    			return '';
		    		}
		    	}
		    	break;
			case 'trend':
				if (!$trend = XoopsCache::read('twitterbomb_trends_'.$this->_modConfig['trend_type'])) {
					$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
					$trend = $oauth_handler->getTrend($this->_modConfig['trend_type']);
					if (!empty($trend))
						XoopsCache::write('twitterbomb_trends_'.$this->_modConfig['trend_type'], $trend, $this->_modConfig['keep_trend_for']);
				}
				if (!empty($trend)) {
					mt_srand(microtime(true)/mt_rand(0,255));
					switch ($this->_modConfig['trend_type']) {
						default:
							$i = microtime(true)+15;
							while($i>microtime(true)) {
								foreach($trend['trends'] as $key => $values) {
									if (isset($values['name'])&&!empty($values['name'])) {
										if (mt_rand($GLOBALS['twitterbombModuleConfig']['odds_minimum'], $GLOBALS['twitterbombModuleConfig']['odds_maximum'])<$GLOBALS['twitterbombModuleConfig']['odds_lower']||mt_rand($GLOBALS['twitterbombModuleConfig']['odds_minimum'], $GLOBALS['twitterbombModuleConfig']['odds_maximum'])>$GLOBALS['twitterbombModuleConfig']['odds_higher']) {
											return $values['name'];
										}
									} else {
										foreach($values as $value) {
											if (mt_rand($GLOBALS['twitterbombModuleConfig']['odds_minimum'], $GLOBALS['twitterbombModuleConfig']['odds_maximum'])<$GLOBALS['twitterbombModuleConfig']['odds_lower']||mt_rand($GLOBALS['twitterbombModuleConfig']['odds_minimum'], $GLOBALS['twitterbombModuleConfig']['odds_maximum'])>$GLOBALS['twitterbombModuleConfig']['odds_higher']) {
												return $value['name'];
											}
										}
									}
								}
							}
							break;
					}
				}
				return '';
				break;
    	}
    }
    
    function get($id, $fields = '*') {
    	$obj = parent::get($id, $fields);
    	if (is_object($obj))
    		return @$obj->runGetPlugin();
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true) {
    	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
    		if (is_object($obj))
    			$objs[$id] = @$obj->runGetPlugin();
    	}
    	return $objs;
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
    
    
    function getFilterForm($filter, $field, $sort='created', $op = 'keywords', $fct='list') {
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