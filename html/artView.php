<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# the html view for an dir or article page

require_once(dirname(__FILE__) . '/globalView.php');
/* ------------------------------
 * GetTitle returns the title(filename) of this markdown
 */
function GetTitle($loc) {
	$filepos = strrpos($loc, "/");// + 1;
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
 * LoadArtViewBegin
 */
function LoadArtViewBegin($title) {
?>
	<?php LoadHTMLBegin(PageTitle($title)); ?>
		<!-- MathJAX -->
		<script type="text/javascript"
			src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
		</script>
		<?php
		$res = "";

		// replace '/view/path/to/article/filename'
		// to      '/path/to/article'
		$locstr = preg_replace('/^\/view(.*)\/[^\/]*$/i', '\1', urldecode($_SERVER['REQUEST_URI']));

		// to array
		$locs = explode('/', $locstr);
		array_shift($locs);

		// draw html
		$res .= '<a target="_top" href="/view/">博客</a>';
		$nowloc = '/view/';
		foreach($locs as $loc) {
			$nowloc .= urlencode($loc) . '/';
			$res .= ' &gt; ';
			$res .= '<a target="_top" href="' . $nowloc . '">' . $loc . '</a>';
		}
		LoadHTMLBodyBegin($res);
		?>
			<div class="mybox" id="box">
			<div class="mycontent" id="content">
				<div class="mytitle" id="title">
					<?php echo $title; ?>
				</div>
				<div class="line"></div>
				<!-- content start -->
<?php
}

/* ----------------------------------
 * LoadArtViewEnd prints the artView footer
 */
function LoadArtViewEnd() {
?>
				<!-- content end -->
			</div> <!-- mycontent -->
			</div> <!-- mybox -->
		<?php LoadHTMLBodyEnd(); ?>
		<?php LoadHTMLScript(); ?>
		<script>
			hljs.initHighlighting();

			function loadText(texts) {
				for (let i in texts) {
					if (texts[i].innerHTML == null)
						continue;
					texts[i].innerHTML = texts[i].innerHTML.replace(/([^\\])\$(.+?)\$/g, '$1\\($2\\)');
					texts[i].innerHTML = texts[i].innerHTML.replace(/\\\$/, '\$');
				}
			}
			loadText(document.getElementsByTagName('p'));
			loadText(document.getElementsByTagName('li'));
		</script>
	<?php LoadHTMLEnd(); ?>
<?php
}
