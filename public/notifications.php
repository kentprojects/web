<?php

/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

$title = "Settings";
require PUBLIC_DIR . "/includes/php/header.php";
?>
	<div class="container">
		<div class="row">
			<h1>Notifications</h1>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="notificationList">
					<div>Fetching notifications...</div>
				</div>
			</div>
		</div>
	</div>
<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>

<script type="text/javascript">
	function onNotificationsGetSuccessList(data) {
		console.log(data);

		if (data.headers && data.headers["X-Notification-Count"] && (data.headers["X-Notification-Count"] > 0)) {
			var HTML = [];
			var notificationIds = [];
			for (var i = 0; i < 5; i++) {
				if (data.body[i]) {
					var notification = data.body[i];
					//console.log(notification);
					var url = "#";
					switch (notification.type) {
						case "user_got_a_notification":
							break;
						case "user_approved_access_to_year":
						case "user_rejected_access_to_year":
							url = '/dashboard.php';
							break;
						case "user_wants_to_access_a_year":
						case "group_wants_to_undertake_a_project":
						case "user_wants_another_to_join_a_group":
						case "user_wants_to_join_a_group":
							if (notification.intent && notification.intent.id) {
								url = '/intents.php?action=view&id=' + notification.intent.id;
							}
							else {
								url = '';
							}
							break;
						case "user_approved_another_to_join_a_group":
						case "user_rejected_another_to_join_a_group":
						case "user_joined_a_group":
						case "user_left_a_group":
							if (notification.group && notification.group.id) {
								url = '/profile.php?type=group&id=' + notification.group.id;
							}
							else {
								url = '';
							}
							break;
						case "group_undertaken_project_approved":
						case "group_undertaken_project_rejected":
						case "group_released_project":
							if (notification.project && notification.project.id) {
								url = '/profile.php?type=project&id=' + notification.project.id;
							}
							else {
								url = '';
							}
							break;
					}
					if (url == "") {
						HTML.push('<li class="notificationListItem">' + notification.text + '</li>');
					}
					else {
						HTML.push('<li class="notificationListItem"><a href="' + url + '">' + notification.text + '</a></li>');
					}
					if (!notification.read) {
						notificationIds.push(notification.id);
					}
				}
			}
			document.querySelector(".notificationList").innerHTML = HTML.join("");
			if (notificationIds > 0) {
				notificationsBadge.innerText = notificationIds.length.toString();
				notificationsBadge.style.display = "block";
				notificationsDropdown.setAttribute('onclick', 'setReadStatus([' + notificationIds + '])');
				updatedReadStatus = false;
			}
			else {
				notificationsBadge.style.display = "none";
			}
		}
		else {
			document.querySelector(".notificationList").innerHTML = '<li class="text-center"><a href="#">You have no notifications</a></li>'
		}
	}

	function onNotificationsGetErrorList(data) {
		console.log(data);
		document.querySelector(".notificationList").innerHTML = '<div class="text-danger text-center">Notifications could not be fetched, please try again.</div>';
	}

	function getNotificationsList() {
		API.GET("/me/notifications", {}, 
			onNotificationsGetSuccessList, 
			onNotificationsGetErrorList
		);
	}
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		getNotificationsList();
	});
</script>