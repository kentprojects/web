<h3 class="text-center" id="newTitle">Create a new group</h3>

<p class="text-center" id="newDescription">What would you like to call your new group?</p>

<div class="row">
	<form class="form-horizontal" role="form" id="userName">
		<div class="form-group">
			<label for="groupName" class="control-label col-xs-12 col-sm-3 col-md-4 text-center">Group Name</label>

			<div class="col-xs-12 col-sm-6 col-md-4">
				<input type="text" class="form-control" id="groupName" placeholder="Group Name"
					pattern="^[A-z\ ]+$" maxlength="100" data-error="Please enter a valid name" required>

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

	$('#userName').validator()

		.on('submit', function (e) {
			if (e.isDefaultPrevented()) {
				// Do nothing
			}
			else {
				e.preventDefault();
				var groupName = document.getElementById("groupName").value;
				API.POST(
					"/group",
					{
						name: groupName
					},
					function SaveProjectNameSuccess(data) {
						console.log(data);
						window.location.href = "/profile.php?type=group&id=" + data.body.id;
					},
					function SaveProjectNameError(data) {
						console.error(data);
					}
				);
			}
		});
</script>