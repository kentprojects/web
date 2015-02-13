<div class="jumbotron">
	<div class="container">
		<h3>You're in a group, go you!</h3>

		<p>Give yourself a high-five, you've made it this far.</p>

		<p>Now you need to find a project.</p>

	</div>
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
			document.querySelector(".Projects ul").innerHTML = scrollerHTML(data.body, "project");
			document.querySelector(".Projects h3").innerText = 'Projects (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);

	// List your group members
	API.GET(
		"/students", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".MyGroup ul").innerHTML = scrollerHTML(data.body, "student");
			document.querySelector(".MyGroup h3").innerText = 'My Group';
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
			document.querySelector(".Supervisors ul").innerHTML = scrollerHTML(data, "staff");
			document.querySelector(".Supervisors h3").innerText = 'Supervisors (' + data.body.length + ')';
		},
		function (data) {
			console.error(data);
		}
	);
</script>