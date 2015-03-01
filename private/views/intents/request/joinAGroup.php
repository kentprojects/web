<h3 id="intentTitle">Ask to join <var class="groupName""></var>?</h3>

<p id="intentDescription">Do you want to ask <a href="#" class="userName"></a> if you can join
	<a href="#" class="groupName"></a>?</p>

<div class="btn-group">
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
				qf(".groupName", function (element) {
					element.innerText = data.body.name;
					element.href = "/profile.php?type=group&id=" + data.body.id;
				});
				qf(".userName", function (element) {
					element.innerText = data.body.creator.name;
					element.href = "/profile.php?type=student&id=" + data.body.creator.id;
				});
				if (me.group.id) {
					document.querySelector("#intentTitle").innerText = "You're already in a group!"
					document.querySelector("#intentDescription").innerHTML = 'You need to leave your current group before you can join a new one! </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
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