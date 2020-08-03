<?php
// debug conf
$INDEBUG = false;

// basic conf
$BLOGTITLE = 'R崽的博客';
$FILELOC = '/root/blog/' . 'resources/articles/';

// style conf
$MYSTYLE = '/css/myStyles.css';
$MYSTYLE_MOBILE = '/css/myStyles.mob.css';
$HIGHLIGHTSTYLE = '/js/highlight/styles/darcula.my.css'; // '/js/highlight/styles/isbl-editor-light.my.css';
$ICONS = [
	0 => 'description',
	1 => 'class',
//	0 => '/img/file.png',
//	1 => '/img/folder.png',
];




#------ NO EDITING AFTER THIS LINE!!! ------
require_once(dirname(__FILE__) . '/lib/checkAgent.php');
$ISMOBILE = CheckAgent();
if (!$ISMOBILE) {
	$ISMICROSOFT = HaveAgent(['edge', 'trident']);
	$ISIE = HaveAgent(['trident']);
}

if ($GLOBALS['INDEBUG']) {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
}
