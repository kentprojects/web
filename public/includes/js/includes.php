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
	"me" => new stdClass,
	"me.user" => (!empty($user) ? $user : new stdClass)
);

if (!empty($user))
{
	if (Session::has("meRequest"))
	{
		$meRequest = Session::get("meRequest");
	}
	else
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
	}

	if (!empty($meRequest))
	{
		$variables["me.group"] = !empty($meRequest->group) ? $meRequest->group : new stdClass;
		$variables["me.project"] = !empty($meRequest->project) ? $meRequest->project : new stdClass;
	}
}

header("HTTP/1.1 200 OK");
header("Content-Type: text/javascript");

echo <<<EOT
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

EOT;

foreach ($variables as $key => $value)
{
	echo "var $key = " . json_encode($value, JSON_PRETTY_PRINT) . ";" . PHP_EOL;
}