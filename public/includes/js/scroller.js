/**
 * Created by house on 12/02/15.
 */
function scrollerTile(item, type) {
	var classList = "", tileHTML = [], tileImage = "";
	// If colour required add to class list.
	// If tile locked add locked to class list.
	if ((type == "student")) {
		if (item.group != null) {
			// Padlock tile
			classList += " statusX";
		}
	}
	else if ((type == "project") && (item.group != null)) {
		classList += " lockTile";	
	}
	else if (type == "group") {
		classList += " locked";
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
		'</li>'
	);
	return tileHTML.join("");
}

function scrollerHTML(data, type) {
	console.log(type);
	console.log(data);
	if (data.length > 0) {
		var item, HTML = [];
		for (var i = 0; i < data.length; i++) {
			item = data[i];
			HTML.push(scrollerTile(item, type));
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