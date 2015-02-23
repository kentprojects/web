<h3 id="intentTitle">Ask to undertake <var class="projectName"">this project?</var></h3>

<p id="intentDescription">Do you want to ask <a href="#" class="userName">the supervisor of this project</a> if your group can
	undertake <a href="#" class="projectName"> this project</a>?</p>

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
		var projectId = phpGets.projectId;

		API.GET(
			"/project/" + projectId, {},
			function Success(data) {
				if (data.body.group != null) {
					qf("#intentTitle", function(element) {
						element.innerText = "This project has already been taken, sorry!";
					});
					qf("#intentDescription", function(element) {
						element.innerHTML = 'Actually, you shouldn\'t have even been able to get to this page! </br><strong><a href=# onclick="window.history.go(-1)"> Go back? </a></strong>';
					})
					document.querySelector(".btn-group").style.display = "none";
				}
				if (me.project.id) {
					document.querySelector("#intentTitle").innerText = "You're already undertaking a project!"
					document.querySelector("#intentDescription").innerHTML = 'You need to leave your current group, or take back your project request! </br><strong><a href=# onclick="window.history.back"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
				if (me.group.creator.id != me.user.id) {
					document.querySelector("#intentTitle").innerText = 'Only the creator of a group can pick the project';
					document.querySelector("#intentDescription").innerHTML = 'You need to ask them to do it. </br><strong><a href="#" onclick="window.history.back"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
				else {
					qf(".projectName", function(element) {
						element.innerText = data.body.name;
						element.href = "/profile.php?type=project&id=" + data.body.id;
					});
					qf(".userName", function(element) {
						element.innerText = data.body.creator.name;
						element.href = "/profile.php?type=staff&id=" + data.body.creator.id;
					});
				}
			},
			function Error(data) {
				console.error("That project doesn't exist!");
				console.error(data.body);
				qf("#intentTitle", function(element) {
					element.innerText = "That's an incorrect project ID!";
				});
				qf("#intentDescription", function(element) {
					element.innerHTML = 'Did you find a broken link? If so, please let the module convener know. </br><strong><a href=# onclick="window.history.back"> Go back? </a></strong>';
				})
				document.querySelector(".btn-group").style.display = "none";
			}
		);
		confirmRequest = function confirmRequest() {
			intentCreate(
				"undertake_a_project",
				{project_id: projectId}
			);
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/profile.php?type=project&id=" + projectId;
		};
	});
</script>