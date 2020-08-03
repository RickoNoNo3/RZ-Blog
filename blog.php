<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# Show the filelist in a dir (if query_string is a dir)
#   or articles from a file. (if query_string is a file)
#
# Use your nginx (or apache2) to link to this page with
# location matching, and rewrite URI:
#   location /view/ {
#     try_files $uri $uri/ /article.php;
#   }
#

require_once(dirname(__FILE__) . '/view/blogView.php');
require_once(dirname(__FILE__) . '/lib/md.php');
require_once(dirname(__FILE__) . '/lib/list.php');

$loc = urldecode($_SERVER['REQUEST_URI']);
if (substr($loc, 0, 6) === '/blog/') {
	$loc = substr($loc, 6);
	// is dir or file
	if (strlen($loc) === 0 || strrpos($loc, '/') === strlen($loc) - 1) {
		// draw list
		LoadBlogViewBegin('文章列表', false);
		ListDir($loc);
	} else {
		// suffix
		LoadBlogViewBegin(GetTitle($loc));
		if (strrpos($loc, '.') === false || in_array(substr($loc, strrpos($loc, '.') + 1), ['txt', 'markdown', 'html', 'php'], true) === false)
			$loc .= '.md';
		// draw markdown
		MdParser($loc);
	}
	LoadBlogViewEnd();
} else {
	echo '<script>location.href="/error";</script>';
}
