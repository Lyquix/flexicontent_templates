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

// if category-custom.php file exists, include it
if(file_exists(__DIR__ . '/category-custom.php')) {
	include __DIR__ . '/category-custom.php';
}

include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'category.php');
