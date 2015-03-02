<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
final class Auth
{
	private static /** @noinspection SpellCheckingInspection */
		$simpleSamlAPI = "https://api.kentprojects.com/simplesaml";
	private static /** @noinspection SpellCheckingInspection */
		$simpleSamlLogout = "/module.php/core/authenticate.php?as=default-sp&logout";

	/**
	 * @param string $code
	 * @return void
	 */
	public static function confirm($code)
	{
		$response = API::Request(API::POST, "/auth/confirm", array(), array("code" => $code));

		if ($response->status === 200)
		{
			if (!is_object($response->body))
			{
				$response->body = json_decode($response->body);
			}

			Session::set("logged-in", true);
			Session::set(API::USERTOKEN_SESSIONKEY, $response->body->token);

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
			error_log((string)$response);
		}
	}

	/**
	 * @return string
	 */
	public static function getLogoutUrl()
	{
		if (Session::get("login-via-sso", 0) == 1)
		{
			$dev = (config("environment") === "development") ? "dev." : "";
			return static::$simpleSamlAPI . static::$simpleSamlLogout . "&ReturnTo=http://{$dev}kentprojects.com";
		}
		else
		{
			return "/";
		}
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
		Session::set("login-via-sso", empty($code) ? 1 : 0);
		redirect(API::GetURL() . (empty($code) ? "/auth/sso" : "/auth/internal?auth=" . $code));
	}
}