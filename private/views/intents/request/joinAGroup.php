<h3 id="intentTitle">Ask to join <var class="groupName"">this group?</var></h3>

<p id="intentDescription">Do you want to ask <a href="#" class="userName">the creator of this group</a> if you can join
	<a href="#" class="groupName"> this group</a>?</p>

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
					document.querySelector("#intentDescription").innerHTML = 'You need to leave your current group before you can join a new one! </br><strong><a href=# onclick="window.history.back"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
			},
			function Error(data) {
				console.error("That group doesn't exist!");
				console.error(data.body);
				qf("#intentTitle", function (element) {
					element.innerText = "That's an incorrect group ID!";
				});
				qf("#intentDescription", function (element) {
					element.innerHTML = 'Did you find a broken link? If so, please let the module convener know. </br><strong><a href=# onclick="window.history.back"> Go back? </a></strong>';
				})
				document.querySelector(".btn-group").style.display = "none";
			}
		);
		confirmRequest = function confirmRequest() {
			intentCreate(
				"join_a_group",
				{group_id: groupId}
			);
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/profile.php?type=group&id=" + groupId;
		};
	});
</script>