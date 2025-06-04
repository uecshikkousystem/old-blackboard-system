function VerAlert() {
	alert("Version : 1.0.0");
}

function vinfo(e) {
	if (!e) {
		var e = window.event;
	}
	
	if (e.charCode == 86) {
		VerAlert();
		return false;
	}
}

function info(e) {
	if (!e) {
		var e = window.event;
	}
	
	if (e.charCode == 86) {
		VerAlert();
		return false;
	} else if (e.charCode == 77) {
		m();
		return false;
	}
}

function m() {
	alert("総会管理システム 鈴木くん 開発チームメンバー\n\nプログラム開発 : 鈴木啓真\nインフラストラクチャー : 高村成道\nインフラストラクチャー : 吉川竜太");
}
