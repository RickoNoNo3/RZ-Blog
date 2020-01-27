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
}
#list li{
	font-size: 20px;
	width: 100%;
	padding: 0;
	border: 1px solid #003530;
	border-top: 0;
	border-left: 0;
	display: table;
}
#list li:hover{
	background-color: rgba(10, 80, 120, 0.3);
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
	/* float: left; */
}
#list .name{
	width: calc(80% - 40px);
	text-align: left;
	display: table-cell;
	/* float: left; */
}
#list .time{
	/* border-left: 1px solid #003530; */
	padding-right: 2%;
	width: 18%;
	text-align: right;
	/* float: right; */
	display: table-cell;
}
</style>
<?php BasicHEADEnd(); ?>
<body id="body">
	<?php LoadHeader(); ?>
	<div class="mybox">
		<div class="mycontent">
			<pre id="loclink" style="margin-top: 0; text-align: center;">当前位置：</pre>
		</div>
	</div>
	<div class="mybox">
	<div class="mycontent" id="content">
		<div class="mytitle" id="title">文章列表</div>
		<ul id="list"></ul>
	</div>
	</div>
	<?php LoadFooter(); ?>
</body>
<script>
listDir();
listFile();
</script>
</html>
