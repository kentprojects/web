<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * Don't panic. There's a PHP file hiding in the middle of the Javascript files!
 *
 * @var stdClass $meRequest
 */
$prerequisites = array("authentication");
require_once __DIR__ . "/../../../private/bootstrap.php";
$variables = array(
	"user" => !empty($meRequest->user) ? $meRequest->user : new stdClass,
	"group" => !empty($meRequest->group) ? $meRequest->group : new stdClass,
	"project" => !empty($meRequest->project) ? $meRequest->project : new stdClass,
	"notifications" => !empty($meRequest->notifications) ? $meRequest->notifications : array(),
	"intents" => !empty($meRequest->intents) ? $meRequest->intents : array(),
	"settings" => !empty($meRequest->settings) ? $meRequest->settings : new stdClass
);

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