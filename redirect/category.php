<?php
/**
 * category.php
 *
 * @version     2.3.0
 * @package     flexicontent_templates
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/flexicontent_templates
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$redirect_url = $this -> params -> get('redirect_url', '/');

// if HTTP headers have not been sent
if (!headers_sent()) {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect_url);
	exit;
}
// headers have been sent, use meta-tag, javascript and HTML failsafe
else {
	// set meta data
	$doc =& JFactory::getDocument();
	$doc -> setMetaData( 'refresh', '0;URL=\'' . $redirect_url . '\'', true );
	// render a javascript redirect
	echo '<script>window.location.replace("' . $redirect_url . '");</script>';
	// last resort: provide a redirect link
	echo '<p>This page has moved, <a href="' . $redirect_url . '">click here if you are not redirected automatically</a></p>';
}
