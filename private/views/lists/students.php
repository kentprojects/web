<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		<h1 class="reduceHeading hideEdit float-left listHeading">Students</h1>
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
	<script type="text/javascript"> function studentSearch() {searchTiles('#studentScroller', changeCheck(), document.getElementById('navbarInput-01').value, "tileListudent");}</script>
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
			No group
		</label>
		<label class="checkbox" for="checkbox3">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox3" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			No project
		</label>
		<label class="checkbox" for="checkbox4">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox4" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			Project selected
		</label>
		<label class="checkbox" for="checkbox5">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox5" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			My project selected
		</label>
	</div>
</form>
<script type="text/javascript">
	function changeCheck() {
		if (document.getElementById("checkbox1").checked) {
			var filters = '{"filters":[{"class":"redStatus","value":"'+document.getElementById("checkbox2").checked+'"},{"class":"yellowStatus","value":"'+document.getElementById("checkbox3").checked+'"},{"class":"greenStatus","value":"'+document.getElementById("checkbox4").checked+'"},{"class":"blueStatus","value":"'+document.getElementById("checkbox5").checked+'"}]}'
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
			"/students/", {},
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
		var output = "<table class='table table-striped'><thead><tr><th></th><th>Name</th><th>Group</th></tr></thead><tbody>";
		for (var i = 0; i < listData.body.length; i++) {
			var dataTag = "";
			var groupLink = "";
			//if in group
			if (listData.body[i].group) {
				if (listData.body[i].group.project) {
					if (listData.body[i].group.project.supervisor.id == me.user.id) {
						dataTag = "<a href='/profile.php?type=project&id=" + listData.body[i].group.project.id + "'><span class='label label-info tableLabel'>My project</span></a>";
					}
					else {
						dataTag = "<a href='/profile.php?type=project&id=" + listData.body[i].group.project.id + "'><span class='label label-success tableLabel'>Has project</span></a>";
					}
				}
				else {
					dataTag = "<a href='/profile.php?type=group&id=" + listData.body[i].group.id + "'><span class='label label-warning tableLabel'>No project</span></a>";
				}
				groupLink = "<a href='/profile.php?type=group&id=" + listData.body[i].group.id + "'>" + listData.body[i].group.name + "</a>";
			}
			else {
				dataTag = "<span class='label label-danger tableLabel'>No group</span></a>";
			}
			output += "<tr><td>" + dataTag + "</td><td><a href='/profile.php?type=project&id=" + listData.body[i].id + "'>" + listData.body[i].name + "</a></td><td>" + groupLink + "</td></tr>";
		};
		output += "</tbody></table>";
		document.getElementById('listContents').innerHTML = output;	
	}

	function viewTiles(listData) {
		tileView = true;
		var output = '<div class="row"><div class="Students col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="flowDown frame" id="studentScroller"><ul class="clearfix tileListItems"></ul></div></div></div>';
		document.getElementById('listContents').innerHTML = output;	
		document.querySelector(".Students ul").innerHTML = generateScroller(".Students ul", listData.body, "student", true);
	}
</script>