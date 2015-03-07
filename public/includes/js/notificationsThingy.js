/**
 * Notifications. Thingy innit.
 */
(function () {
	var notificationsList = document.getElementById("user-notifications");
	if (!notificationsList) {
		console.error("No notification dropdown found. Aborting notificationsThingy.");
		return;
	}

	function onNotificationsGetSuccess(data) {
		console.log("notificationsThingy onNotificationsGetSuccess", data);
		if (data.headers && data.headers["X-Notification-Count"] && (data.headers["X-Notification-Count"] > 0)) {
			for (var i = 0; i < data.body.length; i++) {
				var notification = data.body[i];
				console.log(notification);
			}
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
