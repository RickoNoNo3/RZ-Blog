<!--404-->
<?php
require_once(dirname(__FILE__) . '/html/globalView.php');
require_once(dirname(__FILE__) . '/lib/md.php');
LoadHTMLBegin(PageTitle());
?>
<style>
body{
	text-align: center;
}
#icon1{
	width: 120px;
	height: 120px;
	margin: 0 auto;
}
#title{
	color: rgb(255,255,230);
	margin: 0 auto 10px auto;
	font-size: 30px;
	height: 40px;
	text-align: center;
	filter: drop-shadow(0 0 5px black);
	flex: 1;
}
#goHome{
	color: yellow;
	font-size: 20px;
}
</style>
<?php LoadHTMLBodyBegin('?'); ?>
	<img id="icon1" src="/img/navicon.png"></img>
	<div id="title">
		页面走丢了哦<br />
		<a id="goHome" href="/" target="_top">返回主页</a>
	</div>
<?php
LoadHTMLBodyEnd();
LoadHTMLScript();
LoadHTMLEnd();
