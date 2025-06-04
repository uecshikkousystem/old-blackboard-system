<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");


require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");


$chenum = $_SESSION['chenum'];
$sql = "select * from audience where che = 'no'";

$res = mysql_query($sql);
$nownum = mysql_num_rows($res);

echo $nownum;
if($chenum < $nownum){
echo "<div class=\"newalert\"><a onclick=\"accload()\" href=\"javascript:void(0)\">新しい傍聴者がいます</a></div>";

}
else{
header("HTTP/1.0 404 Not Found", FALSE);
//echo"ng";
//echo $nowid;
}


?>
