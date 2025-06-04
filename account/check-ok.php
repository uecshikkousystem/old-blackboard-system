<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

$oknum = $_SESSION['oknum'];

$sql = "select * from audience where che = 'no' and ok is NULL";

$res = mysql_query($sql);

$num = mysql_num_rows($res);
//echo $num;
//echo $oknum; 
if($num < $oknum){

$now = $oknum - $num;

echo $now;
echo "件が承認されました。";  


}
?>
