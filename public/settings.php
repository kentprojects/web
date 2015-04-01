<?php
/**
 * @var stdClass $meRequest
 */
$prerequisites = array("authentication");
require_once __DIR__ . "/../private/bootstrap.php";

if (!empty($_GET["upload"]) && ($_GET["upload"] === "avatar"))
{
	$response = KentProjects::uploadUserAvatar($meRequest->user);
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
			<h1>Settings</h1>
		</div>
		<div class="row settingsRow">
			<div class="col-xs-12 col-sm-2">
				<b>Year:</b>
			</div>
			<div class="col-xs-12 col-sm-4">
				<i>The academic year you would like to browse</i>
			</div>
			<div class="col-xs-12 col-sm-3">
				<form action="/dashboard.php" method="get">
					<input type="text" name="year" class="form-control text-center yearSelector" placeholder="Year">
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<h4>Current Avatar</h4>

				<img id="imageAvatar" src="/uploads/<?php echo md5($meRequest->user->email); ?>" />
			</div>
			<div class="col-xs-12 col-sm-6">
				<h4>New Avatar</h4>

				<div class="dropzone" id="userAvatarUpload"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		Dropzone.options.userAvatarUpload = {
			accept: function (file, done) {
				console.log(file);
				done();
			},
			acceptedFiles: 'image/*',
			maxFilesize: 5.5,
			init: function () {
				this.on('success', function (file, result) {
					console.log(file, result);
				});
			},
			parallelUploads: 1,
			uploadMultiple: false,
			url: '/settings.php?upload=avatar'
		};
		
		var loadQueue = loadQueue || [];
		loadQueue.push(function () {
			if (me.user.years[year].role_convener) {
				console.log("asdf");
				document.querySelector(".settingsRow").innerHTML += '<div class="col-xs-12 col-sm-3"><a class="btn btn-info" id="addYearButton" href="#" style="display: block;"><span class="fui-plus"></span> Add new year</a></div>';
			}
		});
	</script>
<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>