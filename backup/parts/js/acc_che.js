function addCheck() {
	var clear = new Date().getTime();
	var request = new XMLHttpRequest();

	request.open("GET", "check.php" , true);
	request.send(null);
	request.onreadystatechange = readyStateChangeHandler;
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			document.getElementById('new').innerHTML = request.responseText;
			alert("ok"); 
			setTimeout("autoLink()",1);

		}
	}
}

function accok() {

	window.open('example.html', 'mywindow2', 'width=400, height=300, menubar=no, toolbar=no, scrollbars=yes');
}

function autoLink()
{
location.href="./audience.php";
}

function accReload()
{
var script_node = document.createElement('script');
script_node.src = "../parts/js/accreload.js";
document.body.appendChild(script_node);

document.body.appendChild(script_node); 

}
 

window.setInterval(addCheck, 2000);
