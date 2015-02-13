<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

$user = Auth::getUser();

$action = !empty($_GET["action"]) ? $_GET["action"] : null;
switch ($action)
{
	case "view":
		$view = "/intents-view.php";
		break;
	case "request":
		$view = "/intents-request.php";
		break;
	default:
		redirect("dashboard.php");

}?>

<script src="/includes/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="/includes/js/flat-ui-pro.min.js" type="text/javascript"></script>
<script src="/includes/js/ajax.js" type="text/javascript"></script>
<script src="/includes/js/includes.php" type="text/javascript"></script>

<?php
// Get header
$title = "Dashboard";
require PUBLIC_DIR . "/includes/php/header.php";
require VIEWS_DIR . $view;
require PUBLIC_DIR . '/includes/php/footer.php';
?>
