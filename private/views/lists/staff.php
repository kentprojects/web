<div class="container">
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8">
			<h1 class="reduceHeading hideEdit"> View Staff </h1>
		</div>
		<!--<div class="col-xs-4 col-md-4 alignRight">
			<button style="margin-top:40px;"> Edit</button>
		</div>-->

		<script type="text/javascript">
		API.GET(
		//"/groups/", {},
		//"/projects/", {},
		"/staff/", {},
		//"/students/", {},
		function (data) {
			console.log(data);
			var output = "<table class='table table-striped'><thead><tr><th>Name</th><th class='mobileHide'>Interests</th></tr></thead><tbody>";
				for (var i = 0; i < data.body.length; i++) {
					if (data.body[i].name != "") {
					output += "<tr><td>" + data.body[i].name + "</td></tr>";
				}
				else {
					output += "<tr><td>" + data.body[i].email + "</td></tr>";
				}
				};
				output += "</tbody></table>";
				document.getElementById('listContents').innerHTML = output;
		},
		function (data) {
			console.error(data);
		}
	);
		</script>
	</div>
</div>