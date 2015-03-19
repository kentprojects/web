<h3 class="displayNone" id="intentTitle">Ask to join <var class="groupName""></var>?</h3>

<p class="displayNone" id="intentDescription">Do you want to ask <a href="#" class="userName"></a> if you can join
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
		var groupId = phpGets.groupId;

		API.GET(
			"/group/" + groupId, {},
			function Success(data) {
				if (me.group.id) {
					document.querySelector("#intentTitle").innerText = "You're already in a group!"
					document.querySelector("#intentDescription").innerHTML = 'You need to leave your current group before you can join a new one! </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else if (data.body.project && data.body.project.id) {
					document.querySelector("#intentTitle").innerText = "You can't join a group that's already got a project"
					document.querySelector("#intentDescription").innerHTML = 'How did you get here? </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else if (hasIntent("join_a_group")) {
					document.querySelector("#intentTitle").innerText = 'You can\'t do that right now';
					document.querySelector("#intentDescription").innerHTML = 'You already have a pending request to join a group. </br><strong><a href="#" onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else {
					qf(".groupName", function (element) {
						element.innerText = data.body.name;
						element.href = "/profile.php?type=group&id=" + data.body.id;
					});
					qf(".userName", function (element) {
						element.innerText = data.body.creator.name;
						element.href = "/profile.php?type=student&id=" + data.body.creator.id;
					});
					document.querySelector(".intentResponseButtons").style.display = "block";
				}
				document.querySelector("#intentTitle").style.display = "block";
				document.querySelector("#intentDescription").style.display = "block";
			},
			function Error(data) {
				console.error("That group doesn't exist!");
				console.error(data.body);
				if (data.status == 404) {
					qf("#intentTitle", function (element) {
						element.innerText = "That's an incorrect group ID!";
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
				{handler: "join_a_group", data: {group_id: groupId}},
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
								'You need to wait until your current request is accepted or declined ' +
								'before doing doing it again </br><strong><a href=# onclick="cancelRequest();"> ' +
								'Go back? </a></strong>';
						});

					};
					console.error(data);
					document.querySelector(".btn-group").style.display = "none";
				}
			)
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/profile.php?type=group&id=" + groupId;
		};
	});
</script>