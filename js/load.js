var LoadedModules = [];

function LoadScript(src, callback) {
	setTimeout(function(){
	if (!callback)
		callback = function() {};
	if (LoadedModules.indexOf(src) == -1) {
		var script = document.createElement('script'),
			head = document.getElementsByTagName('head')[0];
		script.type = 'text/javascript';
		script.charset = 'UTF-8';
		script.src = src;
		if (script.addEventListener) {
			script.addEventListener('load', function() {
					callback();
					LoadedModules.push(src);
					}, false);
		} else if (script.attachEvent) {
			script.attachEvent('onreadystatechange', function() {
					var target = window.event.srcElement;
					if (target.readyState == 'loaded') {
						callback();
						LoadedModules.push(src);
					}
				});
		}
		head.appendChild(script);
	} else {
		callback();
	}
	}, 100);
}

function LoadArtPage() {
	LoadScript('/js/modules.js', function() {
		var graphs = document.querySelectorAll('graph');
		for (var i = 0; i < graphs.length; ++i) {
			if (!graphs[i].hasAttribute('drawn')) {
				LoadViz(graphs[i], parseInt(graphs[i].getAttribute('engine')));
				graphs[i].setAttribute('drawn', '1');
			}
		}
		LoadHLJS();
		setTimeout(function() {
			LoadMathJax();
		}, 1000);
	});
}
