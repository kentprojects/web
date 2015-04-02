/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

var likesThingy = function emptyLikesThingy() {
	console.error("Failed to build the native Likes function.");
};

var likeThis = function emptyLikeThisButton() {
	console.error("Failed to build the native likeThis function.");
};

var unLikeThis = function emptyUnlikeThisButton() {
	console.error("Failed to build the native unLikeThis function.");
};

(function () {
	var likesBoxId, likeRoot;

	function getLikes() {
		API.GET(
			"/like", {entity: likeRoot},
			function onLikesRecieved(data) {
				//console.log(data.body);

				if (!data.body.count || (data.body.count == 0)) {
					document.querySelector('#likesBox .has-no-likers').style.display = 'block';
					document.querySelector('#likesBox .has-likers').style.display = 'none';
					document.querySelector('#likeLoader').style.display = 'none';
					updateLikesCount(0);
				}
				else {
					document.querySelector('#likeScroller ul').innerHTML = scrollerHTML(data.body.who, 'student', true);
					scroller("#likeScroller");
					document.querySelector('#likesBox .has-likers').style.display = 'block';
					document.querySelector('#likesBox .has-no-likers').style.display = 'none';
					document.querySelector('#likeLoader').style.display = 'none';
					updateLikesCount(data.body.count);
					$frame = $('#likeScroller');
					$frame.sly('reload');
				}

				if (data.body.liked) {
					likedThis();
				}
				else if (me.user.role == 'student') {
					document.getElementById('likeThisButton').style.display = 'block';
				}
			},
			function onLikesError(data) {
				console.error('There was an error getting likes.', data);
			}
		);
	}

	function likedThis() {
		document.getElementById('likeThisButton').style.display = 'none';
		document.getElementById('unLikeThisButton').style.display = 'block';
	}

	function unlikedThis() {
		document.getElementById('likeThisButton').style.display = 'block';
		document.getElementById('unLikeThisButton').style.display = 'none';
	}

	function updateLikesCount(count) {
		if (count > 0) {
			document.getElementById('likesCount').innerHTML = ' (' + count + ')';
		}
		else {
			document.getElementById('likesCount').innerHTML = '';
		}
	}

	likesThingy = function LikesThingy(boxId, root) {
		likesBoxId = boxId;
		likeRoot = root;

		//console.log("likesThingy", boxId, root);
		getLikes();
	};

	likeThis = function likeThis() {
		API.POST(
			"/like", {entity: likeRoot},
			function onLiked(data) {
				//console.log(data.body);
				likedThis();
				getLikes();
			},
			function onLikedError(data) {
				console.error('There was an error liking this.', data);
			}
		);
	};

	unLikeThis = function unLikeThis() {
		API.DELETE(
			"/like", {entity: likeRoot},
			function onUnLiked(data) {
				//console.log(data.body);
				unlikedThis();
				getLikes();
			},
			function onUnLikedError(data) {
				console.error('There was an error unliking this.', data);
			}
		);
	};
})();