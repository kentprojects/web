/**
 * Notifications. Thingy innit.
 */
var notificationsDropdown = document.getElementById("notificationsDropdown");
var notificationsList = document.getElementById("user-notifications");
var notificationsBadge = document.getElementById("notificationsBadge");
var updatedReadStatus = false;
if (!notificationsList) {
	console.error("No notification dropdown found. Aborting notificationsThingy.");
}

/**
 * @description When the API returns a lists of notifications, this method will generate the HTML to fill the dropdown
 *
 * @param data
 * @return void
 */
function onNotificationsGetSuccess(data) {
	//console.log("notificationsThingy onNotificationsGetSuccess", data);
	if (data.headers && data.headers["X-Notification-Count"] && (data.headers["X-Notification-Count"] > 0)) {
		var HTML = [];
		var notificationIds = [];
		HTML.push(
			'<li class="text-center"><a href="/notifications.php"><strong>Notifications</strong></a></li> ' +
			'<li class="divider"></li>'
		)
		for (var i = 0; i < 10; i++) {
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
							url = '#failed-to-get-intent-id-for-notification-' + notification.id;
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
							url = '#failed-to-get-group-id-for-notification-' + notification.id;
						}
						break;
					case "group_undertaken_project_approved":
					case "group_undertaken_project_rejected":
					case "group_released_project":
						if (notification.project && notification.project.id) {
							url = '/profile.php?type=project&id=' + notification.project.id;
						}
						else {
							url = '#failed-to-get-project-id-for-notification-' + notification.id;
						}
						break;
				}

				HTML.push('<li><a href="' + url + '">' + notification.text + '</a></li>');
				if (!notification.read) {
					notificationIds.push(notification.id);
				}
			}
		}
		HTML.push(
			'<li class="divider"></li>' +
			'<li class="text-center"><a href="/notifications.php"><i>See All</i></a></li>'
		)
		notificationsList.innerHTML = HTML.join("");
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
		notificationsList.innerHTML = '<li class="text-center"><a href="#">You have no notifications</a></li>'
	}
}

function onNotificationsGetError(data) {
	console.error("notificationsThingy onNotificationsGetError", data);
}

function GetNotifications() {
	API.GET("/me/notifications", {}, onNotificationsGetSuccess, onNotificationsGetError);
}

function onCheckNotificationsSuccess(data) {
	//console.log("notificationsThingy onCheckNotificationsSuccess", data);
	if (data.headers && data.headers["X-Notification-Count"] && (data.headers["X-Notification-Count"] > 0)) {
		GetNotifications();
	}
}

function onCheckNotificationsError(data) {
	// Meh. Who cares.
	// console.error("notificationsThingy onCheckNotificationsError", data);
}

function setReadStatus(ids) {
	if(!updatedReadStatus) {
		API.PUT("/me/notifications", {
				ids: ids
			},
			function onNotificationReadStatusUpdateSuccess(data) {
				//console.log(data.body);
				updatedReadStatus = true;
			},
			function onNotificationReadStatusUpdateError() {
				console.error("Failed to update the read status for notifications");
			}
		)
	}
	GetNotifications();
}

function CheckUnreadNotificationInterval() {
	API.HEAD("/me/notifications", {"unread": 1}, onCheckNotificationsSuccess, onCheckNotificationsError);
}

//setInterval(CheckUnreadNotificationInterval, 60000);
GetNotifications();