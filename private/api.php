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

	/**
	 * @return string
	 */
	public static function GetURL()
	{
		return config("api", "url");
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

		/**
		 * Initialise a CURL handler.
		 * (And make a variable for a potential file handler (for PUT!))
		 */
		$ch = curl_init();
		$fh = null;

		/**
		 * Set various CURL options.
		 */
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL, static::GetURL() . $endpoint . "?" . http_build_query($getParams, null, "&"));

		/**
		 * If the requested method is POST, PUT or DELETE
		 */
		switch ($method)
		{
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
		$body = curl_exec($ch);
		$headers = curl_getinfo($ch);

		/**
		 * Close the handlers.
		 */
		if ($method === API::PUT)
		{
			fclose($fh);
		}
		curl_close($ch);

		/**
		 * Return a response.
		 */
		return new ApiResponse($headers["http_code"], $body);
	}
}

final class ApiResponse
{
	/**
	 * @var array|stdClass
	 */
	public $body;
	/**
	 * @var string
	 */
	protected $raw;
	/**
	 * @var int
	 */
	public $status;

	/**
	 * @param int $status
	 * @param string $body
	 */
	public function __construct($status, $body)
	{
		$this->status = $status;
		$this->raw = $body;
		$this->body = json_decode($body);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf(
			"API Response %d %s with body: %s",
			$this->status,
			getHttpStatusForCode($this->status),
			$this->raw
		);
	}

	/**
	 * @return string
	 */
	public function getRawData()
	{
		return $this->raw;
	}

	/**
	 * @return string
	 */
	public function getStatusMessage()
	{
		return getHttpStatusForCode($this->status);
	}
}