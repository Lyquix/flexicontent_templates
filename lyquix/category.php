<?php

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

		} elseif ($cat_section == 'filters') {
			$html = '';
			if ($this-> params -> get('use_filters', 0)) {

				$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRendering') ? $lyquixFlexicontentTmplCustom -> customSectionRendering('renderCatFilters') : '';
				if ($html == '') {
					$html .= '<div class="cat-filters ' . $this-> params -> get('cat_filters_class', '') . '">';
					$html .= $this-> params -> get('cat_filters_label', '');
					if($this-> params -> get('cat_filters_engine', 0)) {
						require_once(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'filters.php');
						$html .= $lyquixFlexicontentTmpl -> renderFilters();
						$html .= '</div>';

					}
					else {
						// this is the problem right now, the included file below requires that $this variable refers to the context: flexicontentCategoryView.
						// since it is called inside the class lyquixFlexicontentTmpl, $this variable refers to the lyquixFlexicontentTmpl...
						echo $html;
						include (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'tmpl_common' . DS . 'listings_filter_form_html5.php');
						echo '</div>';
						$html = '';

					}
				} else {
					echo $html;
				}
			}

		} else {

			$html = '';
			$section = 'renderCat' . ucfirst($cat_section);

			$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRendering') ? $lyquixFlexicontentTmplCustom -> customSectionRendering($section) : '';
			if(!$html) {
				$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRenderingPretext') ? $lyquixFlexicontentTmplCustom -> customSectionRenderingPretext($section) : '';
				$html .= $lyquixFlexicontentTmpl -> $section();
				$html .= method_exists($lyquixFlexicontentTmplCustom,'customSectionRenderingPosttext') ? $lyquixFlexicontentTmplCustom -> customSectionRenderingPosttext($section) : '';
			}

			echo $html;

		}

	}

	echo '</div>';

}
