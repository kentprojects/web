/**
 * Search functionality for filtering tiles.
 *
 * Matt Weeks
 */


function stuff() {
	removeEDR(document.getElementById('navbarInput-01').value, "tileLiproject");
}

function removeEDR(stringFind, tileClass) {
	if (stringFind != "") {
		var tiles = document.getElementsByClassName(tileClass);
		for (i = 0; i < tiles.length; i++) {
			var tile = tiles[i];
			tile.className = tile.className.replace(" hideTile", "");
			// console.log(tile.firstChild.innerText)
			if (tile.firstChild.innerText.indexOf(stringFind) == -1) {
				tile.className = tile.className + " hideTile";
			}
		}
	}
	else {
		clearSearch(tileClass);
	}
}

function clearSearch(tileClass) {
	var tiles = document.getElementsByClassName(tileClass);
	for (i = 0; i < tiles.length; i++) {
		var tile = tiles[i];
		tile.className = tile.className.replace(" hideTile", "");
	}
}