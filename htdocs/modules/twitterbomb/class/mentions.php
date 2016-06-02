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
class TwitterbombMentions extends XoopsObject
{

    function TwitterbombMentions($fid = null)
    {
        $this->initVar('mid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('user', XOBJ_DTYPE_TXTBOX, '@', true, 64);
		$this->initVar('rpids', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('keywords', XOBJ_DTYPE_TXTBOX, null, false, 500);
		$this->initVar('geocode', XOBJ_DTYPE_INT, null, false);
        $this->initVar('longitude', XOBJ_DTYPE_DECIMAL, null, false);
        $this->initVar('latitude', XOBJ_DTYPE_DECIMAL, null, false);
        $this->initVar('radius', XOBJ_DTYPE_INT, 2, false);
		$this->initVar('measurement', XOBJ_DTYPE_ENUM, 'km', false, false, false, array('mi','km'));
		$this->initVar('language', XOBJ_DTYPE_ENUM, 'en', false, false, false, array('aa','ab','af','am','ar','as','ay','az','ba','be','bg','bh','bi','bn','bo','br','ca','co','cs','cy','da','de','dz','el','en','eo','es','et','eu','fa','fi','fj','fo','fr','fy','ga','gd','gl','gn','gu','ha','he','hi','hr','hu','hy','ia','id','ie','ik','is','it','iu','ja','jw','ka','kk','kl','km','kn','ko','ks','ku','ky','la','ln','lo','lt','lv','mg','mi','mk','ml','mn','mo','mr','ms','mt','my','na','ne','nl','no','oc','om','or','pa','pl','ps','pt','qu','rm','rn','ro','ru','rw','sa','sd','sg','sh','si','sk','sl','sm','sn','so','sq','sr','ss','st','su','sv','sw','ta','te','tg','th','ti','tk','tl','tn','to','tr','ts','tt','tw','ug','uk','ur','uz','vi','vo','wo','xh','yi','yo','za','zh','zu'));
        $this->initVar('type', XOBJ_DTYPE_ENUM, 'mixed', false, false, false, array('mixed','recent','popular'));
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mentions', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mentioned', XOBJ_DTYPE_INT, null, false);
	}

	function getForm() {
		return tweetbomb_mentions_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['mid'].']', $this->getVar('mid'));
		$ele['cid'] = new TwitterBombFormSelectCampaigns('', $ret['mid'].'[cid]', $this->getVar('cid'), 1, false, true, 'mentions');
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['mid'].'[catid]', $this->getVar('catid'));
		$ele['rpids'] = new TwitterBombFormCheckboxReplies('', $ret['mid'].'[rpids]', $this->getVar('rpids'), '&nbsp;');
		$ele['user'] = new XoopsFormText('', $ret['mid'].'[user]', 26,64, $this->getVar('user'));
		$ele['keywords'] = new XoopsFormTextArea('', $ret['mid'].'[keywords]', $this->getVar('keywords'), 4, 26);
		$ele['geocode'] = new XoopsFormRadioYN('', $ret['rid'].'[geocode]', $this->getVar('geocode'));
		$ele['longitude'] = new XoopsFormText('', $ret['rid'].'[longitude]', 10,24, $this->getVar('longitude'));
		$ele['latitude'] = new XoopsFormText('', $ret['rid'].'[latitude]', 10,24, $this->getVar('latitude'));
		$ele['radius'] = new XoopsFormText('', $ret['rid'].'[radius]', 8,24, $this->getVar('radius'));
		$ele['measurement'] = new TwitterbombFormSelectMeasurement('', $ret['rid'].'[measurement]', $this->getVar('measurement'));
		$ele['language'] = new TwitterbombFormSelectLanguage('', $ret['rid'].'[language]', $this->getVar('language'));
		
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($ret['mentions']>0) {
			$ele['mentions'] = new XoopsFormLabel('', $ret['mentions']);
		} else {
			$ele['mentions'] = new XoopsFormLabel('', '');
		}
		if ($ret['mentioned']>0) {
			$ele['mentioned'] = new XoopsFormLabel('', date(_DATESTRING, $ret['mentioned']));
		} else {
			$ele['mentioned'] = new XoopsFormLabel('', '');
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
	
}


/**
* XOOPS Spider handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class TwitterbombMentionsHandler extends XoopsPersistableObjectHandler
{
	
	var $_mod = NULL;
	var $_modConfig = array();
	
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_mentions", 'TwitterbombMentions', "mid", "user");

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
    	
    	return parent::insert($obj, $force);
    }
    
	function getObject($cid, $catid, $tweet) {
    	$criteriaa = new CriteriaCompo(new Criteria('cid', 0), 'OR');
    	$criteriaa->add(new Criteria('catid', 0), 'OR');
    	$criteriab = new CriteriaCompo(new Criteria('cid', $cid), 'OR');
    	$criteriab->add(new Criteria('catid', $catid), 'OR');
    	$criteriac = new CriteriaCompo(new Criteria('cid', $cid), 'AND');
    	$criteriac->add(new Criteria('catid', $catid), 'AND');
    	$criteriad = new CriteriaCompo();
    	foreach(explode(' ', $tweet) as $node) {
    		if (substr($node,0,1)=='@'||substr($node,0,1)=='#') {
    			$criteriad->add(new Criteria('`user`', strtolower($node), 'LIKE'), 'OR');
    		}
    	}
    	$tweet = str_replace(array('@', '#'), '', $tweet);
    	$criteriae = new CriteriaCompo();
    	foreach(explode(' ', $tweet) as $node) {
    		$criteriae->add(new Criteria('`keywords`', '%'.strtolower($node).'%', 'LIKE'), 'OR');
    	}
    	$criteriae->add(new Criteria('`keywords`', '', 'LIKE'), 'OR');
    	$criteriae->add(new Criteria('`keywords`', NULL, 'LIKE'), 'OR');
		$criteriaf = new CriteriaCompo();
    	foreach(explode(' ', $tweet) as $node) {
    		$criteriaf->add(new Criteria('`keywords`', '%-'.strtolower($node).'%', 'NOT LIKE'), 'AND');
    	}
    	$criteriaf->add(new Criteria('`keywords`', '', 'LIKE'), 'OR');
    	$criteriaf->add(new Criteria('`keywords`', NULL, 'LIKE'), 'OR');
    	$criteriag = new CriteriaCompo($criteriaa, 'OR');
    	$criteriag->add($criteriab, 'OR');
    	$criteriag->add($criteriac, 'OR');
    	$criteriag->add($criteriad, 'AND');
    	$criteriag->add($criteriae, 'AND');
    	$criteriag->add($criteriaf, 'AND');
    	$criteria = new CriteriaCompo($criteriag, 'OR');
    	$criteria->setOrder('DESC');
    	$criteria->setSort('RAND()');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	$obj = parent::getObjects($criteria, false);
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
    
    
    function getFilterForm($filter, $field, $sort='created', $op = 'mentions', $fct='list') {
    	$ele = tweetbomb_getFilterElement($filter, $field, $sort, $op, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
 	function doSearchForReply($cid, $catid, $mids) {
    	if (is_array($rids)) {
    		$criteria = new CriteriaCompo(new Criteria('mid', '('.implode(',', $mids).')', 'IN'));
    	} else {
    		$criteria = new CriteriaCompo(new Criteria('mid', $mids));
    	}
    	$criteria->setSort('RAND()');
    	$criteria->setOrder('ASC');
    	
    	$log_handler = xoops_getmodulehandler('log', 'twitterbomb');
    	$ret = array();
    	$terms = $this->getObjects($criteria, true);
    	foreach($terms as $mid => $mention) {
    		// Get Since ID
    		$criteria_log = new CriteriaCompo(new Criteria('mid', $mid));
    		$criteria_log->add(new Criteria('cid', $cid));
    		$criteria_log->add(new Criteria('catid', $catid));
    		$criteria_log->setSort('`date`');
    		$criteria_log->setOrder('DESC');
    		$criteria_log->setStart(0);
    		$criteria_log->setLimit(1);
    		$logs = $log_handler->getObjects($criteria_log, false);
    		if (is_object($logs[0]))
    			$since_id = $logs[0]->getVar('id');
    		else 
    			$since_id = '';

    		// Do Search
    		$ret[$mid] = twitterbomb_searchtwitter($this->_modConfig['gather_on_search'], $mention->getVar('user'), explode(' ',trim($mention->getVar('keywords'))), ($mention->getVar('geocode')==true?$mention->getVar('longitude').','.$mention->getVar('latitude').','.$mention->getVar('radius').$mention->getVar('measurement'):''), $mention->getVar('language'), 1, $mention->getVar('type'), ($this->_modConfig['gather_on_search']<100?$this->_modConfig['gather_on_search']:'100'), 'true', '', $since_id);

    		// Set Search Timer
    		$mention->setVar('searched', time());
    		$this->insert($mention, true);
    	}
   	
    	return count($ret)>0?$ret:false;
    }

	function delete($id_or_object, $force = true) {
    	if (is_numeric($id_or_object))
    		return parent::deleteAll(new Criteria('`'.$this->keyName.'`', $id_or_object), $force);
    	elseif (is_object($id_or_object))
    		return parent::delete($id_or_object, $force);
    }
    
}
?>