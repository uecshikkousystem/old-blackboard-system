function buttonChangeMode(mode) {
	if (mode === 'a') {
		document.getElementById('list-wrapper').style.display = 'block';
		listReload();
	} else {
		document.getElementById('list-wrapper').style.display = 'none';
	}
}

function listReload() {
	var clear = new Date().getTime();
	var request = new XMLHttpRequest();
	 
	if (document.getElementById('list-wrapper').style.display !== 'none') {
		request.open("GET", "write_list.php?time=" + clear, true);
		request.send(null);
		request.onreadystatechange = readyStateChangeHandler;	 
	}
	 
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			document.getElementById('list').innerHTML = request.responseText;
		}
	}
}

function titleReload() {
	var clear = new Date().getTime();
	var request = new XMLHttpRequest();
	
	request.open("GET", "../../parts/title.php?time=" + clear, true);
	request.send(null);
	request.onreadystatechange = readyStateChangeHandler;
	 
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			document.getElementById('space-title').innerHTML = request.responseText;
		}
	}
}

window.onload = function() { listReload(); }
window.setTimeout(titleReload, 1);
window.setInterval(listReload, 2000);
window.setInterval(titleReload, 5000);