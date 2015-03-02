/**
 * At least we all get to write some Javascript, eh?
 *
 * Based entirely off http://www.webcodo.net/comments-system-using-php-ajax/
 */
var commentsThingy = function EmptyCommentsThingy() {
	console.error("Failed to build the native Comments function.");
};

(function () {
	var commentRoot, containerDiv, containerId, id, newCommentCount, q, writeBox;
	id = document.getElementById;
	newCommentCount = 250;
	q = document.querySelector;
	writeBox = [
		'<div class="col-xs-12 col-sm-10 col-sm-offset-1" id="commentWriteBox">',
		'<div class="new-com-bt">',
		'<span>Write a comment ...</span>',
		'</div>',
		'<div class="new-com-cnt">',
		'<p id="commentError"></p>',
		'<textarea id="newCommentBody"></textarea>',
		'<p>You have <span id="newCommentCount">', newCommentCount, '</span> characters left.</p>',
		'<div class="bt-add-com">Post comment</div>',
		'<div class="bt-cancel-com">Cancel</div>',
		'</div>',
		'</div>'
	].join('');

	function createComment(data) {
		containerDiv.innerHTML += [
			'<div class="col-xs-12 col-sm-10 col-sm-offset-1 commentItem">',
			'<img src="http://i.imgur.com/ldS4dWw.png">',
			'<div class="commentText">', '<div class="commentHead">',
			'<h5><a href="/profile.php?type=user&id=', data.author.id, '">',
			data.author.name,
			'</a></h5>',
			'<span class="com-dt">', data.created, '</span>',
			'</div>',
			'<p>', data.comment, '</p>',
			'</div>',
			'</div>'
		].join('');
	}

	function initWriteBox() {
		containerDiv.innerHTML += writeBox;

		q('#' + containerId + ' .new-com-bt').onclick(function () {
			q('#' + containerId + ' .new-com-bt').style.display = 'none';
			q('#' + containerId + ' .new-com-cnt').style.display = 'block';
			id('newCommentBody').focus();
		});

		id('newCommentBody').on('keyup', function () {
			var commentLength, opacity;
			commentLength = id('newCommentBody').value.length;

			if (commentLength > 0) {
				if (commentLength > newCommentCount) {
					opacity = 0.6;
					id('commentError').innerText = 'Please enter a shorter comment.';
					id('newCommentCount').innerText = "-" + (commentLength - newCommentCount);
				}
				else {
					opacity = 1;
					id('commentError').innerText = '';
					id('newCommentCount').innerText = '' + (newCommentCount - commentLength);
				}
			}
			else {
				opacity = 0.6;
				id('newCommentCount').innerText = '' + newCommentCount;
			}

			q('#' + containerId + ' .bt-add-com').style.opacity = opacity;
		});

		q('#' + containerId + ' .bt-cancel-com').onclick(function () {
			id('newCommentBody').value = '';
			id('newCommentCount').innerText = '' + newCommentCount;
			id('commentError').innerText = '';
			q('#' + containerId + ' .new-com-cnt').style.display = 'none';
			q('#' + containerId + ' .new-com-bt').style.display = 'block';
		});

		q('#' + containerId + ' .bt-add-com').onclick(function () {
			var commentBody, writeBoxElem;

			commentBody = id('newCommentBody').value;
			if ((commentBody.length == 0) || (commentBody.length > newCommentCount)) {
				return false;
			}

			writeBoxElem = id('commentWriteBox');
			writeBoxElem.innerHTML = '<div class="loader">Sending...</div>';
			API.POST(
				"/comment", {root: commentRoot, comment: commentBody},
				function onCommentCreate(data) {
					console.log("onCommentCreate", data.body);
					writeBoxElem.parentNode.removeChild(writeBoxElem);
					createComment(data.body);
					initWriteBox();
				},
				function onCommentCreateError(data) {
					console.error("onCommentCreateError", data);
				}
			);
		});
	}

	commentsThingy = function CommentsThingy(commentBodyId, root) {
		containerId = commentBodyId;
		containerDiv = id(commentBodyId);
		commentRoot = root;
		API.GET(
			"/comment/thread", {root: root},
			function onCommentGet(data) {
				console.log("onCommentGet", data);
				for (var i = 0; i < data.body.length; i++) {
					createComment(data.body[i]);
				}
				initWriteBox();
			},
			function onCommentGetError(data) {
				console.error("onCommentGetError", data);
			}
		);
	};
})();