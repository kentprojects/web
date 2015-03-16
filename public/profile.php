<?php
/**
 * @var stdClass $meRequest
 */
// Get authentication
$prerequisites = array("authentication", "me");
require_once __DIR__ . "/../private/bootstrap.php";

$profileId = null;
$user = $meRequest->user;
// Get header
$title = "Profile";

if (!empty($_GET["shortcut"]))
{
	$shortcut = $_GET["shortcut"];
	switch ($shortcut)
	{
		case "myProfile":
			if ($user->role == "staff")
			{
				$profileType = "staff";
			}
			elseif ($user->role == "student")
			{
				$profileType = "student";
			}
			else
			{
				redirect("/dashboard.php");
			}
			$profileId = $user->id;
			break;
		case "myGroup":
			if ($user->role == "staff")
			{
				redirect("/dashboard.php");
			}
			elseif ($user->role == "student")
			{
				if (!empty($meRequest->group))
				{
					$profileType = "group";
					$profileId = $meRequest->group->id;
					break;
				}
				else
				{
					redirect("/dashboard.php");
				}
			}
			else
			{
				redirect("/dashboard.php");
			}
		case "myProject":
			if ($user->role == "staff")
			{
				redirect("/dashboard.php");
			}
			elseif ($user->role == "student")
			{
				if (!empty($meRequest->project))
				{
					$profileType = "project";
					$profileId = $meRequest->project->id;
					break;
				}
				else
				{
					redirect("/dashboard.php");
				}
			}
			else
			{
				redirect("/dashboard.php");
			}
		default:
			redirect("/dashboard.php");
	}
}
else
{
	if (!empty($_GET["id"]))
	{
		$profileId = $_GET["id"];
	}
	else
	{
		redirect("dashboard.php");
	}
	if (!empty($_GET["type"]))
	{
		if ($_GET["type"] == "user")
		{
			$response = API::Request(API::GET, "/user/" . $profileId);
			if ($response->status == 200)
			{
				switch ($response->body->role)
				{
					case "student":
						$profileType = "student";
						break;
					case "staff":
						$profileType = "staff";
						break;
					default:
						redirect("404.html");
				}
			}
			else
			{
				redirect("404.html");
			}
		}
		else
		{
			$profileType = $_GET["type"];
		}
	}
	else
	{
		redirect("dashboard.php");
	}
}

require PUBLIC_DIR . "/includes/php/header.php";
?>

	<script>
		var profileId = <?php echo $profileId; ?>;
		var profileType = "<?php echo $profileType; ?>";
	</script>

	<!-- Bootstrap Markdown Support -->
	<link href="/includes/css/lib/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
	<link href="/includes/css/lib/bootstrap-tokenfield.min.css" rel="stylesheet" type="text/css" />

	<script>
		var scriptQueue = scriptQueue || [];
		scriptQueue.push(
			"/includes/js/lib/bootstrap-markdown.js",
			"/includes/js/lib/markdown.js",
			"/includes/js/lib/to-markdown.js",
			"/includes/js/lib/bootstrap-tokenfield.min.js",

			"/includes/js/commentsThingy.js",
			"/includes/js/editsThingy.js",
			"/includes/js/markdownThingy.js",
			"/includes/js/tokensThingy.js"
		)
	</script>

<?php
switch ($profileType)
{
	case "staff":
		include VIEWS_DIR . "/profile/user/staff.php";
		break;
	case "student":
		include VIEWS_DIR . "/profile/user/student.php";
		break;
	case "group":
		include VIEWS_DIR . "/profile/group.php";
		break;
	case "project":
		include VIEWS_DIR . "/profile/project.php";
		break;
	default:
		redirect("dashboard.php");
}

require PUBLIC_DIR . '/includes/php/footer.php';
