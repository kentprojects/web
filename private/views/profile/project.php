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
					<h3 class="panel-title">Supervisor</h3>
				</div>
				<div class="panel-body">
					<h6 id="supervisorName">Supervisor Name</h6>

					<p id="supervisorDescription">Supervisor bio</p>

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

	//TODO: Actually check the user permission
	var canDoTheThing = true;

	API.GET(
		"/project/" + profileId, {},
		function Success(data) {
			document.getElementById("projectName").innerText = data.body.name;
			document.getElementById("supervisorName").innerText = data.body.creator.name;
			var projectDescription = data.body.description || defaultProjectDescription;
			if(canDoTheThing) {
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
		},
		function Error(data) {
			console.error(data);
		}
	);
</script>