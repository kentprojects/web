<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * @var array $prerequisites
 */
define("PRIVATE_DIR", __DIR__);
define("PUBLIC_DIR", __DIR__ . "/../public");
define("VIEWS_DIR", PRIVATE_DIR . "/views");

/**
 * Display and report all of the errors.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/api.php";
require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/kentprojects.php";
require_once __DIR__ . "/session.php";

while (!empty($prerequisites))
{
	switch (array_shift($prerequisites))
	{
		case "authentication":
			if (!Auth::isLoggedIn())
			{
				Session::set("redirect-from", $_SERVER["REQUEST_URI"]);
				redirect("/login.php");
				exit();
			}

			$meRequest = API::Request(API::GET, "/me");
			if ($meRequest->status == 200)
			{
				$meRequest = $meRequest->body;
			}
			else
			{
				$meRequest = new stdClass;
			}

			if (empty($meRequest->user) || empty($meRequest->user->id))
			{
				logout();
				exit();
			}

			if (empty($meRequest->user->name))
			{
				if (
					(strpos($_SERVER["SCRIPT_NAME"], "/includes") !== 0) &&
					($_SERVER["SCRIPT_NAME"] != "/new.php") &&
					($_GET["type"] != "user")
				)
				{
					redirect("/new.php?type=user");
				}
			}
			break;
	}
}