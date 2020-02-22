<?php
# 2020 Feb. 4th
# @Author RickoNoNo3
#
# ListDir
#

require_once(dirname(__FILE__) . '/../config.php');

class File{
	public $fname;
	public $isdir;
	public $time;
	public function __construct($_fname, $_isdir, $_time) {
		$this->fname = $_fname;
		$this->isdir = $_isdir;
		$this->time = $_time;
	}
	public function cutFilename() {
		$res = preg_replace('/^(.*)[.](md)$/', '\1', $this->fname);
		if ($res !== false)
			return $res;
		else
			return $this->fname;
	}
}

function ListDir(string $dirloc) {
	$dirloc_full = $GLOBALS['FILELOC'] . $dirloc;
	$filenames = scandir($dirloc_full);
	if (!$filenames) {
		echo '<script>location.href="/error";</script>';
		return false;
	}

	// make file list
	foreach($filenames as $i => $filename) {
		if ($filename[0] === '.') continue;
		$filename_full = $dirloc_full . $filename;
		$list[] = new File($filename, is_dir($filename_full), filemtime($filename_full));
	}

	if (!isset($list)) {
?>
		<div class="notice">该目录下暂无内容</div>
<?php
	} else {
	// sort file list
	usort($list, function($a, $b) {
		// dirs first
		if ($a->isdir && !$b->isdir)
			return -1;
		else if (!$a->isdir && $b->isdir)
			return 1;
		// closer time will be sorted more forward
		return $b->time - $a->time;
	});

	// draw file list
?>
		<div id="list">
<?php
		foreach($list as $i => $file) {
?>
			<a class="<?php
				echo ($i % 2 ? 'leven' : 'lodd'); ?>"
				href="<?php
					echo '/view/' . $dirloc . $file->cutFilename() . ($file->isdir ? '/' : ''); ?>">
				<div class="name">
					<?php //if (!$GLOBALS['ISIE']) : ?>
					<i class="material-icons">
						<?php
						echo $GLOBALS['ICONS'][($file->isdir ? 1 : 0)];
						?>
					</i>
					<?php //endif; ?>
					<?php echo $file->cutFilename(); ?>
				</div>
				<div class="time">
					<?php echo date('Y/m/d', $file->time) . ''; ?>
				</div>
			</a>
<?php
		} // foreach
?>
		</div>
<?php
	} // if
}
