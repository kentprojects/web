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
		var numResults = 0;
		for (i = 0; i < tiles.length; i++) {
			var tile = tiles[i];
			tile.className = tile.className.replace(" hideTile", "");
			if (inFilter() && (tile.firstChild.innerText.toUpperCase().indexOf(stringFind.toUpperCase()) == -1)) {
				tile.className = tile.className + " hideTile";
			}
			else {
				numResults += 1;
			}
		}
		// If all tiles are hiden then show message to inform the user.
		if (numResults == 0) {
			console.log("No search/filter results, please relax your search to see more results. [CONVERT THIS TO A HTML THING]")
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

function inFilter() {
	return true;
}