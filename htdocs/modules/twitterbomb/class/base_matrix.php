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
class TwitterbombBase_matrix extends XoopsObject
{

    function TwitterbombBase_matrix($fid = null)
    {
        $this->initVar('baseid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);         
		$this->initVar('base1', XOBJ_DTYPE_ENUM, 'for', true, false, false, array('for','when','clause','then','over','under','their','there','trend',''));    
		$this->initVar('base2', XOBJ_DTYPE_ENUM, 'when', true, false, false, array('for','when','clause','then','over','under','their','there','trend',''));
		$this->initVar('base3', XOBJ_DTYPE_ENUM, null, false, false, false, array('for','when','clause','then','over','under','their','there','trend',''));
		$this->initVar('base4', XOBJ_DTYPE_ENUM, null, false, false, false, array('for','when','clause','then','over','under','their','there','trend',''));
		$this->initVar('base5', XOBJ_DTYPE_ENUM, null, false, false, false, array('for','when','clause','then','over','under','their','there','trend',''));
		$this->initVar('base6', XOBJ_DTYPE_ENUM, null, false, false, false, array('for','when','clause','then','over','under','their','there','trend',''));
		$this->initVar('base7', XOBJ_DTYPE_ENUM, null, false, false, false, array('for','when','clause','then','over','under','their','there','trend',''));
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);		
	}

	function getForm() {
		return tweetbomb_base_matrix_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['baseid'].']', $this->getVar('baseid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['baseid'].'[cid]', $this->getVar('cid'), 1, false, false, 'bomb');
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['baseid'].'[catid]', $this->getVar('catid'));
		$ele['base1'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base1]', $this->getVar('base1'), 1, false, true, true);
		$ele['base2'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base2]', $this->getVar('base2'), 1, false, true, true);
		$ele['base3'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base3]', $this->getVar('base3'), 1, false, true, true);
		$ele['base4'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base4]', $this->getVar('base4'), 1, false, true, true);
		$ele['base5'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base5]', $this->getVar('base5'), 1, false, true, true);
		$ele['base6'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base6]', $this->getVar('base6'), 1, false, true, true);
		$ele['base7'] = new TwitterBombFormSelectBase('', $ret['baseid'].'[base7]', $this->getVar('base7'), 1, false, true, true);
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
	
	private function getPopulatedBaseCode() {
		$code = '';
		if (strlen($this->getVar('base1'))>0) {
			$code .= ucfirst($this->getVar('base1'));
			if (strlen($this->getVar('base2'))>0) {
				$code .= ucfirst($this->getVar('base2'));
				if (strlen($this->getVar('base3'))>0) {
					$code .= ucfirst($this->getVar('base3'));
					if (strlen($this->getVar('base4'))>0) {
						$code .= ucfirst($this->getVar('base4'));
						if (strlen($this->getVar('base5'))>0) {
							$code .= ucfirst($this->getVar('base5'));
							if (strlen($this->getVar('base6'))>0) {
								$code .= ucfirst($this->getVar('base6'));
								if (strlen($this->getVar('base7'))>0) {
									$code .= ucfirst($this->getVar('base7'));
								}
							}
						}
					}
				}
			}
		}
		return $code;
	}
	
	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.strtolower($this->getPopulatedBaseCode()).'.php'));
		
		switch ($this->getVar('base1')) {
			case 'for':
			case 'when';
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':
			case 'trend':				
				$func = $this->getPopulatedBaseCode().'MatrixSaveHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('baseid');
	}
	
	function runGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.strtolower($this->getPopulatedBaseCode()).'.php'));
		
		switch ($this->getVar('base1')) {
			case 'for':
			case 'when';
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':
			case 'trend':				
				$func = $this->getPopulatedBaseCode().'MatrixGetHook';
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
class TwitterbombBase_matrixHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_base_matrix", 'TwitterbombBase_matrix', "baseid");
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
    	if ($obj->vars['base1']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($obj->vars['base2']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($obj->vars['base3']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($obj->vars['base4']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($obj->vars['base5']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($obj->vars['base6']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($obj->vars['base7']['changed']==true) {	
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
    
    function getSentence($cid, $catid) {
    	
    	$keywords_handler =& xoops_getmodulehandler('keywords','twitterbomb');
    	
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
    	$criteria->setOrder(mt_rand(0, 1)==1?'DESC':'ASC');
    	$criteria->setSort('RAND()');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	$obj = parent::getObjects($criteria, false);
    	$ret='';
    	if (is_object($obj[0])) {
    		if (strlen($obj[0]->getVar('base1'))>0) {
    			$ret .= $keywords_handler->getKeyword($obj[0]->getVar('base1'), $cid, $catid); 
	    		if (strlen($obj[0]->getVar('base2'))>0) {
	    			$ret .= ' ' . $keywords_handler->getKeyword($obj[0]->getVar('base2'), $cid, $catid); 
		    		if (strlen($obj[0]->getVar('base3'))>0) {
		    			$ret .= ' ' . $keywords_handler->getKeyword($obj[0]->getVar('base3'), $cid, $catid); 
			    		if (strlen($obj[0]->getVar('base4'))>0) {
			    			$ret .= ' ' . $keywords_handler->getKeyword($obj[0]->getVar('base4'), $cid, $catid); 
				    		if (strlen($obj[0]->getVar('base5'))>0) {
				    			$ret .= ' ' . $keywords_handler->getKeyword($obj[0]->getVar('base5'), $cid, $catid); 
					    		if (strlen($obj[0]->getVar('base6'))>0) {
					    			$ret .= ' ' . $keywords_handler->getKeyword($obj[0]->getVar('base6'), $cid, $catid); 
						    		if (strlen($obj[0]->getVar('base7'))>0) {
						    			$ret .= ' ' . $keywords_handler->getKeyword($obj[0]->getVar('base7'), $cid, $catid); 
    								}
					    		}
				    		}
			    		}
		    		}
	    		}
    		}			
    	}
    	if (strlen($ret)>$GLOBALS['twitterbombModuleConfig']['sentence_max_len'])
    		$ret = substr($ret, 0, $GLOBALS['twitterbombModuleConfig']['sentence_max_len']).'...';
    	return $ret;
    }
    
    function get($id, $fields = '*') {
    	$obj = parent::get($id, $fields);
    	return @$obj->runGetPlugin();
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true) {
    	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
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
    
    
    
    function getFilterForm($filter, $field, $sort='created', $op = 'base_matrix', $fct='list') {
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