//-------------------
//  Login
//-------------------
function login() {
	document.getElementById('loginWindow').style.display = 'block';
}

function unlogin() {
	document.getElementById('loginWindow').style.display = 'none';
}

function dologin() {
	location.href = '/login.php?pswd=' + document.getElementById('loginPSWD').value + '&href=' + location.href;
}
