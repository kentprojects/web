<div class="row">
	<div class="col-xs-8 col-sm-9 col-md-9">
		<h1 class="reduceHeading hideEdit">Students</h1>
	</div>
	<div class="reduceTopMargin col-xs-4 col-sm-3 col-md-3 alignRight">
		<div class="floatRight fui-new listButtons" onclick="alert();"></div>
		<div class="floatRight fui-eye listButtons marginRight"onclick="changeListView();"></div>
	</div>
</div>
<!-- Search bit -->
<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	<form class="navbar-form navbar-right noTopPadding noBottomPadding" action="#" role="search">
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
<script type="text/javascript"> function studentSearch() {searchTiles('#studentScroller', changeCheck(), document.getElementById('navbarInput-01').value, "tileListudent");}</script>
<!-- End of search bit -->
<div class="row text-center">
	<input type="checkbox" class="filterCheck" id="filterCheckbox" onchange="studentSearch()" checked> <em>Filtering:</em>
	<input type="checkbox" class="filterCheck" id="redCheck" onchange="studentSearch()" checked>No group
	<input type="checkbox" class="filterCheck" id="yellowCheck" onchange="studentSearch()" checked>No project
	<input type="checkbox" class="filterCheck" id="greenCheck" onchange="studentSearch()" checked>Has project
	<input type="checkbox" class="filterCheck" id="blueCheck" onchange="studentSearch()" checked>I supervise

	<script type="text/javascript">
		function changeCheck() {
			if (document.getElementById("filterCheckbox").checked) {
				var filters = '{"filters":[{"class":"redStatus","value":"'+document.getElementById("redCheck").checked+'"},{"class":"yellowStatus","value":"'+document.getElementById("yellowCheck").checked+'"},{"class":"greenStatus","value":"'+document.getElementById("greenCheck").checked+'"},{"class":"blueStatus","value":"'+document.getElementById("blueCheck").checked+'"}]}'
				return filters;
			}
			else {
				return "";
			}
		}
	</script>

<!-- 	<div class="container">
     	<div class="row pbl">
			<div class="col-md-2">
				<input type="checkbox" checked data-toggle="switch" id="custom-switch-01" />
			</div>
			<div class="col-md-2">
				<input type="checkbox" checked data-toggle="switch" data-on-color="default" data-off-color="primary" id="custom-switch-05" />
			</div>
			<div class="col-md-2">
				<input type="checkbox" checked data-toggle="switch" data-on-color="success" data-off-color="warning" id="custom-switch-06" />
			</div>
			<div class="col-md-2">
				<input type="checkbox" checked data-toggle="switch" data-on-color="warning" data-off-color="info" id="custom-switch-07" />
			</div>
			<div class="col-md-2">
				<input type="checkbox" checked data-toggle="switch" data-on-color="info" data-off-color="danger" id="custom-switch-08" />
			</div>
			<div class="col-md-2">
				<input type="checkbox" checked data-toggle="switch" data-on-color="danger" id="custom-switch-09" />
			</div>
		</div>
	</div> -->


<!--     <div class="container">
      <h4>Switches</h4>
      <div class="row pbl">
        <div class="col-md-2">
          <input type="checkbox" checked data-toggle="switch" id="custom-switch-01" />
        </div>
        <div class="col-md-2">
          <input type="checkbox" data-toggle="switch" id="custom-switch-02" />
        </div>
        <div class="col-md-2">
          <div class="bootstrap-switch-square">
            <input type="checkbox" checked data-toggle="switch" id="custom-switch-03" data-on-text="<span class='fui-check'></span>" data-off-text="<span class='fui-cross'></span>" />
          </div>
        </div>
        <div class="col-md-2">
          <div class="bootstrap-switch-square">
            <input type="checkbox" data-toggle="switch" id="custom-switch-04" />
          </div>
        </div>
        <div class="col-md-2">
          <input type="checkbox" checked disabled data-toggle="switch" id="custom-switch-10" />
        </div>
        <div class="col-md-2">
          <div class="bootstrap-switch-square">
            <input type="checkbox" checked disabled data-toggle="switch" id="custom-switch-11" />
          </div>
        </div>
      </div>
      <h6>Custom colors</h6>
      <div class="row pbl">
        <div class="col-md-2">
          <input type="checkbox" checked data-toggle="switch" data-on-color="default" data-off-color="primary" id="custom-switch-05" />
        </div>
        <div class="col-md-2">
          <input type="checkbox" checked data-toggle="switch" data-on-color="success" data-off-color="warning" id="custom-switch-06" />
        </div>
        <div class="col-md-2">
          <input type="checkbox" checked data-toggle="switch" data-on-color="warning" data-off-color="info" id="custom-switch-07" />
        </div>
        <div class="col-md-2">
          <input type="checkbox" checked data-toggle="switch" data-on-color="info" data-off-color="danger" id="custom-switch-08" />
        </div>
        <div class="col-md-2">
          <input type="checkbox" checked data-toggle="switch" data-on-color="danger" id="custom-switch-09" />
        </div>
      </div>
    </div>--><!-- /.container -->



	<script type="text/javascript">
		var tileView = true;
		var listData = "";

		var loadQueue = loadQueue || [];
		loadQueue.push(function(){
			API.GET(
				"/students/", {},
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
			var output = '<div class="row"><div class="Students col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="flowDown frame" id="studentScroller"><ul class="clearfix tileListItems"></ul></div></div></div>';

			document.getElementById('listContents').innerHTML = output;	

			document.querySelector(".Students ul").innerHTML = generateScroller(".Students ul", listData.body, "student", true);
		}
	</script>
</div>