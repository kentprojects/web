var infoHidden = true;

function switchInfoVisibility() {
	if (infoHidden) {
		showInfo();
	}
	else {
		hideInfo();
	}
	switchButton();
}

function hideInfo() {
	infoHidden = true;
	alert("Hide info.");
}

function showInfo() {
	infoHidden = false;
	alert("Show info.");
}

function switchButton() {
	alert("Switch button.");
}