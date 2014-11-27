<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
final class Auth
{
	/**
	 * @param string $code
	 * @return void
	 */
	public static function confirm($code)
	{
		$response = API::Request(API::POST, "/auth/confirm", array(), array("code" => $code));
		if ($response->status === 200)
		{
			Session::set("logged-in", true);
			Session::set("token", $response->body->token);
			Session::set("user", $response->body->user);

			if (Session::has("redirect-from"))
			{
				$redirect = Session::getOnce("redirect-from");
				redirect($redirect);
			}
			else
			{
				redirect("/dashboard.php");
			}
		}
		else
		{
			error_log($response);
		}
		return null;
	}

	/**
	 * @return bool
	 */
	public static function isLoggedIn()
	{
		return Session::has("logged-in") && Session::get("logged-in") === true;
	}

	/**
	 * @param string $code
	 * @return void
	 */
	public static function redirect($code)
	{
		Session::set("redirect-from", $_SERVER["REQUEST_URI"]);
		redirect(API::GetURL() . "/auth/internal");
	}
}