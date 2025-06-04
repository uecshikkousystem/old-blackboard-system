<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

if (isset($_GET['set']) && preg_match("/^http:\/\/.*\/administrator\/.*\?mode=ini$/",$_SERVER["HTTP_REFERER"]))
	require_once("../db/dbconnect.php");

$sql = "show tables like '". $tablename_set ."'";
$res = mysql_query($sql, $conn);

if (!mysql_num_rows($res)) {
	$sql1 = "create table " . $tablename_set . " (";
	$sql1 .= "id int(11) not null auto_increment,";
	$sql1 .= "item varchar(50) not null,";
	$sql1 .= "body varchar(50) not null,";
	$sql1 .= "date datetime,";
	$sql1 .= "primary key (id)";
	$sql1 .= ")";

	$res1 = mysql_query($sql1, $conn) or die("テーブル追加1エラー");
	
	$sql = "INSERT INTO " . $tablename_set . " (item, body, date)";
	$sql .= "VALUES(";
	$sql .= "'kind',";
	$sql .= "'sokai',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'cal',";
	$sql .= "'auto',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'add',";
	$sql .= "'yes',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'num',";
	$sql .= "'46',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= ")";

	$res = mysql_query($sql,$conn) or die("データ追加エラー");
}

$sql = "show tables like '". $tablename_num ."'";
$res = mysql_query($sql, $conn);

if (!mysql_num_rows($res)) {
	$sql2 = "create table  ". $tablename_num . " (";
	$sql2 .= "id int(11) not null auto_increment,";
	$sql2 .= "num_jyonai int(11) not null,";
	$sql2 .= "num_inin int(11) not null,";
	$sql2 .= "date datetime,";
	$sql2 .= "primary key (id)";
	$sql2 .= ")";
	
	$res2 = mysql_query($sql2,$conn) or die("テーブル追加2エラー");
	
	$sql = "INSERT INTO " . $tablename_num . " (num_jyonai, num_inin, date)";
	$sql .= "VALUES(";
	$sql .= "'0',";
	$sql .= "'0',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= ")";

	$res = mysql_query($sql,$conn) or die("データ追加エラー");
}
	
$sql3 = "create table if not exists " . $tablename_tables . " (";
$sql3 .= "id int(11) not null auto_increment,";
$sql3 .= "kind varchar(10),";
$sql3 .= "faculty varchar(10),";
$sql3 .= "grade varchar(10),";
$sql3 .= "subject varchar(10),";
$sql3 .= "fname varchar(70) character set utf8,";
$sql3 .= "lname varchar(70) character set utf8,";
$sql3 .= "question text character set utf8 not null,";
$sql3 .= "usenow varchar(10) not null,";
$sql3 .= "date datetime,";
$sql3 .= "primary key (id)";
$sql3 .= ")";

$res3 = mysql_query($sql3,$conn) or die("テーブル追加3エラー");

$sql = "show tables like '". $tablename_ele ."'";
$res = mysql_query($sql, $conn);

if (!mysql_num_rows($res)) {
	$sql4 = "create table " . $tablename_ele . " (";
	$sql4 .= "id int(11) not null auto_increment,";
	$sql4 .= "kind varchar(10),";
	$sql4 .= "faculty varchar(10),";
	$sql4 .= "grade varchar(10),";
	$sql4 .= "subject varchar(10),";
	$sql4 .= "fname varchar(70) character set utf8,";
	$sql4 .= "lname varchar(70) character set utf8,";
	$sql4 .= "comment text character set utf8,";
	$sql4 .= "output varchar(10) not null,";
	$sql4 .= "date datetime,";
	$sql4 .= "primary key (id)";
	$sql4 .= ")";

	$res4 = mysql_query($sql4,$conn) or die("テーブル追加4エラー");
	
	$sql = "INSERT INTO " . $tablename_tables . " (kind, question, usenow, date)";
	$sql .= "VALUES(";
	$sql .= "'2',";
	$sql .= "'election',";
	$sql .= "'no',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'3',";
	$sql .= "'open',";
	$sql .= "'no',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'4',";
	$sql .= "'break',";
	$sql .= "'no',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'5',";
	$sql .= "'end',";
	$sql .= "'no',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= "),(";
	$sql .= "'6',";
	$sql .= "'brank',";
	$sql .= "'yes',";
	$sql .= "'" . date("Y/m/d H:i:s") . "'";
	$sql .= ")";
			
	$res = mysql_query($sql,$conn) or die("データ追加7エラー");
}

$sql5 =  "create table if not exists " . $tablename_account . " (";
$sql5 .= "student_id varchar(50) not null,";
$sql5 .= "lname varchar(50) character set utf8,";
$sql5 .= "fname varchar(50) character set utf8,";
$sql5 .= "member varchar(10),";
$sql5 .= "status varchar(50),";
$sql5 .= "parent_id varchar(50),";
$sql5 .= "editer varchar(70),";
$sql5 .= "date datetime,";
$sql5 .= "primary key (student_id)";
$sql5 .= ")";

$res5 = mysql_query($sql5,$conn) or die("テーブル追加5エラー");

$sql6 =  "create table if not exists " . $tablename_chat . " (";
$sql6 .= "id int(11) not null auto_increment,";
$sql6 .= "user varchar(50),";
$sql6 .= "position varchar(50),";
$sql6 .= "addr varchar(50) not null,";
$sql6 .= "comment text character set utf8,";
$sql6 .= "date datetime,";
$sql6 .= "primary key (id)";
$sql6 .= ")";

$res6 = mysql_query($sql6,$conn) or die("テーブル追加6エラー");

if (isset($_GET['set'])) {
	if ($res3 && $res5 && $res6) {
		header("Location: ./?mode=conf");
		exit;
	}
}

?>