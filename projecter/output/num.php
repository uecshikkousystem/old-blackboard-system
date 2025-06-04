<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

$sql = "select body from " . $tablename_set;
$res = mysql_query($sql,$conn);
$i = 1;

if (preg_match("/^sokai$/",$set['kind'])) {
	if ($set['cal'] == 'auto') {
		$sql_num = "select status from " . $tablename_account . " where (status = 'attend1' or status = 'attend2' or status = 'attend3' or status = 'gicho')";
		$res_num = mysql_query($sql_num,$conn);
		
		$jyonai = 0;
		$inin = 0;
		
		while ($row_num = mysql_fetch_array($res_num,MYSQL_ASSOC)) {
			if (preg_match("/^gicho$/",$row_num['status'])) {
				$inin = $inin + 1;
			} else if (preg_match("/^attend1$/",$row_num['status'])) {
				$jyonai = $jyonai + 1;
			} else if (preg_match("/^attend2$/",$row_num['status'])) {
				$jyonai = $jyonai + 2;
			} else if (preg_match("/^attend3$/",$row_num['status'])) {
				$jyonai = $jyonai + 3;
			}
		}
		
		$jyonai = parts_change(f_parts_change($jyonai));
		$inin = parts_change(f_parts_change($inin));
	
	} else if ($set['cal'] == 'manual') {
		$sql_num = "select * from " . $tablename_num . " ORDER BY id DESC";
		$res_num = mysql_query($sql_num,$conn) or die("データ抽出エラー");
		$row_num = mysql_fetch_array($res_num,MYSQL_ASSOC);
		$jyonai = parts_change(f_parts_change($row_num['num_jyonai']));
		$inin = parts_change(f_parts_change($row_num['num_inin']));
	}
	
	echo "<div class=\"jyonai-num\">場内票数<div class=\"space-num\"><hr /></div><div class=\"space-num\"><hr /></div><div class=\"space-num\"><hr /></div>" . $jyonai . "票</div>";
	echo "<div class=\"inin-num\">議長委任票数<div class=\"space-num\"><hr /></div>" . $inin . "票</div>";
	echo "<div class=\"clear\"><hr /></div>";
	
}

?>