<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
		<div class="jumbotron convenorWelcome">
			<div class="container">
				<h3>Welcome to KentProjects!</a></h3>
				<p>This is your <i>convener</i> dashboard, where you can quickly search through your projects, groups,
					and students.</p>
			</div>
		</div>
	</div>
	<div class="Meters col-xs-12 col-sm-12 col-md-6 col-lg-7">
		<div class="gauge col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="tile">
				<div id="students-in-group-gauge">
					<div class="loader">Loading...</div>
				</div>
			</div>
		</div>
		<div class="gauge col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="tile">
				<div id="groups-with-projects-gauge">
					<div class="loader">Loading...</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title" style="clear:none;"><a href="/list.php?type=projects">Projects</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="collapse navbar-collapse" id="navbar-collapse-4">
							<form class="navbar-form navbar-right noTopPadding noBottomPadding" action="#" role="search">
								<div class="form-group">
									<div class="input-group">
										<input class="form-control" id="navbarInput-01" type="search" placeholder="Search" onchange="projectSearch();" oninput="projectSearch();" onkeydown="projectSearch();" onkeypress="projectSearch();" onpaste="projectSearch();">
										<span class="input-group-btn">
											<button type="submit" class="btn"><span class="fui-search"></span></button>
										</span>
									</div>
								</div>
							</form>
						</div>
						<script type="text/javascript"> function projectSearch() {searchTiles('#projectScroller', '', document.getElementById('navbarInput-01').value, "tileLiproject");}</script>
					</div>
					<!-- End of search bit -->
				</div>
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
	<div class="Groups col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title"><a href="/list.php?type=groups">Groups</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="collapse navbar-collapse" id="navbar-collapse-4">
							<form class="navbar-form navbar-right noTopPadding noBottomPadding" action="#" role="search">
								<div class="form-group">
									<div class="input-group">
										<input class="form-control" id="navbarInput-02" type="search" placeholder="Search" onchange="groupSearch();" oninput="groupSearch();" onkeydown="groupSearch();" onkeypress="groupSearch();" onpaste="groupSearch();">
										<span class="input-group-btn">
											<button type="submit" class="btn"><span class="fui-search"></span></button>
										</span>
									</div>
								</div>
							</form>
						</div>
						<script type="text/javascript"> function groupSearch() {searchTiles('#groupScroller', '', document.getElementById('navbarInput-02').value, "tileLigroup");}</script>
					</div>
					<!-- End of search bit -->
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
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title"><a href="/list.php?type=students">Students</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="collapse navbar-collapse" id="navbar-collapse-4">
							<form class="navbar-form navbar-right noTopPadding noBottomPadding" action="#" role="search">
								<div class="form-group">
									<div class="input-group">
										<input class="form-control" id="navbarInput-03" type="search" placeholder="Search" onchange="studentSearch();" oninput="studentSearch();" onkeydown="studentSearch();" onkeypress="studentSearch();" onpaste="studentSearch();">
										<span class="input-group-btn">
											<button type="submit" class="btn"><span class="fui-search"></span></button>
										</span>
									</div>
								</div>
							</form>
						</div>
						<script type="text/javascript"> function studentSearch() {searchTiles('#studentScroller', '', document.getElementById('navbarInput-03').value, "tileListudent");}</script>
					</div>
					<!-- End of search bit -->
				</div>
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
	<div class="Supervisors col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title"><a href="/list.php?type=staff">Supervisors</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="collapse navbar-collapse" id="navbar-collapse-4">
							<form class="navbar-form navbar-right noTopPadding noBottomPadding" action="#" role="search">
								<div class="form-group">
									<div class="input-group">
										<input class="form-control" id="navbarInput-04" type="search" placeholder="Search" onchange="supervisorSearch();" oninput="supervisorSearch();" onkeydown="supervisorSearch();" onkeypress="supervisorSearch();" onpaste="supervisorSearch();">
										<span class="input-group-btn">
											<button type="submit" class="btn"><span class="fui-search"></span></button>
										</span>
									</div>
								</div>
							</form>
						</div>
						<script type="text/javascript"> function supervisorSearch() {searchTiles('#supervisorScroller', '', document.getElementById('navbarInput-04').value, "tileListaff");}</script>
					</div>
					<!-- End of search bit -->
				</div>
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

<!-- For Raphael -->
<script src="/includes/js/lib/raphael.js"></script>
<!-- For JustGage -->
<script src="/includes/js/lib/justgage.js"></script>
<script>
	<!-- *** App code goes here *** -->

	var loadQueue = loadQueue || [];

	loadQueue.push(function () {
		var total_students = 0;
		var total_groups = 0;
		var students_in_groups = 0;
		var groups_with_projects = 0;

		function setGauges() {
			var studentsInGroupsGauge = new JustGage({
				id: "students-in-group-gauge",
				value: students_in_groups,
				min: 0,
				max: total_students,
				levelColors: ["#ee0000", "#eeaa00", "#00ee00"],
				title: "Students in groups:",
				relativeGaugeSize: true,
				startAnimationTime: 0
			});

			var groupsWithProjects = new JustGage({
				id: "groups-with-projects-gauge",
				value: groups_with_projects,
				min: 0,
				max: total_groups,
				levelColors: ["#ee0000", "#eeaa00", "#00ee00"],
				title: "Groups with projects:",
				relativeGaugeSize: true,
				startAnimationTime: 0
			})

		}

		// Get the stats
		API.GET(
			"/year/"+ year +"/stats", {},
			function (data) {
				total_students = data.body.total_students;
				total_groups = data.body.total_groups;
				students_in_groups = data.body.total_students_in_groups;
				groups_with_projects = data.body.total_groups_with_projects;
				setGauges();
				document.querySelector("#students-in-group-gauge .loader").style.display = "none";
				document.querySelector("#groups-with-projects-gauge .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector("#students-in-group-gauge .loader").style.display = "none";
				document.querySelector("#groups-with-projects-gauge .loader").style.display = "none";
			}
		);

		// List the projects
		API.GET(
			"/projects", {"year": year},
			function (data) {
				document.querySelector("#projectScroller").className = document.querySelector("#projectScroller").className.replace("displayNone", "");
				document.querySelector("#projectLoader").className = document.querySelector("#projectLoader").className + " displayNone";
				document.querySelector(".Projects ul").innerHTML = generateScroller(".Projects ul", data.body, "project", true);
				document.querySelector(".Projects a").innerText += ' (' + data.body.length + ')';
				scroller("#projectScroller");
				document.querySelector(".Projects .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Projects .loader").style.display = "none";
			}
		);

		// List the groups
		API.GET(
			"/groups", {"year": year},
			function (data) {
				document.querySelector("#groupScroller").className = document.querySelector("#groupScroller").className.replace("displayNone", "");
				document.querySelector("#groupLoader").className = document.querySelector("#groupLoader").className + " displayNone";
				document.querySelector(".Groups ul").innerHTML = generateScroller(".Groups ul", data.body, "group", true);
				document.querySelector(".Groups a").innerText += ' (' + data.body.length + ')';
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
			"/students", {"year": year},
			function (data) {
				document.querySelector("#studentScroller").className = document.querySelector("#studentScroller").className.replace("displayNone", "");
				document.querySelector("#studentLoader").className = document.querySelector("#studentLoader").className + " displayNone";
				document.querySelector(".Students ul").innerHTML = generateScroller(".Students ul", data.body, "student", true);
				document.querySelector(".Students a").innerText += ' (' + data.body.length + ')';
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
				document.querySelector(".Supervisors a").innerText += ' (' + data.body.length + ')';
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