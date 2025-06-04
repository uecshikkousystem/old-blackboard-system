function TitleReload() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 request.open("GET", "../../parts/title.php?time=" + clear, true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler(){
		 if((request.readyState == 4) && (request.status == 200)) {
			 document.getElementById('space-title').innerHTML  = request.responseText;
		 }
	 }
}

window.onload = function() { TitleReload(); }
window.setInterval(TitleReload, 5000);