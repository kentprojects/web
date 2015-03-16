<h3 class="text-center" id="newTitle">Create a new project</h3>

<p class="text-center" id="newDescription">What would you like to call your new project proposal?</p>

<div class="row">
	<form class="form-horizontal" role="form" id="userName">
		<div class="form-group">
			<label for="projectName" class="control-label col-xs-12 col-sm-3 col-md-4 text-center">Project Name</label>

			<div class="col-xs-12 col-sm-6 col-md-4">
				<input type="text" class="form-control" id="projectName" placeholder="Project Name"
					pattern="^[A-z0-9\ \-]+$" maxlength="100" data-error="Please enter a valid name" required>

				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12 text-center">
				<button action="submit" class="btn btn-primary">Create it!</button>
			</div>
		</div>
	</form>
</div>
<script src="/includes/js/lib/validator.min.js"></script>
<script>
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		$.getScript('/includes/js/lib/validator.min.js', function () {
			$('#userName').validator()

				.on('submit', function (e) {
					if (e.isDefaultPrevented()) {
						// Do nothing
					}
					else {
						e.preventDefault();
						var projectName = document.getElementById("projectName").value;
						API.POST(
							"/project",
							{
								name: projectName
							},
							function SaveProjectNameSuccess(data) {
								window.location.href = "/profile.php?type=project&id=" + data.body.id;
							},
							function SaveProjectNameError(data) {
								console.error(data);
							}
						);
					}
				});
		});
	});
</script>