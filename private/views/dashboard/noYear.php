<div class="jumbotron">
	<div class="container">
		<h1 id="welcomeTitle"></h1>

		<p>You haven't been assigned to an academic year yet.</p>

		<p id="accessYearStatus"></p>

		<p>
			<a class="btn btn-primary btn-lg" href="intents.php?action=request&request=accessYear"
				id="requestYearAccessButton">Request Access</a>
		</p>
	</div>
</div>

<script type="text/javascript">
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
			if (hasIntent("access_year")) {
				filterIntentsByTypeAndEntity("access_year", undefined, undefined, function (intent) {
					document.getElementById("requestYearAccessButton").className = "btn btn-warning btn-lg";
					document.getElementById("requestYearAccessButton").innerText = "Cancel Request";
					document.getElementById("requestYearAccessButton").setAttribute("href", "#");
					document.getElementById("requestYearAccessButton").setAttribute("onclick", "cancelRequest()");
					document.getElementById("accessYearStatus").innerText =
						"Now you need to wait for someone to accept your request.";
					document.getElementById("welcomeTitle").innerText = "Sit tight!";
				});
			}
			else {
				document.getElementById("welcomeTitle").innerText = "Hi there!";
				document.getElementById("accessYearStatus").innerText = "Click the button to request access"
			}
			document.getElementById("requestYearAccessButton").style.display = "inline";
		}
	);

	function cancelRequest() {
		if (confirm("Are you sure you want to cancel this request?")) {
			filterIntentsByTypeAndEntity("access_year", undefined, undefined, function(intent) {
				API.DELETE(
					"/intent/" + intent.id, {},
					function Success(data) {
						window.location.reload();
					},
					function Error(data) {
						console.error(data);
					}
				);
			});
		}
	}
</script>