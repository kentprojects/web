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
				<h3 class="panel-title"><a href="/list.php?type=projects">Projects</a></h3>
			</div>
			<div class="panel-body">
				<div class="frame" id="projectScroller">
					<div class="loader">Loading...</div>
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
					<div class="loader">Loading...</div>
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
	<div class="MyGroup col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><a href="/profile.php?shortcut=myGroup">My Group</a></h3>
			</div>
			<div class="panel-body">
				<div class="frame" id="myGroupScroller">
					<div class="loader">Loading...</div>
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
					<div class="loader">Loading...</div>
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
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		// List the projects
		API.GET(
			"/projects", {"year": year},
			function (data) {
				document.querySelector(".Projects ul").innerHTML = scrollerHTML(data.body, "project", true);
				document.querySelector(".Projects a").innerText += ' (' + data.body.length + ')';
				scroller("#projectScroller");
				document.querySelector(".Projects .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Projects .loader").style.display = "none";
			}
		);

		// List the supervisors
		API.GET(
			"/staff", {"supervisor": true, "year": year},
			function (data) {
				document.querySelector(".Supervisors ul").innerHTML = scrollerHTML(data.body, "staff", true);
				document.querySelector(".Supervisors a").innerText += ' (' + data.body.length + ')';
				scroller("#supervisorScroller");
				document.querySelector(".Supervisors .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Supervisors .loader").style.display = "none";
			}
		);

		// List your group members
		document.querySelector(".MyGroup ul").innerHTML = scrollerHTML(me.group.students, "student", false);
		document.querySelector(".MyGroup a").innerText = 'My Group - ' + me.group.name + ' (' + me.group.students.length + ')';
		scroller("#myGroupScroller");
		document.querySelector(".MyGroup .loader").style.display = "none";

		// List the students
		API.GET(
			"/students", {"year": year},
			function (data) {
				document.querySelector(".Students ul").innerHTML = scrollerHTML(data.body, "student", true);
				document.querySelector(".Students h3").innerText += ' (' + data.body.length + ')';
				scroller("#studentScroller");
				document.querySelector(".Students .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Students .loader").style.display = "none";
			}
		);

	});
</script>