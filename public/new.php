<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * @var stdClass $meRequest
 */

$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

switch (!empty($_GET["type"]) ? $_GET["type"] : null)
{
	case "project":
		if ($user->role == "staff")
		{
			exit((string)new Exception("Students can't do that!"));
		}
		$content = "project";
		break;
	case "group":
		$content = "group";
		break;
	case "user":
		if(empty($meRequest->user->name))
		{
			$content = "user";
		}
		else
		{
			redirect("/dashboard.php");
		}
		break;
	default:
		http_response_code(404);
		include PUBLIC_DIR . "/errors/404.php";
		exit();
}

require PUBLIC_DIR . "/includes/php/header.php";
?>


	<div class="container">
		<div class="Header"></div>
		<div class="jumbotron">
			<div class="container">
				<?php include VIEWS_DIR . "/new/$content.php"; ?>
			</div>
		</div>
	</div>
	<!-- TODO: SANITIZE SANITIZE SANITIZE -->
	<script> var phpGets = <?php echo(json_encode($_GET)); ?>;</script>
	<script src="/includes/js/ajax.js" type="text/javascript"></script>
	<script src="/includes/js/includes.php" type="text/javascript"></script>
	<script src="/includes/js/script.js"></script>

<?php require PUBLIC_DIR . "/includes/php/footer.php"; ?>