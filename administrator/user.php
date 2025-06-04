<div class="main">
<?php
	
$sql = "select * from " . $tablename_user . " where id != '1' ORDER BY id DESC";
$res = mysql_query($sql, $conn) or die("データ抽出エラー");

while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
	echo "<form method=\"post\" action=\"../auth/user_edit.php?user=edit&amp;id=" . $row['id'] . "\">";
	echo "<p>ユーザー名 : " . $row['user'] . "</p>";
	echo "<span>名前 : </span><input type=\"text\" name=\"lname\" value=\"" . $row['lname'] . "\" /><input type=\"text\" name=\"fname\" value=\"" . $row['fname'] . "\" />";
	echo "<span>役職 : </span>" . position_select($row['position']) . "<br />";
	if (empty($row['login']) && empty($row['logout'])) {
		echo "<span>ログイン日時 : (未ログイン)</span>";
	} else {
		echo "<span>ログイン日時 : " . date("Y/m/d H:i:s", strtotime($row['login'])) ;
		if (empty($row['logout'])) {
			echo " - (現在ログイン中)</span>";
		} else {
			echo " - " . date("Y/m/d H:i:s", strtotime($row['logout'])) . "</span>";
		}
	}
	echo "<p>登録日時 : " . date("Y/m/d H:i:s", strtotime($row['makedate'])) . "</p>";
	echo "<p>クライアント情報 : " . $row['useragent'] . "</p>";
	echo "<input type=\"submit\" value=\"編集完了\" />";
	
	if ($row['user'] !== $user_name)
		echo "<input type=\"button\" value=\"削除\" onclick=\"DeleteUser(" . $row['id'] . ");\" />";
		
	echo "</form>";
	echo "<hr />\n";
}

$sql = "select * from " . $tablename_user . " where id = '1'";
$res = mysql_query($sql, $conn) or die("データ抽出エラー");

while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
	echo "<form method=\"post\" action=\"../auth/user_edit.php?user=edit&amp;admin&amp;id=" . $row['id'] . "\">";
	echo "<p>ユーザー名 : " . $row['user'] . "</p>";
	echo "<span>名前 : </span><input type=\"text\" name=\"lname\" value=\"" . $row['lname'] . "\" /><input type=\"text\" name=\"fname\" value=\"" . $row['fname'] . "\" />";
	echo "<span>役職 : " . name_change($row['position']) . "(最高管理ユーザー)" . "</span><br />";
	if (empty($row['login']) && empty($row['logout'])) {
		echo "<span>ログイン日時 : (未ログイン)</span>";
	} else {
		echo "<span>ログイン日時 : " . date("Y/m/d H:i:s", strtotime($row['login'])) ;
		if (empty($row['logout'])) {
			echo " - (現在ログイン中)</span>";
		} else {
			echo " - " . date("Y/m/d H:i:s", strtotime($row['logout'])) . "</span>";
		}
	}
	echo "<p>登録日時 : " . date("Y/m/d H:i:s", strtotime($row['makedate'])) . "</p>";
	echo "<p>クライアント情報 : " . $row['useragent'] . "</p>";
	echo "<input type=\"submit\" value=\"編集完了\" />";
	echo "</form>";
	echo "<hr />\n";
}

?>
</div><!--main:end-->

