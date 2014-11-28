<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * Don't panic. There's a PHP file hiding in the middle of the Javascript files!
 */
require_once __DIR__ . "/../../../private/bootstrap.php";

$user = Auth::getUser();
if (empty($user))
{
	$user = new stdClass;
}

header("HTTP/1.1 200 OK");
header("Content-Type: text/javascript");
?>
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
var user = <?php echo json_encode($user);?>;