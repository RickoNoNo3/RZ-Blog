<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# the html view for an article page

require_once(dirname(__FILE__) . '/globalView.php');
/* ------------------------------
 * GetHTMLTitle returns the title(filename) of this markdown
 */
function ArtTitle($loc) {
	$filepos = strrpos($loc, "/");// + 1;
	if ($filepos != 0) // find a '/'
		$filepos++;
	$len = strrpos($loc, ".") - $filepos;
	return substr($loc, $filepos, $len);
}

/* ------------------------------
 * LoadArtViewHeader prints the artView header
 */
function LoadArtViewHeader($title) {
	BasicHEADBegin(PageTitle($title));
	BasicHEADEnd();
?>

<body>
	<?php LoadHeader(); ?>
	<div class="mybox" id="box">
	<div class="mycontent" id="content">
		<div class="mytitle" id="title"><?php echo $title; ?></div>
		<div class="line"></div>

<?php
}

/* ----------------------------------
 * LoadArtViewFooter prints the artView footer
 */
function LoadArtViewFooter() {
?>

	</div>
	</div>
	<?php LoadFooter(); ?>
</body>
<script>
var codes = document.getElementsByTagName('code');
for (let i = 0; i < codes.length; ++i)
	hljs.highlightBlock(codes[i]);
</script>
</html>

<?php
}
