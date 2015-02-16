/**
 * Created by house on 16/02/15.
 */
var changes = {};

function pushChanges() {
	console.log("Saving changes:")
	console.log(changes);
	for(var p in changes) {
		console.log(changes[p]);
		changes[p].callback(changes[p].data);
	}
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