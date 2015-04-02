/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */


function searchTiles(frameSelector, filters, stringFind, tileClass) {
	if (window.tileView == undefined || tileView == true) {
		var $frame = $(frameSelector);
		removeEDR(filters, stringFind, tileClass);
		$frame.sly('reload');
	}
	else {
		removeEDRLists(filters, stringFind, tileClass);
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

function removeEDRLists(filters, stringFind, tileClass) {
	if (stringFind != "" || filters != "") {
		var rows = document.getElementsByClassName(tileClass);
		var numResults = 0;
		var rowTitle = "", rowText = "";
		for (var i = 0; i < rows.length; i++) {
			var row = rows[i];
			row.className = row.className.replace(" displayNone", "");
			rowTitle = row.querySelector(".rowTitle").firstChild.innerText;
			if (row.querySelector(".rowSubText")) {
				rowText = row.querySelector(".rowSubText").firstChild.innerText;
			}
			else {
				rowText = "";
			}
			searchFields = [rowTitle,rowText];
			// Row passes through filter and title/subtext contain the requested string.
			if (!(passesFilter(filters, row.className) && passesSearch(stringFind, searchFields))) {
				row.className = row.className + " displayNone";
			}
			else {
				numResults += 1;
			}
		}
		// Show message/hide message
		if (numResults == 0) {
			document.querySelector(".nothingToShow").className = document.querySelector(".nothingToShow").className.replace(" displayNone", "");
			document.querySelector(".listTable").className = document.querySelector(".listTable").className.replace(" displayNone", "");
			document.querySelector(".listTable").className += " displayNone";
		}
		else {
			document.querySelector(".nothingToShow").className = document.querySelector(".nothingToShow").className.replace(" displayNone", "");
			document.querySelector(".nothingToShow").className += " displayNone";
			document.querySelector(".listTable").className = document.querySelector(".listTable").className.replace(" displayNone", "");
		}
	}
	else {
		clearSearchLists(tileClass);
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

function clearSearchLists(tileClass) {
	var rows = document.getElementsByClassName(tileClass);
	for (var i = 0; i < rows.length; i++) {
		var row = rows[i];
		row.className = row.className.replace(" displayNone", "");
	}
	document.querySelector(".nothingToShow").className = document.querySelector(".nothingToShow").className.replace(" displayNone", "");
	document.querySelector(".nothingToShow").className += " displayNone";
	document.querySelector(".listTable").className = document.querySelector(".listTable").className.replace(" displayNone", "");
}

function hideSearchLists(tileClass) {
	var tiles = document.getElementsByClassName(tileClass);
	for (var i = 0; i < tiles.length; i++) {
		var tile = tiles[i];
		tile.className += " displayNone";
	}
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