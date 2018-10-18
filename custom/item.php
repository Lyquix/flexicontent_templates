<?php
/**
 * item.php
 *
 * @version     2.0.0
 * @package     flexicontent_templates
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/flexicontent_templates
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

// if item-custom.php file exists, include it
if(file_exists(__DIR__ . '/item-custom.php')) {
	include __DIR__ . '/item-custom.php';
}

include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'item.php');
