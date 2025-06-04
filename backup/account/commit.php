<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

$tablename = "audience";	
$faculty = cnv_dbstr($_POST['faculty']);
$grade = cnv_dbstr($_POST['grade']);
$subject = cnv_dbstr($_POST['subject']);
$name = cnv_dbstr(char_change($_POST['name']));
$comment = cnv_dbstr($_POST['comment']);
$check = no ;			
//echo"	$tablename";

//echo"	$faculty";
//echo"	$grade";
//echo"	$name";
//echo"	$comment";




$sql = "INSERT INTO " . $tablename . "( faculty, grade, subject, name, comment, che, date)";
$sql .= "VALUES(";
$sql .= "'" . $faculty . "',";
$sql .= "'" . $grade . "',";
$sql .= "'" . $subject . "',";
$sql .= "'" . $name . "',";
$sql .= "'" . $comment . "',";
$sql .= "'no',";
$sql .= "'" . date("Y/m/d H:i:s") . "'";
$sql .= ")";
echo $sql;			
$res = mysql_query($sql,$conn) or die("データ追加エラー");
echo $res;


if ($res) {
	$_SESSION['status'] = "a_write_ok";

$sqlche = "SELECT id FROM audience ORDER BY id DESC LIMIT 1";
$sqlchete = "SELECT * FROM audience WHERE id  IN  (SELECT MAX(id) FROM audience)";
$resche = mysql_query($sqlche);
$reschete = mysql_query($sqlchete);

while ($row = mysql_fetch_assoc($reschete)) {
//echo "this id =";   
//    echo $row["id"];
//    echo $row["faculty"];
  //  echo $row["grade"];
 //   echo $row["name"];
 //   echo $row["comment"];
 //   echo $row["che"];
  //  echo $row["date"];
extract($row);
}

$_SESSION['nowid'] = "$id";

	$url =  "./audience-con.php";
	header("Location: " . $url);
	exit;
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>総会総合システム<?php if (!isset($_COOKIE['user_name'])) { echo " [ログイン]"; } ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/index_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/audience.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../parts/js/acc_che.js"></script>
</head>
<body>
<div id ="header"> </div>
<div id=\"inner\"></div>
<div class="main">
<strong style="color:#000000">確認中。もっているidは</strong>  
<?php echo $_SESSION['nowid'] ?>

<div id="new"></div>

</div>
</body>
</html>
