/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

function markdownThingy(container, content, button, saveFunction) {
	button = button || false;
	saveFunction = saveFunction || false;
	$('#' + container).markdown({
		hideable: true,
		onShow: function (e) {
			e.setContent(content);
			e.blur();
		},
		onBlur: function (e) {
			// Remove focus flag
			$(e.$element).data('focused', null);
		}
	});
	if (button && saveFunction) {
		$('#' + button).show();
		$('#' + button).click(function () {
			$('#' + container).markdown({
				hideable: true,
				savable: true,
				onShow: function () {
					$('#' + button).hide();
				},
				onSave: function (e) {
					saveFunction(e.getContent());
					e.blur();
				},
				onFocus: function (e) {

				},
				onBlur: function (e) {
					saveFunction(e.getContent());
					// Remove focus flag
					$(e.$element).data('focused', null);
					$('#' + button).show();
				}
			});
			return false;
		});
	}
}