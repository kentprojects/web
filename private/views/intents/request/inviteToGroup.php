<!--
/**
 * @author: Matt House <matt.house@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */-->
<!--Show details and buttons for the intent.-->
<h3 id="intentTitle">Ask <var class="userName""></var> to join <var class="groupName""></var>?</h3>

<p id="intentDescription">Do you want to ask <a href="#" class="userName"></a> if you can join
	<a href="#" class="groupName"></a>?</p>
<!--Buttons to accept or decline the intent.-->
<div class="btn-group intentResponseButtons">
	<button class="btn btn-primary intentAccept" onclick="confirmRequest();" value="Confirm">
		Confirm
	</button>
	<button class="btn btn-info intentDecline" onclick="cancelRequest();" value="Cancel">
		Cancel
	</button>
</div>

<script>
	var confirmRequest = function () {
	};
	var cancelRequest = function () {
	};

	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		var studentId = phpGets.studentId;

		API.GET(
			"/student/" + studentId, {},
			function Success(data) {
				// Checking that the user has the access privileges to invite someone to join the group.
				if (me.group.creator.id !== me.user.id) {
					document.querySelector("#intentTitle").innerText = "You didn't create your group!"
					document.querySelector("#intentDescription").innerHTML = 'Only the creator of a group can invite people to join it. </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else if (me.project.id) {
					document.querySelector("#intentTitle").innerText = "You can't invite any more people to your group!"
					document.querySelector("#intentDescription").innerHTML = 'Once you\'ve undertaken a project, you can\'t invite more people to your group. </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else if (data.body.group && data.body.group.id) {
					document.querySelector("#intentTitle").innerText = "They're already in a group!"
					document.querySelector("#intentDescription").innerHTML = 'They need to leave their current group before they can join a new one! </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
				}
				else {
					qf(".groupName", function (element) {
						element.innerText = me.group.name;
						element.href = "/profile.php?type=group&id=" + me.group.id;
					});
					qf(".userName", function (element) {
						element.innerText = data.body.name;
						element.href = "/profile.php?type=student&id=" + data.body.id;
					});
					document.querySelector(".intentResponseButtons").style.display = "block";
				}
			},
			function Error(data) {
				console.error("That student doesn't exist!");
				console.error(data.body);
				if (data.status == 404) {
					qf("#intentTitle", function (element) {
						element.innerText = "That's an incorrect student ID!";
					});
					qf("#intentDescription", function (element) {
						element.innerHTML = 'Did you find a broken link? If so, please let the module convener know. </br><strong><a href=# onclick="cancelRequest();"> Go back? </a></strong>';
					});
				};
				document.querySelector(".btn-group").style.display = "none";
			}
		);
		confirmRequest = function confirmRequest() {
			API.POST(
				'/intent',
				{handler: "invite_to_group", data: {user_id: studentId}},
				function Success(data) {
					cancelRequest();
				},
				function Error(data) {
					if (data.status == 409) {
						qf("#intentTitle", function (element) {
							element.innerText = "You can't do that twice in a row!";
						});
						qf("#intentDescription", function (element) {
							element.innerHTML =
								'You need to wait until your current invite is accepted or declined ' +
								'before doing doing it again </br><strong><a href=# onclick="cancelRequest();"> ' +
								'Go back? </a></strong>';
						});

					};
					console.error(data);
					document.querySelector(".btn-group").style.display = "none";
				}
			)
		};
		cancelRequest = function cancelRequest() {
			window.location.href = "/profile.php?type=student&id=" + studentId;
		};
	});
</script>