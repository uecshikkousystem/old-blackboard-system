var ng_cnt = 0;

function ListReload() {
	var clear = new Date().getTime();
	var request = new XMLHttpRequest();
	 
	request.open("GET", "selecter.php?time=" + clear, true);
	request.send(null);
	request.onreadystatechange = readyStateChangeHandler;
	 
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			document.getElementById('list').innerHTML = request.responseText;
			document.getElementById('ng').style.display = "none";
			ng_cnt = 0;
		} else {
			if (++ng_cnt >= 5)
				document.getElementById('ng').style.display = "block";
		}
	}
}

function NumReload() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 request.open("GET", "num.php?time=" + clear, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 document.getElementById('num').innerHTML = request.responseText;
		 }
	 }
}

window.onload = function() { ListReload(); }
window.setTimeout('NumReload()', 1);
window.setInterval('ListReload()',3000);
window.setInterval('NumReload()',5000);
