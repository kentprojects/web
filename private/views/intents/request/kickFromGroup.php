<h3 id="intentTitle">Remove <var class="userName""></var> from <var class="groupName""></var>?</h3>

<p id="intentDescription">Are you sure you want to remove <a href="#" class="userName"></a> from
	<a href="#" class="groupName"></a>?</p>

<div class="btn-group intentResponseButtons">
	<button class="btn btn-primary intentAccept" onclick="confirmRequest();" value="Confirm">
		Confirm
	</button>
	<button class="btn btn-info intentDecline" onclick="cancelRequest();" value="Cancel">
		Cancel
	</button>
</div>

<script>
	var confirmRequest = function () {
	};
	var cancelRequest = function () {
	};

	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		var studentId = phpGets.studentId;

		API.GET(
			"/student/" + studentId, {},
			function Success(data) {
				if (me.group.creator.id !== me.user.id) {
					document.querySelector("#intentTitle").innerText = "You didn't create your group!"
					document.querySelector("#intentDescription").innerHTML = 'Only the creator of a group can invite people to join it. </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else if (me.project.id) {
					document.querySelector("#intentTitle").innerText = "You can't remove people to your group!"
					document.querySelector("#intentDescription").innerHTML = 'Once you\'ve undertaken a project, you can\'t remove people from your group. </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else {
					qf(".groupName", function (element) {
						element.innerText = me.group.name;
						element.href = "/profile.php?type=group&id=" + me.group.id;
					});
					qf(".userName", function (element) {
						element.innerText = data.body.name;
						element.href = "/profile.php?type=student&id=" + data.body.id;
					});
					document.querySelector(".intentResponseButtons").style.display = "block";
				}
			},
			function Error(data) {
				console.error("That student doesn't exist!");
				console.error(data.body);
				if (data.status == 404) {
					qf("#intentTitle", function (element) {
						element.innerText = "That's an incorrect student ID!";
					});
					qf("#intentDescription", function (element) {
						element.innerHTML = 'Did you find a broken link? If so, please let the module convener know. </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					});
				};
				document.querySelector(".btn-group").style.display = "none";
			}
		);
		confirmRequest = function confirmRequest() {
			API.POST(
				'/intent',
				{handler: "kick_from_group", data: {user_id: studentId}},
				function Success(data) {
					cancelRequest();
				},
				function Error(data) {
					if (data.status == 409) {
						qf("#intentTitle", function (element) {
							element.innerText = "You can't do that twice in a row!";
						});
						qf("#intentDescription", function (element) {
							element.innerHTML =
								'Something seems to have gone wrong here ' +
								'</br><strong><a href=# onclick="cancelRequest();"> ' +
								'Go back? </a></strong>';
						});

					};
					console.error(data);
					document.querySelector(".btn-group").style.display = "none";
				}
			)
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/profile.php?type=student&id=" + studentId;
		};
	});
</script>