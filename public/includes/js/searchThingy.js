/**
 * Search functionality for filtering tiles.
 *
 * Matt Weeks
 */

function searchTiles(frameSelector, filters, stringFind, tileClass) {
	if (window.tileView == undefined || tileView == true) {
		var $frame = $(frameSelector);
		removeEDR(filters, stringFind, tileClass);
		$frame.sly('reload');
	}
}

function removeEDR(filters, stringFind, tileClass) {
	if (stringFind != "" || filters != "") {
		var tiles = document.getElementsByClassName(tileClass);
		var numResults = 0;
		var tileTitle = "", tileText = "";
		for (var i = 0; i < tiles.length; i++) {
			var tile = tiles[i];
			tile.className = tile.className.replace(" hideTile", "");
			tileTitle = tile.querySelector(".tile-title").firstChild.innerText;
			if (tile.querySelector(".tileSubText")) {
				tileText = tile.querySelector(".tileSubText").firstChild.innerText;
			}
			else {
				tileText = "";
			}
			searchFields = [tileTitle,tileText];
			// Tile passes through filter and title/subtext contain the requested string.
			if (!(passesFilter(filters, tile.className) && passesSearch(stringFind, searchFields))) {
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
	for (var i = 0; i < tiles.length; i++) {
		var tile = tiles[i];
		tile.className = tile.className.replace(" hideTile", "");
	}
	hideNoResultsMessage(tiles[0]);
}

function passesFilter(filters, tileClasses) {
	if (filters != "") {
		filters = JSON.parse(filters);
		for (var i = 0; i < filters.filters.length; i++) {
	 		if (filters.filters[i].value == "false") {
	 			if (tileClasses.indexOf(filters.filters[i].class) > -1) {
	 				return false;
	 			}
	 		}
		}
	}
	else {
		return true;
	}
	return true;
}

function passesSearch(stringFind, searchFields) {
	if (stringFind != "") {
		for (var i = 0; i < searchFields.length; i++) {
			if (searchFields[i] != "") {
				if (searchFields[i].toUpperCase().indexOf(stringFind.toUpperCase()) > -1) {
					return true;
				}
			}
		}
		return false;
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