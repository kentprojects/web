<div class="jumbotron">
	<div class="container">
		<h3>Welcome to KentProjects!</h3>

		<p>This is your <i>second-marker</i> dashboard, where you can access any projects you will be marking.</p>
	</div>
</div>
<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><a href="/list.php?type=projects">My Projects</a></h3>
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

<script>
	<!-- *** App code goes here *** -->
	var loadQueue = loadQueue || [];
	loadQueue.push(function() {
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
	});
</script>