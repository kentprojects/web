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

$variables = array(
	"user" => (!empty($user) ? $user : new stdClass)
);

if (!empty($user))
{
	$meRequest = API::Request(API::GET, "/me");
	if ($meRequest->status == 200)
	{
		$meRequest = $meRequest->body;
		Session::set("meRequest", $meRequest);
	}
	else
	{
		error_log((string)$meRequest);
		$meRequest = null;
	}

	$variables["group"] = !empty($meRequest->group) ? $meRequest->group : new stdClass;
	$variables["project"] = !empty($meRequest->project) ? $meRequest->project : new stdClass;
}

header("HTTP/1.1 200 OK");
header("Content-Type: text/javascript");

echo <<<EOT
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
var me = {};
EOT;

foreach ($variables as $key => $value)
{
	echo PHP_EOL . "me.$key = " . json_encode($value, JSON_PRETTY_PRINT) . ";";
}