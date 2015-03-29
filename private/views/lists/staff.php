<div class="row">
	<div class="col-xs-8 col-sm-9 col-md-9">
		<h1 class="reduceHeading hideEdit">Staff</h1>
	</div>
	<div class="reduceTopMargin col-xs-4 col-sm-3 col-md-3 alignRight">
		<div class="floatRight fui-new listButtons" onclick="alert();"></div>
		<div class="floatRight fui-eye listButtons marginRight"onclick="changeListView();"></div>
	</div>

	<script type="text/javascript">
		var tileView = true;
		var listData = "";

		var loadQueue = loadQueue || [];
		loadQueue.push(function(){
			API.GET(
				"/staff/", {},
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
			var output = '<div class="row"><div class="Staff col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="flowDown frame" id="staffScroller"><ul class="clearfix tileListItems"></ul></div></div></div>';

			document.getElementById('listContents').innerHTML = output;	

			document.querySelector(".Staff ul").innerHTML = generateScroller(".Staff ul", listData.body, "staff", true);
		}
	</script>
</div>