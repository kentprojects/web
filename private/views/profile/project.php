<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1 id="projectName">Project Profile</h1>
		</div>
	</div>
	<div class="row" id="changeOptions">
		<div class="col-xs-12 text-center">
			<div class="panel">
				<button class="btn btn-default" onclick="location.reload()"><span class="fui-cross"></span> Revert</button>
				<button class="btn btn-success" onclick="pushChanges()"><span class="fui-check"></span> Save</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="projectDetails col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-10">
							<div><h3 class="panel-title">Bio</h3></div>
						</div>
						<div class="col-xs-2">
							<div class="alignRight editBioButton" id="editProjectBioButton">
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
								<button class="btn btn-info panelHeadingButton" id="doProjectButton">Do This Project</button>
							</div>
						</div>
						<div class="col-xs-3 col-sm-0"></div>
					</div>
				</div>
				<div class="panel-body">
					<h6 id="supervisorName">Supervisor Name</h6>

					<p id="supervisorBio">Supervisor bio</p>

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
					<p>Comments here</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
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
			document.getElementById("projectName").innerText = data.body.name;
			document.getElementById("supervisorName").innerHTML = '<a href="/profile.php?type=staff&id=' + data.body.creator.id + '">' + data.body.creator.name + '</a>';
			// Set the project description
			var projectDescription = data.body.description || defaultProjectDescription;
			if(data.body.permissions.update == 1) {
				markdownThingy(
					"projectDescription", projectDescription, "editProjectBioButton",
					queueChange("projectDescription", function SaveProjectDescription(saveData, next) {
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
			}
			else{
				markdownThingy("projectDescription", projectDescription);
			}
			// Set the supervisor's bio
			var userBio = data.body.creator.bio || defaultUserBio;
			markdownThingy("supervisorBio", userBio);

			// TODO: Show the join button if:
			// The user isn't a student / doesn't have a project / it's already taken
			if(me.role = "student" && !me.project.id && !data.body.group){
				document.getElementById("doProjectButton").style.display = "block";
			}
			document.getElementById('doProjectButton').setAttribute("onclick", "window.location.href = '/intents.php?action=request&request=undertake_a_project&projectId=' + profileId;");
		},
		function Error(data) {
			console.error(data);
		}
	);
</script>