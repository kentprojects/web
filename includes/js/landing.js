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
	fadeOut("btnInfo", 100);
	document.getElementById("btnInfo").className = document.getElementById("btnInfo").className.replace(/\bbtn-danger\b/, "btn-info");
}

function fadeIn(elem, num) {
	document.getElementById("infoContainer").style.opacity = num/100;
	if (num < 100) {
		window.setTimeout(function(){fadeIn(elem, num+1)},4);
	}
}

function fadeOut(elem, num) {
	document.getElementById("infoContainer").style.opacity = num/100;
	if (num > 0) {
		window.setTimeout(function(){fadeOut(elem, num-1)},4);
	}
}

function showInfo() {
	infoHidden = false;
	document.getElementById("btnInfo").innerHTML = "X";
	fadeIn("btnInfo", 0);
	document.getElementById("btnInfo").className = document.getElementById("btnInfo").className.replace(/\bbtn-info\b/, "btn-danger");
}