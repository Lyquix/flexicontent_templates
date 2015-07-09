<?php

defined('_JEXEC') or die('Restricted access');

class lyquixFlexicontentTmplCustom {
	
	function customItemClass(&$item, $group) {
		
		$css = array();
		
		/* your custom code here
		 * use $item->fields['field_name'] to get the field value, properties and display
		 * add your classes to the array $css using $css[] = 'myclass'
		*/
		
		return implode(' ', $css);
		
	}
	
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

include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'category.php');