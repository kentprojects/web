<h3 id="intentTitle">Send a generic request to <var class="userName"">this user?</var></h3>

<p id="intentDescription">Are you sure you want to send a generic request to <var class="userName">the user</var></p>

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
		var userId = phpGets.userId;

		API.GET(
			"/user/" + userId, {},
			function Success(data) {
				innerTextForQuerySelector(".userName", data.body.name);
			},
			function Error(data) {
				console.error("That user doesn't exist!");
				console.error(data.body);
			}
		);
		confirmRequest = function confirmRequest() {
			intentCreate("generic", {user_id: userId}, undefined);
		};
		cancelRequest = function cancelRequest() {
		};
	});
</script>