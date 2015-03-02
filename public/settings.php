<?php
// Get header
require_once __DIR__ . "/../private/bootstrap.php";

if (!empty($_GET["upload"]) && ($_GET["upload"] === "avatar"))
{
	$response = KentProjects::uploadUserAvatar();
	header(sprintf("HTTP/1.1 %d %s", $response->status, $response->getStatusMessage()));
	header("Content-Type: application/json");
	echo json_encode($response->body);
	exit();
}

$includeDropZoneJs = true;
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
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<h4>Current Avatar</h4>

				<img src="http://i.imgur.com/ldS4dWw.png" />
			</div>
			<div class="col-xs-12 col-sm-4">
				<h4>New Avatar</h4>

				<div class="dropzone" id="userAvatarUpload"></div>
			</div>
		</div>
	</div>
	<!--suppress SpellCheckingInspection -->
	<script type="text/javascript">
		Dropzone.options.userAvatarUpload = {
			accept: function (file, done) {
				console.log(file);
				done();
			},
			acceptedFiles: 'image/*',
			maxFilesize: 5.5,
			init: function () {
				var zone = this;
				zone.on('success', function (file) {
					console.log(file);
					zone.removeFile(file);
				});
			},
			parallelUploads: 1,
			uploadMultiple: false,
			url: '/settings.php?upload=avatar'
		};
	</script>
	<script src="/includes/js/script.js" type="text/javascript"></script>
<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>