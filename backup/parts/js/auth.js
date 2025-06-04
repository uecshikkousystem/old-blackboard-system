function PassCheck(pass,pass2) {
	
	if (!pass2) {
		document.getElementById('passwderr').innerHTML = "";
		return 1;
	} else {
		if (pass != pass2) {
			document.getElementById('passwderr').innerHTML = "パスワードが一致しません。";
			return 1;
		} else {
			document.getElementById('passwderr').innerHTML = "";
			return 0;
		}
	}
}	

function UserCheck(user) {
	 var request = new XMLHttpRequest();
	 
	 request.open("POST", "user_check.php", true);
	 request.setRequestHeader("content-type","application/x-www-form-urlencoded;charset=UTF-8");
	 request.send("user=" + encodeURI(user));
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 var res = request.responseText;
			 if (res) {
				 document.getElementById('usererr').innerHTML = res;
			 } else {
				 document.getElementById('usererr').innerHTML = "";
			 }
		 }
	 }
}


function FormCheck() {
	var user = document.useraddform.user.value;
	var pass = document.useraddform.passwd.value;
	var pass2 = document.useraddform.passwd2.value;
	var lname = document.useraddform.lname.value;
	var fname = document.useraddform.fname.value;
	
	var errflg = 0;
	
	if (user) {
		if (!user.match(/^[0-9a-zA-Z_\-]+$/)) {
			document.getElementById('usererr').innerHTML = "使用できない文字が含まれています。"
			errflg = 1;
		} else {
			UserCheck(user);
			if (document.getElementById('usererr').innerHTML) {
				errflg = 1;
			}
		}
	} else {
		document.getElementById('usererr').innerHTML = "";
	}
	
	if (pass && pass2) {
		if (!pass.match(/^.{6,}$/)) {
			document.getElementById('passwderr').innerHTML = "文字数が足りません。";
			errflg = 1;
		} else {
			if (!pass.match(/^[0-9a-zA-Z]{6,}$/)) {
				document.getElementById('passwderr').innerHTML = "使用できない文字が含まれています。";
				errflg = 1;
			} else {
				if (PassCheck(pass,pass2) == 1) {
					errflg = 1;
				}
			}
		}
	} else {
		document.getElementById('passwderr').innerHTML = "";
	}
	
	var ary = new Array(user,pass,pass2,lname,fname);
	for (var i=0; i<ary.length; i++) {
		if (!ary[i]) {
			errflg = 1;
		}
	}
	
	if (errflg == 1) {
		document.useraddform.submit.disabled = true;
	} else {
		document.useraddform.submit.disabled = false;
	}
	
}

function FormCheckStart() {
	window.setInterval(FormCheck, 500);
}