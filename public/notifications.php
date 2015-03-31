<?php
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
				</div>
			</div>
		</div>
	</div>
<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>

<script type="text/javascript">
	function onNotificationsGetSuccessList(data) {
		console.log(data);
		document.querySelector(".notificationList").innerHTML = '<div class="text-info text-center">Notifications were fetched :D</div>';
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