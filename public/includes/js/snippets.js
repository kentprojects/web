/**
 * Created by house on 17/02/15.
 */

function addTileTest() {
	var containerID = "";
	var testJSON = "";
}

function innerTextForQuerySelector(query, text) {
	var elements = document.querySelectorAll(query)
	for (var i = 0; i < elements.length; i++) {
		elements[i].innerText = text;
	}
	;
}
function innerHTMLForQuerySelector(query, html) {
	var elements = document.querySelectorAll(query)
	for (var i = 0; i < elements.length; i++) {
		elements[i].innerText = html;
	}
	;
}

function setHrefForQuerySelector(query, href) {
	var elements = document.querySelectorAll(query)
	for (var i = 0; i < elements.length; i++) {
		elements[i].href = href;
	}
	;
}

function qf(query, callback) {
	if (!callback) {
		console.error("No callback provided for query:", query);
	}
	var elements = document.querySelectorAll(query)
	for (var i = 0; i < elements.length; i++) {
		callback(elements[i]);
	}
}

function replaceAll(string, find, replace) {
	return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function buildText(text, placeholders, data) {
	var processedText = text;
	var replacementStrings = mapPlaceHolders(placeholders, data);
	for (var key in replacementStrings) {
		if (replacementStrings.hasOwnProperty(key)) {
			var replacementString = replacementStrings[key];
			processedText = processedText.replace(key, replacementString);
		}
	}
	return processedText;
}

var mapPlaceHolders = (function BuildMapFunction() {
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
		var output = {};
		for (var placeholder in placeholders) {
			if (placeholders.hasOwnProperty(placeholder)) {
				output[placeholder] = getDataByKey(data, placeholders[placeholder]);
			}
		}
		return output;
	};
})();

/**
 * @param type
 * @param entity
 * @param entityId
 * @param callback
 * @returns boolean
 */
function filterIntentsByTypeAndEntity(type, entity, entityId, callback) {
	var intents = getIntentsOfType(type);
	for (var i = 0; i < intents.length; i++) {
		if (!entity && !entityId) {
			return callback && callback(intents[i]);
		}
		if (intents[i][entity] && intents[i][entity].id && intents[i][entity].id == entityId) {
			return callback && callback(intents[i]);
		}
	}
	return false;
}

function getIntentsOfType(type) {
	if (!me || !me.intents) {
		console.error("No intents loaded.");
		return [];
	}
	else if (me.intents.length > 0) {
		var intents = [];
		for (var i = 0; i < me.intents.length; i++) {
			if (me.intents[i].handler == type) {
				intents.push(me.intents[i]);
			}
		}
		return intents;
	}
	else {
		return [];
	}
}

function hasIntent(type) {
	return (getIntentsOfType(type).length > 0);
}