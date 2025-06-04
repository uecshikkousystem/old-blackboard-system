	<div class="main">
      <form method="post" name="conf" enctype="multipart/form-data" action="conf_write.php?mode=conf">
        <fieldset class="kind">
          <legend>種類</legend>
            第<input type="text" class="kind-in" name="num" <?php echo "value=\"" . $set['num'] . "\" "; ?>onkeypress="return submitStop(event);" />回
            <input type="radio" id="kind-s" name="kind" value="sokai" <?php if (preg_match("/^sokai$/",$set['kind'])) { echo "checked=\"checked\" "; } ?>/><label for="kind-s">総会</label>
            <input type="radio" id="kind-k" name="kind" value="kochokai" <?php if (preg_match("/^kochokai$/",$set['kind'])) { echo "checked=\"checked\" "; } ?>/><label for="kind-k">公聴会</label>
        </fieldset>
        <fieldset class="num-sys">
          <legend>票数表示</legend>
            <input type="radio" id="cal-a" name="cal" value="auto" <?php if (preg_match("/^auto$/",$set['cal'])) { echo "checked=\"checked\" "; } ?>/><label for="cal-a">受付データベースからの自動計算</label>
            <input type="radio" id="cal-m" name="cal" value="manual" <?php if (preg_match("/^manual/",$set['cal'])) { echo "checked=\"checked\" "; } ?>/><label for="cal-m">手動入力</label>
        </fieldset>
        <fieldset class="add-sys">
          <legend>ユーザー登録</legend>
            <input type="radio" id="add-y" name="add" value="yes" <?php if (preg_match("/^yes$/",$set['add'])) { echo "checked=\"checked\" "; } ?>/><label for="add-y">許可</label>
            <input type="radio" id="add-n" name="add" value="no" <?php if (preg_match("/^no$/",$set['add'])) { echo "checked=\"checked\" "; } ?>/><label for="add-n">不許可</label>
        </fieldset>
        <fieldset class="tab-sys">
          <legend>データベースリセット</legend>
<?php


$sql = "select id from " . $tablename_chat;
$res = mysql_query($sql,$conn) or die("データ抽出エラー");
$num = mysql_num_rows($res);

echo "<input type=\"checkbox\" id=\"t-c\" name=\"tabledel[]\" value=\"chattable\" onclick=\"TableCheckConfirm(0);\" /><label for=\"t-c\">鈴木ったーデータベース<span class=\"num\">(投稿数:" . $num . "件)</span></label><br />\n";

$sql = "select id from " . $tablename_num;
$res = mysql_query($sql,$conn) or die("データ抽出エラー");
$num = mysql_num_rows($res);

echo "<input type=\"checkbox\" id=\"t-n\" name=\"tabledel[]\" value=\"numtable\" onclick=\"TableCheckConfirm(1);\" /><label for=\"t-n\">場内・議長委任票数データベース<span class=\"num\">(投稿数:" . ($num - 1) . "件)</span></label><br />\n";

$sql = "select id from " . $tablename_ele . " where kind = 'vote-main' or kind = 'vote-sub'";
$res = mysql_query($sql,$conn) or die("データ抽出エラー");
$num = mysql_num_rows($res);

echo "<input type=\"checkbox\" id=\"t-e\" name=\"tabledel[]\" value=\"eletable\" onclick=\"TableCheckConfirm(2);\" /><label for=\"t-e\">選挙票数データベース<span class=\"num\">(投稿数:" . $num . "件)</span></label><br />\n";

$sql = "select student_id from " . $tablename_account . " where status != ''";
$res = mysql_query($sql,$conn) or die("データ抽出エラー");
$num = mysql_num_rows($res);

echo "<input type=\"checkbox\" id=\"t-as\" name=\"tabledel[]\" value=\"accstatus\" onclick=\"TableCheckConfirm(3);\" /><label for=\"t-as\">学友会員名簿出席状況データベース<span class=\"num\">(状況変更人数:" . $num . "人)</span></label><br />\n";

$sql = "select student_id from " . $tablename_account;
$res = mysql_query($sql,$conn) or die("データ抽出エラー");
$num = mysql_num_rows($res);

echo "<input type=\"checkbox\" id=\"t-at\" name=\"tabledel[]\" value=\"acctable\" onclick=\"TableCheckConfirm(4);\" /><label for=\"t-at\">学友会員データベース<span class=\"num\">(登録人数:" . $num . "人)</span></label><br />";

$sql = "select id from " . $tablename_aud;
$res = mysql_query($sql,$conn) or die("データ抽出エラー");
$num = mysql_num_rows($res);

echo "<input type=\"checkbox\" id=\"t-at\" name=\"tabledel[]\" value=\"acctable\" onclick=\"TableCheckConfirm(4);\" /><label for=\"t-at\">傍聴者データベース（使用不可）<span class=\"num\">(登録人数:" . $num . "人)</span></label>";


?>
		</fieldset>
		<fieldset class="list-sys">
          <legend>学友会員名簿インポート/エクスポート</legend>
            <input type="file" name="upfile" />
            <input type="submit" name="account" value="エクスポート" onclick="return Download();" />
        </fieldset>
        <fieldset class="list-sys">
          <legend>ユーザーインポート/エクスポート</legend>
            <input type="file" name="userfile" />
            <input type="submit" name="user" value="エクスポート" onclick="return Download();" />
        </fieldset>
        <div class="setup">
          <input type="submit" onsubmit="this.disabled=true;return true;" value="設定" />
        </div>
      </form>
    </div><!--main:end-->
