<?php
try
{
	// define("DEVELOPMENT", !empty($_SERVER["HTTP_KENTPROJECTS_DEV"]));
	define("DEVELOPMENT", true);
	
	$API = (object) array(
		"authentication" => (object) array(
			"expires" => 300,
			"key" => "1234",
			"salt" => "kylie",
			"secret" => "5678"
		),
		"baseurl" => "http://api".(DEVELOPMENT ? ".dev" : "").".kentprojects.com",
		"headers" => array(
			"Accept-Type" => "application/json",
			"Content-Type" => "application/json",
			"Development" => DEVELOPMENT
		)
	);
	
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
	
	if ($_SERVER["REQUEST_METHOD"] === "PUT")
	{
		fclose($fh);
	}

	/**
	 * Close the CURL handle.
	 */
	curl_close($ch);
	
	header("HTTP/1.1 200 OK");
	header("Content-Type: application/json");
	header("X-API-URL: $url");
	// print_r($API->headers);
	echo $body;
	exit(0);
}
catch(Exception $e)
{
	header("HTTP/1.1 500 Internal Server Error");
	exit(1);
}