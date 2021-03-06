/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
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

function queueChange(saveName, saveData, saveCallback) {
	if (!saveCallback) {
		console.error("No saveCallback.");
		return;
	}
	changes[saveName] = {
		callback: saveCallback,
		data: saveData
	};
	document.getElementById("changeOptions").style.display = "block";
}

function queueMarkdownChange(saveName, saveCallback) {
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