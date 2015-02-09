<div class="jumbotron">
	<div class="container">
		<h3>You're in a group, go you!</h3>

		<p>Give yourself a high-five, you've made it this far.</p>

		<p>Now you need to find a project.</p>

	</div>
</div>

<div class="Projects">
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
<div class="Supervisors">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-mg-8 col-lg-9">
					<h3 class="panel-title sideScrollerTitle">Supervisors</h3>
				</div>
				<div class="col-xs-12 col-sm-5 col-mg-4 col-lg-3">
					<input class="form-control sideScrollerSearchBox" type="text" value=""
						placeholder="Search Supervisors" /></div>
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
			document.querySelector(".Projects ul").innerHTML = scrollerHTML(data);
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
			document.querySelector(".MyGroup ul").innerHTML = scrollerHTML(data);
			document.querySelector(".MyGroup h3").innerText = 'My Group (' + data.body.length + ')';
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