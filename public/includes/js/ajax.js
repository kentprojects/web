/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

var API = {};


/**
 * Perform a GET request.
 *
 * API.GET("/user/1", {}, function(response) {
 *     var user = response.body;
 *     console.log(user.email);
 * });
 *
 * @param url The endpoint to request.
 * @param query Any query data (as an object).
 * @param success The function to run upon success
 * @param error The function to run upon error.
 * @return void
 */
API.GET = function (url, query, success, error) {
	API._Request("GET", url, query, {}, success, error);
};

/**
 * Perform a POST request.
 *
 * API.POST(
 *     "/user",
 *     {
 *         "email": "matt.house@kentprojects.com"
 *     },
 *     function(response)
 *     {
 *         console.log(response.status); // 201
 *         console.log(response.body.email); // matt.house@kentprojects.com
 *     }
 * );
 *
 * @param url The endpoint to request.
 * @param post Any post data (as an object).
 * @param success The function to run upon success
 * @param error The function to run upon error.
 * @return void
 */
API.POST = function (url, post, success, error) {
	API._Request("POST", url, {}, post, success, error);
};

/**
 * Perform a PUT request.
 *
 * API.PUT(
 *     "/user/1",
 *     {
 *         "email": "matt.house@kentprojects.com"
 *     },
 *     function(response)
 *     {
 *         console.log(response.status); // 200
 *         console.log(response.body.email); // matt.house@kentprojects.com
 *     }
 * );
 *
 * @param url The endpoint to request.
 * @param post Any post data (as an object).
 * @param success The function to run upon success
 * @param error The function to run upon error.
 * @return void
 */
API.PUT = function (url, post, success, error) {
	API._Request("PUT", url, {}, post, success, error);
};

/**
 * Perform a DELETE request.
 *
 * API.DELETE("/user/1", {}, function(response) {
 *     console.log(response.status); // 200
 *     console.log(response.body.email); // UNDEFINED
 * });
 *
 * @param url The endpoint to request.
 * @param query Any query data (as an object).
 * @param success The function to run upon success
 * @param error The function to run upon error.
 * @return void
 */
API.DELETE = function (url, query, success, error) {
	API._Request("DELETE", url, query, {}, success, error);
};

/**
 * Perform a HEAD request. Which is exactly like a GET request, but without a `body`.
 *
 * API.HEAD("/user/1", {}, function(response) {
 *     var user = response.body;
 *     console.log(user.email);
 * });
 *
 * @param url The endpoint to request.
 * @param query Any query data (as an object).
 * @param success The function to run upon success
 * @param error The function to run upon error.
 * @return void
 */
API.HEAD = function (url, query, success, error) {
	API._Request("HEAD", url, query, {}, success, error);
};

/**
 * Performs the main request.
 * This should not be run by hand.
 *
 * @param method The method to request.
 * @param url The endpoint to request.
 * @param query Any query data (as an object).
 * @param post Any post data (as an object).
 * @param success The function to run upon success
 * @param error The function to run upon error.
 * @return void
 */
API._Request = function (method, url, query, post, success, error) {
	var r = new XMLHttpRequest();
	r.open("POST", "/ajax.php", true);
	//noinspection SpellCheckingInspection
	r.onreadystatechange = function () {
		if (r.readyState != 4) {
			return;
		}
		// console.log(r.responseText);
		if (r.status == 200) {
			success && success(JSON.parse(r.responseText));
		}
		else {
			error && error(JSON.parse(r.responseText))
		}
	};
	r.send(JSON.stringify({
		"method": method || null,
		"url": url || null,
		"query": query || [],
		"post": post || []
	}));
};