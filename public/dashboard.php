<?php
// Get authentication
$prerequisites = array("authentication", "me");
require_once __DIR__ . "/../private/bootstrap.php";

$user = $meRequest->user;
$years = KentProjects::getPotentialYears();
$year = null;

if (!empty($user->years))
{
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

	if ($user->role === "staff")
	{
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

	}

	$yearData = API::Request(API::GET, "/year/$year");

	if ($yearData->status !== 200)
	{
		echo "Year not created.";
		exit(1);
	}
}

// Get header
$title = "Dashboard";
require PUBLIC_DIR . "/includes/php/header.php";
?>
	<!-- Layout -->

	<div class="container">
		<div class="row Header">
			<div class="col-sm-12 col-xs-12">
				<h1 class="text-center Heading">Dashboard</h1>
			</div>
			<div class="col-lg-5 col-md-4 col-sm-3 col-xs-0" id="headerPadLeft"></div>
			<div class="col-lg-0 col-md-0 col-sm-0 col-xs-0"; id="roleSelectorDiv">
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
			<div class="col-lg-5 col-md-4 col-sm-3 col-xs-0" id="headerPadRight"></div>
		</div>

		<?php

		if (empty($user->years))
		{
			include VIEWS_DIR . "/dashboard/noYear.php";
		}


		else
		{
			if ($user->role === "staff")
			{
				switch ($forcedRole)
				{
					case "secondmarker":
						include VIEWS_DIR . "/dashboard/staff/secondMarker.php";
						break;
					case "supervisor":
						include VIEWS_DIR . "/dashboard/staff/supervisor.php";
						break;
					default:
						if ($roles->convener)
						{
							include VIEWS_DIR . "/dashboard/staff/convener.php";
						}
						elseif ($roles->supervisor)
						{
							include VIEWS_DIR . "/dashboard/staff/supervisor.php";
						}
						elseif ($roles->secondmarker)
						{
							include VIEWS_DIR . "/dashboard/staff/secondMarker.php";
						}
				}
			}
			if ($user->role === "student")
			{
				if ($meRequest->group != null)
				{
					if ($meRequest->project != null)
					{
						include VIEWS_DIR . "/dashboard/student/hasProject.php";
					}
					else
					{
						include VIEWS_DIR . "/dashboard/student/inGroup.php";
					}

				}
				else
				{
					include VIEWS_DIR . "/dashboard/student/noGroup.php";
				}
			}
		}

		?>


	</div>

	<script type="text/javascript">
		var loadQueue = loadQueue || [];
		loadQueue.push(function () {
			<!-- App code goes here -->
			var year = "<?php echo $year; ?>";
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

				document.getElementById("headerPadLeft").className = "col-lg-4 col-md-4 col-sm-4 col-xs-0";
				document.getElementById("roleSelectorDiv").className = "col-lg-4 col-md-4 col-sm-4 col-xs-12";
				document.getElementById("headerPadRight").className = "col-lg-4 col-md-4 col-sm-4 col-xs-0"
				document.getElementById("roleSelector").style.display = "block";
			})();
			<?php }?>
		});
	</script>
<?php require PUBLIC_DIR . '/includes/php/footer.php';