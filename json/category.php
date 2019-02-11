<?php
/**
 * category.php
 *
 * @version     2.3.0
 * @package     flexicontent_templates
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/flexicontent_templates
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

// Set mime type to JSON
$doc = JFactory::getDocument();
$doc -> setMimeEncoding('application/json');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'lyquix' . DS . 'functions.php');
$lyquixFlexicontentTmpl = new lyquixFlexicontentTmpl($this);

if (JFactory::getApplication() -> input -> get('callback', '') != '') {
	echo JFactory::getApplication() -> input -> get('callback') . '(' . $lyquixFlexicontentTmpl -> renderJSONcat() . ');';
}
else {
	echo $lyquixFlexicontentTmpl -> renderJSONcat();
}
