<div class="row">
	<div class="col-xs-7 col-sm-7 col-md-7">
		<h1 class="reduceHeading hideEdit"> Projects </h1>
	</div>
	<div class="reduceTopMargin col-xs-5 col-sm-5 col-md-5 alignRight">
		<div class="floatRight fui-new listButtons" onclick="alert();"></div>
		<div class="floatRight fui-eye listButtons marginRight"onclick="changeListView();"></div>
	</div>

	<script type="text/javascript">
		var tileView = true;
		var listData = "";

		API.GET(
			"/projects", {"year": year},
			function sucess(data) {
				listData = data;
				if (getWidth() < 550) {
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

			document.querySelector(".Projects ul").innerHTML = scrollerHTML(listData.body, "project", true);
		}
	</script>
</div>