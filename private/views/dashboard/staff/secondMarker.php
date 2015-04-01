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
				<div class="row">
					<div class="col-xs-12 col-sm-7">
						<h3 class="panel-title"><a href="/list.php?type=projects">My Projects</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5">
						<div class="navbar-form navbar-right noTopPadding noBottomPadding" role="search">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="navbarInput-01" type="search" autocomplete="off" placeholder="Search" onchange="groupSearch();" oninput="groupSearch();" onkeydown="groupSearch();" onkeypress="groupSearch();" onpaste="groupSearch();">
									<span class="input-group-btn">
										<button type="submit" class="btn"><span class="fui-search"></span></button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<script type="text/javascript"> function groupSearch() {searchTiles('#projectScroller', '', document.getElementById('navbarInput-01').value, "tileLiproject");}</script>
					<!-- End of search bit -->
				</div>
			</div>
			<div class="panel-body">
				<div class="loaderFixHeight" id="projectLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="projectScroller">
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
				document.querySelector("#projectScroller").className = document.querySelector("#projectScroller").className.replace("displayNone", "");
				document.querySelector("#projectLoader").className = document.querySelector("#projectLoader").className + " displayNone";
				document.querySelector(".Projects ul").innerHTML = generateScroller(".Projects ul", data.body, "project", true);
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