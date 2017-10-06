<?php

defined('_JEXEC') or die('Restricted access');

// if item-custom.php file exists, include it
if(file_exists(__DIR__ . '/item-custom.php')) {
	include __DIR__ . '/item-custom.php';
}

include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'item.php');