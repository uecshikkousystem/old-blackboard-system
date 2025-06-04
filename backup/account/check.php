<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

if (!isset($_COOKIE['user_name'])) {
	exit;
}

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

$nowid = $_SESSION['nowid'];
$sql = "select * from audience where id =";
$sql .= "'" . $nowid . "'";
$sql .= "and che like '%yes%'";

//echo $sql;
//echo"sessionid=" , $nowid ;

$res = mysql_query($sql);

while ($row = mysql_fetch_assoc($res)) {
//echo "this id =";   
//    echo $row["id"];
  //  echo $row["faculty"];
  //  echo $row["grade"];
  //  echo $row["name"];
  //  echo $row["comment"];
  //  echo $row["che"];
  //  echo $row["date"];
extract($row);
}
if(isset($id)){
echo"ok!!!";
echo $nowid;
}
else{
header("HTTP/1.0 404 Not Found", FALSE);
//echo"ng";
//echo $nowid;
}
?>
