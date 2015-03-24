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
			showNoResultsMessage(tiles[0]);
		}
		else {
			hideNoResultsMessage(tiles[0])
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
	hideNoResultsMessage(tiles[0]);
}

function inFilter() {
	return true;
}

function showNoResultsMessage(tile) {
	if (tile.parentNode.className.indexOf(" fullWidth") == -1) {
		tile.parentNode.className = tile.parentNode.className + " fullWidth";
	}
	tile.parentNode.querySelector(".scrollerPlaceholder").className = tile.parentNode.querySelector(".scrollerPlaceholder").className.replace(" displayNone", "");	
	tile.parentNode.querySelector(".scrollerPlaceholder").className = tile.parentNode.querySelector(".scrollerPlaceholder").className.replace(" hideTile", "");
}

function hideNoResultsMessage(tile) {
	tile.parentNode.className = tile.parentNode.className.replace(" fullWidth", "");
	if (tile.parentNode.querySelector(".scrollerPlaceholder").className.indexOf(" displayNone") == -1) {
		tile.parentNode.querySelector(".scrollerPlaceholder").className = tile.parentNode.querySelector(".scrollerPlaceholder").className + " displayNone";
	}
	if (tile.parentNode.querySelector(".scrollerPlaceholder").className.indexOf(" hideTile") == -1) {
		tile.parentNode.querySelector(".scrollerPlaceholder").className = tile.parentNode.querySelector(".scrollerPlaceholder").className + " hideTile";
	}
}