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

<div class="Projects">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Projects</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value="" placeholder="Search Projects"/></div>
			</div>
		</div>
		<div class="panel-body">
			<div class="sideScroller" id="project-scroller">
				<ul class="list-inline noBottomMargin">
					<!-- Projects appear here -->
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="Students">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Students</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value="" placeholder="Search Students"/></div>
			</div>
		</div>
		<div class="panel-body">
			<div class="sideScroller" id="project-scroller">
				<ul class="list-inline noBottomMargin">
					<!-- Students appear here -->
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="Supervisors">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Supervisors</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value="" placeholder="Search Supervisors"/></div>
			</div>
		</div>
		<div class="panel-body">
			<div class="sideScroller" id="project-scroller">
				<ul class="list-inline noBottomMargin">
					<!-- Supervisors appear here -->
				</ul>
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

	// Generates a scroller
	function scrollerHTML(data) {
		if (data.body.length > 0) {
			var item, HTML = [];
			for (var i = 0; i < data.body.length; i++) {
				item = data.body[i];
				HTML.push(
					'<li class="sideScrollerItem noBottomMargin">',
					'<div class="tile scrollerTile noBottomMargin">',
					'<div class="tile-title">' + item.name + '</div>',
					'</div>',
					'</li>'
				);
			}
			return HTML.join("");
		}
		else {
			return '<div class="scrollerPlaceholder noBottomMargin"><div class="text-info"> There\'s nothing here yet! </div></div>';
		}
	}
	;
</script>