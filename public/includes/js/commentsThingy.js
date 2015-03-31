/**
 * At least we all get to write some Javascript, eh?
 *
 * JD woz 'ere 2k15
 *
 * Based entirely off http://www.webcodo.net/comments-system-using-php-ajax/
 */
var commentsThingy = function EmptyCommentsThingy() {
	console.error("Failed to build the native Comments function.");
};

var deleteComment = function emptyDeleteComment() {
	console.error("Failed to build the native Delete Comments function.");
};

(function () {
	var commentRoot, containerDiv, containerId, newCommentCount, writeBox;
	newCommentCount = 250;
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
			'<div class="col-xs-12 col-sm-10 col-sm-offset-1 commentItem" id="comment_' + data.id + '">',
			'<img src="/uploads/', md5(data.author.email), '">',
			'<div class="commentText">', '<div class="commentHead">',
			'<h5><a href="/profile.php?type=' + data.author.role + '&id=', data.author.id, '">',
			data.author.name,
			'</a></h5>',
			'<span class="com-dt">', data.created, '</span>',
			((data.permissions.delete) ? '<span class="com-dt-delete"><a href="#" onclick="deleteComment(' + data.id + ');">Delete </a> </span>' : ''),
			'</div>',
			'<p>', data.comment, '</p>',
			'</div>',
			'</div>'
		].join('');
	}

	function initWriteBox() {
		containerDiv.innerHTML += writeBox;

		setTimeout(function () {
			document.querySelector('#commentWriteBox .new-com-bt').onclick = function OnNewCommentButtonClick() {
				document.querySelector('#commentWriteBox .new-com-bt').style.display = 'none';
				document.querySelector('#commentWriteBox .new-com-cnt').style.display = 'block';
				document.getElementById('newCommentBody').focus();
			};

			document.getElementById('newCommentBody').onkeyup = function OnNewCommentBodyKeyUp() {
				var commentLength, opacity;
				commentLength = document.getElementById('newCommentBody').value.length;

				if (commentLength > 0) {
					if (commentLength > newCommentCount) {
						opacity = 0.6;
						document.getElementById('commentError').innerText = 'Please enter a shorter comment.';
						document.getElementById('newCommentCount').innerText = "-" + (commentLength - newCommentCount);
					}
					else {
						opacity = 1;
						document.getElementById('commentError').innerText = '';
						document.getElementById('newCommentCount').innerText = '' + (newCommentCount - commentLength);
					}
				}
				else {
					opacity = 0.6;
					document.getElementById('newCommentCount').innerText = '' + newCommentCount;
				}

				document.querySelector('#commentWriteBox .bt-add-com').style.opacity = opacity;
			};

			document.querySelector('#commentWriteBox .bt-cancel-com').onclick = function OnNewCommentCancelClick() {
				document.getElementById('newCommentBody').value = '';
				document.getElementById('newCommentCount').innerText = '' + newCommentCount;
				document.getElementById('commentError').innerText = '';
				document.querySelector('#' + containerId + ' .new-com-cnt').style.display = 'none';
				document.querySelector('#' + containerId + ' .new-com-bt').style.display = 'block';
			};

			document.querySelector('#commentWriteBox .bt-add-com').onclick = function OnNewCommentSubmit() {
				var commentBody, writeBoxElem;

				commentBody = document.getElementById('newCommentBody').value;
				if ((commentBody.length == 0) || (commentBody.length > newCommentCount)) {
					return;
				}

				writeBoxElem = document.getElementById('commentWriteBox');
				writeBoxElem.innerHTML = '<div class="loader">Sending...</div>';
				API.POST(
					"/comment", {root: commentRoot, comment: commentBody},
					function onCommentCreate(data) {
						writeBoxElem.parentNode.removeChild(writeBoxElem);
						createComment(data.body);
						initWriteBox();
					},
					function onCommentCreateError(data) {
						console.error("onCommentCreateError", data);
					}
				);
			};
		}, 200);
	}

	deleteComment = function deleteComment(id) {
		if (confirm("Are you sure you wish to delete this comment?")) {
			API.DELETE("/comment/" + id, {},
				function Success() {
					var element = document.getElementById("comment_" + id);
					element.parentNode.removeChild(element);
				},
				function Error() {
					console.error("Failed to delete comment with ID " + id);
				}
			);
		}
	};

	commentsThingy = function CommentsThingy(commentBodyId, root) {
		containerId = commentBodyId;
		containerDiv = document.getElementById(commentBodyId);
		commentRoot = root;
		API.GET(
			"/comment/thread", {root: root},
			function onCommentGet(data) {
				if (data.body && data.body.length) {
					for (var i = 0; i < data.body.length; i++) {
						createComment(data.body[i]);
					}
				}
				initWriteBox();
			},
			function onCommentGetError(data) {
				console.error("onCommentGetError", data);
			}
		);
	};
})();