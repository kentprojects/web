<div class="container">
	<div class="row">
		<div class="col-xs-12"><h1 id="userName">&nbsp;</h1></div>

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
	<div class="row">
		<div class="userDetails col-xs-12 col-sm-3 col-md-2 col-lg-2">
			<div class="panel panel-default" id="profilePicture">
				<div class="panel-body">
					<img />
				</div>
			</div>
		</div>
		<div class="userBio col-xs-12 col-sm-9 col-md-10 col-lg-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-8">
							<div><h3 class="panel-title">Bio</h3></div>
						</div>
						<div class="col-xs-4">
							<div class="floatRight text-right hiddenActionButtons" id="inviteToGroupDiv">
								<button class="btn btn-info panelHeadingButton" id="inviteToGroupButton"
									onclick="inviteToGroup()">
									Invite To Join Your Group
								</button>
							</div>
							<div class="floatRight text-right hiddenActionButtons" id="editUserBioButton">
								<span class="fui-new"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div id="userBio">
					</div>
				</div>
			</div>
		</div>
		<div class="projectDetails col-xs-12 col-sm-12 col-md-5 col-lg-5" id="userProjectDescription">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">My Project:</h3>
				</div>
				<div class="panel-body">
					<h6 id="projectName">&nbsp;</h6>

					<p id="projectBio">&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="userInterests col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Interests:</h3>
				</div>
				<div class="panel-body">
					<input type="text" class="form-control" id="interestsInput" />
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
		var defaultUserBio = [
			'This user hasn\'t set a bio yet',
			'',
			'*Why not comment on their page and let them know?*'
		].join('\n');
		var defaultProjectBio = [
			'This project doesn\'t have a bio yet',
			'',
			'*Why not comment on its creator\'s page and let them know?*'
		].join('\n');
		API.GET(
			"/student/" + profileId, {},
			function Success(data) {


				// Set the user bio
				var userBio = data.body.bio || defaultUserBio;
				// Set the user interests
				var userInterests = data.body.interests;


				if (data.body.permissions.update == 1) {

					markdownThingy(
						"userBio", userBio, "editUserBioButton",
						queueMarkdownChange("userBio", function SaveUserBio(saveData, next) {
							API.PUT(
								"/student/" + profileId, {"bio": saveData},
								function SaveUserBioSuccess(data) {
									next();
								},
								function SaveUserBioError(data) {
									console.error(data);
								}
							);
						})
					);

					tokensThingy("#interestsInput", userInterests, function SaveUserInterests(interests, next) {
						API.PUT(
							"/student/" + profileId, {"interests": interests},
							function SaveUserInterestsSuccess(data) {
								next();
							},
							function SaveUserInterestsError(data) {
								console.error(data);
							}
						);
					});


				}
				else {
					markdownThingy("userBio", userBio);
					if (userInterests.length > 0) {
						tokensThingy("#interestsInput", userInterests);
					}
					else {
						document.querySelector(".userInterests .panel-body").innerHTML = '<p class="text-info">I haven\'t set my interests yet</p>';
					}
				}
				// Set the user's name
				document.getElementById("userName").innerText = data.body.name;

				// Set the user's profile picture
				document.querySelector("#profilePicture img").setAttribute("src", '/uploads/' + md5(data.body.email));

				// Set their project bio if they have one
				if (data.body.group.project) {
					document.getElementById("projectName").innerHTML = '<a href="/profile.php?type=project&id=' + data.body.group.project.id + '">' + data.body.group.project.name + '</a>';
					// Set the project bio
					var projectBio = data.body.group.project.description || defaultProjectBio;
					markdownThingy("projectBio", projectBio);
					document.querySelector(".userBio").className = "userBio col-xs-12 col-sm-9 col-md-5 col-lg-5";
					document.querySelector(".projectDetails").className = "projectDetails col-xs-12 col-sm-12 col-md-5 col-lg-5";
					document.getElementById("userProjectDescription").style.display = "block";

				}

				if (me.user.role == "student") {
					if (me.group &&
						me.group.creator &&
						me.group.creator.id == me.user.id &&
						profileId !== me.user.id &&
						!data.body.group) {
						document.getElementById("inviteToGroupDiv").style.display = "block";
						document.getElementById("inviteToGroupButton").style.display = "block";
					}
				}

				commentsThingy("commentsBody", "user/" + data.body.id);
			},
			function Error(data) {
				if (data.status == 404) {
					window.location.href = '/404.html'
				}
				console.error(data);
			}
		);
	});

	function inviteToGroup() {
		window.location.href = '/intents.php?action=request&request=inviteToGroup&studentId=' + profileId;
	}
</script>