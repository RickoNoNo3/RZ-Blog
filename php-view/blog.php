<?php
require_once(dirname(__FILE__) . '/html/globalView.php');
BasicHEADBegin(PageTitle('文章列表'));
?>
<style>
#list{
	border-top: 1px solid #003530;
	list-style: none!important;
	padding: 0;
}
#list a{
	text-decoration: none;
}
#list img{
	width: 17px;
	filter: drop-shadow(0 0 1px white);
}
#list li{
	transition: background-color ease-in 0.2s;
	font-size: 20px;
	width: 100%;
	padding: 0;
	border: 1px solid #003530;
	border-top: 0;
	display: table;
}
#list li:hover{
	background-color: rgba(0,0,0,0.5);
	transition: background-color ease-in 0.1s;
}
#list .listrow{
	clear: both;
	display: block;
	color: black;
	display: table-row;
	height: 30px;
	line-height: 30px;
	width: 100;
}
#list .lodd{
	background-color: rgba(80, 130, 80, 0.15);
}
#list .leven{
	background-color: rgba(50, 220, 150, 0.15);
}
#list .icon{
	width: 40px;
	text-align: right;
	display: table-cell;
}
#list .name{
	width: calc(100% - 40px - 150px);
	text-align: left;
	display: table-cell;
}
#list .time{
	/* border-left: 1px solid #003530; */
	padding-right: 2%;
	width: 150px;
	text-align: right;
	display: table-cell;
}
#loading{
	text-align: center;
	font-size: 20px;
	line-height: 50px;
}
</style>
<?php BasicHEADEnd(); ?>
<body id="body">
	<?php LoadHeader(); ?>
	<div class="mybox reverse">
		<div id="loclink" style="">当前位置：</div>
	</div>
	<div class="mybox">
	<div class="mycontent" id="content">
		<div class="mytitle" id="title">文章列表</div>
		<div class="line"></div>
		<ul id="list"></ul>
		<div id="loading">加载中...</div>
	</div>
	</div>
	<?php LoadFooter(); ?>
</body>
<script>
listDir();
listFile();
</script>
</html>
