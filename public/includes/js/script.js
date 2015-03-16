var loadQueue = loadQueue || [],
	scriptQueue = scriptQueue || [];
loadQueue.execute = function ExecuteLoader() {
	for (var i = 0; i < this.length; i++) {
		typeof this[i] === 'function' && this[i]();
	}
	this.push = function (c) {
		c();
	}
};

/**
 * Confirm the user wants to log out, if so logs the user out of the system.
 */
function logoutUser() {
	if (confirm("Are you sure you want to log out?")) {
		window.location.href = ("/logout.php");
	}
}

loadQueue.push(function OnScriptLoad() {
	/**
	 * No easter eggs here, no sir.
	 */
	cheet('↑ ↑ ↓ ↓ ← → ← → b a', function () {
		alert('Cool video game reference number 1!');
	});
	cheet('i d d q d', function () {
		alert('Cool video game reference number 2!');
	});
});

(function loadScripts(scripts, callback) {
	var script = scripts.shift();
	if (!script) {
		return callback && callback();
	}
	else if (document.getElementById('#script-' + scripts.length)) {
		loadScripts(scripts, callback);
	}
	else {
		var s = document.createElement('script');
		s.id = 'script-' + scripts.length;
		s.onload = function () {
			loadScripts(scripts, callback);
		};
		s.type = 'text/javascript';
		s.src = script;

		document.body.appendChild(s);
	}
})([
	"/includes/js/lib/jquery-1.11.2.min.js",
	"/includes/js/lib/flat-ui-pro.min.js",
	"/includes/js/lib/cheet.min.js",
	"/includes/js/lib/sly.js",

	"/includes/js/ajax.js",
	"/includes/js/includes.php",
	"/includes/js/dynamicCSS.js",
	"/includes/js/notificationsThingy.js",
	"/includes/js/scrollerThingy.js",
	"/includes/js/snippets.js"
].concat(scriptQueue), function scriptsHaveLoaded() {
	loadQueue.execute();
});

/*(function runLoadScripts() {
	if (window.jQuery) {
		(function loadScripts(scripts, callback) {
			var script = scripts.shift();
			if (!script) {
				return callback && callback();
			}
			else {
				jQuery.getScript(script, function () {
					loadScripts(scripts, callback);
				});
			}
		})([
			"/includes/js/lib/flat-ui-pro.min.js",
			"/includes/js/lib/cheet.min.js",
			"/includes/js/lib/sly.js",

			"/includes/js/ajax.js",
			"/includes/js/includes.php",
			"/includes/js/dynamicCSS.js",
			"/includes/js/notificationsThingy.js",
			"/includes/js/scrollerThingy.js",
			"/includes/js/snippets.js"
		], function scriptsHaveLoaded() {
			loadQueue.execute();
		});
	}
	else {
		window.setTimeout(function () {
			/**
			 * For those times when jQuery is getting out of bed and hasn't had it's morning cup of coffee.
			 * I, James Dryden, do hereby accept full responsibility for any crimes against code committed herein.
			 * I am truly sorry.
			 *
			runLoadScripts();
		}, 50);
	}
})(); */