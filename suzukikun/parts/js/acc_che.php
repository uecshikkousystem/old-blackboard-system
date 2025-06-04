<script>
function addCheck() {
	 var clear = new Date().getTime();
	 var request = new XMLHttpRequest();
	 
	 request.open("GET", "check.php" , true);
	 request.send(null);
	 request.onreadystatechange = readyStateChangeHandler;
	 
	 function readyStateChangeHandler() {
		 if ((request.readyState == 4) && (request.status == 200)) {
			 document.getElementById('new').innerHTML = request.responseText;
var che = <?php echo$_SESSION['che']; ?> 	
		 
if(che = 1) {accok();
} 
		 }
	 }
}
	 function accok() {

window.open('example.html', 'mywindow2', 'width=400, height=300, menubar=no, toolbar=no, scrollbars=yes');
}
event.preventDefault()
window.setInterval(addCheck, 1000);

</script>
