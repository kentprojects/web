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
				<h3>Someone would like to something!</h3>

				<p>If you let them something, then something will happen. If you don't let them something, something
					else will happen.</p>

				<form action="" method="POST">
					<div class="btn-group">
						<button class="btn btn-primary" type="submit" value="accept">Accept</button>
						<button class="btn btn-info" type="submit" value="decline">Decline</button>
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