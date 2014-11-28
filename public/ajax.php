<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * Here one should ensure we block any requests from an external source.
 */
require_once __DIR__ . "/../private/api.php";
try
{
	$postData = json_decode(file_get_contents("php://input"), true);
	if (empty($postData["method"]) || empty($postData["url"]))
	{
		throw new InvalidArgumentException("Missing method and/or URL.");
	}

	$response = API::Request(
		"api:request:" . strtolower($postData["method"]),
		$postData["url"],
		$postData["query"],
		$postData["post"]
	);
}
catch (Exception $e)
{
	header("HTTP/1.1 500 Internal Server Error");
}