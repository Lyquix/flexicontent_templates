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
	// if these are not a directories, do nothing
	if(is_dir($src) && is_dir($dst)) {
		// add trailing / if missing
		if (substr($src, strlen($src) - 1, 1) != '/') {
			$src .= '/';
		}
		if (substr($dst, strlen($dst) - 1, 1) != '/') {
			$dst .= '/';
		}
		
		// get list of all files and sub-directories
		$files = scandir($src);
		
		foreach ($files as $file) {
			
			// if directory, recurse into this function
			if (is_dir($src . $file)) {
				
				// ignore . and .. directories
				if ($file != '.' && $file != '..') {
					copy_dir($src . $file, $dst . $file);
				}
				
			} else {
				// copy file
				copy($src . $file, $dst . $file);
			}
		}
	}
}

function delete_dir($dirPath) {
	// if this is not a directory, do nothing
	if(is_dir($dirPath)) {
		// add trailing / if missing
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		
		// get list of all files and sub-directories
		$files = scandir($dirPath);
		
		foreach ($files as $file) {
			
			// if directory, recurse into this function
			if (is_dir($dirPath . $file)) {
				
				// ignore . and .. directories
				if ($file != '.' && $file != '..') {
					delete_dir($dirPath . $file);
				}
				
			} else {
				// delete file
				unlink($dirPath . $file);
			}
		}
		// remove directory now (should be empty)
		rmdir($dirPath);
	}
}
