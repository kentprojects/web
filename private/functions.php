<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

/**
 * @param string|null $section
 * @param string|null $key
 * @throws InvalidArgumentException
 * @return array|string
 */
function config($section = null, $key = null)
{
	if (empty($GLOBALS["config.ini"]))
	{
		if (file_exists(__DIR__ . "/../config.production.ini"))
		{
			$configFile = __DIR__ . "/../config.production.ini";
		}
		elseif (file_exists(__DIR__ . "/../config.ini"))
		{
			$configFile = __DIR__ . "/../config.ini";
		}
		else
		{
			trigger_error("No config file found.", E_USER_ERROR);
			return null;
		}
		$GLOBALS["config.ini"] = parse_ini_file($configFile, true);
	}
	switch (func_num_args())
	{
		case 2:
			return $GLOBALS["config.ini"][$section][$key];
		case 1:
			return $GLOBALS["config.ini"][$section];
		default:
			throw new InvalidArgumentException("Invalid number of arguments for function config.");
	}
}

/**
 * @param int $code
 * @return string
 */
function getHttpStatusForCode($code)
{
	$codes = array(
		// Continuation
		100 => "Continue",
		101 => "Switching Protocols",

		// Success
		200 => "OK",
		201 => "Created",
		202 => "Accepted",
		203 => "Non-Authoritative Information",
		204 => "No Content",
		205 => "Reset Content",
		206 => "Partial Content",

		// 30X Redirection
		300 => "Multiple Choices",
		301 => "Moved Permanently",
		302 => "Found",
		303 => "See Other",
		304 => "Not Modified",
		305 => "Use Proxy",
		306 => "(Unused)",
		307 => "Temporary Redirect",

		// 4XX Client Error
		400 => "Bad Request",
		401 => "Unauthorized",
		402 => "Payment Required",
		403 => "Forbidden",
		404 => "Not Found",
		405 => "Method Not Allowed",
		406 => "Not Acceptable",
		407 => "Proxy Authentication Required",
		408 => "Request Timeout",
		409 => "Conflict",
		410 => "Gone",
		411 => "Length Required",
		412 => "Precondition Failed",
		413 => "Request Entity Too Large",
		414 => "Request-URI Too Long",
		415 => "Unsupported Media Type",
		416 => "Requested Range Not Satisfiable",
		417 => "Expectation Failed",

		// 50X Server Error
		500 => "Internal Server Error",
		501 => "Not Implemented",
		502 => "Bad Gateway",
		503 => "Service Unavailable",
		504 => "Gateway Timeout",
		505 => "HTTP Version Not Supported"
	);
	return (isset($codes[$code])) ? $codes[$code] : "";
}

/**
 * @param string $url The URL to redirect to.
 * @param int $code A 3xx redirect code.
 */
function redirect($url, $code = 301)
{
	header(sprintf("HTTP/1.1 %d %s", $code, getHttpStatusForCode($code)));
	header(sprintf("Location: %s", $url));
	exit(0);
}