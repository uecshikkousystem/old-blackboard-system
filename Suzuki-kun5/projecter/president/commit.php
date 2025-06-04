<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

$chesql = "select * from audience";
$cheres = mysql_query($chesql);
$chenum = mysql_num_rows($cheres);


$id = cnv_dbstr($_POST['id']);
$connid = $_SESSION['connid'];
echo "$chenum";
if($chenum >= $id){
if(isset($connid)){
while($id >= $connid){
$sql = "UPDATE audience SET che = 'yes' WHERE id = '" . $connid . "' ;";

$res = mysql_query($sql,$conn); 
//echo "$sql";
$connid = $connid + 1;
}
}else{
$sql = "UPDATE audience SET che = 'yes' WHERE id = '" . $id . "' ;";

$res = mysql_query($sql,$conn); 
}
}else{

echo "idが不正です。";
}

if($res){
echo"認証完了";
$_SESSION['connid'] = $id;
header('Location: ./index.php');
}else{
echo"認証失敗";

}
//echo "<meta http-equiv=\"refresh\" content=\"1;URL=http://kurneko.com/Suzuki-kun4/projecter/president/index.php\" />\n"
?>


