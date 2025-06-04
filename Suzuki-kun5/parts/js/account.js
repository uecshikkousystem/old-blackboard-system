function FormCheck() {
	var errflg = 0;
	var obj = document.form.student_id.value;
	
	if (obj.match(/^\s*([　]*\s*)*[　]*$/)) {
		errflg = 1;
	} else if (!obj.match(/^\d{7}$/)) {
		errflg = 1;
	}
	
	if (errflg == 1) {
		document.form.submit.disabled = true;
	} else {
		document.form.submit.disabled = false;
	}
	
	return errflg;
}

function KojinFormCheck() {
	var errflg = 0;
	var obj = document.kojinform.k_id.value;
	
	if (obj.match(/^\s*([　]*\s*)*[　]*$/)) {
		errflg = 1;
	} else if (!obj.match(/^\d{7,}$/)) {
		errflg = 1;
	}
	
	if (errflg != 1)
		KojinLoad();
	else {
		document.getElementById('kojin').innerHTML = "";
		document.getElementById('error').innerHTML = "";
	}
}

function Enter(e) {
	if (!e) {
		var e = window.event;
	}
 
    if (e.keyCode == 13) {
		if (FormCheck() == 0) {
			return true;
		} else {
			return false;
		}
	}
}

function KojinEnter(e) {
	if (!e) {
		var e = window.event;
	}
 
    if (e.keyCode == 13) {
		return false;
	}
}

function KojinLoad() {
	 var request = new XMLHttpRequest();
	 var p_id = document.getElementById('p_id').innerHTML;
	 var k_id = document.kojinform.k_id.value;
	 var url = "kojin.php?k_id=" + k_id + "&p_id=" + p_id;
	 
	 request.open("GET", url, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 var res = request.responseText;
			 if (res.match(/^.+error-txt.+/)) {
				 document.getElementById('error').innerHTML = res;
				 document.getElementById('kojin').innerHTML = "";
			 } else {
				 document.getElementById('kojin').innerHTML = res;
				 document.getElementById('error').innerHTML = "";
			 }
		 }
	 }
}

function Cancel() {
	if (window.confirm('本当に取り消ししてよろしいですか？')) {
		return true;
	} else {
		return false;
	}
}

function Back(e) {
	if (!e) {
		var e = window.event;
	}
	
	if (e.charCode == 98) {
		window.location.href = "./";
		return false;
	}
}

function Cursor() {
	if (document.form) {
		document.form.student_id.focus();
	}
	
	if (document.kojinform) {
		document.kojinform.k_id.focus();
	}
}

function Check() {
	window.setInterval(FormCheck, 300);
}

function KojinCheck() {
	window.setInterval(KojinFormCheck, 500);
}