<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# The Global fixed html header and footer
# 
# Usage:
#   PageTitle($title = '', $addSuffix = true)
#     |$pagetitle|
#   LoadHTMLBegin($pagetitle);
#     your head code...
#   LoadHTMLBodyBegin($locstr);
#     your body code...
#   LoadHTMLBodyEnd();
#   LoadHTMLScript();
#     your script code...
#   LoadHTMLEnd();

require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../lib/compress.php');

/* ------------------------------
 * PageTitle return s a title text
 * @param title => the title name of the page
 * @param addSuffix=true => whether to add $BLOGTITLE as suffix */
function PageTitle(string $title = '', bool $addSuffix = true)
{
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
function LoadHTMLBegin($pagetitle)
{
	if (extension_loaded('zlib')) {
		ob_end_clean();
		ob_start('ob_gzhandler');
	} else {
		ob_end_clean();
		ob_start();
	}
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=0.5,maximum-scale=3.0, user-scalable=yes">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="renderer" content="webkit">
		<meta name="author" content="RickoNoNo3,RickoNoNo3@163.com">
		<meta name="copyright" content="RickoNoNo3">
		<meta name="google-site-verification" content="H8OLMgsMa9HVIHDya6fmpU3aeLh0NH56MTuqc1qKvpM">
		<title><?php echo $pagetitle; ?></title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $GLOBALS['MYSTYLE']; ?>">
		<?php if ($GLOBALS['ISMOBILE']) : ?>
			<link rel="stylesheet" href="<?php echo $GLOBALS['MYSTYLE_MOBILE']; ?>">
		<?php endif; ?>
	<?php
}

/* ------------------------------
 * LoadHTMLBodyBegin
 */
function LoadHTMLBodyBegin($locStr)
{
	?>
	</head>

	<body ismobile="<?php echo $GLOBALS['ISMOBILE'] ? 'true' : 'false' ?>">
		<div class="mynav" style="display: none;">
			<div class="mynavline">
				<ul class="mymenubar">
					<li class="mymenuli"><a href="/">主页</a></li>
					<li class="mymenuli"><a href="/blog/">博客</a></li>
					<li class="mymenuli"><a href="/about/">关于</a></li>
					<?php if (0 && CheckAdmin(@$_COOKIE['userHash'])) : ?>
						<li class="mymenuli"><a href="/admin/">管理</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="mynavicon">
				<a href="https://www.cnblogs.com/rickonono3" style="opacity: 0;"></a>
			</div>
		</div>
		<script>
			var menus = document.querySelectorAll('.mymenuli:not(.disabled)');
			var menuCnt = menus.length;
			document.querySelector('.mynav').style.display = 'block';
		</script>
		<div class="myloc" style="opacity: 0;">
			<div class="mylocbar <?php echo ($GLOBALS['ISMICROSOFT'] ? 'edge' : 'normal'); ?>" id="locbar">
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
function LoadHTMLBodyEnd()
{

	?>
		<div id="userlogin" onclick="login();"></div>
		<div id="loginWindow">
			<div style="float:left;top:0;left:0;width:100%;height:100%;" onclick="unlogin();"></div>
			<div id="loginWindowContent" class="mybox" data-role="draggable" data-drag-element="p">
				<p>吃葡萄皮</p>
				<input type="password" id="loginPSWD">
				<div class="BtnList">
					<button value="Cancel" onclick="unlogin();">Cancel</button>
					<button value="OK" onclick="dologin();">OK</button>
				</div>
			</div>
		</div>
		<img id="BG"/>
		<div id="BODYBLANK"></div>
		<footer>
			<div>
				<a href="/">R崽的博客</a>
				| Copyright © 2019 - 2020 R崽哗啦啦
			</div>
		</footer>
	<?php
}

/* ----------------------------------
 * LoadHTMLScript
 */
function LoadHTMLScript()
{
	?>
		<script>
			var IsInClient = false;
			function InClient() {
				var myboxContent = document.querySelector('.mybox').innerHTML;
				document.body.innerHTML = 
					'<div class="mybox inclient">' + 
					myboxContent +
					'</div>';
				IsInClient = true;
			}
			window.onload = <?php if ($GLOBALS['ISIE']) echo 'new '; ?> function() {
				if (!IsInClient) {
					var BG = document.getElementById('BG');
					BG.src = "/img/bg.jpg";
				}
			}
		</script>
		<?php if ($GLOBALS['ISIE']) : ?>
		<script src="/js/conIE.js"></script>
		<?php endif; ?>
		<script src="/js/conBg.js"></script>
		<script src="/js/conNavLoc.js"></script>
		<script src="/js/conLogin.js"></script>
	<?php
}


/* ----------------------------------
 * LoadHTMLEnd
 */
function LoadHTMLEnd()
{
	?>
	</body>

	</html>
<?php
	/*当前页面代码底部*/
	//获取脚本执行完后在缓存中的代码
	$content = ob_get_contents();
	//进行去格式压缩代码
	$content = CompressHtml($content);
	//清空关闭缓存，不直接输出到浏览器
	ob_end_clean();
	//输出到浏览器
	echo $content;
}
