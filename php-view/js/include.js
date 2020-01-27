var index = "";
var blog = "blog.php";
var about = "about.php";
var essayDir = "";
var blogfix = "Blog_";
var blogName = "R崽的博客";
var fordericon = 'forder.png';
var fileicon = 'file.png';

function checkIE(){
	if(window.navigator.userAgent.indexOf("MSIE") >= 1 || !!window.ActiveXObject || "ActiveXObject" in window/* || window.navigator.userAgent.indexOf("Edge") > -1*/){
		alert("请勿使用IE浏览器访问！");
		var body1 = document.getElementById("body");
		var iframe1 = document.getElementById("frame");
		body1.removeChild(iframe1);
		body1.removeChild(document.getElementById('html'))
		return false;
	}
	return true;
}
function xhrDoGet(filename, func1){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			var res = xhr.responseText;
			if(res.substr(0, 10) === "<!--404-->"){
				alert("错误：无法连接后端服务器！");
				return false;
			}
			func1(res);
		}
	}
	xhr.onerror = function(){
		alert("错误：无法连接后端服务器！");
	}
	let loc = '';
	if (filename.substr(0, 4) == 'http')
		loc = filename;
	else
		loc = getNowHref() + filename;
	xhr.open("get", loc, true);
	xhr.send();
}

function getCode(filename, codeid){
	xhrDoGet(filename, function(res){
		document.getElementById(codeid).textContent = res;
		//hljs.initHighlighting();
		hljs.highlightBlock(document.getElementById(codeid));
	});
}

function getFile(filename, DOMid){
	xhrDoGet(filename, function(res){
		document.getElementById(DOMid).innerText= res;
		hljs.highlightBlock(document.getElementById(DOMid));
	});
}
function getQuery(name){
	var reg = new RegExp(".*(^|&)" + name + "=([^&]*)($|&)", "i");
	var res = top.location.search.substr(1).match(reg);
	if(res != null)
		return (res[2]);
	return null;
}
function checkEssay(){
	return (decodeURI(getQuery("loc")).substr(0, blogfix.length) == blogfix);
}
function drawFrame(frameid){
	var loc = decodeURI(getQuery("loc"));
	var frame1 = top.document.getElementById(frameid);
	if(loc == "null")
		loc = index;
	if(checkEssay()){
		loc = essayDir + loc.substr(5);
		//console.log(loc);
		var reg = new RegExp(".*(html|php|htm|aspx|jsp|xhtml|do)$", "i");
		if(loc.match(reg) == null){
			frame1.style.padding = '0 10%';
			frame1.style.width = '80%';
		}
	}
	frame1.src = loc;
	if(loc == index){
		top.document.title = blogName;
		return true;
	} else {
		var reg = new RegExp(".*/(.*)[.][^./]*$", "i");
		var title = loc.match(reg)[1];
		top.document.title = title + " - " + blogName;
	}
}
function getNowDir(){
	var dir = decodeURI(getQuery("dir"));
	if(dir == "null")
		dir = "";
	//return top.location.pathname.substring(5)
	return dir;
}
function listDir(){
	var list = window.document.getElementById("loclink");
	var dirs = getNowDir().split('/');
	console.log(dirs);
	var nowdir = "";
	list.innerHTML += '<a class="loclink" target="_top" href="/' + encodeURI(blog) + '">博客</a>';
	for(var i = 0, len = dirs.length; i < len; i++){
		if(i <= len - 1)
			list.innerHTML += " &gt; ";
		nowdir += dirs[i] + "/";
		list.innerHTML += '<a class="loclink" target="_top" href="/' + encodeURI(blog) + '?dir=' + encodeURI(nowdir) + '">' + dirs[i] + '</a>';
	}
}
function getNowHref(){
	return top.location.protocol + "//" + top.location.hostname + ":" + top.location.port;
}
function gotoFile(filename, isDir){
	if(isDir){
		//console.log('I will open ' + filename);
		top.location.href = '/blog.php?dir=' + encodeURI(filename);
	} else {
		//console.log('I will goto ' + filename);
		// window.open("http://localhost:8888/view/" + encodeURI(filename));
		window.open("/view/" + encodeURI(filename));
	}
}
function listFile(){
	var list = window.document.getElementById("list");
	var dir = getNowDir();
	xhrDoGet("/list/" + dir, function(res){
		var filelist = eval ("(" + res + ")");
		//console.log(filelist);
		var cnt = 0;
		for(var k in filelist){
			// 初始化新file
			cnt++;
			var filename = filelist[k].name.replace(/(^\s*)|(\s*$)/g, "");
			var filetime = filelist[k].time.replace(/(^\s*)|(\s*$)/g, "");
			var fileisDir = filelist[k].isDir;
			if (fileisDir)
				filename = filename + "/"
			// 构造元素
			var liclass = '<li ' + (cnt % 2 ? 'class="lodd"' : 'class="leven"') + '>';
			var divicon = '<div class="icon"><img src="/img/' + (fileisDir ? fordericon : fileicon) + '" /></div>';
			var aonclick = "gotoFile('" + getNowDir() + filename + "', " + fileisDir + ");";
			// 消除网页文件扩展名(破坏性)
			if(!fileisDir){
				var reg = new RegExp("(.*)[.](md|html|php|htm|aspx|jsp|xhtml)$", "i");
				var march1 = filename.match(reg);
				if(march1 != null)
					filename = march1[1];
			}
			// 渲染html
			var innerHTML1;
			innerHTML1 = liclass + '<a class="listrow" href="javascript:void(0);" onclick="' + aonclick + '">' + divicon + '<div class="name">' + filename + '</div>' + '<div class="time">' + filetime + '</div></a></li>'
			list.innerHTML += innerHTML1;
		}
	});
}
function aclose(){
	document.getElementById("mycover").innerHTML = '';
}
function doSearch(stextid){
	document.getElementById("mycover").innerHTML = '<table class="coverl" onclick="aclose()"></table><div class="tanchuang">这是一个弹窗<br><button style="margin: 0 20px; width: 60%;" type="button" id="sbutton" value="结束" onclick="aclose();">结束</button></div>';
	if(stextid == null)
		return false;
	var stext = stextid.value;
	if(stext == "")
		return false;
	console.log("search: " + stext);
}
