<?php

defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'lyquix' . DS . 'functions.php');

// Category sections ordering
$cat_sections = $this -> params -> get('cat_layout_order', array("buttons", "title", "filters", "alpha", "image", "desc", "map", "subcats", "items", "pagination"));

if (!is_array($cat_sections[0])) {
	$cat_sections = explode(",", $cat_sections[0]);
}

if (is_array($cat_sections)) {

	// keeps track of the current section number
	$i = 1;

	echo '<div class="tmpl-' . str_replace('.category.', '', $this -> tmpl) . ' cat-' . $this -> category -> alias . '">' .
		 '<div class="section-1">';

	foreach ($cat_sections as $cat_section) {

		if (strstr($cat_section, 'sep')) {

			$i++;
			echo '</div><div class="section-' . $i . '">';

		} else {

			$section = 'renderCat' . ucfirst($cat_section);
			echo lyquixFlexicontentTmpl::$section();

		}

	}
	
	echo '</div>' .
		 '</div>';

}
