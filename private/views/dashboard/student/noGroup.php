<div class="jumbotron">
	<div class="container">
		<h3>Welcome to KentProjects!</h3>

		<p>This is your dashboard, where you can quickly search through available projects, students that aren't yet in
			groups, and supervisors.</p>

		<p>Start by finding a group you want to join, or creating your own.</p>

	</div>
</div>

<div class="row">
	<div class="Groups col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-8">
						<div><h3 class="panel-title"><a href="/list.php?type=groups">Groups</a></h3></div>
					</div>
					<div class="col-xs-4">
						<div class="text-right">
							<a class="btn btn-info panelHeadingButton displayNone" id="addGroupButton"
								href="/new.php?type=group"><span class="fui-plus"></span> Add</a>
						</div>
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
				<h3 class="panel-title">Students</h3>
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

<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Projects</h3>
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
	<div class="Supervisors col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Supervisors</h3>
			</div>
			<div class="panel-body">
				<div class="frame" id="supervisorScroller">
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
<script type="text/javascript">
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {

		// List the groups
		API.GET(
			"/groups", {"year": year},
			function (data) {
				document.querySelector(".Groups ul").innerHTML = scrollerHTML(data.body, "group", true);
				document.querySelector(".Groups h3").innerText += ' (' + data.body.length + ')';
				scroller("#groupScroller");
				document.getElementById("addGroupButton").style.display = "block";
				document.querySelector(".Groups .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Groups .loader").style.display = "none";
			}
		);

		// List the projects
		API.GET(
			"/projects", {"year": year},
			function (data) {
				document.querySelector(".Projects ul").innerHTML = scrollerHTML(data.body, "project", true);
				document.querySelector(".Projects h3").innerText += ' (' + data.body.length + ')';
				scroller("#projectScroller");
				document.querySelector(".Projects .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Projects .loader").style.display = "none";
			}
		);

		// List the students
		API.GET(
			"/students", {"year": year},
			function (data) {
				document.querySelector(".Students ul").innerHTML = scrollerHTML(data.body, "student", true);
				document.querySelector(".Students h3").innerText += ' (' + data.body.length + ')';
				scroller("#studentScroller");
				document.querySelector(".Students .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Students .loader").style.display = "none";
			}
		);

		// List the supervisors
		API.GET(
			"/staff", {"supervisor": true, "year": year},
			function (data) {
				document.querySelector(".Supervisors ul").innerHTML = scrollerHTML(data.body, "staff", true);
				document.querySelector(".Supervisors h3").innerText += ' (' + data.body.length + ')';
				scroller("#supervisorScroller");
				document.querySelector(".Supervisors .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Supervisors .loader").style.display = "none";
			}
		);
	});
</script>