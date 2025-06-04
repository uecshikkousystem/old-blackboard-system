function FormCheck() {
	var errflg = 0;
	var flg = 0;
	var num = document.chatform.addr.length;
	
	for (var i=0; i<num; i++) {
		if (document.chatform.addr[i].checked) {
			flg = 1;
		}
	}
	
	if (flg != 1) {
		errflg = 1;
	}
	
	var obj = document.chatform.comment.value;
	if (obj.match(/^\s*([　]*\s*)*[　]*$/)) {
		errflg = 1;
	}
	
	if (errflg == 1) {
		document.chatform.submit.disabled = true;
	} else {
		document.chatform.submit.disabled = false;
	}
}

function ChatCheck() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 request.open("GET", "read_admin.php?mode=listcheck&time=" + clear, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 document.getElementById('new').innerHTML = request.responseText;
			 var num = request.responseText;
			 num = num.replace(/^.+\D(\d+)\D.+$/,"$1");
			 
			 if (num) {
				 document.title = '(' + num + ') 鈴木ったー';
			 }
		 }
	 }
}
	 
function Chatload() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 request.open("GET", "read_admin.php?mode=listget&time=" + clear, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 document.getElementById('main-chat').innerHTML = request.responseText;
			 document.title = '鈴木ったー';
			 ChatCheck();
		 }
	 }
}

function ChatConti() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 var url = "read_admin.php?mode=listconti&time=" + clear
	 
	 request.open("GET", url, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 if (!document.getElementById('new').innerHTML) {
				document.getElementById('main-chat').innerHTML = request.responseText;
			 	ChatCheck();
			 }
		 }
	 }
}

function ListDelete(id) {
	var request = new XMLHttpRequest();
	
	var url = "write.php?mode=delete&id=" + id;
	request.open("GET", url, true);
	 
	request.send(null);
	request.onreadystatechange = readyStateChangeHandler;
	
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			Chatload();
		}
	}
}

function getWindowHeight(){
  if (window.innerHeight) return window.innerHeight;
  
  if (document.documentElement && document.documentElement.clientHeight) {
	  return document.documentElement.clientHeight;
  } else if (document.body && document.body.clientHeight) {
	  return document.body.clientHeight;
  }
  
  return 0;
}

function ContiGet() {
	var scrollTop  = document.body.scrollTop || document.documentElement.scrollTop;
	var clientHeight = getWindowHeight();
	var scrollHeight = document.body.scrollHeight;
	var remain = scrollHeight - clientHeight - scrollTop;
	
	if (clientHeight < scrollHeight) {
		if (remain < 60) {
			ChatConti();
		}
	}
}

window.onload = function(){ Chatload(); }
window.setInterval(ContiGet, 300);
window.setInterval(FormCheck, 500);
window.setInterval(ChatCheck, 5000);