  <div class="main">
    <form class="form" method="post" action="vote_write.php">
      <div class="name">
        <fieldset>
          <legend<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error1'])){ echo " class=\"error\""; }} ?>>名前</legend>
            <div class="name-in">
<?php

$sql = "select * from " . $tablename_ele . " where (kind = 'main' or kind = 'sub')";
$res = mysql_query($sql, $conn) or die("データ抽出エラー");
	
while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
	echo "<input type=\"radio\" name=\"name\" id=\"name-" . $row['id'] . "\" value=\"" . $row['id'] ."\""; 
	
	if (preg_match("/^vote_re$/",$_SESSION['status'])) {
		if (empty($_SESSION['error1']) && ($_SESSION['name'] == $row['id'])) {
			echo "checked=\"checked\" ";
		}
	}
	
	if (preg_match("/^main$/",$row['kind'])) {
		$kind = "委員長立候補";
	} else if (preg_match("/^sub$/",$row['kind'])) {
		$kind = "副委員長立候補";
	}
		
	echo "><label for=\"name-" . $row['id'] . "\">" . $kind . " " . $row['fname'] . $row['lname'] . "</label><br />\n";
}

?>
            </div>
        </fieldset>
      </div>
      <div class="vote">
        <fieldset>
          <legend>票数</legend>
            <div class="vote-in">
              信任：<input type="text" name="ok" class="num<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error2'])){ echo " error2"; }} ?>" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['ok'])){ echo "value=\"" . $_SESSION['ok'] . "\" "; }} ?>onkeypress="return submitStop(event);" />
              不信任：<input type="text" name="ng" class="num<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error3'])){ echo " error2"; }} ?>" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['ng'])){ echo "value=\"" . $_SESSION['ng'] . "\" "; }} ?>onkeypress="return submitStop(event);" />
            </div>
        </fieldset>
      </div>
      <div class="submit">
        <input type="submit" name="ele" value="　採決入力　" />
      </div>
    </form>
  </div><!--main:end-->