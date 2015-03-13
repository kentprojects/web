/**
 * Notifications. Thingy innit.
 */
(function () {
	var notificationsList = document.getElementById("user-notifications");
	var notificationsDropdown = document.getElementById("notificationsDropdown");
	if (!notificationsList) {
		console.error("No notification dropdown found. Aborting notificationsThingy.");
		return;
	}

	//if (data.length > 0) {
	//	var item, HTML = [];
	//	for (var i = 0; i < data.length; i++) {
	//		item = data[i];
	//		HTML.push(scrollerTile(item, type, addStyle));
	//	}
	//	return HTML.join("");
	//}
	//else {
	//	return '<div class="scrollerPlaceholder noBottomMargin"><div class="text-info"> There\'s nothing to show here</div></div>';
	//}

	function onNotificationsGetSuccess(data) {
		//console.log("notificationsThingy onNotificationsGetSuccess", data);
		if (data.headers && data.headers["X-Notification-Count"] && (data.headers["X-Notification-Count"] > 0)) {
			var item, HTML = [];
			HTML.push(
				'<li class="text-center"><a href="/notifications.php"><strong>Notifications</strong></a></li> ' +
				'<li class="divider"></li>'
			)
			for (var i = 0; i < data.body.length; i++) {
				var notification = data.body[i];
				//console.log(notification);
				HTML.push('<li><a href="/intents.php?action=view&id=' + data.body[i].intent.id + '">' + data.body[i].text + '</a></li>');
			}
			HTML.push(
				'<li class="divider"></li>' +
				'<li class="text-center"><a href="/notifications.php"><i>See All</i></a></li>'
			)
			notificationsList.innerHTML = HTML.join("");
			notificationsDropdown.innerHTML += '<span class="notificationsBadge">' + data.body.length + '</span>';

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
		console.log("notificationsThingy onCheckNotificationsSuccess", data);
		if (data.headers && data.headers["X-Notification-Count"] && (data.headers["X-Notification-Count"] > 0)) {
			GetNotifications();
		}
	}

	function onCheckNotificationsError(data) {
		// Meh. Who cares.
		// console.error("notificationsThingy onCheckNotificationsError", data);
	}

	function CheckUnreadNotificationInterval() {
		API.HEAD("/me/notifications", {"unread":1}, onCheckNotificationsSuccess, onCheckNotificationsError);
	}

	// setInterval(CheckUnreadNotificationInterval, 10000);
	GetNotifications();
})();
