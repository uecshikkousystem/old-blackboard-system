<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");
mb_http_input("auto");

  $url = "localhost";
  $user = "shikkou";
  $pass = "shikkoupass";
  $db = "shikkoudb";

  // MySQLへ接続する
  $link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");


if (version_compare(PHP_VERSION,'5.2.0') >= 0) {   
     mysql_set_charset("utf8",$link);
} else {  
      mysql_query("SET NAMES utf8",$link);
}



  // データベースを選択する
  $sdb = mysql_select_db($db,$link) or die("データベースの選択に失敗しました。");

  // クエリを送信する
  $sql = "SELECT * FROM audience";
  $result = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);


  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);
//echo $rows; //debug

  //表示するデータを作成
  if($rows){
    while($row = mysql_fetch_array($result)) {
      $tempHtml .= "<tr>";
      $tempHtml .= "<td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["che"]."</td><td>".$row["ok"]."</td>";
      $tempHtml .= "</tr>\n";
    }
    $msg = $rows."件のデータがあります。";
  }else{
    $msg = "データがありません。";
  }

//echo $msg; //debug
//echo  $tempHtml; //debug

  //結果保持用メモリを開放する
  mysql_free_result($result);

  // MySQLへの接続を閉じる
  mysql_close($link) or die("MySQL切断に失敗しました。");
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>全件表示</title>
  </head>
  <body>
    <h3>全件表示</h3>
    <?php echo $msg ?>
    <table width = "200" border = "0">
      <tr bgcolor="##ccffcc"><td>PREF_CD</td><td>PREF_NAME</td><td>check</td><td>entrance</td></tr>
      <?php echo $tempHtml ?>
    </table>
  </body>
</html>
