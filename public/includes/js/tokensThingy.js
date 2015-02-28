function tokensThingy(container, content, saveFunction) {

	saveFunction = saveFunction || false;

	if (saveFunction) {
		var init = true;
		var onTokenEdit = function onTokenEdit() {
			if (init) {
				return;
			}
			$(container).attr("placeholder", "");
			$(container + "-tokenfield").attr("placeholder", "");
			var tokens = $(container).tokenfield('getTokens');
			if (tokens.length > 0) {
				tokens = tokens.map(function formatTokens(value) {
					return value.value;
				});
			}
			else {
				tokens = [];
			}
			queueChange(container, tokens, saveFunction);
		};

		if (content.length == 0 && init) {
			$(container).attr("placeholder", "Add some things here, pressing enter after each one.");
		}

		$(container)

			.on('tokenfield:createdtoken', onTokenEdit)

			.on('tokenfield:editedtoken', onTokenEdit)

			.on('tokenfield:removedtoken', onTokenEdit)

			.on('tokenfield:initialize', function () {
				init = false;
			})

			.tokenfield({tokens: content});

	}

	else {
		$(container)
			.tokenfield({tokens: content})
			.tokenfield('readonly');
	}
}