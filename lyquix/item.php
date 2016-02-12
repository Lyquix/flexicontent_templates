<?php 

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'functions.php');

// Item sections ordering
$item_sections = $this -> params -> get('item_layout_order', array("group1", "group2", "group3", "group4", "group5", "group6", "group7"));

if (!is_array($item_sections)) {
	$item_sections = explode(",", $item_sections);
}

if (is_array($item_sections)) {
	
	// keeps track of the current section number
	$i = 1;
		
	echo '<div class="fc-item tmpl-'.str_replace('.items.','',$this->tmpl).' item-'.$this->item->alias.'">' .
		 '<div class="section-1 ' . $this -> params -> get('css_section_1') . '">';
	
	foreach ($item_sections as $item_section) {

		if (strstr($item_section, 'sep')) {

			$i++;
			echo '</div><div class="section-' . $i . ' ' . $this -> params -> get('css_section_' . $i) . '">';

		} elseif (strstr($item_section, 'group')) {
			
			$j = substr($item_section, -1);
			
			if(isset($this->item->positions['group_'.$j])){
				
				echo '<div class="group-'.$j.' '.$this->params->get('item_css_group_'.$j, '').'">';
				
				foreach ($this->item->positions['group_'.$j] as $field){
									
					echo lyquixFlexicontentTmpl::renderItemField($this->item,$field);
					
				}
				
				echo '</div>';
				
			}
		}
	}
	
	echo '</div>' .
		 '</div>';
}