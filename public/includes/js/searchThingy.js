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
		var tileTitle = "", tileText = "";
		for (i = 0; i < tiles.length; i++) {
			var tile = tiles[i];
			tile.className = tile.className.replace(" hideTile", "");
			tileTitle = tile.querySelector(".tile-title").firstChild.innerText;
			tileText = tile.querySelector(".tileSubText").firstChild.innerText;
			// Tile passes through filter and title/subtext contain the requested string.
			if (!inFilter("") || ((tileTitle.toUpperCase().indexOf(stringFind.toUpperCase()) == -1) && (tileText.toUpperCase().indexOf(stringFind.toUpperCase()) == -1))) {
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

function inFilter(filters) {
	if (filters != "") {
		//If not in filters, response is 
	}
	else {
		return true;
	}
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

// Search box styling fix!
// Focus state for append/prepend inputs
$('.input-group').on('focus', '.form-control', function () {
  $(this).closest('.form-group').addClass('focus');
}).on('blur', '.form-control', function () {
  $(this).closest('.form-group').removeClass('focus');
});