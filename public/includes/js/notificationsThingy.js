/**
 * Notifications. Thingy innit.
 */
var loadQueue = loadQueue || [];
loadQueue.push(function () {
	var notificationsList = document.getElementById("user-notifications");
	if (!notificationsList) {
		console.error("No notification dropdown found. Aborting notificationsThingy.");
		return;
	}

	function onNotificationsGetSuccess(data) {
		console.log("notificationsThingy onNotificationsGetSuccess", data);
	}

	function onNotificationsGetError(data) {
		console.error("notificationsThingy onNotificationsGetError", data);
	}

	function GetNotifications() {
		API.GET("/me/notifications", {}, onNotificationsGetSuccess, onNotificationsGetError);
	}

	function onCheckNotificationsSuccess(data) {
		console.log("notificationsThingy onCheckNotificationsSuccess", data);
	}

	function onCheckNotificationsError(data) {
		console.error("notificationsThingy onCheckNotificationsError", data);
	}

	function CheckUnreadNotificationInterval() {
		API.HEAD("/me/notifications?unread=1", {}, onCheckNotificationsSuccess, onCheckNotificationsError);
	}

	setInterval(CheckUnreadNotificationInterval, 1000);
	GetNotifications();
});