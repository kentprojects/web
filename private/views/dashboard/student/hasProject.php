<div class="jumbotron">
	<div class="container">
		<h3>You've done it!</h3>

		<section class="chosenProject"><p>A pat on the back is in order! Well done for finding a project.</p>

		<p>Now you just need to submit the paperwork to the CAS office.</p></section>

	</div>
</div>

<div class="jumbotron">
	<div class="container">
		<div class="row text-center">

			<section><p>Are you ready to submit your project application to the CAS office?</p></section>

			<section>
				<a class="btn btn-success" href="/intents.php?action=request&request=submitToCAS">Let's do it!</a>
			</section>
		</div>
	</div>
</div>

<script type="text/javascript">
	var loadQueue = loadQueue || [];
	loadQueue.push(function () {
		document.querySelector(".chosenProject").innerHTML = '<p>A pat on the back is in order! Well done for finding a ' + "<a href='/profile.php?type=project&id=" + me.project.id + "'>project</a>.</p><p>Now you just need to submit the paperwork to the CAS office.</p>";
	});
</script>