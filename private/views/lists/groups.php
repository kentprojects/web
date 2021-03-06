<!--
/**
 * @author: Matt Weeks <matt.weeks@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */—->
<!-- Add title and change list view button.-->
<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		<h1 class="reduceHeading hideEdit float-left listHeading">Groups</h1>
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
	<script type="text/javascript"> function studentSearch() {searchTiles('#groupScroller', changeCheck(), document.getElementById('navbarInput-01').value, "tileLigroup");}</script>
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
			No project
		</label>
		<label class="checkbox" for="checkbox3">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox3" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			Project selected
		</label>
		<label class="checkbox" for="checkbox4">
			<input type="checkbox" data-toggle="checkbox" checked id="checkbox4" class="custom-checkbox" onchange="studentSearch()"><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
			My project selected
		</label>
	</div>
</form>
<script type="text/javascript">
	/**
	 * Creates a JSON sting according to the filters that are active on the page.
	 * @returns filtersJSON
	 */
	function changeCheck() {
		if (document.getElementById("checkbox1").checked) {
			var filters = '{"filters":[{"class":"yellowStatus","value":"'+document.getElementById("checkbox2").checked+'"},{"class":"greenStatus","value":"'+document.getElementById("checkbox3").checked+'"},{"class":"blueStatus","value":"'+document.getElementById("checkbox4").checked+'"}]}'
			return filters;
		}
		else {
			return "";
		}
	}

	/**
	 * Enables or disables the filter checkboxes depending on the 'Enable filters' checkbox.
	 * @returns { void }
	 */
	function toggleFilters () {
		if (document.querySelector("#checkbox1").checked) {
			document.querySelector("#checkbox2").disabled = false;
			document.querySelector("#checkbox3").disabled = false;
			document.querySelector("#checkbox4").disabled = false;
		}
		else {
			document.querySelector("#checkbox2").disabled = true;
			document.querySelector("#checkbox3").disabled = true;
			document.querySelector("#checkbox4").disabled = true;
		}
		studentSearch();
	}
</script>
<!-- End of filter bit -->
<script type="text/javascript">
	var tileView = true;
	var listData = "";

	/**
	 * Gets all the data to produce the lists from the API.
	 */
	var loadQueue = loadQueue || [];
	loadQueue.push(function(){
		API.GET(
			"/groups/", {"year": year},
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

	/**
	 * Switch between the tile view and the list view.
	 */
	function changeListView() {
		if (tileView) {
			viewList(listData);
		}
		else {
			viewTiles(listData);
		}
		studentSearch();
	}

	/**
	 * Generate the list from the data retrieved from the API in a table view.
	 * @param listData
	 */
	function viewList(listData) {
		tileView = false;
		var output = "<div class='nothingToShow displayNone text-center text-info'>There's nothing to show here...</div><table class='table table-striped listTable'><thead><tr><th></th><th>Name</th></tr></thead><tbody>";
		for (var i = 0; i < listData.body.length; i++) {
			var dataTag = "";
			var extraClass = "";
			if (listData.body[i].project) {
				if (listData.body[i].project.supervisor.id == me.user.id) {
					dataTag = "<a href='/profile.php?type=project&id=" + listData.body[i].project.id + "'><span class='label label-info'>My project</span></a>";
					extraClass += " blueStatus ignoreStatusColor";
				}
				else {
					dataTag = "<a href='/profile.php?type=project&id=" + listData.body[i].project.id + "'><span class='label label-success'>Has project</span></a>";
					extraClass += " greenStatus ignoreStatusColor";
				}
			}
			else {
				dataTag = "<span class='label label-warning'>No project</span>";
				extraClass += " yellowStatus ignoreStatusColor";
			}
			output += "<tr class='tileLigroup" + extraClass + "'><td>" + dataTag + "</td><td class='rowTitle'><a href='/profile.php?type=group&id=" + listData.body[i].id + "'>" + listData.body[i].name + "</a></td></tr>";
		};
		output += "</tbody></table>";
		document.getElementById('listContents').innerHTML = output;	
	}

	/**
	 * Generate the list from the data retrieved from the API in a tile view.
	 * @param listData
	 */
	function viewTiles(listData) {
		tileView = true;
		var output = '<div class="row"><div class="Groups col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="flowDown frame" id="groupScroller"><ul class="clearfix tileListItems"></ul></div></div></div>';
		document.getElementById('listContents').innerHTML = output;	
		document.querySelector(".Groups ul").innerHTML = generateScroller(".Groups ul", listData.body, "group", true);
	}
</script>