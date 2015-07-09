<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
/* Declare function to escape strings for JSON */
function jsonEscapeString($string) { # list from www.json.org: (\b backspace, \f formfeed)
	$escapers = array("\\", '"', "\n", "\r", "\t", "\x08", "\x0c");
	$replacements = array("\\\\", '\"', '\n', '\r', '\t', '\f', '\b');
	$result = str_replace($escapers, $replacements, $string);
	return $result;
}
/* Set mime type to JSON */
$doc =& JFactory::getDocument();
$doc->setMimeEncoding('application/json');
/* Get callback function name */
$callback = JRequest::getVar('callback');
if($callback!='') {
	echo $callback."(";
}
?>{
	"layout":"item",
	"title":"<?php echo jsonEscapeString($this->item->title); ?>",
	"alias":"<?php echo jsonEscapeString($this->item->alias); ?>",
	"created":"<?php echo jsonEscapeString($this->item->created); ?>",
	"modified":"<?php echo jsonEscapeString($this->item->modified); ?>",
	"metakey":"<?php echo jsonEscapeString($this->item->metakey); ?>",
	"metadesc":"<?php echo jsonEscapeString($this->item->metadesc); ?>",
	"author":"<?php echo jsonEscapeString($this->item->author); ?>",
	"description":"<?php echo jsonEscapeString($this->item->text); ?>",
	"tags":[<?php 
			if(count($this->item->tags)>0){
				$tags = Array();
				foreach($this->item->tags as $tag) {
					array_push($tags,jsonEscapeString($tag->name)); 
				}
				echo '"'.implode('","',$tags).'"';
			} ?>],
	"url":"<?php echo jsonEscapeString(JRoute::_(FlexicontentHelperRoute::getItemRoute($this->item->slug, $this->item->categoryslug))); ?>",
	"fields":{
<?php
if(isset($this->item->positions['renderonly'])) {
	$fields = Array();
	foreach($this->item->positions['renderonly'] as $field) {
		if(isset($this->item->fieldvalues[$field->id])){
			$fieldvalues = Array();
			foreach($this->item->fieldvalues[$field->id] as $fieldvalue){
				$unserval = unserialize($fieldvalue);
				if($unserval) {
					$valuearray = Array();
					foreach($unserval as $key => $val) {
						$valueobj = '"'.str_replace('"','\"',$key).'":"';
						$val = jsonEscapeString($val);
						$valueobj .= $val.'"';
						array_push($valuearray,$valueobj);
					}
					$unserval = implode(',',$valuearray);
					$unserval = '{'.$unserval.'}';
				}
				else {
					$unserval = '"'.jsonEscapeString($fieldvalue).'"';
				}
				array_push($fieldvalues,$unserval);
			}
			$value = implode(',',$fieldvalues);
			array_push($fields,"\t\t".'"'.jsonEscapeString($field->name).'":['.$value.']');
		}
	}
	echo implode(",\n",$fields);
}?>

	}
}<?php
if($callback!='') {
	echo ");";
}