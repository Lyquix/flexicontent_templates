<?php 

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'functions.php');

echo '<div class="fc-item tmpl-'.str_replace('.items.','',$this->tmpl).' item-'.$this->item->alias.'">';

for($j = 1; $j <= 7; $j++){
		
	if(isset($this->item->positions['group_'.$j])){
		
		echo '<div class="group-'.$j.' '.$this->params->get('item_css_group_'.$j, '').'">';
		
		foreach ($this->item->positions['group_'.$j] as $field){
							
			echo lyquixFlexicontentTmpl::renderItemField($this->item,$field);
			
		}
		
		echo '</div>';
		
	}
}

echo '</div>';