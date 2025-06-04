function ListReload() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 request.open("GET", "write_list.php?time=" + clear, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 document.getElementById('list').innerHTML = request.responseText;
		 }
	 }
}

function ListChange(mode, id) {
	var request = new XMLHttpRequest();
	
	if ((mode == "submit_id") || (mode == "delete_id")) {
		var url = "../output/output.php?" + mode + "=" + id;
		request.open("GET", url, true);
	} else {
		var url = "edit_write.php?" + mode + "=" + id;
		request.open("GET", url, true);
	}
	 
	request.send(null);
	request.onreadystatechange = readyStateChangeHandler;
	
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			ListReload();
		}
	}
}

function TitleReload() {
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

window.onload = function() { ListReload(); }
window.setTimeout(TitleReload, 1);
window.setInterval(ListReload, 2000);
window.setInterval(TitleReload, 5000);