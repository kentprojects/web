<div class="jumbotron">
	<div class="container">
		<h3>You've done it!</h3>

		<section class="chosenProject"><p>A pat on the back is in order! Your group has found a project.</p></section>

	</div>
</div>

<script type="text/javascript">
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		document.querySelector(".chosenProject").innerHTML = document.querySelector(".chosenProject").innerHTML.replace("group", "<a href='/profile.php?type=group&id=" + me.group.id + "'>group</a>");
		document.querySelector(".chosenProject").innerHTML = document.querySelector(".chosenProject").innerHTML.replace("project", "<a href='/profile.php?type=project&id=" + me.project.id + "'>project</a>");

		if (me.group.creator.id == me.user.id) {
			document.querySelector(".chosenProject").innerHTML += ("<p>Now you just need to submit the paperwork to the CAS office.</p>");
			document.querySelector(".mainContent").innerHTML += ("<div class='jumbotron'><div class='container'><div class='row text-center'><section><p>Are you ready to submit your project application to the CAS office?</p></section><section><a class='btn btn-success' href='/intents.php?action=request&request=submitToCAS'>Let's do it!</a></section></div></div></div>");
		}
		else {
			document.querySelector(".chosenProject").innerHTML += ("<p>Now your group leader just needs to submit the paperwork to the CAS office.</p>");
		}
	});
</script>