<?php
// debug conf
$INDEBUG = false;

// basic conf
$BLOGTITLE = 'R崽的博客';
$FILELOC = '/root/blog/' . 'resource/articles/';

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
$BGIMG = 'http://pic1.win4000.com/wallpaper/2019-03-26/5c99b7fc7d50e.jpg';




#------ NO EDITING AFTER THIS LINE!!! ------
require_once(dirname(__FILE__) . '/lib/checkAgent.php');
$ISMOBILE = CheckAgent();
$ISMICROSOFT = HaveAgent(['edge', 'trident']);
$ISIE = HaveAgent(['trident']);

if ($GLOBALS['INDEBUG']) {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
}
