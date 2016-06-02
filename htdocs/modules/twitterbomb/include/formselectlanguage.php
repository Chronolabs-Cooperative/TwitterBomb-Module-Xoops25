<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *  Xoops Form Class Elements
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @package         kernel
 * @subpackage      form
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @author          John Neill <catzwolf@xoops.org>
 * @version         $Id: formselect.php 3988 2009-12-05 15:46:47Z trabis $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');

/**
 * A select field
 *
 * @author 		Kazumi Ono <onokazu@xoops.org>
 * @author 		Taiwen Jiang <phppp@users.sourceforge.net>
 * @author 		John Neill <catzwolf@xoops.org>
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @package 	kernel
 * @subpackage 	form
 * @access 		public
 */
class TwitterBombFormSelectLanguage extends XoopsFormElement
{
    /**
     * Options
     *
     * @var array
     * @access private
     */
    var $_options = array();

    /**
     * Allow multiple selections?
     *
     * @var bool
     * @access private
     */
    var $_multiple = false;

    /**
     * Number of rows. "1" makes a dropdown list.
     *
     * @var int
     * @access private
     */
    var $_size;

    /**
     * Pre-selcted values
     *
     * @var array
     * @access private
     */
    var $_value = array();

    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param mixed $value Pre-selected value (or array of them).
     * @param int $size Number or rows. "1" makes a drop-down-list
     * @param bool $multiple Allow multiple selections?
     */
    function TwitterBombFormSelectLanguage($caption, $name, $value = null, $size = 1, $multiple = false, $none=false)
    {
        xoops_loadLanguage('modinfo', 'twitterbomb');
        
    	$this->setCaption($caption);
        $this->setName($name);
        $this->_multiple = $multiple;
        $this->_size = intval($size);
        if (isset($value)) {
            $this->setValue($value);
        }
        if ($none==true) {
        	$this->addOption('', _MI_TWEETBOMB_NONE);
        }
        foreach(array('aa' => 'Afar', 'ab' => 'Abkhazian', 'af' => 'Afrikaans', 'am' => 'Amharic', 'ar' => 'Arabic', 'as' => 'Assamese', 'ay' => 'Aymara', 'az' => 'Azerbaijani', 'ba' => 'Bashkir', 'be' => 'Byelorussian', 'bg' => 'Bulgarian', 'bh' => 'Bihari', 'bi' => 'Bislama', 'bn' => 'Bengali (Bangla)', 'bo' => 'Tibetan', 'br' => 'Breton', 'ca' => 'Catalan', 'co' => 'Corsican', 'cs' => 'Czech', 'cy' => 'Welsh', 'da' => 'Danish', 'de' => 'German', 'dz' => 'Bhutani', 'el' => 'Greek', 'en' => 'English', 'eo' => 'Esperanto', 'es' => 'Spanish', 'et' => 'Estonian', 'eu' => 'Basque', 'fa' => 'Persian', 'fi' => 'Finnish', 'fj' => 'Fiji', 'fo' => 'Faroese', 'fr' => 'French', 'fy' => 'Frisian', 'ga' => 'Irish', 'gd' => 'Scots (Gaelic)', 'gl' => 'Galician', 'gn' => 'Guarani', 'gu' => 'Gujarati', 'ha' => 'Hausa', 'he' => 'Hebrew', 'hi' => 'Hindi', 'hr' => 'Croatian', 'hu' => 'Hungarian', 'hy' => 'Armenian', 'ia' => 'Interlingua', 'id' => 'Indonesian', 'ie' => 'Interlingue', 'ik' => 'Inupiak', 'is' => 'Icelandic', 'it' => 'Italian', 'iu' => 'Inuktitut', 'ja' => 'Japanese', 'jw' => 'Javanese', 'ka' => 'Georgian', 'kk' => 'Kazakh', 'kl' => 'Greenlandic', 'km' => 'Cambodian', 'kn' => 'Kannada', 'ko' => 'Korean', 'ks' => 'Kashmiri', 'ku' => 'Kurdish', 'ky' => 'Kirghiz', 'la' => 'Latin', 'ln' => 'Lingala', 'lo' => 'Laothian', 'lt' => 'Lithuanian', 'lv' => 'Latvian (Lettish)', 'mg' => 'Malagasy', 'mi' => 'Maori', 'mk' => 'Macedonian', 'ml' => 'Malayalam', 'mn' => 'Mongolian', 'mo' => 'Moldavian', 'mr' => 'Marathi', 'ms' => 'Malay', 'mt' => 'Maltese', 'my' => 'Burmese', 'na' => 'Nauru', 'ne' => 'Nepali', 'nl' => 'Dutch', 'no' => 'Norwegian', 'oc' => 'Occitan', 'om' => '(Afan) Oromo', 'or' => 'Oriya', 'pa' => 'Punjabi', 'pl' => 'Polish', 'ps' => 'Pashto (Pushto)', 'pt' => 'Portuguese', 'qu' => 'Quechua', 'rm' => 'Rhaeto-Romance', 'rn' => 'Kirundi', 'ro' => 'Romanian', 'ru' => 'Russian', 'rw' => 'Kinyarwanda', 'sa' => 'Sanskrit', 'sd' => 'Sindhi', 'sg' => 'Sangho', 'sh' => 'Serbo-Croatian', 'si' => 'Sinhalese', 'sk' => 'Slovak', 'sl' => 'Slovenian', 'sm' => 'Samoan', 'sn' => 'Shona', 'so' => 'Somali', 'sq' => 'Albanian', 'sr' => 'Serbian', 'ss' => 'Siswati', 'st' => 'Sesotho', 'su' => 'Sundanese', 'sv' => 'Swedish', 'sw' => 'Swahili', 'ta' => 'Tamil', 'te' => 'Telugu', 'tg' => 'Tajik', 'th' => 'Thai', 'ti' => 'Tigrinya', 'tk' => 'Turkmen', 'tl' => 'Tagalog', 'tn' => 'Setswana', 'to' => 'Tonga', 'tr' => 'Turkish', 'ts' => 'Tsonga', 'tt' => 'Tatar', 'tw' => 'Twi', 'ug' => 'Uighur', 'uk' => 'Ukrainian', 'ur' => 'Urdu', 'uz' => 'Uzbek', 'vi' => 'Vietnamese', 'vo' => 'Volapuk', 'wo' => 'Wolof', 'xh' => 'Xhosa', 'yi' => 'Yiddish', 'yo' => 'Yoruba', 'za' => 'Zhuang', 'zh' => 'Chinese', 'zu' => 'Zulu') as $key=>$language)
			$this->addOption($key, (defined('_MI_TWEETBOMB_LANGUAGE_'.strtoupper($key))?constant('_MI_TWEETBOMB_LANGUAGE_'.strtoupper($key)):$language));
    }
	
