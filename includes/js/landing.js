var infoHidden = true;

function switchInfoVisibility() {
	if (infoHidden) {
		showInfo();
	}
	else {
		hideInfo();
	}
}

function hideInfo() {
	infoHidden = true;
	document.getElementById("btnInfo").innerHTML = "?";
	document.getElementById("divInfo").style.display = "none";
	document.getElementById("btnInfo").className = document.getElementById("btnInfo").className.replace(/\bbtn-danger\b/, "btn-info");
}

function showInfo() {
	infoHidden = false;
	document.getElementById("btnInfo").innerHTML = "X";
	document.getElementById("divInfo").style.display = "block";
	document.getElementById("btnInfo").className = document.getElementById("btnInfo").className.replace(/\bbtn-info\b/, "btn-danger");
}