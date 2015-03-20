<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
final class API
{
	const GET = "api:request:get";
	const POST = "api:request:post";
	const PUT = "api:request:put";
	const DELETE = "api:request:delete";
	const HEAD = "api:request:head";

	const USERTOKEN_SESSIONKEY = "token";

	/**
	 * @var array
	 */
	private static $lastRequest;
	/**
	 * @var ApiResponse
	 */
	private static $lastResponse;

	/**
	 * @return array
	 */
	public static function getLastRequest()
	{
		return static::$lastRequest;
	}

	/**
	 * @return ApiResponse
	 */
	public static function getLastResponse()
	{
		return static::$lastResponse;
	}

	/**
	 * @return string
	 */
	public static function GetURL()
	{
		return config("api", "url");
	}

	/**
	 * @param resource $ch
	 * @param string $response
	 * @return array
	 */
	protected static function getResponse($ch, $response)
	{
		/**
		 * Divide the response between header and body :)
		 */
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$curlHeaders = substr($response, 0, $header_size);
		$body = substr($response, $header_size);

		/**
		 * Format the headers into key => value.
		 */
		$headers = array();
		$curlHeaders = explode("\n", $curlHeaders);
		array_shift($curlHeaders);
		foreach ($curlHeaders as $header)
		{
			$header = trim($header);
			if (empty($header))
			{
				continue;
			}

			$header = explode(":", $header, 2);
			if (count($header) != 2)
			{
				error_log("Unknown header from API request: ", implode(":", $header));
				continue;
			}

			$headers[trim($header[0])] = trim($header[1]);
		}

		/**
		 * Parse the body.
		 */
		if (!empty($body))
		{
			$body = json_decode($body);
			if (empty($body))
			{
				$body = null;
			}
		}
		else
		{
			$body = null;
		}

		/**
		 * And return our findings!
		 */
		return array($headers, $body);
	}

	/**
	 * @param string $method
	 * @param string $endpoint
	 * @param array $getParams
	 * @param array $postParams
	 * @throws InvalidArgumentException
	 * @return ApiResponse
	 */
	public static function Request($method, $endpoint, array $getParams = array(), array $postParams = array())
	{
		static::$lastRequest = array();
		static::$lastResponse = null;

		/**
		 * If you didn't pass a valid API constant, then throw an exception.
		 */
		if (strpos($method, "api:request:") !== 0)
		{
			throw new InvalidArgumentException("Invalid method supplied to API:Request.");
		}
		/**
		 * If you didn't pass a valid API endpoint, throw an exception.
		 */
		if (strpos($endpoint, "/") !== 0)
		{
			throw new InvalidArgumentException("Endpoint should start with a '/'.");
		}
		/**
		 * Are you messing with me right now?
		 */
		if (($method === API::GET) && (!empty($postParams)))
		{
			throw new InvalidArgumentException("GET requests cannot have POST data.");
		}

		/**
		 * Sort out the request signature.
		 */
		$getParams = array_merge($getParams, array(
			"key" => config("api", "key"),
			"expires" => time() + config("api", "expires")
		));
		/**
		 * If the user has given us a user token, then use it in every request.
		 * Automatically. Seamlessly. Instantaneously. On the line.
		 */
		if (Session::has(static::USERTOKEN_SESSIONKEY))
		{
			$getParams["user"] = Session::get(static::USERTOKEN_SESSIONKEY);
		}
		/**
		 * And sign the request!
		 */
		unset($getParams["signature"]);
		ksort($getParams);
		array_walk(
			$getParams,
			function (&$v)
			{
				$v = (string)$v;
			}
		);
		/**
		 * Swish and flick!
		 */
		$getParams["signature"] = md5(config("api", "salt") . config("api", "secret") . json_encode($getParams));

		static::$lastRequest["getParams"] = $getParams;

		/**
		 * Set the standard headers.
		 */
		$headers = array("Accept-Type: application/json");

		/**
		 * If we have been supplied some POST data.
		 */
		if (!empty($postParams))
		{
			/**
			 * Convert the POST data to JSON.
			 */
			$postParams = json_encode($postParams);
			/**
			 * And set some more headers!
			 */
			array_push(
				$headers,
				"Content-Type: application/json",
				"Content-Length: " . strlen($postParams)
			);
		}

		static::$lastRequest["postParams"] = $postParams;
		static::$lastRequest["headers"] = $headers;

		/**
		 * Initialise a CURL handler.
		 * (And make a variable for a potential file handler (for PUT!))
		 */
		$ch = curl_init(
			static::GetURL() . $endpoint . "?" . http_build_query($getParams, null, "&")
		);
		$fh = null;
		static::$lastRequest["url"] = static::GetURL() . $endpoint . "?" . http_build_query($getParams, null, "&");

		/**
		 * Set various CURL options.
		 */
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		/**
		 * If the requested method is POST, PUT or DELETE
		 */
		switch ($method)
		{
			case API::HEAD:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper(str_replace("api:request:", "", $method)));
				break;
			/**
			 * For POST or DELETE requests, set the post fields.
			 */
			case API::POST:
			case API::DELETE:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper(str_replace("api:request:", "", $method)));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
				break;
			/**
			 * For PUT requests, set the file handler contents.
			 */
			case API::PUT:
				$fh = fopen('php://memory', 'rw');
				fwrite($fh, $postParams);
				rewind($fh);
				curl_setopt($ch, CURLOPT_INFILE, $fh);
				curl_setopt($ch, CURLOPT_INFILESIZE, strlen($postParams));
				curl_setopt($ch, CURLOPT_PUT, true);
				break;
		}

		/**
		 * Execute the CURL request, and get back the additional header information!
		 */
		list($headers, $body) = static::getResponse($ch, curl_exec($ch));
		static::$lastResponse = new ApiResponse(curl_getinfo($ch, CURLINFO_HTTP_CODE), $headers, $body);

		/**
		 * Close the handlers.
		 */
		!empty($fh) && fclose($fh);
		curl_close($ch);

		return static::$lastResponse;
	}
}

final class ApiResponse implements JsonSerializable
{
	/**
	 * @var array|stdClass
	 */
	public $body;
	/**
	 * @var array
	 */
	public $headers;
	/**
	 * @var int
	 */
	public $status;

	/**
	 * @param int $status
	 * @param array $headers
	 * @param string $body
	 */
	public function __construct($status = 500, array $headers = array(), $body = null)
	{
		$this->body = $body;
		$this->headers = $headers;
		$this->status = $status;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf(
			"API Response %d %s with headers %s and body %s",
			$this->status, $this->getStatusMessage(),
			json_encode($this->headers), json_encode($this->body)
		);
	}

	/**
	 * @return string
	 */
	public function getStatusMessage()
	{
		return getHttpStatusForCode($this->status);
	}

	public function JsonSerialize()
	{
		return array(
			"status" => $this->status,
			"message" => $this->getStatusMessage(),
			"headers" => $this->headers,
			"body" => $this->body
		);
	}
}