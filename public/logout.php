<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
require_once __DIR__ . "/../private/bootstrap.php";
Session::destroy();
redirect(API::GetURL() . "/auth/logout?url=" . config("logout"));
exit();