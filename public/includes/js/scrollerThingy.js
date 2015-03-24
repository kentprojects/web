/**
 * Created by house on 12/02/15.
 */
function scrollerTile(item, type, addStyle) {
	var classList = "", lockedHTML = "", statusHTML= "", tileHTML = [], tileImage = "";
	// If colour required add to class list.
	if (addStyle) {
		if ((type == "student")) {
			// If in a group.
			if (item.group != null) {
				// If has a project.
				if (item.group.project != null) {
					classList += " greenStatus"; //classList += " greenTile";
				}
				else {
					classList += " yellowStatus"; //classList += " yellowTile";
				}
			}
			else {
				classList += " redStatus"; //classList += " redTile";
				//statusHTML += "<div class='circleStatus redStatus'></div>";
			}
		}
		else if ((type == "project") && (item.group != null)) {
			lockedHTML = "<span class='banner'>Taken</span>";
		}
		else if (type == "group") {
			// If project.
			if (item.project != null) {
				classList += " greenStatus"; //classList += " greenTile";
			}
			else {
				classList += " yellowStatus"; //classList += " yellowTile";
			}
		}
	}
	// If image then add image tag
	if (item.role)  { tileImage = '<span class="tileImage"><img class="tilePic" src="/uploads/' + md5(item.email) + '"/></span>'; }
	else { tileImage = ''};
	// Set class list
	classList = " class='tileLi tileLi" + type + classList + "'";

	// Create tile from HTML segments and return as a string.
	tileHTML.push(
		'<li ' + classList + '>',
		'<div class="fillLi">',
		'<div class="tile-title"><a href="/profile.php?type=' + type + '&id='+ item.id + '">' + item.name + '</a></div>',
		tileImage,
		lockedHTML,
		statusHTML,
		'</a>',
		'</div>',
		'</li>'
	);
	return tileHTML.join("");
}

function scrollerHTML(data, type, addStyle) {
	if (data && data.length > 0) {
		var item, HTML = [];
		for (var i = 0; i < data.length; i++) {
			item = data[i];
			HTML.push(scrollerTile(item, type, addStyle));
		}
		HTML.push('<div class="scrollerPlaceholder noBottomMargin displayNone hideTile"><div class="text-info text-center">There\'s nothing to show here...</div></div>');
		return HTML.join("");
	}
	else {
		return false;
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

function generateScroller(ulClass, data, type, addStyle) {
	var scroller = scrollerHTML(data, type, addStyle);
	if (!scroller) {
		//Set max size of thing.
		document.querySelector(ulClass).className = document.querySelector(ulClass).className + " fullWidth";
		return '<div class="scrollerPlaceholder noBottomMargin displayNone"><div class="text-info text-center">There\'s nothing to show here...</div></div>';
	}
	else {
		return scroller;
	}
}