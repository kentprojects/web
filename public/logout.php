<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
require_once __DIR__ . "/../private/bootstrap.php";
Session::destroy();
/**
 * For our corpus edition, we have to make a few alterations to the login and logout.
 * Namely, hide all traces of SimpleSAML (to avoid errors) and handle redirects appropriately.
 */
if (!empty($_SERVER["CORPUS_ENV"]))
{
	redirect("http://localhost:8080/");
}
else {
	redirect(API::GetURL() ."/auth/logout?url=" . config("logout"));
}
exit();