    /**
     * Are multiple selections allowed?
     *
     * @return bool
     */
    function isMultiple()
    {
        return $this->_multiple;
    }

    /**
     * Get the size
     *
     * @return int
     */
    function getSize()
    {
        return $this->_size;
    }

    /**
     * Get an array of pre-selected values
     *
     * @param bool $encode To sanitizer the text?
     * @return array
     */
    function getValue($encode = false)
    {
        if (! $encode) {
            return $this->_value;
        }
        $value = array();
        foreach($this->_value as $val) {
            $value[] = $val ? htmlspecialchars($val, ENT_QUOTES) : $val;
        }
        return $value;
    }

    /**
     * Set pre-selected values
     *
     * @param  $value mixed
     */
    function setValue($value)
    {
        if (is_array($value)) {
            foreach($value as $v) {
                $this->_value[] = $v;
            }
        } elseif (isset($value)) {
            $this->_value[] = $value;
        }
    }

    /**
     * Add an option
     *
     * @param string $value "value" attribute
     * @param string $name "name" attribute
     */
    function addOption($value, $name = '')
    {
        if ($name != '') {
            $this->_options[$value] = $name;
        } else {
            $this->_options[$value] = $value;
        }
    }

    /**
     * Add multiple options
     *
     * @param array $options Associative array of value->name pairs
     */
    function addOptionArray($options)
    {
        if (is_array($options)) {
            foreach($options as $k => $v) {
                $this->addOption($k, $v);
            }
        }
    }

    /**
     * Get an array with all the options
     *
     * Note: both name and value should be sanitized. However for backward compatibility, only value is sanitized for now.
     *
     * @param int $encode To sanitizer the text? potential values: 0 - skip; 1 - only for value; 2 - for both value and name
     * @return array Associative array of value->name pairs
     */
    function getOptions($encode = false)
    {
        if (! $encode) {
            return $this->_options;
        }
        $value = array();
        foreach($this->_options as $val => $name) {
            $value[$encode ? htmlspecialchars($val, ENT_QUOTES) : $val] = ($encode > 1) ? htmlspecialchars($name, ENT_QUOTES) : $name;
        }
        return $value;
    }

    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
        $ele_name = $this->getName();
		$ele_title = $this->getTitle();
        $ele_value = $this->getValue();
        $ele_options = $this->getOptions();
        $ret = '<select size="'.$this->getSize().'"'.$this->getExtra();
        if ($this->isMultiple() != false) {
            $ret .= ' name="'.$ele_name.'[]" id="'.$ele_name.'" title="'. $ele_title. '" multiple="multiple">' ;
        } else {
            $ret .= ' name="'.$ele_name.'" id="'.$ele_name.'" title="'. $ele_title. '">' ;
        }
        foreach($ele_options as $value => $name) {
            $ret .= '<option value="'.htmlspecialchars($value, ENT_QUOTES).'"';
            if (count($ele_value) > 0 && in_array($value, $ele_value)) {
                $ret .= ' selected="selected"';
            }
            $ret .= '>'.$name.'</option>' ;
        }
        $ret .= '</select>';
        return $ret;
    }

    /**
     * Render custom javascript validation code
     *
     * @seealso XoopsForm::renderValidationJS
     */
    function renderValidationJS()
    {
        // render custom validation code if any
        if (! empty($this->customValidationCode)) {
            return implode("\n", $this->customValidationCode);
            // generate validation code if required
        } elseif ($this->isRequired()) {
            $eltname = $this->getName();
            $eltcaption = $this->getCaption();
            $eltmsg = empty($eltcaption) ? sprintf(_FORM_ENTER, $eltname) : sprintf(_FORM_ENTER, $eltcaption);
            $eltmsg = str_replace('"', '\"', stripslashes($eltmsg));
            return "\nvar hasSelected = false; var selectBox = myform.{$eltname};"."for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true) { hasSelected = true; break; } }"."if (!hasSelected) { window.alert(\"{$eltmsg}\"); selectBox.focus(); return false; }";
        }
        return '';
    }
}

?>