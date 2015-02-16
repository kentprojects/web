/**
 * Created by house on 16/02/15.
 */
var changes = {};

function attemptReload() {
	if (Object.keys(changes).length < 1) {
		window.location.reload();
	}
}

function successfulChange(saveName) {
	delete changes[saveName];
};

function pushChanges() {
	for(var p in changes) {
		changes[p].callback(changes[p].data, function nextFunction() {
			successfulChange(p);
		});
	}
	setInterval(attemptReload, 200);
}

function queueChange(saveName, saveCallback) {
	if (!saveCallback) {
		console.error("No saveCallback.");
		return;
	}
	return function (saveData) {
		changes[saveName] = {
			callback: saveCallback,
			data: saveData
		};
		document.getElementById("changeOptions").style.display = "block";
	};
}