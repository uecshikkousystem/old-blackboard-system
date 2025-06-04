<?php
  $url = "localhost";
  $user = "shikkou";
  $pass = "shikkou";
  $db = "shikkou";

  // MySQLへ接続すめE  $link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました、E);

  // チE�Eタベ�Eスを選択すめE  $sdb = mysql_select_db($db,$link) or die("チE�Eタベ�Eスの選択に失敗しました、E);

  // クエリを送信する
  $sql = "SELECT * FROM audience";
  $result = mysql_query($sql, $link) or die("クエリの送信に失敗しました、Ebr />SQL:".$sql);

  //結果セチE��の行数を取得すめE  $rows = mysql_num_rows($result);

  //表示するチE�Eタを作�E
  if($rows){
    while($row = mysql_fetch_array($result)) {
      $tempHtml .= "<tr>";
      $tempHtml .= "<td>".$row["id"]."</td><td>".$row["PREF_NAME"]."</td>";
      $tempHtml .= "</tr>\n";
    }
    $msg = $rows."件のチE�Eタがあります、E;
  }else{
    $msg = "チE�Eタがありません、E;
  }

  //結果保持用メモリを開放する
  mysql_free_result($result);

  // MySQLへの接続を閉じめE  mysql_close($link) or die("MySQL刁E��に失敗しました、E);
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=SHIFT-JIS">
    <title>全件表示</title>
  </head>
  <body>
    <h3>全件表示</h3>
    <?= $msg ?>
    <table width = "200" border = "0">
      <tr bgcolor="##ccffcc"><td>PREF_CD</td><td>PREF_NAME</td></tr>
      <?= $tempHtml ?>
    </table>
  </body>
</html>
