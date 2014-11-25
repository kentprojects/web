<?php
/**
 * A lovely long list of status codes that a response or exception could use.
 *
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
		505 => "HTTP Version Not Supported",

		// 70X Inexcusable
		701 => "Meh",
		702 => "Emacs",
		703 => "Explosion",

		// 71X Novelty Implementations
		710 => "PHP",
		711 => "Convenience Store",
		712 => "NoSQL",
		719 => "I am not a teapot",

		// 72X Edge Cases
		720 => "Unpossible",
		721 => "Known Unknowns",
		722 => "Unknown Unknowns",
		723 => "Tricky",
		724 => "This line should be unreachable",
		725 => "It works on my machine",
		726 => "It's a feature, not a bug",
		727 => "32 bits is plenty",

		// 73X Fucking
		731 => "Fucking Rubygems",
		732 => "Fucking Unicode",
		733 => "Fucking Deadlocks",
		734 => "Fucking Deferreds",
		735 => "Fucking IE",
		736 => "Fucking Race Conditions",
		737 => "FuckingThreadsing",
		738 => "Fucking Bundler",
		739 => "Fucking Windows",

		// 74X Meme Driven
		740 => "Computer says no",
		741 => "Compiling",
		742 => "A kitten dies",
		743 => "I thought I knew regular expressions",
		744 => "Y U NO write integration tests?",
		745 => "I don't always test me code, but when I do I do it in production",
		746 => "Missed Ballmer Peak",
		747 => "Motherfucking Snakes on the Motherfucking Plane",
		748 => "Confounded by ponies",
		749 => "Reserved for Chuck Norris"
	);
	return (isset($codes[$code])) ? $codes[$code] : "";
}

try
{
	define("DEVELOPMENT", "true");
	
	$API = (object) array(
		"authentication" => (object) array(
			"expires" => 300,
			"key" => "77bf0b0815ce058841d74298394643ab",
			"salt" => "aboard-hay-fish-grass",
			"secret" => "7ede1f827d744b39666214441122764c"
		),
		"baseurl" => "http://api".(DEVELOPMENT ? ".dev" : "").".kentprojects.com",
		"headers" => array(
			"Accept-Type" => "application/json",
			"Content-Type" => "application/json",
			"Development" => DEVELOPMENT
		)
	);
	
	if (!empty($_SERVER["VAGRANT_ENV"]) && ($_SERVER["VAGRANT_ENV"] == "true"))
	{
		$API->baseurl = "http://172.16.1.11";
	}
	
	$_SERVER["REQUEST_METHOD"] = strtoupper($_SERVER["REQUEST_METHOD"]);
	$_SERVER["PATH_INFO"] = (empty($_SERVER["PATH_INFO"])) ? "/" : $_SERVER["PATH_INFO"];
	
	$_GET = array_merge($_GET, array(
		"key" => $API->authentication->key,
		"expires" => time()+$API->authentication->expires
	));
	
	unset($_GET["signature"]);
	ksort($_GET);
	array_walk($_GET, function(&$v) { $v = (string) $v; });
	$_GET["signature"] = md5($API->authentication->salt . $API->authentication->secret . json_encode($_GET));
	
	$ch = curl_init();
	$url = $API->baseurl.$_SERVER["PATH_INFO"] . "?" . http_build_query($_GET, null, "&");
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $API->headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_URL, $url);
	
	switch($_SERVER["REQUEST_METHOD"])
	{
		case "POST":
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
			break;
		case "PUT":
			$body = $_POST;
			$length = strlen($body);
			$fh = fopen('php://memory', 'rw');
			fwrite($fh, $body);
			rewind($fh);
			curl_setopt($ch, CURLOPT_INFILE, $fh);
			curl_setopt($ch, CURLOPT_INFILESIZE, $length);
			curl_setopt($ch, CURLOPT_PUT, true);
			break;
	}
	
	$body = curl_exec($ch);
	$headers = curl_getinfo($ch);
	
	/**
	 * Close all the necessary stuff.
	 */
	if ($_SERVER["REQUEST_METHOD"] === "PUT")
	{
		fclose($fh);
	}
	curl_close($ch);
	
	header(sprintf(
		"HTTP/1.1 %d %s", $headers["http_code"], getHttpStatusForCode($headers["http_code"])
	));
	header("X-API-Output: $body");
	if (json_decode($body) === null)
	{
		header("Content-Type: text/plain");
	}
	else
	{
		header("Content-Type: application/json");
	}
	header("X-API-URL: $url");
	// print_r($API->headers);
	echo $body;
	exit(0);
}
catch(Exception $e)
{
	header("HTTP/1.1 500 Internal Server Error");
	echo (string) $e;
	exit(1);
}