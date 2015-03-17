<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * @var stdClass $meRequest ->user
 */

$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

switch (!empty($_GET["action"]) ? $_GET["action"] : null)
{
	case "request":
		if (empty($_GET["request"]))
		{
			exit((string)new Exception("No request given."));
		}
		else
		{
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
					if ($meRequest->user->role == "staff")
					{
						exit((string)new Exception("Staff can't do that!"));
					}
					$content = "/request/joinAGroup";
					break;
				case "inviteToGroup":
					if (empty($_GET["studentId"]))
					{
						exit((string)new Exception("No student ID given."));
					}
					if ($meRequest->user->role == "staff")
					{
						exit((string)new Exception("Staff can't do that!"));
					}
					$content = "/request/inviteToGroup";
					break;
				case "undertakeAProject":
					if (empty($_GET["projectId"]))
					{
						exit((string)new Exception("No project ID given."));
					}
					if ($meRequest->user->role == "staff")
					{
						exit((string)new Exception("Staff can't do that!"));
					}
					$content = "/request/undertakeAProject";
					break;
				case "accessYear":
					$content = "/request/accessYear";
					break;
				case "submitToCAS":
					if ($meRequest->user->role == "staff")
					{
						exit((string)new Exception("Staff can't do that!"));
					}
					if (empty($meRequest->group))
					{
						exit((string)new Exception("You don't have a group yet!"));
					}
					if (empty($meRequest->project))
					{
						exit((string)new Exception("You don't have a project to submit yet!"));
					}
					$content = "/request/submitToCAS";
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
<?php
$allowedKeys = array("action", "id", "request", "groupId", "projectId", "studentId");
$phpGets = array();
foreach ($_GET as $k => $v)
{
	if (in_array($k, $allowedKeys))
	{
		$phpGets[$k] = $v;
	}
}
?>
	<script>
		var phpGets = <?php echo(json_encode($phpGets)); ?>;
		var scriptQueue = scriptQueue || [];
		scriptQueue.push("/includes/js/intents.js");
	</script>

<?php require PUBLIC_DIR . "/includes/php/footer.php"; ?>