<!DOCTYPE html>
<?php
# 2020/2/20
# @Author RickoNoNo3
#
require_once(dirname(__FILE__) . '/../config.php');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<title>ACE in Action</title>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://pagecdn.io/lib/ace/1.4.8/ace.js" type="text/javascript" charset="utf-8"></script>
	<style type="text/css" media="screen">
	body {
		margin: 0;
		display: flex;
		height: 100vh;
		width: 100vw;
	}
	line {
		flex: none;
		width: 1px;
		background: #333333;
	}
	#output, #editor {
		flex: 1;
	}
	#output {
		border: 0;
		background: rgba(18, 20, 10, 1);
	}
	#editor {
		font-family: 'Sarasa Fixed SC', '微软雅黑', '宋体', 'Courier New';
	}
	</style>
</head>
<body>
	<div id="editor"></div>
	<line></line>
	<iframe id="output" src="previewtool.php"></iframe>
	<script>
		var editor = ace.edit("editor");
		var input = document.getElementsByClassName('ace_text-input')[0];
		var output = document.getElementById('output');
		var t = -1; // for refresh
		editor.setOptions({
			"theme": "ace/theme/monokai",
			"mode": "ace/mode/markdown",
			"keyboardHandler": "ace/keyboard/vim",
			"fontSize": "20px",
			"useSoftTabs": false,
			"wrap": "free",
			"useTextareaForIME": true,
			"showPrintMargin": false,
		});
		function refresh() {
			if (t-- == 0) {
				$.ajax({
					url:"previewtool.php",
					type: "POST",
					data: editor.getValue(),
					success: function(res){
						console.log(res);
						output.contentWindow.location.reload();
					}
				});
			}
			t = t > -600 ? t : 0;
		}
		editor.on('change', function(delta) {t = 1;});
		setInterval(refresh, 1000)
		input.focus();
	</script>
</body>
</html>
