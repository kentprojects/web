<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 *
 * @var array $prerequisites
 */
require_once __DIR__."/api.php";
require_once __DIR__."/auth.php";
require_once __DIR__."/functions.php";
require_once __DIR__."/session.php";

while(!empty($prerequisites))
{
	switch(array_shift($prerequisites))
	{
		case "authentication":
			if (!Auth::isLoggedIn())
			{
				redirect("/login.php");
				exit();
			}
			break;
		case "supervisor":
			break;
	}
}