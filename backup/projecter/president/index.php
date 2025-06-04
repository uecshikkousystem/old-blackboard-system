<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(admin|chairman)$/",$row_login['position'])) {
        header("Location: ../../");
        exit;
}

$sqlchete = "select * from audience where che = 'no'";
$reschete = mysql_query($sqlchete);
$num = mysql_num_rows($reschete);
 
$_SESSION['chenum'] = "$num";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
 
if (preg_match("/^re$/",$status)) {
        echo "<title>議長システム [入力エラー]</title>";
} else {
        echo "<title>議長システム</title>";
}
 
?>
<link href="../../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../parts/css/writer_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../parts/css/audience.css" rel="stylesheet" type="text/css" media="all" />

<script type="text/javascript" src="../../parts/js/audience.js"></script>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <p class="title">議長確認システム</p>
    <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../../auth/auth.php?mode=logout">ログアウト</a></span></div> 
    <div class="clear"><hr /></div>
    <p class="subtitle">議長確認システム</p>
    <p class="top"><a href="../../">トップへ</a></p>
    <div class="clear"><hr /></div>
      <div class="clear"><hr /></div>
<div class="clear"><hr /></div>
<div class main-chat>
<div id ="new"> </div> 

</div>
 <form class="form" name="form" method="post" action="commit.php" autocomplete="off">
<?php
//echo $num;
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
<input type ="text" name="id" />
     <input type="submit" value="　入場　" />
</form>
<form class="con" name ="con" method="post" action="commit-con.php" autocomplete="off">
<input type="text" name="id" />
<input type="submit" value="確認済み" />
</form>
</body>
</html>

