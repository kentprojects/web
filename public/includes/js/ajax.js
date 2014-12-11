var API = {};

API.GET = function(url, query, success, error) {
	API._Request("GET", url, query, {}, success, error)
};

API.POST = function( url, data, success, error) {
	API._Request("POST",url, {}, data, success, error)
};

API.PUT = function(url, data, success, error) {
	API._Request("PUT", url, {}, data, success, error)
};

API.DELETE = function(url, query, success, error) {
	API._Request("DELETE", url, query, success, error)
};

API._Request = function(method, url, query, post, success, error) {
	var data = data || {},
		r = new XMLHttpRequest();
	r.open("POST", "/ajax.php"+url, true);
	r.onreadystatechange = function () {
		if (r.readyState != 4) return;
		// console.log(r, r.responseText);
		if ((r.status >= 200) && (r.status < 300))
		{
			success && success(JSON.parse(r.responseText));
		}
		else
		{
			error && error(JSON.parse(r.responseText))
		}
	};
	r.send(JSON.stringify(data));
};

// example usage:
// API.GET("/user/1", {}, function(user) {
//	  console.log(user.email);
// });