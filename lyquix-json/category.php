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
	"layout":"category",
	"title":"<?php echo jsonEscapeString($this->category->title); ?>",
	"alias":"<?php echo jsonEscapeString($this->category->alias); ?>",
	"description":"<?php echo jsonEscapeString($this->category->description); ?>",
	"url":"<?php echo jsonEscapeString(JRoute::_(FlexicontentHelperRoute::getCategoryRoute($this->category->slug))); ?>",
	"items":[
<?php echo $this->loadTemplate('items'); ?>
	]
}<?php
if($callback!='') {
	echo ");";
}?>