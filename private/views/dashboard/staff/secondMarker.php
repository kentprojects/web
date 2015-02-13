<div class="jumbotron">
	<div class="container">
		<h3>Welcome to KentProjects!</h3>

		<p>This is your <i>second-marker</i> dashboard, where you can access any projects you will be marking.</p>
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
</script>