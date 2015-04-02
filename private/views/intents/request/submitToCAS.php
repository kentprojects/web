<!--
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */--
<!--Show details and buttons for the intent.-->>
<h3 id="intentTitle">Submit to CAS office?</h3>

<p id="intentDescription">Are you ready to submit your project to the CAS office?</p>
<label class="checkbox" for="checkbox1">
	<input type="checkbox" data-toggle="checkbox" checked id="checkbox1" class="custom-checkbox"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
	This project will entail research involving human participants as defined by the Faculty Research Ethics Procedures available <a href=“http://www.kent.ac.uk/stms/faculty/adminprocedures/research-ethics/index.html” target=“_blank”>here</a>.
</label>
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

		// Setting the functionality of the confirm and cancel buttons.

		confirmRequest = function confirmRequest() {
			API.POST(
				'/intent',
				{handler: "submit_to_cas", data: {additional: document.querySelector("#checkbox1").checked}},
				cancelRequest,
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
			window.location.href = "dashboard.php";
		};
	});
</script>