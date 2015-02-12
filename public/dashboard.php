<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

$user = Auth::getUser();
$years = KentProjects::getPotentialYears();

if (!empty($_GET["year"]))
{
	$forcedYear = null;
	foreach ($years as $year)
	{
		if ($year->year == $_GET["year"])
		{
			KentProjects::setForcedYear($_GET["year"]);
			$forcedYear = $_GET["year"];
			break;
		}
	}
	if (empty($forcedYear))
	{
		redirect("/dashboard.php");
	}
}
else
{
	$forcedYear = KentProjects::getForcedYear();
}

$year = !empty($forcedYear) ? $forcedYear : KentProjects::getAcademicYearFromDate("today");
$roles = new stdClass;

foreach ($years as $y)
{
	if ($y->year == $year)
	{
		foreach ($y as $key => $value)
		{
			if (strpos($key, "role_") === 0)
			{
				$roles->{substr($key, 5)} = boolval($value);
			}
		}
		break;
	}
}

$potentialRoles = KentProjects::getPotentialRoles($roles);

if (!empty($_GET["role"]))
{
	$forcedRole = null;
	if (!$roles->{$_GET["role"]})
	{
		die("NO. YOU ARE NOT ALLOWED TO BE THAT PERSON.");
	}
	KentProjects::setForcedRole($_GET["role"]);
	$forcedRole = $_GET["role"];
}
else
{
	$forcedRole = KentProjects::getForcedRole();
}

$yearData = API::Request(API::GET, "/year/$year");

if ($yearData->status !== 200)
{
	echo "Year not created.";
	exit(1);
}

// Get header
$title = "Dashboard";
require PUBLIC_DIR . "/includes/php/header.php";
?>

	<script src="/includes/js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script src="/includes/js/flat-ui-pro.min.js" type="text/javascript"></script>
	<script src="/includes/js/ajax.js" type="text/javascript"></script>
	<script src="/includes/js/scroller.js" type="text/javascript"></script>
	<script src="/includes/js/includes.php" type="text/javascript"></script>

	<!-- Layout -->

	<div class="container">
		<div class="row Header">
			<div class="col-sm-12 col-xs-12">
				<h1 class="text-center Heading">Dashboard</h1>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0" id="headerPadLeft"></div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="roleSelectorDiv">
				<div class="dropdown dashboardSelector Heading">
					<button class="btn btn-default dropdown-toggle dashboardSelector"
						type="button" id="roleSelector" data-toggle="dropdown">
						Role: <span class="caret"></span>
					</button>
					<ul class="dropdown-menu dashboardSelector" id="roleSelectorDropdown" role="menu"
						aria-labelledby="dropdownMenu1">
						<li role="presentation" class="dropdown-header">Choose a role:</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0" id="headerPadRight"></div>
		</div>

		<?php
		if ($user->role == "staff")
		{
			switch ($forcedRole)
			{
				case "secondmarker":
					include VIEWS_DIR . "/dashboard-secondmarker.php";
					break;
				case "supervisor":
					include VIEWS_DIR . "/dashboard-supervisor.php";
					break;
				default:
					if ($roles->convener)
					{
						include VIEWS_DIR . "/dashboard-convener.php";
					}
					elseif ($roles->supervisor)
					{
						include VIEWS_DIR . "/dashboard-supervisor.php";
					}
					elseif ($roles->secondmarker)
					{
						include VIEWS_DIR . "/dashboard-secondmarker.php";
					}
					else
					{
						include VIEWS_DIR . "/dashboard-staff.php";
					}
			}
		}
		if ($user->role == "student")
		{
			$user->group = " ";
			$user->project = " ";
			if($user->group != null) {
				if($user->project != null) {
					include VIEWS_DIR . "/dashboard-student-project.php";
				}
				else {
					include VIEWS_DIR . "/dashboard-student-group.php";
				}

			}
			else {
				include VIEWS_DIR . "/dashboard-student.php";
			}
		}
		?>


	</div>

	<script>
		<!-- App code goes here -->
		var year = "<?php echo $year ?>";
		// Populate the roles dropdown
		<?php if (!empty($potentialRoles)) { ?>
		(function () {
			var roles = <?php echo json_encode($potentialRoles);?>;
			var HTML = [];
			for (var p in roles) {
				if (roles.hasOwnProperty(p)) {
					HTML.push(
						'<li role="presentation">',
						'<a role="menuitem" href="?role=', p, '">',
						roles[p],
						'</a>',
						'</li>'
					);
				}
			}
			document.getElementById("roleSelectorDropdown").innerHTML += HTML.join("");
		})();
		<?php }
		else { ?>
		document.getElementById("roleSelector").style.display = "none";
		document.getElementById("roleSelectorDiv").className = "col-lg-0 col-md-0 col-sm-0 col-xs-0";
		document.getElementById("yearSelectorDiv").className = "col-lg-2 col-md-4 col-sm-6 col-xs-12";
		document.getElementById("headerPadLeft").className = "col-lg-5 col-md-4 col-sm-3 col-xs-0";
		document.getElementById("headerPadRight").className = "col-lg-5 col-md-4 col-sm-3 col-xs-0";
		<?php } ?>
	</script>


<?php require PUBLIC_DIR . '/includes/php/footer.php';