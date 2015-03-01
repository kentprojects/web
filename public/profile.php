<?php
// Get authentication
$prerequisites = array("authentication", "me");
require_once __DIR__ . "/../private/bootstrap.php";

$user = $meRequest->user;
// Get header
$title = "Profile";
require PUBLIC_DIR . "/includes/php/header.php";

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
				redirect("dashboard.php");
			}
			$profileId = $user->id;
			break;
		case "myGroup":
			if ($user->role == "staff")
			{
				redirect("dashboard.php");
			}
			elseif ($user->role == "student")
			{
				if(!empty($meRequest->group))
				{
					$profileType = "group";
					$profileId = $meRequest->group->id;
					break;
				}
				else
				{
					redirect("dashboard.php");
				}
			}
			else
			{
				redirect("dashboard.php");
			}
		default:
			redirect("dashboard.php");
	}
}
else {
	if (!empty($_GET["type"]))
	{
		$profileType = $_GET["type"];
	}
	else
	{
		redirect("dashboard.php");
	}
	if (!empty($_GET["id"]))
	{
		$profileId = $_GET["id"];
	}
	else
	{
		redirect("dashboard.php");
	}
}
?>

<script>
	var profileType = "<?php echo $profileType; ?>";
	var profileId = <?php echo $profileId; ?>;
</script>

<!-- Bootstrap Markdown Support -->
<link href="/includes/css/lib/bootstrap-markdown.min.css" rel="stylesheet" type="text/css"/>
<link href="/includes/css/lib/bootstrap-tokenfield.min.css" rel="stylesheet" type="text/css"/>
<script src="/includes/js/lib/bootstrap-markdown.js" type="text/javascript"></script>
<script src="/includes/js/lib/markdown.js" type="text/javascript"></script>
<script src="/includes/js/lib/to-markdown.js" type="text/javascript"></script>
<script src="/includes/js/lib/bootstrap-tokenfield.min.js" type="text/javascript"></script>
<!-- Sly -->
<script src="/includes/js/lib/sly.js" type="text/javascript"></script>
<!-- Our scripts -->
<script src="/includes/js/ajax.js" type="text/javascript"></script>
<script src="/includes/js/includes.php" type="text/javascript"></script>

<script src="/includes/js/commentsThingy.js" type="text/javascript"></script>
<script src="/includes/js/editPage.js" type="text/javascript"></script>
<script src="/includes/js/markdownThingy.js" type="text/javascript"></script>
<script src="/includes/js/tokensThingy.js" type="text/javascript"></script>
<script src="/includes/js/scrollerThingy.js" type="text/javascript"></script>



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

require PUBLIC_DIR . '/includes/php/footer.php'; ?>
