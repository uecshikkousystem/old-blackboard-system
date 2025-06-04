<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

 $sql = "SELECT * FROM audience WHERE che = 'no'";
$dyn = mysql_query($sql, $conn);



if(!$dyn){
    die("query error");
}
echo "<div class=\"main\">";
$i = 1;
while($row = mysql_fetch_array($dyn)){

   echo $row['id'] . " : ";
   echo $row['faculty'] . " : ";
   echo $row['grade'] . " : ";
echo $row['subject'] . " : ";
echo $row['name'] . " : ";
   echo $row['comment'] . " : ";
   echo $row['date'] ;
echo "   check:";
echo $row['ok'];
echo "<br>";
$i = $i + 1;
}
?>
