    <div class="main">
<?php

$sql = "select body from " . $tablename_set;
$res = mysql_query($sql,$conn);
$i = 1;

while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
	$row_res['body'.$i] = $row['body'];
	$i++;
}

if (preg_match("/^manual$/", $set['cal'])) {
	echo "<form class=\"form\" method=\"post\" action=\"num_write.php\">";
	echo "<div class=\"motion\"><fieldset><legend>票数</legend>";
	echo "<div class=\"num-in\">";
	echo "場内票数：<input type=\"text\" name=\"num_jyonai\" class=\"num-form";

	if (preg_match("/^num_re$/",$_SESSION['status'])) {
		if (!empty($_SESSION['error1'])) {
			echo " error2";
		}
	}

	echo "\"";

	if (preg_match("/^num_re$/",$_SESSION['status'])) {
		if (!empty($_SESSION['num_jyonai'])) {
			echo "value=\"" . $_SESSION['num_jyonai'] . "\" ";
		}
	}

	echo "onkeypress=\"return submitStop(event);\" />";
	echo "議長委任票数：<input type=\"text\" name=\"num_inin\" class=\"num-form";

	if (preg_match("/^num_re$/",$_SESSION['status'])) {
		if (!empty($_SESSION['error2'])) {
			echo " error2";
		}
	}
	
	echo "\"";
	
	if (preg_match("/^num_re$/",$_SESSION['status'])) {
		if (!empty($_SESSION['num_inin'])) {
			echo "value=\"" . $_SESSION['num_inin'] . "\" ";
		}
	}
	echo "onkeypress=\"return submitStop(event);\" />";
   	echo "</div></fieldset></div>";
	echo "<div class=\"submit\"><input type=\"submit\" value=\"　票数入力　\" /></div></form>";

} else {
	echo "<p>現在、受付データベースより自動計算されているため、手動入力できません。</p>";
}
		
?>
    </div><!--main:end-->