<?php
require_once(dirname(__FILE__) . '/html/globalView.php');
require_once(dirname(__FILE__) . '/lib/md.php');
LoadHTMLBegin(PageTitle());
?>

<style>
.welcometitle{
	color: rgb(255,255,230);
	margin: 0 auto 20px;
	font-size: 30px;
	height: 40px;
	text-align: center;
	filter: drop-shadow(0 0 5px black) drop-shadow(0 0 8px grey);
}
.welcomebox1{
	width: 50%;
	margin: 20px 0 20px 10%;
	float: left;
}
.welcomebox2{
	position: fixed;
	width: 25%;
	margin: 20px 10% 20px 5%;
	right: 0;
	top: 60;
}
.welcomebox3{
	width: 5%;
	margin: 20px 10% 20px 5%;
	float: right;
	text-align: center;
}
.coverl{
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background-color: rgba(0,0,0,0.5);
	z-index: 100;
}
.tanchuang{
	position: fixed;
	text-align: center;
	left: calc(50% - 100px);
	top: calc(50% - 50px);
	width: 200px;
	height: 100px;
	background-color: white;
	z-index: 101;
}
</style>

<?php LoadHTMLBodyBegin('<a href="/">主页</a>'); ?>

	<div class="welcometitle">欢迎来到R崽的博客</div>
	<div class="mybox <?php if (!$ISMOBILE) echo 'welcomebox1'; ?>">
		<div class="mycontent">
			<div class="mytitle">建博客的一些心得</div>
			<div class="line"></div>
			<?php
			MdParser('../建博客的一些心得.md');
			?>
		</div>
	</div>
<!--	<div class="mybox welcomebox2">
		<p><input style="float: right; width: 60%;" type="text" id="stext"></input></p><br />
		<p><button style="float: right; width: 80%;" type="button" id="sbutton" value="搜索内容" onclick="doSearch(document.getElementById('stext'));">搜索内容</button></p>
	</div>-->
<!--	<div class="mybox welcomebox3"><br>
	</div>-->

<?php
LoadHTMLBodyEnd();
LoadHTMLScript();
LoadHTMLEnd();
