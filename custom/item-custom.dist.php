<?php

defined('_JEXEC') or die('Restricted access');

class lyquixFlexicontentTmplCustom {

    function customFieldRendering(&$item, &$field) {

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
}