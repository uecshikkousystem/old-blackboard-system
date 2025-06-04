<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

$id = cnv_dbstr($_POST['id']);
echo "$id";
$sql = "UPDATE audience SET ok = 'ok' WHERE id = '" . $id . "' ;";

$res = mysql_query($sql,$conn); 
//echo "$sql";

if($res){
echo"認証完了";

}else{
echo"認証失敗";

}
header('Location: ./index.php');
echo "<meta http-equiv=\"refresh\" content=\"1;URL=http://192.168.0.10/projecter/president/index.php\" />\n"
?>


