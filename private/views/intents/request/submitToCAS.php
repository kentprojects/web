<h3 id="intentTitle">Submit to CAS office?</h3>

<p id="intentDescription">Are you ready to submit your project to the CAS office?

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

		console.log(me.user);

		confirmRequest = function confirmRequest() {
			intentCreate("submit_to_cas", {groupId: me.group.id}, undefined);
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "dashboard.php";
		};
	});
</script>