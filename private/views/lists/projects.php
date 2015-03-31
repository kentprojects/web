<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		<h1 class="reduceHeading hideEdit float-left listHeading">Projects</h1>
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
	<script type="text/javascript"> function studentSearch() {searchTiles('#projectScroller', changeCheck(), document.getElementById('navbarInput-01').value, "tileLiproject");}</script>
	<!-- End of search bit -->
</div>
<!-- Filter bit -->
<form role="form">
	<div class="form-group filters">
		<label class="checkbox" for="checkbox1">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox1" class="custom-checkbox" onchange="toggleFilters();"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			<b><em>Enable filtering</em></b>
		</label>
		<label class="checkbox" for="checkbox2">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox2" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			Not taken
		</label>
		<label class="checkbox" for="checkbox3">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox3" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			Taken
		</label>
		<label class="checkbox" for="checkbox4">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox4" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			Not my Project
		</label>
		<label class="checkbox" for="checkbox5">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox5" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			My project
		</label>
	</div>
</form>
<script type="text/javascript">
	function changeCheck() {
		if (document.getElementById("checkbox1").checked) {
			var filters = '{"filters":[{"class":"projectNotTaken","value":"'+document.getElementById("checkbox2").checked+'"},{"class":"projectTaken","value":"'+document.getElementById("checkbox3").checked+'"},{"class":"notBlueStatus","value":"'+document.getElementById("checkbox4").checked+'"},{"class":"blueStatus","value":"'+document.getElementById("checkbox5").checked+'"}]}'
			return filters;
		}
		else {
			return "";
		}
	}

	function toggleFilters () {
		if (document.querySelector("#checkbox1").checked) {
			document.querySelector("#checkbox2").disabled = false;
			document.querySelector("#checkbox3").disabled = false;
			document.querySelector("#checkbox4").disabled = false;
			document.querySelector("#checkbox5").disabled = false;
		}
		else {
			document.querySelector("#checkbox2").disabled = true;
			document.querySelector("#checkbox3").disabled = true;
			document.querySelector("#checkbox4").disabled = true;
			document.querySelector("#checkbox5").disabled = true;
		}
		studentSearch();
	}
</script>
<!-- End of filter bit -->
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
		studentSearch();
	}

	function viewList(listData) {
		tileView = false;
		var output = "<div class='nothingToShow displayNone text-center text-info'>There's nothing to show here.</div><table class='table table-striped listTable'><thead><tr><th></th><th>Name</th><th>Supervisor</th></tr></thead><tbody>";
		for (var i = 0; i < listData.body.length; i++) {
			var dataTag = "";
			var extraClass = "";
			if (listData.body[i].group) {
				dataTag = "<a href='/profile.php?type=group&id=" + listData.body[i].group + "'><span class='label label-primary tableLabel'>Taken</span></a>";
				extraClass += " projectTaken";
			}
			else {
				extraClass += " projectNotTaken";
			}
			if (listData.body[i].supervisor.id == me.user.id) {
				dataTag += "<span class='label label-info tableLabel'>My project</span>";
				extraClass += " blueStatus ignoreStatusColor";
			}
			else {
				extraClass += " notBlueStatus";
			}
			output += "<tr class='tileLiproject" + extraClass + "'><td>" + dataTag + "</td><td class='rowTitle'><a href='/profile.php?type=project&id=" + listData.body[i].id + "'>" + listData.body[i].name + "</a></td><td class='rowSubText'><a href='/profile.php?type=staff&id=" + listData.body[i].supervisor.id + "'>" + listData.body[i].supervisor.name + "</a></td></tr>";
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