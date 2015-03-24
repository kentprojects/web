/**
 * Created by house on 12/02/15.
 */
function scrollerTile(item, type, addStyle) {
	var classList = "", lockedHTML = "", statusHTML= "", tileHTML = [], tileImage = "";
	// If colour required add to class list.
	// If tile locked add locked to class list.
	if (addStyle) {
		if ((type == "student")) {
			// If group.
			if (item.group != null) {
				// If project.
				if (item.group.project != null) {
					//classList += " greenTile";
					classList += " greenStatus";
					//statusHTML += "<div class='circleStatus greenStatus'></div>";
				}
				else {
					//classList += " yellowTile";
					classList += " yellowStatus";
					//statusHTML += "<div class='circleStatus yellowStatus'></div>";
				}
			}
			else {
				//classList += " redTile";
				classList += " redStatus";
				//statusHTML += "<div class='circleStatus redStatus'></div>";
			}
		}
		else if ((type == "project") && (item.group != null)) {
			//classList += " lockTile";
			lockedHTML = "<span class='banner'>Taken</span>";
		}
		else if (type == "group") {
			// If project.
			if (item.project != null) {
				//classList += " greenTile";
				classList += " greenStatus";
				//statusHTML += "<div class='circleStatus greenStatus'></div>";
			}
			else {
				classList += " yellowStatus";
				//classList += " yellowTile";
				//statusHTML += "<div class='circleStatus yellowStatus'></div>";
			}
		}
	}
	// If image then add image tag
	if (item.role)  { tileImage = '<img class="tilePic" src="/uploads/' + md5(item.email) + '"/>'; }
	else { tileImage = ''};
	// Set class list
	classList = " class='tileLi tileLi" + type + classList + "'";

	// Create tile from HTML segments and return as a string.
	tileHTML.push(
		// id="' + type + item.id + '"' + classList + ' onclick="openLink(\'' + type + item.id + '\');">',
		// '<a id="' + type + item.id + '" class="tileLink" href="javascript:openLink(\'' + type + item.id + '\');"></a>',
		'<li ' + classList + '>',
		'<div class="tile-title"><a href="/profile.php?type=' + type + '&id='+ item.id + '">' + item.name + '</a></div>',
		tileImage,
		lockedHTML,
		statusHTML,
		'</a>',
		'</li>'
	);
	return tileHTML.join("");
}

// function openLink(x) {
// 	console.log(document.getElementById(x));
// 	console.log(document.getElementById(x).parentNode);

// 	var myNode = document.getElementById(x);
// 	console.log('x1: ' + myNode.offsetLeft);
// 	console.log('y1: ' + myNode.offsetTop);
// 	console.log('x2: ' + (myNode.offsetLeft + myNode.offsetWidth));
// 	console.log('y2: ' + (myNode.offsetTop + myNode.offsetHeight));

// 	var parentNode = document.getElementById(x).parentNode;
// 	console.log('x1: ' + parentNode.offsetLeft);
// 	console.log('y1: ' + parentNode.offsetTop);
// 	console.log('x2: ' + (parentNode.offsetWidth));
// 	console.log('y2: ' + (parentNode.offsetHeight));

// 	console.log(window.getComputedStyle(parentNode).getPropertyValue('transform'));

// 	var matrix = window.getComputedStyle(parentNode).getPropertyValue('transform');

//     if(matrix !== 'none') {
//         var values = matrix.toString();
//         var translationValue = parseInt(values.split(",")[4].substr(1));
//         console.log(translationValue);

//         Discus thin page / mobile view handling.
//     }
// }

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












