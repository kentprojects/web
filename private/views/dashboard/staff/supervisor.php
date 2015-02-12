<div class="jumbotron">
	<div class="container">
		<h3>Welcome to KentProjects!</h3>

		<p>This is your <i>supervisor</i> dashboard, where you can quickly search through your projects, groups, and students.</p>

	</div>
</div>

<div class="MyProjects">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Projects</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value=""
						placeholder="Search Projects" /></div>
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
<div class="MyGroups">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Groups</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value="" placeholder="Search Groups"/></div>
			</div>
		</div>
		<div class="panel-body">
			<div class="sideScroller" id="project-scroller">
				<ul class="list-inline noBottomMargin">
					<!-- Groups appear here -->
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="MyStudents">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Students</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value=""
						placeholder="Search Students" /></div>
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

<script>

	<!-- *** App code goes here *** -->

	// List the projects
	API.GET(
		"/projects", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".MyProjects ul").innerHTML = scrollerHTML(data.body, "project");
			document.querySelector(".MyProjects h3").innerText = 'My Projects (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);

	// List the groups
	API.GET(
		"/groups", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".MyGroups ul").innerHTML = scrollerHTML(data.body, "group");
			document.querySelector(".MyGroups h3").innerText = 'My Groups (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);

	// List the students
	API.GET(
		"/students", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".MyStudents ul").innerHTML = scrollerHTML(data.body, "student");
			document.querySelector(".MyStudents h3").innerText = 'My Students (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);
</script>