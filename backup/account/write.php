<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(info|infoadmin|admin)$/",$row_login['position'])) {
	header("Location: ../../");
	exit;
} else {
	$user_name = $_COOKIE['user_name'];
}

if (isset($_GET['a_id'])) {
	
	$sql = "select status,parent_id from " . $tablename_account . " where student_id = '" . $_GET['a_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (!empty($row['status']) || !empty($row['parent_id'])) {
		$url = "./account.php?err&student_id=" . $_GET['a_id'];
		header("Location: " . $url);
		exit;
	}
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = 'attend1',";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['a_id'] . "'";
				
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
				
	if ($res) {
		$url = "./account.php?student_id=" . $_GET['a_id'];
		header("Location: " . $url);
		exit;
	}
	
} else if (isset($_GET['g_id'])) {
	
	$sql = "select status,parent_id from " . $tablename_account . " where student_id = '" . $_GET['g_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (!empty($row['status']) || !empty($row['parent_id'])) {
		$url = "./account.php?err&student_id=" . $_GET['g_id'];
		header("Location: " . $url);
		exit;
	}
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = 'gicho',";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['g_id'] . "'";
				
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
		
	if ($res) {
		$url = "./account.php?student_id=" . $_GET['g_id'];
		header("Location: " . $url);
		exit;
	}
	
} else if (isset($_GET['c_id'])) {
	
	$sql = "select status from " . $tablename_account . " where student_id = '" . $_GET['c_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (empty($row['status'])) {
		$url = "./account.php?err&student_id=" . $_GET['c_id'];
		header("Location: " . $url);
		exit;
	}
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = NULL,";
	$sql .= "parent_id = NULL,";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['c_id'] . "'";
				
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
				
	if ($res) {
		$url = "./account.php?student_id=" . $_GET['c_id'];
		header("Location: " . $url);
		exit;
	}
	
} else if (isset($_GET['k_id']) && isset($_GET['p_id'])) {
	
	if ($_GET['p_id'] == $_GET['k_id']) {
		$url = "./account.php?err&student_id=" . $_GET['p_id'];
		header("Location: " . $url);
		exit;
	}
	
	$sql = "select status from " . $tablename_account . " where student_id = '" . $_GET['p_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (preg_match("/^attend1$/",$row['status'])) {
		$attend = "attend2";
	} else if (preg_match("/^attend2$/",$row['status'])) {
		$attend = "attend3";
	} else {
		$url = "./account.php?student_id=" . $_GET['p_id'];
		header("Location: " . $url);
		exit;
	}
	
	$sql = "select status,parent_id from " . $tablename_account . " where student_id = '" . $_GET['k_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (!empty($row['status']) || !empty($row['parent_id'])) {
		$url = "./account.php?err&student_id=" . $_GET['p_id'];
		header("Location: " . $url);
		exit;
	}
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = '" . $attend . "',";
	$sql .= "parent_id = NULL,";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['p_id'] . "'";
	
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = 'kojin',";
	$sql .= "parent_id = '". $_GET['p_id'] . "',";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['k_id'] . "'";
	
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
	
	if ($res) {
		$url = "./account.php?student_id=" . $_GET['p_id'];
		header("Location: " . $url);
		exit;
	}
	
} else if (isset($_GET['kc_id']) && isset($_GET['pc_id'])) {
	
	$sql = "select status from " . $tablename_account . " where student_id = '" . $_GET['pc_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (preg_match("/^attend2$/",$row['status'])) {
		$status = "attend1";
	} else if (preg_match("/^attend3$/",$row['status'])) {
		$status = "attend2";
	} else {
		if (isset($_GET['mode'])) {
			$url = "./account.php?student_id=" . $_GET['pc_id'];
		} else {
			$url = "./account.php?student_id=" . $_GET['kc_id'];
		}
		header("Location: " . $url);
		exit;
	}
	
	$sql = "select status,parent_id from " . $tablename_account . " where student_id = '" . $_GET['kc_id'] . "'";
	$res = mysql_query($sql,$conn) or die("抽出エラー");
	$row = mysql_fetch_array($res,MYSQL_ASSOC);
	
	if (empty($row['status']) || empty($row['parent_id'])) {
		if (isset($_GET['mode'])) {
			$url = "./account.php?student_id=" . $_GET['pc_id'];
		} else {
			$url = "./account.php?student_id=" . $_GET['kc_id'];
		}
		header("Location: " . $url);
		exit;
	}
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = '" . $status . "',";
	$sql .= "parent_id = NULL,";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['pc_id'] . "'";
	
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
	
	$sql = "UPDATE " . $tablename_account . " SET ";
	$sql .= "status = NULL,";
	$sql .= "parent_id = NULL,";
	$sql .= "editer = '" . $user_name . "',";
	$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
	$sql .= " WHERE student_id = '" . $_GET['kc_id'] . "'";
	
	$res = mysql_query($sql,$conn) or die("データ編集エラー");
	
	if ($res) {
		if (isset($_GET['mode'])) {
			$url = "./account.php?student_id=" . $_GET['pc_id'];
		} else {
			$url = "./account.php?student_id=" . $_GET['kc_id'];
		}
		header("Location: " . $url);
		exit;
	}
}

?>

