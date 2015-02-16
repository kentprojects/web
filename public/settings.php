<?php
// Get header
require_once __DIR__ . "/../private/bootstrap.php";
$title = "Settings";
require PUBLIC_DIR . "/includes/php/header.php";
?>
	<div class="container">
		<div class="row">
			<h1> Settings </h1>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<b>Year:</b>
			</div>
			<div class="col-xs-12 col-sm-4">
				<i>The academic year you would like to browse</i>
			</div>
			<div class="col-xs-12 col-sm-4">
				<form action="dashboard.php" method="get">
					<input type="text" name="year" class="form-control text-center" placeholder="Year">
				</form>
			</div>
		</div>
	</div>
<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>