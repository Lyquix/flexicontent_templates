<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// Set mime type to JSON
$doc =& JFactory::getDocument();
$doc->setMimeEncoding('application/json');

$item = $this -> item;

$url = JRoute::_(JURI::base() . FlexicontentHelperRoute::getItemRoute($item -> slug, $item -> categoryslug));
$json = array();
$json['layout'] = 'item';
if($this -> params -> get ('display_item_id', 1)) $json['id'] = $item -> id;
if($this -> params -> get ('display_item_title', 1)) $json['title'] = $item -> title;
if($this -> params -> get ('display_item_alias', 1)) $json['alias'] = $item -> alias;
if($this -> params -> get ('display_item_author', 1)) $json['author'] = $item -> author;
if($this -> params -> get ('display_item_description', 1)) $json['description'] = $item -> text;
if($this -> params -> get ('display_item_created', 1)) $json['created'] = $item -> created;
if($this -> params -> get ('display_item_modified', 1)) $json['modified'] = $item -> modified;
if($this -> params -> get ('display_item_metadesc', 1)) $json['metadesc'] = $item -> metadesc;
if($this -> params -> get ('display_item_metakey', 1)) $json['metakey'] = $item -> metakey;
if($this -> params -> get ('display_item_url', 1)) $json['url'] = $url;
if($this -> params -> get ('display_item_json', 1)) $json['json'] = $url . (strpos($url, '?') ? '&' : '?') . 'iclayout=' . JRequest::getVar('ilayout') . '&tmpl=' . JRequest::getVar('tmpl');
if($this -> params -> get ('display_item_params', 0)) $json['params'] = json_decode($item -> params);
if($this -> params -> get ('display_item_fields', 1)) {
	$fields = array();
	if(isset($item -> positions)) {
		foreach($item -> positions as $position) {
			foreach($position as $field) {
				$fields[$field -> name] = array();
				if($this -> params -> get ('display_item_field_label', 1)) $fields[$field -> name]['label'] = $field -> label;
				if($this -> params -> get ('display_item_field_value', 1)) {
					if($item -> fields[$field -> name] -> iscore) {
						$fields[$field -> name]['value'] = $item -> {$field -> name};
					}
					else {
						$fields[$field -> name]['value'] = $item -> fieldvalues [$field -> id];
					}
				}
				if($this -> params -> get ('display_item_field_display', 1)) $fields[$field -> name]['display'] = $field -> display;
				
			}
		}
	}
	$json['fields'] = $fields;
}

if (JRequest::getVar('callback', '') != '') {
	echo JRequest::getVar('callback') . '(' . json_encode($json) . ')';
}
else {
	echo json_encode($json);
}

