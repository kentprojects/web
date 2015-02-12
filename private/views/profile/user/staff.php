<div class="container">
	<div class="row">
		<h1>Profile</h1>
		<p>Your email address is "<b id="user_email"> not available right now :(</b>"</p>
		<p>Your role is "<b id="user_role"> not available right now :(</b>"</p>
		<script type="text/javascript">
			API.GET(
				"/staff/" +profileId, {},
				function (data) {
					document.getElementById("user_email").innerText = data.body.email;
					document.getElementById("user_role").innerText = data.body.role;
				},
				function (data)	{console.error(data);}
			);
		</script>
	</div>
</div>