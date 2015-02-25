/**
 * Created by house on 12/02/15.
 */
function scrollerHTML(data, type) {
	if (data.length > 0) {
		var item, HTML = [];
		for (var i = 0; i < data.length; i++) {
			item = data[i];
			HTML.push(
				'<li>',
				'<div class="tile-title"><a href="/profile.php?type=' + type + '&id='+ item.id + '">' + item.name + '</a></div>',
				'</div>',
				'</li>'
			);
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