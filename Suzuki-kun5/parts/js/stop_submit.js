function submitStop(e) {
	if (!e) {
		var e = window.event;
	}
 
    if (e.charCode == 13) {
		return false;
	}
}