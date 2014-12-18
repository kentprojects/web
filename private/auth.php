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
			die((string) $response);

			Session::set("logged-in", true);
			Session::set("user", $response->body->user);

			API::setUserToken($response->body->token);

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
	 * @return stdClass|null
	 */
	public static function getUser()
	{
		return Session::get("user");
	}

	/**
	 * @return bool
	 */
	public static function isLoggedIn()
	{
		return Session::has("logged-in") && Session::get("logged-in") === true;
	}

	/**
	 * @param string $code Code is only optional for our Fake SSO.
	 * @return void
	 */
	public static function redirect($code = null)
	{
		redirect(API::GetURL() . (empty($code) ? "/auth/sso" : "/auth/internal?auth=" . $code));
	}
}