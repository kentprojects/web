<div class="jumbotron">
	<div class="container">
		<h3>Welcome to KentProjects!</h3>

		<p>This is your <i>supervisor</i> dashboard, where you can quickly search through your projects, groups, and
			students.</p>

	</div>
</div>

<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
					<div class="loader">Loading...</div>
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
	<div class="Groups col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12">
						<div><h3 class="panel-title"><a href="/list.php?type=groups">My Groups</a></h3></div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="frame" id="groupScroller">
					<div class="loader">Loading...</div>
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
	<div class="Students col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12">
						<div><h3 class="panel-title"><a href="/list.php?type=students">My Students</a></h3></div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="frame" id="studentScroller">
					<div class="loader">Loading...</div>
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

<script>
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		// List the projects
		API.GET(
			"/projects", {"year": <?php echo $year;?>, "supervisor": me.user.id},
			function (data) {
				var projects = data.body;
				document.querySelector(".Projects ul").innerHTML = scrollerHTML(data.body, "project", true);
				document.querySelector(".Projects a").innerText += ' (' + (projects && projects.length ? projects.length : 0) + ')';
				scroller("#projectScroller");
				document.getElementById("addProjectButton").style.display = "block";
				document.querySelector(".Projects .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Projects .loader").style.display = "none";

			}
		);

		// List the groups
		API.GET(
			"/groups", {"year": <?php echo $year;?>, "supervisor": me.user.id},
			function (data) {
				var groups = data.body;
				document.querySelector(".Groups ul").innerHTML = scrollerHTML(data.body, "group", true);
				document.querySelector(".Groups a").innerText += ' (' + (groups && groups.length ? groups.length : 0) + ')';
				scroller("#groupScroller");
				document.querySelector(".Groups .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Groups .loader").style.display = "none";
			}
		);

		// List the students
		API.GET(
			"/students", {"year": <?php echo $year;?>, "supervisor": me.user.id},
			function (data) {
				var students = data.body;
				document.querySelector(".Students ul").innerHTML = scrollerHTML(students, "student", true);
				document.querySelector(".Students a").innerText += ' (' + (students && students.length ? students.length : 0) + ')';
				scroller("#studentScroller");
				document.querySelector(".Students .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Students .loader").style.display = "none";
			}
		);
	});
</script>