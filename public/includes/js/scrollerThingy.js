/**
 * Created by house on 12/02/15.
 */
function scrollerTile(item, type, addStyle) {
	var classList = "", lockedHTML = "", tileHTML = [], tileImage = "";
	// If colour required add to class list.
	// If tile locked add locked to class list.
	if (addStyle) {
		if ((type == "student")) {
			// If group.
			if (item.group != null) {
				// If project.
				if (item.group.project != null) { 
					classList += " greenTile";
				}
				else {
					classList += " yellowTile";
				}
			}
			else {
				classList += " redTile";
			}
		}
		else if ((type == "project") && (item.group != null)) {
			//classList += " lockTile";
			lockedHTML = "<span class='banner'>Taken</span>";	
		}
		else if (type == "group") {
			// If project.
			if (item.project != null) { 
				classList += " greenTile";
			}
			else {
				classList += " yellowTile";
			}
		}
		// REMOVE BEFORE SUBMISSION
		if (item.name == "Declan Greenhalgh") {
			classList += " decTile";
		}
		// REMOVE BEFORE SUBMISSION
	}
	// If image then add image tag
	if (false)  { tileImage = "<img class='' id='' src=''/>"; }

	// Set class list
	if (classList != "") { classList = " class='" + classList + "'"; }

	// Create tile from HTML segments and return as a string.
	tileHTML.push(
		'<li' + classList + '>',
		'<div class="tile-title"><a href="/profile.php?type=' + type + '&id='+ item.id + '">' + item.name + '</a></div>',
		'</div>',
		lockedHTML,
		'</li>'
	);
	return tileHTML.join("");
}

function scrollerHTML(data, type, addStyle) {
	if (data.length > 0) {
		var item, HTML = [];
		for (var i = 0; i < data.length; i++) {
			item = data[i];
			HTML.push(scrollerTile(item, type, addStyle));
		}
		return HTML.join("");
	}
	else {
		return '<div class="scrollerPlaceholder noBottomMargin"><div class="text-info"> There\'s nothing to show here</div></div>';
	}
}

function scroller(element) {
	var $frame = $(element);
	var $wrap = $frame.parent();

	// Call Sly on frame
	$frame.sly({
		horizontal: 1,
		itemNav: 'basic',
		smart: 1,
		activateOn: 'click',
		mouseDragging: 1,
		touchDragging: 1,
		releaseSwing: 1,
		startAt: 0,
		scrollBar: $wrap.find('.scrollbar'),
		scrollBy: 1,
		pagesBar: $wrap.find('.pages'),
		activatePageOn: 'click',
		speed: 300,
		elasticBounds: 1,
		easing: 'easeOutExpo',
		dragHandle: 1,
		dynamicHandle: 1,
		clickBar: 1,

		// Buttons
		prevPage: $wrap.find('.prevPage'),
		nextPage: $wrap.find('.nextPage')
	});

	$(window).resize(function(e) {
		$frame.sly('reload');
	});
};