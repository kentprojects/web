/**
 * Created by house on 17/02/15.
 */
function innerTextForQuerySelector(query, text) {
	var elements = document.querySelectorAll(query)
	for (i = 0; i < elements.length; i++) {
		elements[i].innerText = text;
	}
	;
}
function innerHTMLForQuerySelector(query, html) {
	var elements = document.querySelectorAll(query)
	for (i = 0; i < elements.length; i++) {
		elements[i].innerText = html;
	}
	;
}

function replaceAll(string, find, replace) {
	return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

mapPlaceHolders = (function BuildMapFunction() {
	function getDataByKey(data, key) {
		key = key.split(".");
		for (var i = 0; i < key.length; i++) {
			if (typeof data === "object") {
				if (data.hasOwnProperty(key[i])) {
					data = data[key[i]];
				}
				if (typeof data !== "object") {
					return data;
				}
			}
			else {
				return data;
			}
		}
		return null;
	}

	return function MapPlaceHolder(placeholders, data) {
		for (var placeholder in placeholders) {
			if (placeholders.hasOwnProperty(placeholder)) {
				placeholders[placeholder] = getDataByKey(data, placeholders[placeholder])
			}
		}
		return placeholders;
	};
})();