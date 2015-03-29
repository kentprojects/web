<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		<h1 class="reduceHeading hideEdit float-left listHeading">Projects</h1>
		<div class="reduceTopMargin alignRight listButtonsDiv">
			<div class="floatRight fui-new listButtons" onclick="alert();"></div>
			<div class="floatRight fui-eye listButtons marginRight"onclick="changeListView();"></div>
		</div>
	</div>
	<!-- Search bit -->
	<div class="col-xs-12 col-sm-4 col-md-4">
		<form class="navbar-form navbar-right listSearchbox noBottomPadding" action="#" role="search">
			<div class="form-group">
				<div class="input-group">
					<input class="form-control" id="navbarInput-01" type="search" placeholder="Search" onchange="studentSearch();" oninput="studentSearch();" onkeydown="studentSearch();" onkeypress="studentSearch();" onpaste="studentSearch();">
					<span class="input-group-btn">
						<button type="submit" class="btn"><span class="fui-search"></span></button>
					</span>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript"> function studentSearch() {searchTiles('#projectScroller', ""/*changeCheck()*/, document.getElementById('navbarInput-01').value, "tileLiproject");}</script>
	<!-- End of search bit -->
	<script type="text/javascript">
		var tileView = true;
		var listData = "";

		var loadQueue = loadQueue || [];
		loadQueue.push(function(){
			API.GET(
				"/projects", {"year": year},
				function sucess(data) {
					listData = data;
					if (window.innerWidth < 550) {
						// View as list
						viewList(listData);
					}
					else {
						// View as tiles
						viewTiles(listData);
					}
				},
				function error(data) {
					console.error(data);
				}
			);
		});

		function changeListView() {
			if (tileView) {
				viewList(listData);
			}
			else {
				viewTiles(listData);
			}
		}

		function viewList(listData) {
			tileView = false;
			var output = "<table class='table table-striped'><thead><tr><th>Name</th></tr></thead><tbody>";
			for (var i = 0; i < listData.body.length; i++) {
				output += "<tr><td>" + listData.body[i].name + "</td></tr>";
			};
			output += "</tbody></table>";
			document.getElementById('listContents').innerHTML = output;	
		}

		function viewTiles(listData) {
			tileView = true;
			var output = '<div class="row"><div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="flowDown frame" id="projectScroller"><ul class="clearfix tileListItems"></ul></div></div></div>';

			document.getElementById('listContents').innerHTML = output;	

			document.querySelector(".Projects ul").innerHTML = generateScroller(".Projects ul", listData.body, "project", true);
		}
	</script>
</div>