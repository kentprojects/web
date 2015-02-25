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
				<div id="students-in-group-gauge"></div>
			</div>
		</div>
		<div class="gauge col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="tile">
				<div id="groups-with-projects-gauge"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><a href="/list.php?type=projects">Projects</a></h3>
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
	<div class="Groups col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><a href="/list.php?type=groups">Groups</a></h3>
			</div>
			<div class="panel-body">
				<div class="frame" id="groupScroller">
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
				<h3 class="panel-title"><a href="/list.php?type=students">Students</a></h3>
			</div>
			<div class="panel-body">
				<div class="frame" id="studentScroller">
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
				<h3 class="panel-title"><a href="/list.php?type=staff">Supervisors</a></h3>
			</div>
			<div class="panel-body">
				<div class="frame" id="supervisorScroller">
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
	<!-- *** App code goes here *** -->

	// List the projects
	API.GET(
		"/projects", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Projects ul").innerHTML = scrollerHTML(data.body, "project");
			document.querySelector(".Projects a").innerText += ' (' + data.body.length + ')';
			scroller("#projectScroller");
		},
		function (data) {
			console.error(data);
		}
	);

	// List the groups
	API.GET(
		"/groups", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Groups ul").innerHTML = scrollerHTML(data.body, "group");
			document.querySelector(".Groups a").innerText += ' (' + data.body.length + ')';
			scroller("#groupScroller");
		},
		function (data) {
			console.error(data);
		}
	);

	// List the students
	API.GET(
		"/students", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Students ul").innerHTML = scrollerHTML(data.body, "student");
			document.querySelector(".Students a").innerText += ' (' + data.body.length + ')';
			scroller("#studentScroller");
		},
		function (data) {
			console.error(data);
		}
	);

	// List the supervisors
	API.GET(
		"/staff", {"supervisor": true, "year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Supervisors ul").innerHTML = scrollerHTML(data.body, "staff");
			document.querySelector(".Supervisors a").innerText += ' (' + data.body.length + ')';
			scroller("#supervisorScroller");
		},
		function (data) {
			console.error(data);
		}
	);

</script>

<!-- For Raphael -->
<script src="/includes/js/raphael.js"></script>
<!-- For JustGage -->
<script src="/includes/js/justgage.js"></script>

<!-- Set the gauges -->
<script>
	var total_students = 0;
	var total_groups = 0;
	var students_in_groups = 0;
	var groups_with_projects = 0;
	// Get the stats
	API.GET(
		"/year/<?php echo $year;?>/stats", {},
		function (data) {
			total_students = data.body.total_students;
			total_groups = data.body.total_groups;
			students_in_groups = data.body.total_students_in_groups;
			groups_with_projects = data.body.total_groups_with_projects;

			setGauges();
		},
		function (data) {
			console.error(data);
		}
	);
	function setGauges() {
		var studentsInGroupsGauge = new JustGage({
			id: "students-in-group-gauge",
			value: students_in_groups,
			min: 0,
			max: total_students,
			levelColors: ["#ff0000", "#f9c802", "#a9d70b"],
			title: "Students in groups:",
			relativeGaugeSize: true,
			startAnimationTime: 0
		});
		var groupsWithProjects = new JustGage({
			id: "groups-with-projects-gauge",
			value: groups_with_projects,
			min: 0,
			max: total_groups,
			levelColors: ["#ff0000", "#f9c802", "#a9d70b"],
			title: "Groups with projects:",
			relativeGaugeSize: true,
			startAnimationTime: 0
		})

	}
</script>