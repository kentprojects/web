<h3 class="text-center" id="newTitle">Welcome to KentProjects!</h3>

<p class="text-center" id="newDescription">Before we can let you in, we need some information about you.</p>

<div class="row">
	<form class="form-horizontal" role="form" id="userName">
		<div class="form-group">
			<label for="firstName" class="control-label col-xs-12 col-sm-3 col-md-4 text-center">First Name</label>

			<div class="col-xs-12 col-sm-6 col-md-4">
				<input type="text" class="form-control" id="firstName" placeholder="First Name"
					pattern="^[A-z\-]+$" maxlength="20" data-error="Please enter a valid name" required>

				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label for="lastName" class="control-label col-xs-12 col-sm-3 col-md-4 text-center">Last Name</label>

			<div class="col-xs-12 col-sm-6 col-md-4">
				<input type="text" class="form-control" id="lastName" placeholder="Last Name"
					pattern="^[A-z\-]+$" maxlength="20" data-error="Please enter a valid name" required>

				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12 text-center">
				<button action="submit" class="btn btn-primary">Let me in!</button>
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
				var firstName = document.getElementById("firstName").value;
				var lastName = document.getElementById("lastName").value;
				API.PUT(
					"/me/",
					{
						first_name: firstName,
						last_name: lastName
					},
					function SaveUserNameSuccess() {
						window.location.href = "/dashboard.php";
					},
					function SaveUserNameError(data) {
						console.error(data);
					}
				);
			}
		});
</script>