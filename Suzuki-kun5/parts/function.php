<?php

function char_change($string) {
	
	$string = mb_convert_kana($string,"C","UTF-8");
	
	$string = preg_replace("/\s/","",$string);
	$string = preg_replace("/　/","",$string);
	
	return $string;
	
}

function cnv_dbstr($string) {
	
    $string = htmlspecialchars($string);

    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
	
	$string = preg_replace("/(\r\n|\n|\r)/"," ",$string);

    $string = mysql_real_escape_string($string);
	
    return $string;
	
}

function cnv_dbstr_acnt($string) {

    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
	
	$string = preg_replace("/(\r\n|\n|\r|\s|\t)/","",$string);
    
	$string = mysql_real_escape_string($string);
	
    return $string;
	
}

function chat_dbstr($string) {
	
    $string = htmlspecialchars($string);

    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
	
	$string = preg_replace("/(\r\n|\n|\r)/","<br />",$string);

    $string = mysql_real_escape_string($string);
	
    return $string;
	
}

function f_parts_change($string) {
	
	$string = preg_replace("/&lt;/u","∧",$string);
	$string = preg_replace("/&gt;/u","∨",$string);
	
	$string = mb_convert_kana($string,"AKV","UTF-8");
	
	return $string;
	
}

function parts_change($string) {
	
	$string = preg_replace("/([０-９ａ-ｚＡ-Ｚ])/u","<div>$1</div>",$string);
	
	$string = preg_replace("/( |　)/u","<div class=\"space\"><hr /></div>",$string);
	
	$string = preg_replace("/(．|。)/u","<div class=\"mark\">。</div>",$string);
	$string = preg_replace("/(，|、)/u","<div class=\"mark\">、</div>",$string);
	$string = preg_replace("/(〜|～)/u","<div class=\"kara\">$1</div>",$string);
	$string = preg_replace("/（/u","<div>&#65077;</div>",$string);
	$string = preg_replace("/）/u","<div>&#65078;</div>",$string);
	$string = preg_replace("/「/u","<div>&#65089;</div>",$string);
	$string = preg_replace("/」/u","<div>&#65090;</div>",$string);
	$string = preg_replace("/∧/u","<div>&#65087;</div>",$string);
	$string = preg_replace("/∨/u","<div>&#65088;</div>",$string);
	$string = preg_replace("/：/u","<div>‥</div>",$string);
	$string = preg_replace("/…/u","<div>&#65049;</div>",$string);
	$string = preg_replace("/(・|＊|？|！|％)/u","<div>$1</div>",$string);
	$string = preg_replace("/＝/u","<div>&#8214;</div>",$string);
	
	$string = preg_replace("/ー/","<div class=\"bar\">|</div>",$string);
	
	$string = preg_replace("/(々|〃|仝|ヽ|ヾ|ゝ|ゞ|〆)/","<div>$1</div>",$string);
	
	$string = preg_replace("/っ/u","<div class=\"small\">っ</div>",$string);
	$string = preg_replace("/ッ/u","<div class=\"small\">ッ</div>",$string);
	
	$string = preg_replace("/ぁ/u","<div class=\"small\">ぁ</div>",$string);
	$string = preg_replace("/ぃ/u","<div class=\"small\">ぃ</div>",$string);
	$string = preg_replace("/ぅ/u","<div class=\"small\">ぅ</div>",$string);
	$string = preg_replace("/ぇ/u","<div class=\"small\">ぇ</div>",$string);
	$string = preg_replace("/ぉ/u","<div class=\"small\">ぉ</div>",$string);
	
	$string = preg_replace("/ゃ/u","<div class=\"small\">ゃ</div>",$string);
	$string = preg_replace("/ゅ/u","<div class=\"small\">ゅ</div>",$string);
	$string = preg_replace("/ょ/u","<div class=\"small\">ょ</div>",$string);
	
	$string = preg_replace("/ァ/u","<div class=\"small\">ァ</div>",$string);
	$string = preg_replace("/ィ/u","<div class=\"small\">ィ</div>",$string);
	$string = preg_replace("/ゥ/u","<div class=\"small\">ゥ</div>",$string);
	$string = preg_replace("/ェ/u","<div class=\"small\">ェ</div>",$string);
	$string = preg_replace("/ォ/u","<div class=\"small\">ォ</div>",$string);
	
	$string = preg_replace("/ャ/u","<div class=\"small\">ャ</div>",$string);
	$string = preg_replace("/ュ/u","<div class=\"small\">ュ</div>",$string);
	$string = preg_replace("/ョ/u","<div class=\"small\">ョ</div>",$string);

	return $string;
	
}

function name_change($string) {
	
	$aryname = array('gene' => '一般', 'writer' => '黒板(入力者)', 'editer' => '黒板(編集者)', 'info' => '受付', 'infoadmin' => '受付(管理者)', 'chairman' => '議長', 'output' => 'プロジェクター表示専用', 'admin' => 'システム管理', 'all' => '全ユーザー');
	
	foreach ($aryname as $key => $value) {
		$string = preg_replace("/^$key$/","$value",$string);
	}
	
	return $string;
}

function position_select($string) {
	$aryname = array('gene' => '一般', 'writer' => '黒板(入力者)', 'editer' => '黒板(編集者)', 'info' => '受付', 'infoadmin' => '受付(管理者)', 'chairman' => '議長', 'output' => 'プロジェクター表示専用', 'admin' => 'システム管理');
	
	$select = "<select name=\"position\">";
	foreach ($aryname as $key => $value) {
		if (preg_match("/^$key$/", $string)) {
			$select .= "<option value=\"" . $key . "\" selected=\"selected\">" . $value . "</option>";
		} else {
			$select .= "<option value=\"" . $key . "\">" . $value . "</option>";
		}
	}
	$select .= "</select>";
	
	return $select;
}

?>
