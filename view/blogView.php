<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# the html view for an dir or article page
# 
# Usage:
#   GetTitle($loc)
#      |$title|
#   LoadBlogViewBegin($title, $isArt = true)
#     your content...
#   LoadBlogViewEnd()

require_once(dirname(__FILE__) . '/globalView.php');
$ISART = isset($ISART) ? $ISART : false;
/* ------------------------------
 * GetTitle returns the title(filename) of this markdown
 */
function GetTitle($loc)
{
	$filepos = strrpos($loc, "/"); // + 1;
	if ($filepos != 0) // find a '/'
		$filepos++;
	$suffix = strrpos($loc, ".");
	if ($suffix !== false) {
		$len = strrpos($loc, ".") - $filepos;
		return substr($loc, $filepos, $len);
	} else {
		return substr($loc, $filepos);
	}
}

/* ------------------------------
 * LoadBlogViewBegin
 */
function LoadBlogViewBegin($title, $isArt = true)
{
?>
	<?php LoadHTMLBegin(PageTitle($title)); ?>
	<?php if ($isArt) :
		$GLOBALS['ISART'] = true;
	?>
		<link rel="stylesheet" href="<?php echo $GLOBALS['HIGHLIGHTSTYLE']; ?>">
		<script src="/js/highlight/highlight.pack.js"></script>
		<meta name="keywords" content="<?php echo $title; ?>,R崽的博客">
		<meta name="description" content="<?php echo $title; ?>">
	<?php endif; ?>
	<?php
	$res = "";

	// replace '/view/path/to/article/filename'
	// to      '/path/to/article'
	$locstr = preg_replace('/^\/blog(.*)\/[^\/]*$/i', '\1', urldecode($_SERVER['REQUEST_URI']));

	// to array
	$locs = explode('/', $locstr);
	array_shift($locs);

	// prepare for locstr
	$res .= '<a target="_top" href="/blog/">博客</a>';
	$nowloc = '/blog/';
	foreach ($locs as $loc) {
		$nowloc .= urlencode($loc) . '/';
		$res .= ' &gt; ';
		$res .= '<a target="_top" href="' . $nowloc . '">' . $loc . '</a>';
	}
	LoadHTMLBodyBegin($res);
	?>
	<div class="mybox" id="box">
		<div class="mycontent" id="content">
			<!--<h1 class="mytitle" id="title">
					<?php echo $title; ?>
				</h1>-->
			<!--<div class="line"></div>-->
			<!-- content start -->
	<?php
}

/// ----------------------------------
// LoadBlogViewEnd prints the footer
// 
function LoadBlogViewEnd()
{
	?>
		<!-- content end -->
	</div> <!-- mycontent -->
</div> <!-- mybox -->
<?php LoadHTMLBodyEnd(); ?>
<?php LoadHTMLScript(); ?>
<script>
	<?php if ($GLOBALS['ISART']) : ?>
		hljs.initHighlighting();

		function loadText(texts) {
			for (var i = 0; i < texts.length; ++i) {
				if (texts[i].innerHTML == null)
					continue;
				texts[i].innerHTML = texts[i].innerHTML.replace(/([^\\])\$(.+?)\$/g, '$1\\($2\\)');
				texts[i].innerHTML = texts[i].innerHTML.replace(/\\\$/, '\$');
			}
		}
		loadText(document.getElementsByTagName('p'));
		loadText(document.getElementsByTagName('li'));
	<?php endif; ?>
</script>
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_SVG"></script>
<?php LoadHTMLEnd(); ?>
<?php
}
