<?php

defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'lyquix' . DS . 'functions.php');

// Category sections ordering
$cat_sections = $this -> params -> get('cat_layout_order', array("buttons", "title", "filters", "alpha", "image", "desc", "map", "subcats", "items", "pagination"));

if (!is_array($cat_sections)) {
	$cat_sections = explode(",", $cat_sections);
}

if (is_array($cat_sections)) {

	// keeps track of the current section number
	$i = 1;

	echo '<div class="fc-category tmpl-' . str_replace('.category.', '', $this -> tmpl) . ' cat-' . $this -> category -> alias . '">' .
		 '<div class="section-1 ' . $this -> params -> get('css_section_1') . '">';

	foreach ($cat_sections as $cat_section) {

		if (strstr($cat_section, 'sep')) {

			$i++;
			echo '</div><div class="section-' . $i . ' ' . $this -> params -> get('css_section_' . $i) . '">';

		} else {
			
			$html = '';
			$section = 'renderCat' . ucfirst($cat_section);
			
			if (class_exists('lyquixFlexicontentTmplCustom')) {
				$html =  lyquixFlexicontentTmplCustom::customSectionRendering($section);
			}
			
			echo $html ? $html : lyquixFlexicontentTmpl::$section();

		}

	}
	
	echo '</div>' .
		 '</div>';

}
