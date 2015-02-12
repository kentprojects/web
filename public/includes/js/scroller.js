/**
 * Created by house on 12/02/15.
 */
function scrollerHTML(data) {
	if (data.body.length > 0) {
		var item, HTML = [];
		for (var i = 0; i < data.body.length; i++) {
			item = data.body[i];
			HTML.push(
				'<li class="sideScrollerItem noBottomMargin">',
				'<div class="tile scrollerTile noBottomMargin">',
				'<div class="tile-title">' + item.name + '</div>',
				'</div>',
				'</li>'
			);
		}
		return HTML.join("");
	}
	else {
		return '<div class="scrollerPlaceholder noBottomMargin"><div class="text-info"> There\'s nothing here yet! </div></div>';
	}
}