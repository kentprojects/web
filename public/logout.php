<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
require_once __DIR__ . "/../private/bootstrap.php";
Session::destroy();
redirect(
	(empty($_SERVER["CORPUS_ENV"]) ? API::GetURL() : "http://localhost:8080") .
	"/auth/logout?url=" . config("logout")
);
exit();
