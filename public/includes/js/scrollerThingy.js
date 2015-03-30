/**
 * Created by house on 12/02/15.
 */
function scrollerTile(item, type, addStyle) {
	var classList = "", lockedHTML = "", tileHTML = [], tileImage = "", subText = "";
	// If colour required add to class list.
	if (addStyle) {
		if ((type == "student")) {
			// If in a group.
			if (item.group != null) {
				// If has a project.
				if (item.group.project != null) {
					// If my project.
					if (item.group.project.supervisor.id == me.user.id) {
						classList += " blueStatus";
					}
					else {
						classList += " greenStatus";
					}
				}
				else {
					classList += " yellowStatus";
				}
			}
			else {
				classList += " redStatus";
			}
		}
		else if (type == "project") {
			subText = '<span class="tileSubText"><a href="/profile.php?type=staff&id='+ item.supervisor.id + '">' + item.supervisor.name + '</a></span>';
			if (item.group != null) {
				classList += " projectTaken";
				lockedHTML = "<span class='banner'><a href='/profile.php?type=group&id=" + item.group + "'>Taken</a></span>";
			}
			else {
				classList += " projectNotTaken";
			}
			if (item.supervisor.id == me.user.id) {
				classList += " blueStatus";
			}
			else {
				classList += " notBlueStatus";
			}
		}
		else if (type == "group") {
			// If project.
			if (item.project != null) {
				subText = '<span class="tileSubText"><a href="/profile.php?type=project&id='+ item.project.id + '">' + item.project.name + '</a></span>';
				if (item.project.supervisor.id == me.user.id) {
					classList += " blueStatus";
				}
				else {
					classList += " greenStatus";
				}
			}
			else {
				classList += " yellowStatus";
			}
		}
	}
	// If image then add image tag
	//if (item.role)  { tileImage = '<span class="tileImage"><img class="tilePic" src="/uploads/' + md5(item.email) + '"/></span>'; }
	if (item.role)  { tileImage = '<span class="tileImage"><div><a href="/profile.php?type=' + item.role + '&id=' + item.id + '"><img class="tilePic" src="/uploads/' + md5(item.email) + '"/></a></div></span>'; }
	else { tileImage = ''};
	// Set class list
	classList = " class='tileLi tileLi" + type + classList + "'";

	// Create tile from HTML segments and return as a string.
	tileHTML.push(
		'<li ' + classList + '>',
		'<div class="fillLi">',
		tileImage,
		lockedHTML,
		'<div class="tile-title"><a href="/profile.php?type=' + type + '&id='+ item.id + '">' + item.name + '</a></div>',
		subText,
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