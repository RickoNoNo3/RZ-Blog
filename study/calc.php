<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes" />
		<title>计算器</title>
		<style>
			* {
				border-radius: 5px;
				color: black;
			}

			#Calculator {
				display: block;
				width: 250px;
				height: max-content;
				padding: 10px;
				margin: 0 auto;
				background-color: #CCC;
				box-shadow: 0 0 5px black;
			}

			#Calculator #Screen {
				position: relative;
				display: block;
				width: 100%;
				height: 80px;
				margin-bottom: 10px;
				background-color: white;
				overflow: hidden;
			}

			#Calculator #Screen #NumInput {
				position: absolute;
				left: 5px;
				top: 5px;
				right: 5px;
				word-break: keep-all;
			}

			#Calculator #Screen #NumOutput {
				position: absolute;
				bottom: 5px;
				right: 5px;
				width: max-content;
				text-align: right;
				font-size: 25px;
				word-break: keep-all;
			}

			#Calculator table {
				width: 100%;
			}

			#Calculator .Button {
				height: 35px;
			}

			#Calculator .Button td {
				width: 25%;
				position: relative;
			}

			#Calculator .Button button {
				top: 0;
				left: 0;
				display: inline;
				width: 100%;
				height: 100%;
				border: 2px ridge black;
				background-color: white;
				position: absolute;
			}
		</style>
	</head>
	<body>
		<div id="Calculator">
			<div id="Screen">
				<div id="NumInput"></div>
				<div id="NumOutput"></div>
			</div>
			<table>
				<tbody>
					<tr class="Button">
						<td><button id="Plus">+</button></td>
						<td><button id="Sub">-</button></td>
						<td><button id="Mult">*</button></td>
						<td><button id="Div">/</button></td>
					</tr>
					<tr class="Button">
						<td><button id="Num7">7</button></td>
						<td><button id="Num8">8</button></td>
						<td><button id="Num9">9</button></td>
						<td rowspan="4"><button id="Equal">=</button></td>
					</tr>
					<tr class="Button">
						<td><button id="Num4">4</button></td>
						<td><button id="Num5">5</button></td>
						<td><button id="Num6">6</button></td>
					</tr>
					<tr class="Button">
						<td><button id="Num1">1</button></td>
						<td><button id="Num2">2</button></td>
						<td><button id="Num3">3</button></td>
					</tr>
					<tr class="Button">
						<td colspan="2"><button id="Num0">0</button></td>
						<td><button id="NumDot">.</button></td>
					</tr>
				</tbody>
			</table>
		</div>
		<script>
			var calced;
			var order = {
				'+': 1,
				'-': 1,
				'*': 2,
				'/': 2,
				'.': 9999,
			};
			var inputDOM = document.getElementById('NumInput');
			var outputDOM = document.getElementById('NumOutput');

			window.onload = function() {
				var btns = document.getElementsByTagName('button');
				for (let i = 0; i < btns.length; ++i) {
					if (btns[i].getAttribute('id') === 'Equal') {
						btns[i].onclick = function() {
							makeResult();
						};
					} else {
						btns[i].onclick = function() {
							doInput(btns[i].innerText);
						};
					}
				}
			}

			function doInput(text) {
				if (calced) {
					inputDOM.innerText = '';
					calced = false;
				}
				var inputs = inputDOM.innerText;
				if (inputs.length > 20)
					return;
				if (!isNum(text) && inputs.length) {
					if (!isNum(inputs[inputs.length - 1])) {
						inputDOM.innerText = inputs.substring(0, inputs.length - 1);
					}
				}
				inputDOM.innerText += text;
			}

			function makeResult() {
				var inputs = inputDOM.innerText;
				var stack1 = [];
				var stack2 = [];
				var inNum = false;
				if (!isNum(inputs[0]))
					inputs = '0' + inputs;

				for (let i = 0; i < inputs.length; ++i) {
					if (isNum(inputs[i])) {
						if (inNum) {
							stack1[stack1.length - 1] += inputs[i];
						} else {
							stack1.push(inputs[i]);
							inNum = true;
						}
					} else {
						inNum = false;
						while (stack2.length && order[inputs[i]] <= order[stack2[stack2.length - 1]]) {
							if (doCalc() === false) {
								return;
							}
						}
						stack2.push(inputs[i]);
					}
					console.log(stack1, stack2);
				}
				if (!stack1.length) {
					show('ERROR');
					return;
				}
				while (stack1.length > 1)
					doCalc();
				show(parseFloat(parseFloat(stack1.pop()).toFixed(10))); // 保留10位小数
				calced = true;

				function doCalc() {
					if (stack1.length < 2 || stack2.length < 1) {
						show('ERROR');
						return false;
					}
					var b = stack1.pop(); // b 后入所以先出
					var a = stack1.pop();
					var res;
					switch (stack2.pop()) {
						case '+':
							res = parseFloat(a) + parseFloat(b);
							break;
						case '-':
							res = parseFloat(a) - parseFloat(b);
							break;
						case '*':
							res = parseFloat(a) * parseFloat(b);
							break;
						case '/':
							res = parseFloat(a) / parseFloat(b);
							break;
						case '.':
							res = parseFloat(a + '.' + b);
							break;
					}
					stack1.push(res.toString());
					console.log(stack1, stack2);
					return res;
				}

				function show(text) {
					outputDOM.innerText = text;
				}
			}

			function isNum(ch) {
				return ch <= '9' && ch >= '0';
			}
		</script>
	</body>
</html>

