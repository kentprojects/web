<!--
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */-—>
<!-- HTML to generate the group profile page -->
<div class="container">
	<div class="row">
		<div class="col-xs-12"><h1 id="groupName">&nbsp;</h1></div>

	</div>
	<div class="row">
		<div class="groupMembers col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<h3 class="panel-title">Group Members</h3>
						</div>
						<div class="col-xs-3 col-sm-2 col-md-1"></div>
						<div class="col-xs-6 col-sm-4 col-md-5">
							<div class="text-center" id="membershipOptions">
								<button class="btn btn-info panelHeadingButton displayNone" id="joinGroupButton"
									onclick="joinGroup()">
									Join This Group
								</button>
								<button class="btn btn-warning panelHeadingButton displayNone" id="leaveGroupButton"
									onclick="leaveGroup()">
									Leave This Group
								</button>
								<button class="btn btn-danger panelHeadingButton displayNone" id="deleteGroupButton"
									onclick="deleteGroup()">
									Delete This Group
								</button>
							</div>
						</div>
						<div class="col-xs-3 col-sm-0"></div>
					</div>
				</div>
				<div class="panel-body">
					<div class="frame" id="groupMembersScroller">
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
		<div class="projectDetails col-xs-12 col-sm-12 col-md-6 col-lg-6 displayNone" id="embeddedProjectDescription">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Our Project:</h3>
				</div>
				<div class="panel-body">
					<h6 id="projectName">&nbsp;</h6>

					<p id="projectBio">&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="commentsPublic col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Public Discussion:</h3>
				</div>
				<div class="panel-body">
					<div class="row" id="commentsBody"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		var defaultProjectBio = [
			'This project doesn\'t have a bio yet',
			'',
			'*Why not comment on its creator\'s page and let them know?*'
		].join('\n');
		if (me.user.role == "student") {
			if (!me.group.id) {
				if (hasIntent("join_a_group")) {
					filterIntentsByTypeAndEntity("join_a_group", "group", profileId, function(intent) {
						document.getElementById("joinGroupButton").className = "btn btn-warning panelHeadingButton";
						document.getElementById("joinGroupButton").innerText = "Cancel Request";
						document.getElementById("joinGroupButton").setAttribute("onclick", "cancelRequest()");
						document.getElementById("joinGroupButton").style.display = "block";
					});
				}
				else {
					document.getElementById("joinGroupButton").style.display = "block";
				}
			}
			else if (me.group.id === profileId) {
				if (me.group.creator.id === me.user.id) {
					document.getElementById("deleteGroupButton").style.display = "block";
				}
				else {
					document.getElementById("leaveGroupButton").style.display = "block";
				}
			}
		}
		// Make the API call to get the group scroller data.
		API.GET(
			"/group/" + profileId, {},
			function Success(data) {
				document.getElementById("groupName").innerText = data.body.name;
				document.querySelector(".groupMembers ul").innerHTML = scrollerHTML(data.body.students, "student");
				scroller("#groupMembersScroller");
				if (data.body.project) {
					document.getElementById("projectName").innerHTML = '<a href="/profile.php?type=project&id=' + data.body.project.id + '">' + data.body.project.name + '</a>';
					// Set the project bio
					var projectBio = data.body.project.description || defaultProjectBio;
					markdownThingy("projectBio", projectBio);
					// Hide the join group button
					document.getElementById("joinGroupButton").style.display = "none";
					document.querySelector(".groupMembers").className = "groupMembers col-xs-12 col-sm-12 col-md-6 col-lg-6";
					document.querySelector("#embeddedProjectDescription").style.display = "block";
				}
				commentsThingy("commentsBody", "group/" + data.body.id);
			},
			function Error(data) {
				if (data.status == 404) {
					window.location.href = '/404.html'
				}
				console.error(data);
			}
		);
	});


	/**
	 * Load a new page to ask to join the group.
	 */
	function joinGroup() {
		window.location.href = '/intents.php?action=request&request=joinAGroup&groupId=' + profileId;
	}

	/**
	 * Cancel the request to join the group.
	 */
	function cancelRequest() {
		if (confirm("Are you sure you want to cancel this request?")) {
			filterIntentsByTypeAndEntity("join_a_group", "group", profileId, function(intent) {
				API.DELETE(
					"/intent/" + intent.id, {},
					function Success(data) {
						window.location.reload();
					},
					function Error(data) {
						console.error(data);
					}
				);
			});
		}
	}

	/**
	 * If you're in the group, make the API call to leave the group.
	 */
	function leaveGroup() {
		if (confirm("Are you sure you want to leave this group?")) {
			API.POST(
				"/intent/",
				{
					handler: "leave_a_group",
					data: {group_id: profileId}
				},
				function Success(data) {
					window.location.href = '/dashboard.php'
				},
				function Error(data) {
					console.error(data);
				}
			);
		}
	}

	/**
	 * Make the API call to delete the current group.
	 */
	function deleteGroup() {
		if (confirm("Are you sure you want to delete this group?")) {
			API.DELETE(
				"/group/" + profileId, {},
				function Success(data) {
					if (data.status == 204) {
						window.location.href = '/dashboard.php';
					}
					else {
						console.error(data);
					}
				},
				function Error(data) {
					console.error(data);
				}
			);
		}
	}

</script>