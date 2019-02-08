<?php
/**
 * category-custom.dist.php
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

class lyquixFlexicontentTmplCustom {

	private $jObject;

	function __construct($passedJObject) {
		$this -> jObject = $passedJObject;
	}

	function customCatClass(&$category) {

		$css = array();

		/* your custom code here
		 *
		 * you can use $category to get the properties
		 * $css[] = 'prefix-' . $category->alias;
		 *
		*/

		return implode(' ', $css);

	}

	function customCatAttrs(&$category) {

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
		return implode(' ', $html);

	}

	function customMapMarker(&$item){

		$marker = '';

		/* your custom code here
		 *
		 * example: $marker = '/templates/lyquix/images/map-marker.png';
		 *
		*/

		return $marker;
	}

	function customSubcatClass(&$subcat) {

		$css = array();

		/* your custom code here
		 *
		 * example: $css[] = 'prefix-' . $subcat -> alias;
		 *
		*/

		return implode(' ', $css);

	}

	function customSubcatAttrs(&$subcat) {

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
		return implode(' ', $html);

	}

	function customItemClass(&$item, $group) {

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

	function customItemAttrs(&$item, $group) {

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
		return implode(' ', $html);

	}

	function customFieldRenderingPretext(&$item, &$field, $group) {

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

	function customFieldRenderingPosttext(&$item, &$field, $group) {

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

	function customSectionRenderingPretext($section) {

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

	function customSectionRenderingPosttext($section) {

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
