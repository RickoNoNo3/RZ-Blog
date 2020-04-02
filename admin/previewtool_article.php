<?php
# @Author RickoNoNo3

require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../lib/md.php');

$filename = '.preview.md';
$content = @file_get_contents('php://input');
if ($content) {
	$fp = fopen($GLOBALS['FILELOC'] . $filename, 'w');
	fwrite($fp, $content);
} else {
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo $GLOBALS['MYSTYLE']; ?>">
	<link rel="stylesheet" href="<?php echo $GLOBALS['HIGHLIGHTSTYLE']; ?>">
	<script src="/js/include.js"></script>
	<script src="/js/highlight/highlight.pack.js"></script>
	<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>
	<style>
	.mycontent, h1, h2, h3, h4, h5, h6{
		margin: 0;
		padding: 0;
		width: 100%;
	}
	</style>
</head>
<body>
	<div class="mycontent" id="content">
		<?php MdParser($filename); ?>
	</div>
</body>
<?php
}
