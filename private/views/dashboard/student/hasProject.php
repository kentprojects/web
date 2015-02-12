<div class="jumbotron">
	<div class="container">
		<h3>You've done it!</h3>

		<p>A pat on the back is in order! Well done for finding a project.</p>

		<p>Now you just need to submit the paperwork to the CAS office.</p>

	</div>
</div>

<div class="row">
	<div class="MyProject col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">My Project</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- My project will appear here -->
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="MySupervisor col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">My Supervisor</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- My supervisor will appear here -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="MyGroup col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title sideScrollerTitle">My Group</h3>
			</div>
			<div class="panel-body">
				<div class="sideScroller" id="project-scroller">
					<ul class="list-inline noBottomMargin">
						<!-- My group will appear here -->
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
			document.querySelector(".MyProject ul").innerHTML = scrollerHTML(data);
		},
		function (data) {
			console.error(data);
		}
	);

	// List your group members
	API.GET(
		"/students", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".MyGroup ul").innerHTML = scrollerHTML(data);
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
			document.querySelector(".MySupervisor ul").innerHTML = scrollerHTML(data);
		},
		function (data) {
			console.error(data);
		}
	);
</script>