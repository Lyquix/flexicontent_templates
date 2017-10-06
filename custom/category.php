<?php

defined('_JEXEC') or die('Restricted access');

// if category-custom.php file exists, include it
if(file_exists(__DIR__ . '/category-custom.php')) {
	include __DIR__ . '/category-custom.php';
}

include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'category.php');