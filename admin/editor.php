<!DOCTYPE html>
<?php
# 2020/2/20
# @Author RickoNoNo3
#
require_once(dirname(__FILE__) . '/../config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ACE in Action</title>

	<style type="text/css" media="screen">
#editor { 
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
	}
	</style>
</head>
<body>

<div id="editor"></div>

<script src="https://pagecdn.io/lib/ace/1.4.8/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
var editor = ace.edit("editor");
editor.setOptions({
	"theme": "ace/theme/monokai",
	"mode": "ace/mode/markdown",
	"keyboardHandler": "ace/keyboard/vim",
	"fontSize": "20px",
});
</script>
</body>
</html>
