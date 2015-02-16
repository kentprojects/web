<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

if (!in_array(strtoupper($_SERVER["REQUEST_METHOD"]), array("GET", "POST")))
{
	exit((string)new Exception("Bad request type."));
}

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

		if (!Intents::isValidIntent(strtolower($_GET["request"])))
		{
			exit((string)new Exception("Invalid request specified."));
		}

		require VIEWS_DIR . "/intents/request.php";
		break;
	case "view":
		if (empty($_GET["id"]))
		{
			exit((string)new Exception("No ID given."));
		}

		require VIEWS_DIR . "/intents/view.php";
		break;
	default:
		redirect("dashboard.php");
}