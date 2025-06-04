<?php

include("./header.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(infoadmin|admin)$/",$row_login['position'])) {
	header("Location: ./");
	exit;
}

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
		
	} else {
		$_SESSION['input_num'] = $_GET['student_id'];
		header("Location: ./edit_index.php?res=re");
		exit;
	}
	
} else {
	header("Location: ./edit_index.php?res=ng");
	exit;
}

if (empty($row['student_id'])) {
	echo "<p class=\"mes\">学籍番号:" . $student_id . "の新規作成</p>";
}

if (isset($_GET['res'])) {
	if (preg_match("/^ok$/", $_GET['res'])) {
		echo "<p class=\"mes\">修正完了</p>";
	} else if (preg_match("/^re$/", $_GET['res'])) {
		echo "<p class=\"mes-ng\">入力エラー</p>";
	} else if (preg_match("/^ng$/", $_GET['res'])) {
		echo "<p class=\"mes-ng\">エラー</p>";
	}
}

?>

<div class="main-edit">
<form class="edit-form"  method="post" action="edit_write.php?student_id=<?php if (!empty($row['student_id'])) { echo $row['student_id']; } else { echo $student_id; } ?>">
  <div class="name">
    <fieldset>
      <legend>名前</legend>
        姓<input type="text" name="lname"<?php if (isset($row['fname'])) { echo " value=\"" . $row['lname'] . "\""; } ?> onkeypress="return submitStop(event);" />
        名<input type="text" name="fname"<?php if (isset($row['lname'])) { echo " value=\"" . $row['fname'] . "\""; } ?> onkeypress="return submitStop(event);" />
    </fieldset>
  </div>
  <div class="member">
    <fieldset>
      <legend>学友会員</legend>
        <input type="radio" id="member-y" name="member" value="yes"<?php if (isset($row['member'])) { if (preg_match("/^yes$/",$row['member'])) { echo " checked=\"checked\""; }} ?> /><label for="member-y">会員</label>
        <input type="radio" id="member-n" name="member" value="no"<?php if (isset($row['member'])) { if (preg_match("/^(no|)$/",$row['member'])) { echo " checked=\"checked\""; }} ?> /><label for="member-n">非会員</label>
    </fieldset>
  </div>
  <div class="status">
    <fieldset>
      <legend>参加状況(基本的に変更しないでください)</legend>
        <input type="radio" id="status-n" name="status" value="none"<?php if (empty($row['status'])) { echo " checked=\"checked\""; } ?> /><label for="status-n">未参加</label>
        <input type="radio" id="status-a1" name="status" value="attend1"<?php if (isset($row['status'])) { if (preg_match("/^attend1$/",$row['status'])) { echo " checked=\"checked\""; }} ?> /><label for="status-a1">1票参加</label>
        <input type="radio" id="status-a2" name="status" value="attend2"<?php if (isset($row['status'])) { if (preg_match("/^attend2$/",$row['status'])) { echo " checked=\"checked\""; }} ?> /><label for="status-a2">2票参加</label>
        <input type="radio" id="status-a3" name="status" value="attend3"<?php if (isset($row['status'])) { if (preg_match("/^attend3$/",$row['status'])) { echo " checked=\"checked\""; }} ?> /><label for="status-a3">3票参加</label>
        <input type="radio" id="status-g" name="status" value="gicho"<?php if (isset($row['status'])) { if (preg_match("/^gicho$/",$row['status'])) { echo " checked=\"checked\""; }} ?> /><label for="status-g">議長委任</label>
        <input type="radio" id="status-k" name="status" value="kojin"<?php if (isset($row['status'])) { if (preg_match("/^kojin$/",$row['status'])) { echo " checked=\"checked\""; }} ?> /><input type="text" class="parent-id" name="parent_id"<?php if (isset($row['parent_id']) && !empty($row['parent_id'])) { echo " value=" . $row['parent_id']; } ?> /><label for="status-k">に対して個人委任</label>
    </fieldset>
  </div>
  <div class="submit">
    <input type="submit" value="修正完了" />
  </div>
</form>
</div>

<?php

include("./footer.php");

?>
