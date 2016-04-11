<?php

defined('_JEXEC') or die('Restricted access');

class lyquixFlexicontentTmplCustom {

    function customItemClass(&$item) {

        $css = array();

        /* your custom code here
		 * 
         * you can use $item->fields['field_name'] to get the field value, properties and display
         * add your custom classes to the $css array, for example: 
		 * $css[] = 'prefix-' . $item->alias;
		 * 
        */

        return implode(' ', $css);

    }

    function customItemAttrs(&$item) {

        $attrs = array();

        /* your custom code here
         * 
         * you can use $item->fields['field_name'] to get the field value, properties and display
         * add your custom attributes to the $attrs array, using the key as the attribute name
         * and the value as the attribute value: 
         * $css['data-lat'] = 40.735178;
         * 
        */

        $html = array();
        if(count($attrs)) {
            foreach($attrs as $attr => $value) {
                $html[] = $attr . '="' . htmlspecialchars($value) . '"';
            }

        }
        return $implode(' ', $html);

    }
    
    function customFieldRenderingPretext(&$item, &$field) {

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

    function customFieldRenderingPosttext(&$item, &$field) {

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