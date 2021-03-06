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
			// error_log(json_encode($response->body));

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
		redirect(
			(empty($_SERVER["CORPUS_ENV"]) ? API::GetURL() : "http://localhost:8080") .
			(empty($code) ? "/auth/sso" : "/auth/internal?auth=" . $code)
		);
	}
}
