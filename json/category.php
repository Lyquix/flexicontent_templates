<?php
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'templates' . DS . 'lyquix' . DS . 'functions.php');

$lyquixFlexicontentTmpl = new lyquixFlexicontentTmpl($this);
echo $lyquixFlexicontentTmpl -> renderJSONcat();
