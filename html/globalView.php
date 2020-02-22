<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# The Global fixed html header and footer
# Use example:
#   LoadHTMLBegin($pagetitle);
#
#     // your head code...
#     
#     LoadHTMLBodyBegin($locstr);
#     
#       // your body code...
#     
#     LoadHTMLBodyEnd();
#     LoadHTMLScript();
#     
#       // your script code...
#     
#   LoadHTMLEnd();

require_once(dirname(__FILE__) . '/../config.php');

$locPrefix = '当前位置: ';

/* ------------------------------
 * PageTitle return s a title text
 * @param title => the title name of the page
 * @param addSuffix=true => whether to add $BLOGTITLE as suffix */
function PageTitle(string $title = '', bool $addSuffix = true) {
	if (trim($title) == '')
		return $GLOBALS['BLOGTITLE'];
	if ($addSuffix)
		return $title . ' - ' . $GLOBALS['BLOGTITLE'];
	else
		return $title;
}

/* ------------------------------
 * LoadHTMLBegin
 */
function LoadHTMLBegin($pagetitle) {
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=0.5,maximum-scale=3.0, user-scalable=yes">
		<title><?php echo $pagetitle; ?></title>
		<link rel="stylesheet" href="<?php
			echo $GLOBALS[($GLOBALS['ISMOBILE'] ? 'MYSTYLE_MOBILE' : 'MYSTYLE')]; ?>">
		<link rel="stylesheet" href="<?php
			echo $GLOBALS['HIGHLIGHTSTYLE']; ?>">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="/js/include.js"></script>
		<script src="/js/highlight/highlight.pack.js"></script>
<?php
}

/* ------------------------------
 * LoadHTMLBodyBegin
 */
function LoadHTMLBodyBegin($locStr) {
	$locStr = $GLOBALS['locPrefix'] . $locStr;
?>
	</head>
	<body ismobile="<?php
		echo $GLOBALS['ISMOBILE'] ? 'true' : 'false'?>">
	<div class="mynav">
		<div class="mynavline">
			<ul class="mymenubar">
				<li class="mymenuli"><a class="mymenu" onclick="menuClick(0);" href="/">主页</a></li>
				<li class="mymenuli"><a class="mymenu" onclick="menuClick(1);" href="/view/">博客</a></li>
				<li class="mymenuli"><a class="mymenu" onclick="menuClick(2);" href="/about/">关于</a></li>
			</ul>
		</div>
		<div class="mynavicon">
			<!--<img src="/img/navicon.png" width="50px" height="50px" alt="" />-->
		</div>
	</div>
	<div class="myloc">
		<div class="mylocbar <?php
			echo ($GLOBALS['ISMICROSOFT'] ? 'edge' : 'normal'); ?>" id="locbar">
			<div class="mylocbarEX"></div>
			<span id="loclink">
				<?php echo $locStr; ?>
			</span>
		</div>
	</div>
<?php
}

/* ----------------------------------
 * LoadHTMLBodyEnd
 */
function LoadHTMLBodyEnd() {
?>
	<img id="BG" src="<?php
		echo $GLOBALS['BGIMG']; ?>" />
	<?php if (!$GLOBALS['ISIE']) : ?>
	<div id="BODYBLANK"></div>
	<div class="myfoot">
		<a href="/">R崽的博客</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="/">开源软件声明</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;
		Copyright © 2019 - 2020 R崽哗啦啦
	</div>
	<?php endif; ?>
<?php
}

/* ----------------------------------
 * LoadHTMLScript
 */
