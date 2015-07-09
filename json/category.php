<?php
defined('_JEXEC') or die('Restricted access');

// Set mime type to JSON
$doc = &JFactory::getDocument();
$doc -> setMimeEncoding('application/json');

// get category params
$catparams = json_decode($this -> category -> params);

$json = array(
	'layout' => 'category',
	'id' => $this -> category -> id,
	'title' => $this -> category -> title,
	'alias' => $this -> category -> alias,
	'description' => $this -> category -> description,
	'created' => $this -> category -> created_time,
	'modified' => $this -> category -> modified_time,
	'metadesc' => $this -> category -> metadesc,
	'metakey' => $this -> category -> metakey,
	'url' => JRoute::_(JURI::base() . FlexicontentHelperRoute::getCategoryRoute($this -> category -> slug)),
	'json' => JRoute::_(JURI::base() . FlexicontentHelperRoute::getCategoryRoute($this -> category -> slug) . '&clayout=' . JRequest::getVar('clayout') . '&tmpl=' . JRequest::getVar('tmpl')),
	'image' => JURI::base() . $catparams -> image,
	'items' => array()
);

foreach($this -> items as $item) {
	
	$fields = array();
	
	if(isset($item -> positions)) {
		foreach($item -> positions as $position) {
			
			foreach($position as $field) {
				
				if($item -> fields[$field -> name] -> iscore) {
					$fields[$field -> name] = array(
						'label' => $field -> label,
						'value' => $item -> {$field -> name}
					);
				}
				else {
					$fields[$field -> name] = array(
						'label' => $field -> label,
						'value' => $item -> fieldvalues [$field -> id]
					);
				}
				
			}
			
		}
	}
	
	$json['items'][] = array(
		'layout' => 'item',
		'id' => $item -> id,
		'title' => $item -> title,
		'alias' => $item -> alias,
		'author' => $item -> author,
		'created' => $item -> created,
		'modified' => $item -> modified,
		'metadesc' => $this -> metadesc,
		'metakey' => $this -> metakey,
		'url' => JRoute::_(JURI::base() . FlexicontentHelperRoute::getItemRoute($item -> slug, $item -> categoryslug)),
		'json' => JRoute::_(JURI::base() . FlexicontentHelperRoute::getItemRoute($item -> slug, $item -> categoryslug) . '&ilayout=' . JRequest::getVar('clayout') . '&tmpl=' . JRequest::getVar('tmpl')),
		'fields' => $fields
	);
}

if (JRequest::getVar('callback', '') != '') {
	echo JRequest::getVar('callback') . '(' . json_encode($json) . ')';
}
else {
	echo json_encode($json);
}


