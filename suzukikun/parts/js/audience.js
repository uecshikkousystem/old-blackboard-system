function audiencecheck() {
         var clear = new Date().getTime();
         var request = new XMLHttpRequest();
    
         request.open("GET", "check.php" , true);
         request.send(null);
         request.onreadystatechange = readyStateChangeHandler;
    
         function readyStateChangeHandler() {
                 if ((request.readyState == 4) && (request.status == 200)) {
                         document.getElementById('new').innerHTML = request.responseText;
    
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

