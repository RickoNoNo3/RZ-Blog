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

function getQuery(name){
	var reg = new RegExp(".*(^|&)" + name + "=([^&]*)($|&)", "i");
	var res = top.location.search.substr(1).match(reg);
	if(res != null)
		return (res[2]);
	return null;
}
function getNowDir(){
	var dir = decodeURI(getQuery("dir"));
	if(dir == "null")
		dir = "";
	return dir;
}
function listDir(){
	var list = window.document.getElementById("loclink");
	var dirs = getNowDir().split('/');
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
function getHref(filename, isDir){
	if(isDir)
		href = '/blog.php?dir=' + encodeURI(filename);
	else
		href = "/view/" + encodeURI(filename) + '?dir=' + encodeURI(getNowDir());
	return href;
}
function listFile(){
	var list = window.document.getElementById("list");
	var dir = getNowDir();
	xhrDoGet("/list/" + dir, function(res){
		var filelist = eval ("(" + res + ")");
		var cnt = 0;
		window.document.getElementById('loading').style.display = "none";
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
			var href = getHref(getNowDir() + filename, fileisDir);
			// 消除网页文件扩展名(破坏性)
			if(!fileisDir){
				var reg = new RegExp("(.*)[.](md|html|php|htm|aspx|jsp|xhtml|c|cpp|css|js|txt|go)$", "i");
				var march1 = filename.match(reg);
				if(march1 != null)
					filename = march1[1];
			}
			// 渲染html
			list.innerHTML += liclass + '<a class="listrow" href="' + href + '">' + divicon + '<div class="name">' + filename + '</div>' + '<div class="time">' + filetime + '</div></a></li>'
		}
	});
}
function doSearch(stextid){
	if(stextid == null)
		return false;
	var stext = stextid.value;
	if(stext == "")
		return false;
	console.log("search: " + stext);
}
