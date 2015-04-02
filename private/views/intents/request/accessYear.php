<!--
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */-->
<!--Show details and buttons for the intent.-->
<h3 id="intentTitle">Ask to join this year?</h3>

<p id="intentDescription">Do you want to ask the convener for this year if you can join it?</p>
<!--Buttons to accept or decline the intent.-->
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
		var yearId = phpGets.yearId;

		// Setting the functionality of the confirm and cancel buttons.

		confirmRequest = function confirmRequest() {
			intentCreate("access_year", {yearId: yearId}, "/dashboard.php");
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/dashboard.php";
		};
	});
</script>