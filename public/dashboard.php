<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

/**
 * @var stdClass $meRequest
 */
$prerequisites = array("authentication", "me");
require_once __DIR__ . "/../private/bootstrap.php";

$forcedRole = null;
$roles = new stdClass;
$user = $meRequest->user;
$year = null;

if (!empty($user->years))
{
	if (!empty($_GET["year"]))
	{
		foreach ($meRequest->user->years as $yearId => $yearRoles)
		{
			if ($yearId == $_GET["year"])
			{
				KentProjects::setForcedYear($yearId);
				$year = $yearId;
				break;
			}
		}
		if (empty($year))
		{
			redirect("/dashboard.php");
		}
	}
	else
	{
		$year = KentProjects::getForcedYear(KentProjects::getAcademicYearFromDate("today"));
	}

	foreach ($meRequest->user->years as $yearId => $yearRoles)
	{
		if ($yearId == $year)
		{
			foreach ($yearRoles as $key => $value)
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
		if (!empty($_GET["role"]))
		{
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

	<div class="container mainContent">
		<div class="row Header">
			<div class="col-sm-12 col-xs-12">
				<h1 class="text-center Heading">Dashboard</h1>
			</div>
			<div class="col-lg-5 col-md-4 col-sm-3 col-xs-0" id="headerPadLeft"></div>
			<div class="col-lg-0 col-md-0 col-sm-0 col-xs-0" ; id="roleSelectorDiv">
				<div class="dropdown dashboardSelector Heading">
					<button class="btn btn-default dropdown-toggle dashboardSelector displayNone"
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

<?php if (!empty($roles))
{
	$potentialRoles = array();
	if (!empty($roles->convener))
	{
		$potentialRoles["convener"] = "Convener";
	}
	if (!empty($roles->supervisor))
	{
		$potentialRoles["supervisor"] = "Supervisor";
	}
	if (!empty($roles->secondmarker))
	{
		$potentialRoles["secondmarker"] = "Second Marker";
	}

	if (!empty($potentialRoles) && (count($potentialRoles) > 1))
	{
		?>
		<script type="text/javascript">
			var loadQueue = loadQueue || [];
			loadQueue.push(function () {
				<!-- App code goes here -->
				// Populate the roles dropdown
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
			});
		</script>
	<?php
	}
}

require PUBLIC_DIR . '/includes/php/footer.php';
