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

require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'lyquix' . DS . 'functions.php');
if (!class_exists('lyquixFlexicontentTmplCustom')) require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'custom' . DS . 'category-custom.dist.php');

// Category sections ordering
$cat_sections = $this -> params -> get('cat_layout_order', array("buttons", "title", "filters", "alpha", "image", "desc", "map", "subcats", "items", "pagination"));


if (!is_array($cat_sections)) {
	$cat_sections = explode(",", $cat_sections);
}

if (is_array($cat_sections)) {

	$lyquixFlexicontentTmpl = new lyquixFlexicontentTmpl($this);
	$lyquixFlexicontentTmplCustom = new lyquixFlexicontentTmplCustom($this);
	$lyquixFlexicontentTmpl -> setTmplCustomObject($lyquixFlexicontentTmplCustom);

	// keeps track of the current section number
	$i = 0;

	echo '<div class="fc-category tmpl-' . str_replace('.category.', '', $this -> tmpl) . ' cat-' . $this -> category -> alias . ' cat-' . $this -> category -> id
		. (method_exists($lyquixFlexicontentTmplCustom,'customCatClass') ? ' ' . $lyquixFlexicontentTmplCustom -> customCatClass($this -> category) : '')
		. ($this -> params -> get('css_wrapper') ? ' ' . $this -> params -> get('css_wrapper') : '')
		. '"'
		. (method_exists($lyquixFlexicontentTmplCustom,'customCatAttrs') ? ' ' . $lyquixFlexicontentTmplCustom -> customCatAttrs($this -> category) : '')
		.'>';

	foreach ($cat_sections as $cat_section) {

		if (strstr($cat_section, 'open')) {

			$i++;
			echo '<div class="section-' . $i . ' ' . $this -> params -> get('css_section_' . $i) . '">';

		} elseif (strstr($cat_section, 'close')){

			echo '</div>';

		} else {

			$html = '';
			$section = 'renderCat' . ucfirst($cat_section);

			$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRendering') ? $lyquixFlexicontentTmplCustom -> customSectionRendering($section) : '';
			if($html !== null) {
				$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRenderingPretext') ? $lyquixFlexicontentTmplCustom -> customSectionRenderingPretext($section) : '';
				$html .= $lyquixFlexicontentTmpl -> $section();
				$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRenderingPosttext') ? $lyquixFlexicontentTmplCustom -> customSectionRenderingPosttext($section) : '';
			}

			echo $html;

		}

	}

	echo '</div>';

}
