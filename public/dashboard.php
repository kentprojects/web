<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

$user = Auth::getUser();

// TODO: Validate the user permissions for roles
if (!empty($_GET["role"]))
{
	KentProjects::setForcedRole($_GET["role"]);
	$forcedRole = $_GET["role"];
}
else
{
	$forcedRole = KentProjects::getForcedRole();
}

// TODO: Validate the user permissions for years
if (!empty($_GET["year"]))
{
	KentProjects::setForcedYear($_GET["year"]);
	$forcedYear = $_GET["year"];
}
else
{
	$forcedYear = KentProjects::getForcedYear();
}

$potentialRoles = KentProjects::getPotentialRoles($user);
$year = !empty($forcedYear) ? $forcedYear : KentProjects::getAcademicYearFromDate("today");
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
	<script src="/includes/js/includes.php" type="text/javascript"></script>

	<!-- Layout -->

	<div class="container">
		<div class="row Header">
			<div class="col-sm-12 col-xs-12">
				<h1 class="text-center Heading">Dashboard</h1>
			</div>
			<div class="col-lg-4 col-md-3 col-sm-2 col-xs-0"></div>
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
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
			<div class="col-md-2 col-md-3 col-sm-4 col-xs-12">
				<div class="dashboardSelector Heading">
					<form action="dashboard.php" method="get">
						<input type="text" name="year" id="yearSelector" class="form-control text-center"
							placeholder="">
					</form>
				</div>
			</div>
			<div class="col-lg-4 col-md-3 col-sm-2 col-xs-0"></div>
		</div>

		<?php
		if ($user->role == "staff")
		{

			switch ($forcedRole)
			{
				case "Second Marker":
					include VIEWS_DIR . "/dashboard-secondmarker.php";
					break;
				case "Supervisor":
					include VIEWS_DIR . "/dashboard-supervisor.php";
					break;
				default:
					if ($user->is->convenor)
					{
						include VIEWS_DIR . "/dashboard-convenor.php";
					}
					elseif ($user->is->supervisor)
					{
						include VIEWS_DIR . "/dashboard-supervisor.php";
					}
					elseif ($user->is->secondmarker)
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
			include VIEWS_DIR . "/dashboard-student.php";
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
			for (var i = 0; i < roles.length; i++) {
				HTML.push('<li role="presentation"><a role="menuitem" href="?role=' + roles[i] + '">' + roles[i] + '</a></li>');
			}

			document.getElementById("roleSelectorDropdown").innerHTML += HTML.join("");
		})();
		<?php }
		else { ?>
			document.getElementById("roleSelector").style.display = "none";
		<?php } ?>

		// Populate the year selection box
		document.getElementById("yearSelector").setAttribute("placeholder", "Year: " + year);
	</script>


<?php require PUBLIC_DIR . '/includes/php/footer.php';