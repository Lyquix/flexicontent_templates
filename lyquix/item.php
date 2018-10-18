<?php
/**
 * item.php
 *
 * @version     2.0.0
 * @package     flexicontent_templates
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/flexicontent_templates
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'lyquix' . DS . 'functions.php');

if (!class_exists('lyquixFlexicontentTmplCustom')) require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'custom' . DS . 'item-custom.dist.php');

// Item sections ordering
$item_sections = $this -> params -> get('item_layout_order', array("group1", "group2", "group3", "group4", "group5", "group6", "group7"));

if (!is_array($item_sections)) {
	$item_sections = explode(",", $item_sections);
}

if (is_array($item_sections)) {

	// keeps track of the current section number
	$i = 0;
	$lyquixFlexicontentTmpl = new lyquixFlexicontentTmpl($this);
	$lyquixFlexicontentTmplCustom = new lyquixFlexicontentTmplCustom($this);

	$lyquixFlexicontentTmpl -> setTmplCustomObject($lyquixFlexicontentTmplCustom);

	echo '<div class="fc-item tmpl-' . str_replace('.items.', '', $this -> tmpl) . ' item-' . $this -> item -> alias . ' item-' . $this -> item -> id
		. (method_exists($lyquixFlexicontentTmplCustom,'customItemClass') ? ' ' . $lyquixFlexicontentTmplCustom -> customItemClass($this -> item) : '')
		. ($this -> params -> get('item_css_wrapper') ? ' ' . $this -> params -> get('css_wrapper') : '')
		. '"'
		. (method_exists($lyquixFlexicontentTmplCustom,'customItemAttrs') ? ' ' . $lyquixFlexicontentTmplCustom -> customItemAttrs($this -> item) : '')
		.'>';

	foreach ($item_sections as $item_section) {

		if (strstr($item_section, 'open')) {

			$i++;
			echo '<div class="section-' . $i . ' ' . $this -> params -> get('item_css_section_' . $i) . '">';

		} elseif (strstr($item_section, 'group')) {

			$j = substr($item_section, -1);

			if (isset($this -> item -> positions['group_' . $j])) {

				echo '<div class="group-' . $j . ' ' . $this -> params -> get('item_css_group_' . $j, '') . '">';

				foreach ($this->item->positions['group_'.$j] as $field) {
					echo $lyquixFlexicontentTmpl -> renderItemField($this -> item, $field);
				}

				echo '</div>';

			}
		} elseif ($item_section == 'buttons'){

			echo $lyquixFlexicontentTmpl -> renderItemButtons($this -> item);

		} elseif (strstr($item_section, 'close')){

			echo '</div>';

		}
	}

	echo '</div>';
}
