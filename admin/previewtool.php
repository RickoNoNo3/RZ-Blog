<?php
# PERVIEW
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>Blog Preview Tool</title>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<style>
*{
	margin: 0;
	padding: 0;
	border: 0;
	color: white;
}
.frm{
	width: calc(50% - 1px - 10px);
	height: calc(100% - 10px);
	display: block;
	position: fixed;
	padding: 5px;
}
.sprt{
	width: 2px;
	height: 100%;
	display: block;
	position: fixed;
	background-color: grey;
	left: calc(50% - 1px);
}
.fill{
	height: 100%;
}
.fill, .fill *{
	width: 100%;
	display: block;
	background-color: black;
	margin: 0;
	padding: 0;
	overflow: auto;
}
#title{
	height: 30px;
	border-bottom: 1px solid grey;
	line-height: 30px;
	font-size: 30px;
}
#content{
	height: calc(100% - 31px - 10px);
	width: calc(100% - 10px);
	resize: none;
	padding: 5px;
}
#submit{
	bottom: 20px;
	right: 30px;
	width: 100px;
	height: 40px;
	line-height: 40px;
	font-size: 20px;
	margin: 5px;
	box-shadow: 2px 0 0 grey;
	color: black;
	border-radius: 5px;
	text-align: center;
	background-color: #AAAAAA;
	display: block;
	position: fixed;
	text-decoration: none;
}
#submit:hover{
	background-color: #FFFFFF;
}
#submit:active{
	background-color: #888888;
}
</style>
</head>
<body>
	<div class="frm" style="left: 0;">
		<div class="fill">
			<input type="text" id="title" placeholder="Title">
			<textarea id="content" placeholder="Content"></textarea>
		</div>
	</div>
	<div class="sprt"></div>
	<div class="frm" style="right: 0;">
		<iframe class="mycontent fill" id="output">
		</iframe>
	</div>
	<a id="submit" href="javascript:void(0);">Submit</a>
</body>
<script>
	var inputtitle = document.getElementById('title');
	var inputcontent = document.getElementById('content');
	var output = document.getElementById('output');
	function refresh() {
		$.ajax({
			url:"previewtool_article.php",
			type: "POST",
			data: inputcontent.value,
			success: function(res){
				output.src = 'previewtool_article.php';
			}
		});
	}
	refresh();
	inputcontent.addEventListener('input', refresh);
	setInterval(refresh, 60000);
	document.body.style.display = 'block';
</script>
</html>

