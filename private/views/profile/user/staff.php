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
						<div class="col-xs-10">
							<div><h3 class="panel-title">Bio</h3></div>
						</div>
						<div class="col-xs-2">
							<div class="text-right editBioButton" id="editUserBioButton">
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
		<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12 displayNone">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-8">
							<div><h3 class="panel-title"><a href="/list.php?type=projects">My Projects</a></h3></div>
						</div>
						<div class="col-xs-4">
							<div class="text-right">
								<a class="btn btn-info panelHeadingButton displayNone" id="addProjectButton" href="/new.php?type=project"><span class="fui-plus"></span> Add</a>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="frame" id="projectScroller">
						<ul class="clearfix">
						</ul>
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
		var defaultOwnerBio = [
			'You haven\'t set a bio yet',
			'',
			'*Click the edit button above to get started*'
		].join('\n');
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
			"/staff/" + profileId, {},
			function Success(data) {
				var user = data.body;

				// Set the user interests
				var userInterests = user.interests;

				if (user.permissions.update == 1) {
					// Set the user bio
					var userBio = user.bio || defaultOwnerBio;

					markdownThingy(
						"userBio", userBio, "editUserBioButton",
						queueMarkdownChange("userBio", function SaveUserBio(saveData, next) {
							API.PUT(
								"/staff/" + profileId, {"bio": saveData},
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
							"/staff/" + profileId, {"interests": interests},
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
					// Set the user bio
					var userBio = user.bio || defaultUserBio;

					markdownThingy("userBio", userBio);
					if (userInterests.length > 0) {
						tokensThingy("#interestsInput", userInterests);
					}
					else {
						document.querySelector(".userInterests .panel-body").innerHTML = '<p class="text-info">I haven\'t set my interests yet</p>';
					}
				}

				document.getElementById("userName").innerText = user.name;

				// Set the user's profile picture
				document.querySelector("#profilePicture img").setAttribute("src", '/uploads/' + md5(user.email));

				//TODO: replace with the forced/current year
				if(user.years[2014].role_supervisor == 1) {
					// List their projects
					API.GET(
						"/projects", {"year": <?php echo $year;?>, "supervisor": user.id},
						function (data) {
							var projects = data.body;
							document.querySelector(".Projects ul").innerHTML = scrollerHTML(projects, "project", true);
							document.querySelector(".Projects a").innerText += ' (' + projects.length + ')';
							scroller("#projectScroller");
							if(user.permissions.update) {
								document.getElementById("addProjectButton").style.display = "block";
							};
							document.querySelector(".Projects").style.display = "block";
						},
						function (data) {
							console.error(data);
						}
					);

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
</script>