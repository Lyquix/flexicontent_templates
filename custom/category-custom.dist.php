<?php

defined('_JEXEC') or die('Restricted access');

class lyquixFlexicontentTmplCustom {

    function customItemClass(&$item, $group) {

        $css = array();

        /* your custom code here
         * use $item->fields['field_name'] to get the field value, properties and display
         * add your classes to the array $css using 
		 * 
		 * $css[] = 'myclass';
        */

        return implode(' ', $css);

    }

    function customFieldRendering(&$item, &$field, $group) {

        $html = '';

        switch ($field->name) {

            /*
            case 'field_name':
                // your custom code for field_name here
                $html .= 'my custom output';
			 	break;
            */
			
				
            default:
                break;

        }
        return $html;

    }
	
	function customSectionRendering($section) {
		
		$html = '';

        switch ($section) {

            /*
            case 'renderCatTitle': // use same name as in functions.php
                // your custom code for field_name here
			 	$html .= 'my custom output';
                break;
            */
				
            default:
                break;

        }
		
		return $html;
		
	}

}