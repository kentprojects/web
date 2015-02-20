<h3 id="intentTitle">Ask to join <var class="groupName"">this group?</var></h3>

<p id="intentDescription">Do you want to ask <var class="userName">the creator of this group</var > if you can join <var class="groupName"> this group</var>?</p>

<div class="btn-group">
	<button class="btn btn-primary intentAccept" onclick="confirmRequest();" value="Confirm">
		Confirm
	</button>
	<button class="btn btn-info intentDecline" onclick="cancelRequest();" value="Cancel">
		Cancel
	</button>
</div>

<script>
	var confirmRequest = function () {};
	var cancelRequest = function () {};

	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		var groupId = phpGets.groupId;

		API.GET(
			"/group/" + groupId, {},
			function Success(data) {
				innerTextForQuerySelector(".groupName", data.body.name);
				innerTextForQuerySelector(".userName", data.body.creator.name);
			},
			function Error(data) {
				console.error("That group doesn't exist!");
				console.error(data.body);
			}
		);
		confirmRequest = function confirmRequest() {
			intentCreate(
				"join_a_group",
				{group_id: groupId}
			);
		};
		cancelRequest = function cancelRequest() {
		};
	});
</script>