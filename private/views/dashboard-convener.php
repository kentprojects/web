<div class="row Meters">
	<div class="col-xs-0 col-sm-0 col-md-2 col-lg-2"></div>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 gauge">
		<div class="tile">
			<div id="students-in-group-gauge"></div>
		</div>
	</div>
	<div class="col-xs-0 col-sm-0 col-md-0 col-lg-2"></div>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 gauge">
		<div class="tile">
			<div id="groups-with-projects-gauge"></div>
		</div>
	</div>
	<div class="col-xs-0 col-sm-0 col-md-2 col-lg-2"></div>
</div>

<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">Projects</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- Projects will appear here -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="Groups col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">Groups</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- Groups will appear here -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="Students col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">Students</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- Students will appear here -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="Supervisors col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">Supervisors</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- Supervisors will appear here -->
					</ul>
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
			document.querySelector(".Projects ul").innerHTML = scrollerHTML(data);
			document.querySelector(".Projects h3").innerText = 'Projects (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);

	// List the groups
	API.GET(
		"/groups", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Groups ul").innerHTML = scrollerHTML(data);
			document.querySelector(".Groups h3").innerText = 'Groups (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);

	// List the students
	API.GET(
		"/students", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Students ul").innerHTML = scrollerHTML(data);
			document.querySelector(".Students h3").innerText = 'Students (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);

	// List the supervisors
	API.GET(
		"/staff", {"supervisor": true, "year": <?php echo $year;?>},
		function (data) {
			console.log(data);
			document.querySelector(".Supervisors ul").innerHTML = scrollerHTML(data);
			document.querySelector(".Supervisors h3").innerText = 'Supervisors (' + data.body.length + ')';
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
			title: "Students in groups:",
			label: "%",
			relativeGaugeSize: true
		});
		var groupsWithProjects = new JustGage({
			id: "groups-with-projects-gauge",
			value: groups_with_projects,
			min: 0,
			max: total_groups,
			title: "Groups with projects:",
			label: "%",
			relativeGaugeSize: true
		})

	}
</script>