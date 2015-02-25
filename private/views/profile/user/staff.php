<div class="container">
	<div class="row">
		<div class="col-xs-12"><h1 id="userName">User Profile</h1></div>

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
			<div class="panel panel-default" id="userPicture">
				<div class="panel-body">
					<img src=http://i.imgur.com/ldS4dWw.png"/>
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
							<div class="alignRight editBioButton" id="editUserBioButton">
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
		"/staff/" + phpGets.profileId, {},
		function Success(data) {

			// Set the user bio
			var userBio = data.body.bio || defaultUserBio;
			if (data.body.permissions.update == 1) {
				markdownThingy(
					"userBio", userBio, "editUserBioButton",
					queueChange("userBio", function SaveUserBio(saveData, next) {
						API.PUT(
							"/staff/" + profileId, {"bio": saveData},
							function SaveUserBioSuccess(data) {
								console.log(data);
								next();
							},
							function SaveUserBioError(data) {
								console.error(data);
							}
						);
					})
				);
			}
			else {
				markdownThingy("userBio", userBio);
			}

			document.getElementById("userName").innerText = data.body.name;
		},
		function Error(data) {
			console.error(data);
		}
	);
</script>