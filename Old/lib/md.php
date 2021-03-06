<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# For markdown document dynamic generation.

require_once(dirname(__FILE__) . '/parsedown-1.7.4/Parsedown.php');
require_once(dirname(__FILE__) . '/../config.php');

function MdParser($filename) {
	$file = @file_get_contents($GLOBALS['FILELOC'] . urldecode($filename));

	if ($file === false) {
		if ($GLOBALS['INDEBUG'])
			printf("无法打开文件: %s", $filename);
		else
			echo '<script>location.href="/error";</script>';
		return false;
	}
	$mdParser = new Parsedown();
	echo $mdParser->text($file);
	#echo @file_get_contents($GLOBALS['FILELOC'] . 'test.html');
}

