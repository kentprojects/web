<!--
/**
 * @author: Matt House <matt.house@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */—->
<!--HTML elements to allow the user to generate a new group.-->
<h3 class="text-center" id="newTitle">Create a new group</h3>

<p class="text-center" id="newDescription">What would you like to call your new group?</p>

<div class="row">
	<form class="form-horizontal" role="form" id="userName">
		<div class="form-group">
			<label for="groupName" class="control-label col-xs-12 col-sm-3 col-md-4 text-center">Group Name</label>

			<div class="col-xs-12 col-sm-6 col-md-4">
				<input type="text" class="form-control" id="groupName" placeholder="Group Name"
					pattern="^[A-z0-9\ \-\']+$" maxlength="100" data-error="Please enter a valid name" required>

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
<script>
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		$.getScript('/includes/js/lib/validator.min.js', function() {
			$('#userName').validator()
				.on('submit', function (e) {
					if (e.isDefaultPrevented()) {
						// Do nothing
					}
					else {
						// Call API methods to create new group
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
		});
	});
</script>