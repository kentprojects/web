<!-- Our scripts -->
<script src="/includes/js/ajax.js" type="text/javascript"></script>
<script src="/includes/js/includes.php" type="text/javascript"></script>

<h1> I am a Jax </h1>

<script type="text/javascript">
	API.GET(
		//"/groups/", {},
		//"/projects/", {},
		//"/staff/", {},
		"/students/", {},
		function (data) {
			console.log(data);
		},
		function (data) {
			console.error(data);
		}
	);
</script>

<?php require PUBLIC_DIR . '/includes/php/footer.php'; ?>