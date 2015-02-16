<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * @var stdClass $user
 */
$text = Intents::getValuesForAPage(strtolower($_GET["request"]));
require PUBLIC_DIR . "/includes/php/header.php";
?>
	<div class="container">
		<div class="Header"></div>
		<div class="jumbotron">
			<div class="container">
				<h3>Ask someone to let you something?</h3>

				<p>Someone will be asked if you can do the thing.</p>

				<form action="" method="POST">
					<div class="btn-group">
						<button class="btn btn-primary" type="submit" value="accept">Yes, please</button>
						<button class="btn btn-info" type="submit" value="decline">Actually, no</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="/includes/js/ajax.js" type="text/javascript"></script>
	<script src="/includes/js/includes.php" type="text/javascript"></script>
	<script type="text/javascript">
		(function OnPageLoad() {

		})();
	</script>
<?php
require PUBLIC_DIR . "/includes/php/footer.php";