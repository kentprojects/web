<h3 id="intentTitle">Ask to undertake <var class="projectName""></var></h3>

<p id="intentDescription">Do you want to ask <a href="#" class="userName"></a> if your group can
	undertake <a href="#" class="projectName"></a>?</p>

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
		var projectId = phpGets.projectId;

		API.GET(
			"/project/" + projectId, {},
			function Success(data) {
				if (data.body.group != null) {
					qf("#intentTitle", function (element) {
						element.innerText = "This project has already been taken, sorry!";
					});
					qf("#intentDescription", function (element) {
						element.innerHTML = 'Actually, you shouldn\'t have even been able to get to this page! </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					})
					document.querySelector(".btn-group").style.display = "none";
				}
				if (!me.group.id) {
					document.querySelector("#intentTitle").innerText = "You're not in a group yet!"
					document.querySelector("#intentDescription").innerHTML = 'You shouldn\'t even be able to get to this page! </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
				if (me.project.id) {
					document.querySelector("#intentTitle").innerText = "You're already undertaking a project!"
					document.querySelector("#intentDescription").innerHTML = 'You need to leave your current group, or take back your project request! </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
				if (me.group.creator && (me.group.creator.id != me.user.id)) {
					document.querySelector("#intentTitle").innerText = 'Only the creator of a group can pick the project';
					document.querySelector("#intentDescription").innerHTML = 'You need to ask them to do it. </br><strong><a href="#" onclick="cancelRequest();"> Go back? </a></strong>';
					document.querySelector(".btn-group").style.display = "none";
				}
				else {
					qf(".projectName", function (element) {
						element.innerText = data.body.name;
						element.href = "/profile.php?type=project&id=" + data.body.id;
					});
					qf(".userName", function (element) {
						element.innerText = data.body.supervisor.name;
						element.href = "/profile.php?type=staff&id=" + data.body.supervisor.id;
					});
				}
			},
			function Error(data) {
				if (data.status == 404) {
					qf("#intentTitle", function (element) {
						element.innerText = "That's an incorrect project ID!";
					});
					qf("#intentDescription", function (element) {
						element.innerHTML =
							'Did you find a broken link? If so, please let the module convener know. ' +
							'</br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					});
				}
				;
				document.querySelector(".btn-group").style.display = "none";
			}
		);
		confirmRequest = function confirmRequest() {
			API.POST(
				'/intent',
				{handler: "undertake_a_project", data: {project_id: projectId}},
				function Success(data) {
					window.location.href = "/profile.php?type=project&id=" + projectId;
				},
				function Error(data) {
					if (data.status == 409) {
						qf("#intentTitle", function (element) {
							element.innerText = "You can't do that twice in a row!";
						});
						qf("#intentDescription", function (element) {
							element.innerHTML =
								'You need to wait until your current request is accepted or declined ' +
								'before doing it again. </br><strong><a href=# onclick="cancelRequest();"> ' +
								'Go back? </a></strong>';
						});

					}
					else if (data.status == 403) {
						qf("#intentTitle", function (element) {
							element.innerText = "You're not allowed to do that";
						});
						qf("#intentDescription", function (element) {
							element.innerHTML =
								'You don\'t have permission to do that, sorry ' +
								'</br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
						});

					}
					else {
						qf("#intentTitle", function (element) {
							element.innerText = "Uh-oh!";
						});
						qf("#intentDescription", function (element) {
							element.innerHTML =
								'Something went wrong on our server while trying to do what you asked' +
								'</br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
						});
					}
					console.error(data);
					document.querySelector(".btn-group").style.display = "none";
				}
			);
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/profile.php?type=project&id=" + projectId;
		};
	});
</script>