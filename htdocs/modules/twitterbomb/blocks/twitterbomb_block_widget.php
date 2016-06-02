<?php

function b_twitterbomb_block_widget_show( $options )
{
	if (empty($options[0])) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$options[0] = $xoConfig['root_tweeter']; 
	}
	if (empty($options[1]))
		$options[1] = 5;
	
	if (empty($options[2]))
		$options[2] = 10000;

	if (empty($options[3]))
		$options[3] = 300;

	if (empty($options[4]))
		$options[4] = '#333333';

	if (empty($options[5]))
		$options[5] = '#ffffff';
		
	if (empty($options[6]))
		$options[6] = '#000000';
		
	if (empty($options[7]))
		$options[7] = '#ffffff';

	if (empty($options[8]))
		$options[8] = '#4aed05';

	if (empty($options[9]))
		$options[9] = 'true';

	if (empty($options[10]))
		$options[10] = 'true';
		
	if (empty($options[11]))
		$options[11] = 'true';

	if (empty($options[12]))
		$options[12] = 'true';

	if (empty($options[13]))
		$options[13] = 'true';

	if (empty($options[14]))
		$options[14] = 'true';
		
	$GLOBALS['xoTheme']->addScript("http://widgets.twimg.com/j/2/widget.js", array("type"=>"text/javascript"));
	
	$block['tweeter'] = $options[0];
	$block['rpp'] = $options[1];
	$block['interval'] = $options[2];
	$block['height'] = $options[3];
	$block['shell']['background'] = $options[4];
	$block['shell']['colour'] = $options[5];
	$block['tweet']['background'] = $options[6];
	$block['tweet']['colour'] = $options[7];
	$block['tweet']['link'] = $options[8];
	$block['features']['scrollbar'] = $options[9];
	$block['features']['loop'] = $options[10];
	$block['features']['live'] = $options[11];
	$block['features']['hashtags'] = $options[12];
	$block['features']['timestamp'] = $options[13];
	$block['features']['avatars'] = $options[14];
	
	return $block ;
}


function b_twitterbomb_block_widget_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));
	
	if (empty($options[0])) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$options[0] = $xoConfig['root_tweeter']; 
	}
	if (empty($options[1]))
		$options[1] = 5;
	
	if (empty($options[2]))
		$options[2] = 10000;

	if (empty($options[3]))
		$options[3] = 300;

	if (empty($options[4]))
		$options[4] = '#333333';

	if (empty($options[5]))
		$options[5] = '#ffffff';
		
	if (empty($options[6]))
		$options[6] = '#000000';
		
	if (empty($options[7]))
		$options[7] = '#ffffff';

	if (empty($options[8]))
		$options[8] = '#4aed05';

	if (empty($options[9]))
		$options[9] = 'true';

	if (empty($options[10]))
		$options[10] = 'true';
		
	if (empty($options[11]))
		$options[11] = 'true';

	if (empty($options[12]))
		$options[12] = 'true';

	if (empty($options[13]))
		$options[13] = 'true';

	if (empty($options[14]))
		$options[14] = 'true';
		
	$tweeter = new XoopsFormText('', 'options[]', 26, 45, $options[0]);
	$form = ""._BL_TWITTERBOMB_TWEETER.$tweeter->render().'<br/>';
	
	$rpp = new XoopsFormText('', 'options[]', 4, 5, $options[1]);
	$form .= ""._BL_TWITTERBOMB_RPP.$rpp->render().'<br/>';
		
	$interval = new XoopsFormText('', 'options[]', 8, 8, $options[2]);
	$form .= ""._BL_TWITTERBOMB_INTERVAL.$interval->render().'<br/>';
		
	$height = new XoopsFormText('', 'options[]', 8, 8, $options[3]);
	$form .= ""._BL_TWITTERBOMB_HEIGHT.$height->render().'<br/>';
		
	$shell_background = new XoopsFormText('', 'options[]', 7, 8, $options[4]);
	$form .= ""._BL_TWITTERBOMB_SHELL_BACKGROUND.$shell_background->render().'<br/>';

	$shell_colour = new XoopsFormText('', 'options[]', 7, 8, $options[5]);
	$form .= ""._BL_TWITTERBOMB_SHELL_COLOUR.$shell_colour->render().'<br/>';
	
	$tweets_background = new XoopsFormText('', 'options[]', 7, 8, $options[6]);
	$form .= ""._BL_TWITTERBOMB_TWEET_BACKGROUND.$tweets_background->render().'<br/>';
		
	$tweets_colour = new XoopsFormText('', 'options[]', 7, 8, $options[7]);
	$form .= ""._BL_TWITTERBOMB_TWEET_COLOUR.$tweets_colour->render().'<br/>';	

	$tweets_link = new XoopsFormText('', 'options[]', 7, 8, $options[8]);
	$form .= ""._BL_TWITTERBOMB_TWEET_LINK.$tweets_link->render().'<br/>';	
	
	$opt = array('true'=>_YES, 'false'=>_NO);
	
	$features_scrollbar = new XoopsFormSelect('', 'options[]', $options[9]);
	$features_scrollbar->addOptionArray($opt);
	$form .= ""._BL_TWITTERBOMB_FEATURE_SCROLLBAR.$features_scrollbar->render().'<br/>';	

	$features_loop = new XoopsFormSelect('', 'options[]', $options[10]);
	$features_loop->addOptionArray($opt);
	$form .= ""._BL_TWITTERBOMB_FEATURE_LOOP.$features_loop->render().'<br/>';	
	
	$features_live = new XoopsFormSelect('', 'options[]', $options[11]);
	$features_live->addOptionArray($opt);
	$form .= ""._BL_TWITTERBOMB_FEATURE_LIVE.$features_live->render().'<br/>';	
	
	$features_hashtags = new XoopsFormSelect('', 'options[]', $options[12]);
	$features_hashtags->addOptionArray($opt);
	$form .= ""._BL_TWITTERBOMB_FEATURE_HASHTAGS.$features_hashtags->render().'<br/>';	
	
	$features_timestamp = new XoopsFormSelect('', 'options[]', $options[13]);
	$features_timestamp->addOptionArray($opt);
	$form .= ""._BL_TWITTERBOMB_FEATURE_TIMESTAMP.$features_timestamp->render().'<br/>';	
	
	$features_avatars = new XoopsFormSelect('', 'options[]', $options[14]);
	$features_avatars->addOptionArray($opt);
	$form .= ""._BL_TWITTERBOMB_FEATURE_AVATARS.$features_avatars->render().'<br/>';	
	
	return $form ;
}

?>