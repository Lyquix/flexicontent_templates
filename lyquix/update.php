<?php

$url = 'https://github.com/Lyquix/flexicontent_templates/archive/master.zip';

file_put_contents("master.zip", fopen($url, 'r'));

$zip = new ZipArchive;
$res = $zip -> open('master.zip');

if ($res === TRUE) {
	$zip -> extractTo('tmp/');
	$zip -> close();
	copy_dir('tmp/flexicontent_templates-master/lyquix', './');
	copy_dir('tmp/flexicontent_templates-master/json', '../json');
	copy_dir('tmp/flexicontent_templates-master/custom', '../custom');
	$custom_dirs = glob('../custom-*', GLOB_ONLYDIR);
	foreach($custom_dirs as $dst) {
		copy_dir('tmp/flexicontent_templates-master/custom', $dst);
	}
}

unlink('master.zip');
delete_dir('tmp');

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
