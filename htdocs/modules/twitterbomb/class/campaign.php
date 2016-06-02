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
class TwitterbombCampaign extends XoopsObject
{

    function TwitterbombCampaign($fid = null)
    {
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);    
		$this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('start', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('end', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('timed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('hits', XOBJ_DTYPE_INT, null, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('active', XOBJ_DTYPE_INT, null, false);
		$this->initVar('cron', XOBJ_DTYPE_INT, null, false);
		$this->initVar('type', XOBJ_DTYPE_ENUM, 'bomb', true, false, false, array('bomb','scheduler','retweet','reply','mention','pictures'));
		$this->initVar('rids', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('mids', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('rpids', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('picids', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('cron', XOBJ_DTYPE_INT, true, false);
	}

	function getForm() {
		return tweetbomb_campaign_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['cid'].']', $this->getVar('cid'));
		$ele['catid'] = new TwitterBombFormSelectCategories('', $ret['cid'].'[catid]', $this->getVar('catid'));
		$ele['type'] = new TwitterBombFormSelectType('', $ret['cid'].'[type]', $this->getVar('type'));
		$ele['name'] = new XoopsFormText('', $ret['cid'].'[name]', 26,64, $this->getVar('name'));
		$ele['description'] = new XoopsFormTextArea('', $ret['cid'].'[catid]', 26, 4, $this->getVar('description'));
		$ele['start'] = new XoopsFormTextDateSelect('', $ret['cid'].'[start]', 15, $this->getVar('start'));
		$ele['end'] = new XoopsFormTextDateSelect('', $ret['cid'].'[end]', 15, $this->getVar('end'));
		$ele['timed'] = new XoopsFormRadioYN('', $ret['cid'].'[timed]', $this->getVar('timed'));
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			if (is_object($user))
				$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
			else 
				$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($ret['created']>0) {
			$ele['created'] = new XoopsFormLabel('', date(_DATESTRING, $ret['created']));
		} else {
			$ele['created'] = new XoopsFormLabel('', '');
		}
		if ($ret['updated']>0) {
			$ele['updated'] = new XoopsFormLabel('', date(_DATESTRING, $ret['updated']));
		} else {
			$ele['updated'] = new XoopsFormLabel('', '');
		}
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
	
	function setCron() {
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign'). ' SET `cron` = "'.time().'" WHERE `cid` = '.$this->getVar('cid');
		$GLOBALS['xoopsDB']->queryF($sql);
		$this->vars['cron']['value'] = time();
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
class TwitterbombCampaignHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_campaign", 'TwitterbombCampaign', "cid", "name");
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
    
    function plusHit($cid=0) {
    	if ($cid==0)
    		return false;
    	$sql = "UPDATE " . $GLOBALS['xoopsDB']->prefix('twitterbomb_campaign') . " SET 	`hits` = `hits` + 1, `active` = '".time()."' WHERE `cid` = '".$cid."'";
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
        
    function getFilterForm($filter, $field, $sort='created', $op = 'campaign', $fct='list') {
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