function LoadHTMLScript() {
?>
	<script>
		//-------------------
		//  IE
		//-------------------
		<?php if ($GLOBALS['ISIE']) : ?>
		(function() {
			var boxes = document.getElementsByClassName('mybox');
			for (let i in boxes) {
				if (boxes[i].style == null)
					continue;
				boxes[i].style.backgroundColor = 'rgba(5,5,1,0.8)';
			}
		})();
		<?php endif; ?>

		//-------------------
		//  弹出菜单控制
		//-------------------
		var mynav = document.getElementsByClassName('mynav')[0];
		var linkhrefs = {};

		(function() {
			var links = mynav.getElementsByTagName('a');
			for (let i in links) {
				linkhrefs[i] = links[i].href;
				links[i].href = 'javascript:void(0);';
			}
		})();

		function menuClick(index) {
			// 判断是否完整弹出
			if (mynav.offsetTop == 0) {
				window.location.href = linkhrefs[index];
			}
		}

		window.addEventListener("touchstart", function(){}, true);

		//-------------------
		//  地址栏相关
		//-------------------
		var locPrefix = '<?php echo $GLOBALS['locPrefix']; ?>';
		var locDOM = document.getElementsByClassName('myloc')[0];
		var loclink = document.getElementById('loclink');
		var loclink_full = loclink.innerHTML.replace(locPrefix, '').trim();

		var loclist = loclink_full.split(' &gt; ');

		function locRedraw() {
			function checkLocLength() {
				return (locDOM.offsetWidth > window.innerWidth);
			}
			loclink.innerHTML = locPrefix + loclink_full;
			if (checkLocLength()) {
				for (let i = 0; i < loclist.length; ++i) {
					if (!i) {
						loclink.innerHTML = '';
					} else {
						loclink.innerHTML = loclist[i-1].replace(/(<a.*>).*(<\/a>)/g, '$1...$2');
					}
					for (let j = i; j < loclist.length; ++j) {
						loclink.innerHTML += (j ? ' &gt; ' : '') + loclist[j];
					}
					if (!checkLocLength())
						return;
				}
			}
		}

		window.addEventListener('resize', locRedraw);
		locRedraw();

		//-------------------
		//  背景图相关
		//-------------------
		<?php if (!$GLOBALS['ISIE']) : ?>
		var BG = document.getElementById('BG');
		var imgHeight = 1080;
		var imgWidth = 1920;
		var imgRatio = imgWidth / imgHeight;

		function getSeenRatio() {
			var seenHeight = window.innerHeight;
			var seenWidth = window.innerWidth;
			var seenRatio = seenWidth / seenHeight;
			return seenRatio;
		}

		function bgScroll() {
			// 手机上不滚动
			if (document.body.getAttribute('ismobile') == 'true')
				return;
			var scrollTop = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
			var seenHeight = window.innerHeight;
			var allHeight = document.body.scrollHeight;
			var maxTop = (BG.offsetHeight != 0 ? BG.offsetHeight : imgHeight) - seenHeight;
			//console.log(scrollTop, seenHeight, allHeight, maxTop);
			// 错误强制修复
			(function() {
				let nowTop = - parseInt(BG.style.top.replace(/px$/g, ''));
				if (nowTop > maxTop || nowTop < - BG.offsetHeight) {
					BG.style.top = '-3px';
				}
			})();
			// 只在横屏时滚动
			if (getSeenRatio() > 1) {
				if (allHeight != seenHeight) {
					let newTop = ((scrollTop / (allHeight - seenHeight)) * 1.6 * maxTop + 3);
					BG.style.top = '-' + (newTop < maxTop ? newTop : maxTop) + 'px';
				} else {
					BG.style.top = - maxTop + 'px';
				}
			} else
				BG.style.top = '-3px';
		}

		function bgResize() {
			var seenHeight = window.innerHeight;
			var seenWidth = window.innerWidth;
			var seenRatio = seenWidth / seenHeight;

			var badHeight = false, badWidth = false;
			if (imgHeight < seenHeight)
				badHeight = true;
			if (imgWidth < seenWidth)
				badWidth = true;

			// 四种情况
			// 宽不够
			if (!badHeight && badWidth) {
				BG.style.height = 'unset';
				BG.style.width = '100vw';
			}
			// 高不够
			if (badHeight && !badWidth) {
				BG.style.height = 'calc(100vh + 3px)';
				BG.style.width = 'unset';
			}
			// 宽高都不够
			if (badHeight && badWidth) {
				// 可视宽高比 <= 图像宽高比, 高度优先
				// 可视宽高比 >  图像宽高比, 宽度优先
				if (seenRatio <= imgRatio){
					BG.style.height = 'calc(100vh + 3px)';
					BG.style.width = 'unset';
				} else {
					BG.style.height = 'unset';
					BG.style.width = '100vw';
				}
			}
			// 宽高都够
			if (!badHeight && !badWidth) {
				BG.style.height = 'unset';
				BG.style.width = 'unset';
			}
			bgScroll();
		}

		window.addEventListener('scroll', bgScroll);
		window.addEventListener('resize', bgResize);

		bgResize();
		setInterval(function() {
			bgResize();
		}, 2000);
		<?php endif; ?>
	</script>
<?php
}


/* ----------------------------------
 * LoadHTMLEnd
 */
function LoadHTMLEnd() {
?>
	</body>
	</html>
<?php
}
