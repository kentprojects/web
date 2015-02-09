<div class="jumbotron">
	<div class="container">
		<h3>You've done it!</h3>

		<p>A pat on the back is in order! Well done for finding a project.</p>

		<p>Now you just need to submit the paperwork to the CAS office.</p>

	</div>
</div>

<div class="MyProject">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-mg-12 col-lg-12">
					<h3 class="panel-title sideScrollerTitle">My Project</h3>
				</div>
			</div>
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
<div class="MySupervisor">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-mg-12 col-lg-12">
					<h3 class="panel-title sideScrollerTitle">My Supervisor</h3>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="sideScroller" id="project-scroller">
				<ul class="list-inline noBottomMargin">
					<!-- My supervisor appear here -->
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="MyGroup">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-mg-12 col-lg-12">
					<h3 class="panel-title sideScrollerTitle">My Group</h3>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="sideScroller" id="project-scroller">
				<ul class="list-inline noBottomMargin">
					<!-- My Group members appear here -->
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