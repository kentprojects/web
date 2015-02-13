/**
 * Created by house on 12/02/15.
 */
function scrollerHTML(data, type) {
	if (data.length > 0) {
		var item, HTML = [];
		for (var i = 0; i < data.length; i++) {
			item = data[i];
			HTML.push(
				'<li class="sideScrollerItem noBottomMargin">',
				'<div class="tile scrollerTile noBottomMargin">',
				'<div class="tile-title"><a href="/profile.php?type=' + type + '&id='+ item.id + '">' + item.name + '</a></div>',
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