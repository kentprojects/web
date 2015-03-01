/**
 * At least we all get to write some Javascript, eh?
 *
 * Based entirely off http://www.webcodo.net/comments-system-using-php-ajax/
 */
var commentsThingy = function EmptyCommentsThingy() {
	console.error("Failed to build the native Comments function.");
};
var $ = $ || undefined;
var loadQueue = loadQueue || [];
var me = me || {};

(function () {
	var containerDiv, commentRoot;
	var newCommentCount = 250;
	var writeBox = [
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
	].join("");

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
		].join("");
	}

	function initWriteBox() {
		containerDiv.innerHTML += writeBox;

		$('.new-com-bt').click(function () {
			$(this).hide();
			$('.new-com-cnt').show();
			$('#newCommentBody').focus();
		});

		$('#newCommentBody').keyup(function () {
			var bt = $(".bt-add-com");
			bt.css({opacity: 0.6});
			if ($(this).val().length > 0) {
				if ($(this).val().length > newCommentCount) {
					bt.css({opacity: 0.6});
					$('#commentError').text('Please enter a shorter comment.');
					$('#newCommentCount').text("-" + ($(this).val().length - newCommentCount));
				}
				else {
					bt.css({opacity: 1});
					$('#commentError').text('');
					$('#newCommentCount').text(newCommentCount - $(this).val().length);
				}
			}
			else {
				$('#newCommentCount').text(newCommentCount);
			}
		});

		$('.bt-cancel-com').click(function () {
			$('#newCommentBody').val('');
			$('#newCommentCount').text(newCommentCount);
			$('#commentError').text('');
			$('.new-com-cnt').fadeOut('fast', function () {
				$('.new-com-bt').fadeIn('fast');
			});
		});

		$('.bt-add-com').click(function (e) {
			var commentBody = $('#newCommentBody').val();
			if ((commentBody.length == 0) || (commentBody.length > newCommentCount)) {
				return false;
			}
			var writeBoxElem = document.getElementById('commentWriteBox');
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

	commentsThingy = function CommentsThingy(containerId, root) {
		containerDiv = document.getElementById(containerId);
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