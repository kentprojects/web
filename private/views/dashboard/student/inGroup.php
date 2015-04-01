<!--
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */-->
<!--Show a message to tell the user their status.-->
<div class="jumbotron">
	<div class="container">
		<h3>You're in a group, go you!</h3>

		<p>Give yourself a high-five, you've made it this far.</p>

		<p>Now you need to find a project.</p>

	</div>
</div>
<!--Generate a Projects scroller with search functionality-->
<div class="row">
	<div class="Projects col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title"><a href="/list.php?type=projects">Projects</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="navbar-form navbar-right noTopPadding noBottomPadding" role="search">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="navbarInput-01" type="search" autocomplete="off" placeholder="Search" onchange="projectSearch();" oninput="projectSearch();" onkeydown="projectSearch();" onkeypress="projectSearch();" onpaste="projectSearch();">
									<span class="input-group-btn">
										<button type="submit" class="btn"><span class="fui-search"></span></button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<script type="text/javascript"> function projectSearch() {searchTiles('#projectScroller', '', document.getElementById('navbarInput-01').value, "tileLiproject");}</script>
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
<!--Generate a Supervisors scroller with search functionaliry-->
<div class="row">
	<div class="Supervisors col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title"><a href="/list.php?type=staff">Supervisors</a></h3>
					</div>
					<!-- Search bit -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="navbar-form navbar-right noTopPadding noBottomPadding" role="search">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="navbarInput-02" type="search" autocomplete="off" placeholder="Search" onchange="supervisorSearch();" oninput="supervisorSearch();" onkeydown="supervisorSearch();" onkeypress="supervisorSearch();" onpaste="supervisorSearch();">
									<span class="input-group-btn">
										<button type="submit" class="btn"><span class="fui-search"></span></button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<script type="text/javascript"> function supervisorSearch() {searchTiles('#supervisorScroller', '', document.getElementById('navbarInput-02').value, "tileListaff");}</script>
					<!-- End of search bit -->
				</div>
			</div>
			<div class="panel-body">
				<div class="loaderFixHeight" id="supervisorLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="supervisorScroller">
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
<!--Generate a student scroller showing all the students in the group that the current user in a part of.-->
<div class="row">
	<div class="MyGroup col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12">
						<h3 class="panel-title"><a href="/profile.php?shortcut=myGroup">My Group</a></h3>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="loaderFixHeight" id="myGroupLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="myGroupScroller">
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
<!--Generate a student scroller showing all the students in the current year.-->
<div class="row">
	<div class="Students col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
						<h3 class="panel-title"><a href="/list.php?type=students">Students</a></h3>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="loaderFixHeight" id="studentLoader">
					<div class="loader">Loading...</div>
				</div>
				<div class="frame displayNone" id="studentScroller">
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
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
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

		// List the supervisors
		API.GET(
			"/staff", {"supervisor": true, "year": year},
			function (data) {
				document.querySelector("#supervisorScroller").className = document.querySelector("#supervisorScroller").className.replace("displayNone", "");
				document.querySelector("#supervisorLoader").className = document.querySelector("#supervisorLoader").className + " displayNone";
				document.querySelector(".Supervisors ul").innerHTML = generateScroller(".Supervisors ul", data.body, "staff", true);
				document.querySelector(".Supervisors a").innerText += ' (' + data.body.length + ')';
				scroller("#supervisorScroller");
				document.querySelector(".Supervisors .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Supervisors .loader").style.display = "none";
			}
		);

		// List your group members
		API.GET(
			"/students", {"group": me.group.id},
			function (data) {
				var groupMembers = data.body;
				document.querySelector("#myGroupScroller").className = document.querySelector("#myGroupScroller").className.replace("displayNone", "");
				document.querySelector("#myGroupLoader").className = document.querySelector("#myGroupLoader").className + " displayNone";
				document.querySelector(".MyGroup ul").innerHTML = generateScroller(".MyGroup ul", groupMembers, "student", true);
				document.querySelector(".MyGroup a").innerText = 'My Group - ' + me.group.name + ' (' + groupMembers.length + ')';
				scroller("#myGroupScroller");
				document.querySelector(".MyGroup .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Students .loader").style.display = "none";
			}
		);

		// List the students
		API.GET(
			"/students", {"year": year},
			function (data) {
				document.querySelector("#studentScroller").className = document.querySelector("#studentScroller").className.replace("displayNone", "");
				document.querySelector("#studentLoader").className = document.querySelector("#studentLoader").className + " displayNone";
				document.querySelector(".Students ul").innerHTML = generateScroller(".Students ul", data.body, "student", true);
				document.querySelector(".Students a").innerText += ' (' + data.body.length + ')';
				scroller("#studentScroller");
				document.querySelector(".Students .loader").style.display = "none";
			},
			function (data) {
				console.error(data);
				document.querySelector(".Students .loader").style.display = "none";
			}
		);

	});
</script>