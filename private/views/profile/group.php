<div class="container">
	<div class="row">
		<h1 id="group_name">Group Profile</h1>
	</div>
	<div class="row">
		<div class="groupMembers col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title sideScrollerTitle">Group Members</h3>
				</div>
				<div class="panel-body">
					<div class="sideScroller" id="project-scroller">
						<ul class="list-inline noBottomMargin">
							<!-- Group members will appear here -->
						</ul>
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
					<h6 id="projectName">Project Name</h6>
					<p id="projectBio">Project description</p>
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
	API.GET(
		"/group/" + profileId, {},
		function Success(data) {
			console.log(data.body);
			document.getElementById("group_name").innerText = data.body.name;
			document.querySelector(".groupMembers ul").innerHTML = scrollerHTML(data.body.students, "student");
			document.getElementById("projectName").innerHTML = '<a href="/profile.php?type=project&id=' + data.body.project.id + '">' + data.body.project.name + '</a>';
			// Set the project bio
			var projectBio = data.body.project.bio || defaultProjectBio;
			markdownThingy("projectBio", projectBio);
		},
		function Error(data) {
			console.error(data);
		}
	);
</script>