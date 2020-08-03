function LoadHLJS() {
	hljs.initHighlighting();
}

function LoadMathJax() {
	function loadText(texts) {
		for (var i = 0; i < texts.length; ++i) {
			if (texts[i].innerHTML == null)
				continue;
			texts[i].innerHTML = texts[i].innerHTML.replace(/([^\\])\$(.+?)\$/g, '$1\\($2\\)');
			texts[i].innerHTML = texts[i].innerHTML.replace(/\\\$/, '\$');
		}
	}
	loadText(document.getElementsByTagName('p'));
	loadText(document.getElementsByTagName('li'));
	LoadScript("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_SVG");
}

function LoadViz(graphDOM, engine) {
	if (!engine) engine = 3;
	var engines = ["circo", "dot", "fdp", "neato", "osage", "twopi"];
	LoadScript("/js/jquery-3.4.1.min.js", function() {
			LoadScript("/js/viz/viz.js", function() {
					LoadScript("/js/viz/full.render.js", function() {
							var viz = new Viz();
							viz.renderSVGElement(graphDOM.innerText, {
								engine: engines[engine],
								format: "svg",
							}).then(function(element) {
								graphDOM.innerHTML = "";
								graphDOM.appendChild(element);
							}).catch(function(error){
								viz = new Viz();
								console.error(error);
							})
					});
			});
	});
}

