<?php

if ($row_usingnow['kind'] == 3) {
	
	echo "<div class=\"open-com\"><p>";
	
	if ($set['kind'] !== 'kochokai')
		echo "誘導係の指示に従い、所定の席へお座りください。<br />";
		
	echo "開会までしばらくお待ちください。</p>";	
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
	
	echo "<div class=\"open-com\">";
	echo "<p>閉会しました。";
	
	if ($set['kind'] !== 'kochokai')
		echo "<br />参加者カードを受付に返却し、お帰りください。";
	
	echo "</p>";
	echo "</div>";
	
}