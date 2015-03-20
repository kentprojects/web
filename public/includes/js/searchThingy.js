/**
 * Search functionality for filtering tiles.
 *
 * Matt Weeks
 */

function stuff() {
	var $frame = $('#projectScroller');
	removeEDR(document.getElementById('navbarInput-01').value, "tileLiproject");
	$frame.sly('reload');
}

function removeEDR(stringFind, tileClass) {
	if (stringFind != "") {
		var tiles = document.getElementsByClassName(tileClass);
		for (i = 0; i < tiles.length; i++) {
			var tile = tiles[i];
			tile.className = tile.className.replace(" hideTile", "");
			if (tile.firstChild.innerText.toUpperCase().indexOf(stringFind.toUpperCase()) == -1) {
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