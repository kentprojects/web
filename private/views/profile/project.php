<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1 class="text-center" id="projectName">&nbsp;</h1>
		</div>
	</div>
	<div class="row" id="changeOptions">
		<div class="col-xs-12 text-center">
			<div class="panel">
				<button class="btn btn-default" onclick="location.reload()"><span class="fui-cross"></span> Revert
				</button>
				<button class="btn btn-success" onclick="pushChanges()"><span class="fui-check"></span> Save</button>
			</div>
		</div>
	</div>
	<div class="row displayNone" id="projectTaken">
		<div class="col-xs-12 col-sm-12">
			<div class="alert alert-success text-center" role="alert">
				<em>This project has already been taken by group.</em>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="projectDetails col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-8">
							<div><h3 class="panel-title">Description</h3></div>
						</div>
						<div class="col-xs-4">
							<div class="floatRight text-right hiddenActionButtons" id="deleteProjectButton"
								onclick="deleteProject()">
								<span class="fui-cross"></span>
							</div>
							<div class="floatRight text-right hiddenActionButtons" id="editProjectDescriptionButton">
								<span class="fui-new"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div id="projectDescription">
					</div>
				</div>
			</div>
		</div>
		<div class="projectDetails col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<h3 class="panel-title">Supervisor</h3>
						</div>
						<div class="col-xs-3 col-sm-2 col-md-1"></div>
						<div class="col-xs-6 col-sm-4 col-md-5">
							<div class="text-center" id="membershipOptions">
								<button class="btn btn-info panelHeadingButton displayNone" id="doProjectButton"
									onclick="doProject()">
									Do This Project
								</button>
								<button class="btn btn-warning panelHeadingButton displayNone" id="giveUpProjectButton"
									onclick="giveUpProject()">
									Give Up Project
								</button>
							</div>
						</div>
						<div class="col-xs-3 col-sm-0"></div>
					</div>
				</div>
				<div class="panel-body">
					<h6 id="supervisorName">&nbsp;</h6>

					<p id="supervisorBio">&nbsp;</p>

				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="likes col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default" id="likesBox">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<h3 class="panel-title">People that like this<span id="likesCount"></span></h3>
						</div>
						<div class="col-xs-3 col-sm-2 col-md-1"></div>
						<div class="col-xs-6 col-sm-4 col-md-5">
							<div class="text-center" id="membershipOptions">
								<button class="btn btn-info panelHeadingButton displayNone" id="likeThisButton"
									onclick="likeThis()">
									I like this
								</button>
								<button class="btn btn-warning panelHeadingButton displayNone" id="unLikeThisButton"
									onclick="unLikeThis()">
									I don't like this
								</button>
							</div>
						</div>
						<div class="col-xs-3 col-sm-0"></div>
					</div>
				</div>
				<div class="panel-body">
					<div class="has-no-likers displayNone">
						<p class="text-center text-info">Nobody has liked this project. Why not be the first?</p>
					</div>
					<div class="loaderFixHeight" id="likeLoader">
						<div class="loader">Loading...</div>
					</div>
					<div class="has-likers displayNone frame" id="likeScroller">
							<ul class="clearfix"></ul>
					</div>
					<ul class="pages"></ul>
					<div class="controls center">
						<button class="btn prevPage"><span class="fui-arrow-left"></span></button>
						<button class="btn nextPage"><span class="fui-arrow-right"></span></button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="commentsPublic col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Public Discussion:</h3>
				</div>
				<div class="panel-body">
					<div class="row" id="commentsBody"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		var defaultProjectDescription = [
			'**Click the edit button above to set a project description**',
			'',
			'Use [Markdown](http://daringfireball.net/projects/markdown/syntax) for formatting'
		].join('\n');
		var defaultUserBio = [
			'This user hasn\'t set a bio yet',
			'',
			'*Why not comment on their page and let them know?*'
		].join('\n');
		API.GET(
			"/project/" + profileId, {},
			function Success(data) {
				var project = data.body;
				document.getElementById("projectName").innerText = data.body.name;
				document.getElementById("supervisorName").innerHTML = '<a href="/profile.php?type=staff&id=' + data.body.supervisor.id + '">' + data.body.supervisor.name + '</a>';
				// Set the project description
				var projectDescription = data.body.description || defaultProjectDescription;
				if (data.body.permissions.update == 1) {
					markdownThingy(
						"projectDescription", projectDescription, "editProjectDescriptionButton",
						queueMarkdownChange("projectDescription", function SaveProjectDescription(saveData, next) {
							API.PUT(
								"/project/" + profileId, {"description": saveData},
								function SaveProjectDescriptionSuccess(data) {
									console.log(data);
									next();
								},
								function SaveProjectDescriptionError(data) {
									console.error(data);
								}
							);
						})
					);
					document.getElementById("deleteProjectButton").style.display = "block";
				}
				else {
					markdownThingy("projectDescription", projectDescription);
				}
				// Set the supervisor's bio
				var userBio = data.body.supervisor.bio || defaultUserBio;
				markdownThingy("supervisorBio", userBio);

				// TODO: Show the do button if:
				// The user isn't a student / doesn't have a project / it's already taken
				if (me.user.role == "student" && me.group.id && !me.project.id && !data.body.group) {
					if (me.group.creator.id == me.user.id) {
						if (hasIntent("undertake_a_project")) {
							filterIntentsByTypeAndEntity("undertake_a_project", "project", profileId, function (intent) {
								document.getElementById("doProjectButton").className = "btn btn-warning panelHeadingButton";
								document.getElementById("doProjectButton").innerText = "Cancel Request";
								document.getElementById("doProjectButton").setAttribute("onclick", "cancelRequest()");
							});
						}
						else {
							document.getElementById("doProjectButton").style.display = "block";
						}
					}
				}
	
				if (data.body.group != null) {
					document.querySelector('#projectTaken').className = document.querySelector('#projectTaken').className.replace(" displayNone", "");
					document.querySelector('#projectTaken').innerHTML = document.querySelector('#projectTaken').innerHTML.replace("group", "<a href='/profile.php?type=group&id=" + data.body.group.id + "'>" + data.body.group.name + "</a>")
				}

				// Show the 'give up' button if:
				if (me.user.role == "student" &&
					me.group.id &&
					me.project.id == data.body.id) {
					if (me.group.creator.id == me.user.id) {
						document.getElementById("giveUpProjectButton").style.display = "block";
					}
				}

				commentsThingy("commentsBody", "project/" + data.body.id);
				likesThingy("likesBox", "project/" + data.body.id);
			},
			function Error(data) {
				if (data.status == 404) {
					window.location.href = '/404.html'
				}
				console.error(data);
			}
		);
	});

	function cancelRequest() {
		if (confirm("Are you sure you want to cancel this request?")) {
			filterIntentsByTypeAndEntity("undertake_a_project", "project", profileId, function (intent) {
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

	function deleteProject() {
		if (confirm("Are you sure you want to delete this project?")) {
			API.DELETE(
				"/project/" + profileId, {},
				function Success(data) {
					window.location.href = '/dashboard.php'
				},
				function Error(data) {
					console.error(data);
				}
			);
		}
	}

	function giveUpProject() {
		API.POST(
			"/intent/", {
				handler: "release_project",
				data: {project_id: profileId}
			},
			function Success(data) {
				window.location.href = '/dashboard.php'
			},
			function Error(data) {
				console.error(data.body);
			}
		);
	}

	function doProject() {
		window.location.href = '/intents.php?action=request&request=undertakeAProject&projectId=' + profileId;
	}
</script>