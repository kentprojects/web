<div class="container">
	<div class="row">
		<h1 id="projectName">Project Profile</h1>
	</div>
</div>

<script type="text/javascript">
	API.GET(
		"/project/" + profileId, {},
		function (data) {
			document.getElementById("projectName").innerText = data.body.name;
		},
		function (data) {
			console.error(data);
		}
	);
</script>