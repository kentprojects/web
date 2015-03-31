<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		<h1 class="reduceHeading hideEdit float-left listHeading">Staff</h1>
		<div class="reduceTopMargin alignRight listButtonsDiv">
			<div class="floatRight fui-eye listButtons marginRight"onclick="changeListView();"></div>
		</div>
	</div>
	<!-- Search bit -->
	<div class="col-xs-12 col-sm-4 col-md-4">
		<div class="navbar-form navbar-right listSearchbox noBottomPadding" role="search">
			<div class="form-group">
				<div class="input-group">
					<input class="form-control" id="navbarInput-01" type="search" placeholder="Search" onchange="studentSearch();" oninput="studentSearch();" onkeydown="studentSearch();" onkeypress="studentSearch();" onpaste="studentSearch();">
					<span class="input-group-btn">
						<button type="submit" class="btn"><span class="fui-search"></span></button>
					</span>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript"> function studentSearch() {searchTiles('#staffScroller', "", document.getElementById('navbarInput-01').value, "tileListaff");}</script>
	<!-- End of search bit -->
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
			studentSearch();
		}

		function viewList(listData) {
			tileView = false;
			var output = "<div class='nothingToShow displayNone text-center text-info'>There's nothing to show here...</div><table class='table table-striped listTable'><thead><tr><th>Name</th></tr></thead><tbody>";
			for (var i = 0; i < listData.body.length; i++) {
				output += "<tr class='tileListaff'><td class='rowTitle'><a href='/profile.php?type=staff&id=" + listData.body[i].id + "'>" + listData.body[i].name + "</a></td></tr>";
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