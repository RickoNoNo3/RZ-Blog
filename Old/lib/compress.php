<?php

/**
 * 压缩HTML代码
 *
 * @author  情留メ蚊子 <qlwz@qq.com>
 * @version 1.0.0.0 By 2016-11-23
 * @link    http://www.94qing.com
 * @param string $html_source HTML源码
 * @return string 压缩后的代码
 */
function CompressHtml($html_source)
{
	$chunks   = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
	$compress = '';
	foreach ($chunks as $c) {
		if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
			$c        = substr($c, 19, strlen($c) - 19 - 20);
			$compress .= $c;
			continue;
		} elseif (strtolower(substr($c, 0, 12)) == '<nocompress>') {
			$c        = substr($c, 12, strlen($c) - 12 - 13);
			$compress .= $c;
			continue;
		} elseif (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
			$compress .= $c;
			continue;
		} elseif (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) { // JS代码，包含“//”注释的，单行代码不处理
			$tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
			$c    = '';
			foreach ($tmps as $tmp) {
				if (strpos($tmp, '//') !== false) { // 对含有“//”的行做处理
					if (substr(trim($tmp), 0, 2) == '//') { // 开头是“//”的就是注释
						continue;
					}
					$chars   = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
					$is_quot = $is_apos = false;
					foreach ($chars as $key => $char) {
						if ($char == '"' && !$is_apos && $key > 0 && $chars[$key - 1] != '\\') {
							$is_quot = !$is_quot;
						} elseif ($char == '\'' && !$is_quot && $key > 0 && $chars[$key - 1] != '\\') {
							$is_apos = !$is_apos;
						} elseif ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
							$tmp = substr($tmp, 0, $key); // 不是字符串内的就是注释
							break;
						}
					}
				}
				$c .= $tmp;
			}
		}

		$c        = preg_replace('/[\\n\\r\\t]+/', ' ', $c); // 清除换行符，清除制表符
		$c        = preg_replace('/\\s{2,}/', ' ', $c); // 清除额外的空格
		$c        = preg_replace('/>\\s</', '> <', $c); // 清除标签间的空格
		$c        = preg_replace('/\\/\\*.*?\\*\\//i', '', $c); // 清除 CSS & JS 的注释
		$c        = preg_replace('/<!--[^!]*-->/', '', $c); // 清除 HTML 的注释
		$compress .= $c;
	}
	return $compress;
}
