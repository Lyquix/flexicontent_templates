<?php

// download the latest from github
file_put_contents("master.zip", fopen('https://github.com/Lyquix/flexicontent_templates/archive/master.zip', 'r'));

// new zip file object
$zip = new ZipArchive;

if ($zip -> open('master.zip') === TRUE) {
	// no errors opening the file, extract to tmp directory
	$zip -> extractTo('tmp/');
	$zip -> close();
	
	// copy fresh files to base templates
	copy_dir('tmp/flexicontent_templates-master/lyquix', './');
	copy_dir('tmp/flexicontent_templates-master/json', '../json');
	copy_dir('tmp/flexicontent_templates-master/custom', '../custom');
	
	// find any custom-* template directory and copy custom directory there
	$custom_dirs = glob('../custom-*', GLOB_ONLYDIR);
	foreach($custom_dirs as $dst) {
		copy_dir('tmp/flexicontent_templates-master/custom', $dst);
	}
	
	// delete zip file and tmp directory
	unlink('master.zip');
	delete_dir('tmp');
}



function copy_dir($src, $dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while (false !== ($file = readdir($dir))) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				copy_dir($src . '/' . $file, $dst . '/' . $file);
			} else {
				copy($src . '/' . $file, $dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

function delete_dir($dirPath) {
	if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		$dirPath .= '/';
	}
	$files = glob($dirPath . '*', GLOB_MARK);
	foreach ($files as $file) {
		if (is_dir($file)) {
			delete_dir($file);
		} else {
			unlink($file);
		}
	}
	rmdir($dirPath);
}
