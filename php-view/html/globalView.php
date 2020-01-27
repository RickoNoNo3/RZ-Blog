<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# The Global fixed html header and footer

require_once(dirname(__FILE__) . '/../config.php');

/* ------------------------------
 * PageTitle return s a title text
 * @param string title => the title name of the page
 * @param bool addSuffix=true => whether to add $BLOGTITLE as suffix */
function PageTitle(string $title = '', bool $addSuffix = true) {
	if (trim($title) == '')
		return $GLOBALS['BLOGTITLE'];
	if ($addSuffix)
		return $title . ' - ' . $GLOBALS['BLOGTITLE'];
	else
		return $title;
}

/* ------------------------------
 * BasicHEADBegin
 */
function BasicHEADBegin($pagetitle) {
?>

<!DOCTYPE html>
<html id="html">
<head>
	<meta charset="utf-8">
	<title><?php echo $pagetitle; ?></title>
	<link rel="stylesheet" href="/css/myStyles.css">
	<link rel="stylesheet" href="/js/highlight/styles/isbl-editor-light.my.css">
	<script src="/js/include.js"></script>
	<script src="/js/highlight/highlight.pack.js"></script>

<?php
}

/* ------------------------------
 * BasicHEADEnd
 */
function BasicHEADEnd() {
?>

</head>

<?php
}

/* ------------------------------
 * LoadHeader prints the  header
 */
function LoadHeader() {
?>
<div class="mynav">
		<ul class="mymenubar">
		<li class="mymenuli"><a class="mymenu" href="/">主页</a></li>
		<li class="mymenuli"><a class="mymenu" href="/blog.php">博客</a></li>
		<li class="mymenuli"><a class="mymenu" href="/about.php">关于</a></li>
		</ul>
		<div class="mynavicon"><img src="/img/navicon.png" width="50px" height="50px" alt="" /></div>
	</div>

<?php
}

/* ----------------------------------
 * LoadFooter prints the  footer
 */
function LoadFooter() {
?>

	<div class="myfoot"><a href="/">R崽的博客</a></div>
<script>
	if(checkIE()){
		document.body.style.display = "block";
	}
</script>
<?php
}
