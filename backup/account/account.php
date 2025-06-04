<?php

include("./header.php");

$errflg = 0;
	
if (empty($_GET['student_id'])) {
	$_SESSION['error1'] = 1;
	$errflg = 1;
} else {
	if (!preg_match("/^\d{7}$/",$_GET['student_id'])) {
		$_SESSION['error1'] = 2;
		$errflg = 1;
	} else {
		$_SESSION['error1'] = "";
	}
}
	
if ($_SERVER['REQUEST_METHOD'] == "GET") {
	if ($errflg == 0) {
			
		$student_id = $_GET['student_id'];
			
		$sql = "select * from " . $tablename_account . " where student_id = '" . $student_id . "'";
		$res = mysql_query($sql,$conn) or die("抽出エラー");
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
			
		if (empty($row['student_id'])) {
			$_SESSION['error1'] = 3;
			header("Location: ./index.php?res=re");
			exit;
		}
		
	} else {
		$_SESSION['input_num'] = $_GET['student_id'];
		header("Location: ./index.php?res=re");
		exit;
	}
	
} else {
	header("Location: ./index.php?res=ng");
	exit;
}

if (isset($_GET['err'])) {
	echo "<div class=\"main-not\">";
	echo "<p>不明なエラーが発生しました。</p>";
	echo "</div>";
	exit;
}

if (preg_match("/^yes$/",$row['member'])) {
	echo "<div class=\"main\">";
	
	if (!empty($row['status'])) {
		
		$sql_k = "select * from " . $tablename_account . " where parent_id = '" . $row['student_id'] . "'";
		$res_k = mysql_query($sql_k,$conn) or die("抽出エラー");

		if (preg_match("/^attend(1|2)$/",$row['status'])) {
			if (preg_match("/^attend1$/",$row['status'])) {
				echo "<p class=\"re-txt\">１票で出席中です。</p>";
				echo "<p class=\"res-id\">学籍番号：<span id=\"p_id\">" . $row['student_id'] . "</span></p>";
				echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
				echo "<div class=\"button-box\">";
				echo "<div class=\"button\"><a href=\"./write.php?c_id=" . $row['student_id'] . "\" onclick=\"return Cancel();\">取り消し</a></div>";
				echo "<div class=\"clear\"><hr /></div>";
				echo "</div>";
			} else if (preg_match("/^attend2$/",$row['status'])) {
				echo "<p class=\"re-txt\">２票で出席中です。</p>";
				echo "<p class=\"res-id\">学籍番号：<span id=\"p_id\">" . $row['student_id'] . "</span></p>";
				echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
				
				echo "</div>";
				echo "<div class=\"main\">";
				while($row_k = mysql_fetch_array($res_k,MYSQL_ASSOC)) {
					echo "<p class=\"res-idname\">学籍番号：" . $row_k['student_id'] . "　名前：" . $row_k['lname'] . $row_k['fname'] . "</p>";
					echo "<div class=\"button2\"><a href=\"./write.php?kc_id=" . $row_k['student_id'] . "&pc_id=" . $row_k['parent_id'] . "&mode=p\" onclick=\"return Cancel();\">取り消し</a></div>";
					echo "<div class=\"clear\"><hr /></div>";
				}
			}
			echo "</div>";
			echo "<div class=\"main\">";
			echo "<form class=\"form\" name=\"kojinform\" method=\"GET\" action=\"#\">";
			echo "<fieldset class=\"form-kojin\"><legend>個人委任入力フォーム</legend>";
			echo "<div id=\"error\"></div>";
			echo "<input class=\"id-in\" type=\"text\" name=\"k_id\" onkeypress=\"return KojinEnter(event);\" onfocus=\"return KojinCheck();\" autocomplete=\"off\" /><br />";
			echo "</fieldset></form>";
			echo "<div id=\"kojin\"></div>";
			
		} else if (preg_match("/^attend3$/",$row['status'])) {
			echo "<p class=\"re-txt\">３票で出席中です。</p>";
			echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
			echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
			
			echo "</div>";
			echo "<div class=\"main\">";
			while($row_k = mysql_fetch_array($res_k,MYSQL_ASSOC)) {
				echo "<p class=\"res-idname\">学籍番号：" . $row_k['student_id'] . "　名前：" . $row_k['lname'] . $row_k['fname'] . "</p>";
				echo "<div class=\"button2\"><a href=\"./write.php?kc_id=" . $row_k['student_id'] . "&pc_id=" . $row_k['parent_id'] . "&mode=p\" onclick=\"return Cancel();\">取り消し</a></div>";
				echo "<div class=\"clear\"><hr /></div>";
			}
		} else if (preg_match("/^kojin$/",$row['status'])) {
			echo "<p class=\"re-txt\">" . $row['parent_id'] . "に対して個人委任中です。</p>";
			echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
			echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
			echo "<div class=\"button-box\">";
			echo "<div class=\"button\"><a href=\"./write.php?kc_id=" . $row['student_id'] . "&pc_id=" . $row['parent_id'] . "\" onclick=\"return Cancel();\">取り消し</a></div>";
			echo "<div class=\"clear\"><hr /></div>";
			echo "</div>";
		} else if (preg_match("/^gicho$/",$row['status'])) {
			echo "<p class=\"re-txt\">議長委任中です。</p>";
			echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
			echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
			echo "<div class=\"button-box\">";
			echo "<div class=\"button\"><a href=\"./write.php?c_id=" . $row['student_id'] . "\" onclick=\"return Cancel();\">取り消し</a></div>";
			echo "<div class=\"clear\"><hr /></div>";
			echo "</div>";
		}
	} else {
		echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
		echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
		echo "<div class=\"button-box2\">";
		echo "<div class=\"button\"><a href=\"./write.php?a_id=" . $row['student_id'] . "\" onclick=\"if (window.confirm('”" . $row['lname'] . $row['fname'] . "” さんで間違いないですか？')) { return ture; } else { return false; }\" tabindex=\"1\">出席</a></div>";
		echo "<div class=\"button\"><a href=\"./write.php?g_id=" . $row['student_id'] . "\" onclick=\"if (window.confirm('”" . $row['lname'] . $row['fname'] . "” さんで間違いないですか？')) { return ture; } else { return false; }\" tabindex=\"2\">議長委任</a></div>";
		echo "<div class=\"clear\"><hr /></div>";
		echo "</div>";
	}
	echo "</div>";
	
} else if (preg_match("/^(no|)$/",$row['member'])) {
	echo "<div class=\"main-not\">";
	echo "<p class=\"re-txt\">学友会員ではありません。</p>";
	echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
	echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
	echo "</div>";
}

include("./footer.php");

?>