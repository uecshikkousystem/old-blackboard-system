<?php

if ($row_usingnow['kind'] == 3) {
	
	echo "<div class=\"open-com\"><p>";
	
	//if ($set['kind'] !== 'kochokai')
	echo "誘導係の指示に従い、所定の席へお座りください。<br />";
		
	//echo "マイクをミュートにして、開会までしばらくお待ちください。</p>";	
	echo "</div>";
	
} else if ($row_usingnow['kind'] == 4) {
	
	$sql_break = "select * from " . $tablename_tables . " where id = '3'";
	$res_break = mysql_query($sql_break, $conn);
	$row_break = mysql_fetch_array($res_break,MYSQL_ASSOC);
	$time = preg_replace("/^.+\((.+:.+)\)$/","$1",$row_break['question']);
	
	echo "<div class=\"open-com\">";
	echo "<p>休会中です。<br />" . $time . "から再開します。</p>";
	echo "</div>";
	
} else if ($row_usingnow['kind'] == 5) {
	
	//echo "<div class=\"open-com\"><p>";
	echo "<div style= \"width:1200px; margin-top:150px; font-size:45px; line-heigth:200%; letter-spacing:2px; text-align:center; float: right;\">";
	echo "<p>本日の総会は閉会しました。";
	
	if ($set['kind'] !== 'kochokai')
		echo "<br />参加者カードを受付に返却し、お帰りください。";
		//echo "<br />そのままご退出ください";
	echo "<br/>また、アンケートへの回答をお願いします。";
	
	echo "</p><p><br/><img src=\" ";
	
	$file ='https://lh3.googleusercontent.com/pw/AP1GczN0XHJu3iEBF8mmDr2wuqyVb_w5DQUDw4WDO5wcIchO4Qr_8ytm9UG84XdNWPpuk_50NRqdWY8P_hR075pPtkO-OJ2t54qiSli-9Q9_6Rw7iWI8CkdBUNc8LbPuAV9PGrfPXFk-gPbxWGac9jlgtGM=w294-h294-s-no-gm'; 
	echo $file;
	
	echo " \" height=\" 250\" width=\" 250 \" >";
	
	echo "</p>";
	echo "</div>";
	}
