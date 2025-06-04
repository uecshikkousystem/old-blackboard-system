function DeleteUser(id) {
	var request = new XMLHttpRequest();
	var url = "../auth/user_edit.php?user=del&id=" + id;
	
	request.open("GET", url, true);
	request.send(null);
	request.onreadystatechange = readyStateChangeHandler;
	 
	function readyStateChangeHandler() {
		if ((request.readyState == 4) && (request.status == 200)) {
			location.reload();
		}
	}
}

function TableCheckConfirm(num) {
	if (document.conf.elements['tabledel[]'][num].checked) {
		if (window.confirm('本当にこのデータベースをリセットしてよろしいですか？')) {
			return true;
		} else {
			document.conf.elements['tabledel[]'][num].checked = false;
			return false;
		}
	}
}

function DropConfirm() {
	if (window.confirm('本当にこのテーブルを削除してよろしいですか？')) {
		return true;
	} else {
		return false;
	}
}

function DeleteConfirm() {
	if (window.confirm('本当にこの立候補者を削除してよろしいですか？')) {
		return true;
	} else {
		return false;
	}
}

function Download() {
	if (window.confirm('ダウンロードを初めてよろしいですか？')) {
		return true;
	} else {
		return false;
	}
}