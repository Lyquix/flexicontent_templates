<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// Set mime type to JSON
$doc =& JFactory::getDocument();
$doc->setMimeEncoding('application/json');

$fields = array();

if(isset($this -> item -> positions)) {
	foreach($this -> item -> positions as $position) {
		
		foreach($position as $field) {
			
			if($this -> item -> fields[$field -> name] -> iscore) {
				$fields[$field -> name] = array(
					'label' => $field -> label,
					'value' => $this -> item -> {$field -> name}
				);
			}
			else {
				$fields[$field -> name] = array(
					'label' => $field -> label,
					'value' => $this -> item -> fieldvalues [$field -> id]
				);
			}
			
		}
		
	}
}

$json = array(
	'layout' => 'item',
	'id' => $this -> item -> id,
	'title' => $this -> item -> title,
	'alias' => $this -> item -> alias,
	'author' => $this -> item -> author,
	'created' => $this -> item -> created,
	'modified' => $this -> item -> modified,
	'metadesc' => $this -> metadesc,
	'metakey' => $this -> metakey,
	'url' => JRoute::_(JURI::base() . FlexicontentHelperRoute::getItemRoute($this -> item -> slug, $this -> item -> categoryslug)),
	'json' => JRoute::_(JURI::base() . FlexicontentHelperRoute::getItemRoute($this -> item -> slug, $this -> item -> categoryslug) . '&ilayout=' . JRequest::getVar('clayout') . '&tmpl=' . JRequest::getVar('tmpl')),
	'fields' => $fields
);

if (JRequest::getVar('callback', '') != '') {
	echo JRequest::getVar('callback') . '(' . json_encode($json) . ')';
}
else {
	echo json_encode($json);
}

