<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

try
{
	/**
	 * TODO: Block any requests not originating from our website.
	 */

	require_once __DIR__ . "/../private/api.php";
	require_once __DIR__ . "/../private/functions.php";

	/**
	 * The data being representing the request.
	 *
	 * @var array $data
	 */
	$data = array_merge(
		array(
			"method" => "",
			"url" => "",
			"query" => array(),
			"post" => array()
		),
		json_decode(file_get_contents("php://input"), true)
	);
	/**
	 * A list of valid methods.
	 *
	 * @var array $methods
	 */
	$methods = array("GET", "POST", "PUT", "DELETE");
	/**
	 * @var ApiResponse $response
	 */
	$response = null;

	/**
	 * If we are missing core components, fail.
	 */
	if (empty($data["method"]) || empty($data["url"]))
	{
		throw new InvalidArgumentException("Missing method and/or URL.");
	}
	/**
	 * If the query or post data isn't an array, fail.
	 */
	elseif (!is_array($data["query"]) || !is_array($data["post"]))
	{
		throw new InvalidArgumentException("Query / Post data must be an array.");
	}
	/**
	 * If we have been given a method we don't support, fail.
	 */
	elseif (!in_array(strtoupper($data["method"]), $methods))
	{
		throw new InvalidArgumentException("Invalid method given. Method must be one of: " . implode(" | ", $methods));
	}
	/**
	 * Otherwise we're looking good, so run the request!
	 */
	else
	{
		$response = API::Request(
			"api:request:" . strtolower($data["method"]), $data["url"], $data["query"], $data["post"]
		);

		/*
		error_log(json_encode(API::getLastRequest(), JSON_UNESCAPED_SLASHES));
		error_log(json_encode(API::getLastResponse(),  JSON_UNESCAPED_SLASHES));
		*/
	}
}
catch (Exception $e)
{
	$response = new ApiResponse(500, (string)$e);
}

header(sprintf("HTTP/1.1 %d %s", $response->status, $response->getStatusMessage()));
header("Content-Type: application/json");
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);