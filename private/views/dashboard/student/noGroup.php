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
				<div class="loaderFixHeight" id="groupLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="groupScroller">
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
				<div class="loaderFixHeight" id="studentLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="studentScroller">
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
				<div class="loaderFixHeight" id="projectLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="projectScroller">
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
				<div class="loaderFixHeight" id="supervisorLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="supervisorScroller">
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
				document.querySelector("#groupScroller").className = document.querySelector("#groupScroller").className.replace("displayNone", "");
				document.querySelector("#groupLoader").className = document.querySelector("#groupLoader").className + " displayNone";
				document.querySelector(".Groups ul").innerHTML = generateScroller(".Groups ul",data.body, "group", true);
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
				document.querySelector("#projectScroller").className = document.querySelector("#projectScroller").className.replace("displayNone", "");
				document.querySelector("#projectLoader").className = document.querySelector("#projectLoader").className + " displayNone";
				document.querySelector(".Projects ul").innerHTML = generateScroller(".Projects ul", data.body, "project", true);
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
				document.querySelector("#studentScroller").className = document.querySelector("#studentScroller").className.replace("displayNone", "");
				document.querySelector("#studentLoader").className = document.querySelector("#studentLoader").className + " displayNone";
				document.querySelector(".Students ul").innerHTML = generateScroller(".Students ul", data.body, "student", true);
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
				document.querySelector("#supervisorScroller").className = document.querySelector("#supervisorScroller").className.replace("displayNone", "");
				document.querySelector("#supervisorLoader").className = document.querySelector("#supervisorLoader").className + " displayNone";


				document.querySelector(".Supervisors ul").innerHTML = generateScroller(".Supervisors ul", data.body, "staff", true);
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