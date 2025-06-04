    <div class="main">
<?php

if ($row_usingnow['kind'] == 1) {
	echo "<form class=\"form\" method=\"post\" action=\"motion_write.php\">";
	echo "<div class=\"motion\">";
	echo "<fieldset>";
	echo "<legend";

	if (preg_match("/^motion_re$/",$_SESSION['status'])) {
		echo " class=\"error\"";
	}
	
	echo ">動議</legend>";
	echo "<div class=\"motion-in\">";
	echo "<input type=\"radio\" name=\"motion\" id=\"motion-k\" value=\"kyukai\"/><label for=\"motion-k\">休会動議</label>";
	echo "<input type=\"radio\" name=\"motion\" id=\"motion-h\" value=\"horyu\" /><label for=\"motion-h\">保留動議</label>";
	echo "<input type=\"radio\" name=\"motion\" id=\"motion-y\" value=\"yokyu\" /><label for=\"motion-y\">採決要求動議</label>";
	echo "<input type=\"radio\" name=\"motion\" id=\"motion-t\" value=\"tekkai\" /><label for=\"motion-t\">撤回動議</label>";
	echo "</div></fieldset></div>";
	echo "<div class=\"submit\">";
	echo "<input type=\"submit\" value=\"　動議入力　\" />";
	echo "</div>";
	echo "</form>";
}

?>
    </div><!--main:end-->