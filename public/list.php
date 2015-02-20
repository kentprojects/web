<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

$user = Auth::getUser();
// Get header
$title = "List";
require PUBLIC_DIR . "/includes/php/header.php";

if (!empty($_GET["shortcut"]))
{
	$shortcut = $_GET["shortcut"];
	switch ($shortcut)
	{
		default:
			redirect("dashboard.php");
	}
}
else
{
	if (!empty($_GET["type"]))
	{
		$listType = $_GET["type"];
	}
	else
	{
		redirect("dashboard.php");
	}
}
?>

<script>
	var listType = '<?php echo $listType; ?>';
</script>


<!-- Include things -->

<?php
switch ($listType)
{
	case "groups":
			include VIEWS_DIR . "/lists/groups.php";
			break;
	case "projects":
			include VIEWS_DIR . "/lists/projects.php";
			break;
	case "staff":
			include VIEWS_DIR . "/lists/staff.php";
			break;
	case "students":
			include VIEWS_DIR . "/lists/students.php";
			break;
	default:
		redirect("dashboard.php");
}
?>


<script type="text/javascript" src="/includes/js/viewEdit.js"></script>

<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>