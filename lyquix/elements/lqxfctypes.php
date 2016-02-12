<?php
defined('_JEXEC') or die('Restricted access');

jimport('cms.html.html');      // JHtml
jimport('cms.html.select');    // JHtmlSelect
jimport('joomla.form.field');  // JFormField
//jimport('joomla.form.helper'); // JFormHelper
//JFormHelper::loadFieldClass('...');   // JFormField...

class JFormFieldLqxfctypes extends JFormField
{
	/**
	 * Element name
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'lqxfctypes';

	function getInput()
	{
		$doc = JFactory::getDocument();
		$db  = JFactory::getDBO();
		
		$node = & $this->element;
		$attributes = get_object_vars($node->attributes());
		$attributes = $attributes['@attributes'];
				
		$query = 'SELECT name AS value, name AS text'
		. ' FROM #__flexicontent_types'
		. ' WHERE published = 1'
		. ' ORDER BY name ASC, id ASC'
		;
		
		$db->setQuery($query);
		$types = $db->loadObjectList();
		
		$values = $this->value;
		if ( empty($values) )							$values = array();
		else if ( ! is_array($values) )		$values = !FLEXI_J16GE ? array($values) : explode("|", $values);
		
		$fieldname	= $this->name;
		$element_id = $this->id;
		
		$attribs = 'style="float:left;"';
		if (@$attributes['multiple']=='multiple' || @$attributes['multiple']=='true' ) {
			$attribs .= ' multiple="multiple" ';
			$attribs .= @ $attributes['size'] ? ' size="'.$attributes['size'].'" ' : ' size="6" ';
		} else {
			if ( @ $attributes['user_selection'] )
				array_unshift($types, JHTML::_('select.option', '', JText::_('FLEXI_MENU_ALLOW_CONTENT_TYPE_SELECTION')));
			else
				array_unshift($types, JHTML::_('select.option', '', JText::_('FLEXI_PLEASE_SELECT')));
		}
		if ($onchange = @$attributes['onchange']) {
			$attribs .= ' onchange="'.$onchange.'"';
		}
		if ($class = @$attributes['class']) {
			$attribs .= ' class="'.$class.'"';
		}

		$html = JHTML::_('select.genericlist', $types, $fieldname, $attribs, 'value', 'text', $values, $element_id);
		
		$html .= '<script>jQuery(document).ready(function(){jQuery("#' . $element_id . '").select2();});</script>';
		
		return $html;
	}
}
