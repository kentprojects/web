<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * @var stdClass $user
 */

$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";
$user = Auth::getUser();

switch (!empty($_GET["action"]) ? $_GET["action"] : null)
{
	case "request":
		if (empty($_GET["request"]))
		{
			exit((string)new Exception("No request given."));
		}
		else {
			switch ($_GET["request"])
			{
				case "generic":
					if (empty($_GET["userId"]))
					{
						exit((string)new Exception("No request ID given."));
					}
					$content = "/request/generic";
					break;
				case "joinAGroup":
					if (empty($_GET["groupId"]))
					{
						exit((string)new Exception("No group ID given."));
					}
					if ($user->role == "staff")
					{
						exit((string)new Exception("Staff can't do that!"));
					}
					$content = "/request/joinAGroup";
					break;
				case "undertakeAProject":
					if (empty($_GET["projectId"]))
					{
						exit((string)new Exception("No project ID given."));
					}
					if ($user->role == "staff")
					{
						exit((string)new Exception("Staff can't do that!"));
					}
					$content = "/request/undertakeAProject";
					break;
				case "joinAYear":
					if (empty($_GET["year"]))
					{
						exit((string)new Exception("No year given."));
					}
					$content = "/request/joinAYear";
					break;
				default:
					exit((string)new Exception("Invalid request."));
			}
		}
		break;
	case "view":
		if (empty($_GET["id"]))
		{
			exit((string)new Exception("No request ID given."));
		}
		$content = "view";
		break;
	default:
		redirect("dashboard.php");
}

require PUBLIC_DIR . "/includes/php/header.php";

?>


	<div class="container">
		<div class="Header"></div>
		<div class="jumbotron">
			<div class="container">
				<?php include VIEWS_DIR . "/intents/$content.php"; ?>
			</div>
		</div>
	</div>
	<!-- TODO: SANITIZE SANITIZE SANITIZE -->
	<script> var phpGets = <?php echo(json_encode($_GET)); ?>;</script>
	<script src="/includes/js/ajax.js" type="text/javascript"></script>
	<script src="/includes/js/includes.php" type="text/javascript"></script>
	<script src="/includes/js/intents.js"></script>
	<script src="/includes/js/script.js"></script>

<?php require PUBLIC_DIR . "/includes/php/footer.php"; ?>