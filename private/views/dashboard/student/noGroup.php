<div class="jumbotron">
	<div class="container">
		<h3>Welcome to KentProjects!</h3>

		<p>This is your dashboard, where you can quickly search through available projects, students that aren't yet in
			groups, and supervisors.</p>

		<p>Start by finding a group you want to join, or creating your own.</p>

	</div>
</div>

<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Projects</h3>
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
				<h3 class="panel-title">Groups</h3>
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
				<h3 class="panel-title">Students</h3>
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
				<h3 class="panel-title">Supervisors</h3>
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
<script type="text/javascript">
	<!-- *** App code goes here *** -->

	// List the projects
	API.GET(
		"/projects", {"year": <?php echo $year;?>},
		function (data) {
			document.querySelector(".Projects ul").innerHTML = scrollerHTML(data.body, "project", true);
			document.querySelector(".Projects h3").innerText += ' (' + data.body.length + ')';
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
			document.querySelector(".Groups ul").innerHTML = scrollerHTML(data.body, "group", true);
			document.querySelector(".Groups h3").innerText += ' (' + data.body.length + ')';
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
			document.querySelector(".Students ul").innerHTML = scrollerHTML(data.body, "student", true);
			document.querySelector(".Students h3").innerText += ' (' + data.body.length + ')';
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
			document.querySelector(".Supervisors ul").innerHTML = scrollerHTML(data.body, "staff", true);
			document.querySelector(".Supervisors h3").innerText += ' (' + data.body.length + ')';
			scroller("#supervisorScroller");
		},
		function (data) {
			console.error(data);
		}
	);
</script>