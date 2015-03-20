<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../../private/bootstrap.php";

$user = Auth::getUser();

// Get header
$title = "Dashboard";
require PUBLIC_DIR . "/includes/php/header.php";
?>
	<h1 id="title">Logging in...</h1>
	<p id="loading">It should have happened by now...</p>
	<script src="/includes/js/ajax.js" type="text/javascript"></script>
	<script src="/includes/js/includes.php" type="text/javascript"></script>
	<script type="text/javascript">
		API.GET(
			"/" +user.role+ "/" +user.id,
			{},
			function (data)
			{
				console.log(data);
				document.getElementById("title").innerText = "Logged In to KentProjects";
				document.getElementById("loading").innerText = "Hello, Bob!";
			},
			function (data)
			{
				console.error(data);
				document.getElementById("title").innerText = "Failed to login with KentProjects";
				document.getElementById("loading").innerText = "No, Bob. No.";
			}
		);
	</script>
<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>