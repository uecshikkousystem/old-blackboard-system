<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");

if ($row_usingnow['kind'] == 1) {
	require_once("../../parts/function.php");
	require_once("./ordi_index.php");
} else if ($row_usingnow['kind'] == 2) {
	require_once("../../parts/function.php");
	require_once("./ele_index.php");
} else if ($row_usingnow['kind'] == 3 or $row_usingnow['kind'] == 4 or $row_usingnow['kind'] == 5 or $row_usingnow['kind'] == 6) {
	require_once("../../parts/com_info.php");
	require_once("./close_index.php");
}

?>