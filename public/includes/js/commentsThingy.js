/**
 * At least we all get to write some Javascript, eh?
 */
var commentsThingy = function EmptyCommentsThingy() {
	console.error("Failed to build the native Comments function.");
};

(function () {
	commentsThingy = function CommentsThingy(containerId) {
		var containerDiv = document.getElementById(containerId);
		containerDiv.innerHTML = "";
	};
})();