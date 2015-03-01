<div class="container">
	<div class="row">
		<div class="col-xs-12"><h1 id="groupName">&nbsp;</h1></div>

	</div>
	<div class="row">
		<div class="groupMembers col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<h3 class="panel-title">Group Members</h3>
						</div>
						<div class="col-xs-3 col-sm-2 col-md-1"></div>
						<div class="col-xs-6 col-sm-4 col-md-5">
							<div class="text-center" id="membershipOptions">
								<button class="btn btn-info panelHeadingButton" id="joinGroupButton">
									Join This Group
								</button>
							</div>
						</div>
						<div class="col-xs-3 col-sm-0"></div>
					</div>
				</div>
				<div class="panel-body">
					<div class="frame" id="groupMembersScroller">
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
		<div class="projectDetails col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Our Project:</h3>
				</div>
				<div class="panel-body">
					<h6 id="projectName">&nbsp;</h6>

					<p id="projectBio">&nbsp;</p>
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
	var defaultProjectBio = [
		'This project doesn\'t have a bio yet',
		'',
		'*Why not comment on its creator\'s page and let them know?*'
	].join('\n');
	if (me.user.role == "student" && !me.group.id) {
		document.getElementById("joinGroupButton").style.display = "block";
	}
	API.GET(
		"/group/" + profileId, {},
		function Success(data) {
			document.getElementById("groupName").innerText = data.body.name;
			document.querySelector(".groupMembers ul").innerHTML = scrollerHTML(data.body.students, "student", false);
			scroller("#groupMembersScroller");
			document.getElementById('joinGroupButton').setAttribute("onclick", "window.location.href = '/intents.php?action=request&request=joinAGroup&groupId=' + profileId;");
			if (data.body.project) {
				document.getElementById("projectName").innerHTML = '<a href="/profile.php?type=project&id=' + data.body.project.id + '">' + data.body.project.name + '</a>';
				// Set the project bio
				var projectBio = data.body.project.description || defaultProjectBio;
				markdownThingy("projectBio", projectBio);
			}
			else {
				document.querySelector(".projectDetails").style.display = "none";
			}
		},
		function Error(data) {
			console.error(data);
		}
	);
</script>