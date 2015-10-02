<?php

defined('_JEXEC') or die('Restricted access');


class lyquixFlexicontentTmplFilters {
	
	function renderFilters() {
			
		// Lyquix filters engine
		
		/* Currently only the following functionality is available
		 * 
		 * - Filters works with GET requests, allows for better navigation
		 * - Only one filter and one value can be applied at a time
		 * - All filters displayed only as lists of links, with label
		 * 
		 */
		 
		$html = '';
		
		// generate array of filter values
		$db = JFactory::getDBO();
		$filter_values = array();
		foreach($this -> filters as $field_name => $filter) {
			
			//$query = $db -> getQuery(true);
			$query = 'SELECT ' . $filter -> filter_valuesselect;
			$query .= ' FROM #__content AS i ';
			$query .= $filter -> filter_valuesjoin ? $filter -> filter_valuesjoin : '';
			$query .= $filter -> filter_valueswhere ? $filter -> filter_valueswhere : '';
			$query .= $filter -> filter_groupby ? $filter -> filter_groupby : '';
			$query .= $filter -> filter_having ? $filter -> filter_having : '';
			$query .= $filter -> filter_orderby ? $filter -> filter_orderby : '';
	//		$html .= '<!--' . $query . '-->';
			
			$db->setQuery($query);
			$filter_values[$field_name] = $db -> loadAssocList();
			
		}
	
	//	$html .= '<!--' . print_r($this, true) . '-->';
	//	$html .= '<!--' . print_r($this -> filters, true) . '-->';
	//	$html .= '<!--' . print_r($filter_values, true) . '-->';			
		
		// print filters
		foreach($this -> filters as $field_name => $filter) {
			
			// get current active filters
			$request_filters = JRequest::getVar('filter_' . $filter -> id);
			
			// make sure filter values are in an array
			if(!is_array($request_filters)){
				if(JRequest::getVar('filter_' . $filter -> id)) {
					$request_filters = array(JRequest::getVar('filter_' . $filter -> id));
				}
				else {
					$request_filters = array();
				}
			}
			
			$html .= '<div class="filter filter_' . $field_name . ' field_type_' . $filter -> field_type . '">';
			$html .= '<div class="label">' . $filter -> label . '</div>';
			$html .= '<ul>';
			
			foreach($filter_values[$field_name] as $filter_value) {
				
				$html .= '<li data-filter="' . $filter -> id . ':' . $field_name . '/' . $filter_value['value'] . ':' . JFilterOutput::stringURLSafe($filter_value['text']) . 
					(in_array($filter_value['value'], $request_filters) ? '" class="checked' : '') . 
					'">';
				
				$html .= '<a href="' . JRoute::_(FlexicontentHelperRoute::getCategoryRoute($this -> category -> slug)) . 
					'&filter_' . $filter -> id . '[]=' . $filter_value['value'] . 
					'">';
				
				$html .= $filter_value['text'] . '</a></li>';
			}
			
			$html .= '</ul>';
			$html .= '</div>';
			
		}
		
		return $html;
		
	}
}
		
