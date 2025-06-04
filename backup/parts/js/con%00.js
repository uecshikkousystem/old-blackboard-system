function audiencecheck() {
         var clear = new Date().getTime();
         var request = new XMLHttpRequest();
    
         request.open("GET", "check-con.php" , true);
         request.send(null);
         request.onreadystatechange = readyStateChangeHandler;
    
         function readyStateChangeHandler() {
                 if ((request.readyState == 4) && (request.status == 200)) {
                         document.getElementById('list').innerHTML = request.responseText;
    
                 }   
         }   
}
function okcheck() {
         var clear = new Date().getTime();
         var request = new XMLHttpRequest();
    
         request.open("GET", "check-ok.php" , true);
         request.send(null);
         request.onreadystatechange = readyStateChangeHandler;
    
         function readyStateChangeHandler() {
                 if ((request.readyState == 4) && (request.status == 200)) {
                         document.getElementById('check').innerHTML = request.responseText;
    
                 }   
         }   
}



function accload() {
setTimeout("autoLink()",1);
}

function autoLink()
{
location.href="./index.php";
}


window.setInterval(audiencecheck, 1000);
window.setInterval(okcheck, 5000);
