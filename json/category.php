<?php
defined('_JEXEC') or die('Restricted access');

// Set mime type to JSON
$doc = &JFactory::getDocument();
$doc -> setMimeEncoding('application/json');

// get category params
$category = $this -> category;
$url = JRoute::_(JURI::base() . FlexicontentHelperRoute::getCategoryRoute($category -> slug));
$catparams = json_decode($category -> params);
$json = array();
$json['layout'] = 'category';
if($this -> params -> get ('display_cat_id', 1)) $json['id'] = $category -> id;
if($this -> params -> get ('display_cat_title', 1)) $json['title'] = $category -> title;
if($this -> params -> get ('display_cat_alias', 1)) $json['alias'] = $category -> alias;
if($this -> params -> get ('display_cat_description', 1)) $json['description'] = $category -> description;
if($this -> params -> get ('display_cat_image', 1)) $json['image'] = $catparams -> image ? JURI::base() . $catparams -> image : '';
if($this -> params -> get ('display_cat_created', 1)) $json['created'] = $category -> created_time;
if($this -> params -> get ('display_cat_modified', 1)) $json['modified'] = $category -> modified_time;
if($this -> params -> get ('display_cat_metadesc', 1)) $json['metadesc'] = $category -> metadesc;
if($this -> params -> get ('display_cat_metakey', 1)) $json['metakey'] = $category -> metakey;
if($this -> params -> get ('display_cat_url', 1)) $json['url'] = $url;
if($this -> params -> get ('display_cat_json', 1)) $json['json'] = $url . (strpos($url, '?') ? '&' : '?') . 'clayout=' . JRequest::getVar('clayout') . '&tmpl=' . JRequest::getVar('tmpl');
if($this -> params -> get ('display_cat_params', 0)) $json['params'] = $catparams;

// process category items
$json['items'] = array();
foreach($this -> items as $item) {
	
	$url = JRoute::_(JURI::base() . FlexicontentHelperRoute::getItemRoute($item -> slug, $item -> categoryslug));
	$json_item = array();
	$json_item['layout'] = 'item';
	if($this -> params -> get ('display_item_id', 1)) $json_item['id'] = $item -> id;
	if($this -> params -> get ('display_item_title', 1)) $json_item['title'] = $item -> title;
	if($this -> params -> get ('display_item_alias', 1)) $json_item['alias'] = $item -> alias;
	if($this -> params -> get ('display_item_author', 1)) $json_item['author'] = $item -> author;
	if($this -> params -> get ('display_item_description', 1)) $json_item['description'] = $item -> text;
	if($this -> params -> get ('display_item_created', 1)) $json_item['created'] = $item -> created;
	if($this -> params -> get ('display_item_modified', 1)) $json_item['modified'] = $item -> modified;
	if($this -> params -> get ('display_item_metadesc', 1)) $json_item['metadesc'] = $item -> metadesc;
	if($this -> params -> get ('display_item_metakey', 1))  $json_item['metakey'] = $item -> metakey;
	if($this -> params -> get ('display_item_url', 1)) $json_item['url'] = $url;
	if($this -> params -> get ('display_item_json', 1)) $json_item['json'] = $url . (strpos($url, '?') ? '&' : '?') . 'ilayout=' . JRequest::getVar('clayout') . '&tmpl=' . JRequest::getVar('tmpl');
	if($this -> params -> get ('display_item_params', 0)) $json_item['params'] = json_decode($item -> params);
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
		$json_item['fields'] = $fields;
	}
	$json['items'][] = $json_item;
}

if (JRequest::getVar('callback', '') != '') {
	echo JRequest::getVar('callback') . '(' . json_encode($json) . ')';
}
else {
	echo json_encode($json);
}


