<?php

defined('_JEXEC') or die('Restricted access');

class lyquixFlexicontentTmplCustom {
	
	function customFieldRendering(&$item, &$field, $group) {
		
		$html = '';
		
		switch ($field->name) {
			
			/*
			case 'field_name':
				// your custom code for field_name here
				break;
			*/
			
			default:
				break;
				
		}
		return $html;
		
	}
	
}

include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'item.php');